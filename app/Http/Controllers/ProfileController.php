<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getProfile($id){
        $user = User::where('id', $id)->get();
       return view('profile.index', ['user' => $user[0]]);

    }

    public function editProfile($id){
        $user = User::where('id', $id)->get();
        return view('profile.edit', ['user' => $user[0]]);
        //dd($user) ; //for testing purposes
    }

    public function updateProfile(Request $req, $id){

        //dd($req->file('avatar'));
        $req->validate([
            'username' => 'required|max:191|string',
            'email' => 'required|email|max:191',
            'avatar' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048',
            'about' => 'string|nullable'
        ]);

        $user = User::find($id);
        if($user)
        {
            if(!is_null($req->input('about'))){
                $user->aboutme = $req->input('about');
            }

            $avatarPath = null;
            if ($req->hasFile('avatar')) {
                //stores the files in avatars folder as "userId" . extension file in storage/app/public
                $avatarPath = $req->file('avatar')->storeAs(
                    'avatars',
                    Auth::id() . '.' . $req->file('avatar')->getClientOriginalExtension(),
                    'public',
                );
                $user->avatar = $avatarPath;
            }
            if(!is_null($req->input('bdate'))){
                $user->bdate = $req->input('bdate');
            }

            $user->name = $req->input('username');
            $user->email = $req->input('email');
            $user->update();
            return redirect(route('profile', $user->id));
        }        
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'A problem occured while trying to update.'
            ]);
        }
        
    }

    public function settingsView($id){
        $user = User::where('id', $id)->get();
        return view('profile.account', ['user' => $user[0]]);
        //return response($user);
        //dd($user) ; //for testing purposes
    }

    public function updateAccount(Request $req){
        $req->validate([
            'username' => 'required|max:191|string',
            'opassw' => 'required|string',
            'npassw' => 'required|string',
            'cpassw' => 'required|string|same:npassw',

        ]);

        $user = User::find($req->user_id);
        $hashedPassword = $user->password;
            if (Hash::check($req->opassw, $hashedPassword)) {//checks if hash of plain text equals a certain hash
                $user->password = Hash::make($req->npassw);
                $user->update();
                return redirect(route('profile', $user->id));
            }else{
                return response()->json([
                    'status'=>406,
                    'message'=>'Wrong old password!'
                ]);
            }
        
    }
}
