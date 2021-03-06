<?php

namespace App\Http\Controllers;

use App\Gift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            $gifts = Gift::where('receiver_id', Auth::id())->where('someone_else_added', false)->get();
            $purchases = Gift::with('receiver')->where('purchaser_id', Auth::id())->get();
            return view('home', [
                'gifts' => $gifts,
                'purchases' => $purchases,
                'currentUser' => Auth::id()
            ]);
        } else {
            return view('main');
        }
    }
}
