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
<?php if (!empty($this->viewer_id)): ?>
  <?php

  $likeUser = Engine_Api::_()->sesbasic()->getLikeStatus($this->subject->epetition_id, 'epetition');
  $likeClass = (!$likeUser) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;
  $likeText = ($likeUser) ?  $this->translate('Unlike') : $this->translate('Like') ;
  ?>
  <div class="epetition_button">
   <a href="javascript:void(0);" data-url="<?php echo $this->subject->epetition_id ; ?>" class="sesbasic_animation sesbasic_link_btn epetition_like_epetition_view  epetition_like_epetition_petition_<?php echo $this->subject->epetition_id ?>"><i class="fa <?php echo $likeClass;?>"></i><span><?php echo $likeText;?></span></a>
  </div>
<?php endif; ?>
