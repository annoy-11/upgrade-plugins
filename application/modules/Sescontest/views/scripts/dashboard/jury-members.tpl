<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: jury-members.tpl  2017-12-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescontestjurymember/externals/styles/styles.css'); ?>
<?php $base_url = $this->layout()->staticBaseUrl;?>
<?php $this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sescontest', array(
	'contest' => $this->contest,
      ));	
?>
	<div class="sesbasic_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs">
<?php } 
	echo $this->partial('dashboard/contest_expire.tpl', 'sescontest', array(
	'contest' => $this->contest,
      ));	
?>
<div class="sesbasic_dashboard_content_header sesbasic_clearfix">	
  <h3><?php echo $this->translate("Manage Jury Members for Voting"); ?></h3>
  <p>
    <?php echo $this->translate(' Here, you can add website members as Jury members to vote on the entries submitted in your contest. Jury members will have higher voting values and thus your contest will have more weightage and importance to the users participating and submitting entries.Jury Members will be able to vote only once on an entry.<br />
If Jury audience is not selected, then: You can not add a Jury Member as you have not enabled voting by Jury Members in your contest.'); ?>
  </p>
</div>
<?php if($this->canAddJury):?>
  <div class="sescontestjurymember_dashboard_form sesbasic_clearfix">
    <form id="addNewMember" method="post" enctype="multipart/form-data" action="<?php echo $this->url(array('contest_id' => $this->contest->custom_url, 'action'=>'jury-members'), 'sescontest_dashboard', true); ?>">
      <input type="hidden" value="" id="user_id" name="user_id" />
      <input type="text" name="search_text" id="search_text" value="" placeholder="<?php echo $this->translate("Search for Jury Memers?"); ?>" />
      <button type="button" id="submitNewMember"><?php echo $this->translate("Add"); ?></button>
    </form>
    <div class="sesbasic_loading_cont_overlay" id="sescontest_jury_loading"></div>
  </div>
<?php endif;?>
<?php if($this->paginator->getTotalItemCount() > 0):?>
	<ul class="sescontestjurymember_dashboard_list sesbasic_clearfix">
    <?php foreach($this->paginator as $user):?>
      <?php $hasDoneVote = Engine_Api::_()->getDbTable('votes','sescontest')->isVoted(array('user_id' => $user->user_id,'contest_id' => $this->contest->contest_id));?>
      <li class="item_list sesbasic_clearfix">
        <div class="item_list_thumb">
          <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon'), array('title' => $user->getTitle(), 'target' => '_parent')); ?>
        </div>
        <div class="item_list_info">
          <div class="item_list_title">
            <?php echo $this->htmlLink($user->getHref(), $user->getTitle(), array('title' => $user->getTitle(), 'target' => '_parent')); ?>
          </div>
          <?php if(!$hasDoneVote):?>
            <div class="item_list_btn">
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescontestjurymember', 'controller' => 'index', 'action' => 'delete-member', 'id' => $user->member_id,'contest_id' => $this->contest->contest_id), $this->translate("Delete"), array('class' => 'sessmoothbox sesbasic_button')) ?>
            </div>
          <?php endif;?>
        </div>
      </li>
    <?php endforeach;?>
  </ul>
<?php else:?>
  <div class="sesbasic_tip clearfix">
    <img src="application/modules/Sescontestjurymember/externals/images/jury-icon.png" alt="">
    <span class="sesbasic_text_light"><?php echo $this->translate("You have not added any jury member till now.");?></span>
  </div>
<?php endif;?>
<?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>

<script type='text/javascript'>
 var Searchurl = "<?php echo $this->url(array('contest_id' => $this->contest->custom_url,'action'=>'search-member'), 'sescontest_dashboard', true); ?>";
 function triggerAutoSuggest() {
  var contentAutocomplete = new Autocompleter.Request.JSON('search_text', Searchurl, {
    'postVar': 'text',
    'minLength': 1,
    'selectMode': 'pick',
    'autocompleteType': 'tag',
    'customChoices': true,
    'filterSubset': true,
    'multiple': false,
    'className': 'sesbasic-autosuggest',
    'injectChoice': function(token) {
  var choice = new Element('li', {
    'class': 'autocompleter-choices', 
    'html': token.photo, 
    'id':token.label
  });
  new Element('div', {
    'html': this.markQueryValue(token.label),
    'class': 'autocompleter-choice'
  }).inject(choice);
  this.addChoiceEvents(choice).inject(this.choices);
  choice.store('autocompleteChoice', token);
    }
  });
  contentAutocomplete.addEvent('onSelection', function(element, selected, value, input) {
    var to =  selected.retrieve('autocompleteChoice');
    sesJqueryObject('#user_id').val(to.id);
  });
  }
  en4.core.runonce.add(function() {
   triggerAutoSuggest();
  });
  sesJqueryObject(document).on("click","#submitNewMember", function() {
    if(sesJqueryObject('#user_id').val() != '')
    sesJqueryObject("#addNewMember").submit();
    else
    alert("Please select the member.");
  });
    sesJqueryObject(document).on('submit','#addNewMember',function(e) {
      e.preventDefault();
      sesJqueryObject('#sescontest_jury_loading').show();
      new Request.HTML({
        method: 'post',
        url : sesJqueryObject(this).attr('action'),
        data : {
          format : 'html',
          'user_id':sesJqueryObject('#user_id').val(),
          is_ajax:true,
        },
        onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
          if(responseHTML != '') {
            sesJqueryObject('.sesbasic_dashboard_content').html(responseHTML);
            triggerAutoSuggest();
            sesJqueryObject('#sescontest_jury_loading').hide();
          }
          else 
          window.location.reload(); 
        }
      }).send();
    });
</script>

