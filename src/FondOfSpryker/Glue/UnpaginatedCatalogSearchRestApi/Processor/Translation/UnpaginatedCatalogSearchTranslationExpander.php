<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Translation;

use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToGlossaryStorageClientInterface;
use Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer;

class UnpaginatedCatalogSearchTranslationExpander implements UnpaginatedCatalogSearchTranslationExpanderInterface
{
    protected const GLOSSARY_SORT_PARAM_NAME_KEY_PREFIX = 'catalog.sort.';
    protected const GLOSSARY_FACET_NAME_KEY_PREFIX = 'product.filter.';

    /**
     * @var \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToGlossaryStorageClientInterface
     */
    protected $glossaryStorageClient;

    /**
     * @param \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToGlossaryStorageClientInterface $glossaryStorageClient
     */
    public function __construct(UnpaginatedCatalogSearchRestApiToGlossaryStorageClientInterface $glossaryStorageClient)
    {
        $this->glossaryStorageClient = $glossaryStorageClient;
    }

    /**
     * @param \Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer $restCatalogSearchAttributesTransfer
     * @param string $localName
     *
     * @return \Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer
     */
    public function addTranslations(
        RestUnpaginatedCatalogSearchAttributesTransfer $restCatalogSearchAttributesTransfer,
        string $localName
    ): RestUnpaginatedCatalogSearchAttributesTransfer {
        $restCatalogSearchAttributesTransfer = $this->addSortParamTranslation($restCatalogSearchAttributesTransfer, $localName);
        $restCatalogSearchAttributesTransfer = $this->addFacetNameTranslation($restCatalogSearchAttributesTransfer, $localName);

        return $restCatalogSearchAttributesTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer $restCatalogSearchAttributesTransfer
     * @param string $localName
     *
     * @return \Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer
     */
    protected function addSortParamTranslation(
        RestUnpaginatedCatalogSearchAttributesTransfer $restCatalogSearchAttributesTransfer,
        string $localName
    ): RestUnpaginatedCatalogSearchAttributesTransfer {
        $sortParamLocalizedNames = [];
        $sortTransfer = $restCatalogSearchAttributesTransfer->getSort();

        if ($sortTransfer === null) {
            return $restCatalogSearchAttributesTransfer;
        }

        foreach ($sortTransfer->getSortParamNames() as $sortParamName) {
            $sortParamLocalizedNames[$sortParamName] = $this->glossaryStorageClient
                ->translate(static::GLOSSARY_SORT_PARAM_NAME_KEY_PREFIX . $sortParamName, $localName);
        }

        $restCatalogSearchAttributesTransfer->setSort($sortTransfer->setSortParamLocalizedNames($sortParamLocalizedNames));

        return $restCatalogSearchAttributesTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer $restCatalogSearchAttributesTransfer
     * @param string $localName
     *
     * @return \Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer
     */
    protected function addFacetNameTranslation(
        RestUnpaginatedCatalogSearchAttributesTransfer $restCatalogSearchAttributesTransfer,
        string $localName
    ): RestUnpaginatedCatalogSearchAttributesTransfer {
        foreach ($restCatalogSearchAttributesTransfer->getValueFacets() as $facet) {
            $glossaryKey = static::GLOSSARY_FACET_NAME_KEY_PREFIX . $facet->getName();
            $facet->setLocalizedName($this->glossaryStorageClient->translate($glossaryKey, $localName));
        }

        foreach ($restCatalogSearchAttributesTransfer->getRangeFacets() as $facet) {
            $glossaryKey = static::GLOSSARY_FACET_NAME_KEY_PREFIX . $facet->getName();
            $facet->setLocalizedName($this->glossaryStorageClient->translate($glossaryKey, $localName));
        }

        return $restCatalogSearchAttributesTransfer;
    }
}
