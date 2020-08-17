<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php if($this->design_type == 1):?>
<div class="seslisting_social_share_listing1 sesbasic_bxs">
  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->seslisting)); ?>

</div>
<?php elseif($this->design_type == 2):?>
	<div class="seslisting_social_share_listing2 sesbasic_bxs">
		<i><b><?php echo $this->translate('Share it').' :-';?></b></i>
		<?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->seslisting)); ?>
	</div>

<?php elseif($this->design_type == 3):?>
	<div class="seslisting_social_share_listing3 sesbasic_bxs">
		<ul>
      <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->seslisting, 'param' => 'photoviewpage')); ?>
		</ul>
	</div>

<?php elseif($this->design_type == 4):?>
  <div class="seslisting_social_share_listing4 sesbasic_bxs">
    <ul>
      <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->seslisting, 'param' => 'photoviewpage')); ?>
    </ul>
  </div>
<?php endif;?>
