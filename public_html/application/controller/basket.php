<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Basket extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        $need_auth = true;
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/_templates/main_header.php';
        require APP . 'view/basket/index.php';
        require APP . 'view/_templates/footer.php';
    }
    
    public function saveOrder(){
        // products   
        header('Content-Type: application/json');
        $_POST = json_decode(file_get_contents('php://input'), true);
        $products = $_POST['products'];
        $coords = $_POST['coords'];
        $additional_notes = $_POST['additional_notes'];
        $additional_notes = trim($additional_notes);
        try{
            $token = $this->model->orderSave($products, $coords, $additional_notes);
            $return = array('userToken'=> $token);
        } catch(Exception $ex){
            $return = array('error' => "error");
        }
        
        
        echo json_encode($return);
    }
}