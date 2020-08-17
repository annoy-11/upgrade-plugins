<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslandingpage
 * @package    Seslandingpage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Seslandingpage/views/scripts/dismiss_message.tpl';?>
<div class="sesbasic_search_reasult">
	<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seslandingpage', 'controller' => 'manage', 'action' => 'index'), $this->translate("Back to Manage Feature Blocks") , array('class'=>'sesbasic_icon_back buttonlink')); ?>
</div>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<?php $contents = $this->contents; ?>
<script>
	
	window.addEvent('domready',function() {
		showIcon('<?php echo $contents['icon_type1'] ?>', 1);
		showIcon('<?php echo $contents['icon_type2'] ?>', 2);
		showIcon('<?php echo $contents['icon_type3'] ?>', 3);
		showIcon('<?php echo $contents['icon_type4'] ?>', 4);

	});
	
	function showIcon(value, param){
		
		if(value == 1) {
			$('fonticon'+param+'-wrapper').style.display = 'block';
			$('photo'+param+'-wrapper').style.display = 'none';
		} else {
			$('photo'+param+'-wrapper').style.display = 'block';
			$('fonticon'+param+'-wrapper').style.display = 'none';
		}
	}
</script>
