<?php



function defineConstants(){

    $constants = parse_ini_file('configs.ini');

    foreach( $constants as $name => $value ){
        define( strtoupper($name), $value );
    }

}

defineConstants();