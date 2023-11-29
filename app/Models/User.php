<?php

namespace App\Models;

use App\Models\Bookings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Validator;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'phone',
        'blocked',
        'address',
        'picture',
        'last_login',
        'device_type',
        'provider',
        'provider_id',
        'api_token',
        'language',
        'forgot_token',
        'listing_credits'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $rules = [

//        'email' => 'required'

    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function validateUserCreation($request)
    {
        $__createUserRules = array(

            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits_between:1,20|unique:users,phone',
            'password' => 'required|min:8',

        );

        $result = Validator::make($request, $__createUserRules);
        if ($result->passes()) {
            return true;
        }

        $this->errors = $result->messages();
        return false;
    }

    public $__regRules = array(

        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'phone' => 'required|numeric|digits_between:1,20|unique:users,phone',
        'role' => 'required',
    );

    public function validateRegisterRequest($request)
    {
        $result = Validator::make($request, $this->__regRules);
        if ($result->passes()) {
            return true;
        }

        $this->errors = $result->messages();
        return false;
    }

    public $__loginRules = array(

        'email' => 'required',
        'password' => 'required',
    );

    public $__socialLoginRules = array(
        'provider' => 'required|in:facebook,google',
        'provider_id' => 'required'
    );




    public function validateLoginRequest($request)
    {
        $result = Validator::make($request, $this->__loginRules);
        if ($result->passes()) {
            return true;
        }

        $this->errors = $result->messages();
        return false;
    }

    public function validateSocialLoginRequest($request)
    {
        $result = Validator::make($request, $this->__socialLoginRules);
        if ($result->passes()) {
            return true;
        }

        $this->errors = $result->messages();
        return false;
    }

    public $__emailRules = array(

        'password' => 'required|confirmed',
    );

    public function passwordResetEmail($request)
    {
        $result = Validator::make($request, $this->__emailRules);
        if ($result->passes()) {
            return true;
        }

        $this->errors = $result->messages()->get('*');
        return false;
    }

    public $__resetType = array(

        'identifier' => 'required',
        'type' => 'required',
    );
    public function resetType($request)
    {
        $result = Validator::make($request, $this->__resetType);
        if ($result->passes()) {
            return true;
        }

        $this->errors = $result->messages();
        return false;
    }

    public function validateOTP($request)
    {
        $__otp = array(
            'phone' => 'required',
            'otp' => 'required',
            'user_id' => 'required',
        );
        $result = Validator::make($request, $__otp);
        if ($result->passes()) {
            return true;
        }

        $this->errors = $result->messages();
        return false;
    }

    public function validatePasswordOTP($request)
    {
        $__password = array(

            'token' => 'required',
            'password' => 'required',
        );
        $result = Validator::make($request, $__password);
        if ($result->passes()) {
            return true;
        }

        $this->errors = $result->messages();
        return false;
    }

    public function resorts()
    {
        return $this->belongsToMany(Resorts::class);
    }

    public function hasManyReviews()
    {
        return $this->hasMany('App\Models\Reviews', 'userID', 'id');
    }

    public function hasManyFailedLogins()
    {
        return $this->hasMany('App\Models\FailedLogins', 'user_id', 'id');
    }

    public function bookings()
    {
        return $this->hasMany(Bookings::class, 'userID');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function listing()
    {
        return $this->hasMany(Listing::class);
    }

    public function favorite()
    {
        return $this->belongsToMany(Listing::class);
    }

}
