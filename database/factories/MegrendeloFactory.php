<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Megrendelo;
use Faker\Generator as Faker;


$factory->define(Megrendelo::class, function (Faker $faker) {
    $huFaker = new \Faker\Generator();
    $huFaker->addProvider(new \Faker\Provider\hu_HU\Person($faker));
    $huFaker->addProvider(new \Faker\Provider\hu_HU\PhoneNumber($faker));
    $huFaker->addProvider(new \Faker\Provider\hu_HU\Address($faker));

    return [
        'nev' => generateHunName($faker->numberBetween(0,1),$faker->numberBetween(0,1),$huFaker),
        'telefonszam' => $huFaker->phoneNumber,
        'szallitasi_cim' => $huFaker->address,
        'szepkartya' => $faker->numberBetween(0,1),
        'kiszallito_id' => App\User::where('munkakor', 'Kiszállító')->inRandomOrder()->first()->id,
    ];
});

function generateHunName($isMale, $hasTitle, $huFaker) 
{   
    $name = "";

    if($hasTitle) {
        $name.=$huFaker->title." ";
    }

    if($isMale) {
        $name.=$huFaker->firstNameMale." ";
    }
    else {
        $name.= $huFaker->numberBetween(0,10) > 3 ? $huFaker->firstNameFemale." " : $huFaker->firstNameMaleNe." ";
    }

    $name.=$huFaker->lastName;

    return $name;
}
