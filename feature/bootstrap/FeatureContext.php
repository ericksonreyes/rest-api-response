<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
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
     * @Given there is the following articles:
     */
    public function thereIsTheFollowingArticles(TableNode $articles)
    {
        throw new PendingException();
    }

    /**
     * @Given there is the following authors:
     */
    public function thereIsTheFollowingAuthors(TableNode $authors)
    {
        throw new PendingException();
    }

    /**
     * @Given the http response status code is :arg1
     */
    public function theHttpResponseStatusIs(int $httpResponseStatusCode)
    {
        throw new PendingException();
    }

    /**
     * @When the response is asked to be generated
     */
    public function theResponseIsAskedToBeGenerated()
    {
        throw new PendingException();
    }

    /**
     * @Then the library will return:
     */
    public function theLibraryWillReturn(PyStringNode $expectedStringResponse)
    {
        throw new PendingException();
    }

    /**
     * @Then the http response status code should be :arg1
     */
    public function theHttpResponseStatusCodeShouldBe(int $expectedHttpResponseStatusCode)
    {
        throw new PendingException();
    }

    /**
     * @Given there are :arg1 total pages in the collection
     */
    public function thereAreTotalPagesInTheCollection(int $expectedTotalPages)
    {
        throw new PendingException();
    }

    /**
     * @Given the current page number is :arg1
     */
    public function theCurrentPageNumberIs(int $currentPageNumber)
    {
        throw new PendingException();
    }

    /**
     * @Given the maximum records per page is :arg1
     */
    public function theMaximumRecordsPerPageIs(int $maximumRecordsPerPage)
    {
        throw new PendingException();
    }

    /**
     * @Given the base url is :arg1
     */
    public function theBaseUrlIs(string $baseUrl)
    {
        throw new PendingException();
    }

    /**
     * @Given there is an exception raised with the following information:
     */
    public function thereIsAnExceptionRaisedWithTheFollowingInformation(TableNode $exceptions)
    {
        throw new PendingException();
    }

    /**
     * @Given there is the following meta information:
     */
    public function thereIsTheFollowingMetaInformation(TableNode $metaCollection)
    {
        throw new PendingException();
    }

    /**
     * @Given there is the following :arg1 meta collection:
     */
    public function thereIsTheFollowingMetaCollection(string $metaCollectionName, TableNode $metaCollection)
    {
        throw new PendingException();
    }
}
