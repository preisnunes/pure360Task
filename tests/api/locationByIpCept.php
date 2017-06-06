<?php

$I = new ApiTester($scenario);
$I->wantTo('Test the correctness of the database population');

$I->haveHttpHeader('Content-Type', 'application/json');
$I->sendGET('/locationByIP', ['IP' => '2.17.252.0']);
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
$I->seeResponseIsJson();
$I->seeResponseContainsJson([
    'country' => "Germany",
    'country_code' => "DE"
]);
