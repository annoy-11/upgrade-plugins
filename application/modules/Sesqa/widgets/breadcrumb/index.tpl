<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesqa
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<div class="sesbasic_breadcrumb">
  <a href="<?php echo $this->url(array('action' => 'browse'), "sesqa_general"); ?>"><?php echo $this->translate("Browse Questions"); ?></a>&nbsp;&raquo;
 <?php if($this->questionview->getTitle()){ 
 		 echo $this->questionview->getTitle(); 
  }else{
  	echo $this->translate("Untitled");
    }
  ?>
</div>


