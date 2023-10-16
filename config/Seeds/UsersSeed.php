<?php

declare(strict_types=1);

use Migrations\AbstractSeed;

require_once 'vendor/autoload.php';

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
{
    public function run(): void
    {

        $faker = Faker\Factory::create();
        for ($i = 0; $i < 20; $i++) {
            # code...
            $username = $faker->lastName();
            $email = $faker->email();
            $data[] = [
                'username' => $username,
                'email' => $email
            ];
        }

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
