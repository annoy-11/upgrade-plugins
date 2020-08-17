<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-category.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic-form'>
  <div>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render(); ?>
      </div>
    <?php endif; ?>
     <?php if( count($this->subsubNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs sesbasic-admin-sub-inner-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subsubNavigation)->render();?>
      </div>
    <?php endif; ?>
    <div class="sesbasic-form-cont">
     <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesrecipe', 'controller' => 'review-categories', 'action' => 'index'), $this->translate("Back to Manage Categories"), array('class'=>'sesbasic_icon_back buttonlink')) ?>
      <br /><br />
      <div class='settings sesbasic_admin_form'>
        <?php echo $this->form->render($this); ?>
      </div>
    </div>
  </div>
</div>