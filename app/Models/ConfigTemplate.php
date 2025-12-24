<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ConfigTemplate extends Model
{
    use HasFactory;

    protected $casts = [
        'content' => 'array'
    ];

    protected $fillable = [
        'content',
    ];

    public function getUrlHeaderImageAttribute()
    {
        if (!empty($this->header_image) && File::exists('../public/storage/' . $this->header_image)) {
            return route('imagecache', [
                'template' => 'person',
                'filename' => $this->header_image,
                'w' => 840,
                'h' => 503
            ]);
        }
    }

    public function getUrlServiceImage1Attribute()
    {
        if (!empty($this->service_image_1) && File::exists('../public/storage/' . $this->service_image_1)) {
            return route('imagecache', [
                'template' => 'person',
                'filename' => $this->service_image_1,
                'w' => 90,
                'h' => 90
            ]);
        }
    }

    public function getUrlServiceImage2Attribute()
    {
        if (!empty($this->service_image_2) && File::exists('../public/storage/' . $this->service_image_2)) {
            return route('imagecache', [
                'template' => 'person',
                'filename' => $this->service_image_2,
                'w' => 90,
                'h' => 90
            ]);
        }
    }

    public function getUrlServiceImage3Attribute()
    {
        if (!empty($this->service_image_3) && File::exists('../public/storage/' . $this->service_image_2)) {
            return route('imagecache', [
                'template' => 'person',
                'filename' => $this->service_image_3,
                'w' => 90,
                'h' => 90
            ]);
        }
    }

    public function getUrlAboutImageAttribute()
    {
        if (!empty($this->about_image) && File::exists('../public/storage/' . $this->about_image)) {
            return route('imagecache', [
                'template' => 'person',
                'filename' => $this->about_image,
                'w' => 585,
                'h' => 548
            ]);
        }
    }

    public function serviceDescriptions1()
    {
        return preg_split('/\r\n|\r|\n/', $this->attributes['service_description_1']);
    }

    public function serviceDescriptions2()
    {
        return preg_split('/\r\n|\r|\n/', $this->attributes['service_description_2']);
    }

    public function serviceDescriptions3()
    {
        return preg_split('/\r\n|\r|\n/', $this->attributes['service_description_3']);
    }
}
