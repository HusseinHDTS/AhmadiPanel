<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigRequest;
use App\Models\Config;
use Illuminate\Http\Request;

class ConfigList extends Controller
{

  public function create(ConfigRequest $request)
  {
    Config::create($request->all());
    return redirect()->route('app-config-list');

  }
  public function delete($id)
  {
    $message = "";
    $type = "success";
    $config = Config::find($id);
    if ($config) {
      $message = "کانفیگ حذف شد";
      $config->delete();
    } else {
      $type = "error";
      $message = "کانفیگ وجود ندارد";
    }
    return redirect()->route('app-config-list')->with($type, $message);
  }
  public function toggle($id)
  {
    $message = "";
    $type = "success";
    $config = Config::find($id);
    if ($config) {
      if ($config->active == "true") {
        $message = "کانفیگ غیرفعال شد";
        $config->active = "false";
      } else {
        $message = "کانفیگ فعال شد";
        $config->active = "true";
      }
      $config->save();
    } else {
      $type = "error";
      $message = "کانفیگ وجود ندارد";
    }
    return redirect()->route('app-config-list')->with($type, $message);
  }
  public function show($id)
  {
    $config = Config::findOrFail($id);
    $config->load('user');
    return view('content.apps.app-config-edit', compact('config'));
  }
  public function edit(ConfigRequest $request, $id)
  {
    $config = Config::findOrFail($id);
    if($config){
      $config->update($request->all());
    }
    return redirect()->route('app-config-list')->with('success', 'کانفیگ ویرایش شد');
  }
  public function index()
  {
    return view('content.apps.app-config-list');
  }
}
