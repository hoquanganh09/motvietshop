<?php

namespace App\Models;

use App\Traits\ModelScopeTrait;
use App\Traits\UploadFileTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, ModelScopeTrait, SearchableTrait;

    protected $fillable = [
        'name',
        'price',
        'old_price',
        'description',
        'washing_instructions',
        'kind_id',
        'is_active',
        'stock',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('is_on_top', 'desc');
    }

    public function getThumbnail(bool $withDefault = true)
    {
        $image = $this->images->first();

        if (!$withDefault) {
            return $image->isOnTop() ? $image->image : null;
        }

        return $image ? $image->getImage() : getDefaultImage();
    }

    public function getStatusLabel(): string
    {
        return $this->is_active ? 'Đang hoạt động' : 'Không hoạt động';
    }

    public function isInStock(): bool
    {
        return ($this->stock > 0) ? true : false;
    }

    public static function searchFields()
    {
        return [
            'name', 'price', 'old_price',
        ];
    }

    public function kind()
    {
        return $this->belongsTo(Kind::class);
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function isSale(): bool
    {
        return $this->old_price ? true : false;
    }

    public function getDiscount(): int
    {
        if (!$this->isSale()) {
            return 0;
        }

        $discount = (($this->old_price - $this->price) / $this->old_price) * 100;

        return round($discount);
    }

    public function getWashingInstructions(): string
    {
        $array = ['<p><br></p>'];

        if (!$this->washing_instructions  || in_array($this->washing_instructions, $array)) {
            return view('client.product.default.washing_instruction')->render();
        }

        return $this->washing_instructions;
    }

    public static function getProductRelations(): array
    {
        return [
            'colors',
            'colors.color',
            'sizes',
            'sizes.size',
            'images',
        ];
    }

    public static function getProducts(array $ids = [], int $limit = null, string|int $exceptId = null, bool $buider = false)
    {
        $query = self::query()
            ->active()
            ->with(self::getProductRelations());

        if (count($ids) > 0) {
            $query = $query->whereIn('id', $ids);
        }

        if ($exceptId) {
            $query = $query->where('id', '!=', $exceptId);
        }

        if ($limit) {
            $query = $query->limit($limit);
        }

        return $buider ? $query : $query->get();
    }
}
