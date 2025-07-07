<?php

namespace Sportmaster\Api\Response;

/**
 * Response object for creating a product prices import task.
 */
class ProductPricesCreateImportTaskResponse
{
    private ?string $taskId;

    /**
     * ProductPricesCreateImportTaskResponse constructor.
     *
     * @param string|null $taskId Task ID (1–20 digits).
     * @throws \InvalidArgumentException If taskId format is invalid.
     */
    public function __construct(?string $taskId)
    {
        if ($taskId !== null && !preg_match('/^\d{1,20}$/', $taskId)) {
            throw new \InvalidArgumentException('Invalid taskId format, must be 1–20 digits');
        }
        $this->taskId = $taskId;
    }

    /**
     * Gets the task ID.
     *
     * @return string|null
     */
    public function getTaskId(): ?string
    {
        return $this->taskId;
    }
}