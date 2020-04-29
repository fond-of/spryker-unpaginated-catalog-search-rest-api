<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Translation;

use Codeception\Test\Unit;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToGlossaryStorageClientInterface;
use Generated\Shared\Transfer\RestCatalogSearchSortTransfer;
use Generated\Shared\Transfer\RestFacetSearchResultTransfer;
use Generated\Shared\Transfer\RestRangeSearchResultTransfer;
use Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer;

class UnpaginatedCatalogSearchTranslationExpanderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Translation\UnpaginatedCatalogSearchTranslationExpander
     */
    protected $unpaginatedCatalogSearchTranslationExpander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToGlossaryStorageClientInterface
     */
    protected $unpaginatedCatalogSearchRestApiToGlossaryStorageClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer
     */
    protected $restUnpaginatedCatalogSearchAttributesTransferMock;

    /**
     * @var string
     */
    protected $localeName;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCatalogSearchSortTransfer
     */
    protected $restCatalogSearchSortTransferMock;

    /**
     * @var string[]
     */
    protected $sortParamNames;

    /**
     * @var string
     */
    protected $translation;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestFacetSearchResultTransfer
     */
    protected $restFacetSearchResultTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestFacetSearchResultTransfer[]|\PHPUnit\Framework\MockObject\MockObject[]
     */
    protected $valueFacets;

    /**
     * @var string
     */
    protected $facetName;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestRangeSearchResultTransfer
     */
    protected $restRangeSearchResultTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestRangeSearchResultTransfer[]|\PHPUnit\Framework\MockObject\MockObject[]
     */
    protected $rangeFacets;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->unpaginatedCatalogSearchRestApiToGlossaryStorageClientInterfaceMock = $this->getMockBuilder(UnpaginatedCatalogSearchRestApiToGlossaryStorageClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restUnpaginatedCatalogSearchAttributesTransferMock = $this->getMockBuilder(RestUnpaginatedCatalogSearchAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeName = 'locale-name';

        $this->restCatalogSearchSortTransferMock = $this->getMockBuilder(RestCatalogSearchSortTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->sortParamNames = ['sort-param-names'];

        $this->translation = 'translation';

        $this->restFacetSearchResultTransferMock = $this->getMockBuilder(RestFacetSearchResultTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->valueFacets = [
            $this->restFacetSearchResultTransferMock,
        ];

        $this->facetName = 'facet-name';

        $this->restRangeSearchResultTransferMock = $this->getMockBuilder(RestRangeSearchResultTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->rangeFacets = [
            $this->restRangeSearchResultTransferMock,
        ];

        $this->unpaginatedCatalogSearchTranslationExpander = new UnpaginatedCatalogSearchTranslationExpander(
            $this->unpaginatedCatalogSearchRestApiToGlossaryStorageClientInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testAddTranslations(): void
    {
        $this->restUnpaginatedCatalogSearchAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getSort')
            ->willReturn($this->restCatalogSearchSortTransferMock);

        $this->restCatalogSearchSortTransferMock->expects($this->atLeastOnce())
            ->method('getSortParamNames')
            ->willReturn($this->sortParamNames);

        $this->unpaginatedCatalogSearchRestApiToGlossaryStorageClientInterfaceMock->expects($this->atLeastOnce())
            ->method('translate')
            ->willReturn($this->translation);

        $this->restCatalogSearchSortTransferMock->expects($this->atLeastOnce())
            ->method('setSortParamLocalizedNames')
            ->willReturnSelf();

        $this->restUnpaginatedCatalogSearchAttributesTransferMock->expects($this->atLeastOnce())
            ->method('setSort')
            ->with($this->restCatalogSearchSortTransferMock)
            ->willReturnSelf();

        $this->restUnpaginatedCatalogSearchAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getValueFacets')
            ->willReturn($this->valueFacets);

        $this->restFacetSearchResultTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->facetName);

        $this->restFacetSearchResultTransferMock->expects($this->atLeastOnce())
            ->method('setLocalizedName')
            ->willReturnSelf();

        $this->restUnpaginatedCatalogSearchAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getRangeFacets')
            ->willReturn($this->rangeFacets);

        $this->restRangeSearchResultTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->facetName);

        $this->restRangeSearchResultTransferMock->expects($this->atLeastOnce())
            ->method('setLocalizedName')
            ->willReturnSelf();

        $this->assertInstanceOf(
            RestUnpaginatedCatalogSearchAttributesTransfer::class,
            $this->unpaginatedCatalogSearchTranslationExpander->addTranslations(
                $this->restUnpaginatedCatalogSearchAttributesTransferMock,
                $this->localeName
            )
        );
    }

    /**
     * @return void
     */
    public function testAddTranslationsSortNull(): void
    {
        $this->restUnpaginatedCatalogSearchAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getSort')
            ->willReturn(null);

        $this->restUnpaginatedCatalogSearchAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getValueFacets')
            ->willReturn($this->valueFacets);

        $this->restFacetSearchResultTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->facetName);

        $this->restFacetSearchResultTransferMock->expects($this->atLeastOnce())
            ->method('setLocalizedName')
            ->willReturnSelf();

        $this->restUnpaginatedCatalogSearchAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getRangeFacets')
            ->willReturn($this->rangeFacets);

        $this->restRangeSearchResultTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->facetName);

        $this->restRangeSearchResultTransferMock->expects($this->atLeastOnce())
            ->method('setLocalizedName')
            ->willReturnSelf();

        $this->assertInstanceOf(
            RestUnpaginatedCatalogSearchAttributesTransfer::class,
            $this->unpaginatedCatalogSearchTranslationExpander->addTranslations(
                $this->restUnpaginatedCatalogSearchAttributesTransferMock,
                $this->localeName
            )
        );
    }
}
