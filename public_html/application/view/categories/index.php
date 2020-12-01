</header>
<main>
    <div class="title"><?=ucfirst($category["name"]);?></div>
    
    <div class="group product_group">
	    <?php
	    $sql = "CALL GetProductByCategory('" . $locality . "', '".$category["categoryId"]."')";
        $query = $this->db->prepare($sql);
        $query->execute();
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        if (count($products) != 0) {
            foreach($products as $product){
    	        ?>
        		<div class="product_item" 
        		onclick="window.location.href='<?=URL?><?=$product["category_name"]?>/<?=$product['productId']?>';"
        		>
        			<img class="image_product"  src="<?=URL?>img/product/<?=$product['productPhoto'];?>" alt="">
        			<div class="product_item_name">
        				<?=$product['name'];?>				
        			</div>
        			<div class="product_item_price">
        				<?=$product['price'];?> ₽
        			</div>
        		</div>
        		<?php
            }	
        }
        else {
            ?>
            <div class="product_item product_item_empty">
                <span>
                    Товаров по данной категории в данном населенном пункте нет.
                </span>
            </div>
            <?php
        }
    	?>
	</div>
	<?php
	require_once APP . 'view/_templates/cities_list.php';
	?>
</main>