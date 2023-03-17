<?php



namespace  src\DataBase;



interface DataBaseManager {

// connect to DB
public static function connect();

//read 
public static function select($columns = '*');

//create 
public static function insert($data);

//update 
public static function update($data);

//delete 
public static function delete();


//Join select 
// public static function JoinSelect($columns = '*' , $table ,  $filters);
    


}