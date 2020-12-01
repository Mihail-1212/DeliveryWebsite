<?php

class Model
{
    /**
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
    
    public function loginRaw($userLogin, $userPassword){
        $sql = "SELECT * FROM User WHERE login='" . $userLogin . "' AND password='" . md5($userPassword) . "'";
        $query = $this->db->prepare($sql);
        
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getUserByLogin($userLogin){
        $sql = "SELECT * FROM User WHERE login=:loginValue";
        $query = $this->db->prepare($sql);
        $parameters = array(':loginValue' => $userLogin);
        $query->execute($parameters);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateUserData($user, $surname, $name, $patronymic, $homeAddress){
        $login = $user['login'];
        $surname = Helper::checkIsStringNull($surname);
        $name = Helper::checkIsStringNull($name);
        $patronymic = Helper::checkIsStringNull($patronymic);
        $homeAddress = Helper::checkIsStringNull($homeAddress);
            
        $sql = "CALL UpdateUser('{$login}', '{$surname}', '{$name}', '{$patronymic}', '{$homeAddress}')";
        $query = $this->db->prepare($sql);
        $query->execute();
    }
    
    public function updateUserDataAdmin($login, $surname, $name, $patronymic, $homeAddress, $rights, $admin){
        $surname = Helper::checkIsStringNull($surname);
        $name = Helper::checkIsStringNull($name);
        $patronymic = Helper::checkIsStringNull($patronymic);
        $homeAddress = Helper::checkIsStringNull($homeAddress);
        $rights = Helper::checkIsStringNull($rights);
        $admin = Helper::checkIsStringNull($admin);
            
        $sql = "CALL UpdateUserAdmin('{$login}', '{$surname}', '{$name}', '{$patronymic}', '{$homeAddress}', '{$admin}', '{$rights}')";
        $query = $this->db->prepare($sql);
        $query->execute();
    }
    
    /***
     * @param $product_array => array of dict{'productId', 'productCount'}
     * @param $coords => array[lat, lng]
     * @param $additional_notes => additional notes of order as text
     */
    // orderSave
    public function orderSave($product_array, $coords, $additional_notes=null){
        if(isset($_SESSION['userToken'])){
            // implode 
            $coords = implode(", ", $coords);
            $insert_order_sql = "CALL CreateOrder('" . $additional_notes . "', '". $_SESSION['userToken'] ."', '". $coords ."')";
            $insert_order_query = $this->db->prepare($insert_order_sql);
            $insert_order_query->execute();
            $order_id = $insert_order_query->fetch(PDO::FETCH_ASSOC)['insert_id'];
            $insert_order_query->closeCursor();
            $sql = "CALL CreateBasket(:order_id, :productCount, :productId, :locality)";
            try{
                $query = $this->db->prepare($sql);
                foreach($product_array as $product_encoded_value){
                    $productId = $product_encoded_value['productId'];
                    $productCount = $product_encoded_value['productCount'];
                    // $sql = "CALL CreateBasket(" . $order_id . ", " . $productCount . ", " . $productId . ", " . $_COOKIE['locality'] . ")";
                    
                    $query->execute(
                        array(
                            ':order_id' => $order_id,
                            ':productCount' => $productCount,
                            ':productId' => $productId,
                            ':locality' => $_COOKIE['locality'] 
                            )
                        );
                }
                
            } catch(PDOException $ex){
                return $ex->getCode();
            }
            return $order_id;
        } else {
            throw new Exception('Вы не авторизованы!');
        }
    }
    
