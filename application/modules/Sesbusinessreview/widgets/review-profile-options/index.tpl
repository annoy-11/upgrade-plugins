<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div id='profile_options' <?php if ($this->viewType == 'horizontal'): ?> class="sesbusinessreview_profile_options_horrizontal"<?php endif; ?> >
  <?php echo $this->navigation()->menu()->setContainer($this->navigation)->setPartial(array('_navIcons.tpl', 'core'))->render(); ?>
</div>

