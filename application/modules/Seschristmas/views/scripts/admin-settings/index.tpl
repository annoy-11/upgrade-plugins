<?php

/**
* SocialEngineSolutions
*
* @category   Application_Seschristmas
* @package    Seschristmas
* @copyright  Copyright 2014-2015 SocialEngineSolutions
* @license    http://www.socialenginesolutions.com/license/
* @version    $Id: index.tpl 2014-11-15 00:00:00 SocialEngineSolutions $
* @author     SocialEngineSolutions
*/
?>

<h2><?php echo $this->translate("SESCHRISTMAS_PLUGIN") ?></h2>

<?php if( count($this->navigation) ): ?>
<div class='tabs'>
  <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
</div>
<?php endif; ?>

<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.pluginactivated',0)){ 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>
<script>

  en4.core.runonce.add(function() {
    choosetemplate("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.template', 1)  ?>");
    showeffect("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.snoweffect', 1)  ?>");
    showwish("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.wish', 1)  ?>");
  });


  function showwish(value) {
    if (value == 0) {
      if ($('seschristmas_wisheslimit-wrapper'))
        $('seschristmas_wisheslimit-wrapper').style.display = 'none';
      if ($('seschristmas_showviewmore-wrapper'))
        $('seschristmas_showviewmore-wrapper').style.display = 'none';

    } else {
      if ($('seschristmas_wisheslimit-wrapper'))
        $('seschristmas_wisheslimit-wrapper').style.display = 'block';
      if ($('seschristmas_showviewmore-wrapper'))
        $('seschristmas_showviewmore-wrapper').style.display = 'block';
    }
  }


  function showeffect(value) {
    if (value == 0) {
      if ($('seschristmas_snowimages-wrapper'))
        $('seschristmas_snowimages-wrapper').style.display = 'none';
      if ($('seschristmas_snowquantity-wrapper'))
        $('seschristmas_snowquantity-wrapper').style.display = 'none';

    } else {
      if ($('seschristmas_snowimages-wrapper'))
        $('seschristmas_snowimages-wrapper').style.display = 'block';
      if ($('seschristmas_snowquantity-wrapper'))
        $('seschristmas_snowquantity-wrapper').style.display = 'block';
    }
  }


  function choosetemplate(value) {
    if (value == 0) {
      if ($('seschristmas_template1-wrapper'))
        $('seschristmas_template1-wrapper').style.display = 'none';
      if ($('seschristmas_template2-wrapper'))
        $('seschristmas_template2-wrapper').style.display = 'block';
    } else if (value == 1) {
      if ($('seschristmas_template1-wrapper'))
        $('seschristmas_template1-wrapper').style.display = 'block';
      if ($('seschristmas_template2-wrapper'))
        $('seschristmas_template2-wrapper').style.display = 'none';
    } else if (value == 2) {
      if ($('seschristmas_template1-wrapper'))
        $('seschristmas_template1-wrapper').style.display = 'none';
      if ($('seschristmas_template2-wrapper'))
        $('seschristmas_template2-wrapper').style.display = 'none';
    }
  }
</script>
<style type="text/css">
  #remove{
    margin-left:190px;
  }
</style>