<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Tao thong bao thanh cong khi edit
        $notification = array(
            'message' => 'User Logout Successfully!',
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
    }

    public function Profile(){
        //Lay id cua nguoi dung khi dang nhap da xac thuc
        $id = Auth::user()->id;
        //Lay database trong bang User
        $adminData = User::find($id);
        // echo $id;
        // echo $adminData;
        return view('admin.admin_profile_view', compact('adminData'));

    }

    public function EditProfile(){
        //Lay id cua nguoi dung khi dang nhap da xac thuc
        $id = Auth::user()->id;
        //Lay database trong bang User
        $editData = User::find($id);
        // echo $id;
        // echo $adminData;
        return view('admin.admin_profile_edit', compact('editData'));
    }

    public function storeProfile(Request $request){
        //Lay id cua nguoi dung khi dang nhap da xac thuc
        $id = Auth::user()->id;
        //Lay database trong bang User
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->username = $request->username;

        if ($request->file('profile_image')){
            $file = $request->file('profile_image');

            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            // gan cot profile image trong database = file name
            $data['profile_image'] =  $filename;

        }

        $data->save();

        // Tao thong bao thanh cong khi edit
        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('admin.profile')->with($notification);
    }

    public function changePassword(){
        return view('admin.admin_change_password');
    }

    public function updatePassword(Request $request){
        //validate bat phai nhap cac truong vao 
        $validateData = $request ->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            //same:newpassword de confirm phai giogn cai newpass
            'confirm_password' => 'required|same:newpassword',

        ]);
        //Kiem tra xem mat khau cu co khop khong
        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->oldpassword, $hashedPassword)){
            $users = User::find(Auth::id());
            $users->password = bcrypt($request->newpassword);
            $users->save();

            
        session()->flash('message', 'Password Updated Successfully');
        return redirect()->back();
        }
        //Neu k khop
        else{
            
            session()->flash('message', 'Old password is not match');
            return redirect()->back();
        }

    }


}
