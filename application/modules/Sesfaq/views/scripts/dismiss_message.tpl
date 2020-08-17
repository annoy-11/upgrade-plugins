<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<h2><?php echo $this->translate("Multi - Use FAQs Plugin") ?></h2>
<?php 
$sesfaq_adminmenu = Zend_Registry::isRegistered('sesfaq_adminmenu') ? Zend_Registry::get('sesfaq_adminmenu') : null;
if(!empty($sesfaq_adminmenu)) { ?>
<?php if(count($this->navigation) ): ?>
  <div class='sesbasic-admin-navgation'>
		<ul>
		  <?php foreach( $this->navigation as $navigationMenu ): ?>
		    <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
		      <?php echo $this->htmlLink($navigationMenu->getHref(), $this->translate($navigationMenu->getLabel()), array('class' => $navigationMenu->getClass())); ?>
		    </li>
		  <?php endforeach; ?>
		</ul>
  </div>
<?php endif; ?>
<?php } ?>
<style type="text/css">
.ses_tip_red > span {
	background-color:red;
	color: white;
}
.sesfaq_nav_btns{
	float:right;
	margin-top:-40px;
}
.sesfaq_nav_btns a{
	background-color:#f36a33;
	color:#fff;
	float:left;
	font-weight:bold;
	padding:8px 15px;
	margin-left:10px;
}
.sesfaq_nav_btns a:hover{
	text-decoration:none;
}
</style>
