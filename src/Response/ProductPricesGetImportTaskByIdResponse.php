<?php

namespace Sportmaster\Api\Response;

use InvalidArgumentException;

/**
 * Response object for retrieving the status of a product prices import task.
 */
class ProductPricesGetImportTaskByIdResponse
{
    private ?string $taskId;
    private ?string $statusDate;
    private ?string $createDate;
    private ?string $status;
    private array $productPrices;

    /**
     * ProductPricesGetImportTaskByIdResponse constructor.
     *
     * @param string|null $taskId Task ID.
     * @param string|null $statusDate Status update date (ISO 8601).
     * @param string|null $createDate Task creation date (ISO 8601).
     * @param string|null $status Task status.
     * @param array $productPrices Array of price items with their status.
     * @throws \InvalidArgumentException If date formats are invalid.
     */
    public function __construct(?string $taskId, ?string $statusDate, ?string $createDate, ?string $status, array $productPrices)
    {
        if ($statusDate !== null && !preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(?:\.\d+)?(?:[+-]\d{2}:\d{2}|Z)$/', $statusDate)) {
            throw new InvalidArgumentException('Invalid statusDate format, must be ISO 8601');
        }
        if ($createDate !== null && !preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(?:\.\d+)?(?:[+-]\d{2}:\d{2}|Z)$/', $createDate)) {
            throw new InvalidArgumentException('Invalid createDate format, must be ISO 8601');
        }
        $this->taskId = $taskId;
        $this->statusDate = $statusDate;
        $this->createDate = $createDate;
        $this->status = $status;
        $this->productPrices = $productPrices;
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

    /**
     * Gets the status update date.
     *
     * @return string|null
     */
    public function getStatusDate(): ?string
    {
        return $this->statusDate;
    }

    /**
     * Gets the task creation date.
     *
     * @return string|null
     */
    public function getCreateDate(): ?string
    {
        return $this->createDate;
    }

    /**
     * Gets the task status.
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Gets the product prices.
     *
     * @return array
     */
    public function getProductPrices(): array
    {
        return $this->productPrices;
    }
}