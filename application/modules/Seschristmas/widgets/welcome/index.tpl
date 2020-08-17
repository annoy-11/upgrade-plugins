<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seschristmas
 * @package    Seschristmas
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2014-11-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<script src="<?php echo $this->baseUrl(); ?>/application/modules/Seschristmas/externals/scripts/snow.js" type="text/javascript"></script>
<script>  
createSnow('<?php echo $this->baseUrl() . "/application/modules/Seschristmas/externals/images/snow$this->snowimages.png" ?>', <?php echo $this->snowquantity ?>);
</script>