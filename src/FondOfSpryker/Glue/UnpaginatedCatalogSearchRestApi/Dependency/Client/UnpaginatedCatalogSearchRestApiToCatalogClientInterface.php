<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client;

interface UnpaginatedCatalogSearchRestApiToCatalogClientInterface
{
    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array
     */
    public function catalogSearch(string $searchString, array $requestParameters = []): array;
}
