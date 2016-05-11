<?php

namespace CanalTP\FenrirApiClient;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use CanalTP\FenrirApiClient\AbstractGuzzle\Guzzle;
use CanalTP\FenrirApiClient\AbstractGuzzle\GuzzleVersions;
use CanalTP\FenrirApiClient\Exception\FenrirApiException;

class FenrirApi
{
    /**
     * @var Guzzle
     */
    private $guzzle;

    /**
     * @var Response
     */
    private $lastResponse;

    /**
     * @param Guzzle $guzzle
     */
    public function __construct(Guzzle $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    /**
     * @param string $baseUrl
     *
     * @return self
     */
    public static function createWithBaseUrl($baseUrl)
    {
        return new static(GuzzleVersions::createGuzzle($baseUrl));
    }

    /**
     * @param string $method
     * @param string $uri
     * @param mixed $body request body to json encode.
     *
     * @return mixed
     *
     * @throws FenrirApiException on non success status code.
     */
    private function jsonCall($method, $uri, $body = null)
    {
        $jsonBody = null;

        if (null !== $body) {
            $jsonBody = json_encode($body);
        }

        $request = new Request($method, $uri, ['Content-Type' => 'application/json'], $jsonBody);
        $response = $this->guzzle->send($request);
        $this->lastResponse = $response;

        self::checkResponse($response);

        return json_decode($response->getBody());
    }

    /**
     * @param Response $response
     *
     * @throws FenrirApiException When Fenrir Api return a non success status code.
     */
    private static function checkResponse(Response $response)
    {
        $statusCode = $response->getStatusCode();

        if ($statusCode >= 400 && $statusCode < 600) {
            $reason = $response->getReasonPhrase();
            $body = json_decode($response->getBody());

            if (isset($body->error->exception[0]->message)) {
                $reason = $body->error->exception[0]->message;
            }

            throw new FenrirApiException($statusCode, $reason);
        }
    }

    /**
     * @return Response
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * Retrieve all users.
     *
     * @return \stdClass[]
     */
    public function getUsers()
    {
        return $this->jsonCall('GET', 'users');
    }

    /**
     * Retrieve an user by id.
     *
     * @param int $id
     *
     * @return \stdClass
     */
    public function getUser($id)
    {
        return $this->jsonCall('GET', 'users/'.$id);
    }

    /**
     * Create an user.
     *
     * @param string $username
     * @param int $originId
     * @param array $parameters Other user fields, optional.
     *
     * @return \stdClass
     */
    public function postUser($username, $originId, $parameters = [])
    {
        $user = [
            'username' => $username,
            'originId' => $originId,
        ];

        $user += $parameters;

        return $this->jsonCall('POST', 'users', $user);
    }

    /**
     * Update an user.
     *
     * @param int $id
     * @param array $parameters User parameters to update.
     *
     * @return \stdClass The updated user.
     */
    public function patchUser($id, $parameters)
    {
        return $this->jsonCall('PATCH', 'users/'.$id, $parameters);
    }

    /**
     * @param int $id
     *
     * @return null
     */
    public function deleteUser($id)
    {
        return $this->jsonCall('DELETE', 'users/'.$id);
    }

    /**
     * Retrieve all origins.
     *
     * @return \stdClass[]
     */
    public function getOrigins()
    {
        return $this->jsonCall('GET', 'origins');
    }

    /**
     * Retrieve an origin by id.
     *
     * @param int $id
     *
     * @return \stdClass
     */
    public function getOrigin($id)
    {
        return $this->jsonCall('GET', 'origins/'.$id);
    }

    /**
     * Creates a new origin with the provided name.
     *
     * @param string $name
     *
     * @return int The id of the created origin.
     */
    public function postOrigin($name)
    {
        return $this->jsonCall('POST', 'origins', array(
            'name' => $name,
        ));
    }

    /**
     * Update an origin.
     *
     * @param int $id
     * @param string $name The new name to set.
     *
     * @return \stdClass The updated origin.
     */
    public function patchOrigin($id, $name)
    {
        return $this->jsonCall('PATCH', 'origins/'.$id, array(
            'name' => $name,
        ));
    }

    /**
     * @param int $id
     *
     * @return null
     */
    public function deleteOrigin($id)
    {
        return $this->jsonCall('DELETE', 'origins/'.$id);
    }
}
