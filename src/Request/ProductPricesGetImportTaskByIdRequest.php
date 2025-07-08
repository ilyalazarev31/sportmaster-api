<?php

namespace Sportmaster\Api\Request;

use InvalidArgumentException;

/**
 * Request object for retrieving a product prices import task status by ID.
 */
class ProductPricesGetImportTaskByIdRequest
{
    private string $taskId;

    /**
     * ProductPricesGetImportTaskByIdRequest constructor.
     *
     * @param string $taskId The task identifier.
     * @throws \InvalidArgumentException If taskId is invalid.
     */
    public function __construct(string $taskId)
    {
        if (!preg_match('/^\d{1,20}$/', $taskId)) {
            throw new InvalidArgumentException('Invalid taskId format: ' . $taskId);
        }
        $this->taskId = $taskId;
    }

    /**
     * Gets the task ID.
     *
     * @return string
     */
    public function getTaskId(): string
    {
        return $this->taskId;
    }
}