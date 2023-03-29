<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Termwind\Components\Raw;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'sdm_id',
        'check_in_time',
        'latitude_in',
        'longitude_in',
        'check_out_time',
        'latitude_out',
        'longitude_out',
        'permission'
    ];
    static $latitude = 80;
    static $longitude = 80;
    static $jenisIzin = [
        'Tidak Masuk',
        'Izin Berkegiatan Diluar 1/2 Hari',
        'Izin Berkegiatan Diluar 1 Hari',
        'Izin Sakit',
        'Terkendala Absen Masuk',
        'Terkendala Absen Pulang',
    ];
    static $workingTime = [
        'Dosen' => 18,
        'Dosen DT' => 30,
        'Tenaga Kependidikan' => 35,
        'Security' => 55,
        'Customer Service' => 55,
    ];

    public static function workHour($sdm_type)
    {
        $workHour = [
            'Dosen' => [
                'in' => "07:00",
                'out' => "19:00",
            ],
            'Dosen DT' => [
                'in' => "07:00",
                'out' => "19:00",
            ],
            'Tenaga Kependidikan' => [
                'in' => "09:00",
                'out' => "16:00",
            ],
            'Security 1' => [
                'in' => "17:00",
                'out' => "06:00",
            ],
            'Security 2' => [
                'in' => "06:00",
                'out' => "17:00",
            ],
            'Customer Service' => [
                'in' => "07:00",
                'out' => "17:00",
            ],
        ];
        if (!array_key_exists(Str::title($sdm_type), $workHour))  throw new Exception('Invalid sdm_type' . $sdm_type);
        return $workHour[Str::title($sdm_type)];
    }

    public static function isLate($sdm_type)
    {
        return Carbon::now()->format('H:i') > Presence::workHour($sdm_type)['in'];
    }

    public function human_resource()
    {
        return $this->belongsTo(HumanResource::class, 'sdm_id', 'id');
    }

    public function attachment()
    {
        return $this->hasOne(PresenceAttachment::class, 'presence_id');
    }

    public function processWeek(Request $request)
    {
        $start_week = $request->input('start');
        $end_week = $request->input('end');
        //validate input
        $validatedData = $request->validate([
            'start' => 'required|date_format:Y-W|before_or_equal:end',
            'end' => 'required|date_format:Y-W|after_or_equal:start',
        ]);

        // Mengubah input menjadi tanggal
        $start_date = Carbon::parse($start_week)->startOfWeek();
        $end_date = Carbon::parse($end_week)->endOfWeek();

        // Menampilkan hasil
        echo "Tanggal awal minggu: " . $start_date->toDateString() . "<br>";
        echo "Tanggal akhir minggu: " . $end_date->toDateString();
    }

    public static function expectedWorkingHours($sdm_type, $period)
    {
        $working_hours_per_week = $sdm_type ? self::$workingTime[$sdm_type] : 0;
        return $working_hours_per_week * $period * 60;
    }

    public static function calculatePeriod($start_date, $end_date)
    {
        $start = Carbon::parse($start_date);
        $end = Carbon::parse($end_date);
        $days = $start->diffInDays($end);
        return $days / 7;
    }

    public static function subPresenceByCivitas()
    {
        $end = request('end');
        $start = request('start');
        $search = request('search');
        $isSearchROle = Str::contains($search, ':');
        $role = $isSearchROle ? str_replace(':', '', $search) : '';

        $query = HumanResource::join('presences', 'human_resources.id', '=', 'presences.sdm_id')
            ->where('permission', 1)
            // ->where('sdm_type', 'Dosen')
            ->whereIn('human_resources.id', array_merge(User::getChildrenSdmId()->toArray(), collect(Auth::id())->toArray()))
            ->whereNotNull('check_in_time')
            ->whereNotNull('check_out_time')
            ->whereColumn('check_out_time', '>', 'check_in_time')
            ->select(
                'human_resources.sdm_name',
                'human_resources.id',
                'sdm_type',
                DB::raw(
                    'TIME_FORMAT(
                        GREATEST(0, SEC_TO_TIME(SUM(
                            CASE  
                                WHEN sdm_type = "Tenaga Kependidikan" THEN
                                    TIMESTAMPDIFF(
                                        SECOND, 
                                        GREATEST(check_in_time, DATE_ADD(DATE(check_in_time), INTERVAL 9 HOUR)),
                                        LEAST(check_out_time, DATE_ADD(DATE(check_out_time), INTERVAL 16 HOUR))
                                    )
                                WHEN sdm_type = "dosen" THEN
                                    TIMESTAMPDIFF(
                                        SECOND, 
                                        GREATEST(check_in_time, DATE_ADD(DATE(check_in_time), INTERVAL 7 HOUR)),
                                        LEAST(check_out_time, DATE_ADD(DATE(check_out_time), INTERVAL 19 HOUR))
                                    )
                                ELSE 0
                            END
                        ))), "%H:%i:%s"
                    ) as effective_hours'
                )
            )
            ->when($start && $end, function ($query) use ($start, $end) {
                return $query->whereBetween('presences.check_in_time', [$start, $end]);
            })
            ->when($search && !$isSearchROle, function ($query) use ($search) {
                return $query->where('human_resources.sdm_name', 'like', "%$search%");
            })
            ->when($isSearchROle, function ($query) use ($role) {
                return $query->where('human_resources.sdm_type', 'like', "%$role%");
            })
            ->groupBy(
                'human_resources.id',
                'sdm_name',
                'sdm_type',
            );

        return $query->paginate();
    }

    public static function subPresenceAll()
    {
        return self::getPresences(User::justChildSDMId());
    }

    public static function myPresence($sdm_id)
    {
        $search = request('search');
        $start = request('start');
        $end = request('end');
        $isSearchROle = Str::contains($search, ':');
        $role = $isSearchROle ? str_replace(':', '', $search) : '';

        $query = Presence::join('human_resources', 'presences.sdm_id', 'human_resources.id')
            ->whereIn('presences.sdm_id', $sdm_id)
            ->select(
                'presences.id',
                'presences.sdm_id',
                'sdm_name',
                'sdm_type',
                DB::raw("DATE_FORMAT(check_in_time, '%W, %d-%m-%Y') AS check_in_date"),
                DB::raw("DATE_FORMAT(check_out_time, '%W, %d-%m-%Y') AS check_out_date"),
                DB::raw("DATE_FORMAT(check_in_time, '%H:%i:%s') AS check_in_hour"),
                DB::raw("DATE_FORMAT(check_out_time, '%H:%i:%s') AS check_out_hour"),
            )
            ->workHoursGroup()
            ->when($start && $end, function ($query) use ($start, $end) {
                return $query->whereBetween('presences.check_in_time', [$start, $end]);
            })
            ->when($search && !$isSearchROle, function ($query) use ($search) {
                return $query->where('human_resources.sdm_name', 'like', "%$search%");
            })
            ->when($isSearchROle, function ($query) use ($role) {
                return $query->where('human_resources.sdm_type', 'like', "%$role%");
            })
            ->groupBy(
                'presences.id',
                'presences.sdm_id',
                'presences.check_in_time',
                'presences.check_out_time',
                'sdm_name',
                'sdm_type'
            );

        return $query->paginate();
    }

    public static function getPresences($sdm_id)
    {
        $search = request('search');
        $start = request('start');
        $end = request('end');
        $isSearchROle = Str::contains($search, ':');
        $role = $isSearchROle ? str_replace(':', '', $search) : '';

        $query = Presence::join('human_resources', 'presences.sdm_id', 'human_resources.id')
            ->whereIn('presences.sdm_id', $sdm_id)
            ->select(
                'presences.id',
                'presences.sdm_id',
                'sdm_name',
                'sdm_type',
                DB::raw("DATE_FORMAT(check_in_time, '%W, %d-%m-%Y') AS check_in_date"),
                DB::raw("DATE_FORMAT(check_out_time, '%W, %d-%m-%Y') AS check_out_date"),
                DB::raw("DATE_FORMAT(check_in_time, '%H:%i:%s') AS check_in_hour"),
                DB::raw("DATE_FORMAT(check_out_time, '%H:%i:%s') AS check_out_hour"),
            )
            ->workHoursGroup()
            ->when($start && $end, function ($query) use ($start, $end) {
                return $query->whereBetween('presences.check_in_time', [$start, $end]);
            })
            ->when($search && !$isSearchROle, function ($query) use ($search) {
                return $query->where('human_resources.sdm_name', 'like', "%$search%");
            })
            ->when($isSearchROle, function ($query) use ($role) {
                return $query->where('human_resources.sdm_type', 'like', "%$role%");
            })
            ->groupBy(
                'presences.id',
                'presences.sdm_id',
                'presences.check_in_time',
                'presences.check_out_time',
                'sdm_name',
                'sdm_type'
            );

        return $query->paginate();
    }

    public static function getPresenceHours($sdm_id)
    {
        $search = request('search');
        $start = request('start');
        $end = request('end');

        return HumanResource::join('presences', 'human_resources.id', '=', 'presences.sdm_id')
            ->where('human_resources.id', $sdm_id)
            ->where('presences.permission', 1)
            ->select(
                'human_resources.sdm_name',
                'human_resources.id'
            )
            ->workHours()
            ->when($search, function ($query) use ($search) {
                $query->where('sdm_name', 'like', "%$search%");
            })
            ->when($start && $end, function ($query) use ($start, $end) {
                return $query->whereBetween('check_in_time', [$start, $end]);
            })
            ->groupBy(
                'human_resources.sdm_name',
                'human_resources.id',
                'human_resources.sdm_type'
            )
            ->first();
    }

    public static function dsdmByCivitas()
    {
        $search = request('search');
        $start = request('start');
        $end = request('end');

        return HumanResource::join('presences', 'human_resources.id', '=', 'presences.sdm_id')
            ->select(
                'human_resources.sdm_name',
                'human_resources.id'
            )
            ->workHours()
            ->when($search, function ($query) use ($search) {
                $query->where('sdm_name', 'like', "%$search%");
            })
            ->when($start && $end, function ($query) use ($start, $end) {
                return $query->whereBetween('check_in_time', [$start, $end]);
            })
            ->groupBy(
                'human_resources.sdm_name',
                'human_resources.id',
                'presences.check_in_time',
                'presences.check_out_time',
            )
            ->orderByDesc('hours')
            ->paginate();
    }

    public static function dsdmAllCivitas()
    {
        $search = request('search');
        $start = request('start');
        $end = request('end');
        $query = Presence::join('human_resources', 'presences.sdm_id', 'human_resources.id')
            ->select(
                'presences.id',
                'presences.sdm_id',
                'sdm_name',
                DB::raw("DATE_FORMAT(check_in_time, '%W, %d-%m-%Y') AS check_in_date"),
                DB::raw("DATE_FORMAT(check_out_time, '%W, %d-%m-%Y') AS check_out_date"),
                DB::raw("DATE_FORMAT(check_in_time, '%H:%i') AS check_in_hour"),
                DB::raw("DATE_FORMAT(check_out_time, '%H:%i') AS check_out_hour")
            )
            ->workHours()
            ->when($search, function ($query) use ($search) {
                return $query->where('sdm_name', 'like', "%$search%");
            })
            ->when($start && $end, function ($query) use ($start, $end) {
                return $query->whereBetween('check_in_time', [$start, $end]);
            })
            ->groupBy(
                'presences.id',
                'presences.sdm_id',
                'presences.check_in_time',
                'presences.check_out_time',
                'sdm_name',
            );

        return $query->paginate();
    }

    // API
    public static function myPresenceAPI($sdm_id)
    {
        return self::where('sdm_id', $sdm_id)
            ->select(
                'id',
                'sdm_id',
                DB::raw("DATE_FORMAT(check_in_time, '%W, %d-%m-%Y') AS check_in_date"),
                DB::raw("DATE_FORMAT(check_out_time, '%W, %d-%m-%Y') AS check_out_date"),
                DB::raw("DATE_FORMAT(check_in_time, '%H:%i') AS check_in_hour"),
                DB::raw("DATE_FORMAT(check_out_time, '%H:%i') AS check_out_hour")
            )
            ->workHours()
            ->groupBy(
                'id',
                'sdm_id',
                'check_in_time',
                'check_out_time'
            )
            ->get();
    }
}
