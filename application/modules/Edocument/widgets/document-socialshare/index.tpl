<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if($this->design_type == 1):?>
  <div class="edocument_social_share_document1 sesbasic_bxs">
    <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->edocument)); ?>
  </div>
<?php elseif($this->design_type == 2):?>
	<div class="edocument_social_share_document2 sesbasic_bxs">
		<i><b><?php echo $this->translate('Share it').' :-';?></b></i>
		<?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->edocument)); ?>
	</div>
<?php elseif($this->design_type == 3):?>
	<div class="edocument_social_share_document3 sesbasic_bxs">
		<ul>
      <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->edocument, 'param' => 'photoviewpage')); ?>
		</ul>
	</div>
<?php elseif($this->design_type == 4):?>
  <div class="edocument_social_share_document4 sesbasic_bxs">
    <ul>
      <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->edocument, 'param' => 'photoviewpage')); ?>
    </ul>
  </div>
<?php endif;?>
