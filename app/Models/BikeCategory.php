<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BikeCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'icon_url',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];


    public function parent()
    {
        return $this->belongsTo(BikeCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(BikeCategory::class, 'parent_id');
    }
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function models()
    {
        return $this->hasMany(BikeModel::class, 'category_id');
    }

    public function listings()
    {
        return $this->hasMany(Listing::class, 'category_id');
    }

    public function isRoot()
    {
        return is_null($this->parent_id);
    }

    public function getParents()
    {
        $parents = [];
        $category = $this;

        while ($category->parent) {
            $parents[] = $category->parent;
            $category = $category->parent;
        }

        return array_reverse($parents);
    }
}