<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
//		Model::unguard();

		// $this->call('UserTableSeeder');
//		 $this->call('ProductSeeder');

		if (App::environment() === 'production') {
			exit('I just stopped you getting fired. Love Luca');
		}

		Eloquent::unguard();

		$this->call('ClientsTableSeeder');
		$this->call('GrantsTableSeeder');
		$this->call('ScopesTableSeeder');
		$this->call('SessionsTableSeeder');
		$this->call('AuthCodesTableSeeder');
		$this->call('AccessTokensTableSeeder');
		$this->call('RefreshTokensTableSeeder');
	}

}
