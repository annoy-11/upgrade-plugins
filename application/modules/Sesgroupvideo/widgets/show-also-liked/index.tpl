<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupvideo
 * @package    Sesgroupvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroupvideo/externals/styles/styles.css'); ?>
<ul class="sesbasic_sidebar_block sesbasic_bxs sesbasic_clearfix sesgroupvideo_sidebar_video_list">
<?php include APPLICATION_PATH . '/application/modules/Sesgroupvideo/views/scripts/_showVideoListGrid.tpl'; ?>
</ul>
