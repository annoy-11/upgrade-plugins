<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppoll
 * @package    Sesgrouppoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesgrouppoll/views/scripts/dismiss_message.tpl';?>

<div class='sesbasic-form sesbasic-categories-form'>
  <div>
<?php if( count($this->navigation) ): ?>
  <div class='sesbasic-admin-sub-tabs'>
    <?php
       echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();
    ?>
  </div>
<?php endif; ?>
    <div class='clear sesbasic-form-cont'>
    <div class='settings'>
      <?php echo $this->form->render($this); ?>
    </div>
<div class="sesbasic_waiting_msg_box" style="display:none;">
        <div class="sesbasic_waiting_msg_box_cont">
          <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
          <i></i>
  </div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgrouppoll.pluginactivated',0)){ ?>
    sesJqueryObject('.global_form').submit(function(e){
      sesJqueryObject('.sesbasic_waiting_msg_box').show();
    });
  <?php } ?>
</script>