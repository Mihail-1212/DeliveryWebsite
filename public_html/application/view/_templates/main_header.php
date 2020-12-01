<?php
$sql = "CALL GetProductCategory(:limit)";
$query = $this->db->prepare($sql);
$parameters = array(':limit' => 15);
$query->execute($parameters);
$title_links = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<nav class="nav-head">
    <?php
    foreach ( $title_links as $title){
        ?>
        <a  onclick="window.location.href='<?=URL;?><?=$title['link_name']?>';" title="<?=$title['name']?>">
             <img src="<?=URL?>img/svg/<?=$title['categorySVG']?>" 
                alt="Your browser does not support SVG">
			<span class="tooltiptext"><?=$title['name']?></span>
		</a>
        <?php
    }
    ?>
</nav>