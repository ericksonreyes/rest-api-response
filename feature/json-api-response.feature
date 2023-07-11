Feature: Generating a JSON API collection
  As a REST API Developer
  I want a REST API response generator library

  Scenario: Generating a JSON API collection.
    Given there is the following articles:
      | id | title                       | body                                     | created                      | updated                  |
      | 1  | Basketball for kids.        | Learn basketball at early age.           | May 22, 2015 02:59:29 AM     | May 22, 2015 02:59:30 AM |
      | 2  | Swimming for Middle School. | Play and slay in middle school swimming. | January 22, 2019 02:59:29 AM | 2019-02-22 06:00:30 AM   |
    When a JSON API response is asked to be generated
    Then the library will return:
      """
      {
        "jsonapi": {
          "version": "1.1"
        },
        "data": [
          {
            "type": "article",
            "id": "1",
            "attributes": {
              "title": "Basketball for kids.",
              "body": "Learn basketball at early age.",
              "created": 1432263569,
              "updated": 1432263570
            }
          },
          {
            "type": "article",
            "id": "2",
            "attributes": {
              "title": "Swimming for Middle School.",
              "body": "Play and slay in middle school swimming.",
              "created": 1548125969,
              "updated": 1550815230
            }
          }
        ]
      }
      """
    And the http response status code should be 200
    And the media type should be "application/vnd.api+json"


  Scenario: Generating a JSON API collection with relationships.
    Given there is the following articles:
      | id | title                       | body                                     | author_id | created                      | updated                  |
      | 1  | Basketball for kids.        | Learn basketball at early age.           | 8         | May 22, 2015 02:59:29 AM     | May 22, 2015 02:59:30 AM |
      | 2  | Swimming for Middle School. | Play and slay in middle school swimming. | 9         | January 22, 2019 02:59:29 AM | 2019-02-22 06:00:30 AM   |
    And there is the following authors:
      | id | first_name | last_name | age | gender |
      | 8  | Seiji      | Reyes     | 10  | male   |
      | 9  | Summer     | Reyes     | 13  | female |
    When a JSON API response is asked to be generated
    Then the library will return:
      """
      {
        "jsonapi": {
          "version": "1.1"
        },
        "data": [
          {
            "type": "article",
            "id": "1",
            "attributes": {
              "title": "Basketball for kids.",
              "body": "Learn basketball at early age.",
              "created": 1432263569,
              "updated": 1432263570
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
            "type": "article",
            "id": "2",
            "attributes": {
              "title": "Swimming for Middle School.",
              "body": "Play and slay in middle school swimming.",
              "created": 1548125969,
              "updated": 1550815230
            },
            "relationships": {
              "author": {
                "data": {
                  "id": "9",
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
              "age": "10",
              "gender": "male"
            }
          },
          {
            "type": "people",
            "id": "9",
            "attributes": {
              "first_name": "Summer",
              "last_name": "Reyes",
              "age": "13",
              "gender": "female"
            }
          }
        ]
      }
      """
    And the http response status code should be 200
    And the media type should be "application/vnd.api+json"


  Scenario: Generating a JSON API collection with pagination.
    Given there is the following articles:
      | id | title                       | body                                     | author_id | created                      | updated                  |
      | 1  | Basketball for kids.        | Learn basketball at early age.           | 8         | May 22, 2015 02:59:29 AM     | May 22, 2015 02:59:30 AM |
      | 2  | Swimming for Middle School. | Play and slay in middle school swimming. | 9         | January 22, 2019 02:59:29 AM | 2019-02-22 06:00:30 AM   |
    And there is the following authors:
      | id | first_name | last_name | age | gender |
      | 8  | Seiji      | Reyes     | 10  | male   |
      | 9  | Summer     | Reyes     | 13  | female |
    And there are 118 total articles
    And the current page number is 2
    And the maximum records per page is 10
    And the http response status code is 200
    And the base url is "http://example.com/articles?page[number]=2&page[size]=10"
    When a JSON API response is asked to be generated
    Then the library will return:
      """
      {
        "jsonapi": {
          "version": "1.1"
        },
        "links": {
          "self": "http:\/\/example.com\/articles?page[number]=2&page[size]=10",
          "first": "http:\/\/example.com\/articles?page[number]=1&page[size]=10",
          "previous": "http:\/\/example.com\/articles?page[number]=1&page[size]=10",
          "next": "http:\/\/example.com\/articles?page[number]=3&page[size]=10",
          "last": "http:\/\/example.com\/articles?page[number]=11&page[size]=10"
        },
        "meta": {
          "total": "118",
          "page": {
            "size": "10",
            "total": "11",
            "first": "1",
            "previous": "1",
            "current": "2",
            "next": "3",
            "last": "11"
          }
        },
        "data": [
          {
            "type": "article",
            "id": "1",
            "attributes": {
              "title": "Basketball for kids.",
              "body": "Learn basketball at early age.",
              "created": 1432263569,
              "updated": 1432263570
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
            "type": "article",
            "id": "2",
            "attributes": {
              "title": "Swimming for Middle School.",
              "body": "Play and slay in middle school swimming.",
              "created": 1548125969,
              "updated": 1550815230
            },
            "relationships": {
              "author": {
                "data": {
                  "id": "9",
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
              "age": "10",
              "gender": "male"
            }
          },
          {
            "type": "people",
            "id": "9",
            "attributes": {
              "first_name": "Summer",
              "last_name": "Reyes",
              "age": "13",
              "gender": "female"
            }
          }
        ]
      }
      """
    And the http response status code should be 200
    And the media type should be "application/vnd.api+json"


  Scenario: Generating a JSON API error response.
    Given there is an exception raised with the following information:
      | status | source                         | code                         | title                     |
      | 422    | /data/attributes/customer_name | MissingCustomerNameException | Customer name is missing. |
    And the http response status code is 422
    When a JSON API response is asked to be generated
    Then the library will return:
      """
      {
        "jsonapi": {
          "version": "1.1"
        },
        "data": [],
        "errors": [
          {
            "status": "422",
            "source": {
              "pointer": "\/data\/attributes\/customer_name"
            },
            "code":  "MissingCustomerNameException",
            "title": "Customer name is missing."
          }
        ]
      }
      """
    And the http response status code should be 422
    And the media type should be "application/vnd.api+json"


  Scenario: Generating a JSON API multiple error response.
    Given there is an exception raised with the following information:
      | status | source                        | code                                | title                                                   |
      | 403    | /data/attributes/secretPowers |                                     | Editing secret powers is not authorized on Sundays.     |
      | 422    | /data/attributes/volume       |                                     | Volume does not, in fact, go to 11.                     |
      | 500    | /data/attributes/reputation   | The backend responded with an error | Reputation service not responding after three requests. |
    And the http response status code is 400
    When a JSON API response is asked to be generated
    Then the library will return:
      """
      {
        "jsonapi": {
          "version": "1.1"
        },
        "data": [],
        "errors": [
          {
            "status": "403",
            "source": {
              "pointer": "\/data\/attributes\/secretPowers"
            },
            "title": "Editing secret powers is not authorized on Sundays."
          },
          {
            "status": "422",
            "source": {
              "pointer": "\/data\/attributes\/volume"
            },
            "title": "Volume does not, in fact, go to 11."
          },
          {
            "status": "500",
            "source": {
              "pointer": "\/data\/attributes\/reputation"
            },
            "code": "The backend responded with an error",
            "title": "Reputation service not responding after three requests."
          }
        ]
      }
      """
    And the http response status code should be 400
    And the media type should be "application/vnd.api+json"


  Scenario: Generating a JSON API multiple error response with error codes.
    Given there is an exception raised with the following information:
      | status | code | source                     | title                                                               | detail                                                    |
      | 422    | 123  | /data/attributes/firstName | Value is too short                                                  | First name must contain at least two characters.          |
      | 422    | 225  | /data/attributes/password  | Passwords must contain a letter, number, and punctuation character. | The password provided is missing a punctuation character. |
      | 422    | 226  | /data/attributes/password  | Password and password confirmation do not match.                    |                                                           |
    And the http response status code is 422
    When a JSON API response is asked to be generated
    Then the library will return:
      """
      {
        "jsonapi": {
          "version": "1.1"
        },
        "data": [],
        "errors": [
          {
            "status": "422",
            "source": {
              "pointer": "\/data\/attributes\/firstName"
            },
            "code":   "123",
            "title":  "Value is too short",
            "detail": "First name must contain at least two characters."
          },
          {
            "status": "422",
            "source": {
              "pointer": "\/data\/attributes\/password"
            },
            "code":   "225",
            "title": "Passwords must contain a letter, number, and punctuation character.",
            "detail": "The password provided is missing a punctuation character."
          },
          {
            "status": "422",
            "source": {
              "pointer": "\/data\/attributes\/password"
            },
            "code":   "226",
            "title": "Password and password confirmation do not match."
          }
        ]
      }
      """
    And the http response status code should be 422
    And the media type should be "application/vnd.api+json"


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
    And there is the following "author" meta collection:
      | name          |
      | Yehuda Katz   |
      | Steve Klabnik |
      | Dan Gebhardt  |
      | Tyler Kellen  |
    When a JSON API response is asked to be generated
    Then the library will return:
      """
      {
        "jsonapi": {
          "version": "1.1"
        },
        "meta": {
          "copyright": "Copyright 2015 Example Corp.",
          "author": [
            "Yehuda Katz",
            "Steve Klabnik",
            "Dan Gebhardt",
            "Tyler Kellen"
          ]
        },
        "data": [
          {
            "type": "article",
            "id": "1",
            "attributes": {
              "title": "Basketball for kids.",
              "body": "Learn basketball at early age.",
              "created": 1432263569,
              "updated": 1432263570
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
            "type": "article",
            "id": "2",
            "attributes": {
              "title": "Swimming for Middle School.",
              "body": "Play and slay in middle school swimming.",
              "created": 1548125969,
              "updated": 1550815230
            },
            "relationships": {
              "author": {
                "data": {
                  "id": "9",
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
              "age": "10",
              "gender": "male"
            }
          },
          {
            "type": "people",
            "id": "9",
            "attributes": {
              "first_name": "Summer",
              "last_name": "Reyes",
              "age": "13",
              "gender": "female"
            }
          }
        ]
      }
      """
    And the http response status code should be 200
    And the media type should be "application/vnd.api+json"


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
      | name    | url            |
      | self    | /articles      |
      | related | /articles/tags |
    And the base url is "http://example.com"
    When a JSON API response is asked to be generated
    Then the library will return:
      """
      {
        "jsonapi": {
          "version": "1.1"
        },
        "links": {
          "self": "http:\/\/example.com\/articles",
          "related": "http:\/\/example.com\/articles\/tags"
        },
        "data": [
          {
            "type": "article",
            "id": "1",
            "attributes": {
              "title": "Basketball for kids.",
              "body": "Learn basketball at early age.",
              "created": 1432263569,
              "updated": 1432263570
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
            "type": "article",
            "id": "2",
            "attributes": {
              "title": "Swimming for Middle School.",
              "body": "Play and slay in middle school swimming.",
              "created": 1548125969,
              "updated": 1550815230
            },
            "relationships": {
              "author": {
                "data": {
                  "id": "9",
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
              "age": "10",
              "gender": "male"
            }
          },
          {
            "type": "people",
            "id": "9",
            "attributes": {
              "first_name": "Summer",
              "last_name": "Reyes",
              "age": "13",
              "gender": "female"
            }
          }
        ]
      }
      """
    And the http response status code should be 200
    And the media type should be "application/vnd.api+json"


  Scenario: Generating a JSON API empty collection.
    Given there is the following articles:
      | id | title | body | author_id | created | updated |
    When a JSON API response is asked to be generated
    Then the library will return:
      """
      {
        "jsonapi": {
          "version": "1.1"
        },
        "data": []
      }
      """
    And the http response status code should be 200
    And the media type should be "application/vnd.api+json"