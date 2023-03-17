<?php

use src\View\View;
use src\config\config;


function require_with($pg, $vars = [])
{
	extract($vars);
	require $pg;
}


if(!function_exists('env')){


    function env($key , $default = null){
        return $_ENV[$key] ?? value($default) ;
    }


}


// function config($path , $key ){
// 	 return config::get($path , $key);
// }

if(!function_exists('value')){


    function value($value){
        return ($value instanceof Closure) ? $value() : $value ;
    }


}



function old($key){
	return $_SESSION['Flash']['old'][$key] ?? false;
}


function asset($filePath){
	return 'http://' .$_SERVER['HTTP_HOST'] . $filePath;
}


if(!function_exists('view')){


    function view($value,$data = []){
        return View::make($value , $data);
    }


}








function auth()
{
	if (isset($_SESSION['client'])) {
		return true;
	}
}


function getUser()
{
	if (isset($_SESSION['client'])) {
		return $_SESSION['client'];
	}
	return false;
}


function not_auth_redirect()
{
	if (!auth()) {
		header("location:login.php");
	}
}

function auth_redirect()
{
	if (auth()) {
		header("location:profile.php");
	}
}

// function dd($var = null)
// {
// 	if (is_null($var)) {
// 		die();
// 	}
// 	echo "dd =>";
// 	echo '<pre>';
// 	print_r($var);
// 	echo '</pre>';
// 	die();
// }

// function dump($var)
// {
// 	echo "dump =>";
// 	echo '<pre>';
// 	print_r($var);
// 	echo '</pre>';
// }



