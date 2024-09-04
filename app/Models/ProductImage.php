<?php

namespace App\Models;

use App\Traits\UploadFileTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory, UploadFileTrait;

    protected $fillable = [
        'product_id',
        'image',
        'is_on_top',
    ];

    public function getImage()
    {
        return $this->image ? Storage::url($this->image) : getDefaultImage();
    }

    public function isOnTop()
    {
        return $this->is_on_top;
    }
}
