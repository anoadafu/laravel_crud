<?php

namespace App\Http\Controllers;

use App\Image;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Add pagination if render more than 10 images
        $images = Image::orderBy('created_at','desc')->paginate(12);

        return view('images/index')->with(compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('images/create')->with(compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'string|required|max:60',
            'description' => 'string|required|max:255',
            'category_id' => 'integer|required|exists:categories,id',
            'image' => 'image|required|max:4096', // 4MB Max
        ]);

        // Save uploaded file to local storage
        $file = $request->file('image');
        $storage_path = Storage::disk('public')->put('images', $file);

        // Store image data to DB
        $image = new Image([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
            'storage_path' => $storage_path
        ]);
        $image->set_owner(auth()->user());
        $image->save();

        $image->create_thumb();

        return redirect('images')->with('status', 'Image Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        return view('images/show')->with(compact('image'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        $this->authorize('update-delete-image', $image);
        
        $categories = Category::all();

        return view('images/edit')->with(compact('image', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        $this->authorize('update-delete-image', $image);

        $request->validate([
            'title' => 'string|required|max:60',
            'description' => 'string|required|max:255',
            'category_id' => 'integer|required|exists:categories,id',
        ]);

        // Update Image data
        $image->title = $request->input('title');
        $image->description = $request->input('description');
        $image->category_id = $request->input('category_id');

        $image->save();

        return redirect('images')->with('status', 'Image Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        $this->authorize('update-delete-image', $image);

        // Delete Image instance, image file  and image thumb
        $image->delete();

        return redirect('images')->with('status', 'Image Removed');
    }
    /**
     * Perform search query by title.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $images = Image::where('title', 'LIKE', '%'. $request->q .'%' )->paginate(12);

        return view('images/search')->with(['images' => $images, 'search_query' => $request->q]);
    }
}
