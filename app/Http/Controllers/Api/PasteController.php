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
        return PasteResource::collection(
            Paste::when($request->boolean('with-links'), fn ($q) => $q->with('links'))
                ->where('user_id', Auth::id())
                ->latest()
                ->paginate(10)
                ->onEachSide(1)
        );
    }

    public function store(PasteRequest $request)
    {
        $paste = Paste::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'privacy' => $request->privacy,
            'slug' => Str::slug(Str::words($request->title, 3, '') . '-' . uniqid()),
        ]);

        return $this->storeLinks($request->links, $paste);
    }

    public function show(string $slug)
    {
        return new PasteResource(
            Paste::with('links')
                ->where(['slug' => $slug, 'user_id' => Auth::id()])
                ->firstOrFail()
        );
    }

    public function update(PasteRequest $request, Paste $paste)
    {
        $paste->update([
            'title' => $request->title,
            'description' => $request->description,
            'privacy' => $request->privacy,
            'slug' => $paste->title !== $request->title ? Str::slug(Str::words($request->title, 3, '') . '-' . uniqid()) : $paste->slug,
        ]);

        return $this->storeLinks($request->links, $paste);
    }

    public function destroy(Paste $paste)
    {
        $paste->delete();

        return response()->json(['message' => 'Paste deleted']);
    }

    public function search(Request $request)
    {
        if ($q = $request->q) {
            $pastes = Paste::where('user_id', $request->user()->id)
                ->where("title", "like", "%$q%")
                ->orWhere("privacy", "like", "%$q%")
                ->orWhere("viewed_count", "like", "%$q%")
                ->latest()
                ->get();

            return [
                'data' => PasteResource::collection($pastes),
                'meta' => [
                    'links' => [],
                ]
            ];
        }

        return "you shouldn't send an empty string here dude";
    }

    private function storeLinks(array $links, Paste $paste)
    {
        foreach ($links as $key => $value) {
          if(is_array($value)) {
            $links[$key]['id'] = $value['link_id'] ?? null;
            $links[$key]['paste_id'] = $paste->id;
            $links[$key]['user_id'] = Auth::id();
            $links[$key]['hash'] = md5(microtime());

            unset($links[$key]['link_id']);
          }
        }

        $paste->links()->upsert($links, ['id']);

        return new PasteResource($paste);
    }
}
