<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'qty',
        'category_id',
        'image',
        'is_active'
    ];

    /**
     * Requirement A: Enforce Attribute Casting ($casts)
     * Direct database values are parsed into actual JSON floats, integers, and booleans.
     */
    protected $casts = [
        'price'     => 'float',
        'stock'     => 'integer',
        'is_active' => 'boolean',
    ];
    /**
     * Requirement A: Append custom virtual field to the JSON string serialization
     */
    protected $appends = ['image_url'];
    /**
     * Requirement A: One-to-Many Inverse Link (belongsTo Relationship)
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    /**
     * Requirement A: Accessor for generating absolute external URLs for client 
applications
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }
        return url(Storage::url($this->image));
    }
}
