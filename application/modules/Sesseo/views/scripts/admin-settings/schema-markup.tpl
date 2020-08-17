<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: schema-markup.tpl  2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesseo/views/scripts/dismiss_message.tpl';?>

<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

  window.addEvent('domready', function() {
    hideside("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesseo_schema_type', 1); ?>");
  });

  function hideside(value) {

    if(value == 1) {
      $('sesseo_sitetitle-wrapper').style.display = 'block';
      $('sesseo_alternatetitle-wrapper').style.display = 'block';
      $('sesseo_facebook-wrapper').style.display = 'block';
      $('sesseo_twitter-wrapper').style.display = 'block';
      $('sesseo_linkdin-wrapper').style.display = 'block';
      $('sesseo_googleplus-wrapper').style.display = 'block';
      $('sesseo_instagram-wrapper').style.display = 'block';
      $('sesseo_youtube-wrapper').style.display = 'block';
      $('sesseo_othermediaurl-wrapper').style.display = 'block';
      $('sesseo_customschema-wrapper').style.display = 'none';
    } else if(value == 2) {

    } else if(value == 3) {
      $('sesseo_customschema-wrapper').style.display = 'block';
      $('sesseo_sitetitle-wrapper').style.display = 'none';
      $('sesseo_alternatetitle-wrapper').style.display = 'none';
      $('sesseo_facebook-wrapper').style.display = 'none';
      $('sesseo_twitter-wrapper').style.display = 'none';
      $('sesseo_linkdin-wrapper').style.display = 'none';
      $('sesseo_googleplus-wrapper').style.display = 'none';
      $('sesseo_instagram-wrapper').style.display = 'none';
      $('sesseo_youtube-wrapper').style.display = 'none';
      $('sesseo_othermediaurl-wrapper').style.display = 'none';
    }
  }
</script>
