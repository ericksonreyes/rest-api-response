# An example of a collections with links in JSON API format

```php
namespace App\Http\Controllers;

use EricksonReyes\RestApiResponse\JsonApi\JsonApiRelationship;use EricksonReyes\RestApiResponse\JsonApi\JsonApiResource;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResources;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResponse;
use EricksonReyes\RestApiResponse\Meta;use EricksonReyes\RestApiResponse\Resource;use Illuminate\Http\Response;
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
        
        // Add the article resources to the resources collection.
        $resources->addResource($resource);
    }
    
    // New JSON API metadata
    $meta = new Meta();
    $meta->addMetaData(key: 'title', value: 'copyright');
    $meta->addMetaData(key: 'description', value: 'Copyright 2015 Example Corp.');
    $meta->addMetaData(key: 'author', value: [
        'name' => [
            'Yehuda Katz',
            'Steve Klabnik',
            'Dan Gebhardt',
            'Tyler Kellen'
        ]
    ]);
    
    // Add the metadata to the JSON API response object
    $response->withMeta($meta);
    
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
```

[README home](../../../README.md)