<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
  use HasFactory;
  protected $table = 'configs';

  protected $fillable = ['order','title', 'internet_type','active', 'assigned_to', 'config'];

  // If 'config' is stored as JSON in a text field
  public function getConfigAttribute($value)
  {
    return json_decode($value, true);
  }

  public function setConfigAttribute($value)
  {
    $this->attributes['config'] = json_encode($value);
  }
  public function user()
  {
    return $this->belongsTo(User::class, 'assigned_to')->select('id','username');
  }
}
