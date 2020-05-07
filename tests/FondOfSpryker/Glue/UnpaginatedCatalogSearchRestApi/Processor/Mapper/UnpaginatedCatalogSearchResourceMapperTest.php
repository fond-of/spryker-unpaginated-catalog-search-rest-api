<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Mapper;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCurrencyClientInterface;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\FacetConfigTransfer;
use Generated\Shared\Transfer\FacetSearchResultTransfer;
use Generated\Shared\Transfer\PaginationSearchResultTransfer;
use Generated\Shared\Transfer\PriceModeConfigurationTransfer;
use Generated\Shared\Transfer\RangeSearchResultTransfer;
use Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAbstractProductsTransfer;
use Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer;

class UnpaginatedCatalogSearchResourceMapperTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Mapper\UnpaginatedCatalogSearchResourceMapper
     */
    protected $unpaginatedCatalogSearchResourceMapper;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCurrencyClientInterface
     */
    protected $unpaginatedCatalogSearchRestApiToCurrencyClientInterfaceMock;

    /**
     * @var array
     */
    protected $restSearchResponse;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PaginationSearchResultTransfer
     */
    protected $paginationSearchResultTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\FacetSearchResultTransfer
     */
    protected $facetSearchResultTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RangeSearchResultTransfer
     */
    protected $rangeSearchResultTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\FacetConfigTransfer
     */
    protected $facetConfigTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer
     */
    protected $restUnpaginatedCatalogSearchAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceModeConfigurationTransfer
     */
    protected $priceModeConfigurationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAbstractProductsTransfer
     */
    protected $restUnpaginatedCatalogSearchAbstractProductsTransferMock;

    /**
     * @var \ArrayObject|\Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAbstractProductsTransfer[]
     */
    protected $abstractProducts;

    /**
     * @var int[]
     */
    protected $prices;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CurrencyTransfer
     */
    protected $currencyTransferMock;

    /**
     * @var string
     */
    protected $currentPriceMode;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->unpaginatedCatalogSearchRestApiToCurrencyClientInterfaceMock = $this->getMockBuilder(UnpaginatedCatalogSearchRestApiToCurrencyClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->paginationSearchResultTransferMock = $this->getMockBuilder(PaginationSearchResultTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facetSearchResultTransferMock = $this->getMockBuilder(FacetSearchResultTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->rangeSearchResultTransferMock = $this->getMockBuilder(RangeSearchResultTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facetConfigTransferMock = $this->getMockBuilder(FacetConfigTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restUnpaginatedCatalogSearchAttributesTransferMock = $this->getMockBuilder(RestUnpaginatedCatalogSearchAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceModeConfigurationTransferMock = $this->getMockBuilder(PriceModeConfigurationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restUnpaginatedCatalogSearchAbstractProductsTransferMock = $this->getMockBuilder(RestUnpaginatedCatalogSearchAbstractProductsTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->abstractProducts = new ArrayObject([
            $this->restUnpaginatedCatalogSearchAbstractProductsTransferMock,
        ]);

        $this->prices = [
            'abstract' => 1,
        ];

        $this->restSearchResponse = [
            'products' => [
                [],
            ],
            'facets' => [
                $this->facetSearchResultTransferMock,
                $this->rangeSearchResultTransferMock,
            ],
            'sort' => $this->paginationSearchResultTransferMock,
        ];

        $this->currencyTransferMock = $this->getMockBuilder(CurrencyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currentPriceMode = 'current-price-mock';

        $this->unpaginatedCatalogSearchResourceMapper = new UnpaginatedCatalogSearchResourceMapper(
            $this->unpaginatedCatalogSearchRestApiToCurrencyClientInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testMapSearchResultToRestAttributesTransfer(): void
    {
        $this->paginationSearchResultTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->facetSearchResultTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->facetSearchResultTransferMock->expects($this->atLeastOnce())
            ->method('getConfig')
            ->willReturn($this->facetConfigTransferMock);

        $this->facetConfigTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->rangeSearchResultTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->rangeSearchResultTransferMock->expects($this->atLeastOnce())
            ->method('getConfig')
            ->willReturn($this->facetConfigTransferMock);

        $this->assertInstanceOf(
            RestUnpaginatedCatalogSearchAttributesTransfer::class,
            $this->unpaginatedCatalogSearchResourceMapper->mapSearchResultToRestAttributesTransfer(
                $this->restSearchResponse
            )
        );
    }

    /**
     * @return void
     */
    public function testMapSearchResultToRestAttributesTransferNoKeys(): void
    {
        $this->paginationSearchResultTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->assertInstanceOf(
            RestUnpaginatedCatalogSearchAttributesTransfer::class,
            $this->unpaginatedCatalogSearchResourceMapper->mapSearchResultToRestAttributesTransfer(
                [
                    'sort' => $this->paginationSearchResultTransferMock,
                ]
            )
        );
    }

    /**
     * @return void
     */
    public function testMapPrices(): void
    {
        $this->restUnpaginatedCatalogSearchAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getAbstractProducts')
            ->willReturn($this->abstractProducts);

        $this->restUnpaginatedCatalogSearchAbstractProductsTransferMock->expects($this->atLeastOnce())
            ->method('getPrices')
            ->willReturn($this->prices);

        $this->unpaginatedCatalogSearchRestApiToCurrencyClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getCurrent')
            ->willReturn($this->currencyTransferMock);

        $this->currencyTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->priceModeConfigurationTransferMock->expects($this->atLeastOnce())
            ->method('getCurrentPriceMode')
            ->willReturn($this->currentPriceMode);

        $this->priceModeConfigurationTransferMock->expects($this->atLeastOnce())
            ->method('getGrossModeIdentifier')
            ->willReturn($this->currentPriceMode);

        $this->assertInstanceOf(
            RestUnpaginatedCatalogSearchAttributesTransfer::class,
            $this->unpaginatedCatalogSearchResourceMapper->mapPrices(
                $this->restUnpaginatedCatalogSearchAttributesTransferMock,
                $this->priceModeConfigurationTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testMapPricesPriceModeNetModeIdentifier(): void
    {
        $this->restUnpaginatedCatalogSearchAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getAbstractProducts')
            ->willReturn($this->abstractProducts);

        $this->restUnpaginatedCatalogSearchAbstractProductsTransferMock->expects($this->atLeastOnce())
            ->method('getPrices')
            ->willReturn($this->prices);

        $this->unpaginatedCatalogSearchRestApiToCurrencyClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getCurrent')
            ->willReturn($this->currencyTransferMock);

        $this->currencyTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->priceModeConfigurationTransferMock->expects($this->atLeastOnce())
            ->method('getCurrentPriceMode')
            ->willReturn($this->currentPriceMode);

        $this->priceModeConfigurationTransferMock->expects($this->atLeastOnce())
            ->method('getGrossModeIdentifier')
            ->willReturn('');

        $this->priceModeConfigurationTransferMock->expects($this->atLeastOnce())
            ->method('getNetModeIdentifier')
            ->willReturn($this->currentPriceMode);

        $this->assertInstanceOf(
            RestUnpaginatedCatalogSearchAttributesTransfer::class,
            $this->unpaginatedCatalogSearchResourceMapper->mapPrices(
                $this->restUnpaginatedCatalogSearchAttributesTransferMock,
                $this->priceModeConfigurationTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testMapPricesNone(): void
    {
        $this->restUnpaginatedCatalogSearchAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getAbstractProducts')
            ->willReturn($this->abstractProducts);

        $this->restUnpaginatedCatalogSearchAbstractProductsTransferMock->expects($this->atLeastOnce())
            ->method('getPrices')
            ->willReturn($this->prices);

        $this->unpaginatedCatalogSearchRestApiToCurrencyClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getCurrent')
            ->willReturn($this->currencyTransferMock);

        $this->currencyTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->priceModeConfigurationTransferMock->expects($this->atLeastOnce())
            ->method('getCurrentPriceMode')
            ->willReturn($this->currentPriceMode);

        $this->priceModeConfigurationTransferMock->expects($this->atLeastOnce())
            ->method('getGrossModeIdentifier')
            ->willReturn('');

        $this->priceModeConfigurationTransferMock->expects($this->atLeastOnce())
            ->method('getNetModeIdentifier')
            ->willReturn('');

        $this->assertInstanceOf(
            RestUnpaginatedCatalogSearchAttributesTransfer::class,
            $this->unpaginatedCatalogSearchResourceMapper->mapPrices(
                $this->restUnpaginatedCatalogSearchAttributesTransferMock,
                $this->priceModeConfigurationTransferMock
            )
        );
    }
}
