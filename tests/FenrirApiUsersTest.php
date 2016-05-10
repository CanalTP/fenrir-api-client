<?php

namespace Tests\CanalTP\FenrirApiClient;

use GuzzleHttp\Psr7\Response;

class FenrirApiUsersTest extends AbstractFenrirApiTest
{
    public function testGetUsers()
    {
        $jsonResponse = '[{"id":1,"username":"josette"},{"id":2,"username":"roberto"}]';
        $mockedResponse = new Response(200, [], $jsonResponse);

        $this->guzzle
            ->expects($this->once())
            ->method('send')
            ->with($this->callback($this->createRequestCheckerCallback('GET', 'users')))
            ->willReturn($mockedResponse)
        ;

        $users = $this->fenrirApi->getUsers();

        $this->assertEquals(json_decode($jsonResponse), $users);
    }

    public function testGetUser()
    {
        $jsonResponse = '{"id":2,"username":"roberto"}';
        $mockedResponse = new Response(200, [], $jsonResponse);

        $this->guzzle
            ->expects($this->once())
            ->method('send')
            ->with($this->callback($this->createRequestCheckerCallback('GET', 'users/2')))
            ->willReturn($mockedResponse)
        ;

        $users = $this->fenrirApi->getUser(2);

        $this->assertEquals(json_decode($jsonResponse), $users);
    }

    public function testPostUser()
    {
        $jsonResponse = '{"id":3,"username":"newbie","origin":{"id":1,"name":"somewhereoverovertherainbow"}}';
        $mockedResponse = new Response(201, [], $jsonResponse);
        $userParameters = [
            'username' => 'newbie',
            'originId' => 1,
            'enabled' => true,
        ];

        $this->guzzle
            ->expects($this->once())
            ->method('send')
            ->with($this->callback($this->createRequestCheckerCallback('POST', 'users', json_encode($userParameters))))
            ->willReturn($mockedResponse)
        ;

        $createdUser = $this->fenrirApi->postUser($userParameters['username'], $userParameters['originId'], [
            'enabled' => true,
        ]);

        $this->assertEquals(json_decode($jsonResponse), $createdUser);
    }

    public function testPatchUser()
    {
        $jsonResponse = '{"id":3,"username":"newbie_patched","origin":{"id":1,"name":"somewhereoverovertherainbow"}}';
        $mockedResponse = new Response(200, [], $jsonResponse);
        $userParameters = [
            'username' => 'newbie_patched',
        ];

        $this->guzzle
            ->expects($this->once())
            ->method('send')
            ->with($this->callback($this->createRequestCheckerCallback('PATCH', 'users/3', json_encode($userParameters))))
            ->willReturn($mockedResponse)
        ;

        $user = $this->fenrirApi->patchUser(3, $userParameters);

        $this->assertEquals(json_decode($jsonResponse), $user);
    }

    public function testDeleteUser()
    {
        $mockedResponse = new Response(204, [], '');

        $this->guzzle
            ->expects($this->once())
            ->method('send')
            ->with($this->callback($this->createRequestCheckerCallback('DELETE', 'users/3')))
            ->willReturn($mockedResponse)
        ;

        $this->fenrirApi->deleteUser(3);
    }
}
