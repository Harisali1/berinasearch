<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateListingAPIRequest;
use App\Http\Requests\API\FavoriteListingAPIRequest;
use App\Http\Requests\API\GalleryStoreRequest;
use App\Http\Requests\API\UpdateListingAPIRequest;
use App\Http\Resources\FavoriteResource;
use App\Models\Gallery;
use App\Models\Listing;
use App\Models\User;
use App\Repositories\ListingRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ListingResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Response;

/**
 * Class ListingController
 * @package App\Http\Controllers\API
 */
class ListingAPIController extends AppBaseController
{
    /** @var  ListingRepository */
    /** @var  UserRepository */
    private $listingRepository, $userRepository;

    public function __construct(ListingRepository $listingRepo, UserRepository $userRepo)
    {
        $this->listingRepository = $listingRepo;
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the Listing.
     * GET|HEAD /listings
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $listings = $this->listingRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        return $this->sendResponse(ListingResource::collection($listings), 'Listings retrieved successfully');
    }

    /**
     * Store a newly created Listing in storage.
     * POST /listings
     *
     * @param CreateListingAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateListingAPIRequest $request)
    {
        $user = Auth::user();
        $listings = Listing::whereUserId($user->id)->get()->count();

        if ($user->listing_credits <= $listings) {
            return $this->sendError('Listing Limit Exceed');
        }

        $listingData = $request->all();
        $listingData['slug'] = Str::slug($listingData['title']);

        if ($user->role->name == 'Admin') {
            $listingData['admin_id'] = Auth::user()->id;
        }

        if ($user->role->name == 'User' || $user->role->name == 'Broker') {
            $listingData['user_id'] = Auth::user()->id;
        }

        $listingData['image'] = 'default.jpg';

        $listing = $this->listingRepository->create($listingData);

        $imageIdArray = $request->get('image_ids');

        $arr = [
            'listing_id' => $listing->id,
        ];

        $where['listing_id'] = $imageIdArray;

        DB::table('galleries')->whereIn('id', $imageIdArray)->update($arr);

//        $this->storeListingGallery($request->file('images'), $listing);
        return $this->sendResponse(new ListingResource($listing), 'Listing saved successfully');
    }

    /**
     * Display the specified Listing.
     * GET|HEAD /listings/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Listing $listing */
        $listing = $this->listingRepository->find($id);

        if (empty($listing)) {
            return $this->sendError('Listing not found');
        }

        return $this->sendResponse(new ListingResource($listing), 'Listing retrieved successfully');
    }

    /**
     * Update the specified Listing in storage.
     * PUT/PATCH /listings/{id}
     *
     * @param int $id
     * @param UpdateListingAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {

        $listing = $this->listingRepository->find($id);

        if (empty($listing)) {
            return $this->sendError('Listing not found');
        }

        $listingData = $request->all();
//        if ($request->file('image')) {
//            foreach ($request->file('image') as $value) {
//                $name = Str::random(4) . '-' . $value->getClientOriginalName();
//                $ImagePath = "/assets//assets/frontend/images/listing/" . $name;
//                $value->move(public_path() . '/assets//assets/frontend/images/listing/', $name);
//                $listingData['image'] = $ImagePath;
//            }
//        }

        $listing = $this->listingRepository->update($listingData, $id);

        return $this->sendResponse(new ListingResource($listing), 'Listing updated successfully');
    }

    /**
     * Remove the specified Listing from storage.
     * DELETE /listings/{id}
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var Listing $listing */
        $listing = $this->listingRepository->find($id);

        if (empty($listing)) {
            return $this->sendError('Listing not found');
        }

        $listing->delete();

        return $this->sendSuccess('Listing deleted successfully');
    }

    public function userListing()
    {

        $listings = Listing::where('user_id', Auth::user()->id)->get();

        return $this->sendResponse(ListingResource::collection($listings), 'Listings retrieved successfully');

    }

    public function userFavoriteListing()
    {
        $listings = User::where('id', Auth::user()->id)->get();
        return $this->sendResponse(FavoriteResource::collection($listings), 'User Favorite Listing retrieved successfully');
    }

    public function listingImagesAdd(GalleryStoreRequest $request)
    {
        if ($request->get('image')) {
            $folderPath = "/assets/frontend/img/listing/gallery/";
            $image = Str::replace('data:image/png;base64,', '', $request->get('image'));
            $image = Str::replace(' ', '+', $image);
            $imageName = Str::random(10) . '.' . 'png';

            $listingGallery = [
                'file_name' => $imageName,
                'path'      => $folderPath . '/' . $imageName,
                'size'      => '2306',
                'format'    => 'png',
            ];
            File::put(public_path() . $folderPath . '/' . $imageName, base64_decode($image));
            $gallery = Gallery::create($listingGallery);
        }
        $response = [
            'id'       => $gallery->id,
            'path'     => $gallery->path,
            'full_url' => env('APP_URL') . $gallery->path,
        ];
        return $this->sendResponse($response, 'Listing Gallery updated successfully');
    }

    public function favoriteListing(FavoriteListingAPIRequest $request)
    {
        $user = $this->userRepository->find($request->get('user_id'));
        $user->favorite()->attach($request->get('listing_id'));
        return $this->sendResponse([], 'Listing Favorite Successfully');
    }

    private function storeMainImage(?array $file)
    {

        if ($file) {
            foreach ($file as $value) {
                $name = Str::random(4) . '-' . $value->getClientOriginalName();
                $ImagePath = "/assets/frontend/img/listing/" . $name;
                $value->move(public_path() . '/assets/frontend/img/listing/', $name);
                $listingData['image'] = $ImagePath;
            }
        }
        return $listingData['image'];
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
                    'file_name'  => $name,
                    'path'       => $productImagePath,
                    'size'       => $size,
                    'format'     => $ext,
                    'listing_id' => $listing->id
                ];
                $value->move(public_path() . '/assets/frontend/img/listing/gallery/', $name);
            }
            $listing->images()->createMany($productImages);
        }
    }
}
