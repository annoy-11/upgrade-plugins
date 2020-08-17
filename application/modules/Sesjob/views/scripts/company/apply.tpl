<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: apply.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headScript()->appendFile('https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=' . Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.mapApiKey', '')); ?>
<div class="sesjob_job_form">
  <?php echo $this->form->render(); ?>
</div>
<script type="text/javascript">
  en4.core.runonce.add(function()
  {
      if (document.getElementById('location')) {
        new google.maps.places.Autocomplete(document.getElementById('location'));
      }
  });
</script>
