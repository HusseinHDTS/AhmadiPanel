<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FileUploadController extends Controller
{
  public function upload(Request $request)
  {
    if ($request->hasFile('file')) {
      // Handle file upload
      $file = $request->file('file');
      $path = $file->store('uploads', 'public'); // Store file in storage/app/public/uploads
      // Optionally, return the file path
      return response()->json(['file_path' => '/storage/' . $path]);
    }
    return response()->json(['error' => 'File upload failed'], 500);

  }
}
