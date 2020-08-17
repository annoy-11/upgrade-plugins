<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesuserdocverification
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesbasic_bxs">
	<?php if(count($this->verifieddocuments) > 0) { ?>
		<div class="sesuserdocverification_verify_label <?php if($this->distip) { ?> sesbasic_verify_tip <?php } ?>">
    	<i>	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve" class=""><g><g><g id="check-circle-outline"><path d="M150.45,206.55l-35.7,35.7L229.5,357l255-255l-35.7-35.7L229.5,285.6L150.45,206.55z M459,255c0,112.2-91.8,204-204,204    S51,367.2,51,255S142.8,51,255,51c20.4,0,38.25,2.55,56.1,7.65l40.801-40.8C321.3,7.65,288.15,0,255,0C114.75,0,0,114.75,0,255    s114.75,255,255,255s255-114.75,255-255H459z" data-original="#000000" class="active-path" data-old_color="#ffffff" fill="#ffffff"/></g></g></g> </svg></i>
			<span><?php echo $this->translate("Verified"); ?></span>
			<?php include APPLICATION_PATH .  '/application/modules/Sesbasic/views/scripts/_verification_info.tpl'; ?>
		</div>
  <?php } ?>
</div>
