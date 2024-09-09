<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class UserViewAccount extends Controller
{

  public function update(Request $request,$id){
    $admin = Admin::with(['roles'])->findOrFail($id);
    $admin->password = bcrypt($request['password']);
    $admin->save();
    return redirect()->route('app-user-view-account',['id'=>$id]);
  }

  public function index($id)
  {
    $admin = Admin::with(['roles'])->findOrFail($id);
    return view('content.apps.app-user-view-account', compact('admin'));
  }
}