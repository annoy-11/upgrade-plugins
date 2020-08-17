<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: post-create.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroupforum/externals/styles/styles.css'); ?>
<div class="layout_middle">
  <div class="sesbasic_ext_breadcrumb sesbasic_bxs sesbasic_clearfix">
    <div class="_mainhumb"><a href="<?php echo $this->group->getHref(); ?>"><img src="<?php echo $this->group->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon" /></a></div>
    <div class="_maincont">
      <a href="<?php echo $this->group->getHref(); ?>"><?php echo $this->group->getTitle(); ?></a>
      <span class="sesbasic_text_light">&raquo;</span>
      <a href="<?php echo $this->topic->getHref(); ?>"><?php echo $this->topic->getTitle(); ?></a>
      <span class="sesbasic_text_light">&raquo;</span>
      <span><?php echo $this->translate("Create Topic"); ?></span>
    </div>
  </div>
</div>
<script type="text/javascript">
  function showUploader() {
    $('photo').style.display = 'block';
    $('photo-label').style.display = 'none';
  }
</script>

<div class="layout_middle">
  <div class="generic_layout_container layout_core_content">
    <div class="sesgroupforum_page_title">
    <h2>
      <?php echo $this->translate('Post Reply');?>
    </h2>
    </div>
    <div class="sesgroupforum_crete_form">
      <?php echo $this->form->render($this) ?>
    </div>
	</div>
</div>
<script type="text/javascript">
  $$('.core_main_sesgroupforum').getParent().addClass('active');
</script>
