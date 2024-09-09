<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
  use HasFactory;
  protected $table = 'settings';

  protected $fillable = [
    'info',
    'test_url',
    'custom_menu_title',
    'custom_menu_link',
    'version_link',
    'version',
    'allow_insecure',
    'enable_mux',
    'enable_fragment',
    'prefer_ipv6',
  ];

  public static function getSettings()
  {
    // Retrieve the first (and only) record, or create it if it doesn't exist
    return self::firstOrCreate(['id' => 1], []);
  }

}
