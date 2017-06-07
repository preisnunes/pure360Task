<?php

require __DIR__ . '/vendor/autoload.php';

$srcDir = __DIR__ . '/src/';

require_once $srcDir . 'Utils/functions.php';

require_once $srcDir . 'CountryIpCsv.php';

require_once $srcDir . 'CountryIpData.php';

require_once  $srcDir . 'Mysql.php';

require_once $srcDir . 'Command/PopulateCountriesIp.php';

/**
 * Define Constants
 */
function defineConstants(){

    $constants = parse_ini_file('configs.ini');

    foreach( $constants as $name => $value ){
        define( strtoupper($name), $value );
    }

}

defineConstants();