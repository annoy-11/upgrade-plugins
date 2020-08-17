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
<div class="sesbasic_breadcrumb">
	<a href="<?php echo $this->url(array('action' => 'home'), "seseventvideo_general"); ?>"><?php echo $this->translate("Videos Home"); ?></a>&nbsp;&raquo;
	<a href="<?php echo $this->event->getHref(); ?>"><?php echo $this->event->getTitle(); ?></a>&nbsp;&raquo;
	<?php echo $this->video->getTitle(); ?>
</div>
