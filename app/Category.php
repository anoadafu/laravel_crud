<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title'];

    public function images()
    {
        return $this->hasMany('App\Image');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($category) {
             $category->images()->delete();
        });
    }
}
