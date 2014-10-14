# AdrotecWebApiBundle

This is a `Symfony 2`bundle to create Web APIs with [breeze.server.php](http://github.com/adrotec/breeze.server.php)

## Usage

#### Install with composer

```json
    "require": {
      "adrotec/webapi-bundle": "dev-master",
      "symfony/validator": "dev-master"
    }
```

`"symfony/validator": "dev-master"` is required for validations with `breeze.server.php` to work properly

#### Enable the bundle  in `AppKernel.php`

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new JMS\SerializerBundle\JMSSerializerBundle(),
        new Adrotec\WebApiBundle\AdrotecWebApiBundle(),
        // ...
    );
}
```

The order is important here because `AdrotecWebApiBundle` [overrides](https://github.com/adrotec/AdrotecWebApiBundle/blob/master/Resources/config/services.xml) some of the `JMSSerializerBundle` behaviours. E.g: Naming strategy, Lazy loading, etc.


#### Create an API controller

Add routing configuration

```yaml
# src/EmpDirectory/Bundle/Resources/config/routing.yml
emp_directory_api:
    path:       /api/{resource}
    defaults:   { _controller: EmpDirectoryBundle:Api:api }
```

the request parameter `{resource}` is important here, since it is used by the library to identify the current request resource.

The bundle exposes a service named `adrotec_webapi` which you can use in your controller.

```php

// src/EmpDirectory/Bundle/Controller/ApiController.php

namespace EmpDirectory\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{

    public function apiAction(Request $request)
    {
        $api = $this->container->get('adrotec_webapi');

        $api->addResources(array(
            'Employees' => 'EmpDirectory\Bundle\Entity\Employee',
            'Departments' => 'EmpDirectory\Bundle\Entity\Department',
            'Jobs' => 'EmpDirectory\Bundle\Entity\Job',
        ));
        
        // $request->attributes->set($request->attributes->get('resource'));

        $response = $api->handle($request);
        
        return $response;
    }

}

```
