<?php

use Illuminate\Database\Seeder;

class InitialUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
            'nama'       => 'User Inisial',
            'username'   => 'InitialUser',
            'password'   => bcrypt('InitialPassword'),
            'email'      => 'faruq.rahmadani@gmail.com',
            'tipe'       => 1,
            'sekolah_id' => 01012011,
        ]);
    }
}
