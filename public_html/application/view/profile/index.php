</header>
<main>
    <div class="title">
        <?= Helper::getFullFIO($user);?> 
        <?php
        if($user['admin']) {
        ?>
            <img class="admin_svg" src="data:image/svg+xml;base64,PHN2ZyBmaWxsPSIjMmQzNDM2IiBpZD0iYm9sZCIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMjQgMjQiIGhlaWdodD0iNTEyIiB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSI1MTIiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0ibTguNSAyMWMtLjAzNiAwLS4wNzItLjAwNC0uMTA3LS4wMTItLjA4NC0uMDE4LTguMzkzLTEuOTQxLTguMzkzLTExLjA1OXYtNi40MjljMC0uMjA4LjEyOS0uMzk1LjMyNC0uNDY4bDgtM2MuMTEzLS4wNDIuMjM4LS4wNDIuMzUyIDBsOCAzYy4xOTUuMDczLjMyNC4yNi4zMjQuNDY4djYuNDI5YzAgOS4xMTgtOC4zMDkgMTEuMDQyLTguMzkzIDExLjA2LS4wMzUuMDA3LS4wNzEuMDExLS4xMDcuMDExeiIvPjxwYXRoIGQ9Im0yMCAxOWMtMS4xMDMgMC0yLS44OTctMi0ycy44OTctMiAyLTIgMiAuODk3IDIgMi0uODk3IDItMiAyeiIvPjxwYXRoIGQ9Im0yMy4yNSAyNGgtNi41Yy0uNDE0IDAtLjc1LS4zMzYtLjc1LS43NXYtLjVjMC0xLjUxNyAxLjIzMy0yLjc1IDIuNzUtMi43NWgyLjVjMS41MTcgMCAyLjc1IDEuMjMzIDIuNzUgMi43NXYuNWMwIC40MTQtLjMzNi43NS0uNzUuNzV6Ii8+PC9zdmc+" alt="Admin" />
            <span class="tooltiptext">Администратор</span>
        <?php
        }
        ?>
    </div>
    <div class="group input_group">
        <label class="input_label">Фамилия</label>
        <input type="text" name="surname" placeholder="Введите фамилию" value="<?=$user['surname']?>">
        <label class="input_label">Имя</label>
        <input type="text" name="name" placeholder="Введите имя" value="<?=$user['name']?>">
        <label class="input_label">Отчество</label>
        <input type="text" name="patronymic" placeholder="Введите отчество" value="<?=$user['patronymic']?>">
        <label class="input_label">Домашний адрес</label>
        <input type="text" name="homeAddress" placeholder="Введите домашний адрес" value="<?=$user['homeAddress']?>">
        <label class="input_label">Права</label>
        <div class="input_disabled"><?=Helper::getRightsNormal($user);?></div>
        <div class="group_button">
            <button id="save_changes_button">Сохранить изменения</button>
            <button id="delete_button" class="delete_button">Удалить профиль</button>
        </div>
	</div>
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
<script type="text/javascript" src="<?=URL?>js/profile/index.js"></script>

<div class="block_alert">
</div>
<div class="block_hidden_alert">
  <div class="alert success">
    <span class="closebtn">&times;</span>
    <strong>Успех!</strong> Заказ успешно оформлен!
  </div>
</div>

<!--Modal window-->
<div id="modal_window_delete_profile" class="modal">
  <span class="close">×</span>
  <div class="modal_content modal_static_block" scrolling="no" >
        <div class="title">Вы уверены, что хотите удалить свой профиль?</div>
        <div class="input_group">
            <button class="delete_button" id="deleteUserAccept">Удалить</button>
            <button class="static_close">Отмена</button>
        </div>
  </div>
</div>
