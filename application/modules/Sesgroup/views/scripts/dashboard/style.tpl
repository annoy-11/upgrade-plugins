<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: style.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sesgroup', array(
	'group' => $this->group,
      ));	
?>
	<div class="sesgroup_dashboard_content sesbm sesbasic_clearfix">
<?php } 	
?>
<div class="sesgroup_dashboard_form sesgroup_edit_style_group sesgroup_create_form">
	<?php echo $this->form->render() ?>
</div>
<?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>