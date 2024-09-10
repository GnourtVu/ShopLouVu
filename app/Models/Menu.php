<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'content',
        'active',
        'thumb',
        'slug'
    ];
    public function products()
    {
        return $this->hasMany(Product::class, 'menu_id', 'id');
    }
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
}
