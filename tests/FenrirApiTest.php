<?php

namespace Tests\CanalTP\FenrirApiClient;

use CanalTP\FenrirApiClient\AbstractGuzzle\Guzzle;
use CanalTP\FenrirApiClient\FenrirApi;

class FenrirApiTest extends AbstractFenrirApiTest
{
    public function testCreateWithBaseUrlReturnsAnInitializedInstanceOfFenrir()
    {
        $baseUrl = 'http://mock.ette/api/';

        $fenrirApi = FenrirApi::createWithBaseUrl($baseUrl);
        $abstractGuzzle = $fenrirApi->getGuzzle();

        $this->assertInstanceOf(FenrirApi::class, $fenrirApi);
        $this->assertInstanceOf(Guzzle::class, $abstractGuzzle);

        $this->assertEquals($baseUrl, $abstractGuzzle->getBaseUrl());
    }
}
