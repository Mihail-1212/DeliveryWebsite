<?php

// if have cookie login => auth (header)
$sql = "CALL GetCitiesList()";
$query = $this->db->prepare($sql);
$query->execute();
$cities_list = $query->fetchAll(PDO::FETCH_ASSOC);
$query->closeCursor();
$cities_list_id = array_column($cities_list, 'localityId');
if (isset($_COOKIE['locality']) && in_array($_COOKIE['locality'], $cities_list_id)) {
    $locality = $_COOKIE['locality'];
}
else {
    unset($_COOKIE['locality']); 
    setcookie('locality', null, -1, '/'); 
    $locality = $cities_list_id[0];
    setcookie('locality', $locality, '/'); 
}

// if (!isset($_SESSION['userId'])) {
//     header('Location: ' . URL . 'authorization');
// }
   
// setcookie("locality",1);
if (isset($_SESSION['userToken'])){
    $user = $_SESSION['userToken'];
    $user = $this->model->getUserByLogin($user);
}
if(isset($need_auth) && is_null($user)){
    header('Location: ' . URL . 'authorization');
}


if(isset($need_courier) && (is_null($user) || $user['user_type'] != 'courier') ){
    header('Location: ' . URL . 'authorization');
}

if(isset($need_admin) && (is_null($user) || !$user['admin'])){
    header('Location: ' . URL . 'authorization');
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Сеть быстрого питания Delivery</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?= URL; ?>css/styles.css">
	<link rel="icon" href="<?=URL;?>/img/logo.ico">
	<link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@900&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?= URL; ?>css/modal_window.css">
	<link rel="stylesheet" type="text/css" href="<?=URL?>css/datagrid.css">
	<script type="text/javascript" src="<?= URL; ?>js/_template_scripts/custom_select.js"></script>
</head>
	<body>
        <script>
        var url = '<?= URL; ?>';
        function getCookie(name) {
          let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
          ));
          return matches ? decodeURIComponent(matches[1]) : undefined;
        }
        
        function setCookie(name, value, options = {}) {
          options = {
            path: '/',
            // при необходимости добавьте другие значения по умолчанию ...options
          };
    
          if (options.expires instanceof Date) {
            options.expires = options.expires.toUTCString();
          }
    
          let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);
    
          for (let optionKey in options) {
            updatedCookie += "; " + optionKey;
            let optionValue = options[optionKey];
            if (optionValue !== true) {
              updatedCookie += "=" + optionValue;
            }
          }
    
          document.cookie = updatedCookie;
        }
        
        function deleteCookie(name) {
          document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        }
        
        function findGetParameter(parameterName) {
            var result = null,
                tmp = [];
            location.search
                .substr(1)
                .split("&")
                .forEach(function (item) {
                  tmp = item.split("=");
                  if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
                });
            return result;
        }

        </script>
        <?php
        $sql = "CALL backend_GetTitlesHeader()";
        $query = $this->db->prepare($sql);
        $query->execute();
        $main_titles = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        ?>
        <header>
            <div class="top_header_title">
                <div class="top_header_cities">
                    <span>Ваш город: </span>
                    <div class="custom-select">
                        <select id="cities_show">
                            <option value="Выберите город">Выберите город</option>
                            <?php
                            foreach($cities_list as $locality_item){
                                ?>
                                <option value="<?=$locality_item['localityId'];?>"><?=$locality_item['name']?></option>
                                <?php
                                if($locality_item['localityId'] == $locality) {
                                    $localityCoord = $locality_item['coordinates'];
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        	<div class="logo_head">
        		<img class="logo" src="<?=URL?>img/logo.png" onclick="window.location.href='<?=URL;?>'">
        		<section class="head_menu">
        		    <?php
        		    foreach($main_titles as $main_title){
        		        ?>
        		        <a href="<?=$main_title['link']?>"><?=$main_title['name']?></a>
        		        <?php
        		    }
        		    ?>
        		</section>
        		<section class="registration menu_container">
        		    <?php
        		    if (isset($user)){
        		        ?>
                        <a class="dropdown_button profile_header_button" id="profile_registration">
            		        <?=ucfirst($user['surname']) ?> 
            		        <?=mb_substr(ucfirst($user['name']), 0, 1)?>. 
            		        <?php
            		            if (!is_null($user['patronymic'])) {
            		                echo mb_substr (ucfirst($user['patronymic']), 0, 1) . '.';
            		            }
            		        ?>
            		    </a>
                        <div class="menu hiding" data-for="profile_registration">
                            <a class="menu__item" href="<?=URL?>profile">Профиль</a>
                            <a class="menu__item" href="<?=URL?>basket">Корзина</a>
                            <a class="menu__item" href="<?=URL?>your_orders">Ваши заказы</a>
                            <?php
                            if($user['user_type'] == 'courier'){
                                ?>
                                <hr>
                                <a class="menu__item" href="<?=URL?>avaible_orders">Доступные заказы</a>
                                <a class="menu__item" href="<?=URL?>accepted_orders">Принятые заказы</a>
                                <?php
                            }
                            ?>
                            <?php
                            if($user['admin']){
                                ?>
                                <hr>
                                <a class="menu__item" href="<?=URL?>admin">Управление</a>
                                <?php
                            }
                            ?>
                            <hr>
                            <a class="menu__item" href="<?=URL?>authorization/logout">Выход</a>
                        </div>
        		        <?php
        		    } else {
        		        ?>
        		        <a>
            				<span id="registration_button">
            					Регистрация
            				</span>
            				<span id="authorization_button">
            					Авторизация
            				</span>
            			</a>
        		        <?php
        		    }
        		    ?>
        			
        		</section>
        	</div>
