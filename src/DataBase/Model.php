<?php

namespace src\DataBase;

use PDO;
use PDOException;
use src\config\config;

//use src\DataBase\DataBaseManager;

// MySql Manager / querybuilder
abstract class Model implements  DataBaseManager {

    public static $conn;
    
    public static $query;
    public static $dataToBind = [];



static public function get_child_class(){
    return get_called_class()::$ModelName;
}

    // public static $ClassIs = get_called_class();

//     public static function get_child_class(){
// $class = get_called_class();
//       return  substr( $class , strrpos($class , '\\') + 1);
//     }


//protected
public static function connect(){
        $DB_DATA = config::get('database');

        try {
            $pdo = new PDO('mysql:host=' . $DB_DATA['DB_HOST'] . ';dbname=' . $DB_DATA['DB_DATABASE'], $DB_DATA['DB_USERNAME'], $DB_DATA['DB_PASSWORD']);
            // set the PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // $pdo->setFetchMode(PDO::FETCH_ASSOC);

            // echo "Connected successfully";
            self::$conn = $pdo;
            // return $pdo;

          } catch (PDOException $e) {
           // echo "Connection failed: " . $e->getMessage();
          }

          
// echo self::get_child_class();
    }



    //read 
    public static function select($columns = ['*']){
        self::$query="";
        self::$dataToBind = [];


        $cols = (count($columns) != 1) ? implode(' , '  , $columns) : $columns[0];
// if(count($columns) == 1){

// $cols = implode(' , '  , $columns);

// } else {
//     $cols = $columns[0];
// }
        self::$query = "SELECT  ". $cols ." FROM ".self::get_child_class()." WHERE 1 = 1 ";
      
        //    array_push(self::$dataToBind , self::get_child_class() );
            return new static();



    }


    public static function get(){
        // self::connect()->exec(self::$query);
       
        echo self::$query;
        // return (self::$conn->exec(self::$query)) ? true : false ;
        $stm = self::$conn->prepare(self::$query);
        $stm->execute(self::$dataToBind);
       $data =  $stm->fetchAll(PDO::FETCH_ASSOC);
       
$data = (count($data) == 1) ? $data[0] : $data ;

        return $data ;

        



   
    }




    
    //create 
    public static function insert($data){

        // use cases
        // User::insert([
        //     'name' => 'London to Paris',
        // ]);



        self::$query="";
        self::$dataToBind = [];

$cols = [];
$val = [];
        foreach ($data as $key => $value) {
            array_push($cols,$key);
            array_push($val,$value);
        }

        $cols = (count($cols) != 1) ? implode(' , '  , $cols) : $cols[0];
        
$valueAsString = '' ;
$valLength = count($val);
        foreach ($val as $key => $value) {
            if($key == $valLength - 1){
                $valueAsString .= " ?  ";
            } else {
                $valueAsString .= " ? , ";
            }
        }




        self::$query = "INSERT INTO  ". self::get_child_class() . " ( " . $cols ." ) VALUES ( " . $valueAsString . " ) ";

        foreach ($val as $key => $value) {
            array_push(self::$dataToBind , $value );

        }

        return new static();


    }


    
    
    //update 
    public static function update($data){
      
       // use cases
        // User::update([
        //     'name' => 'London to Paris',
        // ]);

      
        self::$query="";
        self::$dataToBind = [];




        $cols = [];
        $val = [];
                foreach ($data as $key => $value) {
                    array_push($cols,$key);
                    array_push($val,$value);
                }
        
                // $colsString = '';
                foreach ($cols as $key => $value) {
                    $cols[$key] = $value . " =  ? " ;
                }

                $cols = (count($cols) != 1) ? implode(' , '  , $cols) : $cols[0];
                

                self::$query = "  UPDATE  " . self::get_child_class() . " SET  " . $cols . " WHERE 1 = 1 " ;


                foreach ($val as $key => $value) {
                    array_push(self::$dataToBind , $value );
        
                }


        return new static();


    }
    
    //delete 
    public static function delete(){
        self::$query="";
        self::$dataToBind = [];

        self::$query = "DELETE  FROM ".self::get_child_class()." WHERE 1 = 1 ";
    //    array_push(self::$dataToBind , self::get_child_class() );
        return new static();
        }
    
    public static function where($col , $val , $operator = "="){

        if(str_contains($val, '.')){

            self::$query .= ' AND  `' . $col . '`  '  . $operator  . '  ' . $val   ;

        }else {

            self::$query .= ' AND  `' . $col . '`  '  . $operator  . '  ? ' ;
            // array_push(self::$dataToBind , $col );
            // array_push(self::$dataToBind , $operator );
            array_push(self::$dataToBind , $val );
        }

        return new static();
    }

    public static function join($table){
        // self::$query .= ' JOIN  ' . $table ;
        self::$query =  str_replace("WHERE 1 = 1", ' JOIN  ' . $table ." WHERE 1 = 1 ",self::$query);
        // array_push(self::$dataToBind , $col );
        // array_push(self::$dataToBind , $operator );
        // array_push(self::$dataToBind , $val );

        return new static();
    }



    public static function run(){
        // self::connect()->exec(self::$query);
       
        echo self::$query;
        // return (self::$conn->exec(self::$query)) ? true : false ;
        return self::$conn->prepare(self::$query)->execute(self::$dataToBind);
        // self::$query= "";
        // self::$dataToBind = [];

        
    }


    
    // //Join select 
    // public static function JoinSelect($columns = '*' , $table ,  $filters){
    //     self::$query="";
    //     self::$dataToBind = [];
  
        


    // }




    public static function All(){
        return self::select()->get();
    }




    
}