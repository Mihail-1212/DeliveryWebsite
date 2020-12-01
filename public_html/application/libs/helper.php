<?php

class Helper
{
    /**
     * debugPDO
     *
     * Shows the emulated SQL query in a PDO statement. What it does is just extremely simple, but powerful:
     * It combines the raw query and the placeholders. For sure not really perfect (as PDO is more complex than just
     * combining raw query and arguments), but it does the job.
     * 
     * @author Panique
     * @param string $raw_sql
     * @param array $parameters
     * @return string
     */
    static public function debugPDO($raw_sql, $parameters) {

        $keys = array();
        $values = $parameters;

        foreach ($parameters as $key => $value) {

            // check if named parameters (':param') or anonymous parameters ('?') are used
            if (is_string($key)) {
                $keys[] = '/' . $key . '/';
            } else {
                $keys[] = '/[?]/';
            }

            // bring parameter into human-readable format
            if (is_string($value)) {
                $values[$key] = "'" . $value . "'";
            } elseif (is_array($value)) {
                $values[$key] = implode(',', $value);
            } elseif (is_null($value)) {
                $values[$key] = 'NULL';
            }
        }

        /*
        echo "<br> [DEBUG] Keys:<pre>";
        print_r($keys);
        
        echo "\n[DEBUG] Values: ";
        print_r($values);
        echo "</pre>";
        */
        
        $raw_sql = preg_replace($keys, $values, $raw_sql, 1, $count);

        return $raw_sql;
    }
    
    static public function setSession($token){
        $_SESSION['userToken'] = $token['login'];
        $return = $token['login'];
        return $return;
    }
    
    static public function stopSession(){
        $return = $_SESSION['userToken'];
        unset($_SESSION['counter']);
        session_destroy();
        return $return;
    }
    
    static public function getFullFIO($user){
        return (ucfirst($user['surname']) . ' ' . ucfirst($user['name']) . (!is_null($user['patronymic'])?' ' . ucfirst($user['patronymic']):''));
    }
    
    static public function getFullFIOParams($surename, $name, $patronymic=''){
        return (ucfirst($surename) . ' ' . ucfirst($name) . ucfirst($patronymic));
    }
    
    static public function getShortFIOParams($surename, $name, $patronymic){
        if($surename && $name)
            return ucfirst($surename) . ' ' . mb_substr(ucfirst($name), 0, 1) . '. ' . (!is_null($patronymic)?(mb_substr(ucfirst($patronymic), 0, 1) . '.'):'');
        else
            return "";
    }
    
    static public function getRightsNormal($user){
        switch($user['user_type']){
            case 'client':
                return 'Клиент';
                break;
            case 'courier':
                return 'Курьер';
                break;
            default:
                return 'Ошибка';
                break;
        } 
    }
    /**
     * return null or full string
     */
    static public function checkIsStringNull($string){
        if ($string !== '')
            return $string;
        return null;
    }
    
    /*
        return svg, public text and short text by eng status enum
        'accepted', 'executed', 'failure'
    */
    
    static public function getOrderStatusInfo($status){
        $status_info = array();
        switch ($status) {
            case 'accepted':
                $status_info['short_text'] = 'Принято';
                $status_info['svg'] = 'sand.svg';
                $status_info['public_text'] = 'Принято на обработку';
                break;
            case 'executed':
                $status_info['short_text'] = 'Выполнено';
                $status_info['svg'] = 'check.svg';
                $status_info['public_text'] = 'Заказ выполнен';
                break;
            case 'failure':
                $status_info['short_text'] = 'Отменено';
                $status_info['svg'] = 'cross.svg';
                $status_info['public_text'] = 'Заказ отменен';
                break;
        }
        $status_info['status'] = $status;
        return $status_info;
    }
}