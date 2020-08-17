<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventvideo
 * @package    Seseventvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seseventvideo/externals/styles/styles.css'); ?>
<ul class="sesbasic_sidebar_block sesbasic_bxs sesbasic_clearfix seseventvideo_sidebar_video_list">
<?php include APPLICATION_PATH . '/application/modules/Seseventvideo/views/scripts/_showVideoListGrid.tpl'; ?>
</ul>