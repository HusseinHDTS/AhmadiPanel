<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigRequest;
use App\Models\Config;
use Illuminate\Http\Request;

class ConfigsController extends Controller
{
  /**
   * Display a listing of the resource.
   */

  public function create(ConfigRequest $request)
  {
    return Config::create($request->all());
  }

  public function index()
  {
    $configs = Config::with('user')->orderBy('order')->get();
    return response()->json([
      'data' => $configs->map(function ($config) {
        return $config;
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
    // if (Auth::user()->id == $id) {
    //   return response()->json(['message' => 'YOU CANT DELETE YOUR SELF!!!'], 403);
    // }
    // DB::beginTransaction();
    // try {
    //   $admin = Admin::find($id);
    //   if ($admin) {
    //     $invoices = InvoiceList::where('owner_id', $id)->get();
    //     $admin->delete();
    //     foreach ($invoices as $invoice) {
    //       ChangeLogsController::logChanges($invoice, $invoice->toArray(), Auth::user()->id, false, true);
    //       foreach ($invoice->invoiceDetails as $productDetail) {
    //         ChangeLogsController::logChanges($productDetail, $productDetail->toArray(), Auth::user()->id, false, true);

    //         $productDetail->delete();
    //       }
    //       $invoice->delete();
    //     }
    //     DB::commit();
    //     return response()->json(['message' => 'Admin removed successfully'], 200);
    //   } else {
    //     return response()->json(['message' => 'Admin not found'], 404);
    //   }
    // } catch (\Exception $e) {
    //   DB::rollBack();
    //   return response()->json(['message' => 'Error deleting invoices and product details.', 'error' => $e->getMessage()], 500);
    // }

  }
}
