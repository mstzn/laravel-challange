<?php

namespace App\Models;

use App\Http\Traits\SubscriptionTrait;
use App\Http\Traits\SuspendableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Company extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SubscriptionTrait, SuspendableTrait;


    protected $fillable = [
        'name',
        'last_name',
        'site_url',
        'company_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function packages(): HasMany
    {
        return $this->hasMany(CompanyPackage::class);
    }
}
