<?php

namespace EricksonReyes\RestApiResponse\JsonApi;

use EricksonReyes\RestApiResponse\Errors;
use EricksonReyes\RestApiResponse\ErrorsInterface;
use EricksonReyes\RestApiResponse\ErrorSourceInterface;
use EricksonReyes\RestApiResponse\Meta;
use EricksonReyes\RestApiResponse\MetaInterface;
use EricksonReyes\RestApiResponse\ResourcesInterface;

/**
 * Class JsonApiResponse
 * @package EricksonReyes\RestApiResponse\JsonApi
 */
class JsonApiResponse implements JsonApiResponseInterface
{

    public const API_SPECIFICATION_NAME = 'jsonapi';

    public const API_VERSION = '1.1';

    private const HTTP_STATUS_600 = 600;

    private const HTTP_STATUS_100 = 100;

    private const HTTP_STATUS_OK = 200;

    /**
     * @var int
     */
    private int $httpStatusCode = self::HTTP_STATUS_OK;

    /**
     * @var string
     */
    private string $httpResponseDescription = 'OK';

    /**
     * @var \EricksonReyes\RestApiResponse\ErrorsInterface
     */
    private ErrorsInterface $errors;

    /**
     * @var \EricksonReyes\RestApiResponse\MetaInterface
     */
    private MetaInterface $meta;

    /**
     * @var \EricksonReyes\RestApiResponse\JsonApi\JsonApiResourcesInterface
     */
    private JsonApiResourcesInterface $resources;


    public function __construct()
    {
        $this->errors = new Errors();
        $this->resources = new JsonApiResources();
        $this->meta = new Meta();
    }

    /**
     * @param \EricksonReyes\RestApiResponse\JsonApi\JsonApiResourcesInterface $resources
     * @return void
     */
    public function withResources(JsonApiResourcesInterface $resources): void
    {
        $this->resources = $resources;
    }

    /**
     * @return \EricksonReyes\RestApiResponse\ResourcesInterface
     */
    public function resources(): ResourcesInterface
    {
        return $this->resources;
    }

    /**
     * @return bool
     */
    public function hasResources(): bool
    {
        return $this->resources->count() > 0;
    }

    /**
     * @return bool
     */
    public function hasNoResources(): bool
    {
        return $this->hasResources() === false;
    }


    /**
     * @return string
     */
    public function mediaType(): string
    {
        return JsonApiResponseMediaTypeInterface::RESPONSE_MEDIA_TYPE_JSON_API;
    }

    /**
     * @return string
     */
    public function specificationName(): string
    {
        return self::API_SPECIFICATION_NAME;
    }

    /**
     * @return string
     */
    public function specificationVersion(): string
    {
        return self::API_VERSION;
    }

    /**
     * @param int $httpStatusCode
     * @return void
     */
    public function setHttpStatusCode(int $httpStatusCode): void
    {
        if ($httpStatusCode >= self::HTTP_STATUS_100 && $httpStatusCode < self::HTTP_STATUS_600) {
            $this->httpStatusCode = $httpStatusCode;
        }
    }

    /**
     * @param string $httpResponseDescription
     * @return void
     */
    public function describeHttpResponse(string $httpResponseDescription): void
    {
        $this->httpResponseDescription = $httpResponseDescription;
    }

    /**
     * @return int
     */
    public function httpStatusCode(): int
    {
        if ($this->errors->isNotEmpty() && $this->httpStatusCode === self::HTTP_STATUS_OK) {
            foreach ($this->errors->errors() as $error) {
                $this->httpStatusCode = $error->httpStatusCode();
            }
        }

        return $this->httpStatusCode;
    }

    /**
     * @return string
     */
    public function httpResponseDescription(): string
    {
        return $this->httpResponseDescription;
    }

    /**
     * @param \EricksonReyes\RestApiResponse\MetaInterface $meta
     * @return void
     */
    public function withMeta(MetaInterface $meta): void
    {
        $this->meta = $meta;
    }

    /**
     * @return \EricksonReyes\RestApiResponse\MetaInterface
     */
    public function meta(): MetaInterface
    {
        return $this->meta;
    }

    /**
     * @param \EricksonReyes\RestApiResponse\ErrorsInterface $errors
     * @return void
     */
    public function withErrors(ErrorsInterface $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * @return \EricksonReyes\RestApiResponse\ErrorsInterface
     */
    public function errors(): ErrorsInterface
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return $this->errors->count() > 0;
    }

    /**
     * @return bool
     */
    public function hasNoErrors(): bool
    {
        return $this->hasErrors() === false;
    }


    /**
     * @return array
     */
    public function array(): array
    {
        $response = [
            $this->specificationName() => [
                'version' => $this->specificationVersion()
            ]
        ];

        $response = $this->addMeta($response);
        $response = $this->addLinks($response);
        $response = $this->addPaginationMetaData($response);
        $response = $this->addResources($response);
        $response = $this->addErrors($response);
        return $this->addPaginationLinks($response);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode($this->array(), JSON_PRETTY_PRINT);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->array();
    }

    /**
     * @param array $response
     * @return array
     */
    private function addResources(array $response): array
    {
        $response['data'] = [];
        foreach ($this->resources as $index => $resource) {
            $response['data'][$index] = [
                'type' => $resource->type(),
                'id' => $resource->id(),
                'attributes' => $resource->attributes()
            ];
            $response = $this->addRelationships($resource, $response, $index);
        }

        return $response;
    }

