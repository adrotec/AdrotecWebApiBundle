# AdrotecWebApiBundle

This is a `Symfony 2`bundle to create Web APIs with [breeze.server.php](github.com/adrotec/breeze.server.php)

## Usage

install with composer

```json
    "require": {
      "adrotec/webapi-bundle": "dev-master",
      "symfony/validator": "dev-master"
    }
```

`"symfony/validator": "dev-master"` is required for validations with `breeze.server.php` to work properly


The bundle exposes a service named `adrotec_webapi`


Add routing configuration

```yaml
# src/EmpDirectory/Bundle/Resources/config/routing.yml
emp_directory_api:
    path:       /api/{resource}
    defaults:   { _controller: EmpDirectoryBundle:Api:api }
```

```php

// src/EmpDirectory/Bundle/Controller/ApiController.php

namespace EmpDirectory\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{

    public function apiAction(Request $request)
    {
        $app = $this->container->get('adrotec_webapi');

        $app->addResources(array(
            'Employees' => 'EmpDirectory\Bundle\Entity\Employee',
            'Departments' => 'EmpDirectory\Bundle\Entity\Department',
            'Jobs' => 'EmpDirectory\Bundle\Entity\Job',
        ));

        $response = $app->handle($request);
        
        return $response;
    }

}

```