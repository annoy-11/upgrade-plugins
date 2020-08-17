<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage.tpl  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sestestimonial/externals/styles/style.css'); ?>
<script type="text/javascript">
  var pageAction =function(page){
    $('page').value = page;
    $('filter_form').submit();
  }
</script>
<?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
  <div class="sestestimonial_manage_listing sesbasic_clearfix sesbasic_bxs">
    <?php foreach($this->paginator as $item) { ?>
      <?php $user = Engine_Api::_()->getItem('user', $item->user_id); ?>
      <div class="sestestimonial_manage_list_item sesbasic_clearfix">
        <div class="testimonial_user_img">
          <a href="<?php echo $user->getHref(); ?>"><?php echo $this->itemPhoto($user, 'thumb.profile'); ?></a>
        </div>
        <div class="testimonial_user_body">
          <div class="testimonial_manage_header">
            <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.titleviewpage', 1)) { ?>
              <div class="testimonial_user_title">
                <a href="<?php echo $item->getHref(); ?>"><h4><?php echo $item->title; ?></h4></a>
              </div>
            <?php } ?>
            <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.rating', 1)) { ?>
              <div class="testimonial_user_rating">
                <?php for( $x=1; $x<=$item->rating; $x++ ): ?>
                  <span class="rating_star_generic rating_star"></span>
                <?php endfor; ?>
                <?php if( (round($item->rating) - $item->rating) > 0): ?>
                  <span class="rating_star_generic rating_star_half"></span>
                <?php endif; ?>
                <?php for( $x=5; $x>round($item->rating); $x-- ): ?>
                  <span class="rating_star_generic rating_star_empty"></span>
                <?php endfor; ?>
              </div>
            <?php } ?>
          </div>
          <div class="testimonial_manage_desc sesbasic_text_light">
            <?php echo nl2br($item->description); ?>
          </div>
         
          <div class="testimonial_list_footer">
            <div class="testimonial_footer_left">
              <span class="user_name">
                <a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a>
              </span>
               <?php if($item->designation && Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.designation', 1)) { ?>
                <span class="designation"><?php echo $item->designation; ?></span> 
              <?php } ?>  
            </div>
            <div class="testimonial_manage_buttons">
              <a href="<?php echo $this->url(array('action' => 'edit', 'testimonial_id' => $item->testimonial_id), 'sestestimonial_specific') ?>" class="testimonial_edit"><i class="fa fa-pencil"></i><?php echo $this->translate("Edit"); ?></a>
              <a href="<?php echo $this->url(array('action' => 'delete', 'testimonial_id' => $item->testimonial_id), 'sestestimonial_specific') ?>" class="smoothbox testimonial_delete"><i class="fa fa-trash"></i><?php echo $this->translate("Delete"); ?></a>
            </div>        
          </div>
        
        </div>
      </div>
    <?php } ?>
  </div>
<?php elseif($this->search): ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('You do not have any testimonial entries that match your search criteria.');?>
    </span>
  </div>
<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('You do not have any testimonial entries.');?>
      <?php if( $this->canCreate ): ?>
        <?php echo $this->translate('Get started by %1$swriting%2$s a new testimonial.', '<a href="'.$this->url(array('action' => 'create'), 'sestestimonial_general').'">', '</a>'); ?>
      <?php endif; ?>
    </span>
  </div>
<?php endif; ?>
<?php echo $this->paginationControl($this->paginator, null, null, array(
  'pageAsQuery' => true,
  'query' => $this->formValues,
  //'params' => $this->formValues,
)); ?>
<script type="text/javascript">
  $$('.core_main_sestestimonial').getParent().addClass('active');
</script>
