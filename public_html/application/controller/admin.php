<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Admin extends Controller
{
    public function index()
    {
        $need_admin = true;
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/admin/index.php';
        require APP . 'view/_templates/footer.php';
    }
    
    public function saveUserEdit(){
        header('Content-Type: application/json');
        $_POST = json_decode(file_get_contents('php://input'), true);
        $login = $_POST['loginValue'];
        $surname = $_POST['surnameValue'];
        $name = $_POST['nameValue'];
        $patronymic = $_POST['patronymicValue'];
        $homeAddress = $_POST['homeAddressValue'];
        $rights = $_POST['rightsValue'];
        $admin = $_POST['isAdminValue'];
        try {
            $this->model->updateUserDataAdmin($login, $surname, $name, $patronymic, $homeAddress, $rights, $admin);
            $return = array('success'=> 'success');
        } catch(Exception $ex){
            $return = array('error' => 'error');
        }
        
        echo json_encode($return);
    }
    
    public function deleteUserAdmin(){
        header('Content-Type: application/json');
        $_POST = json_decode(file_get_contents('php://input'), true);
        $login = $_POST['loginValue'];
        if (isset($_SESSION['userToken'])){
            try{
                $this->model->deleteProfileAdmin($login);
                $return = array('userToken'=> 'sucess', 'is_success' => true);
            } catch(PDOException $Exception){
                $return = array('userToken'=> 'error');
            }
            echo json_encode($return);
        } else {
            throw new Exception('Вы не авторизованы!');
        }
    }
}