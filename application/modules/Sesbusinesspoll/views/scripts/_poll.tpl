<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspoll
 * @package    Sesbusinesspoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _poll.tpl  2018-10-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php 
    $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusinesspoll/externals/styles/styles.css');
  ?>
<?php 
    $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusinesspoll/externals/styles/styles.css');
  ?>
<?php
  $this->headScript()
    ->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbusinesspoll/externals/scripts/core.js');
  $this->headTranslate(array(
    'Show Questions', 'Show Results', '%1$s%%', '%1$s vote',
  ));
 $isvoteShow = in_array("vote_count", $this->show_criteria)?true:false;
?>

<script type="text/javascript">
  //<![CDATA[

  en4.core.runonce.add(function() {
    var initializePoll = function() {
      en4.sesbusinesspoll.urls.vote = '<?php echo $this->url(array('action' => 'vote'), 'sesbusinesspoll_general') ?>';
      en4.sesbusinesspoll.urls.login = '<?php echo $this->url(array(), 'user_login') ?>';
      en4.sesbusinesspoll.addPollData(<?php echo $this->sesbusinesspoll->getIdentity() ?>, {
        canVote : <?php echo $this->canVote ? 'true' : 'false' ?>,
        canChangeVote : <?php echo $this->canChangeVote ? 'true' : 'false' ?>,
        hasVoted : <?php echo $this->hasVoted ? 'true' : 'false' ?>,
        csrfToken : '<?php echo $this->sesBusinessVoteHash($this->sesbusinesspoll)->generateHash()?>',
        isClosed : <?php echo $this->sesbusinesspoll->closed ? 'true' : 'false' ?>
      });
      $$('#sesbusinesspoll_form_<?php echo $this->sesbusinesspoll->getIdentity() ?> .sesbusinesspoll_vote').removeEvents('click').addEvent('click', function(event) {
 var isVoteShow = <?php echo $isvoteShow ? 'true' : 'false' ?>;
        en4.sesbusinesspoll.vote(<?php echo $this->sesbusinesspoll->getIdentity() ?>,$("sesbusinesspoll_option_"+this.get("id")) ,isVoteShow);
      });
    }
    // Dynamic loading for feed
    if( $type(en4) == 'object' && 'sesbusinesspoll' in en4 ) {
      initializePoll();
    } else {
      new Asset.javascript(en4.core.staticBaseUrl + 'application/modules/Sesbusinesspoll/externals/scripts/core.js', {
        onload: function() {
          initializePoll();
        }
      });
    }
  });
  //]]>
</script>

<span class="sesbusinesspoll_view_single sesbasic_bxs">
  <form id="sesbusinesspoll_form_<?php echo $this->sesbusinesspoll->getIdentity() ?>" action="<?php echo $this->url() ?>" method="POST" onsubmit="return false;">
    <ul id="sesbusinesspoll_options_<?php echo $this->sesbusinesspoll->getIdentity() ?>" class="sesbusinesspoll_options">
     <?php // <div style="display:flex;"> ?>
      <?php foreach( $this->pollOptions as $i => $option ):?>
	  <?php if($option->file_id >0 && $option->image_type>0): ?>
     <?php //<div class="sesbusinesspoll_img_box"> ?>
      <li id="sesbusinesspoll_item_option_<?php echo $option->poll_option_id ?>" class="sesbusinesspoll_with_img">
        <div class="sesbusinesspoll_has_voted" <?php echo ( $this->hasVoted ? '' : 'style="display:none;"' ) ?>>
        <div class="sesbusinesspoll_has_voted_inner">
          <?php $pct = $this->sesbusinesspoll->vote_count
                     ? floor(100*($option->votes/$this->sesbusinesspoll->vote_count))
                     : 0;
                if (!$pct)
                  $pct = 1;
           ?>

            <?php if($option->file_id >0){
				$gifUrl = ($storage = Engine_Api::_()->storage()->get($option->file_id, '')) ? $storage->map() : "";?>
            <div class="sesbusinesspoll_img">
              <img src ="<?php echo $gifUrl ?>">
							<div class="sesbusinesspoll_img_overlay_inner">
								<div class="sesbusinesspoll_img_overlay">
									<div class="sesbusinesspoll_percent">
                      <div id="sesbusinesspoll-answer-<?php echo $option->poll_option_id ?>" class='sesbusinesspoll_answer sesbusinesspoll-answer-<?php echo (($i%8)+1) ?>'
                      style='width: <?php echo 1*$pct; ?>%;'>
                        &nbsp;
                      </div>
									</div>
									<div class="sesbusinesspoll_answer_total">
									 <?php echo $this->translate(array('%1$s vote', '%1$s votes', $option->votes), $this->locale()->toNumber($option->votes)) ?>
										(<?php echo $this->translate('%1$s%%', $this->locale()->toNumber($option->votes ? $pct : 0)) ?>)
									</div>
								</div>
              </div>
            <?php } ?>
            </div>
            <div class="sesbusinesspoll_optioncontent">
							<div class="sesbusinesspoll_option">
								<?php echo $option->poll_option ?>
							</div>
						</div>
						<div class="sesbusinesspoll_answer_user" id="sesbusinesspoll_user_photo_<?php echo $option->poll_option_id ?>">
            <?php
							$tables = Engine_Api::_()->getDbtable('votes', 'sesbusinesspoll')->getVotesPaginator($option->poll_option_id)->setItemCountPerPage(5)->setCurrentPageNumber(1);
							$pagecount = $tables->getPages()->pageCount;
							foreach($tables as $table){
								$user = Engine_Api::_()->getItem('user', $table->user_id);
								if($user->getPhotoUrl('thumb.notmal')){
								?>
									<div>
											 <a href="<?php echo $user->getHref();?>"><span class="bg_item_photo" style="background-image:url(<?php echo $user->getPhotoUrl('thumb.notmal'); ?>);"></span></a>
									</div>
								<?php }
							}
							if($pagecount >1 ){ ?>
								<div>
									<a class="more_user" id="<?php echo $option->poll_option_id ?>"><i class="fa fa-ellipsis-h"></i></a>
								</div>
							<?php }  ?>

        </div>
        </div>
        </div>
        <div class="sesbusinesspoll_not_voted" <?php echo ($this->hasVoted?'style="display:none;"':'') ?> >
          <div class="sesbusinesspoll_not_voted_inner">
