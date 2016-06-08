<?php

namespace Tests\CanalTP\FenrirApiClient;

use CanalTP\FenrirApiClient\FenrirApi;

class FenrirApiTest extends AbstractFenrirApiTest
{
    public function testCreateWithBaseUrlReturnsAnInitializedInstanceOfFenrir()
    {
        $baseUrl = 'http://mock.ette/api/';

        $fenrirApi = FenrirApi::createWithBaseUrl($baseUrl);
        $abstractGuzzle = $fenrirApi->getGuzzle();

        $this->assertInstanceOf('CanalTP\\FenrirApiClient\\FenrirApi', $fenrirApi);
        $this->assertInstanceOf('CanalTP\\AbstractGuzzle\\Guzzle', $abstractGuzzle);

        $this->assertEquals($baseUrl, $abstractGuzzle->getBaseUrl());
    }
}
