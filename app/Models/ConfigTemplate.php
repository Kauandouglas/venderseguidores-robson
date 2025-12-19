<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ConfigTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'nav_button',
        'header_title',
        'header_sub_title',
        'header_button',
        'service_title_1',
        'service_sub_title_1',
        'service_description_1',
        'service_title_2',
        'service_sub_title_2',
        'service_description_2',
        'service_title_3',
        'service_sub_title_3',
        'service_description_3',
        'basic_title',
        'basic_description',
        'about_title',
        'about_description',
        'about_button',
        'contact_title',
        'contact_description',
        'footer_title',
    ];

    public function setHeaderImage($value)
    {
        if (!is_null($value)) {
            Storage::delete($this->header_image);

            $upload = $value->store('configTemplates/' . $this->id);
            $this->attributes['header_image'] = $upload;
        }
    }

    public function setServiceImage1($value)
    {
        if (!is_null($value)) {
            Storage::delete($this->service_image_1);

            $upload = $value->store('configTemplates/' . $this->id);
            $this->attributes['service_image_1'] = $upload;
        }
    }

    public function setServiceImage2($value)
    {
        if (!is_null($value)) {
            Storage::delete($this->service_image_2);

            $upload = $value->store('configTemplates/' . $this->id);
            $this->attributes['service_image_2'] = $upload;
        }
    }

    public function setServiceImage3($value)
    {
        if (!is_null($value)) {
            Storage::delete($this->service_image_3);

            $upload = $value->store('configTemplates/' . $this->id);
            $this->attributes['service_image_3'] = $upload;
        }
    }

    public function setAboutImage($value)
    {
        if (!is_null($value)) {
            Storage::delete($this->about_image);

            $upload = $value->store('configTemplates/' . $this->id);
            $this->attributes['about_image'] = $upload;
        }
    }

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
