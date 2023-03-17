<?php


namespace src\Support;


class Session {

public function set($key , $value){

    $_SESSION[$key] = $value ;

}

public function get($key){

    return $_SESSION[$key] ?? false ;

}

public function has($key){

    return isset($_SESSION[$key]);

}



public function remove($key){
    if($this->has($key)){
unset($_SESSION[$key]);
    }
}


public function setFlash($key , $message){
    $_SESSION['Flash'][$key] = [
        'remove' => false,
        'content' => $message,
    ];
}


public function getFlash($key){
    return $_SESSION['Flash'][$key]['content'] ?? false;
    // return $_SESSION['Flash'][$key] ?? false;
}




public function __construct(){

    $flashMessages = $_SESSION['Flash'] ?? [];
    
    
    foreach ($flashMessages as $key => $FlashMessage) {
        // $flashMessage['remove'] = 'true';
        $flashMessages[$key]['remove'] = true;
        // echo $flashMessage['remove'];
//    dump($flashMessages);

    }

   $_SESSION['Flash'] = $flashMessages;


}


public function __destruct(){
    $this->removeFlashMessages();

}

protected function removeFlashMessages(){

    $flashMessages = $_SESSION['Flash'] ?? [];


    foreach ($flashMessages as $key => $FlashMessage) {
        if($FlashMessage['remove']){
         unset($flashMessages[$key]);
        }
    }

    $_SESSION['Flash'] = $flashMessages;

}

}