<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client;

interface UnpaginatedCatalogSearchRestApiToPriceClientInterface
{
    /**
     * @return string
     */
    public function getCurrentPriceMode(): string;

    /**
     * @param string $priceMode
     *
     * @return void
     */
    public function switchPriceMode(string $priceMode): void;

    /**
     * @return string
     */
    public function getGrossPriceModeIdentifier(): string;

    /**
     * @return string
     */
    public function getNetPriceModeIdentifier(): string;

    /**
     * @return string[]
     */
    public function getPriceModes(): array;
}
