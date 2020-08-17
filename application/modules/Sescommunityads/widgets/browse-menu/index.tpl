<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescommunityads
 * @package    Sescommunityads
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-09 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
 <?php if(!empty($_SESSION['removeSiteHeaderFooter'])){ ?>
  <style>
  .layout_sescommunityads_browse_menu{display:none !important;}
  </style>
 <?php } ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescommunityads/externals/styles/styles.css'); ?>
<div class="headline">
  <h2>
    <?php if(!empty($this->title)): ?>
      <?php echo $this->translate($this->title); ?>
    <?php else: ?>
      <?php echo $this->translate('Advertisements'); ?>
    <?php endif; ?>
  </h2>
  <?php if( count($this->navigation) > 0 ){ ?>
    <div class="tabs">
      <ul class="navigation">
	  <?php foreach( $this->navigation as $navigationMenu ){ ?>
	      <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
	      <?php if ($navigationMenu->action){ ?>
                <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array('action' => $navigationMenu->action), $navigationMenu->route, true) : $navigationMenu->uri ?>'><?php echo $this->translate($navigationMenu->label); ?></a>
              <?php }else{ ?>
                <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>'><?php echo $this->translate($navigationMenu->label); ?></a>
              <?php } ?>
	      </li>
	    <?php } ?>
      </ul>
    </div>
     <?php } ?>
</div>