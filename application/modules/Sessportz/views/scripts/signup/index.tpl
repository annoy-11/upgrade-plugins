<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php echo $this->partial($this->script[0], $this->script[1], array(
  'form' => $this->form
)) ?>
<script type="text/javascript">
    
  window.addEvent('domready', function() {
    if( $("user_signup_form") ) $("user_signup_form").getElements(".form-errors").destroy();
  });
  
  function skipForm() {
    document.getElementById("skip").value = "skipForm";
    $('SignupForm').submit();
  }
  function finishForm() {
    document.getElementById("nextStep").value = "finish";
  }

</script>

