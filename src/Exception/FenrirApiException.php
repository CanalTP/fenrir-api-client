<?php

namespace CanalTP\FenrirApiClient\Exception;

class FenrirApiException extends \RuntimeException
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var string
     */
    private $reason;

    /**
     * @param int $statusCode
     * @param string $reason
     * @param \Exception $previous
     */
    public function __construct($statusCode, $reason, $previous = null)
    {
        parent::__construct(
            sprintf('Fenrir Api returned an http error (%d) "%s".', $statusCode, $reason),
            $statusCode,
            $previous
        );
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }
}
