<?php

namespace App\Http\Controllers;

use App\Gift;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        $gifts = Gift::where('receiver_id', $userId)->limit(1000)->get();
        return view('gift.list', [
            'gifts' => $gifts,
            'user' => User::findOrFail($userId),
            'currentUser' => Auth::id()
        ]);
    }

    public function create()
    {
        return view('gift.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gift = new Gift;
        $gift->title = $request->title;
        $gift->description = $request->description;
        $gift->url = $request->url;
        $gift->price = $request->price;
        $gift->receiver_id = Auth::id();
        $gift->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Gift  $gift
     * @return \Illuminate\Http\Response
     */
    public function show(Gift $gift)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gift  $gift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gift $gift)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gift  $gift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gift $gift)
    {
        //
    }

    public function search(Request $request)
    {
        $giftSearch = Gift::search($request->searchQuery)->where('receiver_id', $request->user)->get()->load(['purchaser']);
        return $giftSearch;
    }

    public function claimConfirm($giftId)
    {
        $gift = Gift::findOrFail($giftId);

        if ($gift->receiver_id === Auth::id()) {
            return view('home', ['gifts' => ""]);
        }
        return view('gift.claim', ['gift' => $gift]);
    }

    public function claim($giftId)
    {
        $gift = Gift::findOrFail($giftId);
        if ($gift->receiver_id !== Auth::id()) {
            $gift->purchaser_id = Auth::id();
            $gift->save();
            return view('gift.claim-success', [
                'userProfile' => $gift->receiver_id
            ]);
        }
    }

    public function unclaim($giftId)
    {
        $gift = Gift::findOrFail($giftId);
        $gift->purchaser_id = null;
        $gift->save();
        $purchaseList = Gift::with('receiver')->where('purchaser_id', Auth::id())->get();
        return $purchaseList;
    }
}
