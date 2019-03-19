<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Translation;

use Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer;

interface UnpaginatedCatalogSearchTranslationExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer $restUnpaginatedCatalogSearchAttributesTransfer
     * @param string $localName
     *
     * @return \Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer
     */
    public function addTranslations(
        RestUnpaginatedCatalogSearchAttributesTransfer $restUnpaginatedCatalogSearchAttributesTransfer,
        string $localName
    ): RestUnpaginatedCatalogSearchAttributesTransfer;
}
