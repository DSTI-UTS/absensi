<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = ["subject_id", "meeting_name", "datetime_local", "meeting_start", "meeting_end", "file_start", "file_end"];

    public $timestamps = false;

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function subjectClass()
    {
        return $this->belongsTo(SubjectClass::class);
    }

    public static function bulkCreateMeetings($subject_id, $numberOfMeetings)
    {
        $numbers = range(1, $numberOfMeetings);
        $newNumbers = array_map(function ($number) use ($subject_id) {
            return [
                "subject_id" => $subject_id,
                "meeting_name" => "Pertemuan ke " . $number,
                "datetime_local" => null
            ];
        }, $numbers);

        self::insert($newNumbers);
    }
}
