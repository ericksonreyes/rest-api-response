<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
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
     * @var \EricksonReyes\RestApiResponse\ResourceInterface[]
     */
    private array $articles = [];

    /**
     * @var \EricksonReyes\RestApiResponse\ResourceInterface[]
     */
    private array $authors = [];

    /**
     * @var array
     */
    private array $relationships = [];

    /**
     * @var string
     */
    private string $baseUrl;

    /**
     * @var array
     */
    private array $links = [];

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
            $articleId = $article['id'];
            $type = 'article';
            $created = (new DateTimeImmutable($article['created']));
            $updated = (new DateTimeImmutable($article['updated']));

            $attributes = [
                'title' => $article['title'],
                'body' => $article['body'],
                'author_id' => $article['author_id'],
                'created' => $created->format(DateTimeInterface::ATOM),
                'updated' => $updated->format(DateTimeInterface::ATOM)
            ];
            $this->articles[$articleId] = new Resource(id: $articleId, type: $type, attributes: $attributes);
            $this->relationships[$articleId] = new JsonApiRelationship($article['author_id'], 'people');
        }
    }

    /**
     * @Given there is the following authors:
     */
    public function thereIsTheFollowingAuthors(TableNode $authors): void
    {
        foreach ($authors as $author) {
            $id = $author['id'];
            $type = 'people';
            $attributes = [
                'first_name' => $author['first_name'],
                'last_name' => $author['last_name'],
                'age' => (string)$author['age'],
                'gender' => $author['gender']
            ];
            $this->authors[$id] = new Resource(id: $id, type: $type, attributes: $attributes);
        }
    }

    /**
     * @Given there is the following links:
     */
    public function thereIsTheFollowingLinks(TableNode $links): void
    {
        foreach ($links as $link) {
            $name = $link['name'];
            $url = $link['url'];
            $this->links[] = new Link(name: $name, url: $url);
        }
    }

    /**
     * @Given the http response status code is :arg1
     */
    public function theHttpResponseStatusIs(int $httpResponseStatusCode): void
    {
        throw new PendingException();
    }

    /**
     * @When a JSON API response is asked to be generated
     */
    public function AJSONAPIResponseIsAskedToBeGenerated(): void
    {
        $resources = new JsonApiResources('data');
        $this->jsonApiResponse = new JsonApiResponse();

        if (!empty($this->articles)) {
            foreach ($this->articles as $article) {
                $resource = new JsonApiResource(
                    $article->id(),
                    $article->type(),
                    $article->attributes()
                );

                $relationships = new JsonApiRelationships('authors');
                foreach ($this->relationships as $articleId => $author) {
                    if ($article->id() === (string)$articleId) {
                        $relationships->addRelationship($author);
                    }
                }
                $resource->withRelationships($relationships);

                $resources->addResource($resource);
            }
        }

        if (!empty($this->links)) {
            $links = new Links();
            foreach ($this->links as $link) {
                $links->addLink($link);
            }
            $resources->withLinks($links);
        }


        if (!empty($this->authors)) {
            foreach ($this->authors as $author) {
                $resources->addIncludedResource(
                    new Resource(
                        $author->id(),
                        $author->type(),
                        $author->attributes()
                    )
                );
            }
        }

        $this->jsonApiResponse->withResources($resources);
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

    /**
     * @Given there are :arg1 total pages in the collection
     */
    public function thereAreTotalPagesInTheCollection(int $expectedTotalPages): void
    {
        throw new PendingException();
    }

    /**
     * @Given the current page number is :arg1
     */
    public function theCurrentPageNumberIs(int $currentPageNumber): void
    {
        throw new PendingException();
    }

    /**
     * @Given the maximum records per page is :arg1
     */
    public function theMaximumRecordsPerPageIs(int $maximumRecordsPerPage): void
    {
        throw new PendingException();
    }

    /**
     * @Given the base url is :arg1
     */
    public function theBaseUrlIs(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @Given there is an exception raised with the following information:
     */
    public function thereIsAnExceptionRaisedWithTheFollowingInformation(TableNode $exceptions): void
    {
        throw new PendingException();
    }

    /**
     * @Given there is the following meta information:
     */
    public function thereIsTheFollowingMetaInformation(TableNode $metaCollection): void
    {
        throw new PendingException();
    }

    /**
     * @Given there is the following :arg1 meta collection:
     */
    public function thereIsTheFollowingMetaCollection(string $metaCollectionName, TableNode $metaCollection): void
    {
        throw new PendingException();
    }
}