<div class ="sesbusinesspoll_vote" style="cursor: pointer;" id="<?php echo $option->poll_option_id ?>" >
            <div class="sesbusinesspoll_imginfo">
           <?php if($option->file_id){
           $gifUrl = ($storage = Engine_Api::_()->storage()->get($option->file_id, '')) ? $storage->map() : "";
            ?>
              <div class="sesbusinesspoll_img">
                <img src ="<?php echo $gifUrl ?>">
              </div>

            <?php } ?>
             <div class="sesbusinesspoll_optioncontent">
               <div class="sesbusinesspoll_radio" id="sesbusinesspoll_radio_<?php echo $option->poll_option_id ?>">

            <input id="sesbusinesspoll_option_<?php echo $option->poll_option_id ?>"
                   type="radio" name="sesbusinesspoll_options" value="<?php echo $option->poll_option_id ?>"
                   <?php if( $this->hasVoted == $option->poll_option_id ): ?>checked="true"<?php endif; ?>
                   <?php if( ($this->hasVoted && !$this->canChangeVote) || $this->sesbusinesspoll->closed ): ?>disabled="true"<?php endif; ?>
                   />
                   <span class="checkmark"></span>
          </div>
          <label for="sesbusinesspoll_option_<?php echo $option->poll_option_id ?>">
            <?php echo $option->poll_option ?>
          </label>
          </div>
          </div>
</div>


        </div>
      </li>
    <?php //  </div> ?>
      <?php else: ?>
	  <li id="sesbusinesspoll_item_option_<?php echo $option->poll_option_id ?>" class="sesbusinesspoll_resultview">
        <div class="sesbusinesspoll_has_voted" <?php echo ( $this->hasVoted ? '' : 'style="display:none;"' ) ?>>
          <div class="sesbusinesspoll_option">
            <?php echo $option->poll_option ?>
          </div>

          <?php $pct = $this->sesbusinesspoll->vote_count
                     ? floor(100*($option->votes/$this->sesbusinesspoll->vote_count))
                     : 0;
                if (!$pct)
                  $pct = 1;
                
           ?>

					<div class="sesbusinesspoll_percentage_bar">
						<div id="sesbusinesspoll-answer-<?php echo $option->poll_option_id ?>" class='sesbusinesspoll_answer sesbusinesspoll-answer-<?php echo (($i%8)+1) ?>' style='width: <?php echo 1*$pct; ?>%;'>            
						&nbsp;
          </div>
          </div>
          <div class="sesbusinesspoll_answer_total">
           <?php echo $this->translate(array('%1$s vote', '%1$s votes', $option->votes), $this->locale()->toNumber($option->votes)) ?>
            (<?php echo $this->translate('%1$s%%', $this->locale()->toNumber($option->votes ? $pct : 0)) ?>)
            </div>
          <div class="sesbusinesspoll_answer_user" id="sesbusinesspoll_user_photo_<?php echo $option->poll_option_id ?>">
            <?php
             $tables = Engine_Api::_()->getDbtable('votes', 'sesbusinesspoll')->getVotesPaginator($option->poll_option_id)->setItemCountPerPage(5)->setCurrentPageNumber(1);
            $pagecount = $tables->getPages()->pageCount;
           foreach($tables as $table){
              $user = Engine_Api::_()->getItem('user', $table->user_id);
            if($user->getPhotoUrl('thumb.notmal')){
            ?>
                  	<div>
                         <a href="<?php echo $user->getHref();?>"><span class="bg_item_photo" style="background-image:url(<?php echo $user->getPhotoUrl('thumb.notmal'); ?>);"></span></a>
                    </div><?php }}
           if($pagecount >1 ){ ?>
           <div>
            <a class="more_user" id="<?php echo $option->poll_option_id ?>"><i class="fa fa-ellipsis-h"></i></a>
            </div>
        <?php }  ?>

          </div>
        </div>
        <div class="sesbusinesspoll_not_voted" <?php echo ($this->hasVoted?'style="display:none;"':'') ?> >
         <div class="sesbusinesspoll_simpleview">
