# An example of a collection of resources in JSON API format

```php
namespace App\Http\Controllers;

use EricksonReyes\RestApiResponse\JsonApi\JsonApiResource;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResources;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResponse;
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
    
    $response = new JsonApiResponse();
    $articles = Article::all();
    
    $resources = new JsonApiResources();
    foreach ($articles as $article) {
      $resource = new JsonApiResource(
        id: $article->id,
        type: 'article',
        attributes: [
          'title' => $article->title,
          'body' => $article->body,
          'created' => $article->created->getTimestamp()
          'updated' => $article->birthday->getTimestamp()
        ]
      ); 
      $resources->addResource($resource);
    }
    $response->withResources($resources);
    
    return response()->json(
        data: $response->array()
    );
  }
}
```

Empty collection output.

```json
{
  "jsonapi": {
    "version": "1.1"
  },
  "data": []
}
```

Collection output

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