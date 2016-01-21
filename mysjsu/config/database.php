<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PDO Fetch Style
    |--------------------------------------------------------------------------
    |
    | By default, database results will be returned as instances of the PHP
    | stdClass object; however, you may desire to retrieve records in an
    | array format for simplicity. Here you can tweak the fetch style.
    |
    */

    'fetch' => PDO::FETCH_CLASS,

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'sqlite'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver'   => 'sqlite',
            'database' => database_path('database.sqlite'),
            'prefix'   => '',
        ],

        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', 'localhost'),
            'database'  => env('DB_DATABASE', 'forge'),
            'username'  => env('DB_USERNAME', 'forge'),
            'password'  => env('DB_PASSWORD', ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],

        'pgsql' => [
            'driver'   => 'pgsql',
            'host'     => env('DB_HOST', 'localhost'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ],

        'sqlsrv' => [
            'driver'   => 'sqlsrv',
            'host'     => env('DB_HOST', 'localhost'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset'  => 'utf8',
            'prefix'   => '',
        ],


         // Obp/laravel-odbc-db2
        'odbc' => [
            'driver'         => 'odbc',
            'host'           => env('DB2_HOST', 'localhost'),
            'database'       => env('DB2_DATABASE', 'mysjsu'),
            'username'       => env('DB2_USER', 'db2inst1'),
            'password'       => env('DB2_PASSWORD', 'db2inst1'),
            'port'           => env('DB2_PORT', 50000),
            'schema'         => 'DB2INST1',
            'odbc_driver'    => 'DB2', // name of driver created by unixODBC
        ],


        /*
        // michaelb/laravel-db2
        'odbc' => [
            'driver'                => 'odbc',
            'host'                  => 'localhost',
            'database'              => 'mysjsu',
            'username'              => 'db2inst1',
            'password'              => 'db2inst1',
            'charset'               => 'utf8',
            'ccsid'                 => 1208,
            'prefix'                => '',
            'schema'                => 'DB2INST1',
            'signon'                => 3,
            'ssl'                   => 0,
            'commitMode'            => 2,
            'connectionType'        => 0,
            'defaultLibraries'      => '',
            'naming'                => 0,
            'unicodeSql'            => 0,
            // Format settings
            'dateFormat'            => 5,
            'dateSeperator'         => 0,
            'decimal'               => 0,
            'timeFormat'            => 0,
            'timeSeparator'         => 0,
            // Performances settings
            'blockFetch'            => 1,
            'blockSizeKB'           => 32,
            'allowDataCompression'  => 1,
            'concurrency'           => 0,
            'lazyClose'             => 0,
            'maxFieldLength'        => 15360,
            'prefetch'              => 0,
            'queryTimeout'          => 1,
            // Modules settings
            'defaultPkgLibrary'     => 'QGPL',
            'defaultPackage'        => 'A/DEFAULT(IBM),2,0,1,0',
            'extendedDynamic'       => 1,
            // Diagnostic settings
            'QAQQINILibrary'        => '',
            'sqDiagCode'            => '',
            // Sort settings
            'languageId'            => 'ENU',
            'sortTable'             => '',
            'sortSequence'          => 0,
            'sortWeight'            => 0,
            'jobSort'               => 0,
            // Conversion settings
            'allowUnsupportedChar'  => 0,
            'ccsid'                 => 1208,
            'graphic'               => 0,
            'forceTranslation'      => 0,
            // Other settings
            'allowProcCalls'        => 0,
            'DB2SqlStates'          => 0,
            'debug'                 => 0,
            'trueAutoCommit'        => 0,
            'catalogOptions'        => 3,
            'libraryView'           => 0,
            'ODBCRemarks'           => 0,
            'searchPattern'         => 1,
            'translationDLL'        => '',
            'translationOption'     => 0,
            'maxTraceSize'          => 0,
            'multipleTraceFiles'    => 1,
            'trace'                 => 0,
            'traceFilename'         => '',
            'extendedColInfo'       => 0,
            'i5_libl'               => '',
            'i5_lib'                => '',
            'i5_commit'             => 0,
            'i5_naming'             => 0,
            'i5_date_fmt'           => 5,
            'i5_date_sep'           => 0,
            'i5_decimal_sep'        => 0,
            'i5_time_fmt'           => 0,
            'i5_time_sep'           => 0,
            'options'               => [
                PDO::ATTR_CASE => PDO::CASE_LOWER,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => false
            ]
        ], */


        /*
         // ccovey/laravel-odbc
        'odbc' => [
            'driver' => 'odbc',
            'dsn' => 'Driver={iSeries Access ODBC Driver};System=my_system_name;',
            'grammar' => 'DB2',
            'username' => 'db2inst1',
            'password' => 'db2inst1',
            'database' => 'localhost',
        ],
        */

        /*
         opb/laravel-db2
        'odbc' => [
            'driver'         => 'odbc',
            'host'           => env('DB2_HOST', 'localhost'),
            'database'       => env('DB2_DATABASE', 'mysjsu'),
            'username'       => env('DB2_USER', 'db2inst1'),
            'password'       => env('DB2_PASSWORD', 'db2inst1'),
            'port'           => env('DB2_PORT', 50000),
            'schema'         => 'DB2INST1',
            'odbc_driver'    => 'DB2', // name of driver created by unixODBC
        ],
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'cluster' => false,

        'default' => [
            'host'     => '127.0.0.1',
            'port'     => 6379,
            'database' => 0,
        ],

    ],

];
