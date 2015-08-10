<?php
 
class UserTableSeeder extends Seeder {
 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
                'username'   => 'zach',
                'email'      => 'test@aol.com',
                'password'   => Hash::make('test'),
                'first_name' => 'Zach',
                'last_name'  => 'Firestone',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]);

        DB::table('users')->insert([
                'username'   => 'jake',
                'email'      => 'jake@aol.com',
                'password'   => Hash::make('test'),
                'first_name' => 'Jake',
                'last_name'  => 'Firestone',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]);
    }
 
}