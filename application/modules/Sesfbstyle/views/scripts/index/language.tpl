<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbstyle
 * @package    Sesfbstyle
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesfbstyle_language_chooser_popup">
	<h3><?php echo $this->translate("Select Your Language");?></h3>
  <div class="_cont">
    <?php $selectedLanguage = $this->translate()->getLocale() ?>
    	<div><a href="javascript:;" class="disabled" ><?php echo $this->languageNameList[$selectedLanguage]; ?></a></div>   
    <?php 
      foreach($this->languageNameList as $key=>$value){
      if($selectedLanguage == $key)
      continue; 
    ?>
    	<div><a href="javascript:;" class="lan_selected_<?php echo $this->identity; ?><?php if($key == $selectedLanguage){ ?> disabled<?php } ?>" data-rel="<?php echo $key; ?>" ><?php echo $value; ?></a></div>
    <?php } ?> 
	</div>
</div>    