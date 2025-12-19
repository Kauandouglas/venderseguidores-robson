<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'domain',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function apiProviders()
    {
        return $this->hasMany(ApiProvider::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function systemSettings()
    {
        return $this->hasMany(SystemSetting::class);
    }

    public function systemSetting()
    {
        return $this->hasOne(SystemSetting::class);
    }

    public function configTemplate()
    {
        return $this->hasOne(ConfigTemplate::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function userAlertNotify()
    {
        return $this->hasOne(UserAlertNotify::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function planPurchase()
    {
        return $this->hasOne(PlanPurchase::class);
    }

    public function domain()
    {
        return $this->hasOne(Domain::class);
    }

    public function configPreviewStore()
    {
        return $this->hasOne(ConfigPreviewStore::class);
    }

    public function conversionTag()
    {
        return $this->hasOne(ConversionTag::class);
    }

    public function serviceDescounts()
    {
        return $this->hasMany(ServiceDescount::class);
    }

    public function userNotifies()
    {
        return $this->hasMany(UserNotify::class);
    }

    public function whatsappInstance()
    {
        return $this->hasOne(WhatsappInstance::class);
    }

    public function discountCoupons()
    {
        return $this->hasMany(DiscountCoupon::class);
    }

    public function setDomainAttribute($value)
    {
        $this->attributes['domain'] = Str::slug($value);
    }

    public function setPasswordAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        $this->attributes['password'] = Hash::make($value);
    }

    public function setImage($value)
    {
        if (!is_null($value)) {
            Storage::delete($this->image);

            $upload = $value->store('users/' . $this->id);
            $this->attributes['image'] = $upload;
        }
    }

    public function getUrlImageAttribute()
    {
        if (!empty($this->image) && File::exists('../public/storage/' . $this->image)) {
            return route('imagecache', [
                'template' => 'person',
                'filename' => $this->image,
                'w' => 50,
                'h' => 50
            ]);
        }

        return asset('panel_assets/images/default-user.png');
    }

    public function scopeUsers($query)
    {
        $query->where('role', 2);
    }
}
