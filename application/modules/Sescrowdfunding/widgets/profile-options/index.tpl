<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesbasic_sidebar_block sescf_profile_sidebar_options<?php if ($this->viewType == 'horizontal'): ?> sescf_profile_options_horizontal<?php endif; ?>">
  <?php echo $this->navigation()->menu()->setContainer($this->navigation)->setPartial(array('_navIcons.tpl', 'core'))->render(); ?>
</div>