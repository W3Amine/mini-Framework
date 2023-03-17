<?php

namespace src\View;

use src\config\config;



class View {
   public static $ViewConfigDir = __DIR__ . '/../../views/';



public static function make($view , $data = []){

   $view =  self::pathEditor($view);


   if(self::exists($view)){

    //    require_once self::$ViewConfigDir . $view;


       require_with(self::$ViewConfigDir . $view , $data );

   } else {
    
echo '<div style="color:white;background-color:#f03c2f;text-align:center;margin:0px;margin-top:20px,width:100vw,height:20vw;padding:20px">
<h1>View ['.$view.'] not found</h1>
<p>this is a framework error</p>
</div>';
   }

// ob_start();

//require_once self::$ViewConfigDir . $view;

// ob_get_clean();

}


public static function exists($view){

    return (file_exists(self::$ViewConfigDir.$view)) ? true : false;



}


private static function pathEditor($view){

return (str_contains($view , ".")) ? implode('/' , explode('.',$view) ) . '.view.php' : $view . '.view.php';



}






}




