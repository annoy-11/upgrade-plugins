<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php if($this->design_type == 1):?>
<div class="sesarticle_social_share_article1 sesbasic_bxs">
  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesarticle)); ?>

</div>
<?php elseif($this->design_type == 2):?>
	<div class="sesarticle_social_share_article2 sesbasic_bxs">
		<i><b><?php echo $this->translate('Share it').' :-';?></b></i>
		<?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesarticle)); ?>
	</div>

<?php elseif($this->design_type == 3):?>
	<div class="sesarticle_social_share_article3 sesbasic_bxs">
		<ul>
      <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesarticle, 'param' => 'photoviewpage')); ?>
		</ul>
	</div>

<?php elseif($this->design_type == 4):?>
  <div class="sesarticle_social_share_article4 sesbasic_bxs">
    <ul>
      <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesarticle, 'param' => 'photoviewpage')); ?>
    </ul>
  </div>
<?php endif;?>