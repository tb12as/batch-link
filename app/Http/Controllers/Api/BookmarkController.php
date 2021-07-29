<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookmarkResource;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index()
    {
        return [
            'data' => BookmarkResource::collection(
                auth()->user()->bookmarks()->latest()->get()
            )
        ];
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'paste_id' => 'required|numeric',
        ]);

        if(auth()->user()->bookmarks()->where('paste_id', $request->paste_id)->exists()) {
            return $this->destroy($request->paste_id);
        }

        auth()->user()->bookmarks()->attach($request->paste_id);
        return response()->json(['message' => 'Added to bookmark']);
    }

    public function destroy($paste_id)
    {
        auth()->user()->bookmarks()->detach($paste_id);
        return ['message' => 'Bookmark deleted'];
    }
}
