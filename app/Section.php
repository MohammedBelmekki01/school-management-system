<?php

namespace App;

use App\Http\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

/**
 * Section Model
 *
 * Represents a section (division) within a class.
 * Each section belongs to a class and is managed by a teacher.
 *
 * @property int    $id
 * @property string $name
 * @property int    $capacity
 * @property int    $class_id
 * @property int    $teacher_id
 * @property string $note
 * @property int    $status
 *
 * @author Mohammed Belmekki
 */
class Section extends Model
{
    use SoftDeletes;
    use UserstampsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'capacity',
        'class_id',
        'teacher_id',
        'note',
        'status',
    ];

    /**
     * Get the teacher assigned to this section.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo('App\Employee', 'teacher_id');
    }

    /**
     * Get the class this section belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function class()
    {
        return $this->belongsTo('App\IClass', 'class_id');
    }

    /**
     * Get marks for this section.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function marks()
    {
        return $this->hasMany('App\Mark', 'section_id');
    }

    /**
     * Get student registrations for this section.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function student()
    {
        return $this->hasMany('App\Registration', 'section_id');
    }

    /**
     * Scope a query to only include active sections.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', AppHelper::ACTIVE);
    }

    /**
     * Scope a query to filter sections by class.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  int $classId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfClass($query, $classId)
    {
        if ($classId) {
            return $query->where('class_id', $classId);
        }
        return $query;
    }

    /**
     * Get the number of enrolled students in this section.
     *
     * @return int
     */
    public function getEnrolledCountAttribute()
    {
        return $this->student()->count();
    }

    /**
     * Check if the section has available capacity.
     *
     * @return bool
     */
    public function hasAvailableCapacity()
    {
        return $this->enrolled_count < ($this->capacity ?? PHP_INT_MAX);
    }

    /**
     * Get the section display name with class info.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        $className = $this->class ? $this->class->name : 'Unknown';
        return $className . ' - Section ' . $this->name;
    }
}
