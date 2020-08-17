<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if (!empty($this->viewer_id)): ?>
  <?php      
  $likeUser = Engine_Api::_()->sesbasic()->getLikeStatus($this->subject->recipe_id, 'sesrecipe_recipe');
  $likeClass = (!$likeUser) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;
  $likeText = ($likeUser) ?  $this->translate('Unlike') : $this->translate('Like') ;
  ?>
  <div class="sesrecipe_button">
    <a href="javascript:;" data-url="<?php echo $this->subject->recipe_id ; ?>" class="sesbasic_animation sesbasic_link_btn sesrecipe_like_sesrecipe_recipe_view  sesrecipe_like_sesrecipe_recipe_<?php echo $this->subject->recipe_id ?>"><i class="fa <?php echo $likeClass;?>"></i><span><?php echo $likeText;?></span></a>
  </div>
<?php endif; ?>
