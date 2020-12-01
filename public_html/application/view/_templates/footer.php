        <!-- The Modal -->
        <div id="modal_window" class="modal">
          <span class="close">&times;</span>
          <iframe class="modal_content" scrolling="no"></iframe>
        </div>
        
        <script>
            var link_login = '<?php echo URL; ?>authorization/login';
            var link_registration = '<?php echo URL; ?>authorization/registration';
            var localityId = '<?=$locality?>';
            var localityCoord = [<?=$localityCoord?>];
        </script>
        <script type="text/javascript" src="<?=URL?>js/_template_scripts/modal_window.js"></script>
        <script type="text/javascript" src="<?= URL; ?>js/authorization/authorization.js"></script>
        <script type="text/javascript" src="<?=URL?>js/_template_scripts/helper.js"></script>

        <?php
        $sql = "CALL backend_GetFooterLinks()";
        $query = $this->db->prepare($sql);
        $query->execute();
        $footerlinks = $query->fetchAll(PDO::FETCH_ASSOC);
        ?>
        
        <footer>
        	<div class="main-footer">
        		<img class="logo" src="<?=URL?>img/logo.png" onclick="window.location.href='<?=URL;?>'">
        		<div class="footer-links">
        		    <?php
        		    foreach($footerlinks as $link){
        		        ?>
        		        <a href="<?=$link['link'];?>"><?=$link['name'];?></a>
        		        <?php
        		    }
        		    ?>
        			
        		</div>
        	</div>
        	<div class="footer-site-live">
        		© 2020-2020, тестовый сайт, не используется в коммерческих целях
        	</div>
        </footer>
        
        <a class="button_to_top"></a>
        
        <script type="text/javascript" src="<?= URL; ?>js/_template_scripts/alert.js"></script>
        
        <script type="text/javascript" src="<?= URL; ?>js/_template_scripts/scroll_button.js"></script>
        
        <script type="text/javascript" src="<?= URL; ?>js/_template_scripts/update_cities.js"></script>
        
        <script type="text/javascript" src="<?= URL; ?>js/_template_scripts/main_height.js"></script>
        
        <script type="text/javascript" src="<?= URL; ?>js/_template_scripts/dropdown_menu.js"></script>
    </body>
</html>
