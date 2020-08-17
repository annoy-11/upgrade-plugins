<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php if($this->design_type == 1):?>
<div class="sesrecipe_social_share_recipe1 sesbasic_bxs">
  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesrecipe)); ?>

</div>
<?php elseif($this->design_type == 2):?>
	<div class="sesrecipe_social_share_recipe2 sesbasic_bxs">
		<i><b><?php echo $this->translate('Share it').' :-';?></b></i>
		<?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesrecipe)); ?>
	</div>

<?php elseif($this->design_type == 3):?>
	<div class="sesrecipe_social_share_recipe3 sesbasic_bxs">
		<ul>
      <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesrecipe, 'param' => 'photoviewpage')); ?>
		</ul>
	</div>

<?php elseif($this->design_type == 4):?>
  <div class="sesrecipe_social_share_recipe4 sesbasic_bxs">
    <ul>
      <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesrecipe, 'param' => 'photoviewpage')); ?>
    </ul>
  </div>
<?php endif;?>