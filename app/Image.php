<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as ImageIntervention;

class Image extends Model
{
    protected $fillable = ['title', 'description', 'category', 'storage_path'];

    /**
     * Return Image URL.
     *
     * @return string
     */
    public function url()
    {
        return Storage::disk('public')->url($this->storage_path);
    }

    /**
     * Return Image URL.
     *
     * @return string
     */
    public function thumb_url()
    {
        return Storage::disk('public')->url($this->thumb_storage_path());
    }

    /**
     * Return Image thumb path.
     *
     * @return string
     */
    public function thumb_storage_path()
    {
        // Separate file path and extension
        $image_path_explode = explode('.', $this->storage_path);
        // Get extension and remove it from array
        $image_extension = array_pop($image_path_explode);
        $image_path_without_extension = implode('.', $image_path_explode);
        // Get Image thumb path
        $image_thumb_path = $image_path_without_extension . '_thumb.' . $image_extension;

        return $image_thumb_path;
    }

    /**
     * Create Image thumb file
     *
     * @return Intervention\Image\Image
     */
    public function create_thumb()
    {
        // Create thumb using logic (name of stored image + _thumb + .extention)
        $thumb = ImageIntervention::make(Storage::disk('public')->get($this->storage_path));
        $thumb->fit(350, 240);

        return $thumb->save(Storage::disk('public')->path($this->thumb_storage_path()));
    }

    /**
     * Delete Image thumb, file and instance
     *
     * @return bool|null
     *
     * @throws \Exception
     */
    public function delete()
    {
        // Delete Image thumb
        Storage::disk('public')->delete($this->thumb_storage_path());
        // Delete Image file
        Storage::disk('public')->delete($this->storage_path);
        // Delete Image instance
        parent::delete();
    }
}
