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

    /**
     * Return Image thumb URL.
     *
     * @return string
     */
    public function thumb_file(){
        return explode('.', $this->storage_path)[0] . '_thumb.' . explode('.', $this->storage_path)[1];
    }
}
