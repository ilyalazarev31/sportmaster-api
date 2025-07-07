<?php

namespace Sportmaster\Api\Response;

/**
 * Response object for creating FBS stock import tasks.
 */
class FbsStocksCreateImportTaskResponse
{
    private ?string $taskId;

    /**
     * FbsStocksCreateImportTaskResponse constructor.
     *
     * @param string|null $taskId Task ID for the stock import.
     */
    public function __construct(?string $taskId)
    {
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