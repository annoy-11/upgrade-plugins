<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-member.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php
if(!$this->is_search_ajax):
if(!$this->is_ajax):
echo $this->partial('dashboard/left-bar.tpl', 'sesbusiness', array('business' => $this->business));?>
<div class="sesbusiness_dashboard_content sesbm sesbasic_clearfix">
  <?php endif; endif;?>
  <?php if(!$this->is_search_ajax): ?>
  <div class="sesbusiness_dashboard_content_header sesbasic_clearfix">
    <h3><?php echo $this->translate('Manage Members') ?></h3>
    <p><?php echo $this->translate("This business lists all the members of your Business, you can search members, approve / disapprove, remove and block them."); ?></p><br />
    <?php echo $this->translate('This Business has ').$this->translate(array('%s member', '%s members', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
  </div>
  <div class="sesbasic_browse_search sesbasic_browse_search_horizontal sesbusiness_dashboard_search_form">
    <?php echo $this->searchForm->render($this); ?>
  </div>
  <?php endif;?>
  <div id="sesbusiness_manage_members_content">
    <?php if($this->paginator->getTotalItemCount() > 0): ?>
      <div class="sesbusiness_dashboard_manage_members sesbasic_bxs">
        <form method="post" >
          <ul>
          	<?php foreach ($this->paginator as $member): ?>
              <li class="sesbusiness_dashboard_manage_members_item">
              	<article>
                  <div class="_thumb">
                    <?php echo $this->htmlLink($member->getHref(), $this->itemBackgroundPhoto($member, 'thumb.profile')) ?>
                  </div>
                  <div class="_cont">
                  	<div class="_name">
                      <a href="<?php echo $member->getHref();?>"><?php echo $member->displayname; ?></a>
                      <?php if($member->user_id == $this->business->owner_id):?>
                        <span class="sesbasic_text_light">(<?php echo $this->translate('Owner');?>)</span>
                      <?php endif;?>
                    </div>
                    <div class="_date sesbasic_text_light">Added on jan 2 2018</div>
                  </div>
                  
                  <div class="_btns">
                  	<?php if($member->user_id != $this->business->owner_id):?>
                      <div class="sesbasic_pulldown_wrapper _option">
                        <a href="javascript:void(0);" class="sesbasic_button sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a>
                        <div class="sesbasic_pulldown_options">
                        <ul class="_isicon">
                          <?php if( !$this->business->isOwner($member) && $member->active == true ): ?>
                          	<li>
                            	<?php echo $this->htmlLink(array('route' => 'sesbusiness_extended', 'controller' => 'member', 'action' => 'remove', 'business_id' => $this->business->getIdentity(), 'user_id' => $member->getIdentity()), $this->translate('Remove Member'), array('class' => 'smoothbox sesbusiness_member_remove')) ?>
                          	</li>
                          <?php endif;?>
                          <?php if( $member->active == false && $member->resource_approved == false ): ?>
                            <li>
                            	<?php echo $this->htmlLink(array('route' => 'sesbusiness_extended', 'controller' => 'member', 'action' => 'approve', 'business_id' => $this->business->getIdentity(), 'user_id' => $member->getIdentity()), $this->translate('Approve Request'), array('class' => 'smoothbox sesbusiness_request_accept')) ?>
                            </li>
                            <li>
                            	<?php echo $this->htmlLink(array('route' => 'sesbusiness_extended', 'controller' => 'member', 'action' => 'reject', 'business_id' => $this->business->getIdentity(), 'user_id' => $member->getIdentity()), $this->translate('Reject Request'), array('class' => 'smoothbox sesbusiness_request_reject')) ?>
                            </li>
                          <?php endif; ?>
                          <?php if( $member->active == false && $member->resource_approved == true ): ?>
                            <li><?php echo $this->htmlLink(array('route' => 'sesbusiness_extended', 'controller' => 'member', 'action' => 'remove', 'business_id' => $this->business->getIdentity(), 'user_id' => $member->getIdentity()), $this->translate('Cancel Invite'), array('class' => 'smoothbox sesbusiness_request_cancel')) ?></li>
                          <?php endif; ?>
                        </ul>
                        </div>
                      </div>
                  	<?php endif;?>  
                  </div>
                <td></td>
                </article>
              </li>
            <?php endforeach; ?>
          </ul>
        </form>
      </div>
      <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesbusiness"),array('')); ?>
    <?php else: ?>
      <div class="tip">
        <span>
          <?php if(!$this->is_search_ajax){ ?>
          <?php echo $this->translate('No member joined your business yet.'); }else{echo $this->translate('No members were found matching your selection.');}?>
        </span>
      </div>
    <?php endif; ?>
  </div>
  <?php if(!$this->is_search_ajax): 
  if(!$this->is_ajax): ?>
</div>
</div>
</div>
<?php endif; endif; ?>
<script type="application/javascript">
  var requestPagging;
  function paggingNumber(pageNum){
    sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
    var searchFormData = sesJqueryObject('#sesbusiness_search_member_search').serialize();
    requestPagging= (new Request.HTML({
      method: 'post',
      url: en4.core.baseUrl + 'sesbusiness/dashboard/manage-member/',
      'data': {
          format: 'html',
          searchParams :searchFormData, 
          is_search_ajax:true,
          is_ajax : 1,
          page:pageNum,
          business_id: '<?php echo $this->business->business_id; ?>',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
        sesJqueryObject('#sesbusiness_manage_members_content').html(responseHTML);
      }
    }));
    requestPagging.send();
    return false;
  }
  sesJqueryObject('#loadingimgsesbusiness-wrapper').hide();
  sesJqueryObject(document).on('submit', '#manage_members_search_form', function (event) {
    event.preventDefault();
    var searchFormData = sesJqueryObject(this).serialize();
    sesJqueryObject('#loadingimgsesbusiness-wrapper').show();
    new Request.HTML({
      method: 'post',
      url: en4.core.baseUrl + 'sesbusiness/dashboard/manage-member/',
      data: {
        format: 'html',
        business_id: '<?php echo $this->business->business_id; ?>',
        searchParams: searchFormData,
        is_search_ajax: true,
      },
      onComplete: function (response) {
        sesJqueryObject('#loadingimgsesbusiness-wrapper').hide();
        sesJqueryObject('#sesbusiness_manage_members_content').html(response);
      }
    }).send();
  });
</script>
