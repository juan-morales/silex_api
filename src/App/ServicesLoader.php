<?php

namespace App;

use Silex\Application;

class ServicesLoader {

    protected $app;

    public function __construct(Application $app) {

        $this->app = $app;
    }

    public function bindServicesIntoContainer() {

		$this->app['product.service'] = $this->app->share(function () {        
			/* you can have more than 1 service under product.service */

            $return['ProductService'] = new Services\ProductService($this->app["db"]);
            //$return['OtherService'] = new Services\OtherService($this->app["db"]);
			return $return;
        });
		
		$this->app['extra.service'] = $this->app->share(function () {        
            $return['ExtraService'] = new Services\ExtraService($this->app["db"]);
			return $return;
        });
    }

}
