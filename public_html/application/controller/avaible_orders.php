<?php

/**
 * Class Your_orders
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Avaible_orders extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        $need_auth = true;
        $need_courier = true;
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/_templates/main_header.php';
        require APP . 'view/avaible_orders/index.php';
        require APP . 'view/_templates/footer.php';
    }
    
    public function getOrderInfoFull(){
        // products   
        header('Content-Type: application/json');
        $_POST = json_decode(file_get_contents('php://input'), true);
        $logId = $_POST['order'];
        try{
            $token = $this->model->getOrderInfoFull($logId);
            $token['status'] = Helper::getOrderStatusInfo($token['status']);
            $basket = $this->model->getOrderBasketFull($logId);
            $return = array('orderInfo'=> $token, 'basketInfo' => $basket);
        } catch(Exception $ex){
            $return = array('error' => "error");
        }
        
        
        echo json_encode($return);
    }
    
    public function takeOrder(){
        header('Content-Type: application/json');
        $_POST = json_decode(file_get_contents('php://input'), true);
        $logId = $_POST['order'];
        
        try{
            $this->model->takeOrder($logId);
            $return = array('orderInfo'=> 'success');
        } catch(Exception $ex){
            $return = array('error' => 'error');
        }
        
        echo json_encode($return);
    }
}