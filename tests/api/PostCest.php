<?php

namespace App\Tests\api;

use App\Tests\ApiTester;
use MongoDB\BSON\UTCDateTime;

class PostCest
{
    public function listAll(ApiTester $I)
    {
        $data = [
            'title' => $I->faker->sentence,
            'body' => $I->faker->paragraph(3),
            'created_at' =>  new UTCDateTime($I->faker->dateTimeThisYear->getTimestamp()),
            'updated_at' =>  new UTCDateTime($I->faker->dateTimeThisYear->getTimestamp()),
        ];
        $I->haveInCollection('posts', $data);
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGET("/post");

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true]);
        $I->seeResponseJsonMatchesJsonPath('$.data..id');
        $I->seeResponseMatchesJsonType([
            'success' => 'boolean',
            'data' => 'array'
        ]);
    }

    public function listByQuery(ApiTester $I)
    {
        $data = [
            'title' => $I->faker->sentence,
            'body' => $I->faker->paragraph(3),
            'created_at' =>  new UTCDateTime($I->faker->dateTimeThisYear->getTimestamp()),
            'updated_at' =>  new UTCDateTime($I->faker->dateTimeThisYear->getTimestamp()),
        ];
        $I->haveInCollection('posts', $data);

        $partTitle = explode(" ", $data['title'])[0];

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGET("/post?q={$partTitle}");

        unset($data['created_at'], $data['updated_at']);

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true]);
        $I->canSeeResponseContainsJson($data);
    }

    public function getPostNotFound(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGET("/post/{$I->faker->uuid}");

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['message' => 'Not Found']);
    }

    public function get(ApiTester $I)
    {
        $data = [
            'title' => $I->faker->sentence,
            'body' => $I->faker->paragraph(3),
            'created_at' =>  new UTCDateTime($I->faker->dateTimeThisYear->getTimestamp()),
            'updated_at' =>  new UTCDateTime($I->faker->dateTimeThisYear->getTimestamp()),
        ];
        $post = $I->haveInCollection('posts', $data);

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGET("/post/{$post}");

        unset($data['created_at'], $data['updated_at']);

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => true,
            'data' => $data
        ]);

    }
}
