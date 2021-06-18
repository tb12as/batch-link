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
    public function index(Request $request)
    {
        return [
            'pastes' => PasteResource::collection(
                Paste::when($request->boolean('with-links'), fn ($q) => $q->with('links'))
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->get()
            )
        ];
    }

    public function store(PasteRequest $request)
    {
        $paste = $this->storePaste($request->title);

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

        return response()->json(['message' => 'Paste deleted', 'slug' => $paste->slug]);
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

    public function storeWithoutLinks(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        return new PasteResource($this->storePaste($request->title));
    }

    private function generateSlug(string $title): string
    {
        return Str::slug(Str::words($title, 3, '') . '-' . uniqid());
    }

    private function storePaste(string $title)
    {
        $paste = Paste::create([
            'user_id' => Auth::id(),
            'title' => $title,
            'slug' => $this->generateSlug($title),
        ]);

        return $paste;
    }
}