<div class ="sesbusinesspoll_vote" style="cursor: pointer;" id="<?php echo $option->poll_option_id ?>" >
          <div class="sesbusinesspoll_radio"  id="sesbusinesspoll_radio_<?php echo $option->poll_option_id ?>">
            <input id="sesbusinesspoll_option_<?php echo $option->poll_option_id ?>"
                   type="radio" name="sesbusinesspoll_options" value="<?php echo $option->poll_option_id ?>"
                   <?php if( $this->hasVoted == $option->poll_option_id ): ?>checked="true"<?php endif; ?>
                   <?php if( ($this->hasVoted && !$this->canChangeVote) || $this->sesbusinesspoll->closed ): ?>disabled="true"<?php endif; ?>
                   />
                   <span class="checkmark"></span>
          </div>
	</div>
          <label for="sesbusinesspoll_option_<?php echo $option->poll_option_id ?>">
            <?php echo $option->poll_option ?>
          </label>
          </div>

            <?php if($option->file_id){
            $gifUrl = Engine_Api::_()->storage()->get($option->file_id, '')->map();
            ?>

                <img src ="<?php echo $gifUrl ?>">
            <?php } ?>
        </div>
      </li>

	  <?php endif ?>
	  <?php endforeach; ?>
	 <?php // </div> ?>
    </ul>
    <?php if( empty($this->hideStats) ): ?>
    <div class="sesbusinesspoll_stats">
    <div class="sesbusiness_poll_icons">
      <a href='javascript:void(0);' onClick='en4.sesbusinesspoll.toggleResults(<?php echo $this->sesbusinesspoll->getIdentity() ?>); this.blur();' class="sesbusinesspoll_toggleResultsLink">
        <?php echo $this->translate($this->hasVoted ? 'Show Questions' : 'Show Results' ) ?>
      </a>
      <div class="sesbusinesspoll_option_view">
      <a href="javascript:;" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a>
      <div class="sesbasic_pulldown_options">
      <?php if( empty($this->hideLinks) ): ?>

      <?php echo $this->htmlLink(array(
        'module'=>'core',
        'controller'=>'report',
        'action'=>'create',
        'route'=>'default',
        'subject'=>$this->sesbusinesspoll->getGuid(),
        'format' => 'smoothbox'
      ), $this->translate("Report"), array('class' => 'smoothbox sesbusinesspoll_report')); ?>
      <?php endif; ?>
      <?php if( $this->canEdit && !$this->sesbusinesspoll->vote_count>0 ): ?>

      <?php echo $this->htmlLink(array(
            'route' => 'sesbusinesspoll_specific',
            'action' => 'edit',
            'poll_id' => $this->sesbusinesspoll->getIdentity(),
            'reset' => true,
          ), $this->translate('Edit Poll'), array(
            'class' => 'sesbusinesspoll_privacy',
			'id'=>'sesbusinesspoll_edit_link'
          )) ?>
      <?php endif; ?>
      <?php if( $this->canDelete && !$this->sesbusinesspoll->vote_count>0 ) : ?>
      <?php echo $this->htmlLink(array(
            'route' => 'sesbusinesspoll_specific',
            'action' => 'delete',
            'poll_id' => $this->sesbusinesspoll->getIdentity(),
            'format' => 'smoothbox'
          ), $this->translate('Delete Poll'), array(
            'class' => 'smoothbox sesbusinesspoll_del',
			'id'=>'sesbusinesspoll_delete_link'
          )) ?>
      <?php endif; ?>
			<?php 
			$poll = $this->sesbusinesspoll;
			$viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
			$owner_id = $poll->getOwner()->getIdentity();
			?>
			<?php if($owner_id == $viewer_id): ?>
			 <?php if( !$poll->closed ): ?>
            <?php echo $this->htmlLink(array(
              'route' => 'sesbusinesspoll_specific',
              'action' => 'close',
              'poll_id' => $this->sesbusinesspoll->getIdentity(),
              'closed' => 1,
            ), $this->translate('Close Poll'), array(
              'class' => 'buttonlink icon_poll_close'
            )) ?>
          <?php else: ?>
            <?php echo $this->htmlLink(array(
              'route' => 'sesbusinesspoll_specific',
              'action' => 'close',
              'poll_id' => $this->sesbusinesspoll->getIdentity(),
              'closed' => 0,
            ), $this->translate('Open Poll'), array(
              'class' => 'buttonlink icon_poll_open'
            )) ?>
          <?php endif; ?>
			<?php endif ?>
	  </div>
    </div>
      <?php
      $value['resource_type'] = 'sesbusinesspoll_poll';
      $value['resource_id'] = $this->sesbusinesspoll->poll_id;
       $tableFav = Engine_Api::_()->getDbTable('favourites', 'sesbusinesspoll')->isFavourite($value);
      ?>
        <!-- polls like favourite -->
		<div class="_btnsleft">
		  <?php $viewer = Engine_Api::_()->user()->getViewer();?>
            <?php $viewerId = $viewer->getIdentity();?>
            <?php if($viewerId ):?>
            <?php $canComment = Engine_Api::_()->authorization()->isAllowed('sesbusinesspoll_poll', $viewer, 'create');?>
            <?php  if($canComment && in_array("likeButton", $this->show_criteria)):?>
            <?php $likeStatus = Engine_Api::_()->sesbusiness()->getLikeStatus($this->sesbusinesspoll->poll_id,$this->sesbusinesspoll->getType()); ?>
			  <a href="javascript:;" data-type="like_view" data-url="<?php echo $this->sesbusinesspoll->poll_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesbusinesspoll_like sesbusinesspoll_like_<?php echo $this->sesbusinesspoll->poll_id ?> sesbusinesspoll_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $this->sesbusinesspoll->like_count;?></span></a>
            <?php endif;?>
            <?php if( Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinesspoll.allow.favourite', 1) && in_array("favouriteButton", $this->show_criteria)):?>
            <?php 	$value['resource_type'] = $this->sesbusinesspoll->getType();
						$value['resource_id'] = $this->sesbusinesspoll->poll_id;
						$favouriteStatus = Engine_Api::_()->getDbTable('Favourites', 'sesbusinesspoll')->isFavourite($value);
				$favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'sesbusinesspoll')->isFavourite(array('resource_id' => $this->sesbusinesspoll->poll_id,'resource_type' => $this->sesbusinesspoll->getType())); ?>
				<a href="javascript:;" data-type="favourite_view" data-url="<?php echo $this->sesbusinesspoll->poll_id ; ?>" class="sesbasic_icon_btn favrite sesbasic_icon_btn_count sesbusinesspoll_fav sesbasic_icon_fav_btn sesbusinesspoll_favourite_<?php echo $this->sesbusinesspoll->poll_id ?> sesbusinesspoll_likefavfollow <?php echo ($favouriteStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php echo $this->sesbusinesspoll->favourite_count;?></span></a>
            <?php endif;?>
            <?php endif;?>
            <?php  // endif;?>
	
        <!-- polls end  polls like favourite -->
        <?php $shareType = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinesspoll.allow.share', 1);?>
        <!-- social share -->
        <?php if($shareType  && in_array("socialSharing", $this->show_criteria)):?>
        <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesbusinesspoll, 'socialshare_enable_plusicon' => 1, 'socialshare_icon_limit' => '10')); ?>
        <?php endif;?>
        	</div>
          </div>
        <!-- social share end -->
				<?php $item = $this->sesbusinesspoll; ?>
      <div class="stats sesbasic_text_light">
