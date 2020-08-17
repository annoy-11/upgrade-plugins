<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestutorial
 * @package    Sestutorial
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<script type="text/javascript">
function dismiss(coockiesValue) {
  var d = new Date();
  d.setTime(d.getTime()+(365*24*60*60*1000));
  var expires = "expires="+d.toGMTString();
  document.cookie = coockiesValue + "=" + 1 + "; " + expires;
	$(coockiesValue).style.display = 'none';
}
</script>
<?php if( !isset($_COOKIE["dismiss_developer"])): ?>
  <div id="dismiss_developer" class="tip">
    <span>
      <?php echo "Can you rate our developer profile on <a href='https://www.socialengine.com/experts/profile/socialenginesolutions' target='_blank'>socialengine.com</a> to support us? <a href='https://www.socialengine.com/experts/profile/socialenginesolutions' target='_blank'>Yes</a> or <a href='javascript:void(0);' onclick='dismiss(\"dismiss_developer\")'>No, not now</a>.";
    ?>
    </span>
  </div>
<?php endif; ?>
<h2><?php echo $this->translate("Multi - Use Tutorials Plugin") ?></h2>
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
<style type="text/css">
.ses_tip_red > span {
	background-color:red;
	color: white;
}
.sestutorial_nav_btns{
	float:right;
	margin-top:-40px;
}
.sestutorial_nav_btns a{
	background-color:#f36a33;
	color:#fff;
	float:left;
	font-weight:bold;
	padding:8px 15px;
	margin-left:10px;
}
.sestutorial_nav_btns a:hover{
	text-decoration:none;
}
</style>
