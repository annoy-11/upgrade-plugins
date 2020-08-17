<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesautoaction/views/scripts/dismiss_message.tpl';?>

<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesautoaction', 'controller' => 'manage', 'action' => 'index'), "Back to Manage Auto Actions", array('class'=>'sesbasic_icon_back buttonlink')) ?>
<br /><br />
<div class='settings sesbasic_admin_form'>
  <?php echo $this->form->render($this); ?>
</div>
<script>
  en4.core.runonce.add(function(){
    showAllAction('<?php echo $this->item->resource_type; ?>');
      if($('newsignup-wrapper'))
        $('newsignup-wrapper').style.display = 'none';
      if($('friend-wrapper'))
        $('friend-wrapper').style.display = 'none';
  });
    
  function chooseoptions(value) {
    if(value == 1) {
      if($('name-wrapper'))
        $('name-wrapper').style.display = 'block';
      if($('member_levels-wrapper'))
        $('member_levels-wrapper').style.display = 'none';
    } else { 
      if($('member_levels-wrapper'))
        $('member_levels-wrapper').style.display = 'block';
      if($('name-wrapper'))
        $('name-wrapper').style.display = 'none';
    }
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
        
//         if(responseJSON.friend == 1) {
//           if($('friend-wrapper'))
//             $('friend-wrapper').style.display = 'block';
//         } else {
//           if($('friend-wrapper'))
//             $('friend-wrapper').style.display = 'none';
//         }
        
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
