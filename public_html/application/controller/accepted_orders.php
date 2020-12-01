<?php

/**
 * Class Your_orders
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Accepted_orders extends Controller
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
        require APP . 'view/accepted_orders/index.php';
        require APP . 'view/_templates/footer.php';
    }
    
    public function setExecutedOrder(){
        header('Content-Type: application/json');
        $_POST = json_decode(file_get_contents('php://input'), true);
        $logId = $_POST['order'];
        
        try{
            if (!isset($_SESSION['userToken'])){
                throw new Exception('Вы не авторизованы!');
            }
            $sql = "CALL GetOrderListCourierSelf('" . $_SESSION['userToken'] . "')";
            $query = $this->db->prepare($sql);
            $query->execute();
            $orders = $query->fetchAll(PDO::FETCH_ASSOC);   // ['logId']
            $query->closeCursor();
            $log_list_id = array_column($orders, 'id');
            if(in_array($logId, $log_list_id)){
                $this->model->setOrderStatus($logId, 'executed');
                $return = array('orderInfo'=> 'success');
            } else {
                throw new Exception('Вы не выбрали данный заказ!');
            }
        } catch(Exception $ex){
            $return = array('error' => $ex->getMessage());
        }
        
        echo json_encode($return);
    } 
}