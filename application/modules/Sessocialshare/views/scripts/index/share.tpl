<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: share.tpl 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php 
  $base_url = $this->layout()->staticBaseUrl;
  $this->headScript()
        ->appendFile($base_url . 'externals/autocompleter/Observer.js')
        ->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
        ->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
        ->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sessocialshare/externals/styles/styles.css'); ?>
<div class="sessocialshare_share_popup sesbasic_bxs">
  <div class="sessocialshare_share_popup_close">
    <a title="<?php echo $this->translate('Close'); ?>" href="javascript:void(0);" onclick="parent.Smoothbox.close();"><i class="fa fa-close"></i></a>
  </div>
  <div class='sessocialshare_share_popup_tabs'>
    <ul class="navigation">
      <li id="sessocialshare_shli" class="active">
        <a onclick="showContent('share');" href="javascript:void(0)"><?php echo $this->translate("Share"); ?></a>
      </li>
      <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialshare.enableseshare', 1)): ?>
      <li id="sessocialshare_soli">
        <a onclick="showContent('socialshare');" href="javascript:void(0)"><?php echo $this->translate("Social Share"); ?></a>
      </li>
      <?php endif; ?>
    </ul>
  </div>
  <div class="sesbasic_bxs">
    <div id="sessocialshare_share">
      <?php echo $this->form->setAttrib('class', 'global_form_popup')->render($this) ?>
      <div class="sharebox">
        <?php if( $this->attachment->getPhotoUrl() ): ?>
          <div class="sharebox_photo">
            <?php echo $this->htmlLink($this->attachment->getHref(), $this->itemPhoto($this->attachment, ''), array('target' => '_parent')) ?>
          </div>
        <?php endif; ?>
        <div>
          <div class="sharebox_title">
            <?php echo $this->htmlLink($this->attachment->getHref(), $this->attachment->getTitle(), array('target' => '_parent')) ?>
          </div>
          <div class="sharebox_description">
            <?php 
              if(Engine_Api::_()->sesbasic()->isModuleEnable(array('sesadvancedactivity')) && $this->attachment->getType() == 'activity_action' || $this->attachment->getType() == 'sesadvacancedtivity_action') {
                $content =  $this->getContent($this->attachment);
                echo $content[0].': '.$content[1];
              } else
                echo $this->attachment->getDescription();
            ?>
          </div>
        </div>
      </div>
    </div>
    <div id="sessocialshare_socialshare" style="display:none;">
      <?php echo $this->partial('_popUpSocialShareButtons.tpl','sessocialshare', array('type' => $this->type, 'id' => $this->id)); ?>
      <?php //echo $this->content()->renderWidget('sessocialshare.social-share'); ?>
    </div>
	</div>
</div>
<script type="text/javascript">


function showContent(value) {
  if(value == 'share') {
    if($('sessocialshare_share'))
      $('sessocialshare_share').style.display = 'block';
    if($('sessocialshare_socialshare'))
      $('sessocialshare_socialshare').style.display = 'none';
    $('sessocialshare_shli').addClass('active');
    $('sessocialshare_soli').removeClass('active');
  } else if(value == 'socialshare') {
    if($('sessocialshare_share'))
      $('sessocialshare_share').style.display = 'none';
    if($('sessocialshare_socialshare'))
      $('sessocialshare_socialshare').style.display = 'block';
    $('sessocialshare_shli').removeClass('active');
    $('sessocialshare_soli').addClass('active');
  }
  parent.Smoothbox.instance.doAutoResize();
}


