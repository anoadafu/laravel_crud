<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as ImageIntervention;

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
        $images = Image::orderBy('created_at','desc')->paginate(10);

        return view('index')->with(compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
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
            'description' => 'string|required|max:280',
            'category' => 'string|required|max:25',
            'image' => 'image|required|max:4096', // 4MB Max
        ]);

        // Save uploaded file to local storage
        $file = $request->file('image');
        $storage_path = $file->storePublicly('images');

        // Create thumb using logic (name of stored image + _thumb + .extention)
        $thumb_path = storage_path('app/public/images/' . explode('.', $file->hashName())[0] . '_thumb.' . $file->extension());
        $thumb = ImageIntervention::make($file->path());
        $thumb->fit(350, 240);
        $thumb->save($thumb_path);

        // Store image data to DB
        $image = new Image([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category' => $request->input('category'),
            'storage_path' => $storage_path
        ]);
        $image->save();

        return redirect('/')->with('status', 'Image Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = Image::findOrFail($id);

        return view('show')->with(compact('image'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $image = Image::findOrFail($id);

        return view('edit')->with(compact('image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Check image exist
        $image = Image::findOrFail($id);

        $request->validate([
            'title' => 'string|required|max:60',
            'description' => 'string|required|max:280',
            'category' => 'string|required|max:25',
        ]);

        // Update Image data
        $image->title = $request->input('title');
        $image->description = $request->input('description');
        $image->category = $request->input('category');

        $image->save();

        return redirect('/')->with('status', 'Image Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Image::find($id);
        
        // Check if image exists before deleting
        if (!isset($image)){
            return redirect('/')->with('error', 'No Such Image');
        }

        // Delete Image
        Storage::delete($image->storage_path);
        $image->delete();
        
        return redirect('/')->with('status', 'Image Removed');
    }

    public function search(Request $request)
    {
        $images = Image::where('title', 'LIKE', '%'. $request->q .'%' )->paginate (10);

        return view('search')->with('images', $images);
    }
}