<?php if(in_array("likecount", $this->show_criteria)): ?>
		
				<span class="like_count" title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber(	$item->like_count)) ?>">
										<i class="fa fa-thumbs-up"></i> <span><?php echo $item->like_count ;?></span>
									</span>
				<?php endif; ?>
				<?php if(in_array("votecount", $this->show_criteria)): ?>
					<span class="sesbusinesspoll_vote_total"  title="<?php echo $this->translate(array('%s vote', '%s votes', $item->vote_count), $this->locale()->toNumber($item->vote_count)) ?>">
						<i class="fa fa-hand-o-up"></i> <span><?php echo $item->vote_count ;?></span>
					</span>
				<?php endif; ?>
				<?php if(in_array("viewcount", $this->show_criteria)): ?>
					<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber(	$item->view_count)) ?>">
						<i class="fa fa-eye"></i> <span><?php echo $item->view_count ;?></span>
					</span>
				<?php endif; ?>
				<?php if(in_array("favouritecount", $this->show_criteria)): ?>
					<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber(	$item->favourite_count)) ?>">
						<i class="fa fa-heart-o"></i> <span><?php echo $item->favourite_count ;?></span>
					</span>
				<?php endif; ?>
			</div>
    </div>
    <?php endif; ?>
  </form>
</span>

