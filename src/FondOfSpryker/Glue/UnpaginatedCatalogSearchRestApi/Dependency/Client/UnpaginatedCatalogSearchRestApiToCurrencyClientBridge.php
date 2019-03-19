<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client;

use Generated\Shared\Transfer\CurrencyTransfer;
use Spryker\Client\Currency\CurrencyClientInterface;

class UnpaginatedCatalogSearchRestApiToCurrencyClientBridge implements UnpaginatedCatalogSearchRestApiToCurrencyClientInterface
{
    /**
     * @var \Spryker\Client\Currency\CurrencyClientInterface
     */
    protected $currencyClient;

    /**
     * @param \Spryker\Client\Currency\CurrencyClientInterface $currencyClient
     */
    public function __construct(CurrencyClientInterface $currencyClient)
    {
        $this->currencyClient = $currencyClient;
    }

    /**
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    public function getCurrent(): CurrencyTransfer
    {
        return $this->currencyClient->getCurrent();
    }
}
