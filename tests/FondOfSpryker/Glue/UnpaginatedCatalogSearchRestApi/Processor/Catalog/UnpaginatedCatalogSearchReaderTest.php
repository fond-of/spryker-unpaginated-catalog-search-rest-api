<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Catalog;

use Codeception\Test\Unit;
use Exception;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCatalogClientInterface;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToPriceClientInterface;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Mapper\UnpaginatedCatalogSearchResourceMapperInterface;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Translation\UnpaginatedCatalogSearchTranslationExpanderInterface;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\UnpaginatedCatalogSearchRestApiConfig;
use Generated\Shared\Transfer\PaginationSearchResultTransfer;
use Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\MetadataInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class UnpaginatedCatalogSearchReaderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Catalog\UnpaginatedCatalogSearchReader
     */
    protected $unpaginatedCatalogSearchReader;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\UnpaginatedCatalogSearchRestApiConfig
     */
    protected $unpaginatedCatalogSearchRestApiConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCatalogClientInterface
     */
    protected $unpaginatedCatalogSearchRestApiToCatalogClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToPriceClientInterface
     */
    protected $unpaginatedCatalogSearchRestApiToPriceClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Mapper\UnpaginatedCatalogSearchResourceMapperInterface
     */
    protected $unpaginatedCatalogSearchResourceMapperInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Translation\UnpaginatedCatalogSearchTranslationExpanderInterface
     */
    protected $unpaginatedCatalogSearchTranslationExpanderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Symfony\Component\HttpFoundation\Request
     */
    protected $requestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Symfony\Component\HttpFoundation\ParameterBag
     */
    protected $parameterBagMock;

    /**
     * @var string
     */
    protected $requestParameter;

    /**
     * @var string[]
     */
    protected $allRequestParameters;

    /**
     * @var int
     */
    protected $defaultPageLimit;

    /**
     * @var array
     */
    protected $searchResult;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PaginationSearchResultTransfer
     */
    protected $paginationSearchResultTransferMock;

    /**
     * @var int
     */
    protected $currentPage;

    /**
     * @var int
     */
    protected $maxPage;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer
     */
    protected $restUnpaginatedCatalogSearchAttributesTransferMock;

    /**
     * @var string
     */
    protected $currentPriceMode;

    /**
     * @var string
     */
    protected $grossPriceModeIdentifier;

    /**
     * @var string
     */
    protected $netPriceModeIdentifier;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\MetadataInterface
     */
    protected $metadataInterfaceMock;

    /**
     * @var string
     */
    protected $localeString;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $restResourceInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Exception
     */
    protected $exceptionMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restResourceBuilderInterfaceMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->unpaginatedCatalogSearchRestApiConfigMock = $this->getMockBuilder(UnpaginatedCatalogSearchRestApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->unpaginatedCatalogSearchRestApiToCatalogClientInterfaceMock = $this->getMockBuilder(UnpaginatedCatalogSearchRestApiToCatalogClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->unpaginatedCatalogSearchRestApiToPriceClientInterfaceMock = $this->getMockBuilder(UnpaginatedCatalogSearchRestApiToPriceClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->unpaginatedCatalogSearchResourceMapperInterfaceMock = $this->getMockBuilder(UnpaginatedCatalogSearchResourceMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->unpaginatedCatalogSearchTranslationExpanderInterfaceMock = $this->getMockBuilder(UnpaginatedCatalogSearchTranslationExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestInterfaceMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestMock = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->parameterBagMock = $this->getMockBuilder(ParameterBag::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestMock->query = $this->parameterBagMock;

        $this->requestParameter = 'request-parameter';

        $this->allRequestParameters = [
            $this->requestParameter,
        ];

        $this->defaultPageLimit = 1;

        $this->paginationSearchResultTransferMock = $this->getMockBuilder(PaginationSearchResultTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->searchResult = [
            'pagination' => $this->paginationSearchResultTransferMock,
            'products' => [
                'product',
            ],
        ];

        $this->currentPage = 2;

        $this->maxPage = 3;

        $this->currentPriceMode = 'current-price-mode';

        $this->grossPriceModeIdentifier = 'gross-price-mode-identifier';

        $this->netPriceModeIdentifier = 'net-price-mode-identifier';

        $this->restUnpaginatedCatalogSearchAttributesTransferMock = $this->getMockBuilder(RestUnpaginatedCatalogSearchAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->metadataInterfaceMock = $this->getMockBuilder(MetadataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeString = 'locale-string';

        $this->restResourceInterfaceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseInterfaceMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->exceptionMock = $this->getMockBuilder(Exception::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->unpaginatedCatalogSearchReader = new UnpaginatedCatalogSearchReader(
            $this->restResourceBuilderInterfaceMock,
            $this->unpaginatedCatalogSearchRestApiConfigMock,
            $this->unpaginatedCatalogSearchRestApiToCatalogClientInterfaceMock,
            $this->unpaginatedCatalogSearchRestApiToPriceClientInterfaceMock,
            $this->unpaginatedCatalogSearchResourceMapperInterfaceMock,
            $this->unpaginatedCatalogSearchTranslationExpanderInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testUnpaginatedCatalogSearch(): void
    {
        $this->restRequestInterfaceMock->expects($this->atLeastOnce())
            ->method('getHttpRequest')
            ->willReturn($this->requestMock);

        $this->parameterBagMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(UnpaginatedCatalogSearchRestApiConfig::QUERY_STRING_PARAMETER, '')
            ->willReturn($this->requestParameter);

        $this->parameterBagMock->expects($this->atLeastOnce())
            ->method('all')
            ->willReturn($this->allRequestParameters);

        $this->unpaginatedCatalogSearchRestApiConfigMock->expects($this->atLeastOnce())
            ->method('getDefaultPageLimit')
            ->willReturn($this->defaultPageLimit);

        $this->unpaginatedCatalogSearchRestApiToCatalogClientInterfaceMock->expects($this->atLeastOnce())
            ->method('catalogSearch')
            ->willReturn($this->searchResult);

        $this->paginationSearchResultTransferMock->expects($this->atLeastOnce())
            ->method('getCurrentPage')
            ->willReturnOnConsecutiveCalls($this->currentPage, $this->currentPage, $this->maxPage);

        $this->paginationSearchResultTransferMock->expects($this->atLeastOnce())
            ->method('getMaxPage')
            ->willReturn($this->maxPage);

        $this->unpaginatedCatalogSearchResourceMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapSearchResultToRestAttributesTransfer')
            ->willReturn($this->restUnpaginatedCatalogSearchAttributesTransferMock);

        $this->unpaginatedCatalogSearchRestApiToPriceClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getCurrentPriceMode')
            ->willReturn($this->currentPriceMode);

        $this->unpaginatedCatalogSearchRestApiToPriceClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getGrossPriceModeIdentifier')
            ->willReturn($this->grossPriceModeIdentifier);

        $this->unpaginatedCatalogSearchRestApiToPriceClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getNetPriceModeIdentifier')
            ->willReturn($this->netPriceModeIdentifier);

        $this->unpaginatedCatalogSearchResourceMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapPrices')
            ->with($this->restUnpaginatedCatalogSearchAttributesTransferMock)
            ->willReturn($this->restUnpaginatedCatalogSearchAttributesTransferMock);

        $this->restRequestInterfaceMock->expects($this->atLeastOnce())
            ->method('getMetadata')
            ->willReturn($this->metadataInterfaceMock);

        $this->metadataInterfaceMock->expects($this->atLeastOnce())
            ->method('getLocale')
            ->willReturn($this->localeString);

        $this->unpaginatedCatalogSearchTranslationExpanderInterfaceMock->expects($this->atLeastOnce())
            ->method('addTranslations')
            ->with($this->restUnpaginatedCatalogSearchAttributesTransferMock, $this->localeString)
            ->willReturn($this->restUnpaginatedCatalogSearchAttributesTransferMock);

        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResource')
            ->with(
                UnpaginatedCatalogSearchRestApiConfig::RESOURCE_UNPAGINATED_CATALOG_SEARCH,
                null,
                $this->restUnpaginatedCatalogSearchAttributesTransferMock
            )->willReturn($this->restResourceInterfaceMock);

        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseInterfaceMock);

        $this->restResponseInterfaceMock->expects($this->atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceInterfaceMock)
            ->willReturnSelf();

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->unpaginatedCatalogSearchReader->unpaginatedCatalogSearch(
                $this->restRequestInterfaceMock
            )
        );
    }

    /**
     * @return void
     */
    public function testUnpaginatedCatalogSearchUnpaginatedCatalogSearchError(): void
    {
        $this->restRequestInterfaceMock->expects($this->atLeastOnce())
            ->method('getHttpRequest')
            ->willReturn($this->requestMock);

        $this->parameterBagMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(UnpaginatedCatalogSearchRestApiConfig::QUERY_STRING_PARAMETER, '')
            ->willReturn($this->requestParameter);

        $this->parameterBagMock->expects($this->atLeastOnce())
            ->method('all')
            ->willReturn($this->allRequestParameters);

        $this->unpaginatedCatalogSearchRestApiConfigMock->expects($this->atLeastOnce())
            ->method('getDefaultPageLimit')
            ->willReturn($this->defaultPageLimit);

        $this->unpaginatedCatalogSearchRestApiToCatalogClientInterfaceMock->expects($this->atLeastOnce())
            ->method('catalogSearch')
            ->willThrowException($this->exceptionMock);

        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseInterfaceMock);

        $this->restResponseInterfaceMock->expects($this->atLeastOnce())
            ->method('addError')
            ->willReturnSelf();

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->unpaginatedCatalogSearchReader->unpaginatedCatalogSearch(
                $this->restRequestInterfaceMock
            )
        );
    }

    /**
     * @return void
     */
    public function testUnpaginatedCatalogSearchProductNull(): void
    {
        $this->restRequestInterfaceMock->expects($this->atLeastOnce())
            ->method('getHttpRequest')
            ->willReturn($this->requestMock);

        $this->parameterBagMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(UnpaginatedCatalogSearchRestApiConfig::QUERY_STRING_PARAMETER, '')
            ->willReturn($this->requestParameter);

        $this->parameterBagMock->expects($this->atLeastOnce())
            ->method('all')
            ->willReturn($this->allRequestParameters);

        $this->unpaginatedCatalogSearchRestApiConfigMock->expects($this->atLeastOnce())
            ->method('getDefaultPageLimit')
            ->willReturn($this->defaultPageLimit);

        $this->unpaginatedCatalogSearchRestApiToCatalogClientInterfaceMock->expects($this->atLeastOnce())
            ->method('catalogSearch')
            ->willReturn([
                'pagination' => $this->paginationSearchResultTransferMock,
                'products' => [],
            ]);

        $this->paginationSearchResultTransferMock->expects($this->atLeastOnce())
            ->method('getCurrentPage')
            ->willReturnOnConsecutiveCalls($this->currentPage, $this->currentPage, $this->maxPage);

        $this->paginationSearchResultTransferMock->expects($this->atLeastOnce())
            ->method('getMaxPage')
            ->willReturn($this->maxPage);

        $this->unpaginatedCatalogSearchResourceMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapSearchResultToRestAttributesTransfer')
            ->willReturn($this->restUnpaginatedCatalogSearchAttributesTransferMock);

        $this->unpaginatedCatalogSearchRestApiToPriceClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getCurrentPriceMode')
            ->willReturn($this->currentPriceMode);

        $this->unpaginatedCatalogSearchRestApiToPriceClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getGrossPriceModeIdentifier')
            ->willReturn($this->grossPriceModeIdentifier);

        $this->unpaginatedCatalogSearchRestApiToPriceClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getNetPriceModeIdentifier')
            ->willReturn($this->netPriceModeIdentifier);

        $this->unpaginatedCatalogSearchResourceMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapPrices')
            ->with($this->restUnpaginatedCatalogSearchAttributesTransferMock)
            ->willReturn($this->restUnpaginatedCatalogSearchAttributesTransferMock);

        $this->restRequestInterfaceMock->expects($this->atLeastOnce())
            ->method('getMetadata')
            ->willReturn($this->metadataInterfaceMock);

        $this->metadataInterfaceMock->expects($this->atLeastOnce())
            ->method('getLocale')
            ->willReturn($this->localeString);

        $this->unpaginatedCatalogSearchTranslationExpanderInterfaceMock->expects($this->atLeastOnce())
            ->method('addTranslations')
            ->with($this->restUnpaginatedCatalogSearchAttributesTransferMock, $this->localeString)
            ->willReturn($this->restUnpaginatedCatalogSearchAttributesTransferMock);

        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResource')
            ->with(
                UnpaginatedCatalogSearchRestApiConfig::RESOURCE_UNPAGINATED_CATALOG_SEARCH,
                null,
                $this->restUnpaginatedCatalogSearchAttributesTransferMock
            )->willReturn($this->restResourceInterfaceMock);

        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseInterfaceMock);

        $this->restResponseInterfaceMock->expects($this->atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceInterfaceMock)
            ->willReturnSelf();

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->unpaginatedCatalogSearchReader->unpaginatedCatalogSearch(
                $this->restRequestInterfaceMock
            )
        );
    }
}
