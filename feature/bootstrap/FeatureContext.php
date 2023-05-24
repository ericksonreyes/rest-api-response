<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use EricksonReyes\RestApiResponse\Link;
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
     * @var string
     */
    private string $baseUrl;

    /**
     * @var array
     */
    private array $links = [];

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
            $id = $article['id'];
            $type = 'article';
            $created = (new DateTimeImmutable($article['created']));
            $updated = (new DateTimeImmutable($article['updated']));

            $attributes = [
                'title' => $article['title'],
                'body' => $article['body'],
                'author_id' => $article['author_id'],
                'created' => $created,
                'updated' => $updated
            ];
            $this->articles[$id] = new Resource(id: $id, type: $type, attributes: $attributes);
        }
    }

    /**
     * @Given there is the following authors:
     */
    public function thereIsTheFollowingAuthors(TableNode $authors): void
    {
        foreach ($authors as $author) {
            $id = $author['id'];
            $type = 'author';
            $attributes = [
                'first_name' => $author['first_name'],
                'last_name' => $author['last_name'],
                'age' => $author['age'],
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
     * @When a JSON API response is asked to be generated
     */
    public function AJSONAPIResponseIsAskedToBeGenerated(): void
    {
        throw new PendingException();
    }

    /**
     * @Then the library will return:
     */
    public function theLibraryWillReturn(PyStringNode $expectedStringResponse): void
    {
        throw new PendingException();
    }

    /**
     * @Then the http response status code is :arg1
     */
    public function theHttpResponseStatusIs(int $httpResponseStatusCode): void
    {
        throw new PendingException();
    }

    /**
     * @Then the http response status code should be :arg1
     */
    public function theHttpResponseStatusCodeShouldBe(int $expectedHttpResponseStatusCode): void
    {
        throw new PendingException();
    }

    /**
     * @Then the media type should be :arg1
     */
    public function theMediaTypeShouldBe(string $mediaType): void
    {
        throw new PendingException();
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
