Feature: Generating a JSON API collection
  As a REST API Developer
  I want a REST API response generator library


  Scenario: Generating a JSON API collection.
    Given there is the following articles:
      | id | title                       | body                                     | author_id | created                      | updated                  |
      | 1  | Basketball for kids.        | Learn basketball at early age.           | 8         | May 22, 2015 02:59:29 AM     | May 22, 2015 02:59:30 AM |
      | 2  | Swimming for Middle School. | Play and slay in middle school swimming. | 9         | January 22, 2019 02:59:29 AM | 2019-02-22 06:00:30 AM   |
    And there is the following authors:
      | id | first_name | last_name | age | gender |
      | 8  | Seiji      | Reyes     | 10  | male   |
      | 9  | Summer     | Reyes     | 13  | female |
    When the response is asked to be generated
    Then the library will return:
      """
      {
        {
          "jsonapi": {
            "version": "1.1"
          }
        },
        "data": [
          {
            "type": "articles",
            "id": "1",
            "attributes": {
              "title": "Basketball for kids.",
              "body": "Learn basketball at early age.",
              "created": "2015-05-22T14:56:29.000Z",
              "updated": "2015-05-22T14:56:30.000Z"
            },
            "relationships": {
              "author": {
                "data": {
                  "id": "8",
                  "type": "people"
                }
              }
            }
          },
          {
            "type": "articles",
            "id": "2",
            "attributes": {
              "title": "Swimming for Middle School.",
              "body": "Play and slay in middle school swimming.",
              "created": "2019-01-22T02:59:29.000Z",
              "updated": "2019-02-22T06:00:30.000Z"
            },
            "relationships": {
              "author": {
                "data": {
                  "id": "13",
                  "type": "people"
                }
              }
            }
          }
        ],
        "included": [
          {
            "type": "people",
            "id": "8",
            "attributes": {
              "first_name": "Seiji",
              "last_name": "Reyes",
              "age": 10,
              "gender": "male"
            }
          },
          {
            "type": "people",
            "id": "9",
            "attributes": {
              "first_name": "Summer",
              "last_name": "Reyes",
              "age": 13,
              "gender": "female"
            }
          }
        ]
      }
      """
    And the http response status code should be 200


  Scenario: Generating a JSON API collection with pagination.
    Given there is the following articles:
      | id | title                       | body                                     | author_id | created                      | updated                  |
      | 1  | Basketball for kids.        | Learn basketball at early age.           | 8         | May 22, 2015 02:59:29 AM     | May 22, 2015 02:59:30 AM |
      | 2  | Swimming for Middle School. | Play and slay in middle school swimming. | 9         | January 22, 2019 02:59:29 AM | 2019-02-22 06:00:30 AM   |
    And there is the following authors:
      | id | first_name | last_name | age | gender |
      | 8  | Seiji      | Reyes     | 10  | male   |
      | 9  | Summer     | Reyes     | 13  | female |
    And there are 13 total pages in the collection
    And the current page number is 3
    And the maximum records per page is 2
    And the base url is "http://example.com/"
    And the http response status code is 200
    When the response is asked to be generated
    Then the library will return:
      """
      {
        {
          "jsonapi": {
            "version": "1.1"
          }
        },
        {
          "links": {
            "self": "http://example.com/articles"
          }
        },
        "meta": {
          "totalPages": 13
        },
        "data": [
          {
            "type": "articles",
            "id": "1",
            "attributes": {
              "title": "Basketball for kids.",
              "body": "Learn basketball at early age.",
              "created": "2015-05-22T14:56:29.000Z",
              "updated": "2015-05-22T14:56:30.000Z"
            },
            "relationships": {
              "author": {
                "data": {
                  "id": "8",
                  "type": "people"
                }
              }
            }
          },
          {
            "type": "articles",
            "id": "2",
            "attributes": {
              "title": "Swimming for Middle School.",
              "body": "Play and slay in middle school swimming.",
              "created": "2019-01-22T02:59:29.000Z",
              "updated": "2019-02-22T06:00:30.000Z"
            },
            "relationships": {
              "author": {
                "data": {
                  "id": "13",
                  "type": "people"
                }
              }
            }
          }
        ],
        "included": [
          {
            "type": "people",
            "id": "8",
            "attributes": {
              "first_name": "Seiji",
              "last_name": "Reyes",
              "age": 10,
              "gender": "male"
            }
          },
          {
            "type": "people",
            "id": "9",
            "attributes": {
              "first_name": "Summer",
              "last_name": "Reyes",
              "age": 13,
              "gender": "female"
            }
          }
        ],
        "links": {
          "self": "http://example.com/articles?page[number]=3&page[size]=1",
          "first": "http://example.com/articles?page[number]=1&page[size]=1",
          "prev": "http://example.com/articles?page[number]=2&page[size]=1",
          "next": "http://example.com/articles?page[number]=4&page[size]=1",
          "last": "http://example.com/articles?page[number]=13&page[size]=1"
        }
      }
      """
    And the http response status code should be 200


  Scenario: Generating a JSON API error response.
    Given there is an exception raised with the following information:
      | http_status_code | source             | title                        | detail                    |
      | 422              | File.php, Line 100 | MissingCustomerNameException | Customer name is missing. |
    And the http response status code is 422
    When the response is asked to be generated
    Then the library will return:
      """
      {
        {
          "jsonapi": {
            "version": "1.1"
          }
        },
        "errors": [
          {
            "status": "422",
            "source": {
              "pointer": "File.php, Line 100"
            },
            "title":  "MissingCustomerNameException",
            "detail": "Customer name is missing."
          }
        ]
      }
      """
    And the http response status code should be 422


  Scenario: Generating a JSON API multiple error response.
    Given there is an exception raised with the following information:
      | http_status_code | source                        | title                               | detail                                                  |
      | 403              | /data/attributes/secretPowers |                                     | Editing secret powers is not authorized on Sundays.     |
      | 422              | /data/attributes/volume       |                                     | Volume does not, in fact, go to 11.                     |
      | 500              | /data/attributes/reputation   | The backend responded with an error | Reputation service not responding after three requests. |
    And the http response status code is 400
    When the response is asked to be generated
    Then the library will return:
      """
        {
          "jsonapi": {
            "version": "1.1"
          }
        },
        {
          "errors": [
            {
              "status": "403",
              "source": { "pointer": "/data/attributes/secretPowers" },
              "detail": "Editing secret powers is not authorized on Sundays."
            },
            {
              "status": "422",
              "source": { "pointer": "/data/attributes/volume" },
              "detail": "Volume does not, in fact, go to 11."
            },
            {
              "status": "500",
              "source": { "pointer": "/data/attributes/reputation" },
              "title": "The backend responded with an error",
              "detail": "Reputation service not responding after three requests."
            }
          ]
        }
      """
    And the http response status code should be 400


  Scenario: Generating a JSON API multiple error response with error codes.
    Given there is an exception raised with the following information:
      | http_status_code | error_code | source                     | title                                                               | detail                                                    |
      | 422              | 123        | /data/attributes/firstName | Value is too short                                                  | First name must contain at least two characters.          |
      | 422              | 225        | /data/attributes/password  | Passwords must contain a letter, number, and punctuation character. | The password provided is missing a punctuation character. |
      | 422              | 226        | /data/attributes/password  | Password and password confirmation do not match.                    |                                                           |
    And the http response status code is 422
    When the response is asked to be generated
    Then the library will return:
      """
        {
          "jsonapi": {
            "version": "1.1"
          }
        },
        "errors": [
          {
            "code":   "123",
            "source": { "pointer": "/data/attributes/firstName" },
            "title":  "Value is too short",
            "detail": "First name must contain at least two characters."
          },
          {
            "code":   "225",
            "source": { "pointer": "/data/attributes/password" },
            "title": "Passwords must contain a letter, number, and punctuation character.",
            "detail": "The password provided is missing a punctuation character."
          },
          {
            "code":   "226",
            "source": { "pointer": "/data/attributes/password" },
            "title": "Password and password confirmation do not match."
          }
        ]
      """
    And the http response status code should be 422


  Scenario: Generating a JSON API collection with meta information.
    Given there is the following articles:
      | id | title                       | body                                     | author_id | created                      | updated                  |
      | 1  | Basketball for kids.        | Learn basketball at early age.           | 8         | May 22, 2015 02:59:29 AM     | May 22, 2015 02:59:30 AM |
      | 2  | Swimming for Middle School. | Play and slay in middle school swimming. | 9         | January 22, 2019 02:59:29 AM | 2019-02-22 06:00:30 AM   |
    And there is the following authors:
      | id | first_name | last_name | age | gender |
      | 8  | Seiji      | Reyes     | 10  | male   |
      | 9  | Summer     | Reyes     | 13  | female |
    And there is the following meta information:
      | title     | description                  |
      | copyright | Copyright 2015 Example Corp. |
    And there is the following "authors" meta collection:
      | name          |
      | Yehuda Katz   |
      | Steve Klabnik |
      | Dan Gebhardt  |
      | Tyler Kellen  |
    When the response is asked to be generated
    Then the library will return:
      """
      {
        {
          "jsonapi": {
            "version": "1.1"
          }
        },
        "meta": {
          "copyright": "Copyright 2015 Example Corp.",
          "authors": [
            "Yehuda Katz",
            "Steve Klabnik",
            "Dan Gebhardt",
            "Tyler Kellen"
          ]
        },
        "data": [
          {
            "type": "articles",
            "id": "1",
            "attributes": {
              "title": "Basketball for kids.",
              "body": "Learn basketball at early age.",
              "created": "2015-05-22T14:56:29.000Z",
              "updated": "2015-05-22T14:56:30.000Z"
            },
            "relationships": {
              "author": {
                "data": {
                  "id": "8",
                  "type": "people"
                }
              }
            }
          },
          {
            "type": "articles",
            "id": "2",
            "attributes": {
              "title": "Swimming for Middle School.",
              "body": "Play and slay in middle school swimming.",
              "created": "2019-01-22T02:59:29.000Z",
              "updated": "2019-02-22T06:00:30.000Z"
            },
            "relationships": {
              "author": {
                "data": {
                  "id": "13",
                  "type": "people"
                }
              }
            }
          }
        ],
        "included": [
          {
            "type": "people",
            "id": "8",
            "attributes": {
              "first_name": "Seiji",
              "last_name": "Reyes",
              "age": 10,
              "gender": "male"
            }
          },
          {
            "type": "people",
            "id": "9",
            "attributes": {
              "first_name": "Summer",
              "last_name": "Reyes",
              "age": 13,
              "gender": "female"
            }
          }
        ]
      }
      """
    And the http response status code should be 200


  Scenario: Generating a JSON API collection with link objects.
    Given there is the following articles:
      | id | title                       | body                                     | author_id | created                      | updated                  |
      | 1  | Basketball for kids.        | Learn basketball at early age.           | 8         | May 22, 2015 02:59:29 AM     | May 22, 2015 02:59:30 AM |
      | 2  | Swimming for Middle School. | Play and slay in middle school swimming. | 9         | January 22, 2019 02:59:29 AM | 2019-02-22 06:00:30 AM   |
    And there is the following authors:
      | id | first_name | last_name | age | gender |
      | 8  | Seiji      | Reyes     | 10  | male   |
      | 9  | Summer     | Reyes     | 13  | female |
    And there is the following links:
      | title   | description    |
      | self    | /articles      |
      | related | /articles/tags |
    And the base url is "http://example.com/"
    When the response is asked to be generated
    Then the library will return:
      """
      {
        {
          "jsonapi": {
            "version": "1.1"
          }
        },
        {
          "links": {
            "self": "http://example.com/articles"
            "related": "http://example.com/tags"
          }
        },
        "data": [
          {
            "type": "articles",
            "id": "1",
            "attributes": {
              "title": "Basketball for kids.",
              "body": "Learn basketball at early age.",
              "created": "2015-05-22T14:56:29.000Z",
              "updated": "2015-05-22T14:56:30.000Z"
            },
            "relationships": {
              "author": {
                "data": {
                  "id": "8",
                  "type": "people"
                }
              }
            }
          },
          {
            "type": "articles",
            "id": "2",
            "attributes": {
              "title": "Swimming for Middle School.",
              "body": "Play and slay in middle school swimming.",
              "created": "2019-01-22T02:59:29.000Z",
              "updated": "2019-02-22T06:00:30.000Z"
            },
            "relationships": {
              "author": {
                "data": {
                  "id": "13",
                  "type": "people"
                }
              }
            }
          }
        ],
        "included": [
          {
            "type": "people",
            "id": "8",
            "attributes": {
              "first_name": "Seiji",
              "last_name": "Reyes",
              "age": 10,
              "gender": "male"
            }
          },
          {
            "type": "people",
            "id": "9",
            "attributes": {
              "first_name": "Summer",
              "last_name": "Reyes",
              "age": 13,
              "gender": "female"
            }
          }
        ]
      }
      """
    And the http response status code should be 200


  Scenario: Generating a JSON API empty collection.
    Given there is the following articles:
    And the base url is "http://example.com/"
    When the response is asked to be generated
    Then the library will return:
      """
      {
        {
          "jsonapi": {
            "version": "1.1"
          }
        },
        "links": {
          "self": "http://example.com/articles"
        },
        "data": []
      }
      """
    And the http response status code should be 200