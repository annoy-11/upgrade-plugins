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
  <a href="javascript:;" data-url="<?php echo $this->subject_id ; ?>" class="sesbasic_animation eblog_like_eblog_blog_view  eblog_like_eblog_blog_<?php echo $this->subject_id ?>"><i class="fa <?php echo $this->likeClass;?>"></i><span><?php echo $this->likeText; ?></span></a>
</div>
