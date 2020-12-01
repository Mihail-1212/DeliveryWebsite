<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Profile extends Controller
{
    public function index()
    {
        $need_auth = true;
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/profile/index.php';
        require APP . 'view/_templates/footer.php';
    }
    
    public function saveChanges(){
        header('Content-Type: application/json');
        if (isset($_SESSION['userToken'])){
            $user = $this->model->getUserByLogin($_SESSION['userToken']);
            $_POST = json_decode(file_get_contents('php://input'), true);
            $surname = $_POST['surnameValue'];
            $name = $_POST['nameValue'];
            $patronymic = $_POST['patronymicValue'];
            $homeAddress = $_POST['homeAddressValue'];
            try{
                $this->model->updateUserData($user, $surname, $name, $patronymic, $homeAddress);
                $return = array('userToken'=> 'sucess', 'is_success' => true);
                echo json_encode($return);
            } catch(PDOException $Exception){
                
            }
        } else {
            throw new Exception('Вы не авторизованы!');
        }
    }
    
    public function deleteProfile(){
        header('Content-Type: application/json');
        if (isset($_SESSION['userToken'])){
            try{
                $this->model->deleteProfile();
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