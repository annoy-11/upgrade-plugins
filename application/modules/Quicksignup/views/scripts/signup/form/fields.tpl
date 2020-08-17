<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Quicksignup
 * @package    Quicksignup
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: fields.tpl  2018-11-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<style>
      #signup_account_form #name-wrapper {
            display: none;
      }
</style>

<script type="text/javascript">
    //<![CDATA[
    window.addEvent('load', function() {
        if( $('username') && $('profile_address') ) {
            $('profile_address').innerHTML = $('profile_address')
                .innerHTML
                .replace('<?php echo /*$this->translate(*/'yourname'/*)*/?>',
                '<span id="profile_address_text"><?php echo $this->translate('yourname') ?></span>');

            $('username').addEvent('keyup', function() {
                var text = '<?php echo $this->translate('yourname') ?>';
                if( this.value != '' ) {
                    text = this.value;
                }

                $('profile_address_text').innerHTML = text.replace(/[^a-z0-9]/gi,'');
            });
            // trigger on page-load
            if( $('username').value.length ) {
                $('username').fireEvent('keyup');
            }
        }
    });
    //]]>
</script>
<?php
  /* Include the common user-end field switching javascript */
  echo $this->partial('_jsSwitch.tpl', 'fields', array(
      'topLevelId' => $this->form->getTopLevelId(),
      'topLevelValue' => $this->form->getTopLevelValue(),
));
?>
<?php echo $this->form->render($this) ?>
