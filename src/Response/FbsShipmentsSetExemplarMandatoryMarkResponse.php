<?php

namespace Sportmaster\Api\Response;

/**
 * Response object for setting a mandatory mark on an exemplar in an FBS shipment.
 */
class FbsShipmentsSetExemplarMandatoryMarkResponse
{
    private bool $isMandatoryMarkSet;
    private array $verificationErrors;

    /**
     * FbsShipmentsSetExemplarMandatoryMarkResponse constructor.
     *
     * @param bool $isMandatoryMarkSet Whether the mandatory mark was set.
     * @param array $verificationErrors Array of verification errors.
     */
    public function __construct(bool $isMandatoryMarkSet, array $verificationErrors)
    {
        $this->isMandatoryMarkSet = $isMandatoryMarkSet;
        $this->verificationErrors = $verificationErrors;
    }

    /**
     * Checks if the mandatory mark was set.
     *
     * @return bool
     */
    public function isMandatoryMarkSet(): bool
    {
        return $this->isMandatoryMarkSet;
    }

    /**
     * Gets the verification errors.
     *
     * @return array
     */
    public function getVerificationErrors(): array
    {
        return $this->verificationErrors;
    }
}