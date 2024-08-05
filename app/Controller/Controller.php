<?php

namespace App\Controller;

use App\Model\Model;

class Controller
{
    public $post;
    protected static $conn;
    public function __construct(){
        $this->post = [];
        self::$conn = Model::conn();

        if(!empty($_POST)) {
            foreach ($_POST as $key => $val) {
                if(is_array($val)){
                    $this->post[$key] = (array)(array_key_exists($key, $_POST)) ? $_POST[$key] : [];
                } else {
                    $this->post[$key] = Model::treat($val);
                }
            }
        }
    }

}