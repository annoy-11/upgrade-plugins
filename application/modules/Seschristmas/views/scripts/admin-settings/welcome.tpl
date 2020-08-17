<?php

/**
* SocialEngineSolutions
*
* @category   Application_Seschristmas
* @package    Seschristmas
* @copyright  Copyright 2014-2015 SocialEngineSolutions
* @license    http://www.socialenginesolutions.com/license/
* @version    $Id: welcome.tpl 2014-11-15 00:00:00 SocialEngineSolutions $
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

<script>

  en4.core.runonce.add(function() {
    showwelcome("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.welcome', 1)  ?>");
  });

  function showwelcome(value) {
    if (value == 0) {
      if ($('seschristmas_welcomepageshow-wrapper'))
        $('seschristmas_welcomepageshow-wrapper').style.display = 'none';
      if ($('seschristmas_welcomecountdown-wrapper'))
        $('seschristmas_welcomecountdown-wrapper').style.display = 'none';
      if ($('seschristmas_urlmanifest-wrapper'))
        $('seschristmas_urlmanifest-wrapper').style.display = 'none';
      if ($('seschristmas_pagename-wrapper'))
        $('seschristmas_pagename-wrapper').style.display = 'none';

    } else {
      if ($('seschristmas_welcomepageshow-wrapper'))
        $('seschristmas_welcomepageshow-wrapper').style.display = 'block';
      if ($('seschristmas_welcomecountdown-wrapper'))
        $('seschristmas_welcomecountdown-wrapper').style.display = 'block';
      if ($('seschristmas_urlmanifest-wrapper'))
        $('seschristmas_urlmanifest-wrapper').style.display = 'block';
      if ($('seschristmas_pagename-wrapper'))
        $('seschristmas_pagename-wrapper').style.display = 'block';
    }
  }
</script>
<style type="text/css">
  #remove{
    margin-left:190px;
  }
</style>