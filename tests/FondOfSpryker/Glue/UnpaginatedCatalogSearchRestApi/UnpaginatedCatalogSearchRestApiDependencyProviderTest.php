<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi;

use Codeception\Test\Unit;
use Spryker\Glue\Kernel\Container;

class UnpaginatedCatalogSearchRestApiDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\UnpaginatedCatalogSearchRestApiDependencyProvider
     */
    protected $unpaginatedCatalogSearchRestApiDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container
     */
    protected $containerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->unpaginatedCatalogSearchRestApiDependencyProvider = new UnpaginatedCatalogSearchRestApiDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->unpaginatedCatalogSearchRestApiDependencyProvider->provideDependencies(
                $this->containerMock
            )
        );
    }
}
