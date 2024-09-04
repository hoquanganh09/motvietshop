<?php

namespace App\Models;

use App\Traits\UploadFileTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory, UploadFileTrait;

    protected $fillable = [
        'name', 'image'
    ];

    public function getImage()
    {
        return $this->image ? Storage::url($this->image) : getDefaultImage();
    }

    public function kinds()
    {
        return $this->hasMany(Kind::class);
    }
}
