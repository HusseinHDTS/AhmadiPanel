<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\InvoiceList;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

class AdminsController extends Controller
{
  /**
   * Display a listing of the resource.
   */

  public function removeExpiredUsers(){
    $users = User::all();

    foreach ($users as $user) {
        // Calculate the subscription expiration date
        $expirationDate = Carbon::parse($user->start_sub_date)->addDays($user->sub_days);

        if (Carbon::now()->greaterThanOrEqualTo($expirationDate)) {
            // Log::error('there are some users expired');
            $user->delete();
        } else {
        }
    }

  }

  public function listUserNames(Request $request)
  {
    $search = $request->input('q');
    $query = User::select('id', 'username');
    if (!empty($search)) {
      $query->where('username', 'LIKE', "%$search%");
    }
    $users = $query->get();

    return response()->json($users);
  }
  public function index()
  {
    $users = User::orderBy('created_at', 'desc')->get();
    return response()->json([
      'data' => $users->map(function ($user) {
        $startDate = Carbon::parse($user->start_sub_date);
        $endDate = $startDate->copy()->addDays($user->sub_days);
        $now = Carbon::now();
        $remainingMilliseconds = $now->diffInMilliseconds($endDate, false);
        $user->remaining_milliseconds = $remainingMilliseconds;
        return $user;
      }),
    ]);
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
