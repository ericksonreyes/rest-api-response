### An example of a collection of resources in JSON API format


```php
namespace App\Http\Controllers;

use EricksonReyes\RestApiResponse\JsonApi\JsonApiResource;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResources;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Article;

class Articles extends BaseController {

  /**
  * @return \Illuminate\Http\Response
  */
  public function index(): Response {
    
    $response = new JsonApiResponse();
    $resources = new JsonApiResources();
    $articles = Article::all();
    
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
    $data = $response->array();
    
    return response()->view('json', $data);
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

[Back to README home](../../README.md)