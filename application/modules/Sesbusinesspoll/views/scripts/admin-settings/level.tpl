<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspoll
 * @package    Sesbusinesspoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: level.tpl  2018-10-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/dismiss_message.tpl';?>

<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <?php if( count($this->navigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php
          echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();
        ?>
      </div>
    <?php endif; ?>
    <div class='clear'>
      <div class='settings'>
        <?php echo $this->form->render($this); ?>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
//<![CDATA[
$('level_id').addEvent('change', function(){
  window.location.href = en4.core.baseUrl + 'admin/sesbusinesspoll/settings/level/id/'+this.get('value');
});
//]]>
</script>