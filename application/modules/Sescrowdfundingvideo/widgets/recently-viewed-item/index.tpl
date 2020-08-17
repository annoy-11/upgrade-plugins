<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingvideo
 * @package    Sescrowdfundingvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescrowdfundingvideo/externals/styles/styles.css'); ?>
<ul class="sesbasic_sidebar_block sesbasic_bxs sesbasic_clearfix sescrowdfundingvideo_sidebar_video_list">
<?php include APPLICATION_PATH . '/application/modules/Sescrowdfundingvideo/views/scripts/_showVideoListGrid.tpl'; ?>
</ul>
