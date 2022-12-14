<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = ['sdm_id', 'check_in_time', 'check_out_time'];

    public function human_resource()
    {
        return $this->belongsTo(HumanResource::class);
    }

    // public static function listSubDivision($type = false)
    // {
    //     $children = Structure::childrens(User::child_id());
    //     if ($type) {
    //         $children = collect($children)->filter(function ($child) use ($type) {
    //             return $child['type'] === $type;
    //         });
    //     }
    //     $ids = collect($children)->map(function ($item) {
    //         return $item['id'];
    //     })->toArray();
    //     return $ids;
    // }

    // public static function lecturer()
    // {
    //     $ids = self::listSubDivision('dosen');
    //     $results = HumanResource::whereIn('structure_id', $ids)
    //         ->with('structure:id,role,type')
    //         ->get();
    //     return $results;
    // }

    // public static function presence()
    // {
    //     $ids = self::listSubDivision();
    //     $results = HumanResource::whereIn('structure_id', $ids)
    //         ->with('structure:id,role,type')
    //         ->get();
    //     return $results;
    // }

    // public static function getDetail()
    // {
    //     // $results = HumanResource::join('structures', 'human_resources.sdm_id', 'id')
    //     // $results = Subject::select(
    //     //     'subjects.id',
    //     //     'subject',
    //     //     'sks',
    //     //     'number_of_meetings',
    //     //     'study_program_id',
    //     //     'sdm_id',
    //     //     DB::raw('ROUND((SUM(CASE WHEN meetings.file_start IS NOT NULL AND meetings.file_end IS NOT NULL THEN 1 ELSE 0 END) / SUM(number_of_meetings)) * SUM(sks), 2) AS value_sks'),
    //     //     DB::raw('COUNT(meetings.file_start) AS meetings_completed'),
    //     //     DB::raw('COUNT(*) - COUNT(meetings.file_start) AS meetings_pending'),
    //     //     DB::raw('SUM(TIMESTAMPDIFF(MINUTE, meetings.meeting_start, meetings.meeting_end)) AS meeting_duration')
    //     // )
    //     //     ->join('meetings', 'subjects.id', 'meetings.subject_id')
    //     //     ->with(['study_program:id,study_program', 'human_resource' => function ($query) {
    //     //         $query->select('id', 'sdm_name', 'structure_id');
    //     //         $query->with('structure:id,role');
    //     //     }])
    //     //     ->whereIn('subjects.sdm_id', function ($query) use ($ids) {
    //     //         $query->select('id')
    //     //             ->from('human_resources')
    //     //             ->whereIn('structure_id', $ids);
    //     //     })
    //     //     ->groupBy(
    //     //         'subjects.id',
    //     //         'subject',
    //     //         'sks',
    //     //         'number_of_meetings',
    //     //         'study_program_id',
    //     //         'sdm_id'
    //     //     )
    //     //     ->paginate();
    // }
}