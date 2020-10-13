<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('admin');

        $categories = Category::paginate(25);

        return view('categories/index')->with(['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('admin');

        $request->validate([
            'title' => 'string|required|max:25'
        ]);

        // Store image data to DB
        $category = new Category([
            'title' => $request->input('title')
        ]);
        $category->save();

        return redirect('admin/categories')->with('status', 'Category Added');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('admin');

        $request->validate([
            'title' => 'string|required|max:25'
        ]);

        $category->title = $request->input('title');
        $category->save();

        return redirect('admin/categories')->with('status', 'Category Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('admin');

        $category->delete();

        return redirect('admin/categories')->with('status', 'Category Removed');
    }
}
