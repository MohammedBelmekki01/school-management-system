<?php

namespace App;

use App\Http\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

/**
 * Exam Model
 *
 * Represents an examination entity in the school system.
 * Exams are associated with classes and contain marks and results.
 *
 * @property int    $id
 * @property int    $class_id
 * @property string $name
 * @property int    $elective_subject_point_addition
 * @property string $marks_distribution_types
 * @property int    $status
 * @property int    $open_for_marks_entry
 *
 * @author Mohammed Belmekki
 */
class Exam extends Model
{
    use SoftDeletes;
    use UserstampsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_id',
        'name',
        'elective_subject_point_addition',
        'marks_distribution_types',
        'status',
        'open_for_marks_entry'
    ];


    /**
     * Get the class this exam belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function class()
    {
        return $this->belongsTo('App\IClass', 'class_id');
    }

    /**
     * Scope to filter exams by class.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  int $classId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIclass($query, $classId)
    {
        if($classId){
            return $query->where('class_id', $classId);
        }

        return $query;
    }

    /**
     * Get all marks associated with this exam.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function marks()
    {
        return $this->hasMany('App\Mark', 'exam_id');
    }

    /**
     * Get all results associated with this exam.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function result()
    {
        return $this->hasMany('App\Result', 'exam_id');
    }

    /**
     * Scope a query to only include active exams.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', AppHelper::ACTIVE);
    }

    /**
     * Check if marks entry is currently open for this exam.
     *
     * @return bool
     */
    public function isOpenForMarksEntry()
    {
        return $this->open_for_marks_entry == 1;
    }

    /**
     * Get the decoded marks distribution types.
     *
     * @return array
     */
    public function getDistributionTypesAttribute()
    {
        if (empty($this->marks_distribution_types)) {
            return [];
        }

        $types = json_decode($this->marks_distribution_types, true);
        if (!is_array($types)) {
            return explode(',', $this->marks_distribution_types);
        }

        return $types;
    }
}
