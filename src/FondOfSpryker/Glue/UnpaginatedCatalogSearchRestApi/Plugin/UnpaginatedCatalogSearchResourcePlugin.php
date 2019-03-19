<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Plugin;

use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\UnpaginatedCatalogSearchRestApiConfig;
use Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class UnpaginatedCatalogSearchResourcePlugin extends AbstractPlugin implements ResourceRoutePluginInterface
{
    /**
     * @api
     *
     * Specification:
     *  - Configuration for resource routing, how http methods map to controller actions, is action is protected, also possible
     * to add additional contextual data for action for later access when processing controller action.
     *
     * @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface $resourceRouteCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    public function configure(
        ResourceRouteCollectionInterface $resourceRouteCollection
    ): ResourceRouteCollectionInterface {
        $resourceRouteCollection
            ->addGet('get', false);

        return $resourceRouteCollection;
    }

    /**
     * @api
     *
     * Specification:
     *  - Resource name this plugins handles, must be plural string. This name also is matched with request path where resource
     * is provided.
     *
     * @return string
     */
    public function getResourceType(): string
    {
        return UnpaginatedCatalogSearchRestApiConfig::RESOURCE_UNPAGINATED_CATALOG_SEARCH;
    }

    /**
     * @api
     *
     * Specification:
     *  - Module controller name, separated by dashes. cart-items-resource would point to CartItemsResourceController
     *
     * @return string
     */
    public function getController(): string
    {
        return UnpaginatedCatalogSearchRestApiConfig::CONTROLLER_UNPAGINATED_CATALOG_SEARCH;
    }

    /**
     * @api
     *
     * Specification:
     *  - This method should return FQCN to transfer object. This object will be automatically populated from POST/PATCH
     * requests, and passed to REST controller actions as first argument. It is also used when creating JSONAPI resource objects.
     *
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestUnpaginatedCatalogSearchAttributesTransfer::class;
    }
}
