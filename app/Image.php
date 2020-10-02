<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = ['title', 'description', 'category', 'storage_path'];

    /**
     * Return Image URL.
     *
     * @return string
     */
    public function url(){
        return Storage::url($this->storage_path);
    }
}
