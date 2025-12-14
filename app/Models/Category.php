<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'merchant_id',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship to parent category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Relationship to child categories (subcategories)
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Relationship to merchant
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
