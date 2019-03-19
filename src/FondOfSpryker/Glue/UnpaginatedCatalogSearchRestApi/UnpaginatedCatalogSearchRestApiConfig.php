<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi;

use FondOfSpryker\Shared\UnpaginatedCatalogSearchRestApi\UnpaginatedCatalogSearchRestApiConstants;
use Spryker\Glue\Kernel\AbstractBundleConfig;

class UnpaginatedCatalogSearchRestApiConfig extends AbstractBundleConfig
{
    public const RESOURCE_UNPAGINATED_CATALOG_SEARCH = 'unpaginated-catalog-search';
    public const CONTROLLER_UNPAGINATED_CATALOG_SEARCH = 'unpaginated-catalog-search-resource';
    public const QUERY_STRING_PARAMETER = 'q';

    /**
     * @return int
     */
    public function getDefaultPageLimit(): int
    {
        return $this->get(
            UnpaginatedCatalogSearchRestApiConstants::DEFAULT_PAGE_LIMIT,
            UnpaginatedCatalogSearchRestApiConstants::DEFAULT_PAGE_LIMIT_VALUE
        );
    }
}
