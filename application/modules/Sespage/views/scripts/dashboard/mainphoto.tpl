<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: mainphoto.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(!$this->is_ajax) {
  echo $this->partial('dashboard/left-bar.tpl', 'sespage', array('page' => $this->page));	
?>
	<div class="sespage_dashboard_content sesbm sesbasic_clearfix">
<?php }  ?>
	<div class="sespage_dashboard_form">
    <div class="sespage_edit_photo_blog">
      <?php echo $this->form->render() ?> 
    </div> 
	</div>
<?php if(!$this->is_ajax) { ?>
	</div>
</div>
<?php } ?>