<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\SearchAPIRequest;
use App\Http\Requests\API\SearchFilterAPIRequest;
use App\Http\Resources\ListingResource;
use App\Models\Listing;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Response;

/**
 * Class UserController
 * @package App\Http\Controllers\API
 */
class SearchAPIController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }


    public function index(Request $request)
    {
        $search = Listing::with('images');

        if ($request->get('location')) {
            $search = $search
                ->where('location', 'like', "%{$request->get('location')}%");
        }
        if ($request->get('zip_code')) {
            $search = $search
                ->orWhere('zip_code', 'like', "%{$request->get('zip_code')}%");
        }

        $search = $search->get();

        if (count($search) > 0) {
            return $this->sendResponse($search, 'Listing retrieved successfully');
        }
        return $this->sendError('Listing not found');


    }

    public function filter(SearchFilterAPIRequest $request)
    {
        $search = Listing::with('images');

        if ($request->get('zip_code')) {
            $search = $search
                ->where('zip_code', 'like', "%{$request->get('zip_code')}%");
        }

        if ($request->get('type_id')) {
            $search = $search
                ->orWhere('type_id', $request->get('type_id'));
        }

        if ($request->get('min_price')) {
            $search = $search
                ->orWhere('price', '>=', $request->get('min_price'));
        }

        if ($request->get('max_price')) {
            $search = $search
                ->orWhere('price', '<=', $request->get('max_price'));
        }

        $search = $search->get();

        if (count($search) > 0) {
            return $this->sendResponse($search, 'Listing retrieved successfully');
        }
        return $this->sendError('Listing not found');

    }

}
