 <h2><?php echo $this->translate("Documents Sharing Plugin") ?></h2>
<?php if(count($this->navigation) ): ?>
  <div class='sesbasic-admin-navgation'>
		<ul>
		  <?php foreach( $this->navigation as $navigationMenu ): ?>		  
		    <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
		      <?php echo $this->htmlLink($navigationMenu->getHref(), $this->translate($navigationMenu->getLabel()), array(
		        'class' => $navigationMenu->getClass())); ?>
		    </li>
		  <?php endforeach; ?>
		</ul>
  </div>
<?php endif; ?>
