<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'App\\Models\\Database\\Lunch' => $baseDir . '/app/models/database/Lunch.php',
    'App\\Models\\Database\\Restaurant' => $baseDir . '/app/models/database/Restaurant.php',
    'App\\Models\\Database\\User' => $baseDir . '/app/models/database/User.php',
    'App\\Models\\Lunch' => $baseDir . '/app/models/Lunch.php',
    'App\\Models\\Restaurant' => $baseDir . '/app/models/Restaurant.php',
    'BaseController' => $baseDir . '/app/controllers/BaseController.php',
    'CreateFriendsTable' => $baseDir . '/app/database/migrations/2015_03_08_005307_create_friends_table.php',
    'CreateLunchesTable' => $baseDir . '/app/database/migrations/2015_03_08_010929_create_lunches_table.php',
    'CreateRestaurantsTable' => $baseDir . '/app/database/migrations/2015_03_08_012149_create_restaurants_table.php',
    'CreateUsersTable' => $baseDir . '/app/database/migrations/2015_03_07_171152_create_users_table.php',
    'DatabaseSeeder' => $baseDir . '/app/database/seeds/DatabaseSeeder.php',
    'HomeController' => $baseDir . '/app/controllers/HomeController.php',
    'IlluminateQueueClosure' => $vendorDir . '/laravel/framework/src/Illuminate/Queue/IlluminateQueueClosure.php',
    'LunchController' => $baseDir . '/app/controllers/LunchController.php',
    'RestaurantController' => $baseDir . '/app/controllers/RestaurantController.php',
    'SessionHandlerInterface' => $vendorDir . '/symfony/http-foundation/Symfony/Component/HttpFoundation/Resources/stubs/SessionHandlerInterface.php',
    'TestCase' => $baseDir . '/app/tests/TestCase.php',
    'User' => $baseDir . '/app/models/User.php',
    'UserController' => $baseDir . '/app/controllers/UserController.php',
    'UserTableSeeder' => $baseDir . '/app/database/seeds/UserTableSeeder.php',
    'Whoops\\Module' => $vendorDir . '/filp/whoops/src/deprecated/Zend/Module.php',
    'Whoops\\Provider\\Zend\\ExceptionStrategy' => $vendorDir . '/filp/whoops/src/deprecated/Zend/ExceptionStrategy.php',
    'Whoops\\Provider\\Zend\\RouteNotFoundStrategy' => $vendorDir . '/filp/whoops/src/deprecated/Zend/RouteNotFoundStrategy.php',
);
