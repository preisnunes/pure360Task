<?php

$I = new ApiTester($scenario);
$I->wantTo('Test the correctness of the database population');

$I->haveHttpHeader('Content-Type', 'application/json');
$I->sendGET('/locationByIP', ['IP' => '77.185.59.37']);
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
$I->seeResponseIsJson();
$I->seeResponseContainsJson([
    'country' => "Germany",
    'country_code' => "DE"
]);
