<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

class IClass extends Model
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
        'numeric_value',
        'order',
        'group',
        'duration',
        'have_selective_subject',
        'max_selective_subject',
        'have_elective_subject',
        'is_open_for_admission',
        'status',
        'note'
    ];


    /**
     * Get sections belonging to this class.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function section()
    {
        return $this->hasMany('App\Section', 'class_id');
    }

    /**
     * Get student registrations for this class.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function student()
    {
        return $this->hasMany('App\Registration', 'class_id');
    }

    /**
     * Get attendance records for this class.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendance()
    {
        return $this->hasMany('App\StudentAttendance', 'class_id');
    }

    /**
     * Get subjects for this class.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjects()
    {
        return $this->hasMany('App\Subject', 'class_id');
    }

    /**
     * Get exams for this class.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exams()
    {
        return $this->hasMany('App\Exam', 'class_id');
    }

    /**
     * Scope a query to only include active classes.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }

    /**
     * Scope a query to order classes by their order field.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Check if the class is open for admission.
     *
     * @return bool
     */
    public function isOpenForAdmission()
    {
        return $this->is_open_for_admission == 1;
    }

    /**
     * Get the total number of registered students.
     *
     * @return int
     */
    public function getStudentCountAttribute()
    {
        return $this->student()->count();
    }
}
