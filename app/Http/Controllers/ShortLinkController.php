<?php

namespace App\Http\Controllers;

use App\ShortLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShortLinkController extends Controller
{
    public function encode(Request $request){

        $validator = Validator::make($request->all(), [
            'q' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Target link is require'
            ], 412);
        }


        $shortLink = ShortLink::create(['origin' => $request->input('q')]);

        return response()->json([
            'id' => $shortLink->id,
            'link' => route('decoder', $shortLink->getLinkCode())
        ]);

    }
}
