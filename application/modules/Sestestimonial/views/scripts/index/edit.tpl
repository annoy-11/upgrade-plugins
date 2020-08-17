<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script type="application/javascript">
window.addEvent('load', function(){
	tinymce.execCommand('mceRemoveEditor',true, 'description');
	var desVal = document.getElementById('description').value;
	document.getElementById('description').value = desVal.match(/[^<p>].*[^</p>]/g)[0];
});
</script>
<div class="headline">
  <h2>
    <?php echo $this->translate('Testimonials');?>
  </h2>
  <div class="tabs">
    <?php
      // Render the menu
      echo $this->navigation()
        ->menu()
        ->setContainer($this->navigation)
        ->render();
    ?>
  </div>
</div>
<?php echo $this->form->render($this) ?>
<script type="text/javascript">
  $$('.core_main_sestestimonial').getParent().addClass('active');
</script>
