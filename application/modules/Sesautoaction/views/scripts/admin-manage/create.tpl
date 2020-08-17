<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
 <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesautoaction/views/scripts/dismiss_message.tpl';?>
<div class="sesbasic_search_reasult">
	<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesautoaction', 'controller' => 'manage', 'action' => 'index'), $this->translate("Back to Manage Auto Actions") , array('class'=>'sesbasic_icon_back buttonlink')); ?>
</div>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

    en4.core.runonce.add(function(){
      if($('resource_id-wrapper'))
        $('resource_id-wrapper').style.display = 'none';
      if($('likeaction-wrapper'))
        $('likeaction-wrapper').style.display = 'none';
      if($('friend-wrapper'))
        $('friend-wrapper').style.display = 'none';
      if($('join-wrapper'))
        $('join-wrapper').style.display = 'none';
      if($('follow-wrapper'))
        $('follow-wrapper').style.display = 'none';
      if($('favourite-wrapper'))
        $('favourite-wrapper').style.display = 'none';
      if($('commentaction-wrapper'))
        $('commentaction-wrapper').style.display = 'none';
      if($('newsignup-wrapper'))
        $('newsignup-wrapper').style.display = 'none';
      formObj = sesJqueryObject('#form-auto-action').find('div').find('div').find('div');
    });
    
	  function getAllContent(resource_type) {
      if(resource_type == '')
        return;
        
      var url = en4.core.baseUrl + 'sesautoaction/index/getcontent';
      (new Request.HTML({
        url: url,
        data: {
          'resource_type':resource_type
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        
            if (formObj.find('#resource_id-wrapper').length && responseHTML) {
              sesJqueryObject('#resource_id-wrapper').show();
              formObj.find('#resource_id-wrapper').show();
              formObj.find('#resource_id-wrapper').find('#resource_id-element').find('#resource_id').html(responseHTML);
            }
//           sesJqueryObject('#sesmusic_sussubcat_loading').hide();
        }
      })).send();  
    }
    
    function showAllAction(resource_type) {
      if(resource_type == '')
        return;
        
      var url = en4.core.baseUrl + 'sesautoaction/index/showaction';
      (new Request.JSON({
        url: url,
        data: {
          'format' : 'json',
          'resource_type':resource_type
        },
        onSuccess: function(responseJSON) {
        
          if(responseJSON.likeaction == 1) {
            if($('likeaction-wrapper'))
              $('likeaction-wrapper').style.display = 'block';
          } else {
            if($('likeaction-wrapper'))
              $('likeaction-wrapper').style.display = 'none';
          }
          
//           if(responseJSON.friend == 1) {
//             if($('friend-wrapper'))
//               $('friend-wrapper').style.display = 'block';
//           } else {
//             if($('friend-wrapper'))
//               $('friend-wrapper').style.display = 'none';
//           }
          
          if(responseJSON.join == 1) {
            if($('join-wrapper'))
              $('join-wrapper').style.display = 'block';
          } else {
            if($('join-wrapper'))
              $('join-wrapper').style.display = 'none';
          }
          if(responseJSON.commentaction == 1) {
            if($('commentaction-wrapper'))
              $('commentaction-wrapper').style.display = 'block';
          } else {
            if($('commentaction-wrapper'))
              $('commentaction-wrapper').style.display = 'none';
          }
          
          if(responseJSON.follow == 1) {
            if($('follow-wrapper'))
              $('follow-wrapper').style.display = 'block';
          } else {
            if($('follow-wrapper'))
              $('follow-wrapper').style.display = 'none';
          }
          if(responseJSON.favourite == 1) {
            if($('favourite-wrapper'))
              $('favourite-wrapper').style.display = 'block';
          } else {
            if($('favourite-wrapper'))
              $('favourite-wrapper').style.display = 'none';
          }
        }
      })).send();  
    }
</script>
