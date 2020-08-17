<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagepoll
 * @package    Sespagepoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<!--<div class="sespagepoll_owner_name">
  <?php  echo  $this->translate('%s\'s Polls', $this->htmlLink($this->owner,
  $this->owner->getTitle()))
  ; ?>
  </div>-->
<div class='sespagepolls_view'>
  <h3>
    <?php  echo $this->sespagepoll->title ;  ?>
    <?php  if( $this->sespagepoll->closed ):  ?>
       <i class="fa fa-lock" alt="<?php echo $this->translate('Closed') ?>"></i>
    <?php endif ?>
  </h3>
  <div class="poll_desc sesbasic_text_light">
    <?php echo $this->sespagepoll->description ?>
  </div>
  <?php
    // poll, pollOptions, canVote, canChangeVote, hasVoted, showPieChart
     include APPLICATION_PATH . '/application/modules/Sespagepoll/views/scripts/_poll.tpl'; 
  ?>
</div>
<?php  $viewUrl = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagepoll.polls.manifest', 'pagepolls'); ?>
 
<!--
<script type="text/javascript">
 $('.core_main_sespagepoll').getParent().addClass('active');-->
<script>

	var url = '<?php echo $viewUrl; ?>';
  // more user select
  sesJqueryObject(document).on('click', '.more_user', function() {
    var optionId = sesJqueryObject(this).attr('id');
      var url = '<?php echo $this->url(Array('module' => 'sespagepoll', 'controller' => 'poll', 'action' =>'more'), 'default') ?>' + '/option_id/'+ optionId;
      Smoothbox.open(url);
  });
  /* like request */
  sesJqueryObject(document).on('click', '.sespagepoll_like', function() {
      var id = sesJqueryObject (this).attr('data-url');
      var thisclass = sesJqueryObject (this);
      sesJqueryObject.ajax({
          url:en4.core.baseUrl+url+'/poll/like/id/' + id ,
          type: "POST",
          contentType:false,
          processData: false,
          success: function(response) {
              var data = JSON.parse(response);
              var span = sesJqueryObject(thisclass).find( "span" );
              if(data.status){
                  if(data.condition == 'increment'){
                      sesJqueryObject(thisclass).addClass("button_active");
                      sesJqueryObject(span).html(data.count);
                  }else{
                      sesJqueryObject(thisclass).removeClass("button_active");
                      sesJqueryObject(span).html(data.count);
                  }
              }
          }
      });
  });
  /* like request end */
  /* favourite request  */
  sesJqueryObject(document).on('click', '.sespagepoll_fav', function() {
      var id = sesJqueryObject (this).attr('data-url');
      var thisclass = sesJqueryObject (this);
      sesJqueryObject.ajax({
          url:en4.core.baseUrl+url+'/poll/favourite/id/' + id ,
          type: "POST",
          contentType:false,
          processData: false,
          success: function(response) {
              var data = JSON.parse(response);
              var span = sesJqueryObject(thisclass).find( "span" );
              if(data.status){
                  if(data.condition == 'increment'){
                      sesJqueryObject(thisclass).addClass("button_active");
                      sesJqueryObject(span).html(data.count);
                  }else{
                      sesJqueryObject(thisclass).removeClass("button_active");
                      sesJqueryObject(span).html(data.count);
                  }
              }
          }
      });
  });
  /* favourite request end */
	</script>
