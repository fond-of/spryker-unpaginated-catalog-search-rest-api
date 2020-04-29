<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi;

use Codeception\Test\Unit;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCatalogClientInterface;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCurrencyClientInterface;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToGlossaryStorageClientInterface;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToPriceClientInterface;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Catalog\UnpaginatedCatalogSearchReaderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\Kernel\Container;

class UnpaginatedCatalogSearchRestApiFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\UnpaginatedCatalogSearchRestApiFactory
     */
    protected $unpaginatedCatalogSearchRestApiFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\UnpaginatedCatalogSearchRestApiConfig
     */
    protected $unpaginatedCatalogSearchRestApiConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCatalogClientInterface
     */
    protected $unpaginatedCatalogSearchRestApiToCatalogClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToPriceClientInterface
     */
    protected $unpaginatedCatalogSearchRestApiToPriceClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCurrencyClientInterface
     */
    protected $unpaginatedCatalogSearchRestApiToCurrencyClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToGlossaryStorageClientInterface
     */
    protected $unpaginatedCatalogSearchRestApiToGlossaryStorageClientInterfaceMock;

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

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->unpaginatedCatalogSearchRestApiToCatalogClientInterfaceMock = $this->getMockBuilder(UnpaginatedCatalogSearchRestApiToCatalogClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->unpaginatedCatalogSearchRestApiToPriceClientInterfaceMock = $this->getMockBuilder(UnpaginatedCatalogSearchRestApiToPriceClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->unpaginatedCatalogSearchRestApiToCurrencyClientInterfaceMock = $this->getMockBuilder(UnpaginatedCatalogSearchRestApiToCurrencyClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->unpaginatedCatalogSearchRestApiToGlossaryStorageClientInterfaceMock = $this->getMockBuilder(UnpaginatedCatalogSearchRestApiToGlossaryStorageClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->unpaginatedCatalogSearchRestApiFactory = new class (
            $this->restResourceBuilderInterfaceMock
        ) extends UnpaginatedCatalogSearchRestApiFactory {
            /**
             * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
             */
            protected $restResourceBuilder;

            /**
             * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
             */
            public function __construct(RestResourceBuilderInterface $restResourceBuilder)
            {
                $this->restResourceBuilder = $restResourceBuilder;
            }

            /**
             * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
             */
            public function getResourceBuilder(): RestResourceBuilderInterface
            {
                return $this->restResourceBuilder;
            }
        };
        $this->unpaginatedCatalogSearchRestApiFactory->setContainer($this->containerMock);
        $this->unpaginatedCatalogSearchRestApiFactory->setConfig($this->unpaginatedCatalogSearchRestApiConfigMock);
    }

    /**
     * @return void
     */
    public function testCreateUnpaginatedCatalogSearchReader(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [UnpaginatedCatalogSearchRestApiDependencyProvider::CLIENT_CATALOG],
                [UnpaginatedCatalogSearchRestApiDependencyProvider::CLIENT_PRICE],
                [UnpaginatedCatalogSearchRestApiDependencyProvider::CLIENT_CURRENCY],
                [UnpaginatedCatalogSearchRestApiDependencyProvider::CLIENT_GLOSSARY_STORAGE]
            )->willReturnOnConsecutiveCalls(
                $this->unpaginatedCatalogSearchRestApiToCatalogClientInterfaceMock,
                $this->unpaginatedCatalogSearchRestApiToPriceClientInterfaceMock,
                $this->unpaginatedCatalogSearchRestApiToCurrencyClientInterfaceMock,
                $this->unpaginatedCatalogSearchRestApiToGlossaryStorageClientInterfaceMock
            );

        $this->assertInstanceOf(
            UnpaginatedCatalogSearchReaderInterface::class,
            $this->unpaginatedCatalogSearchRestApiFactory->createUnpaginatedCatalogSearchReader()
        );
    }
}
