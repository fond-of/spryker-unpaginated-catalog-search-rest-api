<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Mapper;

use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCurrencyClientInterface;
use Generated\Shared\Transfer\FacetConfigTransfer;
use Generated\Shared\Transfer\FacetSearchResultTransfer;
use Generated\Shared\Transfer\PriceModeConfigurationTransfer;
use Generated\Shared\Transfer\RangeSearchResultTransfer;
use Generated\Shared\Transfer\RestCatalogSearchSortTransfer;
use Generated\Shared\Transfer\RestCurrencyTransfer;
use Generated\Shared\Transfer\RestFacetConfigTransfer;
use Generated\Shared\Transfer\RestFacetSearchResultTransfer;
use Generated\Shared\Transfer\RestPriceProductTransfer;
use Generated\Shared\Transfer\RestRangeSearchResultTransfer;
use Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAbstractProductsTransfer;
use Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer;

class UnpaginatedCatalogSearchResourceMapper implements UnpaginatedCatalogSearchResourceMapperInterface
{
    protected const SEARCH_KEY_PRODUCTS = 'products';

    /**
     * @var \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCurrencyClientInterface
     */
    protected $currencyClient;

    /**
     * @param \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCurrencyClientInterface $currencyClient
     */
    public function __construct(UnpaginatedCatalogSearchRestApiToCurrencyClientInterface $currencyClient)
    {
        $this->currencyClient = $currencyClient;
    }

    /**
     * @uses \Spryker\Client\Search\Plugin\Elasticsearch\ResultFormatter\FacetResultFormatterPlugin::NAME
     */
    protected const NAME = 'facets';

    /**
     * @uses \Spryker\Client\Search\Plugin\Elasticsearch\ResultFormatter\SortedResultFormatterPlugin::NAME
     */
    protected const SORT_NAME = 'sort';

