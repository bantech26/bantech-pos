<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    //Get Member
    public function getMember($id){
        $member = Member::where('no_member',$id)
                  ->orWhere('name', 'like', "%$id%")
                  ->orWhere('handphone', 'like', "%$id%")
                  ->first();
        if($member){
            return response()->json($member);
        }

        return response()->json(['message','Data Member Tidak Di Temukan!'], 404);
    }
}
