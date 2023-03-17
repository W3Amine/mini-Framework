<?php


namespace src;

use src\Http\Route;
use src\DataBase\DB;
use src\Http\Request;
use src\Http\Response;
use src\Support\Session;



class Application {

   protected Route $route;
   protected Request $request;
   protected Response $response;
   protected Session $session;
   


   public function __construct(){

       $this->request = new Request() ;
       $this->response = new Response() ;
       $this->session = new Session();
       $this->route = new Route($this->request , $this->response) ;
       
       DB::connect();

   }


   public function run(){

    // this->db->conect();
    $this->route->resolve();

   }


   public function __get($name){
    if(property_exists($this , $name)){
        return $this->$name;
    }

   }

}