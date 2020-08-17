<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<a id="page_profile_members_anchor"></a>
<script type="text/javascript">
  var pageMemberSearch = '<?php echo $this->search ?>';
  var pageMemberPage = Number(<?php echo sprintf('%d', $this->members->getCurrentPageNumber()) ?>);
  var waiting = '<?php echo $this->waiting ?>';
  en4.core.runonce.add(function() {
    var url = en4.core.baseUrl + 'widget/index/content_id/' + <?php echo sprintf('%d', $this->identity) ?>;
    $('page_members_search_input').addEvent('keypress', function(e) {
      if( e.key != 'enter' ) return;

      en4.core.request.send(new Request.HTML({
        'url' : url,
        'data' : {
          'format' : 'html',
          'subject' : en4.core.subject.guid,
          'search' : this.value
        }
      }), {
        'element' : $('page_profile_members_anchor').getParent()
      });
    });
  });

  var paginateSespageMembers = function(page) {
    var url = en4.core.baseUrl + 'widget/index/content_id/' + <?php echo sprintf('%d', $this->identity) ?>;
    en4.core.request.send(new Request.HTML({
      'url' : url,
      'data' : {
        'format' : 'html',
        'subject' : en4.core.subject.guid,
        'search' : pageMemberSearch,
        'page' : page,
        'waiting' : waiting
      }
    }), {
      'element' : $('page_profile_members_anchor').getParent()
    });
  }
</script>

<?php if( !empty($this->waitingMembers) && $this->waitingMembers->getTotalItemCount() > 0 ): ?>
<script type="text/javascript">
  var showWaitingMembers = function() {
    var url = en4.core.baseUrl + 'widget/index/content_id/' + <?php echo sprintf('%d', $this->identity) ?>;
    en4.core.request.send(new Request.HTML({
      'url' : url,
      'data' : {
        'format' : 'html',
        'subject' : en4.core.subject.guid,
        'waiting' : true
      }
    }), {
      'element' : $('page_profile_members_anchor').getParent()
    });
  }
  var showFullMembers = function() {
    var url = en4.core.baseUrl + 'widget/index/content_id/' + <?php echo sprintf('%d', $this->identity) ?>;
    en4.core.request.send(new Request.HTML({
      'url' : url,
      'data' : {
        'format' : 'html',
        'subject' : en4.core.subject.guid,
      }
    }), {
      'element' : $('page_profile_members_anchor').getParent()
    });
  }
