<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Paste;
use Illuminate\Http\Request;

class PasteController extends Controller
{
    public function index()
    {
        $data = Paste::where('privacy', 'public')->latest()->get();

        $vars = $this->popularAndBookmarkIds();

        $popular = $vars['popular'];
        $bookmarkIds = $vars['bookmarkIds'];

        return view('front.paste-index', compact('data', 'popular', 'bookmarkIds'));
    }

    public function show($slug)
    {
        $data = Paste::where('privacy', 'public')
            ->where('slug', '!=', $slug)
            ->latest()
            ->get();

        $paste = Paste::with('links')
            ->where('privacy', 'public')
            ->where('slug', $slug)
            ->firstOrFail();

        $bookmarkIds = null;

        if (auth()->user()) {
            $bookmarkIds = auth()->user()->bookmarks()->pluck('paste_id')->toArray();
        }

        return view('front.paste-detail', compact('paste', 'data', 'bookmarkIds'));
    }

    public function addViewedCount($id)
    {
        $paste = Paste::findOrFail($id);
        $paste->viewed_count = $paste->viewed_count + 1;
        $paste->save();

        return response()->json($paste->viewed_count);
    }

    public function search(Request $request)
    {
        if ($q = $request->q) {
            $vars = $this->popularAndBookmarkIds();

            $popular = $vars['popular'];
            $bookmarkIds = $vars['bookmarkIds'];

            $data = Paste::where("title", "like", "%$q%")
                ->where('privacy', 'public')
                ->latest()
                ->get();

            return view('front.paste-index', compact('data', 'popular', 'bookmarkIds'));
        }

        return redirect()->route('batch.index');
    }

    private function popularAndBookmarkIds()
    {
        $popular = Paste::where('privacy', 'public')
            ->where('viewed_count', '>=', 10)
            ->orderBy('viewed_count', 'desc')
            ->get()
            ->take(3);

        $bookmarkIds = null;

        if (auth()->user()) {
            $bookmarkIds = auth()->user()->bookmarks()->pluck('paste_id')->toArray();
        }

        return [
            'popular' => $popular,
            'bookmarkIds' => $bookmarkIds,
        ];
    }
}
