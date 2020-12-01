<?php
?>
<div class="main-cities">
	<span class="main-cities-title">Города</span>
	<ul class="main-cities-collumns">
	    <?php
	    foreach($cities_list as $city){
	        ?>
	        <li><a data-id="<?=$city['localityId'];?>"><?=$city['name']?></a></li>
	        <?php
	    }
	    ?>
	</ul>
</div>