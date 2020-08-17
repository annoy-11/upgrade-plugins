<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: field-create.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>
  
	function toggle_field(id, id2) {
        var state = document.getElementById(id).style.display;
            if (state == 'block') {
                document.getElementById(id).style.display = 'none';
				document.getElementById(id2).style.display = 'block';
				document.getElementById("map-field-button").setAttribute("class", "admin_button_disabled");
				document.getElementById("create-field-button").setAttribute("class", "");
            } else {
                document.getElementById(id).style.display = 'block';
				document.getElementById(id2).style.display = 'none';
				document.getElementById("create-field-button").setAttribute("class", "admin_button_disabled");
				document.getElementById("map-field-button").setAttribute("class", "");
            }
        }
  
</script>
<?php if( $this->form ): ?>

  <?php
  if (APPLICATION_ENV == 'production')
    $this->headScript()
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.min.js');
  else
    $this->headScript()
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Observer.js');
  ?>
  <div id="create-field">
    <?php echo $this->form->render($this) ?>
  </div>
<?php else: ?>
  <div class="global_form_popup_message">
    <?php echo $this->translate("Your changes have been saved.") ?>
  </div>

  <script type="text/javascript">
    parent.onFieldCreate(
      <?php echo Zend_Json::encode($this->field) ?>,
      <?php echo Zend_Json::encode($this->htmlArr) ?>
    );
    (function() { parent.Smoothbox.close(); }).delay(1000);
  </script>

<?php endif; ?>