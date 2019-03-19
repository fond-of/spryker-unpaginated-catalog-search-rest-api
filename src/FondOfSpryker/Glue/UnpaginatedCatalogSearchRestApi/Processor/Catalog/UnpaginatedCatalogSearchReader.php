<?php

namespace FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Catalog;

use Exception;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCatalogClientInterface;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToPriceClientInterface;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Exception\ArrayKeyDoesNotExistException;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Exception\InvalidInstanceTypeException;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Mapper\UnpaginatedCatalogSearchResourceMapperInterface;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Translation\UnpaginatedCatalogSearchTranslationExpanderInterface;
use FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\UnpaginatedCatalogSearchRestApiConfig;
use Generated\Shared\Transfer\PaginationSearchResultTransfer;
use Generated\Shared\Transfer\PriceModeConfigurationTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Symfony\Component\HttpFoundation\Response;

class UnpaginatedCatalogSearchReader implements UnpaginatedCatalogSearchReaderInterface
{
    /**
     * @uses \Spryker\Client\Catalog\Plugin\Config\CatalogSearchConfigBuilder::PARAMETER_NAME_PAGE;
     */
    protected const PARAMETER_NAME_PAGE = 'page';

    /**
     * @uses \Spryker\Client\Catalog\Plugin\Config\CatalogSearchConfigBuilder::PARAMETER_NAME_ITEMS_PER_PAGE;
     */
    protected const PARAMETER_NAME_ITEMS_PER_PAGE = 'ipp';

    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    private $restResourceBuilder;

    /**
     * @var \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\UnpaginatedCatalogSearchRestApiConfig
     */
    protected $config;

    /**
     * @var \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCatalogClientInterface
     */
    protected $catalogClient;

    /**
     * @var \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToPriceClientInterface
     */
    protected $priceClient;

    /**
     * @var \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Mapper\UnpaginatedCatalogSearchResourceMapperInterface
     */
    protected $unpaginatedCatalogSearchResourceMapper;

