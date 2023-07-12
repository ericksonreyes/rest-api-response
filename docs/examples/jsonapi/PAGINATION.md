# An example of a collections with pagination in JSON API format


```php
namespace App\Http\Controllers;

use EricksonReyes\RestApiResponse\JsonApi\JsonApiResource;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResources;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResponse;
use EricksonReyes\RestApiResponse\Resource;
use Illuminate\Http\Response;
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
    
    // Set base URL
    $resources->setBaseUrl(baseUrl: 'http://example.com\/articles');
    
    // Add pagination information
    $resources->withPagination(
        numberOfRecords: Article::count(),
        recordsPerPage: 10,
        currentPageNumber: 2
    );
    
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