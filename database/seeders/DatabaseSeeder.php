<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // \App\Models\User::factory(10)->create();

    \App\Models\Admin::factory()->create([
      'name' => 'Admin',
      'email' => 'admin@gmail.com',
      'password' => bcrypt('admin@gmail.com'),
    ]);
    \Spatie\Permission\Models\Permission::create(['name' => 'create edit', 'guard_name' => 'admin']);
    \Spatie\Permission\Models\Role::create(['name' => 'admin', 'guard_name' => 'admin']);
    \Spatie\Permission\Models\Role::create(['name' => 'user', 'guard_name' => 'admin']);
    $user = \App\Models\Admin::find(1); // Replace with the appropriate user ID
    $user->assignRole('admin');

    $user->givePermissionTo('create edit');


  }
}
