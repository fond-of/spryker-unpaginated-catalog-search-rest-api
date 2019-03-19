<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi;

use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCatalogClientInterface;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCurrencyClientInterface;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToGlossaryStorageClientInterface;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToPriceClientInterface;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Catalog\UnpaginatedCatalogSearchReader;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Catalog\UnpaginatedCatalogSearchReaderInterface;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Mapper\UnpaginatedCatalogSearchResourceMapper;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Mapper\UnpaginatedCatalogSearchResourceMapperInterface;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Translation\UnpaginatedCatalogSearchTranslationExpander;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Translation\UnpaginatedCatalogSearchTranslationExpanderInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\UnpaginatedCatalogSearchRestApiConfig getConfig()
 */
class UnpaginatedCatalogSearchRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Catalog\UnpaginatedCatalogSearchReaderInterface
     */
    public function createUnpaginatedCatalogSearchReader(): UnpaginatedCatalogSearchReaderInterface
    {
        return new UnpaginatedCatalogSearchReader(
            $this->getResourceBuilder(),
            $this->getConfig(),
            $this->getCatalogClient(),
            $this->getPriceClient(),
            $this->createUnpaginatedCatalogSearchResourceMapper(),
            $this->createUnpaginatedCatalogSearchTranslationExpander()
        );
    }

    /**
     * @return \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Mapper\UnpaginatedCatalogSearchResourceMapperInterface
     */
    protected function createUnpaginatedCatalogSearchResourceMapper(): UnpaginatedCatalogSearchResourceMapperInterface
    {
        return new UnpaginatedCatalogSearchResourceMapper($this->getCurrencyClient());
    }

    /**
     * @return \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Translation\UnpaginatedCatalogSearchTranslationExpanderInterface
     */
    protected function createUnpaginatedCatalogSearchTranslationExpander(): UnpaginatedCatalogSearchTranslationExpanderInterface
    {
        return new UnpaginatedCatalogSearchTranslationExpander($this->getGlossaryStorageClient());
    }

    /**
     * @throws
     *
     * @return \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCatalogClientInterface
     */
    protected function getCatalogClient(): UnpaginatedCatalogSearchRestApiToCatalogClientInterface
    {
        return $this->getProvidedDependency(UnpaginatedCatalogSearchRestApiDependencyProvider::CLIENT_CATALOG);
    }

    /**
     * @throws
     *
     * @return \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToPriceClientInterface
     */
    protected function getPriceClient(): UnpaginatedCatalogSearchRestApiToPriceClientInterface
    {
        return $this->getProvidedDependency(UnpaginatedCatalogSearchRestApiDependencyProvider::CLIENT_PRICE);
    }

    /**
     * @throws
     *
     * @return \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToGlossaryStorageClientInterface
     */
    public function getGlossaryStorageClient(): UnpaginatedCatalogSearchRestApiToGlossaryStorageClientInterface
    {
        return $this->getProvidedDependency(UnpaginatedCatalogSearchRestApiDependencyProvider::CLIENT_GLOSSARY_STORAGE);
    }

    /**
     * @throws
     *
     * @return \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCurrencyClientInterface
     */
    protected function getCurrencyClient(): UnpaginatedCatalogSearchRestApiToCurrencyClientInterface
    {
        return $this->getProvidedDependency(UnpaginatedCatalogSearchRestApiDependencyProvider::CLIENT_CURRENCY);
    }
}
