<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="sesbasic_ext_breadcrumb sesbasic_bxs sesbasic_clearfix">
  <div class="_mainhumb"><a href="<?php echo $this->classroom->getHref(); ?>"><img src="<?php echo $this->classroom->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon" /></a></div>
  <div class="_maincont">
    <a href="<?php echo $this->classroom->getHref(); ?>"><?php echo $this->classroom->getTitle(); ?></a>
    <span class="sesbasic_text_light">&raquo;</span>
    <a href="<?php echo $this->album->getHref(); ?>"><?php echo $this->translate("Photo Albums"); ?></a>
    <span class="sesbasic_text_light">&raquo;</span>
    <?php echo $this->album->getTitle(); ?>
  </div>
</div>
