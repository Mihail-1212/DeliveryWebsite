</header>

<main>
    <?php
    if(!isset($_GET["type"])){
        $type = 'main_menu';
    } else {
        switch ($_GET["type"]) {
            case 'user':
                $type = 'user_list';
                $title = 'Пользователь';
                break;
            case 'order':
                $type = 'order_list';
                $title = 'Заказ';
                break;
            default:
                echo '<script>window.location.href="' . URL . 'problem";</script>';
                break;
        }
        if(isset($_GET['edit'])){
            switch ($_GET["type"]) {
                case 'user':
                    $type = 'user_edit';
                    $title = 'Пользователь';
                    break;
                case 'order':
                    echo '<script>window.location.href="' . URL . 'problem";</script>';
                    break;
                default:
                    echo '<script>window.location.href="' . URL . 'problem";</script>';
                    break;
            }
        }
    }
    ?>
    
    <div class="title">
      Панель администрирования <?=isset($title)?'- ' . $title:""?>
    </div>
    
    <?php
    require APP . 'view/admin/' . $type . '.php';
    ?>
    
    <?php //require APP . 'view/admin/user_list.php'; ?>
    
    <?php //require APP . 'view/admin/order_list.php'; ?>

    <?php //require APP . 'view/admin/user_edit.php'; ?>

</main>

<div class="block_alert">
</div>

<div class="block_hidden_alert">
	<div class="alert error surnameMiss">
		<span class="closebtn">&times;</span>
		<strong>Ошибка!</strong> Вы не указали фамилию!
	</div>
	
	<div class="alert error nameMiss">
		<span class="closebtn">&times;</span>
		<strong>Ошибка!</strong> Вы не указали имя!
	</div>
	
	<div class="alert error uncorrectUserData">
		<span class="closebtn">&times;</span>
		<strong>Ошибка!</strong> Неправильные пользовательские данные!
	</div>

	<div class="alert success">
		<span class="closebtn">&times;</span>
		<strong>Успех!</strong>
	</div>
</div>

<!--Modal window-->
<div id="modal_window_delete_profile" class="modal">
  <span class="close">×</span>
  <div class="modal_content modal_static_block" scrolling="no" >
        <div class="title">Вы уверены, что хотите удалить данного пользователя?</div>
        <div class="input_group">
            <button class="delete_button" id="deleteUserAccept">Удалить</button>
            <button class="static_close">Отмена</button>
        </div>
  </div>
</div>