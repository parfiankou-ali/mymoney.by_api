<?php

namespace App\Exceptions\Http;

abstract class HttpException extends \Exception
{
    private $response;

    /**
     * Get exception status code.
     *
     * @return int
     */
    abstract public static function getStatusCode(): int;

    /**
     * Set response.
     *
     * @param $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * Get response.
     *
     * @return \stdClass
     */
    public function getResponse()
    {
        if (empty($this->response)) {
            return new \stdClass();
        }

        return $this->response;
    }
}
