<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2018-10-31 00:00:00 SocialEngineSolutions $
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
<?php if (($this->current_count >= $this->quota) && !empty($this->quota)):?>
  <div class="tip">
    <span>
      <?php echo $this->translate('You have already posted the maximum number of entries.');?>
    </span>
  </div>
  <br/>
<?php else:?>
  <?php echo $this->form->render($this);?>
<?php endif; ?>
<script type="text/javascript">
  $$('.core_main_sestestimonial').getParent().addClass('active');
</script>
