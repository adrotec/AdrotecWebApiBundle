<?php

namespace Adrotec\WebApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

class WebApiController extends Controller {

    public function getResources() {
        //throw new \Exception('getClientClasses method should be implemented by sub classes');
        return null;
    }

    public function apiAction(Request $request) {
        
        $app = $this->container->get('adrotec_webapi');

        $resources = $this->getResources();
        
        if($resources){
            $app->addResources($resources);
        }

        $response = $app->handle($request);
        
        return $response;
    }

}
