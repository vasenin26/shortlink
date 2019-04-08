<?php

namespace App\Http\Controllers;

use App\ShortLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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

    public function decode($code){

        $shortLink = ShortLink::findByCode($code);

        ShortLink::whereId($shortLink->id)->update(['counter' => DB::raw('counter + 1')]);

        return response()->redirectTo($shortLink->origin, 301);

    }
}
