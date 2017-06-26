<?php

use Silex\Application;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\ServicesLoader;
use App\RoutesLoader;
use Carbon\Carbon;

//your preferrred time zone
date_default_timezone_set('America/Argentina/Buenos_Aires');

define("ROOT_PATH", __DIR__ . "/..");

//CORS SECTION BEGIN
//Set or Unset this
//handling CORS preflight request
$app->before(function (Request $request) {
   
   if ($request->getMethod() === "OPTIONS") {
	   
	   $response = new Response();
	   $response->headers->set("Access-Control-Allow-Origin","*");
	   $response->headers->set("Access-Control-Allow-Methods","GET,POST");
	   $response->headers->set("Access-Control-Allow-Headers","Content-Type");
	   $response->setStatusCode(200);
	   $response->send();
   }
}, Application::EARLY_EVENT);

//handling CORS respons with right headers
$app->after(function (Request $request, Response $response) {
   
   $response->headers->set("Access-Control-Allow-Origin","*");
   $response->headers->set("Access-Control-Allow-Methods","GET,POST");
});

//CORS END

//JSON SECTION BEGIN
//accepting JSON
$app->before(function (Request $request) {
	
	if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
		
		$data = json_decode($request->getContent(), true);
		$request->request->replace(is_array($data) ? $data : array());
	}
});
//JSON END

//APP setting preloaded values if you need, for every request
$app->before(function (Request $request) use ($app) {

	//here you can do some checks, use this section as a middleware section.
	/*
	$app['yousection'] = array(
		...
		... values
	);
	*/
	
});



$app->register(new ServiceControllerServiceProvider());


//DB SECTION BEGIN

//configured to use with MySQL, change it if you need it.
$app->register(new DoctrineServiceProvider(), array(
	"db.options" => array(
		'dbname' => 'test_db',
		'user' => 'root',
		'password' => '',
		'host' => '127.0.0.1',
		'driver' => 'pdo_mysql',
		'charset' => 'utf8',
	),
));
///DB END


//CACHE CONF
$app->register(new HttpCacheServiceProvider(), array("http_cache.cache_dir" => ROOT_PATH . "/storage/cache",));

//LOGS CONF
$app->register(new MonologServiceProvider(), array(
	"monolog.logfile" => ROOT_PATH . "/storage/logs/" . date("Y-m-d") . ".log",
	"monolog.level" => $app["log.level"],
	"monolog.name" => "application"
));

//Load your "Services", do NOT delete this.
//Respect the position also.
$servicesLoader = new App\ServicesLoader($app);
$servicesLoader->bindServicesIntoContainer();

//Load your ROUTES, do NOT delete this, and do NOT alter the order.
$routesLoader = new App\RoutesLoader($app);
$routesLoader->bindRoutesToControllers();

//Replace the Error Handler , to use your own error handler.
//This is pretty much everything you will ned.
$app->error(function (\Exception $e, $code) use ($app) {
	$app['monolog']->addError($e->getMessage());
	$app['monolog']->addError($e->getTraceAsString());
	return new JsonResponse(array("statusCode" => $code, "message" => $e->getMessage(), "stacktrace" => $e->getTraceAsString()));
});


return $app;