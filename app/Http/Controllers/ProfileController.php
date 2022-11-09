<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getProfile($id){
        $user = User::where('id', $id)->get();
       // return response($user[0]);
       return view('profile.index', ['user' => $user[0]]);
        //return view('profile.index', ['user' => $user]);
        //return response($user);
        //dd($user) ; //for testing purposes
    }

    public function editProfile($id){
        $user = User::where('id', $id)->get();
        return view('profile.edit', ['user' => $user[0]]);
        //return response($user);
        //dd($user) ; //for testing purposes
    }

    public function updateProfile(Request $req, $id){

        //dd($req->file('avatar'));
        $validator = Validator::make($req->all(), [
            'username' => 'required|max:191',
            'email' => 'required|email|max:191',
            'avatar' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048',
        ], [
            'role.required' => 'Role is required.'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }else{
                    
        $user = User::find($id);
        if($user)
        {
            if(!is_null($req->input('about'))){
                $user->aboutme = $req->input('about');
            }

            $avatarPath = null;
            if ($req->hasFile('avatar')) {
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
        
    }
}
