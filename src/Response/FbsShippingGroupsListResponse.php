<?php

namespace Sportmaster\Api\Response;

/**
 * Response object for retrieving a list of shipping groups.
 */
class FbsShippingGroupsListResponse
{
    private array $shippingGroups;
    private array $pagination;

    /**
     * FbsShippingGroupsListResponse constructor.
     *
     * @param array $shippingGroups List of shipping group details.
     * @param array $pagination Pagination details (limit, offset, total).
     */
    public function __construct(array $shippingGroups, array $pagination)
    {
        $this->shippingGroups = $shippingGroups;
        $this->pagination = $pagination;
    }

    /**
     * Gets the list of shipping groups.
     *
     * @return array
     */
    public function getShippingGroups(): array
    {
        return $this->shippingGroups;
    }

    /**
     * Gets the pagination details.
     *
     * @return array
     */
    public function getPagination(): array
    {
        return $this->pagination;
    }
}