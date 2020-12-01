<?php

class Authorization extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        header('Location: ' . URL . "authorization/login");
        exit();
    }
    
    public function login(){
        // load views
        require APP . 'view/authorization/login.php';
    }
    
    public function registration(){
        // load views
        require APP . 'view/authorization/registration.php';
    }
    
    public function loginTry(){
        header('Content-Type: application/json');
        $_POST = json_decode(file_get_contents('php://input'), true);
        $loginVal = $_POST['loginValue'];
        $passwordVal = $_POST['passwordValue'];
        $token = $this->model->loginRaw($loginVal, $passwordVal);
        if($token){
            $token = Helper::setSession($token);
        }
        else {
            $token = null;
        }
        $return = array('userToken'=> $token);
        
        echo json_encode($return);
    }
    
    public function registrationTry(){
        header('Content-Type: application/json');
        $_POST = json_decode(file_get_contents('php://input'), true);
        $loginVal = $_POST['loginValue'];
        $passwordVal = $_POST['passwordValue'];
        $passwordRepeatVal = $_POST['passwordValueRepeat'];
        if($passwordVal != $passwordRepeatVal){
            throw new Exception('Пароли не совпадают!');
        }
        
        try{
            $passwordVal = md5($passwordVal);
            $query = $this->db->prepare("CALL CreateUser('{$loginVal}', '{$passwordVal}')");
            $query->execute();
            $return = array('answer'=> $loginVal);
            echo json_encode($return);
        } catch(PDOException $Exception){
            // $return = array('answer'=> '$Exception->getMessage()');
            $return = array('error'=> $Exception->getCode());
            echo json_encode($return);
        }
        
    }
    
    public function logout(){
        Helper::stopSession();
        header('Location: ' . URL); 
    }
}