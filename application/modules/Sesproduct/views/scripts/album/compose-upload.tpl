<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: compose-upload.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script type="text/javascript">
  $try(function(){
    parent.en4.album.getComposer().processResponse(<?php echo $this->jsonInline($this->getVars()) ?>);
  });
  $try(function() {
    parent._composePhotoResponse = <?php echo $this->jsonInline($this->getVars()) ?>;
  });
</script>
