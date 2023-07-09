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
     * @var string
     */
    private string $mediaType = '';

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
            $created = (new DateTimeImmutable($article['created']));
            $updated = (new DateTimeImmutable($article['updated']));

            $this->articles[$article['id']] = [
                'id' => $article['id'],
                'type' => 'article',
                'attributes' => [
                    'title' => $article['title'],
                    'body' => $article['body'],
                    'created' => $created->format(DateTimeInterface::ATOM),
                    'updated' => $updated->format(DateTimeInterface::ATOM)
                ],
                'relationships' => [
                    [
                        'id' => $article['author_id'],
                        'type' => 'people'
                    ]
                ]
            ];
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
            $resources->setBaseUrl($this->baseUrl);
        }

        if (!empty($this->articles)) {
            foreach ($this->articles as $article) {
                $resource = new JsonApiResource(
                    id: $article['id'],
                    type: $article['type'],
                    attributes: $article['attributes']
                );

                $relationships = new JsonApiRelationships('author');
                foreach ($article['relationships'] as $relationship) {
                    $relationships->addRelationship(
                        new JsonApiRelationship(
                            id: $relationship['id'],
                            type: $relationship['type']
                        )
                    );
                }
                $resource->withRelationships($relationships);

                $resources->addResource($resource);
            }
        }

        if (($this->pagination['total_number_of_records'] ?? 0) > 0 &&
            ($this->pagination['records_per_page'] ?? 0) > 0 &&
            ($this->pagination['page_number'] ?? 0) > 0
        ) {
            $resources->withPagination(
                numberOfRecords: $this->pagination['total_number_of_records'],
                recordsPerPage: $this->pagination['records_per_page'],
                currentPageNumber: $this->pagination['page_number']
            );
        }

        if (!empty($this->links)) {
            $links = new Links();
            foreach ($this->links as $link) {
                $links->addLink(
                    new Link(
                        name: $link['name'],
                        url: $link['url']
                    )
                );
            }
            $resources->withLinks($links);
        }


        if (!empty($this->authors)) {
            foreach ($this->authors as $author) {
                $resources->addIncludedResource(
                    new Resource(
                        id: $author['id'],
                        type: $author['type'],
                        attributes: $author['attributes']
                    )
                );
            }
        }

        if (!empty($this->exceptions)) {
            $errors = new Errors();
            foreach ($this->exceptions as $exception) {
                $error = new Error(
                    status: (int)$exception['status'],
                    title: $exception['title'],
                );

                if (isset($exception['source'])) {
                    $errorSource = new ErrorSource(
                        type: ErrorSourceType::Pointer,
                        source: $exception['source']
                    );
                    $error->fromSource(source: $errorSource);
                }

                if (isset($exception['code'])) {
                    $error->withCode(code: $exception['code']);
                }

                if (isset($exception['detail'])) {
                    $error->withDetail(detail: $exception['detail']);
                }

                $errors->addError($error);
            }
            $this->jsonApiResponse->withErrors($errors);
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
