<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Config;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'internet_type',
    'username',
    'password',
    'active_sessions',
    'max_active_session',
    'start_sub_date',
    'sub_days',
    'max_volume',
    'current_volume',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'remember_token',
  ];
  public function incrementActiveSessions()
  {
    if ($this->active_sessions < $this->max_active_session) {
      $this->active_sessions++;
      $this->save();
      return true;
    }
    return false;
  }

  public function decrementActiveSessions()
  {
    if ($this->active_sessions > 0) {
      $this->active_sessions--;
      $this->save();
      return true;
    }
    return false;
  }
  public function configs()
  {
    return $this->hasMany(Config::class, 'assigned_to');
  }

}
