<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if (!empty($this->viewer_id) && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.favourite', 1)): ?>
  <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'epetition')->isFavourite(array('resource_type'=>'epetition','resource_id'=>$this->epetition->epetition_id)); ?>
  <div class="epetition_button">
    <a href="javascript:;" data-url="<?php echo $this->epetition->epetition_id ; ?>" class="sesbasic_animation sesbasic_link_btn  epetition_favourite_epetition_petition_<?php echo $this->epetition->epetition_id ?> epetition_favourite_epetition_view <?php echo ($favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php if($favStatus):?><?php echo $this->translate('Un-Favourite');?><?php else:?><?php echo $this->translate('Favorite');?><?php endif;?></span></a>
  </div>
<?php endif; ?>