    /**
     * @param \EricksonReyes\RestApiResponse\JsonApi\JsonApiResourceInterface $resource
     * @param array $response
     * @param int $resourceIndex
     * @return array
     */
    private function addRelationships(JsonApiResourceInterface $resource, array $response, int $resourceIndex): array
    {
        $hasRelationships = count($resource->relationships()) > 0;

        if ($hasRelationships) {
            $resources = $resource->relationships();
            foreach ($resources as $name => $resource) {
                $response['data'][$resourceIndex]['relationships'][$name]['data'] = [
                    'id' => $resource->id(),
                    'type' => $resource->type()
                ];

                $response['included'][] = [
                    'type' => $resource->type(),
                    'id' => $resource->id(),
                    'attributes' => $resource->attributes(),
                ];
            }
        }
        return $response;
    }

    /**
     * @param array $response
     * @return array
     */
    private function addLinks(array $response): array
    {
        $baseUrl = '';
        if (empty($this->resources->baseUrl()) === false) {
            $baseUrl = $this->resources->baseUrl();
            $response['links']['self'] = $baseUrl;
        }

        if (empty($this->resources->links()) === false) {
            foreach ($this->resources->links() as $link) {
                $response['links'][$link->name()] = $baseUrl . $link->url();
            }
        }
        return $response;
    }

    /**
     * @param array $response
     * @return array
     */
    private function addErrors(array $response): array
    {
        if ($this->errors()->isNotEmpty()) {
            /**
             * @var $error \EricksonReyes\RestApiResponse\ErrorInterface
             */
            foreach ($this->errors() as $errorIndex => $error) {
                $errorArray = [];
                $errorArray['status'] = (string)$error->httpStatusCode();

                if ($error->source() instanceof ErrorSourceInterface) {
                    $type = $error->source()->type()->name();
                    $source = $error->source()->source();
                    $errorArray['source'][$type] = $source;
                }

                if (empty($error->code()) === false) {
                    $errorArray['code'] = $error->code();
                }
                if (empty($error->title()) === false) {
                    $errorArray['title'] = $error->title();
                }
                if (empty($error->detail()) === false) {
                    $errorArray['detail'] = $error->detail();
                }

                $response['errors'][$errorIndex] = $errorArray;
            }
        }

        return $response;
    }

    /**
     * @param array $response
     * @return array
     */
    private function addPaginationMetaData(array $response): array
    {
        if ($this->resources->numberOfPages() > 0) {
            $response['meta']['total'] = (string)$this->resources->numberOfRecords();

            if ($this->resources->recordsPerPage() > 0) {
                $response['meta']['page']['size'] = (string)$this->resources->recordsPerPage();
            }
            if ($this->resources->numberOfPages() > 0) {
                $response['meta']['page']['total'] = (string)$this->resources->numberOfPages();
            }
            if ($this->resources->firstPage() > 0) {
                $response['meta']['page']['first'] = (string)$this->resources->firstPage();
            }
            if ($this->resources->previousPage() > 0) {
                $response['meta']['page']['previous'] = (string)$this->resources->previousPage();
            }
            if ($this->resources->currentPageNumber() > 0) {
                $response['meta']['page']['current'] = (string)$this->resources->currentPageNumber();
            }
            if ($this->resources->nextPage() > 0) {
                $response['meta']['page']['next'] = (string)$this->resources->nextPage();
            }
            if ($this->resources->lastPage() > 0) {
                $response['meta']['page']['last'] = (string)$this->resources->lastPage();
            }
        }
        return $response;
    }

    /**
     * @param array $response
     * @return array
     */
    private function addMeta(array $response): array
    {
        if ($this->meta()->isNotEmpty()) {
            foreach ($this->meta()->meta() as $key => $value) {
                $response['meta'][$key] = $value;
            }
        }

        return $response;
    }

    /**
     * @param array $response
     * @return array
     */
    private function addPaginationLinks(array $response): array
    {
        if ($this->resources->numberOfPages() > 0) {
            if ($this->resources->firstPage() > 0) {
                $response['links']['first'] = $this->formatPaginationUrl($this->resources->firstPage());
            }
            if ($this->resources->previousPage() > 0) {
                $response['links']['previous'] = $this->formatPaginationUrl($this->resources->previousPage());
            }
            if ($this->resources->nextPage() > 0) {
                $response['links']['next'] = $this->formatPaginationUrl($this->resources->nextPage());
            }
            if ($this->resources->lastPage() > 0) {
                $response['links']['last'] = $this->formatPaginationUrl($this->resources->lastPage());
            }
        }
        return $response;
    }

    /**
     * @param int $pageNumber
     * @return string
     */
    private function formatPaginationUrl(int $pageNumber): string
    {
        $url = $this->resources->baseUrl();

        $recordsPerPage = $this->resources->recordsPerPage();

        $pattern = '/page\[number\]=\d+/';
        $url = preg_replace($pattern, 'page[number]=' . $pageNumber, $url);

        $pattern = '/page\[size\]=\d+/';
        return preg_replace($pattern, 'page[size]=' . $recordsPerPage, $url);
    }
}
