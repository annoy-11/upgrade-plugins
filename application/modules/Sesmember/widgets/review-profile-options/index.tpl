<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<div id='profile_options' <?php if ($this->viewType == 'horizontal'): ?> class="sesmember_profile_options_horrizontal"<?php endif; ?> >
  <?php echo $this->navigation()->menu()->setContainer($this->navigation)->setPartial(array('_navIcons.tpl', 'core'))->render(); ?>
</div>