    /**
     * @param array $restSearchResponse
     *
     * @return \Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer
     */
    public function mapSearchResultToRestAttributesTransfer(array $restSearchResponse): RestUnpaginatedCatalogSearchAttributesTransfer
    {
        $restSearchAttributesTransfer = (new RestUnpaginatedCatalogSearchAttributesTransfer())->fromArray($restSearchResponse, true);

        $restSearchAttributesTransfer = $this->mapSearchResponseProductsToRestUnpaginatedCatalogSearchAttributesTransfer(
            $restSearchAttributesTransfer,
            $restSearchResponse
        );

        $restCatalogSearchSortTransfer = (new RestCatalogSearchSortTransfer())
            ->fromArray($restSearchResponse[static::SORT_NAME]->toArray());
        $restSearchAttributesTransfer->setSort($restCatalogSearchSortTransfer);

        if (isset($restSearchResponse[static::NAME])) {
            $restSearchAttributesTransfer = $this->mapSearchResponseFacetTransfersToSearchAttributesTransfer(
                $restSearchResponse[static::NAME],
                $restSearchAttributesTransfer
            );
        }

        return $restSearchAttributesTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer $restCatalogSearchAttributesTransfer
     * @param array $restSearchResponse
     *
     * @return \Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer
     */
    protected function mapSearchResponseProductsToRestUnpaginatedCatalogSearchAttributesTransfer(
        RestUnpaginatedCatalogSearchAttributesTransfer $restCatalogSearchAttributesTransfer,
        array $restSearchResponse
    ): RestUnpaginatedCatalogSearchAttributesTransfer {
        if (!isset($restSearchResponse[static::SEARCH_KEY_PRODUCTS]) || !is_array($restSearchResponse[static::SEARCH_KEY_PRODUCTS])) {
            return $restCatalogSearchAttributesTransfer;
        }

        foreach ($restSearchResponse[static::SEARCH_KEY_PRODUCTS] as $product) {
            $restCatalogSearchAttributesTransfer->addAbstractProduct(
                (new RestUnpaginatedCatalogSearchAbstractProductsTransfer())->fromArray($product, true)
            );
        }

        return $restCatalogSearchAttributesTransfer;
    }

    /**
     * @param array $facets
     * @param \Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer $restSearchAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer
     */
    protected function mapSearchResponseFacetTransfersToSearchAttributesTransfer(
        array $facets,
        RestUnpaginatedCatalogSearchAttributesTransfer $restSearchAttributesTransfer
    ): RestUnpaginatedCatalogSearchAttributesTransfer {
        foreach ($facets as $facet) {
            if ($facet instanceof FacetSearchResultTransfer) {
                $valueFacet = (new RestFacetSearchResultTransfer())->fromArray($facet->toArray(), true);
                $valueFacet->setConfig($this->mapFacetConfigTransferToRestFacetConfigTransfer($facet->getConfig()));
                $restSearchAttributesTransfer->addValueFacet($valueFacet);
                continue;
            }

            if ($facet instanceof RangeSearchResultTransfer) {
                $rangeFacet = (new RestRangeSearchResultTransfer())->fromArray($facet->toArray(), true);
                $rangeFacet->setConfig($this->mapFacetConfigTransferToRestFacetConfigTransfer($facet->getConfig()));
                $restSearchAttributesTransfer->addRangeFacet($rangeFacet);
            }
        }

        return $restSearchAttributesTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\FacetConfigTransfer $facetConfigTransfer
     *
     * @return \Generated\Shared\Transfer\RestFacetConfigTransfer
     */
    protected function mapFacetConfigTransferToRestFacetConfigTransfer(
        FacetConfigTransfer $facetConfigTransfer
    ): RestFacetConfigTransfer {
        $restFacetConfigTransfer = (new RestFacetConfigTransfer())->fromArray($facetConfigTransfer->toArray(), true);
        $restFacetConfigTransfer->setIsMultiValued((bool)$restFacetConfigTransfer->getIsMultiValued());

        return $restFacetConfigTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer $restSearchAttributesTransfer
     * @param \Generated\Shared\Transfer\PriceModeConfigurationTransfer $priceModeInformation
     *
     * @return \Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer
     */
    public function mapPrices(
        RestUnpaginatedCatalogSearchAttributesTransfer $restSearchAttributesTransfer,
        PriceModeConfigurationTransfer $priceModeInformation
    ): RestUnpaginatedCatalogSearchAttributesTransfer {
        foreach ($restSearchAttributesTransfer->getAbstractProducts() as $product) {
            $prices = [];

            foreach ($product->getPrices() as $priceType => $price) {
                $priceData = $this
                    ->getPriceTransfer($priceType, $price, $priceModeInformation)
                    ->modifiedToArray(true, true);

                $prices[] = $priceData + [$priceType => $price];
            }

            $product->setPrices($prices);
        }

        return $restSearchAttributesTransfer;
    }

    /**
     * @param string $priceType
     * @param int $price
     * @param \Generated\Shared\Transfer\PriceModeConfigurationTransfer $priceModeInformation
     *
     * @return \Generated\Shared\Transfer\RestPriceProductTransfer
     */
    protected function getPriceTransfer(
        string $priceType,
        int $price,
        PriceModeConfigurationTransfer $priceModeInformation
    ): RestPriceProductTransfer {
        $restPriceProductTransfer = new RestPriceProductTransfer();
        $restPriceProductTransfer->setPriceTypeName($priceType);

        $restPriceProductTransfer->setCurrency(
            (new RestCurrencyTransfer())->fromArray(
                $this->currencyClient->getCurrent()->toArray(),
                true
            )
        );

        if ($priceModeInformation->getCurrentPriceMode() === $priceModeInformation->getGrossModeIdentifier()) {
            return $restPriceProductTransfer->setGrossAmount($price);
        }

        if ($priceModeInformation->getCurrentPriceMode() === $priceModeInformation->getNetModeIdentifier()) {
            return $restPriceProductTransfer->setNetAmount($price);
        }

        return $restPriceProductTransfer;
    }
}
