<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if (!empty($this->viewer_id)): ?>
  <div class="edocument_button"><a href="javascript:;" data-url="<?php echo $this->subject_id ; ?>" class="sesbasic_animation sesbasic_link_btn edocument_like_edocument_view  edocument_like_edocument_<?php echo $this->subject_id ?>"><i class="fa <?php echo $this->likeClass;?>"></i><span><?php echo $this->likeText;?></span></a></div>
<?php endif; ?>
