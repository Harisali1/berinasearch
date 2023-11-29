<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePlanAPIRequest;
use App\Http\Requests\API\UpdatePlanAPIRequest;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use App\Repositories\PlanRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PlanResource;
use Response;

/**
 * Class PlanController
 * @package App\Http\Controllers\API
 */

class PlanAPIController extends AppBaseController
{
    /** @var  PlanRepository */
    private $planRepository;

    public function __construct(PlanRepository $planRepo)
    {
        $this->planRepository = $planRepo;
    }

    /**
     * Display a listing of the Plan.
     * GET|HEAD /plans
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $plans = $this->planRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(PlanResource::collection($plans), 'Plans retrieved successfully');
    }

//    /**
//     * Store a newly created Plan in storage.
//     * POST /plans
//     *
//     * @param CreatePlanAPIRequest $request
//     *
//     * @return Response
//     */
//    public function store(CreatePlanAPIRequest $request)
//    {
//        $input = $request->all();
//
//        $plan = $this->planRepository->create($input);
//
//        return $this->sendResponse(new PlanResource($plan), 'Plan saved successfully');
//    }

    /**
     * Display the specified Plan.
     * GET|HEAD /plans/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Plan $plan */
        $plan = $this->planRepository->find($id);
        if (empty($plan)) {
            return $this->sendError('Plan not found');
        }

        $user = User::whereApiToken(request()->bearerToken())->firstOrFail();
        $user->update([
            'listing_credits' => $user->listing_credits + $plan->no_of_listing,
        ]);

        $payment = [
            'plan_id' => $id,
            'user_id' => $user->id,
            'price' => $plan->price,
            'limit' => $plan->limit,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
        ];

        $payment = Payment::create($payment);

        return $this->sendResponse('success', 'Payment Create successfully');
    }

//    /**
//     * Update the specified Plan in storage.
//     * PUT/PATCH /plans/{id}
//     *
//     * @param int $id
//     * @param UpdatePlanAPIRequest $request
//     *
//     * @return Response
//     */
//    public function update($id, UpdatePlanAPIRequest $request)
//    {
//        $input = $request->all();
//
//        /** @var Plan $plan */
//        $plan = $this->planRepository->find($id);
//
//        if (empty($plan)) {
//            return $this->sendError('Plan not found');
//        }
//
//        $plan = $this->planRepository->update($input, $id);
//
//        return $this->sendResponse(new PlanResource($plan), 'Plan updated successfully');
//    }

//    /**
//     * Remove the specified Plan from storage.
//     * DELETE /plans/{id}
//     *
//     * @param int $id
//     *
//     * @throws \Exception
//     *
//     * @return Response
//     */
//    public function destroy($id)
//    {
//        /** @var Plan $plan */
//        $plan = $this->planRepository->find($id);
//
//        if (empty($plan)) {
//            return $this->sendError('Plan not found');
//        }
//
//        $plan->delete();
//
//        return $this->sendSuccess('Plan deleted successfully');
//    }
}
