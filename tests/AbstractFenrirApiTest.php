<?php

namespace Tests\CanalTP\FenrirApiClient;

use GuzzleHttp\Psr7\Request;
use CanalTP\FenrirApiClient\AbstractGuzzle\Guzzle;
use CanalTP\FenrirApiClient\FenrirApi;

abstract class AbstractFenrirApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FenrirApi
     */
    protected $fenrirApi;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $guzzle;

    /**
     * {@InheritDoc}
     */
    public function setUp()
    {
        parent::__construct();

        $baseUrlMock = 'http://mock.ette/api/';

        $this->guzzle = $this->getMockForAbstractClass(Guzzle::class, [$baseUrlMock]);
        $this->fenrirApi = new FenrirApi($this->guzzle);
    }

    /**
     * Create a callback used by php unit callback constraint
     * to compare an expected Request object.
     *
     * @param string $method
     * @param string $uri
     * @param string|null $body
     *
     * @return callable
     */
    protected function createRequestCheckerCallback($method, $uri, $body = null)
    {
        return function (Request $request) use ($method, $uri, $body) {
            $headers = $request->getHeaders();
            $this->assertArrayHasKey('Content-Type', $headers, 'Request has a Content-Type header.');
            $this->assertContains('application/json', $headers['Content-Type'], 'Content-Type is application/json.');

            $this->assertEquals($method, $request->getMethod(), 'HTTP method matches.');
            $this->assertEquals($uri, $request->getUri()->__toString(), 'Request URI matches.');

            if (null !== $body) {
                $this->assertEquals($body, $request->getBody().'', 'Request body matches.');
            }

            return true;
        };
    }
}
