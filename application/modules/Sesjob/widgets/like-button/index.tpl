<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if (!empty($this->viewer_id)): ?>
  <?php      
  $likeUser = Engine_Api::_()->sesbasic()->getLikeStatus($this->subject->job_id, 'sesjob_job');
  $likeClass = (!$likeUser) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;
  $likeText = ($likeUser) ?  $this->translate('Unlike') : $this->translate('Like') ;
  ?>
  <div class="sesjob_button">
    <a href="javascript:;" data-url="<?php echo $this->subject->job_id ; ?>" class="sesbasic_animation sesbasic_link_btn sesjob_like_sesjob_job_view  sesjob_like_sesjob_job_<?php echo $this->subject->job_id ?>"><i class="fa <?php echo $likeClass;?>"></i><span><?php echo $likeText;?></span></a>
  </div>
<?php endif; ?>
