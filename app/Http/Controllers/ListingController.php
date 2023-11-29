<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Models\ListingImage;
use App\Models\ProductImage;
use App\Models\Type;
use App\Repositories\ListingRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Response;

class ListingController extends AppBaseController
{
    /** @var  ListingRepository */
    private $listingRepository;

    public function __construct(ListingRepository $listingRepo)
    {
        $this->listingRepository = $listingRepo;
    }

    /**
     * Display a listing of the Listing.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     */
    public function index(Request $request)
    {
        $listings = $this->listingRepository->paginate(10);

        return view('listings.index')
            ->with('listings', $listings);
    }

    /**
     * Show the form for creating a new Listing.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     */
    public function create()
    {
        $types = Type::all()->sortBy('name')->pluck('name', 'id');
        return view('listings.create')->with('types', $types);
    }

    /**
     * Store a newly created Listing in storage.
     *
     * @param CreateListingRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|Response
     */
    public function store(CreateListingRequest $request)
    {
        $user = Auth::user();
        $listingData = $request->all();
        $listingData['slug'] = Str::slug($listingData['title']);


        $image = $this->storeMainImage($request->file('image'));

        $listingData['image'] = $image;
        if($user->role->name == 'Admin'){
            $listingData['admin_id'] = Auth::user()->id;
        }
        if($user->role->name == 'User'){
            $listingData['user_id'] = Auth::user()->id;
        }
        $listing = $this->listingRepository->create($listingData);
        $this->storeListingGallery($request->file('images'), $listing);
        Flash::success('Listing saved successfully.');
        return redirect(route('listings.index'));
    }

    /**
     * Display the specified Listing.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $listing = $this->listingRepository->find($id);

        if (empty($listing)) {
            Flash::error('Listing not found');

            return redirect(route('listings.index'));
        }

        return view('listings.show')->with('listing', $listing);
    }

    /**
     * Show the form for editing the specified Listing.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     */
    public function edit($id)
    {
        $listing = $this->listingRepository->find($id);
        $gallaries = $this->listingRepository->getFormattedGallery($listing->images()->get());
        $types = Type::all()->sortBy('name')->pluck('name', 'id');
        if (empty($listing)) {
            Flash::error('Listing not found');

            return redirect(route('listings.index'));
        }

        return view('listings.edit')
            ->with('listing', $listing)
            ->with('gallaries', $gallaries)
            ->with('types', $types);
    }

    /**
     * Update the specified Listing in storage.
     *
     * @param int $id
     * @param UpdateListingRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateListingRequest $request)
    {
        $listing = $this->listingRepository->find($id);

        if (empty($listing)) {
            Flash::error('Listing not found');

            return redirect(route('listings.index'));
        }

        $listingData = $request->all();
        if($request->file('image')){
            foreach ($request->file('image') as $value) {
                $name = Str::random(4) . '-' . $value->getClientOriginalName();
                $ImagePath = "/assets/frontend/img/listing/". $name;
                $value->move(public_path() . '/assets/frontend/img/listing/', $name);
                $listingData['image'] = $ImagePath;
            }
        }

        $listing = $this->listingRepository->update($listingData, $id);

        Flash::success('Listing updated successfully.');

        return redirect(route('listings.index'));
    }

    /**
     * Remove the specified Listing from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $listing = $this->listingRepository->find($id);

        if (empty($listing)) {
            Flash::error('Listing not found');

            return redirect(route('listings.index'));
        }

        $this->listingRepository->delete($id);

        Flash::success('Listing deleted successfully.');

        return redirect(route('listings.index'));
    }

    public function delete_image($id)
    {
        $image = ListingImage::find($id);

        if (empty($image)) {
            return redirect()->back()->with('error', 'Image not found');
        }

        $image->delete($id);

        return redirect()->back()->with('error', 'Image deleted successfully.');
    }

    private function storeMainImage(?array $file)
    {
        $image = '';
        if($file){
            foreach ($file as $value) {
                $name = Str::random(4) . '-' . $value->getClientOriginalName();
                $ImagePath = "/assets/frontend/img/listing/". $name;
                $value->move(public_path() . '/assets/frontend/img/listing/', $name);
                $image = $ImagePath;
            }
        }
        return $image;
    }

    private function storeListingGallery(?array $file, \Illuminate\Database\Eloquent\Model $listing)
    {
        $productImages = [];
        if ($file) {
            foreach ($file as $value) {
                $name = Str::random(4) . '-' . $value->getClientOriginalName();
                $ext = $value->getClientOriginalExtension();
                $size = $value->getSize();
                $productImagePath = "/assets/frontend/img/listing/gallery/" . $name;
                $productImages[] = [
                    'file_name' => $name,
                    'path' => $productImagePath,
                    'size' => $size,
                    'format' => $ext,
                    'listing_id' => $listing->id
                ];
                $value->move(public_path() . '/assets/frontend/img/listing/gallery/', $name);
            }
            $listing->galleries()->createMany($productImages);
        }
    }
}
