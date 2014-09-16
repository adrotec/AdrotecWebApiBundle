<?php

namespace Adrotec\WebApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Adrotec\BreezeJs\Doctrine\ORM\Dispatcher;
use Symfony\Component\HttpFoundation\Response;
use Adrotec\BreezeJs\MetadataInterceptor;
use Adrotec\BreezeJs\Serializer\MetadataInterceptor as SerializerInterceptorBase;
use Adrotec\BreezeJs\Validator\ValidatorInterceptor;
use Symfony\Component\HttpFoundation\Request;

//use Symfony\Component\Validator\Validator;

class SerializerInterceptor extends SerializerInterceptorBase {
    public function getDefaultResourceName(\Adrotec\BreezeJs\Metadata\StructuralType $structuralType){
        return $structuralType->shortName;
    }
}

/**
 * @deprecated use the "adrotec_webapi" service instead
 */

class WebApiController extends Controller {

    public function getClientClasses() {
        //throw new \Exception('getClientClasses method should be implemented by sub classes');
        return null;
    }

    public function apiAction($route) {
        
        $app = $this->container->get('adrotec_webapi');

        $app->addResources($this->getClientClasses());

        $request = Request::createFromGlobals();
        $request->attributes->set('resource', $route);
        $response = $app->handle($request);
        
        return $response;
    }

}
