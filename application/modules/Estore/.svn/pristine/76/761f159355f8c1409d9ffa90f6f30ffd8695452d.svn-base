<div class="estore_myaccount_sidebar">
	<ul class="estore_myaccount_list">
	<?php foreach($this->navigation as $subnavigationMenu ): ?>
	<?php $icons = array('billing' =>'fa-location-arrow', 'shipping' =>'fa-location-arrow', 'myorder' =>'fa-location-arrow', 'mydownloads' =>'fa-location-arrow', 'mywishlist' =>'fa-location-arrow', 'myreview' =>'fa-location-arrow'); ?>
	    <li <?php if ($subnavigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
	        <?php if ($subnavigationMenu->action){ ?>
	            <a class= "<?php echo $subnavigationMenu->class ?>" href='<?php echo empty($subnavigationMenu->uri) ? $this->url(array('action' => $subnavigationMenu->action), $subnavigationMenu->route, true) : $subnavigationMenu->uri ?>'><?php echo $this->translate($subnavigationMenu->label); ?></a>
	        <?php } else { ?>
	            <a class= "<?php echo $subnavigationMenu->class ?>" href='<?php echo empty($subnavigationMenu->uri) ? $this->url(array(), $subnavigationMenu->route, true) : $subnavigationMenu->uri ?>'><?php echo $this->translate($subnavigationMenu->label); ?></a>
	        <?php } ?>
	    </li>
	    <?php $subcountMenu++; endforeach; ?>
	</ul>
</div>