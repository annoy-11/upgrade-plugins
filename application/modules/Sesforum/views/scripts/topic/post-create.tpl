<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: post-create.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesforum/externals/styles/styles.css'); ?>

<script type="text/javascript">
function showUploader()
{
  $('photo').style.display = 'block';
  $('photo-label').style.display = 'none';
}
</script>
<div class="layout_middle">
  <div class="generic_layout_container layout_core_content">
    <div class="sesforum_page_title">
    <h2>
      <?php echo $this->translate('Post Reply');?>
    </h2>
    </div>
    <div class="sesforum_crete_form">
      <?php echo $this->form->render($this) ?>
    </div>
	</div>
</div>
<script type="text/javascript">
  $$('.core_main_sesforum').getParent().addClass('active');
</script>
