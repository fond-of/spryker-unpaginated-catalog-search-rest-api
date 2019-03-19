<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client;

class UnpaginatedCatalogSearchRestApiToPriceClientBridge implements UnpaginatedCatalogSearchRestApiToPriceClientInterface
{
    /**
     * @var \Spryker\Client\Price\PriceClientInterface
     */
    protected $priceClient;

    /**
     * @param \Spryker\Client\Price\PriceClientInterface $priceClient
     */
    public function __construct($priceClient)
    {
        $this->priceClient = $priceClient;
    }

    /**
     * @return string
     */
    public function getCurrentPriceMode(): string
    {
        return $this->priceClient->getCurrentPriceMode();
    }

    /**
     * @param string $priceMode
     *
     * @return void
     */
    public function switchPriceMode(string $priceMode): void
    {
        $this->priceClient->switchPriceMode($priceMode);
    }

    /**
     * @return string
     */
    public function getGrossPriceModeIdentifier(): string
    {
        return $this->priceClient->getGrossPriceModeIdentifier();
    }

    /**
     * @return string
     */
    public function getNetPriceModeIdentifier(): string
    {
        return $this->priceClient->getNetPriceModeIdentifier();
    }

    /**
     * @return string[]
     */
    public function getPriceModes(): array
    {
        return $this->priceClient->getPriceModes();
    }
}
