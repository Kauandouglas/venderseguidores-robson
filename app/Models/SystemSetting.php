<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_id',
        'title',
        'description',
        'keyword',
        'primary_color',
        'secondary_color',
        'terms',
        'code',
        'phone',
        'email',
        'notify_popup_title',
        'notify_popup_description',
        'notify_popup_url',
        'notify_popup_button_color',
        'notify_popup_button_name'
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function setLogo($value)
    {
        if (!is_null($value)) {
            Storage::delete($this->logo);

            $upload = $value->store('systemSettings/' . $this->id . '/logo');
            $this->attributes['logo'] = $upload;
        }
    }

    public function setFavicon($value)
    {
        if (!is_null($value)) {
            Storage::delete($this->favicon);

            $upload = $value->store('systemSettings/' . $this->id . '/favicon');
            $this->attributes['favicon'] = $upload;
        }
    }

    public function getUrlLogoAttribute()
    {
        if (!empty($this->logo) && File::exists('../public/storage/' . $this->logo)) {
            return route('imagecache', [
                'template' => 'person',
                'filename' => $this->logo,
                'w' => 170,
                'h' => 70
            ]);
        }

        return asset('template_assets/zinc/images/logo.png');
    }

    public function getUrlFaviconAttribute()
    {
        if (!empty($this->favicon) && File::exists('../public/storage/' . $this->favicon)) {
            return route('imagecache', [
                'template' => 'person',
                'filename' => $this->favicon,
                'w' => 64,
                'h' => 64
            ]);
        }
    }
}
