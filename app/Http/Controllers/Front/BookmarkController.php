<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Paste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Auth::user()->bookmarks()->get();

        $pastes = Paste::with('user')->where('privacy', 'public')->latest()->get();

        $bookmarkIds = null;
        if (auth()->user()) {
            $bookmarkIds = auth()->user()->bookmarks()->pluck('paste_id')->toArray();
        }

        return view('front.bookmark', compact('data', 'pastes', 'bookmarkIds'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->bookmarks()->where('paste_id', $request->paste_id)->exists()) {
           return $this->destroy($request->paste_id);

            /* should i delete the bookmark if already added before?
            so if user click add to bookmark btn twice, the bookmark 
            will deleted. */
        }

        Auth::user()->bookmarks()->attach($request->paste_id);
        return response()->json(['message' => 'Added to bookmark']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auth::user()->bookmarks()->detach($id);
        return response()->json(['message' => 'Bookmark deleted']);
    }
}
