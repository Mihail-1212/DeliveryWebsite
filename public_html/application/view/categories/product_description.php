<?php
$query = $this->db->prepare("CALL GetProduct(:locality, :product, :category)");
$parameters = array(
    ':product' => $product_id, 
    ':category' => $category['categoryId'],
    ':locality' => $locality);
$query->execute($parameters);
if ($query->rowCount() == 0)
    echo '<script>window.location.href = "'. URL . 'problem");</script>';
$product = $query->fetch(PDO::FETCH_ASSOC);
?>
</header>
<main>
    <div class="product_description">
        <div class="title">
            <?=ucfirst($product["name"]);?> 
            <span class="category"><?=$product["category_name"];?></span>
        </div>
        
        <div class="product_description_info">
            <div class="photo_block">
                <img class="image_product"  src="<?=URL?>img/product/<?=$product['productPhoto'];?>" alt="Product">
                <div class="photo_text">
                    <span class="price">
                        <?=$product['price'];?> ₽
                    </span>
                    <a class="to_basket" id="add_to_basket">
                        Добавить в корзину
                    </a>
                    
                </div>
            </div>
            
            <div class="description_text">
                <?=$product["description"]??"Нет описания"?>        
            </div>
        </div>
    </div>
</main>
<div class="block_alert">
</div>
<div class="block_hidden_alert">
  <div class="alert error alreadyAddedToBasket">
    <span class="closebtn">&times;</span>
    <strong>Ошибка!</strong> Товар уже добавлен в корзину!
  </div>

  <div class="alert success">
    <span class="closebtn">&times;</span>
    <strong>Успех!</strong> Товар успешно добавлен в корзину!
  </div>
</div>
<script>
    var productId = '<?=$product['productId']?>';
</script>
<script type="text/javascript" src="<?=URL?>js/categories/product_description.js"></script>