<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Plugin;

use Codeception\Test\Unit;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\UnpaginatedCatalogSearchRestApiConfig;
use Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class UnpaginatedCatalogSearchResourcePluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Plugin\UnpaginatedCatalogSearchResourcePlugin
     */
    protected $unpaginatedCatalogSearchResourcePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    protected $resourceRouteCollectionInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->resourceRouteCollectionInterfaceMock = $this->getMockBuilder(ResourceRouteCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->unpaginatedCatalogSearchResourcePlugin = new UnpaginatedCatalogSearchResourcePlugin();
    }

    /**
     * @return void
     */
    public function testConfigure(): void
    {
        $this->resourceRouteCollectionInterfaceMock->expects($this->atLeastOnce())
            ->method('addGet')
            ->with('get', false)
            ->willReturnSelf();

        $this->assertInstanceOf(
            ResourceRouteCollectionInterface::class,
            $this->unpaginatedCatalogSearchResourcePlugin->configure(
                $this->resourceRouteCollectionInterfaceMock
            )
        );
    }

    /**
     * @return void
     */
    public function testGetResourceType(): void
    {
        $this->assertSame(
            UnpaginatedCatalogSearchRestApiConfig::RESOURCE_UNPAGINATED_CATALOG_SEARCH,
            $this->unpaginatedCatalogSearchResourcePlugin->getResourceType()
        );
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        $this->assertSame(
            UnpaginatedCatalogSearchRestApiConfig::CONTROLLER_UNPAGINATED_CATALOG_SEARCH,
            $this->unpaginatedCatalogSearchResourcePlugin->getController()
        );
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        $this->assertSame(
            RestUnpaginatedCatalogSearchAttributesTransfer::class,
            $this->unpaginatedCatalogSearchResourcePlugin->getResourceAttributesClassName()
        );
    }
}
