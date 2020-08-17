<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if($this->memberlink == 1 && $this->sesmemberEnable && $this->showinfotooltip == 1){ ?>
	<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/styles/styles.css'); ?>
<?php } ?>
<div class="sesytube_member_block_wrapper">
  <div class="sesytube_member_block sesbasic_clearfix sesbasic_bxs">
    <div class="sesytube_member_block_header">
      <?php if($this->heading) { ?>
        <h2><?php echo $this->translate($this->heading); ?></h2>
      <?php } ?>
      <?php if($this->caption) { ?>
        <p><?php echo $this->translate($this->caption); ?></p>
      <?php } ?>
    </div>
    <div class="sesytube_member_block_members clearfix">
      <ul>
        <?php foreach( $this->paginator as $user ): ?>
          <li>
            <article>
              <?php if($this->memberlink == 1){ ?>
              <a href="<?php echo $user->getHref(); ?>" <?php if($this->sesmemberEnable && $this->showinfotooltip == 1){ ?> class="ses_tooltip" <?php } ?> data-src="<?php echo $user->getGuid(); ?>">
              <?php } ?>
              <?php echo $this->itemPhoto($user, 'thumb.profile') ?>
              <?php if($this->memberlink == 1){ ?>
              </a>
              <?php } ?>
            </article>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>  
