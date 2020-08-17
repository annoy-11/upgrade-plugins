<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<div class='sesadvpolls_view'>
  <h3>
    <?php  echo $this->sesadvpoll->title ;  ?>
    <?php  if( $this->sesadvpoll->closed ):  ?>
      <i class="fa fa-lock" alt="<?php echo $this->translate('Closed') ?>"></i>
    <?php endif ?>
  </h3>
  <div class="poll_desc sesbasic_text_light">
    <?php echo $this->sesadvpoll->description ?>
  </div>
  <?php include APPLICATION_PATH . '/application/modules/Sesadvpoll/views/scripts/_poll.tpl'; ?>
</div>

<script>

  sesJqueryObject(document).on('click', '.more_user', function() {
    var optionId = sesJqueryObject(this).attr('id');
      var url = '<?php echo $this->url(Array('module' => 'sesadvpoll', 'controller' => 'poll', 'action' =>'more'), 'default') ?>' + '/option_id/'+ optionId;
      Smoothbox.open(url);
  });

  sesJqueryObject(document).on('click', '.sesadvpoll_like', function() {
      var id = sesJqueryObject (this).attr('data-url');
      var thisclass = sesJqueryObject (this);
      sesJqueryObject.ajax({
          url:en4.core.baseUrl + 'sesadvpoll/poll/like/id/' + id ,
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

  sesJqueryObject(document).on('click', '.sesadvpoll_fav', function() {
      var id = sesJqueryObject (this).attr('data-url');
      var thisclass = sesJqueryObject (this);
      sesJqueryObject.ajax({
          url:en4.core.baseUrl+'sesadvpoll/poll/favourite/id/' + id ,
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
</script>
