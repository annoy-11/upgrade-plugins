<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="eblog_button">
  <a href="javascript:;" data-url="<?php echo $this->subject_id ; ?>" class="sesbasic_animation eblog_favourite_eblog_blog_<?php echo $this->subject_id ?> eblog_favourite_eblog_blog_view <?php echo ($this->favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php if($this->favStatus):?><?php echo $this->translate('Un-Favourite');?><?php else:?><?php echo $this->translate('Favourite');?><?php endif;?></span></a>
</div>
