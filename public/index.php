<?php

require '../src/include.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \pureTask\CountryIpCsv as CountryIpCsv;
use \pureTask\Mysql as Mysql;


$app = new \Slim\App;

/**
 * Service that given an ip as query parameter returns the country
 */
$app->get('/locationByIP', function (Request $request, Response $response) {

    $queryParams = $request->getQueryParams();
    $ip = (string)$queryParams['IP'];

    try
    {
        $db = Mysql::getInstance();

        $query = $db->prepare("SELECT * 
            FROM ipcountry
            WHERE ip_start = :ip");

        $query->bindParam(':ip', $ip, PDO::PARAM_STR);
        $query->execute();
        $ip = $query->fetch(PDO::FETCH_OBJ);

        if($ip) {
            $response->withStatus(200);
            $response->withHeader('Content-Type', 'application/json');
            echo json_encode($ip);
        }
        else {
            throw new PDOException('No records found.');
        }

    } catch(PDOException $e) {
        $response->withStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

});


$app->run();