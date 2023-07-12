# An example of a collections with relationships in JSON API format

```php
namespace App\Http\Controllers;

use EricksonReyes\RestApiResponse\JsonApi\JsonApiRelationship;use EricksonReyes\RestApiResponse\JsonApi\JsonApiResource;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResources;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResponse;
use EricksonReyes\RestApiResponse\Resource;use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Article;

/**
* Class Articles
 * @package App\Http\Controllers
 */
class Articles extends BaseController {

  /**
  * @return \Illuminate\Http\Response
  */
  public function index(): Response {
    
    // New JSON API response
    $response = new JsonApiResponse();
    
    // New JSON API resources collection
    $resources = new JsonApiResources();

    $articles = Article::all();
    foreach ($articles as $article) {
    
        // JSON API article resource 
        $resource = new JsonApiResource(
            id: $article->id,
            type: 'article',
            attributes: [
              'title' => $article->title,
              'body' => $article->body,
              'author_id' => $article->author_id,
              'created' => $article->created->getTimestamp()
              'updated' => $article->birthday->getTimestamp()
            ]
        ); 
        
        // Loop through the authors
        foreach ($article->authors as $author) {
        
            // JSON API author resource 
            $relatedResource = new JsonApiResource(
                id: $author->id,
                type: 'people',
                attributes:    [
                    'first_name' => $author->first_name,
                    'last_name' => $author->last_name,
                    'age' => $author->age,
                    'gender' => $author->gender,
                ]
            );
            
            // Relate the author to the article
            $resource->addRelationship(
                relation: 'author',
                resource: $relatedResource
            );
        }
        
        // Add the article resources to the resources collection.
        $resources->addResource($resource);
    }
    
    // Add the article resources to the JSON API response object
    $response->withResources($resources);
    
    return response()->json(
        data: $response->array()
    );
  }
}
```

Output

```json
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
```

[README home](../../../README.md)