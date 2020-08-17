<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagepoll
 * @package    Sespagepoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage.tpl  2018-10-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php 
    $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagepoll/externals/styles/styles.css');
  ?>
<script type="text/javascript">
  var searchPolls = function() {
    $('filter_form').submit();
  }
</script>
  <?php if( 0 == count($this->paginator) ): ?>
    <div class="tip">
      <span>
        <?php echo $this->translate('There are no polls yet.') ?>
        <?php if( $this->canCreate): ?>
          <?php echo $this->translate('Why don\'t you %1$screate one%2$s?',
            '<a href="'.$this->url(array('action' => 'create'), 'sespagepoll_general').'">', '</a>') ?>
        <?php endif; ?>
      </span>
    </div>

  <?php else: // $this->polls is NOT empty ?>
  
    <ul class="sespagepoll_poll_listing">
      <?php foreach( $this->paginator as $poll ): ?>
      <li id="Sespagepoll-item-<?php echo $poll->poll_id ?>">
        <?php echo $this->htmlLink($poll->getHref(), $this->itemPhoto($this->owner, 'thumb.icon'), array('class' => 'sespagepolls_browse_photo')) ?>
        
        <div class="sespagepolls_browse_options">
         <a href="javascript:;" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a>
           <div class="sesbasic_pulldown_options">
          <?php if(!$poll->vote_count >0){
          echo $this->htmlLink(array( 'route' => 'sespagepoll_specific', 'action' => 'edit', 'poll_id' =>
          $poll->poll_id, 'reset' => true, ), $this->translate('Edit Poll'), array( 'class' => 'buttonlink icon_poll_edit' )); } ?>

          <?php if( !$poll->closed ): ?>
            <?php echo $this->htmlLink(array(
              'route' => 'sespagepoll_specific',
              'action' => 'close',
              'poll_id' => $poll->getIdentity(),
              'closed' => 1,
            ), $this->translate('Close Poll'), array(
              'class' => 'buttonlink icon_poll_close'
            )) ?>
          <?php else: ?>
            <?php echo $this->htmlLink(array(
              'route' => 'sespagepoll_specific',
              'action' => 'close',
              'poll_id' => $poll->getIdentity(),
              'closed' => 0,
            ), $this->translate('Open Poll'), array(
              'class' => 'buttonlink icon_poll_open'
            )) ?>
          <?php endif; ?>


          <?php if(!$poll->vote_count >0){ echo $this->htmlLink(array(
            'route' => 'sespagepoll_specific',
            'action' => 'delete',
            'poll_id' => $poll->getIdentity(),
            'format' => 'smoothbox'
          ), $this->translate('Delete Poll'), array(
            'class' => 'buttonlink smoothbox icon_poll_delete'
          )); } ?>
        </div>
        </div>
        <div class="sespagepolls_browse_info">
          <h3 class="sespagepolls_browse_info_title">
            <?php echo $this->htmlLink($poll->getHref(), $poll->getTitle()) ?>
            <?php if( $poll->closed ): ?>
               <i class="fa fa-lock" alt="<?php echo $this->translate('Closed') ?>"></i>
            <?php endif ?>
          </h3>
          <div class="sespagepolls_browse_info_date sesbasic_text_light">
              <?php echo $this->translate('Posted by %s in <a href="#">Page</a>', $this->htmlLink($this->owner, $this->owner->getTitle())) ?>
              <?php echo $this->timestamp($poll->creation_date) ?>
           </div>
          <div class="sespagepolls_counts sesbasic_text_light">
          <span> 
              <?php echo $this->translate(array('<i class="fa fa-thumbs-up"></i> %s', '<i class="fa fa-thumbs-up"></i> %s', $poll->vote_count), $this->locale()->toNumber($poll->vote_count)) ?>
          </span>
          <span>
              <?php echo $this->translate(array('<i class="fa fa-eye"></i> %s', '<i class="fa fa-eye"></i> %s ', $poll->view_count), $this->locale()->toNumber($poll->view_count)) ?>
          </div>
          <?php if( '' != ($description = $poll->getDescription()) ): ?>
            <div class="sespagepolls_browse_info_desc sesbasic_text_light">
              <?php echo $description ?>
            </div>
          <?php endif; ?>
        </div>
      </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; // $this->polls is NOT empty ?>

  <?php echo $this->paginationControl($this->paginator, null, null, array(
    'pageAsQuery' => true,
    'query' => $this->formValues,
    //'params' => $this->formValues,
  )); ?>


<script type="text/javascript">
  $$('.core_main_sespagepoll').getParent().addClass('active');
</script>
