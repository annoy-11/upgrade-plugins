<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if($this->design_type == 1):?>
<div class="sesjob_social_share_job1 sesbasic_bxs">
  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesjob)); ?>

</div>
<?php elseif($this->design_type == 2):?>
	<div class="sesjob_social_share_job2 sesbasic_bxs">
		<i><b><?php echo $this->translate('Share it').' :-';?></b></i>
		<?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesjob)); ?>
	</div>

<?php elseif($this->design_type == 3):?>
	<div class="sesjob_social_share_job3 sesbasic_bxs">
		<ul>
      <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesjob, 'param' => 'photoviewpage')); ?>
		</ul>
	</div>

<?php elseif($this->design_type == 4):?>
  <div class="sesjob_social_share_job4 sesbasic_bxs">
    <ul>
      <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesjob, 'param' => 'photoviewpage')); ?>
    </ul>
  </div>
<?php endif;?>