//<![CDATA[
var toggleFacebookShareCheckbox, toggleTwitterShareCheckbox;
(function($$) {
  toggleFacebookShareCheckbox = function(){
      $$('span.composer_facebook_toggle').toggleClass('composer_facebook_toggle_active');
      $$('input[name=post_to_facebook]').set('checked', $$('span.composer_facebook_toggle')[0].hasClass('composer_facebook_toggle_active'));
  }
  toggleTwitterShareCheckbox = function(){
      $$('span.composer_twitter_toggle').toggleClass('composer_twitter_toggle_active');
      $$('input[name=post_to_twitter]').set('checked', $$('span.composer_twitter_toggle')[0].hasClass('composer_twitter_toggle_active'));
  }
})($$)
//]]>

  var contentAutocomplete;
  en4.core.runonce.add(function () {

    if (en4.user.viewer.id) {
      $("content_title-wrapper").style.display = 'none';
    }
    
    if('<?php echo $this->share_type ?>' != 0) {
      $("content_title-wrapper").style.display = 'block';
      
      var shareTypeVal = '<?php echo $this->share_type ?>';
      if(shareTypeVal == 'self_friend') {
        $('content_title').placeholder = 'Start typing friend name...';
      } else if(shareTypeVal == 'email') {
        $('content_title').placeholder = 'Enter Email Address';
      } else if(shareTypeVal == 'message') {
        $('content_title').placeholder = 'Start typing friend name...';
      }
      else {
        $('content_title').placeholder = 'Search...';
      }
    }
    
    contentAutocomplete = new Autocompleter.Request.JSON('content_title', "<?php echo $this->url(array('module' => 'sessocialshare', 'controller' => 'index', 'action' => 'getcontents'), 'default', true) ?>", {
        'postVar': 'text',
        'minLength': 1,
        'delay' : 250,
        'selectMode': 'pick',
        'autocompleteType': 'message',
        'customChoices': true,
        'filterSubset': true,
        'multiple': false,
        'className': 'sesbasic-autosuggest message-autosuggest',
        'postData': {
          'share_type': 'self_profile'
        },
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
        //$('content_id').value = selected.retrieve('autocompleteChoice').id;

        var shareItem = selected.retrieve('autocompleteChoice');
        if($('content_id').value) {
          var str = $('content_id').value;
          var split_str = str.split(",");
          var notAddagain = false;
          for (var i = 0; i < split_str.length; i++) {
            if (split_str[i] == shareItem.id) {
              notAddagain = true;
            }
          }

          if(notAddagain == false) {
            $('content_id').value = $('content_id').value+','+shareItem.id;
            var shareItemmyElement = new Element('span', {'id' : 'contentTitle_remove_'+shareItem.id, 'class' : 'sessocialshare_tag tag', 'html' :  shareItem.label  + ' <a href="javascript:void(0);" ' + 'onclick="removeFromToValue('+shareItem.id+');">x</a>'
            });
            $('content_title-wrapper').appendChild(shareItemmyElement);
            $('content_title-wrapper').setStyle('height', 'auto');
            $('content_title-element').addClass('dnone');
            $('content_title').value = '';
            parent.Smoothbox.instance.doAutoResize();
          }
        } else {
          $('content_id').value = shareItem.id;
          var shareItemmyElement = new Element('span', {'id' : 'contentTitle_remove_'+shareItem.id, 'class' : 'sessocialshare_tag tag', 'html' :  shareItem.label  + ' <a href="javascript:void(0);" ' + 'onclick="removeFromToValue('+shareItem.id+');">x</a>'
          });
          $('content_title-wrapper').appendChild(shareItemmyElement);
          $('content_title-wrapper').setStyle('height', 'auto');
          $('content_title-element').addClass('dnone');
          $('content_title').value = '';
          parent.Smoothbox.instance.doAutoResize();
        }
        


      });
  });
  
  function removeToValue(id, toValueArray){
    for (var i = 0; i < toValueArray.length; i++){
      if (toValueArray[i]==id) toValueIndex =i;
    }

    toValueArray.splice(toValueIndex, 1);
    $('content_id').value = toValueArray.join();
    parent.Smoothbox.instance.doAutoResize();
  }
  
  function removeFromToValue(id) {
  
    var toValues = $('content_id').value;
    var toValueArray = toValues.split(",");
    removeToValue(id, toValueArray);

    $('content_title-element').removeClass('dnone');
    if ($('contentTitle_remove_'+id)) {
      $('contentTitle_remove_'+id).destroy();
    }
    parent.Smoothbox.instance.doAutoResize();
  }

  function sessocialshareType(value) {

    if(value == 'self_profile') {
      $('content_title-wrapper').style.display = 'none';
    } else if(value == 'self_friend') {
      $('content_title-wrapper').style.display = 'block';
      $('content_title').placeholder = 'Start typing friend name...';
    } else if(value == 'email') {
      $('content_title-wrapper').style.display = 'block';
      $('content_title').placeholder = 'Enter Email Address';
    } else if(value == 'message') {
      $('content_title-wrapper').style.display = 'block';
      $('content_title').placeholder = 'Start typing friend name...';
    }
    else {
      $('content_title-wrapper').style.display = 'block';
      $('content_title').placeholder = 'Search...';
    }
    $('content_id').value = '';
    sesJqueryObject('.sessocialshare_tag').remove();
    contentAutocomplete.setOptions({
      'postData': {
        'share_type': value
      }
    });
    parent.Smoothbox.instance.doAutoResize();
  }

</script>