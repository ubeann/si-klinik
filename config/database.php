<?php

namespace App\Config;

/**
 * Database configuration file.
 *
 * This file returns an array of configuration settings used to connect to the MySQL database.
 * The settings include the host, database name, username, password, and character set.
 */

return [
    // The hostname or IP address of the database server.
    'host' => 'localhost',

    // The name of the specific database to connect to.
    'dbname' => 'clinic',

    // The username for connecting to the database.
    'username' => 'root',

    // The password for the above username.
    'password' => '12345678',

    // The character set used for the database connection, ensuring proper encoding of characters.
    'charset' => 'utf8mb4'
];
