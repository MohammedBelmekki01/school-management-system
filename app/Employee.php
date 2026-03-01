<?php

namespace App;

use App\Http\Helpers\AppHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;
use Illuminate\Support\Arr;

/**
 * Employee Model
 *
 * Represents a staff member (teacher, accountant, librarian, etc.)
 * in the school management system.
 *
 * @property int         $id
 * @property int         $user_id
 * @property int         $role_id
 * @property string      $id_card
 * @property string      $name
 * @property int         $designation
 * @property string      $qualification
 * @property string      $dob
 * @property int         $gender
 * @property int         $religion
 * @property string      $email
 * @property string      $phone_no
 * @property string      $address
 * @property Carbon      $joining_date
 * @property Carbon|null $leave_date
 * @property string      $photo
 * @property string      $signature
 * @property int         $shift
 * @property string      $duty_start
 * @property string      $duty_end
 * @property int         $status
 * @property int         $order
 *
 * @author Mohammed Belmekki
 */
class Employee extends Model
{
    use SoftDeletes;
    use UserstampsTrait;

    protected $dates = ['joining_date','leave_date'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'role_id',
        'id_card',
        'name',
        'designation',
        'qualification',
        'dob',
        'gender',
        'religion',
        'email',
        'phone_no',
        'address',
        'joining_date',
        'leave_date',
        'photo',
        'signature',
        'shift',
        'duty_start',
        'duty_end',
        'status',
        'order'
    ];

    /**
     * Get the user account associated with this employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get the human-readable gender attribute.
     */
    public function getGenderAttribute($value)
    {
        return Arr::get(AppHelper::GENDER, $value);
    }

    /**
     * Get the human-readable shift attribute.
     */
    public function getShiftAttribute($value)
    {
        return Arr::get(AppHelper::EMP_SHIFTS, $value);
    }

    /**
     * Get the human-readable designation attribute.
     */
    public function getDesignationAttribute($value)
    {
        return Arr::get(AppHelper::EMPLOYEE_DESIGNATION_TYPES, $value);
    }

    /**
     * Set joining date from d/m/Y format to Y-m-d.
     */
    public function setJoiningDateAttribute($value)
    {
        $this->attributes['joining_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    /**
     * Set leave date from d/m/Y format to Y-m-d, or null if empty.
     */
    public function setLeaveDateAttribute($value)
    {
        if(strlen($value)) {
            $this->attributes['leave_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }
        else{
            $this->attributes['leave_date'] = null;
        }
    }

    /**
     * Set duty start time from 12h format to 24h format.
     */
    public function setDutyStartAttribute($value)
    {
        if(strlen($value)){
            $this->attributes['duty_start'] = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');
        }
    }

    /**
     * Get duty start as Carbon instance.
     */
    public function getDutyStartAttribute($value)
    {
        if(!strlen($value)){
            return null;
        }

        return Carbon::parse($value);
    }

    /**
     * Set duty end time from 12h format to 24h format.
     */
    public function setDutyEndAttribute($value)
    {
        if(strlen($value)){
            $this->attributes['duty_end'] = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');
        }
    }

    /**
     * Get duty end as Carbon instance.
     */
    public function getDutyEndAttribute($value)
    {
        if(!strlen($value)){
            return null;
        }
        return Carbon::parse($value);
    }

    /**
     * Get the human-readable religion attribute.
     */
    public function getReligionAttribute($value)
    {
        return Arr::get(AppHelper::RELIGION, $value);
    }

    /**
     * Get the classes taught by this employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function class()
    {
        return $this->hasMany('App\IClass', 'teacher_id');
    }

    /**
     * Get the sections managed by this employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function section()
    {
        return $this->hasMany('App\Section', 'teacher_id');
    }

    /**
     * Get the role assigned to this employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Role', 'role_id');
    }

    /**
     * Get the attendance records for this employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendance()
    {
        return $this->hasMany('App\EmployeeAttendance', 'employee_id');
    }

    /**
     * Scope a query to only include active employees.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', AppHelper::ACTIVE);
    }

    /**
     * Scope a query to filter by designation.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $designation
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDesignation($query, $designation)
    {
        if ($designation) {
            return $query->where('designation', $designation);
        }
        return $query;
    }

    /**
     * Scope a query to only include teachers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTeachers($query)
    {
        return $query->where('role_id', AppHelper::USER_TEACHER);
    }

    /**
     * Check if the employee is currently active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status == AppHelper::ACTIVE;
    }

    /**
     * Get the employee's years of service.
     *
     * @return int
     */
    public function getYearsOfServiceAttribute()
    {
        if (!$this->joining_date) {
            return 0;
        }

        $endDate = $this->leave_date ?? Carbon::now();
        return $this->joining_date->diffInYears($endDate);
    }
}
