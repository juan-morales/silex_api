<?php

namespace App;

use Silex\Application;


class RoutesLoader {

    private $app;

    public function __construct(Application $app) {

        $this->app = $app;
        $this->instantiateControllers();
    }

    private function instantiateControllers() {

        $this->app['product.controller'] = $this->app->share(function () {
        	/* 
        		Add the logic to handle Product´s under $app['product.controller'] 
        		The actual code is stored in the ProductController file under the Controllers directory

        		The controller will make use of the services passed by 2nd parameter, in this case you can see:
        		1 st parameter: instance of the app
        		2 nd parameter: instance of the services that the controller needs to do its logic.

        		(services are loaded in the ServiceLoader.php file.)
        	*/
            return new Controllers\ProductController($this->app, $this->app['product.service']);
        }); 
		

        $this->app['extra.controller'] = $this->app->share(function () {
            return new Controllers\ExtraController($this->app, $this->app['extra.service']);
        }); 
    }


    /*
    	Define the Routes.

    	Here are defined all POST routes, but you can add whatever you need.
    */
    public function bindRoutesToControllers() {
        $api = $this->app["controllers_factory"];
        
        /*We define the Routes */

		//Extra
        $api->post('/helloworld', "extra.controller:index");   
		
		//PRODUCT
        $api->post('/product/create', "product.controller:create");
        $api->post('/product/update', "product.controller:update");
        $api->post('/product/delete', "product.controller:delete");
        $api->post('/product', "product.controller:index");

		/* We attach the routes defined to the $app instance of the webapplication*/
        $this->app->mount($this->app["api.endpoint"].'/'.$this->app["api.version"], $api);
    }
}

