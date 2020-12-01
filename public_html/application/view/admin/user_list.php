<!-- Пользователи -->

<script type="text/javascript" src="<?=URL?>js/admin/user_list.js"></script>

<div class="group input_group datagrid">
  <table class="cursor_table">
    <thead>
      <tr>
        <th>ФИО</th>
        <th>Логин</th>
        <th>Права</th>
        <th>Администратор</th>
      </tr>
    </thead>
    <tbody>
        <?php
        $users = $this->model->getUserListAdmin();
        foreach($users as $currentUser){
            ?>
            <tr class="userRow" data-login="<?=$currentUser['login']?>">
                <td><?=Helper::getFullFIO($currentUser)?></td>
                <td><?=$currentUser['login']?></td>
                <td><?=Helper::getRightsNormal($currentUser)?></td>
                <td><?=$currentUser['admin']?"Администратор":"Обычный пользователь"?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
  </table>

</div>
