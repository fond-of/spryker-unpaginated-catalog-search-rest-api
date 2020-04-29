<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client;

use Codeception\Test\Unit;
use Spryker\Client\GlossaryStorage\GlossaryStorageClientInterface;

class UnpaginatedCatalogSearchRestApiToGlossaryStorageClientBridgeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToGlossaryStorageClientBridge
     */
    protected $unpaginatedCatalogSearchRestApiToGlossaryStorageClientBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\GlossaryStorage\GlossaryStorageClientInterface
     */
    protected $glossaryStorageClientInterface;

    /**
     * @var string
     */
    protected $translation;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $localeName;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->glossaryStorageClientInterface = $this->getMockBuilder(GlossaryStorageClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->translation = 'translation';

        $this->id = 'id';

        $this->localeName = 'locale-name';

        $this->unpaginatedCatalogSearchRestApiToGlossaryStorageClientBridge = new UnpaginatedCatalogSearchRestApiToGlossaryStorageClientBridge(
            $this->glossaryStorageClientInterface
        );
    }

    /**
     * @return void
     */
    public function testTranslate(): void
    {
        $this->glossaryStorageClientInterface->expects($this->atLeastOnce())
            ->method('translate')
            ->with($this->id, $this->localeName)
            ->willReturn($this->translation);

        $this->assertSame(
            $this->translation,
            $this->unpaginatedCatalogSearchRestApiToGlossaryStorageClientBridge->translate(
                $this->id,
                $this->localeName
            )
        );
    }
}
