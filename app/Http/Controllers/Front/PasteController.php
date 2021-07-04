<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Paste;
use Illuminate\Http\Request;

class PasteController extends Controller
{
    public function index()
    {
        $data = Paste::where('privacy', 'public')->latest('id')->get();

        $popular = Paste::where('privacy', 'public')
            ->where('viewed_count', '>=', 10)
            ->orderBy('viewed_count', 'desc')
            ->get()
            ->take(3);

        $bookmarkIds = null;

        if (auth()->user()) {
            $bookmarkIds = auth()->user()->bookmarks()->pluck('paste_id')->toArray();
        }

        return view('front.paste-index', compact('data', 'popular', 'bookmarkIds'));
    }

    public function show($slug)
    {
        $data = Paste::where('privacy', 'public')->latest()->get();
        $paste = Paste::with('links')->where('slug', $slug)->firstOrFail();

        return view('front.paste-detail', compact('paste', 'data'));
    }


    public function addViewedCount($id)
    {
        $paste = Paste::findOrFail($id);
        $paste->viewed_count = $paste->viewed_count + 1;
        $paste->save();

        return $paste->viewed_count;
    }
}
