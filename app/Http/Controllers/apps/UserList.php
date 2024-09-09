<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserList extends Controller
{
  public function index()
  {
    $users_count = number_format(User::count());
    return view('content.apps.app-user-list', compact('users_count'));
  }
  public function edit($id)
  {
    $user = User::findOrFail($id);
    return view('content.apps.app-user-edit', compact('user'));
  }
  public function update(Request $request, $id)
  {
    $user = User::findOrFail($id);
    $userData = $request->all();
    if ($userData['sub_days'] != $user->sub_days) {
      $userData['start_sub_date'] = now();
    }
    $user->update($userData);
    return redirect()->route('app-user-list')->with('success', 'کاربر ویرایش شد');
  }
  public function toggle($id)
  {
    $user = User::findOrFail($id);
    if ($user->status == "active") {
      $user->status = "deActive";
    } else {
      $user->status = "active";
    }
    $user->save();
    return redirect()->route('app-user-list')->with('success', 'وضعیت کاربر تغییر کرد');
  }
  public function create(Request $request)
  {
    $existingUser = User::where('username', $request->input('username'))->first();

    if (!$existingUser) {
      // If no user exists with that username, create the new user
      $request['start_sub_date'] = now();
      User::create($request->all());

      // Return success response or do other logic here
      return redirect()->route('app-user-list')->with('success', 'کاربر ایجاد شد');
    } else {
      // If the user already exists, return an error response
      return redirect()->route('app-user-list')->with('error', 'کاربر با این نام کاربری وجود دارد');
    }
  }
  public function resetVolume($id)
  {
    $user = User::findOrFail($id);
    $user->current_volume = 0;
    $user->save();
    return redirect()->route('app-user-list')->with('success', 'حجم تمدید شد');
  }
  public function resetDays($id)
  {
    $user = User::findOrFail($id);
    $user->start_sub_date = now();
    $user->tokens()->where('name', 'Personal Access Token')->where('user_id', $id)->delete();
    $user->active_sessions = 0;
    $user->save();
    return redirect()->route('app-user-list')->with('success', 'اعتبار تمدید شد');
  }
  public function delete($id)
  {
    $user = User::findOrFail($id);
    if ($user) {
      $token = $user->tokens()->where('name', 'Personal Access Token')->where('user_id', $id)->delete();
      $user->delete();
    }
    return redirect()->route('app-user-list');
  }
  public function removeActiveSessions($id)
  {
    $user = User::findOrFail($id);
    if ($user) {
      $token = $user->tokens()->where('name', 'Personal Access Token')->where('user_id', $id)->delete();
      $user->active_sessions = 0;
      $user->save();
    }
    return redirect()->route('app-user-list');
  }
}
