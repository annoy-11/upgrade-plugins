<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: addheading.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php echo $this->form->setAttrib('class', 'global_form_popup')->render($this) ?>
<script>
  window.addEvent('domready',function() {
    showIcon('<?php echo $this->icon_type;?>');
  });

function showIcon(value) {
  if(value == 0) {
    $('font_icon-wrapper').style.display = 'none';
    $('photo-wrapper').style.display = 'block';
  } else if(value == 1) {
    $('font_icon-wrapper').style.display = 'block';
    $('photo-wrapper').style.display = 'none';
  }
}
</script>
