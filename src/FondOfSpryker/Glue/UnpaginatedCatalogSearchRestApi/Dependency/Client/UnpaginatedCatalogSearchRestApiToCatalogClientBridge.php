<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client;

class UnpaginatedCatalogSearchRestApiToCatalogClientBridge implements UnpaginatedCatalogSearchRestApiToCatalogClientInterface
{
    /**
     * @var \Spryker\Client\Catalog\CatalogClientInterface
     */
    protected $catalogClient;

    /**
     * @param \Spryker\Client\Catalog\CatalogClientInterface $catalogClient
     */
    public function __construct($catalogClient)
    {
        $this->catalogClient = $catalogClient;
    }

    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array
     */
    public function catalogSearch(string $searchString, array $requestParameters = []): array
    {
        return $this->catalogClient->catalogSearch($searchString, $requestParameters);
    }
}
