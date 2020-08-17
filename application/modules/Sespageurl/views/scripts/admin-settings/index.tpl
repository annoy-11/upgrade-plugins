<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageurl
 * @package    Sespageurl
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sespageurl/views/scripts/dismiss_message.tpl';?>
<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <?php if( count($this->navigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render(); ?>
      </div>
    <?php endif; ?>
    <div class='clear sesbasic-form-cont'>
      <div class='settings'>
        <?php echo $this->form->render($this); ?>
      </div>
    </div>
  </div>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<script type='text/javascript'>
  sesJqueryObject(document).on('change','input[type=radio][name=sespage_enable_shorturl]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sespage_shorturl_onlike-wrapper').show();
      sesJqueryObject('input[type=radio][name=sespage_shorturl_onlike]:checked').trigger('change');
    }else{
      sesJqueryObject('#sespage_shorturl_onlike-wrapper').hide();
      sesJqueryObject('#sespage_countlike-wrapper').hide();
    }
  });
  sesJqueryObject(document).on('change','input[type=radio][name=sespage_shorturl_onlike]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sespage_countlike-wrapper').show();
    }else{
      sesJqueryObject('#sespage_countlike-wrapper').hide();
    }
  });
  window.addEvent('domready', function() {
    var valueStyle = sesJqueryObject('input[type=radio][name=sespage_enable_shorturl]:checked').val();
    if(valueStyle == 1) {
      sesJqueryObject('#sespage_shorturl_onlike-wrapper').show();
      sesJqueryObject('input[type=radio][name=sespage_shorturl_onlike]:checked').trigger('change');
    }
    else {
      sesJqueryObject('#sespage_shorturl_onlike-wrapper').hide();
      sesJqueryObject('#sespage_countlike-wrapper').hide();
    }
  });
</script>