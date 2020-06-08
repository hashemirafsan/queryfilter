<?php

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'   => 'sqlite',
    'database' => __DIR__ . '/database.sqlite',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

// Drop table migration
Capsule::schema()->dropIfExists('dummies');

// create table migration
Capsule::schema()->create('dummies', function (Blueprint $table) {
    $table->increments('id');
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email');
});

// seed data
foreach ( range(1, 10) as $i ) {
    Dummy::create([
        'first_name' => 'First Name of',
        'last_name'  => 'Admin' . $i,
        'email'      => "admin$i@example.com",
    ]);

}
