<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="images")
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     */
    private $category;

    /**
     * @ORM\Column(type="string")
     */
    private $description;
    
    /**
     * @ORM\Column(type="string")
     */
    private $storage_path;

    public function __construct($title, $category, $description, $storage_path)
    {
        $this->title = $title;
        $this->category = $category;
        $this->description = $description;
        $this->storage_path = $storage_path;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getStorage_path()
    {
        return $this->storage_path;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setStorage_path($storage_path)
    {
        $this->storage_path = $storage_path;
    }


    // Old methods



    /**
     * Return Image URL.
     *
     * @return string
     */
    public function url()
    {
        return \Storage::disk('public')->url($this->storage_path);
    }

    /**
     * Return Image URL.
     *
     * @return string
     */
    public function thumb_url()
    {
        return \Storage::disk('public')->url($this->thumb_storage_path());
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
        $thumb = \ImageIntervention::make(\Storage::disk('public')->get($this->storage_path));
        $thumb->fit(350, 240);

        return $thumb->save(\Storage::disk('public')->path($this->thumb_storage_path()));
    }
    
}