<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Account;
use Faker\Generator as Faker;

use Illuminate\Support\Str;


class AcccountTest extends TestCase
{

    /** @test */
    public function test_create_account()
    {
        $faker = new Faker();
        $accountIndividual = [
            "accountType" => "individual",
            "name" => $faker->name(),
            "email" => $faker->unique()->safeEmail,
            "address" => "itahari",
            "contactNumber" =>$faker->numerify('98########') ,
            "dueLimit" => "100"
        ];
        $accountReatiler = [
            "accountType" => "retailer",
            "name" => "megha dhakal",
            "email" => "meghadhakal5@gmail.com",
            "address" => "itahari",
            "contactNumber" => "9816798262",
            "dueLimit" => "100",
            "pan" => "98113128",
        ];

        $this->json('POST', 'api/account/createAccount', $accountIndividual, [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer 1|JR4pagvhLqxnjC7OKqhoT7lJjXkgqaqWq0CP5gJZ',
        ])->assertStatus(201);

        // $this->json('POST', 'api/account/createAccount', $accountReatiler, [
        //     'Accept' => 'application/json',
        //     'Authorization' => 'Bearer 1|JR4pagvhLqxnjC7OKqhoT7lJjXkgqaqWq0CP5gJZ',
        // ])->assertStatus(201);
    }

    // public function test_update_account()
    // {
    //     $account  = Account::last();
    //     $accountIndividual = [
    //         "accountType" => "individual",
    //         "name" => "rajan dhakal",
    //         "email" => "sanamdhakal5@gmail.com",
    //         "address" => "itahari",
    //         "contactNumber" => "9815934562",
    //         "dueLimit" => "500"
    //     ];
    //     $accountReatiler = [
    //         "accountType" => "retailer",
    //         "name" => "megha dhakal",
    //         "email" => "meghadhakal5@gmail.com",
    //         "address" => "itahari",
    //         "contactNumber" => "9819318262",
    //         "dueLimit" => "100",
    //         "pan" => "98113128",
    //     ];
    //     $this->json('POST', 'api/updateAccount/' + $account->id, $accountIndividual, [
    //         'Accept' => 'application/json',
    //         'Authorization' => 'Bearer 1|JR4pagvhLqxnjC7OKqhoT7lJjXkgqaqWq0CP5gJZ',
    //     ])->assertStatus(201);
    //     $this->json('POST', 'api/updateAccount/' + $account->id, $accountReatiler, [
    //         'Accept' => 'application/json',
    //         'Authorization' => 'Bearer 1|JR4pagvhLqxnjC7OKqhoT7lJjXkgqaqWq0CP5gJZ',
    //     ])->assertStatus(201);
    // }
}
