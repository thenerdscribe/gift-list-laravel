<?php

namespace App\Http\Controllers;

use App\Gift;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
    public function show(int $giftId)
    {
        $gift = Gift::findOrFail($giftId);
        return view('gift.create', [
            'gift' => $gift
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gift  $gift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $giftId)
    {
        $gift = Gift::findOrFail($giftId);
        $gift->title = $request->title;
        $gift->description = $request->description;
        $gift->url = $request->url;
        $gift->price = $request->price;
        $gift->given = $request->given ?? $gift->given;
        $gift->wrapped = $request->wrapped ?? $gift->wrapped;
        $gift->received = $request->received ?? $gift->received;
        $gift->purchased = $request->purchased ?? $gift->purchased;
        $gift->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gift  $gift
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $giftId)
    {
        Gift::destroy($giftId);
        $gifts = Gift::where('receiver_id', Auth::id())->get();
        return $gifts;
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
        $gift->given = false;
        $gift->wrapped = false;
        $gift->received = false;
        $gift->purchased = false;
        $gift->save();
        $purchaseList = Gift::with('receiver')->where('purchaser_id', Auth::id())->get();
        return $purchaseList;
    }
}
