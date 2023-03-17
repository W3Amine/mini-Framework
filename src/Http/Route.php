<?php


namespace src\Http;

use src\View\View;

// use src\Http\Request;
// use src\Http\Response;




class Route
{


    public  $request;
    public  $response;

    public function __construct( $request ,  $response ){
$this->request = $request;
$this->response = $response;
    }






    protected static array $routes = [];




    public static function get($route, $action)
    {

$route = (strlen($route) > 1 && str_ends_with($route, '/')) ? rtrim($route, "/") : $route;
self::$routes['get'][$route] = $action;

    }



    public static function post($route, $action)
    {

        // $route = (str_ends_with($route, '/')) ? rtrim($route, "/") : $route;
        $route = (strlen($route) > 1 && str_ends_with($route, '/')) ? rtrim($route, "/") : $route;

self::$routes['post'][$route] = $action;

    }


public function resolve(){

    
    $path = $this->request->path();
    $path = ( strlen($path) > 1 && str_ends_with($path, '/')) ? rtrim($path, "/") : $path  ;
    $method = $this->request->method();


    $action = self::$routes[$method][$path] ?? false;

    // var_dump($action);

    if(!$action){
return  View::make('errors.404');
    }
//@TODO if $ path is not set return view of 404






// now handling the route get or post "ACTION" TWO SITUATIONS if is a callback or is  an array of a controller class 
// and it s method

// if it 's a callback function we have to run it 

if(is_callable($action)){
    call_user_func_array($action , [] );
}

// if it 's a array function we have to run it 

if(is_array($action)){



call_user_func_array([new $action[0] ,  $action[1]] , []);


};



}









}