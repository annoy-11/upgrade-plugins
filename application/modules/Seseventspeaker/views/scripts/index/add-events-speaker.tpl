<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: add-events-speaker.tpl 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php $this->headScript()->appendFile("https://maps.googleapis.com/maps/api/js?libraries=places&sensor=true"); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?>
<div class='sesbasic_form_popup'>
  <?php echo $this->form->render($this) ?>
</div>
<script type="text/javascript">
  en4.core.runonce.add(function() {
    if (document.getElementById('location')) {
      new google.maps.places.Autocomplete(document.getElementById('location'));
    }
  });
</script>