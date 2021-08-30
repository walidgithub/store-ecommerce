<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    //
    public function editProfile(){
        $admin = Admin::find(auth('admin')->user()->id);

        return view('dashboard.profile.edit',compact('admin'));
    }

    public function updateProfile(ProfileRequest $request){
        try {

            $admin=Admin::find(auth('admin')->user()->id);

            //if password in request so hash it
            if($request->filled('password')){
                $request->merge(['password'=>bcrypt($request->password)]);
            }

            //exept id field
            unset($request['id']);
            unset($request['password_confirmation']);

            // $admin->update($request->only(['name','email','password']));
            $admin->update($request->all());

            return redirect() -> back() -> with(['success' => 'تم التحديث بنجاح']);
        }catch (\Exception $ex){
            return redirect() -> back() -> with(['error' => 'يوجد خطأ ما يرجي المحاولة فيما بعد']);
        }
    }
}
