</header>


<!--Maps-->
<script src="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js"></script>
<link href="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css" rel="stylesheet" />

<!--GeoCode-->
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>
<link
rel="stylesheet"
href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css"
type="text/css"
/>

<link href="<?=URL; ?>css/order_list.css" rel="stylesheet" />

<script src="<?=URL; ?>js/your_orders/order_list_map.js"></script>
<script src="<?=URL; ?>js/your_orders/cancel_order.js"></script>

<main style="min-height: 297px;">
  <div class="title">
    Ваши заказы
  </div>
  <div class="group product_group product_info">
    <div class="map_order" id="map"></div>
    <div class="product_info__text_info">
      <div class="info_title">Информация о заказе</div>
      <div class="info_body">
        <div class="info_body_row">
          <div class="info_body_row_label">
            Дата создания: 
          </div>
          <div class="info_body_row_value" id="info_body_create_date">
            -
          </div>
        </div>

        <div class="info_body_row">
          <div class="info_body_row_label">
            Дата исполнения: 
          </div>
          <div class="info_body_row_value" id="info_body_execution_date">
            -
          </div>
        </div>

        <div class="info_body_row">
          <div class="info_body_row_label">
            Статус: 
          </div>
          <div class="info_body_row_value" id="info_body_status">
            -
          </div>
        </div>

        <div class="info_body_row">
          <div class="info_body_row_label">
            Дополнительные примечания: 
          </div>
          <div class="info_body_row_value">
            <a class="info_body_row_value_show_modal" id="button_show_additional_noted">Показать</a>
          </div>
        </div>

        <div class="info_body_row">
          <div class="info_body_row_label">
            Корзина заказа: 
          </div>
          <div class="info_body_row_value">
            <a class="info_body_row_value_show_modal" id="button_show_basket">Показать</a>
          </div>
        </div>

        <div class="info_body_row">
          <div class="info_body_row_label">
            Сумма заказа: 
          </div>
          <div class="info_body_row_value" id="info_body_sum">
            -
          </div>
        </div>
        
        <input type="hidden" id="orderIdInput" />
        
        <button title="Отмена заказа" style="visibility: collapse;" class="canlce_button" id="orderCancle"></button>

      </div>
    </div>
  </div>
  
  <?php
    $sql = "CALL GetOrderList('" . $user['login'] . "')";
    $query = $this->db->prepare($sql);
    $query->execute();
    $orders = $query->fetchAll(PDO::FETCH_ASSOC);
    if (count($orders) == 0) {
        ?>
        <div class="group product_group order_list_group order_list_group_empty">
            У вас нет заказов!
        </div>
        <?php

    } else {
        ?>
        <div class="subtitle">История</div>
        <div class="group product_group order_list_group" id="order_list_group">
            <div class="order_item title_item">
              <div class="status">Статус</div>
              <div class="create_date">Дата создания</div>
              <div class="execution_date">Дата выполнения</div>
              <div class="first_product">Корзина</div>
            </div>
        <?php
        
        foreach($orders as $order){
            $status_info = Helper::getOrderStatusInfo($order['status']);
            ?>
            <div class="order_item" data-order="<?=$order['id']?>">
              <div class="status">
                <img alt="" class="status_image" src="<?=URL?>img/order_status/<?=$status_info['svg']?>">
                <div class="status_tooltip"><?=$status_info['public_text']?></div>
              </div>
              <?php
              $create_date = date_create($order['create_datetime']);
              if($order['execution_datetime'] != null)
                $execution_date = date_create($order['execution_datetime']);
              else
                $execution_date = 'None';
              ?>
              <div class="create_date"><?=date_format($create_date, 'd.m.Y H:i:s')?></div>
              <div class="execution_date"><?=$execution_date!='None'?date_format($execution_date, 'd.m.Y H:i:s'):'Не выполнено!'?></div>
              <div class="first_product"><?=$order['first_product']?> и другое...</div>
            </div>
            
            <?php
        }
        ?>
        </div>
        <?php
    }
  ?>
</main> 

<div id="modal_window_show_additional_noted" class="modal" style="display: none;">
    <span class="close">×</span>
    <div class="modal_content modal_static_block" scrolling="no">
          <div class="title">Дополнительные примечания к заказу</div>
          <div class="main_text additional_noted_block" id="additional_noted_block">
            -
          </div>
    </div>
</div>

<div id="modal_window_show_basket" class="modal" style="display: none;">
    <span class="close">×</span>
    <div class="modal_content modal_static_block" scrolling="no">
          <div class="title">Корзина заказа</div>
          <div class="main_text basket_block">
            <div class="order_item order_title">
              <div class="order_item__value">Название</div>
              <div class="order_item__value">Количество</div>
              <div class="order_item__value">Цена</div>
            </div>
            
            <div class="order_item_body" id="basket_block">
                <div class="order_item">
                  <div class="order_item__value">-</div>
                  <div class="order_item__value">-</div>
                  <div class="order_item__value">-</div>
                </div>
            </div>
          </div>
    </div>
</div>

<div id="modal_window_cancel_order" class="modal">
  <span class="close">×</span>
  <div class="modal_content modal_static_block" scrolling="no" >
        <div class="title">Вы уверены, что хотите отменить заказ?</div>
        <div class="input_group">
            <button class="static_close" id="cancelOrderButtonSubmit">Да</button>
            <button class="static_close delete_button">Нет</button>
        </div>
  </div>
</div>