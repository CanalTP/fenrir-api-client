<?php

namespace Tests\CanalTP\FenrirApiClient;

use GuzzleHttp\Psr7\Response;

class FenrirApiOriginsTest extends AbstractFenrirApiTest
{
    public function testGetOrigins()
    {
        $jsonResponse = '[{"id":1,"name":"somewhereovertherainbow"},{"id":2,"name":"navitia.io"}]';
        $mockedResponse = new Response(200, [], $jsonResponse);

        $this->guzzle
            ->expects($this->once())
            ->method('send')
            ->with($this->callback($this->createRequestCheckerCallback('GET', 'origins')))
            ->willReturn($mockedResponse)
        ;

        $origins = $this->fenrirApi->getOrigins();

        $this->assertEquals(json_decode($jsonResponse), $origins);
    }

    public function testGetOrigin()
    {
        $jsonResponse = '{"id":2,"name":"navitia.io"}';
        $mockedResponse = new Response(200, [], $jsonResponse);

        $this->guzzle
            ->expects($this->once())
            ->method('send')
            ->with($this->callback($this->createRequestCheckerCallback('GET', 'origins/2')))
            ->willReturn($mockedResponse)
        ;

        $origins = $this->fenrirApi->getOrigin(2);

        $this->assertEquals(json_decode($jsonResponse), $origins);
    }

    public function testPostOrigin()
    {
        $jsonResponse = '{"id":3,"name":"new_origin"}';
        $mockedResponse = new Response(201, [], $jsonResponse);

        $this->guzzle
            ->expects($this->once())
            ->method('send')
            ->with($this->callback($this->createRequestCheckerCallback('POST', 'origins', '{"name":"new_origin"}')))
            ->willReturn($mockedResponse)
        ;

        $createdOrigin = $this->fenrirApi->postOrigin('new_origin');

        $this->assertEquals(json_decode($jsonResponse), $createdOrigin);
    }

    public function testPatchOrigin()
    {
        $jsonResponse = '{"id":3,"name":"myorigin_updated"}';
        $mockedResponse = new Response(200, [], $jsonResponse);

        $this->guzzle
            ->expects($this->once())
            ->method('send')
            ->with($this->callback($this->createRequestCheckerCallback('PATCH', 'origins/3', '{"name":"new_origin"}')))
            ->willReturn($mockedResponse)
        ;

        $origin = $this->fenrirApi->patchOrigin(3, 'new_origin');

        $this->assertEquals(json_decode($jsonResponse), $origin);
    }

    public function testDeleteOrigin()
    {
        $mockedResponse = new Response(204, [], '');

        $this->guzzle
            ->expects($this->once())
            ->method('send')
            ->with($this->callback($this->createRequestCheckerCallback('DELETE', 'origins/3')))
            ->willReturn($mockedResponse)
        ;

        $this->fenrirApi->deleteOrigin(3);
    }
}
