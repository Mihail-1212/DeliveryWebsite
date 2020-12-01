</header>
<main>
    <div class="title">Категории</div>
    <div class="group category_group">
        <?php
        $sql = "CALL GetProductCategory(0)";
        $query = $this->db->prepare($sql);
        $query->execute();
        $product_category = $query->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($product_category as $item){
            ?>
            <div class="product_item" onclick="window.location.href='<?=URL;?><?=$item['link_name']?>'">
                <!--$item['categoryPhoto']-->
				<img class="image_product"  src="<?=URL?>img/photoCategories/<?=$item['categoryPhoto']?>" alt="">
				<div class="categoty_item_name">
					<?=$item['name']?>					
				</div>
			</div>
    		<?php
        }
		?>
	</div>
				
    <button class="group_show">
		Показать все
	</button>
    
	<div class="group">
	    <?php
	    $sql = "CALL GetProductTop('" . $locality . "');";
        $query = $this->db->prepare($sql);
        $query->execute();
        if($query->rowCount() != 0)
            $products = $query->fetchAll(PDO::FETCH_ASSOC);
        else
            $products = array();
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
    				<?=$product['price']?> ₽
    			</div>
    		</div>
    		<?php
        }	
    	?>
	</div>
	<?php
	require_once APP . 'view/_templates/cities_list.php';
	?>
</main>


<script type="text/javascript" src="<?=URL?>js/main/product_categories_hide.js"></script>
