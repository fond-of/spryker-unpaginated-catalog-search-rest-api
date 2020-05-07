<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client;

use Codeception\Test\Unit;
use Spryker\Client\Price\PriceClientInterface;

class UnpaginatedCatalogSearchRestApiToPriceClientBridgeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToPriceClientBridge
     */
    protected $unpaginatedCatalogSearchRestApiToPriceClientBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Price\PriceClientInterface
     */
    protected $priceClientInterfaceMock;

    /**
     * @var string
     */
    protected $currentPriceMode;

    /**
     * @var string
     */
    protected $priceMode;

    /**
     * @var string
     */
    protected $grossPriceModeIdentifier;

    /**
     * @var string
     */
    protected $netPriceModeIdentifier;

    /**
     * @var string[]
     */
    protected $priceModes;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->priceClientInterfaceMock = $this->getMockBuilder(PriceClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currentPriceMode = 'current-price-mode';

        $this->priceMode = 'price-mode';

        $this->grossPriceModeIdentifier = 'gross-price-mode-identifier';

        $this->netPriceModeIdentifier = 'net-price-mode-identifier';

        $this->priceModes = [
            $this->priceMode,
        ];

        $this->unpaginatedCatalogSearchRestApiToPriceClientBridge = new UnpaginatedCatalogSearchRestApiToPriceClientBridge(
            $this->priceClientInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testGetCurrentPriceMode(): void
    {
        $this->priceClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getCurrentPriceMode')
            ->willReturn($this->currentPriceMode);

        $this->assertSame(
            $this->currentPriceMode,
            $this->unpaginatedCatalogSearchRestApiToPriceClientBridge->getCurrentPriceMode()
        );
    }

    /**
     * @return void
     */
    public function testSwitchPriceMode(): void
    {
        $this->priceClientInterfaceMock->expects($this->atLeastOnce())
            ->method('switchPriceMode')
            ->with($this->priceMode);

        $this->unpaginatedCatalogSearchRestApiToPriceClientBridge->switchPriceMode(
            $this->priceMode
        );
    }

    /**
     * @return void
     */
    public function testGetGrossPriceModeIdentifier(): void
    {
        $this->priceClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getGrossPriceModeIdentifier')
            ->willReturn($this->grossPriceModeIdentifier);

        $this->assertSame(
            $this->grossPriceModeIdentifier,
            $this->unpaginatedCatalogSearchRestApiToPriceClientBridge->getGrossPriceModeIdentifier()
        );
    }

    /**
     * @return void
     */
    public function testGetNetPriceModeIdentifier(): void
    {
        $this->priceClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getNetPriceModeIdentifier')
            ->willReturn($this->netPriceModeIdentifier);

        $this->assertSame(
            $this->netPriceModeIdentifier,
            $this->unpaginatedCatalogSearchRestApiToPriceClientBridge->getNetPriceModeIdentifier()
        );
    }

    /**
     * @return void
     */
    public function testGetPriceModes(): void
    {
        $this->priceClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getPriceModes')
            ->willReturn($this->priceModes);

        $this->assertIsArray(
            $this->unpaginatedCatalogSearchRestApiToPriceClientBridge->getPriceModes()
        );
    }
}
