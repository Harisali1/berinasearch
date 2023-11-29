<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\InvoiceResource;
use App\Repositories\InvoiceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Response;

class InvoiceController extends AppBaseController
{
    /** @var  InvoiceRepository */
    private $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepo)
    {
        $this->invoiceRepository = $invoiceRepo;
    }

    /**
     * Display a listing of the Role.
     * GET|HEAD /categories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $invoices = $this->invoiceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(InvoiceResource::collection($invoices), 'Invoices retrieved successfully');
    }

}
