<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: compose-upload.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
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