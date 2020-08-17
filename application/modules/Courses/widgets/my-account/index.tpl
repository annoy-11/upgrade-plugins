<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<div class="courses_myaccount_sidebar">
	<ul class="courses_myaccount_list">
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
