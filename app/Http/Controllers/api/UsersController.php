<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UsersController extends Controller
{
  /**
   * Display a listing of the resource.
   */

  public function settings()
  {
    $settings = Settings::getSettings();
    return response()->json($settings);
  }

  public function configs()
  {
    $authUser = Auth::user();
    $id = $authUser->id;
    $userInternet = $authUser->internet_type;
    $configs = Config::leftJoin('users', 'configs.assigned_to', '=', 'users.id')
      ->where(function ($query) use ($id) {
        $query->where('users.id', $id)
          ->orWhereNull('configs.assigned_to');
      })
      ->where('configs.active', "true")
      ->where('configs.internet_type', $userInternet)
      ->select('configs.id', 'configs.title', 'configs.internet_type', 'configs.config', 'configs.order')
      ->get();
    // Log::alert("Initial user: " . $EauthUser->toJson());
    // Log::alert("Initial configs: " . $configs->toJson());
    $configs = $configs->sortBy('order');
    $configsArray = $configs->values()->toArray();
    // Log::alert("userInternet : ".print_r($configsArray, true));
    return response()->json($configsArray);
  }

  public function user(Request $request)
  {
    try{
      $user = Auth::user();
      if ($user->status != "active") {
        return response()->json(['message' => 'Your account is not active.'], 403);
      }
      $user->token = str_replace('Bearer ', '', $request->header()['authorization'][0]);
  
      $startDate = Carbon::parse($user->start_sub_date);
      $endDate = $startDate->copy()->addDays($user->sub_days);
      $now = Carbon::now();
      $remainingMilliseconds = $now->diffInMilliseconds($endDate, false);
  
      $user->remaining_milliseconds = $remainingMilliseconds;
      return response()->json($user);
    }catch(\Exception $e){
      $user->decrementActiveSessions();
      return response()->json(['message' => 'Session is not active'], 403);
    }
    
  }
  public function getClientSecret($clientId)
  {
    $client = DB::table('oauth_clients')->where('id', $clientId)->first();
    if ($client) {
      return $client->secret;
    }
    return null;
  }
  public function login(Request $request)
  {
    $request->validate([
      'username' => 'required|string',
      'password' => 'required|string',
    ]);

    $user = User::where('username', $request->username)->first();
    if ($user) {
      if (!isset($user->status)) {
        $user->status = 'active';
      }
      if ($user->status != "active") {
        return response()->json(['message' => 'Your account is not active.'], 403);
      }
      if (!$user || $request->password !== $user->password) {
        return response()->json(['error' => 'Unauthorized'], 403);
      }

      $token = $user->createToken('Personal Access Token')->accessToken;
      $startDate = Carbon::parse($user->start_sub_date);
      $endDate = $startDate->copy()->addDays($user->sub_days);
      $now = Carbon::now();
      $remainingMilliseconds = $now->diffInMilliseconds($endDate, false);

      if ($remainingMilliseconds > 0) {
        if (!$user->incrementActiveSessions()) {
          return response()->json(['error' => 'Maximum active sessions reached'], 403);
        }
      }
      $user->remaining_milliseconds = $remainingMilliseconds;
      $user->token = $token;
      return response()->json($user);
    }else{
      return response()->json(['error' => 'Not Found'], 401);
    }
  }
  public function logout(Request $request)
  {
    $user = Auth::user();
    if (!$user) {
      return response()->json(['error' => 'Not authenticated'], 401);
    }

    // Find and revoke all tokens for the user
    $tokenString = $request->bearerToken();

    if ($tokenString) {
      $config = Configuration::forSymmetricSigner(
        new \Lcobucci\JWT\Signer\Hmac\Sha256(),
        InMemory::base64Encoded($this->getClientSecret(1))
      );

      $parser = $config->parser();
      $token = $parser->parse($tokenString);
      $tokenId = $token->claims()->get('jti');

      $tokenInstance = $user->tokens()->where('id', $tokenId)->first();
      if ($tokenInstance) {
        $tokenInstance->revoke();
      }
    }


    $user->decrementActiveSessions();

    return response()->json(['message' => 'Successfully logged out']);
  }

  public function index()
  {
    // $settings = Settings::getSettings();
    // return response()->json($settings);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {

  }
}
