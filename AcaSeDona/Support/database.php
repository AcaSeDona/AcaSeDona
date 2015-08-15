<?php

use Illuminate\Database\Capsule\Manager as Capsule;

// load dotenv
$dotenv = new Dotenv\Dotenv(__DIR__ . '/../../');
$dotenv->load();

$capsule = new Capsule;

$mysql_config = array(
    'host'      => getenv('DB_HOST'),
    'driver'    => 'mysql',
    'database'  => getenv('DB_DATABASE'),
    'username'  => getenv('DB_USER'),
    'password'  => getenv('DB_PASS'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => getenv('DB_PREFIX'),
);

$sqlite_config = array(
    'driver'   => 'sqlite',
    'database' => __DIR__ . '/database.sqlite',
    'prefix'   => '',
);

// database connection
$capsule->addConnection($mysql_config);
$capsule->setAsGlobal();
$capsule->bootEloquent();


// use this only when creating/updating tables
$create_tables = false;

if ($create_tables)
{
    Capsule::schema()->create('places', function ($table)
    {
        $table->increments('id');
        $table->string('name');
        $table->string('slug');
        $table->text('address');
        $table->decimal('lat', 8, 6); // 90 to -90
        $table->decimal('long', 9, 6); // 180 to -180
        $table->string('start_hour')->nullable();
        $table->string('end_hour')->nullable();
        $table->string('days')->nullable();
        $table->text('comments')->nullable();
        $table->boolean('confirmed')->default(1);
        $table->string('googl');
        $table->timestamps();
    });
}
