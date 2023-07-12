# An example of a error responses in JSON API format

### Basic error message.
```php
namespace App\Http\Controllers;

use EricksonReyes\RestApiResponse\Error;use EricksonReyes\RestApiResponse\Errors;use EricksonReyes\RestApiResponse\JsonApi\JsonApiResource;
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
    try {
        // Codes...
    }
    catch (\Exception $exception) {
        $errors = new Errors();
        
        $httpStatusCode = 400;
        $title = $exception->getMessage();
        $error = new Error(
            httpStatusCode: $httpStatusCode, 
            title: $title
        );
        
        $response->withErrors($errors);
        return response()->json(
            data: $response->array(),
            status: $httpStatusCode
        );
    }
  }
  
}
```

Output

```json
{
  "jsonapi": {
      "version": "1.1"
  },
  "data": [],
  "errors": [
    {
      "status": "400",
      "title": "Customer name is missing."
    }
  ]
}
```



### Error message with additional details

```php
namespace App\Http\Controllers;

use EricksonReyes\RestApiResponse\Error;use EricksonReyes\RestApiResponse\Errors;use EricksonReyes\RestApiResponse\ErrorSource;use EricksonReyes\RestApiResponse\ErrorSourceType;use EricksonReyes\RestApiResponse\JsonApi\JsonApiResource;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResources;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;

/**
* Class Users
 * @package App\Http\Controllers
 */
class Users extends BaseController {

  /**
  * @return \Illuminate\Http\Response
  */
  public function index(): Response {
  
    $response = new JsonApiResponse();
    try {
        // Codes...
    }
    catch (\Exception $exception) {
        $errors = new Errors();
        
        $title = $exception->getMessage();
        $error = new Error(
            httpStatusCode: $httpStatusCode, 
            title: $title
        );
        
        $details = $exception->getTraceAsString();
        $error->withDetail($details);
        
        $errorCode = $exception->getCode(); 
        $error->withCode($errorCode);
        
        $type = ErrorSourceType::Pointer;
        $source = 'data/attributes/customer_name';
        $sourceOfError = new ErrorSource(
            $type,
            $source
        );
        $error->fromSource($sourceOfError);
        
        $httpStatusCode = 422;
        $response->withErrors($errors);
        return response()->json(
            data: $response->array(),
            status: $httpStatusCode
        );
    }
  }
  
}
```

Output

```json
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
      "title": "Customer name is missing.",
      "detail": "Customer name is required when creating a new user."
    }
  ]
}
```



### Multiple errors

```php
namespace App\Http\Controllers;

use EricksonReyes\RestApiResponse\Error;use EricksonReyes\RestApiResponse\Errors;use EricksonReyes\RestApiResponse\ErrorSource;use EricksonReyes\RestApiResponse\ErrorSourceType;use EricksonReyes\RestApiResponse\JsonApi\JsonApiResource;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResources;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;

/**
* Class Users
 * @package App\Http\Controllers
 */
class Users extends BaseController {

  /**
  * @return \Illuminate\Http\Response
  */
  public function index(): Response {
  
    $response = new JsonApiResponse();
    try {
        // Codes...
    }
    catch (\Exception $exception) {
        $errors = new Errors();
        
        /**
        * First error
        */
        $error = new Error(
            httpStatusCode: 422, 
            title: 'Value is too short'
        );
        $error->withDetail('First name must contain at least two characters.');
        $error->withCode('123');
        $error->fromSource(
            new ErrorSource(
                ErrorSourceType::Pointer,
                '/data/attributes/firstName'
            )
        );
        
        /**
        * Second error
        */
        $error = new Error(
            httpStatusCode: 403, 
            title: 'Passwords must contain a letter, number, and punctuation character.'
        );
        $error->withDetail('The password provided is missing a punctuation character.');
        $error->withCode('225');
        $error->fromSource(
            new ErrorSource(
                ErrorSourceType::Pointer,
                '/data/attributes/password'
            )
        );
        
        /**
        * Third error
        */
        $error = new Error(
            httpStatusCode: 422, 
            title: 'Password and password confirmation do not match.'
        );
        $error->withCode('226');
        $error->fromSource(
            new ErrorSource(
                ErrorSourceType::Pointer,
                '/data/attributes/password'
            )
        );
        
        $response->withErrors($errors);
        $httpStatusCode = 422;
        return response()->json(
            data: $response->array(),
            status: $httpStatusCode
        );
    }
  }
  
}
```

Output

```json
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
      "status": "403",
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
```

[README home](../../../README.md)