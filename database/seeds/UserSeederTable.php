<?php

use Illuminate\Database\Seeder;

class UserSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create('App\User');
        DB::table('customers')->insert([
            'first_name' => $faker->firstName,
            'last_name'=>$faker->lastName,
            'company_name'=>$faker->company,
            'type' =>1,
            'email' => $faker->unique()->safeEmail,
            'status'=>1
        ]);
    }
}
