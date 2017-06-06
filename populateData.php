#!/usr/bin/env php
<?php

require_once __DIR__ . '/include.php';

use Symfony\Component\Console\Application;
use pureTask\Command\PopulateCountriesIp;


$application = new Application('PureTask', '1.0.0');
$application->add( new PopulateCountriesIp());
$application->run();