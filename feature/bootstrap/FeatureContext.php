<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use EricksonReyes\RestApiResponse\Error;
use EricksonReyes\RestApiResponse\Errors;
use EricksonReyes\RestApiResponse\ErrorSource;
use EricksonReyes\RestApiResponse\ErrorSourceType;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiRelationship;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiRelationships;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResource;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResources;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResponse;
use EricksonReyes\RestApiResponse\Link;
use EricksonReyes\RestApiResponse\Links;
use EricksonReyes\RestApiResponse\Meta;
use EricksonReyes\RestApiResponse\Resource;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{

    /**
     * @var array
     */
    private array $articles = [];

    /**
     * @var array
     */
    private array $authors = [];

    /**
     * @var array
     */
    private array $pagination = [];

    /**
     * @var string
     */
    private string $baseUrl;

    /**
     * @var array
     */
    private array $links = [];

    /**
     * @var array
     */
    private array $exceptions = [];

    /**
     * @var array
     */
    private array $meta = [];

    /**
     * @var array
     */
    private array $metaCollection = [];

    /**
     * @var int
     */
    private int $httpResponseStatusCode = 0;

    /**
     * @var \EricksonReyes\RestApiResponse\JsonApi\JsonApiResponse|null
     */
    private ?JsonApiResponse $jsonApiResponse;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @return void
     * @BeforeScenario
     */
    public function beforeScenario(): void
    {
        $this->authors = [];
        $this->articles = [];
        $this->pagination = [];
        $this->exceptions = [];
        $this->meta = [];
        $this->metaCollection = [];
        $this->baseUrl = '';
        $this->links = [];
    }

    /**
     * @Given there is the following articles:
     * @throws \Exception
     */
    public function thereIsTheFollowingArticles(TableNode $articles): void
    {
        foreach ($articles as $article) {
            $created = (new \DateTimeImmutable($article['created']));
            $updated = (new \DateTimeImmutable($article['updated']));

            $this->articles[$article['id']] = [
                'id' => $article['id'],
                'type' => 'article',
                'attributes' => [
                    'title' => $article['title'],
                    'body' => $article['body'],
                    'created' => $created->getTimestamp(),
                    'updated' => $updated->getTimestamp()
                ]
            ];

            if (isset($article['author_id'])) {
                $this->articles[$article['id']]['relationships'] = [
                    [
                        'id' => $article['author_id'],
                        'type' => 'people'
                    ]
                ];
            }
        }
    }

    /**
     * @Given there is the following authors:
     */
    public function thereIsTheFollowingAuthors(TableNode $authors): void
    {
        foreach ($authors as $author) {
            $this->authors[$author['id']] = [
                'id' => $author['id'],
                'type' => 'people',
                'attributes' => [
                    'first_name' => $author['first_name'],
                    'last_name' => $author['last_name'],
                    'age' => (string)$author['age'],
                    'gender' => $author['gender']
                ]
            ];
        }
    }

    /**
     * @Given there is the following links:
     */
    public function thereIsTheFollowingLinks(TableNode $links): void
    {
        foreach ($links as $link) {
            $this->links[] = [
                'name' => $link['name'],
                'url' => $link['url']
            ];
        }
    }

    /**
     * @Given the base url is :arg1
     */
    public function theBaseUrlIs(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }


    /**
     * @Given there are :arg1 total articles
     */
    public function thereAreTotalArticles(int $expectedTotalNumberOfRecords): void
    {
        $this->pagination['total_number_of_records'] = $expectedTotalNumberOfRecords;
    }

    /**
     * @Given the current page number is :arg1
     */
    public function theCurrentPageNumberIs(int $currentPageNumber): void
    {
        $this->pagination['page_number'] = $currentPageNumber;
    }

    /**
     * @Given the maximum records per page is :arg1
     */
    public function theMaximumRecordsPerPageIs(int $maximumRecordsPerPage): void
    {
        $this->pagination['records_per_page'] = $maximumRecordsPerPage;
    }

    /**
     * @Given there is an exception raised with the following information:
     */
    public function thereIsAnExceptionRaisedWithTheFollowingInformation(TableNode $exceptions): void
    {
        foreach ($exceptions as $exception) {
            $exceptionArray = [];

            if (isset($exception['status'])) {
                $exceptionArray['status'] = $exception['status'];
            }

            if (isset($exception['code'])) {
                $exceptionArray['code'] = $exception['code'];
            }

            if (isset($exception['title'])) {
                $exceptionArray['title'] = $exception['title'];
            }

            if (isset($exception['source'])) {
                $exceptionArray['source'] = $exception['source'];
            }

            if (isset($exception['title'])) {
                $exceptionArray['title'] = $exception['title'];
            }

            if (isset($exception['detail'])) {
                $exceptionArray['detail'] = $exception['detail'];
            }

            $this->exceptions[] = $exceptionArray;
        }
    }

    /**
     * @Given there is the following meta information:
     */
    public function thereIsTheFollowingMetaInformation(TableNode $metas): void
    {
        foreach ($metas as $meta) {
            $this->meta[] = [
                'title' => $meta['title'],
                'description' => $meta['description']
            ];
        }
    }

    /**
     * @Given there is the following :arg1 meta collection:
     */
    public function thereIsTheFollowingMetaCollection(string $collectionName, TableNode $collection): void
    {
        foreach ($collection as $meta) {
            $this->metaCollection[$collectionName][] = $meta['name'];
        }
    }

    /**
     * @Given the http response status code is :arg1
     */
    public function theHttpResponseStatusIs(int $httpResponseStatusCode): void
    {
        $this->httpResponseStatusCode = $httpResponseStatusCode;
    }

    /**
     * @When a JSON API response is asked to be generated
     */
    public function AJSONAPIResponseIsAskedToBeGenerated(): void
    {
        $resources = new JsonApiResources('data');
        $this->jsonApiResponse = new JsonApiResponse();

        if (!empty($this->baseUrl)) {
            $baseUrl = $this->baseUrl;
            $resources->setBaseUrl(baseUrl: $baseUrl);
        }

        if (!empty($this->articles)) {
            foreach ($this->articles as $article) {
                $id = $article['id'];
                $type = $article['type'];
                $attributes = $article['attributes'];

                $resource = new JsonApiResource(id: $id, type: $type, attributes: $attributes);
                if (isset($article['relationships'])) {
                    $relationships = new JsonApiRelationships(relation: 'author');
                    foreach ($article['relationships'] as $relationship) {
                        $id = $relationship['id'];
                        $type = $relationship['type'];
                        $relationship = new JsonApiRelationship(id: $id, type: $type);

                        $relationships->addRelationship($relationship);
                    }
                    $resource->withRelationships($relationships);
                }

                $resources->addResource($resource);
            }
        }

        if (($this->pagination['total_number_of_records'] ?? 0) > 0 &&
            ($this->pagination['records_per_page'] ?? 0) > 0 &&
            ($this->pagination['page_number'] ?? 0) > 0
        ) {
            $totalNumberOfRecords = (int)$this->pagination['total_number_of_records'];
            $recordsPerPage = (int)$this->pagination['records_per_page'];
            $currentPageNumber = (int)$this->pagination['page_number'];

            $resources->withPagination(
                numberOfRecords: $totalNumberOfRecords,
                recordsPerPage: $recordsPerPage,
                currentPageNumber: $currentPageNumber
            );
        }

        if (!empty($this->links)) {
            $links = new Links();
            foreach ($this->links as $link) {
                $name = $link['name'];
                $url = $link['url'];

                $link = new Link(name: $name, url: $url);
                $links->addLink($link);
            }
            $resources->withLinks($links);
        }

        if (!empty($this->authors)) {
            foreach ($this->authors as $author) {
                $id = $author['id'];
                $type = $author['type'];
                $attributes = $author['attributes'];

                $includedResource = new Resource(id: $id, type: $type, attributes: $attributes);
                $resources->addIncludedResource($includedResource);
            }
        }

        if (!empty($this->exceptions)) {
            $errors = new Errors();
            foreach ($this->exceptions as $exception) {
                $status = (int)$exception['status'];
                $title = $exception['title'];

                $error = new Error(httpStatusCode: $status, title: $title);

                if (isset($exception['source'])) {
                    $source = $exception['source'];
                    $type = ErrorSourceType::Pointer;

                    $errorSource = new ErrorSource(type: $type, source: $source);
                    $error->fromSource(source: $errorSource);
                }

                if (isset($exception['code'])) {
                    $code = $exception['code'];
                    $error->withCode(code: $code);
                }

                if (isset($exception['detail'])) {
                    $detail = $exception['detail'];
                    $error->withDetail(detail: $detail);
                }

                $errors->addError($error);
            }
            $this->jsonApiResponse->withErrors($errors);
        }

        if (!empty($this->meta)) {
            $meta = new Meta();
            foreach ($this->meta as $metaArray) {
                $title = $metaArray['title'];
                $description = $metaArray['description'];
                $meta->addMetaData($title, $description);
            }
            $this->jsonApiResponse->withMeta($meta);
        }

        if (!empty($this->metaCollection)) {
            if (!isset($meta)) {
                $meta = new Meta();
            }

            foreach ($this->metaCollection as $collectionName => $metaCollection) {
                $meta->addMetaData($collectionName, $metaCollection);
            }
            $this->jsonApiResponse->withMeta($meta);
        }


        if (!empty($this->links)) {
            $links = new Links();
            foreach ($this->links as $linkArray) {
                $name = $linkArray['name'];
                $url = $linkArray['url'];
                $link = new Link($name, $url);
                $links->addLink($link);
            }
        }

        $this->jsonApiResponse->withResources($resources);
        $this->jsonApiResponse->setHttpStatusCode($this->httpResponseStatusCode);
    }

    /**
     * @Then the library will return:
     */
    public function theLibraryWillReturn(PyStringNode $expectedStringResponse): void
    {
        assert(
            $this->jsonApiResponse->array() === json_decode($expectedStringResponse->getRaw(), true),
            'Expected JSON response body was not met. Actual response body is: ' .
            $this->jsonApiResponse
        );
    }

    /**
     * @Then the http response status code should be :arg1
     */
    public function theHttpResponseStatusCodeShouldBe(int $expectedHttpResponseStatusCode): void
    {
        assert(
            $this->jsonApiResponse->httpStatusCode() === $expectedHttpResponseStatusCode,
            'Expected HTTP status code was not met. Actual HTTP status code is: ' .
            $this->jsonApiResponse->httpStatusCode()
        );
    }

    /**
     * @Then the media type should be :arg1
     */
    public function theMediaTypeShouldBe(string $expectedMediaType): void
    {
        assert(
            $this->jsonApiResponse->mediaType() === $expectedMediaType,
            'Expected media type was not met. Actual media type is: ' .
            $this->jsonApiResponse->mediaType()
        );
    }
}
