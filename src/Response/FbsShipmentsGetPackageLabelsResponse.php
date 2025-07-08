<?php

namespace Sportmaster\Api\Response;

/**
 * Response object for retrieving package labels for FBS shipments.
 */
class FbsShipmentsGetPackageLabelsResponse
{
    private ?string $fileContent;
    private ?string $fileName;
    private array $getPackageLabelResults;

    /**
     * FbsShipmentsGetPackageLabelsResponse constructor.
     *
     * @param string|null $fileContent Base64-encoded file content (PDF or ZIP).
     * @param string|null $fileName Name of the file.
     * @param array $getPackageLabelResults Array of package label results.
     */
    public function __construct(?string $fileContent, ?string $fileName, array $getPackageLabelResults)
    {
        $this->fileContent = $fileContent;
        $this->fileName = $fileName;
        $this->getPackageLabelResults = $getPackageLabelResults;
    }

    /**
     * Gets the file content.
     *
     * @return string|null
     */
    public function getFileContent(): ?string
    {
        return $this->fileContent;
    }

    /**
     * Gets the file name.
     *
     * @return string|null
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * Gets the package label results.
     *
     * @return array
     */
    public function getPackageLabelResults(): array
    {
        return $this->getPackageLabelResults;
    }
}