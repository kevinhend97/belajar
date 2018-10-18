<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Redirect;
use App\Http\Requests\UpdateProfile;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //
     public function edit($id)
    {
    	$data = User::find($id);
    	return view('profile.profile',compact('data'));
    }

    public function update(UpdateProfile $request, $id)
    {

        //$this->validate($request, $this->aturan);

        $profile = User::find($id);
        $current_password = Auth::user()->password;

        //handle the user upload
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/avatar');
            $avatar->move($destinationPath, $filename);
            
            $profile->avatar = $filename;    
        }

        //bagian ganti password
        if(Hash::check($request['current_password'], $current_password))//untuk memecah password yang di lock
        {
            $profile->password = Hash::make($request['password']); // untuk membuat lock passw                   
        }

        //bagian update data name, username,dan email
        $profile->name = $request['name'];
        $profile->username = $request['username'];
        $profile->email = $request['email'];
        $profile->no_telp = $request['no_telp'];
        $profile->update();
        return redirect()->back()->with('alert', 'Proses Ubah Sukses!');
    }
}
