<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Mapper;

use Generated\Shared\Transfer\PriceModeConfigurationTransfer;
use Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer;

interface UnpaginatedCatalogSearchResourceMapperInterface
{
    /**
     * @param array $restSearchResponse
     *
     * @return \Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer
     */
    public function mapSearchResultToRestAttributesTransfer(array $restSearchResponse): RestUnpaginatedCatalogSearchAttributesTransfer;

    /**
     * @param \Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer $restSearchAttributesTransfer
     * @param \Generated\Shared\Transfer\PriceModeConfigurationTransfer $priceModeInformation
     *
     * @return \Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer
     */
    public function mapPrices(
        RestUnpaginatedCatalogSearchAttributesTransfer $restSearchAttributesTransfer,
        PriceModeConfigurationTransfer $priceModeInformation
    ): RestUnpaginatedCatalogSearchAttributesTransfer;
}
