<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $listings = Listing::with('images','type','user')->orderBy('id','desc')->limit(6)->get();
        return view('frontend.index', compact('listings'));
    }

    public function welcome()
    {
        return view('welcome');
    }

    public function execute()
    {
        return request('paymentId');
    }
}
