<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client;

use Codeception\Test\Unit;
use Spryker\Client\Catalog\CatalogClientInterface;

class UnpaginatedCatalogSearchRestApiToCatalogClientBridgeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCatalogClientBridge
     */
    protected $unpaginatedCatalogSearchRestApiToCatalogClientBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Catalog\CatalogClientInterface
     */
    protected $catalogClientInterfaceMock;

    /**
     * @var string
     */
    protected $searchString;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->catalogClientInterfaceMock = $this->getMockBuilder(CatalogClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->searchString = 'search-string';

        $this->unpaginatedCatalogSearchRestApiToCatalogClientBridge = new UnpaginatedCatalogSearchRestApiToCatalogClientBridge(
            $this->catalogClientInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testCatalogSearch(): void
    {
        $this->catalogClientInterfaceMock->expects($this->atLeastOnce())
            ->method('catalogSearch')
            ->with($this->searchString, [])
            ->willReturn([]);

        $this->assertIsArray(
            $this->unpaginatedCatalogSearchRestApiToCatalogClientBridge->catalogSearch(
                $this->searchString
            )
        );
    }
}
