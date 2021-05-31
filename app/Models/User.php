<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'pesel_number',
        'email',
        'street',
        'street_number',
        'city',
        'voivodeship_id',
        'zip',
        'password',
        'locale',
        'birth_date',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Using Laravel accessors to make them visible in Voyager.
     * @var string[]
     */
    public $additional_attributes = ['full_name', 'full_address'];
    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's address.
     *
     * @return string
     */
    public function getFullAddressAttribute()
    {
        return "{$this->street} {$this->street_number}; {$this->zip} {$this->city}";
    }

    /**
     * The voivodeship that belongs to the user
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function voivodeship()
    {
        return $this->hasOne(Voivodeship::class);
    }

    /**
     * User can have many Client Bank Products
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clientBankProducts()
    {
        return $this->hasMany(ClientBankProduct::class);
    }

}
