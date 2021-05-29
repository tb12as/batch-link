<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasteRequest;
use App\Http\Resources\PasteResource;
use App\Models\Paste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PasteController extends Controller
{
    public function index()
    {
        return [
            'pastes' => PasteResource::collection(
                Paste::with('links')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->get()
            )
        ];
    }

    public function store(PasteRequest $request)
    {
        $paste = Paste::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug(Str::words($request->title, 3, '') . '-' . Str::random(10)),
        ]);

        return $this->storeLinks($request->links, $paste);
    }

    public function show(string $slug)
    {
        return new PasteResource(
            Paste::with('links')
                ->where('slug', $slug)
                ->firstOrFail()
        );
    }

    public function update(PasteRequest $request, Paste $paste)
    {
        $paste->update(['title' => $request->title]);

        return $this->storeLinks($request->links, $paste);
    }

    public function destroy(Paste $paste)
    {
        $paste->delete();

        return response()->json(['message' => 'Paste deleted']);
    }

    private function storeLinks(array $links, Paste $paste)
    {
        foreach ($links as $link) {
            $paste->links()->updateOrCreate(['id' => $link['link_id'] ?? null], [
                'user_id' => Auth::id(),
                'title' => $link['title'],
                'hash' => md5(microtime()),
                'original_link' => $link['original_link']
            ]);
        }

        return new PasteResource(Paste::with('links')->find($paste->id));
    }
}
