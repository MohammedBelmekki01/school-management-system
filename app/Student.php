<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;
use App\Http\Helpers\AppHelper;
use Illuminate\Support\Arr;


class Student extends Model
{
    use SoftDeletes;
    use UserstampsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'nick_name',
        'dob',
        'gender',
        'religion',
        'blood_group',
        'nationality',
        'photo',
        'email',
        'phone_no',
        'extra_activity',
        'note',
        'father_name',
        'father_phone_no',
        'mother_name',
        'mother_phone_no',
        'guardian',
        'guardian_phone_no',
        'present_address',
        'permanent_address',
        'sms_receive_no',
        'siblings',
        'status',
    ];

    /**
     * Get the registrations for this student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registration()
    {
        return $this->hasMany('App\Registration', 'student_id');
    }

    /**
     * Get the user account associated with this student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getGenderAttribute($value)
    {
        return Arr::get(AppHelper::GENDER, $value);
    }

    public function getReligionAttribute($value)
    {
        return Arr::get(AppHelper::RELIGION, $value);
    }

    public function getBloodGroupAttribute($value)
    {
        if ($value) {
            return Arr::get(AppHelper::BLOOD_GROUP, $value);
        }
        return "";
    }

    /**
     * Get student's full name with guardian info.
     *
     * @return string
     */
    public function getFullInfoAttribute()
    {
        $info = $this->name;
        if ($this->father_name) {
            $info .= ' (Father: ' . $this->father_name . ')';
        }
        return $info;
    }

    /**
     * Scope a query to only include active students.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', AppHelper::ACTIVE);
    }

    /**
     * Scope a query to filter students by gender.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $gender
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGender($query, $gender)
    {
        if ($gender) {
            return $query->where('gender', $gender);
        }
        return $query;
    }

    /**
     * Check if the student has a phone number registered.
     *
     * @return bool
     */
    public function hasContactInfo()
    {
        return !empty($this->phone_no) || !empty($this->email);
    }
}
