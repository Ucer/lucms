<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 初始化用户角色，将 1 号用户指派为『站长』
        $user = \App\Models\User::find(1);
        $user->assignRole('Founder');
    }
}
