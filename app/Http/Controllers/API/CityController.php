<?php

namespace App\Http\Controllers\API;

//use App\Http\Requests\API\CreateCityAPIRequest;
//use App\Http\Requests\API\UpdateCityAPIRequest;
use App\Models\Payment;
use App\Models\City;
use App\Models\User;
use App\Repositories\CityRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CityResource;
use Response;

/**
 * Class CityController
 * @package App\Http\Controllers\API
 */

class CityController extends AppBaseController
{
    /** @var  CityRepository */
    private $cityRepository;

    public function __construct(CityRepository $cityRepo)
    {
        $this->cityRepository = $cityRepo;
    }

    /**
     * Display a listing of the City.
     * GET|HEAD /citys
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $citys = $this->cityRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(CityResource::collection($citys), 'Citys retrieved successfully');
    }



}
