<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;

class EcommerceDashboard extends Controller
{
  public function index()
  {
    $settings = Settings::getSettings();
    return view('content.apps.app-dashboard',compact('settings'));
  }

  public function update(Request $request){
    $setting = Settings::getSettings();
    $settings_data = $request->all();
    if(isset($settings_data['allow_insecure']) && $settings_data['allow_insecure'] == "on"){
      $settings_data['allow_insecure'] = 1;
    }else{
      $settings_data['allow_insecure'] = 0;
    }

    if(isset($settings_data['enable_mux']) && $settings_data['enable_mux'] == "on"){
      $settings_data['enable_mux'] = 1;
    }else{
      $settings_data['enable_mux'] = 0;
    }

    if(isset($settings_data['enable_fragment']) && $settings_data['enable_fragment'] == "on"){
      $settings_data['enable_fragment'] = 1;
    }else{
      $settings_data['enable_fragment'] = 0;
    }

    if(isset($settings_data['prefer_ipv6']) && $settings_data['prefer_ipv6'] == "on"){
      $settings_data['prefer_ipv6'] = 1;
    }else{
      $settings_data['prefer_ipv6'] = 0;
    }
    $setting->update($settings_data);
    return redirect('/')->with('success', 'تنظیمات ویرایش شد');
  }

}