</script>
<?php endif; ?>
<div class="sespage_profile_tab_wrapper sespage_profile_members sesbasic_bxs">
  <div style="display:block;">
    <?php $singularMemberTitle = $this->singularTitle;?>
    <?php $pluralMemberTitle = $this->pluralTitle;?>
  <?php if( !$this->waiting ): ?>
    <div class="sespage_profile_content_search sesbasic_clearfix">
      <div class="_input">
        <input id="page_members_search_input" type="text" value="<?php echo $this->translate('Search ').ucfirst($pluralMemberTitle) ?>" onfocus="$(this).store('over', this.value);this.value = '';" onblur="this.value = $(this).retrieve('over');">
      </div>
    </div>
    <div class="sespage_profile_content_total sesbasic_clearfix">
      <div class="_count">
        <?php if( '' == $this->search ): ?>
          <?php echo $this->translate(array('This page has %1$s %2$s.', 'This page has %1$s %3$s.', $this->members->getTotalItemCount()),$this->locale()->toNumber($this->members->getTotalItemCount()),$singularMemberTitle,$pluralMemberTitle) ?>
        <?php else: ?>
          <?php echo $this->translate(array('This page has %1$s %2$s that matched the query "%3$s".', 'This page has %1$s %4$s that matched the query "%3$s".', $this->members->getTotalItemCount()), $this->locale()->toNumber($this->members->getTotalItemCount()), $singularMemberTitle, $this->search, $pluralMemberTitle) ?>
        <?php endif; ?>
      </div>
      <?php if( !empty($this->waitingMembers) && $this->waitingMembers->getTotalItemCount() > 0 ): ?>
        <div class="_links">
          <?php echo $this->htmlLink('javascript:void(0);', $this->translate('See Waiting'), array('onclick' => 'showWaitingMembers(); return false;', 'class' => 'sesbasic_button')) ?>
        </div>
      <?php endif; ?>
    </div>  
  <?php else: ?>
    <div class="sespage_profile_content_total sesbasic_clearfix">
      <div class="_count">
        <?php echo $this->translate(array('This page has %1$s %2$s waiting for approval or waiting for an invite response.', 'This page has %1$s %3$s waiting for approval or waiting for an invite response.', $this->members->getTotalItemCount()),$this->locale()->toNumber($this->members->getTotalItemCount()),$singularMemberTitle,$pluralMemberTitle) ?>
      </div>
      <?php if( !empty($this->fullMembers) && $this->fullMembers->getTotalItemCount() > 0 ): ?>
        <div class="_links">
          <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View all approved ').$pluralMemberTitle, array('onclick' => 'showFullMembers(); return false;', 'class' => 'sesbasic_button')) ?>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>
  
  <?php if( $this->members->getTotalItemCount() > 0 ): ?>
  	<div class="sespage_profile_members_listing">
    	<div class="sesbasic_loading_cont_overlay" id="memberdataloading"></div>
      <ul class='sesbasic_clearfix sespage_profile_members_listing'>
        <?php foreach( $this->members as $member ):
          if( !empty($member->resource_id) ) {
            $memberInfo = $member;
            $member = $this->item('user', $memberInfo->user_id);
          } else {
            $memberInfo = $this->page->membership()->getMemberInfo($member);
          }
          ?>
    
          <li class="sespage_profile_members_list_item sesbasic_clearfix" id="page_member_<?php echo $member->getIdentity() ?>">
    				<article>
            	<div class="_thumb">
              	<?php echo $this->htmlLink($member->getHref(), $this->itemBackgroundPhoto($member, 'thumb.profile')) ?>
              </div>
              <div class="_cont">
                <div class="_name"> <?php echo $this->htmlLink($member->getHref(), $member->getTitle()) ?></div>
                <?php if( $this->page->isOwner($member) ): ?>
                 	<div class="_role"> 
                  	(<?php echo ( $memberInfo->title ? $memberInfo->title : $this->translate('owner') ) ?><?php if( $this->page->isOwner($this->viewer()) ): ?><?php echo $this->htmlLink(array('route' => 'sespage_extended', 'controller' => 'member', 'action' => 'edit', 'page_id' => $this->page->getIdentity(), 'user_id' => $member->getIdentity(), 'format' => 'smoothbox'), '&nbsp;', array('class' => 'smoothbox')) ?><?php endif; ?>)
                  </div>
                <?php endif; ?>
                <div class="_date sesbasic_text_light" style="display:none;">Added on jan 2 2018</div>
              </div>
              <?php // Remove/Promote/Demote member ?>
              <?php if($this->page->isOwner($this->viewer()) ): ?>
                <div class="_btns">
                  <div class="sesbasic_pulldown_wrapper _option">
                    <?php if((!$this->page->isOwner($member) && $memberInfo->active == true) || ($memberInfo->active == false && $memberInfo->resource_approved == false) || ($memberInfo->active == false && $memberInfo->resource_approved == true)):?>
                      <a href="javascript:void(0);" class="sesbasic_button sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a>
                    <?php endif;?>
                    <div class="sesbasic_pulldown_options">
                      <ul class="_isicon">
                        <?php if( !$this->page->isOwner($member) && $memberInfo->active == true ): ?>
                          <li><?php echo $this->htmlLink(array('route' => 'sespage_extended', 'controller' => 'member', 'action' => 'remove', 'page_id' => $this->page->getIdentity(), 'user_id' => $member->getIdentity()), $this->translate("Remove ").ucfirst($singularMemberTitle), array('class' => 'smoothbox sespage_member_remove')) ?></li>
                        <?php endif;?>
                        <?php if( $memberInfo->active == false && $memberInfo->resource_approved == false ): ?>
                          <li><?php echo $this->htmlLink(array('route' => 'sespage_extended', 'controller' => 'member', 'action' => 'approve', 'page_id' => $this->page->getIdentity(), 'user_id' => $member->getIdentity()), $this->translate('Approve Request'), array('class' => 'smoothbox sespage_request_accept')) ?></li>
                          <li><?php echo $this->htmlLink(array('route' => 'sespage_extended', 'controller' => 'member', 'action' => 'reject', 'page_id' => $this->page->getIdentity(), 'user_id' => $member->getIdentity()), $this->translate('Reject Request'), array('class' => 'smoothbox sespage_request_reject')) ?></li>
                        <?php endif;?>
                        <?php if( $memberInfo->active == false && $memberInfo->resource_approved == true ): ?>
                          <li><?php echo $this->htmlLink(array('route' => 'sespage_extended', 'controller' => 'member', 'action' => 'remove', 'page_id' => $this->page->getIdentity(), 'user_id' => $member->getIdentity()), $this->translate('Cancel Invite'), array('class' => 'smoothbox sespage_request_cancel')) ?></li>
                        <?php endif;?>
                      </ul>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
    		</article>
          </li>
        <?php endforeach;?>
      </ul>
    </div>
    <?php if( $this->members->count() > 1 ): ?>
      <div class="clear sesbasic_clearfix">
        <?php if( $this->members->getCurrentPageNumber() > 1 ): ?>
          <div id="user_page_members_previous" class="paginator_previous">
            <?php echo $this->htmlLink('javascript:void(0);', $this->translate('Previous'), array(
              'onclick' => 'paginateSespageMembers(pageMemberPage - 1)',
              'class' => 'buttonlink icon_previous'
            )); ?>
          </div>
        <?php endif; ?>
        <?php if( $this->members->getCurrentPageNumber() < $this->members->count() ): ?>
          <div id="user_page_members_next" class="paginator_next">
            <?php echo $this->htmlLink('javascript:void(0);', $this->translate('Next') , array(
              'onclick' => 'paginateSespageMembers(pageMemberPage + 1)',
              'class' => 'buttonlink_right icon_next'
            )); ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  <?php endif; ?>
  </div>
</div>