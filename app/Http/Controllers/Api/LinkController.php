<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LinkRequest;
use App\Http\Resources\LinkResource;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexold(Request $request)
    {
        $links = $request->user()
            ->pastes()
            ->with('links')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get()
            ->pluck('links')
            ->toArray();

        $link2 = array_merge([], ...$links); // i don't know about this before
        $link3 = json_decode(json_encode($link2));
        return ['links' => LinkResource::collection($link3)];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ['links' => LinkResource::collection($this->getUserLinks())];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LinkRequest $request)
    {
        $link = Link::create($request->validated() + [
            'hash' => md5(microtime()),
            'user_id' => Auth::id(),
        ]);

        return new LinkResource($link);
    }

    /**
     * Display the specified resource.
     *
     * @param  $hash
     * @return \Illuminate\Http\Response
     */
    public function show($hash)
    {
        $link = $this->getSingleLink($hash);
        return new LinkResource($link);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $hash
     * @return \Illuminate\Http\Response
     */
    public function update(LinkRequest $request, $hash)
    {
        $link = $this->getSingleLink($hash);
        $link->update([
            'title' => $request->title,
            'original_link' => $request->original_link,
        ]);

        return new LinkResource($link);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $hash
     * @return \Illuminate\Http\Response
     */
    public function destroy($hash)
    {
        $link = $this->getSingleLink($hash);
        $link->delete();

        return response()->json(['message' => 'Link deleted']);
    }

    private function getUserLinks()
    {
        return Link::where('user_id', Auth::id())->latest()->get();
    }

    private function getSingleLink($hash)
    {
        return Link::where(['user_id' => Auth::id(), 'hash' => $hash])->firstOrFail();
    }
}
