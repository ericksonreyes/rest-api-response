# REST API Response Generator Class for PHP 8

![Code Coverage](https://github.com/ericksonreyes/rest-api-response/raw/master/coverage_badge.svg)
[![Build](https://github.com/ericksonreyes/rest-api-response/actions/workflows/merge.yaml/badge.svg?branch=master)](https://github.com/ericksonreyes/rest-api-response/actions/workflows/merge.yaml)

Nothing fancy. I just created a REST API response generator class that I've been copy-pasting over and over again.

## Installation

```shell
composer require ericksonreyes/rest-api-response
```

### Example (Lumen)

Controller

```php
namespace App\Http\Controllers;

use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Users extends BaseController {

    private const DEFAULT_PAGE_SIZE = 35;

    public function index(Request $request, UserRepository $repository): Response {
        $page = (int) $request->get('page', 1);
        $size = (int) $request->get('size', self::DEFAULT_PAGE_SIZE);
        
        if ($page < 1) {
            $page = 1;
        }
        
        if ($size < 1) {
            $size = self::DEFAULT_PAGE_SIZE;
        }
        
        $offset = $page - 1;
        $limit = $size;
        $count = $repository->countUsers();
        $data['users'] = $repository->getUsers($offset, $limit);  
        
        $data['pagination'] = new Pagination(
            recordsFound: $count,
            recordsPerPage: 10,
            currentPage: $page
        );
        
        return response()->view('list', $data);
    }
    
}
```

### Author

* Erickson
  Reyes ([GitHub](https://github.com/ericksonreyes), [GitLab](https://gitlab.com/ericksonreyes/), [LinkedIn](https://www.linkedin.com/in/ericksonreyes/)
  and [Packagist](http://packagist.org/users/ericksonreyes/)).

### License

See [LICENSE](LICENSE)

### Gitlab

This project is also available in [GitLab](https://gitlab.com/ericksonreyes/rest-api-response) 