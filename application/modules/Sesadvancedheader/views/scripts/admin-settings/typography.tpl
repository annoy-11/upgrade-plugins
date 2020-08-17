<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: typography.tpl  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesadvancedheader/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form exp_typography_setting'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script>
  window.addEvent('domready',function() {
    usegooglefont('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvancedheader.googlefonts', 0);?>');
  });
  
  function usegooglefont(value) {
  
    if(value == 1) {
    
//       $('exp_googlebody_fontfamily').value = 'Open Sans';
//       $('exp_googleheading_fontfamily').value = 'Open Sans';
//       if('exp_body-wrapper')
//         $('exp_body-wrapper').style.display = 'none';
      
//       if('exp_mainmenu-wrapper')
//         $('exp_mainmenu-wrapper').style.display = 'none';
      if($('sesadvheader_mainmenugrp'))
        $('sesadvheader_mainmenugrp').style.display = 'none';
//       if('exp_tab-wrapper')
//         $('exp_tab-wrapper').style.display = 'none';
      
        
      
      if($('sesadvheader_googlemainmenugrp'))
        $('sesadvheader_googlemainmenugrp').style.display = 'block';
      
    } else {

      if($('sesadvheader_mainmenugrp'))
        $('sesadvheader_mainmenugrp').style.display = 'block';

      if($('sesadvheader_googlemainmenugrp'))
        $('sesadvheader_googlemainmenugrp').style.display = 'none';
        
    }
  }
</script>
