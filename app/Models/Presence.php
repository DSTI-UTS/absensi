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
                'in' => false,
                'out' => false,
            ],
            'Dosen DT' => [
                'in' => false,
                'out' => false,
            ],
            'Tenaga Kependidikan' => [
                'in' => "09:00",
                'out' => "16:00",
            ],
            'Security' => [
                'in' => "17:00",
                'out' => "06:00",
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
        // $thisWeek = request('thisweek');
        // if ($thisWeek) {
        //     $start = Carbon::now()->startOfWeek();
        //     $end = Carbon::now()->endOfWeek();
        // }
        // $thisMonth = request('thismonth');
        // if ($thisMonth) {
        //     $start = Carbon::now()->startOfMonth();
        //     $end = Carbon::now()->endOfMonth();
        // }
        // $period = self::calculatePeriod($start, $end);

        $query = HumanResource::leftJoin('presences', 'human_resources.id', '=', 'presences.sdm_id')
            ->whereIn('human_resources.id', User::getChildrenSdmId())
            ->where('human_resources.id', '!=', Auth::id())
            ->select(
                'human_resources.sdm_name',
                'human_resources.id',
                'human_resources.sdm_type',
                DB::raw('SUM(IFNULL(TIMESTAMPDIFF(HOUR, check_in_time, check_out_time),0)) as hours'),
                DB::raw('SUM(IFNULL(TIMESTAMPDIFF(MINUTE, check_in_time, check_out_time),0)) % 60 as minutes')
            )
            ->getDiffAttribute()
            ->when($start && $end, function ($query) use ($start, $end) {
                return $query->whereBetween('presences.check_in_time', [$start, $end]);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where('human_resources.sdm_name', 'like', "%$search%");
            })
            ->groupBy(
                'human_resources.sdm_name',
                'human_resources.id'
            );

        return $query->paginate();
    }

    public static function subPresenceAll()
    {
        return self::getPresences(User::justChildSDMId());
    }

    public static function getPresences($sdm_id)
    {
        $search = request('search');
        $start = request('start');
        $end = request('end');

        $query = Presence::join('human_resources', 'presences.sdm_id', 'human_resources.id')
            ->whereIn('presences.sdm_id', $sdm_id)
            ->select(
                'presences.id',
                'presences.sdm_id',
                'sdm_name',
                'sdm_type',
                'latitude_in',
                'longitude_in',
                'latitude_out',
                'longitude_out',
                DB::raw("DATE_FORMAT(presences.created_at, '%W, %d-%m-%Y') AS created_at"),
                DB::raw("DATE_FORMAT(check_in_time, '%W, %d-%m-%Y') AS check_in_date"),
                DB::raw("DATE_FORMAT(check_out_time, '%W, %d-%m-%Y') AS check_out_date"),
                DB::raw("DATE_FORMAT(check_in_time, '%H:%i') AS check_in_hour"),
                DB::raw("DATE_FORMAT(check_out_time, '%H:%i') AS check_out_hour"),
                DB::raw('SUM(IFNULL(TIMESTAMPDIFF(HOUR, check_in_time, check_out_time),0)) as hours'),
                DB::raw('SUM(IFNULL(TIMESTAMPDIFF(MINUTE, check_in_time, check_out_time),0)) % 60 as minutes')
            )
            ->groupBy(
                'presences.id',
                'presences.sdm_id',
                'sdm_name',
                'sdm_type',
                'latitude_in',
                'longitude_in',
                'latitude_out',
                'longitude_out',
                'check_in_date',
                'check_out_date',
                'check_in_hour',
                'check_out_hour'
            );
        if ($search) {
            $query->when($search, function ($query) use ($search) {
                return $query->where('sdm_name', 'like', "%$search%");
            });
        }

        if ($start && $end) {
            $query->when($start && $end, function ($query) use ($start, $end) {
                return $query->whereBetween('check_in_time', [$start, $end]);
            });
        }
        return $query->paginate();
    }

    public static function getPresenceHours($sdm_id)
    {
        $search = request('search');
        $start = request('start');
        $end = request('end');

        return HumanResource::join('presences', 'human_resources.id', '=', 'presences.sdm_id')
            ->where('human_resources.id', $sdm_id)
            ->select(
                'human_resources.sdm_name',
                'human_resources.id',
                DB::raw('SUM(IFNULL(TIMESTAMPDIFF(HOUR, check_in_time, check_out_time),0)) as hours'),
                DB::raw('SUM(IFNULL(TIMESTAMPDIFF(MINUTE, check_in_time, check_out_time),0)) % 60 as minutes')
            )
            ->getDiffAttribute()
            ->when($search, function ($query) use ($search) {
                $query->where('sdm_name', 'like', "%$search%");
            })
            ->when($start && $end, function ($query) use ($start, $end) {
                return $query->whereBetween('check_in_time', [$start, $end]);
            })
            ->groupBy(
                'human_resources.sdm_name',
                'human_resources.id'
            )
            ->orderByDesc('hours')
            ->get();
    }

    public static function dsdmByCivitas()
    {
        $search = request('search');
        $start = request('start');
        $end = request('end');

        return HumanResource::leftJoin('presences', 'human_resources.id', '=', 'presences.sdm_id')
            ->select(
                'human_resources.sdm_name',
                'human_resources.id',
                DB::raw('SUM(IFNULL(TIMESTAMPDIFF(HOUR, check_in_time, check_out_time),0)) as hours'),
                DB::raw('SUM(IFNULL(TIMESTAMPDIFF(MINUTE, check_in_time, check_out_time),0)) % 60 as minutes')
            )
            ->getDiffAttribute()
            ->when($search, function ($query) use ($search) {
                $query->where('sdm_name', 'like', "%$search%");
            })
            ->when($start && $end, function ($query) use ($start, $end) {
                return $query->whereBetween('check_in_time', [$start, $end]);
            })
            ->groupBy(
                'human_resources.sdm_name',
                'human_resources.id'
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
                'latitude_in',
                'longitude_in',
                'latitude_out',
                'longitude_out',
                DB::raw("DATE_FORMAT(check_in_time, '%W, %d-%m-%Y') AS check_in_date"),
                DB::raw("DATE_FORMAT(check_out_time, '%W, %d-%m-%Y') AS check_out_date"),
                DB::raw("DATE_FORMAT(check_in_time, '%H:%i') AS check_in_hour"),
                DB::raw("DATE_FORMAT(check_out_time, '%H:%i') AS check_out_hour"),
                DB::raw('SUM(IFNULL(TIMESTAMPDIFF(HOUR, check_in_time, check_out_time),0)) as hours'),
                DB::raw('SUM(IFNULL(TIMESTAMPDIFF(MINUTE, check_in_time, check_out_time),0)) % 60 as minutes')
            )
            ->groupBy('presences.id', 'presences.sdm_id', 'sdm_name', 'latitude_in', 'longitude_in', 'latitude_out', 'longitude_out', 'check_in_date', 'check_out_date', 'check_in_hour', 'check_out_hour');
        if ($search) {
            $query->when($search, function ($query) use ($search) {
                return $query->where('sdm_name', 'like', "%$search%");
            });
        }

        if ($start && $end) {
            $query->when($start && $end, function ($query) use ($start, $end) {
                return $query->whereBetween('check_in_time', [$start, $end]);
            });
        }
        return $query->paginate();
    }

    // API
    public static function myPresenceAPI($sdm_id)
    {
        return self::where('sdm_id', $sdm_id)
            ->select(
                'id',
                'sdm_id',
                'latitude_in',
                'longitude_in',
                'latitude_out',
                'longitude_out',
                DB::raw("DATE_FORMAT(check_in_time, '%W, %d-%m-%Y') AS check_in_date"),
                DB::raw("DATE_FORMAT(check_out_time, '%W, %d-%m-%Y') AS check_out_date"),
                DB::raw("DATE_FORMAT(check_in_time, '%H:%i') AS check_in_hour"),
                DB::raw("DATE_FORMAT(check_out_time, '%H:%i') AS check_out_hour"),
                DB::raw('SUM(IFNULL(TIMESTAMPDIFF(HOUR, check_in_time, check_out_time),0)) as hours'),
                DB::raw('SUM(IFNULL(TIMESTAMPDIFF(MINUTE, check_in_time, check_out_time),0)) % 60 as minutes')
            )
            ->groupBy('id', 'sdm_id', 'latitude_in', 'longitude_in', 'latitude_out', 'longitude_out', 'check_in_date', 'check_out_date', 'check_in_hour', 'check_out_hour')
            ->get();
    }
}
