<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string name
 * @property string description
 * @property float price
 * @property \DateTimeInterface date_validity
 * @property string image
 * @property int category_id
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'date_validity',
        'image',
        'category_id'
    ];

    protected $casts = [
        'price' => 'float',
        'date_validity' => 'datetime:Y-m-d',
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
