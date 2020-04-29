<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CurrencyTransfer;
use Spryker\Client\Currency\CurrencyClientInterface;

class UnpaginatedCatalogSearchRestApiToCurrencyClientBridgeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCurrencyClientBridge
     */
    protected $unpaginatedCatalogSearchRestApiToCurrencyClientBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Currency\CurrencyClientInterface
     */
    protected $currencyClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CurrencyTransfer
     */
    protected $currencyTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->currencyClientInterfaceMock = $this->getMockBuilder(CurrencyClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currencyTransferMock = $this->getMockBuilder(CurrencyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->unpaginatedCatalogSearchRestApiToCurrencyClientBridge = new UnpaginatedCatalogSearchRestApiToCurrencyClientBridge(
            $this->currencyClientInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testGetCurrent(): void
    {
        $this->currencyClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getCurrent')
            ->willReturn($this->currencyTransferMock);

        $this->assertInstanceOf(
            CurrencyTransfer::class,
            $this->unpaginatedCatalogSearchRestApiToCurrencyClientBridge->getCurrent()
        );
    }
}
