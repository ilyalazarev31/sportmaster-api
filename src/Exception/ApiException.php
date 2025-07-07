<?php

namespace Sportmaster\Api\Exception;

/**
 * Exception thrown when an API request fails.
 */
class ApiException extends \Exception
{
    private string $errorCode;

    /**
     * ApiException constructor.
     *
     * @param string $message Error message.
     * @param int $code HTTP status code.
     * @param string $errorCode API error code.
     */
    public function __construct(string $message, int $code = 0, string $errorCode = 'UNKNOWN')
    {
        parent::__construct($message, $code);
        $this->errorCode = $errorCode;
    }

    /**
     * Gets the API error code.
     *
     * @return string
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }
}