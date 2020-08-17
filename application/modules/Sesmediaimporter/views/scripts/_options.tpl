<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _facebook.tpl 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

  
<div class="sesmdimp_app_view_right_options hidefb sesbasic_clearfix" style="display:none;">
	<div class="_text"><?php echo $this->translate("Select the Albums / Photos to be imported from this social network to your account."); ?></div>
  <div class="_btns">
    
    <a href="javascript:;" class="sesbasic_linkinherit sesmediaimp_refreshbtn"><i class="fa fa-refresh"></i><span><?php echo $this->translate("Refresh"); ?></span></a>
    <a href="javascript:;" class="sesbasic_linkinherit selectsesmediaimporter"><i class="fa fa-square-o"></i><span><?php echo $this->translate("Select All"); ?></span></a>
    <a href="javascript:;" class="sesbasic_linkinherit unselectsesmediaimporter" style="display:none;"><i class="fa fa-check-square-o"></i><span><?php echo $this->translate("Select All"); ?></span></a>
    <a href="javascript:;" class="sesmediaimporterimport sesbasic_link_btn sesmi_import_btn isdisable"><i class="fa fa-download"></i><span><?php echo $this->translate("Import Selected"); ?></span></a>
  </div>
</div>