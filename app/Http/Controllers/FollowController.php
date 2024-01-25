<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    //
    public function createFollow(User $user)
    {
        //you cant follow yourself 
        if ($user->id == auth()->user()->id) {
            return back()->with('failure', 'you cannot fallow yourself');
        }
        //you cant follow someone you alredy follow
        $existChech = Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->count();
        if ($existChech) {
            return back()->with('failure', 'you alredy follow this user');
        }

        $newFollow = new Follow;
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followeduser = $user->id;
        $newFollow->save();
        return back()->with('success', 'user succesfully followed');
    }

    public function removeFollow(User $user)
    {
        Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->delete();

        return back()->with('success', 'User succesfully unfollowed');
    }
}
