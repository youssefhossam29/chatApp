<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    //
    public function chats(){
        $user_id = Auth::id();
        $LoggedUserInfo = User::find($user_id);
        if (!$LoggedUserInfo) {
            return redirect('login')->with('fail', 'You must be logged in to access the dashboard');
        }

        // Retrieve all users
        $users = User::where('id', '!=', $user_id )->get();

        return view('user.chats', [
            'LoggedUserInfo' => $LoggedUserInfo,
            'users' => $users
        ]);
    }

}
