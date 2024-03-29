<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirectView($hash)
    {
        try {
            $link = Link::with('paste')->where('hash', $hash)->firstOrFail();
            // store 'visited' before redirect here 
            return view('redirect', compact('link'));
        } catch (\Throwable $th) {
            return response()->view('errors.link-404', [], 404);
        }
    }

    public function getOriginalLink($hash, Request $request)
    {
      if(! $request->expectsJson()) {
        return redirect()->route('redirect', $hash);
      }

      $link = Link::where('hash', $hash)->firstOrFail();
      return response()->json($link->original_link);
    }
}
