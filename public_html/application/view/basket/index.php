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
<!-- Promise polyfill script required to use Mapbox GL Geocoder in IE 11 -->
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>

<!--
<script src='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.js'></script>
<link href='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.css' rel='stylesheet' />
-->
<!--/Maps-->

<script src="<?URL;?>js/basket/map.js" type="text/javascript"></script>

<link rel="stylesheet" href="<?=URL?>css/basket_style.css">
<script src="<?=URL?>js/basket/basket_product.js" type="text/javascript"></script>

<main>
  <div class="title">
    Корзина заказа
  </div>
  <div class="group_group">
    <div class="group group_product">
        
        <?php
            if(isset($_COOKIE["basket"])){
                
                $cookie_items = $_COOKIE["basket"];
                $basket_items = json_decode($cookie_items, true);
                
                foreach ($basket_items as $value){
                    $currentId = $value['productId'];
                    $query = $this->db->prepare("CALL GetProductById(:product, :locality)");
                    $parameters = array(
                        ':product' => $value['productId'], 
                        ':locality' => $value['locality']);
                    $query->execute($parameters);
                    // if ($query->rowCount() == 0)
                    //     echo '<script>document.location.replace("' . URL . 'problem");</script>';
                    $product = $query->fetch(PDO::FETCH_ASSOC);
                    // productId
                    // count
                    // locality
                    
                    ?>
                    <div class="basket_product_item" data-productId="<?=$product['productId']?>">
                        <img class="basket_product_item_image" src="<?=URL?>img/product/<?=$product['productPhoto'];?>" alt="product item">
                        <div class="basket_product_item_info"><div class="basket_product_item_info_title"><?=$product['name']?></div></div>
                        <div class="basket_product_item_product_count">
                          <div class="placeholder">шт.</div>
                          <input class="change_count_basket" type="number" min="0" max="100" value="<?=$value['count']?>"> 
                        </div>
                        <div class="basket_product_item_product_price">
                          <div class="placeholder">цена за шт.</div>
                          <span class="basket_product_item_product_price_sum"><?=$product['productPrice']?> ₽</span>
                        </div>
                        <div class="basket_product_item_delete"><a class="delete_product_click"></a></div>
                    </div>
                                
                    <?php
                }
            }
        ?>
    </div>
    
    <div class="group_right">
      <div class="group_map">
        <div id="map"></div>
      </div>
      <div class="group group_info input_group">
        <div class="info_text">
          <div id="total"></div>
        </div>

        <button id="checkoutButton" class="custom_button">Оформить заказ</button>
      </div>
      
    </div>
    
  </div>
    
</main>    

<div class="block_alert">
</div>
<div class="block_hidden_alert">
  <div class="alert error unFindedPlace">
    <span class="closebtn">&times;</span>
    <strong>Ошибка!</strong> Вы не выбрали место доставки!
  </div>
  
  <div class="alert error unFindedBasket">
    <span class="closebtn">&times;</span>
    <strong>Ошибка!</strong> Ваша корзина пуста!
  </div>

  <div class="alert success">
    <span class="closebtn">&times;</span>
    <strong>Успех!</strong> Заказ успешно оформлен!
  </div>
</div>


<!--Modal window-->
<div id="modal_window_save_order" class="modal">
  <span class="close">×</span>
  <div class="modal_content modal_static_block" scrolling="no" >
        <div class="title">Вы уверены, что хотите сделать заказ?</div>
        <div class="input_group">
            <textarea name="additional_notes" placeholder="Комментарий"></textarea>
        </div>
        <div class="input_group">
            <button class="static_close" id="checkoutButtonAccept">Сохранить</button>
            <button class="static_close delete_button">Отмена</button>
        </div>
  </div>
</div>