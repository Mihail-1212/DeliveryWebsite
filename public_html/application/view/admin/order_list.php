<!-- Заказы -->

<div class="group input_group datagrid">
  <table class="">
    <thead>
      <tr>
        <th>Статус</th>
        <th>Заказчик</th>
        <th>Исполнитель</th>
        <th>Дата создания</th>
        <th>Дата исполнения</th>
        <th>Сумма</th>
      </tr>
    </thead>
    <tbody>
        <?php
        $orders = $this->model->getOrderListAdmin();
        foreach($orders as $currentOrder){
            ?>
            <tr>
                <td><?=Helper::getOrderStatusInfo($currentOrder['status'])['short_text']?></td>
                <td><?=Helper::getShortFIOParams(
                $currentOrder['clientSurname'],
                $currentOrder['clientName'],
                $currentOrder['clientPatronymic']
                )?></td>
                <?php
                $courier = Helper::getShortFIOParams(
                    $currentOrder['courierSurname'],
                    $currentOrder['courierName'],
                    $currentOrder['courierPatronymic']
                    );
                ?>
                <td><?=empty($courier)?"Заказ не выбран":$courier?></td>
                <?php
                $create_date = date_create($currentOrder['create_datetime']);
                if($currentOrder['execution_datetime'] != null)
                    $execution_date = date_create($currentOrder['execution_datetime']);
                else
                    $execution_date = 'None';
                ?>
                <td><?=date_format($create_date, 'd.m.Y H:i:s')?></td>
                <td><?=$execution_date!='None'?date_format($execution_date, 'd.m.Y H:i:s'):'Не выполнено!'?></td>
                <td><?=$currentOrder['sum']?> ₽</td>
            </tr>
            <?php
        }
        ?>
        
    </tbody>
  </table>
</div>