<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi;

use Codeception\Test\Unit;

class UnpaginatedCatalogSearchRestApiConfigTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\UnpaginatedCatalogSearchRestApiConfig
     */
    protected $unpaginatedCatalogSearchRestApiConfig;

    /**
     * @var int
     */
    protected $pageLimit;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->pageLimit = 1;

        $this->unpaginatedCatalogSearchRestApiConfig = new class (
            $this->pageLimit
        ) extends UnpaginatedCatalogSearchRestApiConfig {
            /**
             * @var \Spryker\Shared\Config\Config
             */
            protected $pageLimit;

            /**
             * @param int $pageLimit
             */
            public function __construct(int $pageLimit)
            {
                $this->pageLimit = $pageLimit;
            }

            /**
             * @param string $key
             * @param string|null $default
             *
             * @return int
             */
            protected function get($key, $default = null): int
            {
                return $this->pageLimit;
            }
        };
    }

    /**
     * @return void
     */
    public function testGetDefaultPageLimit(): void
    {
        $this->assertSame(
            $this->pageLimit,
            $this->unpaginatedCatalogSearchRestApiConfig->getDefaultPageLimit()
        );
    }
}
