<?php

namespace App\Http\Controllers;

use App\Entities\Image;
use Illuminate\Http\Request;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class ImageController extends Controller
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Display a listing of the resource.
     * @param  array  $items
     * @param  int  $results_per_page
     * @param  int  $requested_page
     * @param  array  $options (path, query, fragment, pageName)
     * 
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    private function get_paginatior($items, $results_per_page, $requested_page, array $options = [])
    {
        // Prepare slice for pagination
        $requested_page = is_null($requested_page) ? 1 : $requested_page;
        $offset = $results_per_page * ($requested_page -1);
        $c = count($items);
        $items_slice = array_slice($items, $offset, $results_per_page);

        return new Paginator($items_slice, $c, $results_per_page, $requested_page, $options);
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $results_per_page
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $results_per_page = 6)
    {
        $request->validate([
            'page' => 'nullable|integer'
        ]);
        //Get all Images
        $images = $this->em->getRepository(Image::class)->findBy([], ['id' => 'DESC']);
        
        // Add pagination if render more than results_per_page Images
        $paginator = $this->get_paginatior($images, $results_per_page, $request->page, ['path' => 'images']);

        return view('images/index', ['paginator' => $paginator]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('images/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
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
        $storage_path = \Storage::disk('public')->put('images', $file);

        // Store image data to DB
        $image = new Image($request->input('title'), $request->input('category'), $request->input('description'), $storage_path);

        $this->em->persist($image);
        $this->em->flush();

        $image->create_thumb();

        return redirect('images')->with(['status' => 'Image Added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = $this->em->getRepository(Image::class)->find($id);
        abort_if(empty($image), 404);

        return view('images/show', ['image' => $image]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $image = $this->em->getRepository(Image::class)->find($id);
        abort_if(empty($image), 404);

        return view('images/edit', ['image' => $image]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Check image exist
        $image = $this->em->getRepository(Image::class)->find($id);
        abort_if(empty($image), 404);

        $request->validate([
            'title' => 'string|required|max:60',
            'description' => 'string|required|max:280',
            'category' => 'string|required|max:25',
        ]);

        // Update Image data
        $image->setTitle($request->input('title'));
        $image->setCategory($request->input('category'));
        $image->setDescription($request->input('description'));

        $this->em->flush();

        return redirect('images')->with(['status' => 'Image Edited']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = $this->em->getRepository(Image::class)->find($id);
        abort_if(empty($image), 404);

        // Check if image exists before deleting
        if (!isset($image)){
            return redirect('images')->with(['error' => 'No Such Image']); //TODO edit in master brunch
        }

        // Delete Image inctance, image file  and image thumb
        $this->em->remove($image);
        $this->em->flush();

        return redirect('images')->with(['status' => 'Image Removed']);
    }

    /**
     * Perform search query by title.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $results_per_page
     * 
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, $results_per_page = 6)
    {
        $request->validate([
            'q' => 'required|max:60',
            'page' => 'nullable|integer'
        ]);

        // Get serched Images
        $query = $this->em->createQuery('SELECT i FROM App\Entities\Image i WHERE i.title LIKE :q');
        $query->setParameter('q', '%' . $request->q . '%');
        $searched_images = $query->getResult();
        
        // Create pagination
        $paginator = $this->get_paginatior($searched_images, $results_per_page, $request->page, ['path' => 'search']);
        
        return view('images/search', ['search_query' => $request->q, 'paginator' => $paginator]);
    }

}
