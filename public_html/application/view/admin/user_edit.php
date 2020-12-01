<!-- Изменение пользователя -->
<?php
$editUser = $this->model->getUserByLogin($_GET['edit']);
if($editUser == null){
    echo '<script>window.location.href="' . URL . 'problem";</script>';
}
?>

<script type="text/javascript" src="<?=URL?>js/admin/user_rights.js"></script>

<script type="text/javascript" src="<?=URL?>js/admin/user_edit.js"></script>

<div class="group input_group">
  <label class="input_label">Фамилия</label>
  <input type="text" name="surname" placeholder="Введите фамилию" value="<?=$editUser['surname']?>">
  <label class="input_label">Имя</label>
  <input type="text" name="name" placeholder="Введите имя" value="<?=$editUser['name']?>">
  <label class="input_label">Отчество</label>
  <input type="text" name="patronymic" placeholder="Введите отчество" value="<?=$editUser['patronymic']?>">
  <label class="input_label">Домашний адрес</label>
  <input type="text" name="homeAddress" placeholder="Введите домашний адрес" value="<?=$editUser['homeAddress']?>">
  <label class="input_label">Права</label>
  <div class="custom-select">
    <select id="current_user_rights" data-initialize="<?=$editUser['user_type']?>">
        <option value="Выберите тип прав">Выберите тип прав</option>
        <option value="client">Клиент</option>
        <option value="courier">Курьер</option>
    </select>
  </div>
  <label class="input_label">Администратор</label>
  <input type="checkbox" id="isAdminCheckbox" <?=$editUser['admin']?'checked="checked"':''?>>
  <label class="input_label_checkbox" for="isAdminCheckbox">Администратор</label>
  <div class="group_button">
      <button id="save_changes_button">Сохранить изменения</button>
      <button id="delete_button" class="delete_button">Удалить пользователя</button>
  </div>
</div>



