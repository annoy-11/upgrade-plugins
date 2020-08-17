<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seshtmlbackground
 * @package    Seshtmlbackground
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-10-22 00:00:00 SocialEngineSolutions $
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
<?php echo $this->form->setAttrib('id','seshtmlbackground_form')->setAttrib('class', 'global_form_box signupseshtmlbtn_'.$this->idI)->render($this) ?>

<?php if($this->isLogin){ ?>
<script type="application/javascript">
sesJqueryObject('.signupseshtmlbtn_<?php echo $this->idI; ?>').hide();
</script>
<?php } ?>