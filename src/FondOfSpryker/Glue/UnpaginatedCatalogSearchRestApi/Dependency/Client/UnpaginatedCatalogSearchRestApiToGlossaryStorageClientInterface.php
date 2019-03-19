<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client;

interface UnpaginatedCatalogSearchRestApiToGlossaryStorageClientInterface
{
    /**
     * @param string $id
     * @param string $localeName
     * @param array $parameters
     *
     * @return string
     */
    public function translate($id, $localeName, array $parameters = []): string;
}
