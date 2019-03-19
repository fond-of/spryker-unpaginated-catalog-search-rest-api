<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi;

use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCatalogClientBridge;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCurrencyClientBridge;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToGlossaryStorageClientBridge;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToPriceClientBridge;
use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

class UnpaginatedCatalogSearchRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_CATALOG = 'CLIENT_CATALOG';
    public const CLIENT_PRICE = 'CLIENT_PRICE';
    public const CLIENT_CURRENCY = 'CLIENT_CURRENCY';
    public const CLIENT_GLOSSARY_STORAGE = 'CLIENT_GLOSSARY_STORAGE';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        $container = $this->addGlossaryStorageClient($container);
        $container = $this->addCatalogClient($container);
        $container = $this->addPriceClient($container);
        $container = $this->addCurrencyClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addCatalogClient(Container $container): Container
    {
        $container[static::CLIENT_CATALOG] = function (Container $container) {
            return new UnpaginatedCatalogSearchRestApiToCatalogClientBridge($container->getLocator()->catalog()->client());
        };

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addPriceClient(Container $container): Container
    {
        $container[static::CLIENT_PRICE] = function (Container $container) {
            return new UnpaginatedCatalogSearchRestApiToPriceClientBridge($container->getLocator()->price()->client());
        };

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addCurrencyClient(Container $container): Container
    {
        $container[static::CLIENT_CURRENCY] = function (Container $container) {
            return new UnpaginatedCatalogSearchRestApiToCurrencyClientBridge($container->getLocator()->currency()->client());
        };

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addGlossaryStorageClient(Container $container): Container
    {
        $container[static::CLIENT_GLOSSARY_STORAGE] = function (Container $container) {
            return new UnpaginatedCatalogSearchRestApiToGlossaryStorageClientBridge($container->getLocator()->glossaryStorage()->client());
        };

        return $container;
    }
}