    /**
     * @var \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Translation\UnpaginatedCatalogSearchTranslationExpanderInterface
     */
    protected $unpaginatedCatalogSearchTranslationExpander;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\UnpaginatedCatalogSearchRestApiConfig $config
     * @param \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToCatalogClientInterface $catalogClient
     * @param \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Dependency\Client\UnpaginatedCatalogSearchRestApiToPriceClientInterface $priceClient
     * @param \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Mapper\UnpaginatedCatalogSearchResourceMapperInterface $unpaginatedCatalogSearchResourceMapper
     * @param \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Processor\Translation\UnpaginatedCatalogSearchTranslationExpanderInterface $unpaginatedCatalogSearchTranslationExpander
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        UnpaginatedCatalogSearchRestApiConfig $config,
        UnpaginatedCatalogSearchRestApiToCatalogClientInterface $catalogClient,
        UnpaginatedCatalogSearchRestApiToPriceClientInterface $priceClient,
        UnpaginatedCatalogSearchResourceMapperInterface $unpaginatedCatalogSearchResourceMapper,
        UnpaginatedCatalogSearchTranslationExpanderInterface $unpaginatedCatalogSearchTranslationExpander
    ) {
        $this->restResourceBuilder = $restResourceBuilder;
        $this->config = $config;
        $this->catalogClient = $catalogClient;
        $this->priceClient = $priceClient;
        $this->unpaginatedCatalogSearchResourceMapper = $unpaginatedCatalogSearchResourceMapper;
        $this->unpaginatedCatalogSearchTranslationExpander = $unpaginatedCatalogSearchTranslationExpander;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function unpaginatedCatalogSearch(RestRequestInterface $restRequest): RestResponseInterface
    {
        $searchString = $this->getRequestParameter($restRequest, UnpaginatedCatalogSearchRestApiConfig::QUERY_STRING_PARAMETER);
        $requestParameters = $this->getAllRequestParameters($restRequest);

        try {
            $searchResult = $this->catalogSearch($searchString, $requestParameters);
        } catch (Exception $e) {
            return $this->buildUnpaginatedCatalogSearchErrorResponse($e);
        }

        $restSearchAttributesTransfer = $this->unpaginatedCatalogSearchResourceMapper
            ->mapSearchResultToRestAttributesTransfer($searchResult);

        $this->unpaginatedCatalogSearchResourceMapper
            ->mapPrices($restSearchAttributesTransfer, $this->getPriceModeConfigurationTransfer());

        $restSearchAttributesTransfer = $this->unpaginatedCatalogSearchTranslationExpander
            ->addTranslations($restSearchAttributesTransfer, $restRequest->getMetadata()->getLocale());

        return $this->buildUnpaginatedCatalogSearchResponse($restSearchAttributesTransfer);
    }

    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @throws
     *
     * @return array
     */
    protected function catalogSearch(string $searchString, array $requestParameters = []): array
    {
        $searchResult = $this->catalogClient->catalogSearch($searchString, $requestParameters);

        $this->validateSearchResult($searchResult);

        /** @var \Generated\Shared\Transfer\PaginationSearchResultTransfer $pagination */
        $pagination = $searchResult['pagination'];

        if ($pagination->getCurrentPage() === $pagination->getMaxPage()) {
            return $searchResult;
        }

        $requestParameters[static::PARAMETER_NAME_PAGE] = $pagination->getCurrentPage() + 1;
        $searchResultToMerge = $this->catalogSearch($searchString, $requestParameters);

        if (count($searchResultToMerge['products']) === 0) {
            return $searchResult;
        }

        $searchResult['products'] = array_merge($searchResult['products'], $searchResultToMerge['products']);

        return $searchResult;
    }

    /**
     * @param array $searchResult
     *
     * @throws \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Exception\ArrayKeyDoesNotExistException
     * @throws \FondOfSpryker\Glue\UnpaginatedCatalogSearchRestApi\Exception\InvalidInstanceTypeException
     *
     * @return void
     */
    protected function validateSearchResult(array $searchResult): void
    {
        if (!array_key_exists('pagination', $searchResult)) {
            throw new ArrayKeyDoesNotExistException('Pagination is missing.');
        }

        if (!($searchResult['pagination'] instanceof PaginationSearchResultTransfer)) {
            throw new InvalidInstanceTypeException('Wrong instance for pagination.');
        }

        if (!array_key_exists('products', $searchResult)) {
            throw new ArrayKeyDoesNotExistException('Products are missing');
        }
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param string $parameterName
     *
     * @return string
     */
    protected function getRequestParameter(RestRequestInterface $restRequest, string $parameterName): string
    {
        return $restRequest->getHttpRequest()->query->get($parameterName, '');
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return array
     */
    protected function getAllRequestParameters(RestRequestInterface $restRequest): array
    {
        $params = $restRequest->getHttpRequest()->query->all();

        $params[static::PARAMETER_NAME_ITEMS_PER_PAGE] = $this->config->getDefaultPageLimit();

        return $params;
    }

    /**
     * @return \Generated\Shared\Transfer\PriceModeConfigurationTransfer
     */
    protected function getPriceModeConfigurationTransfer(): PriceModeConfigurationTransfer
    {
        $priceModeConfiguration = new PriceModeConfigurationTransfer();

        $priceModeConfiguration->setCurrentPriceMode($this->priceClient->getCurrentPriceMode());
        $priceModeConfiguration->setGrossModeIdentifier($this->priceClient->getGrossPriceModeIdentifier());
        $priceModeConfiguration->setNetModeIdentifier($this->priceClient->getNetPriceModeIdentifier());

        return $priceModeConfiguration;
    }

    /**
     * @param \Generated\Shared\Transfer\RestUnpaginatedCatalogSearchAttributesTransfer $restSearchAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function buildUnpaginatedCatalogSearchResponse(
        RestUnpaginatedCatalogSearchAttributesTransfer $restSearchAttributesTransfer
    ): RestResponseInterface {
        $restResource = $this->restResourceBuilder->createRestResource(
            UnpaginatedCatalogSearchRestApiConfig::RESOURCE_UNPAGINATED_CATALOG_SEARCH,
            null,
            $restSearchAttributesTransfer
        );

        $response = $this->restResourceBuilder->createRestResponse();

        return $response->addResource($restResource);
    }

    /**
     * @param \Exception $exception
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function buildUnpaginatedCatalogSearchErrorResponse(Exception $exception): RestResponseInterface
    {
        $response = $this->restResourceBuilder->createRestResponse();

        $restErrorTransfer = (new RestErrorMessageTransfer())
            ->setCode($exception->getCode())
            ->setStatus(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->setDetail($exception->getMessage());

        return $response->addError($restErrorTransfer);
    }
}