    public function getOrderInfo($logId){
        if(isset($_SESSION['userToken'])){
            $sql = "CALL GetOrderInfo(:logId, :userLogin)";
            // SELECT * FROM User WHERE login=:loginValue
            $query = $this->db->prepare($sql);
            $parameters = array(':logId' => $logId, ':userLogin' => $_SESSION['userToken']);
            $query->execute($parameters);
            return $query->fetch(PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Вы не авторизованы!');
        }
    }
    
    public function getOrderInfoFull($logId){
        if(isset($_SESSION['userToken'])){
            $currentUser = $this->getUserByLogin($_SESSION['userToken']);
            if($currentUser['user_type'] != 'courier'){
                throw new Exception('Вы не курьер');
            }
            $sql = "CALL GetOrderInfoCourier(:logId)";
            // SELECT * FROM User WHERE login=:loginValue
            $query = $this->db->prepare($sql);
            $parameters = array(':logId' => $logId);
            $query->execute($parameters);
            return $query->fetch(PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Вы не авторизованы!');
        }
    }
    
    public function getOrderBasket($logId){
        if(isset($_SESSION['userToken'])){
            $sql = "CALL GetOrderBasket(:logId, :userLogin)";
            // SELECT * FROM User WHERE login=:loginValue
            $query = $this->db->prepare($sql);
            $parameters = array(':logId' => $logId, ':userLogin' => $_SESSION['userToken']);
            $query->execute($parameters);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Вы не авторизованы!');
        }
    }
    
    public function getOrderBasketFull($logId){
        if(isset($_SESSION['userToken'])){
            $currentUser = $this->getUserByLogin($_SESSION['userToken']);
            if($currentUser['user_type'] != 'courier'){
                throw new Exception('Вы не курьер');
            }
            $sql = "CALL GetOrderBasketCourier(:logId)";
            // SELECT * FROM User WHERE login=:loginValue
            $query = $this->db->prepare($sql);
            $parameters = array(':logId' => $logId);
            $query->execute($parameters);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Вы не авторизованы!');
        }
    }
    
    public function setOrderStatus($logId, $status){
        if(isset($_SESSION['userToken'])){
            $update_order_status_query = "CALL UpdateOrderStatus(:logId, :userLogin, :status)";
            $update_order_status = $this->db->prepare($update_order_status_query);
            $parameters = array(':logId' => $logId, ':userLogin' => $_SESSION['userToken'], ':status' => $status);
            $update_order_status->execute($parameters);
        } else {
            throw new Exception('Вы не авторизованы!');
        }
    }
    
    public function takeOrder($logId){
        if(isset($_SESSION['userToken'])){
            $user = $this->getUserByLogin($_SESSION['userToken']);  // получение пользователя для проверки
            if($user['user_type'] != 'courier') {
                throw new Exception('Вы не курьер!');
            }
            $orderInfo = $this->getOrderInfoFull($logId);
            $stackId = $orderInfo['stackId'];
            
            $take_order_query = "CALL TakeOrderCourier(:stackId_param, :userlogin_param)";
            $take_order = $this->db->prepare($take_order_query);
            $parameters = array(':stackId_param' => $stackId, ':userlogin_param' => $_SESSION['userToken']);
            $take_order->execute($parameters);
        }
        else {
            throw new Exception('Вы не авторизованы!');
        }
    }
    
    public function getUserListAdmin(){
        if(isset($_SESSION['userToken'])){
            $user = $this->getUserByLogin($_SESSION['userToken']);
            if(!$user['admin']){
                throw new Exception('Вы не администратор!');
            }
            $getUserListQuery = "CALL GetUserListAdmin(:userLogin_param)";
            $getUserList = $this->db->prepare($getUserListQuery);
            $parameters = array(':userLogin_param' => $_SESSION['userToken']);
            $getUserList->execute($parameters);
            $userList = $getUserList->fetchAll(PDO::FETCH_ASSOC);
            $getUserList->closeCursor();
            return $userList;
        }
        else {
            throw new Exception('Вы не авторизованы!');
        }
    }
    
    public function getOrderListAdmin() {
        if(isset($_SESSION['userToken'])){
            $user = $this->getUserByLogin($_SESSION['userToken']);
            if(!$user['admin']){
                throw new Exception('Вы не администратор!');
            }
            $getOrderListQuery = "CALL GetOrderListAdmin()";
            $getOrderList = $this->db->prepare($getOrderListQuery);
            $getOrderList->execute();
            $orderList = $getOrderList->fetchAll(PDO::FETCH_ASSOC);
            $getOrderList->closeCursor();
            return $orderList;
        }
        else {
            throw new Exception('Вы не авторизованы!');
        }
    }
    
    public function deleteProfile(){
        if(isset($_SESSION['userToken'])){
            $sql = "CALL DeleteUser(:userLogin_param)";
            $query = $this->db->prepare($sql);
            $parameters = array(':userLogin_param' => $_SESSION['userToken']);
            $query->execute($parameters);
        }
        else {
            throw new Exception('Вы не авторизованы!');
        }
    }
    
    public function deleteProfileAdmin($login){
        if(isset($_SESSION['userToken'])){
            $currentUser = $this->getUserByLogin($_SESSION['userToken']);
            if($currentUser['admin']){
                $sql = "CALL DeleteUser(:userLogin_param)";
                $query = $this->db->prepare($sql);
                $parameters = array(':userLogin_param' => $login);
                $query->execute($parameters);
            } else {
                throw new Exception('Вы не администратор!');
            }
        }
        else {
            throw new Exception('Вы не авторизованы!');
        }
    }
}
