<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use App\Permissions\HasPermissionsTrait;
use App\Http\Helpers\AppHelper;

/**
 * User Model
 *
 * Represents an authenticated user in the school management system.
 * Users can have roles such as Admin, Teacher, Student, or Parent.
 *
 * @property int    $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $phone_no
 * @property string $password
 * @property int    $status
 * @property int    $force_logout
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use UserstampsTrait;
    use HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'phone_no', 'password', 'status', 'force_logout'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status'       => 'integer',
        'force_logout' => 'integer',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the employee record associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function employee()
    {
        return $this->hasOne('App\Employee');
    }

    /**
     * Get the student record associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function student()
    {
        return $this->hasOne('App\Student');
    }

    /**
     * Get the role assigned to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role()
    {
        return $this->hasOne('App\UserRole');
    }

    /**
     * Get the teacher (employee) record associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function teacher()
    {
        return $this->hasOne('App\Employee');
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', AppHelper::ACTIVE);
    }

    /**
     * Scope a query to only include inactive users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('status', AppHelper::INACTIVE);
    }

    /**
     * Check if the user is currently active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status == AppHelper::ACTIVE;
    }

    /**
     * Check if the user has a specific role type.
     *
     * @param  int $roleType
     * @return bool
     */
    public function isRoleType($roleType)
    {
        return $this->role && $this->role->role_id == $roleType;
    }

    /**
     * Check if the user is a teacher.
     *
     * @return bool
     */
    public function isTeacher()
    {
        return $this->isRoleType(AppHelper::USER_TEACHER);
    }

    /**
     * Check if the user is a student.
     *
     * @return bool
     */
    public function isStudent()
    {
        return $this->isRoleType(AppHelper::USER_STUDENT);
    }

    /**
     * Get the user's display name with role.
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return $this->name . ' (' . ($this->username ?? 'N/A') . ')';
    }
}
