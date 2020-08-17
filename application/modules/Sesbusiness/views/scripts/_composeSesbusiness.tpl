<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _composeSesbusiness.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(!Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) { return; ?>
<?php } ?>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbusiness/externals/scripts/composer_sesbusiness.js');
?>
<script type="application/javascript">
en4.core.runonce.add(function() {
    composeInstance.addPlugin(new Composer.Plugin.Sesbusiness({
      title: '<?php echo $this->string()->escapeJavascript($this->translate('Add Business')) ?>',
      lang : {
        'cancel' : '<?php echo $this->string()->escapeJavascript($this->translate('cancel')) ?>',
      },
    }));
  });
  
function addBusinessTag(){
  
  new Autocompleter.Request.JSON('tag_business_input', '<?php echo $this->url(array('module' => 'sesbusiness', 'controller' => 'index', 'action' => 'suggest-business'), 'default', true) ?>', {
    'minLength': 1,
    'delay' : 250,
    'selectMode': 'pick',
    'autocompleteType': 'message',
    'multiple': false,
    'className': 'sesadvactivity_autosuggest',
    'filterSubset' : true,
    'tokenFormat' : 'object',
    'tokenValueKey' : 'label',
    'cache': false,
    'injectChoice': function(token){
      if(token.type == 'user'){
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
      else {
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
        
    },
    onPush : function(choice){
      var elemSpan = sesJqueryObject('#toValues-element > span');
      var firstElem = elemSpan.eq(elemSpan.length - 1);
      var firstElemText = firstElem.text();
      var html = '';
      var elem = firstElemText.replace(' x','');
      var id = firstElem.attr('id').replace('tospan_'+elem+"_",'');
      html = '<a href="javascript:;" class="sesbusiness_clk">'+firstElemText.replace('x','')+'</a>';
      sesJqueryObject('#sesact_post_tags_sesadv').css('display', 'block');
      sesJqueryObject('#sesbusiness_elem_act').html('in '+html);
      sesJqueryObject('#sesbusiness_elem_act').show();
      sesJqueryObject('#dash_elem_act').show();
      elemSpan.eq(elemSpan.length - 1).remove();
      var setHtml = '<div id="sesbusiness-element"><span id="tospan_'+elem+'_'+id+'" class="tag">'+elem+' <a href="javascript:void(0);" onclick="this.parentNode.destroy();removeFromSesbusiness(&quot;'+id+'&quot;, &quot;toValues&quot;);">x</a></span></div>';
      sesbusinessContentSelected = setHtml;
      sesJqueryObject('.sesbusiness_post_tags_holder').prepend(setHtml);
      sesJqueryObject('.sesbusiness_post_tag_input').hide();
      sesJqueryObject('#businessValues').val(id);
      var value = sesJqueryObject('#toValues').val();
      var splitedVal = value.split(",");
      if(splitedVal.length == 1){
          sesJqueryObject('#toValues').val('');
      }else{
          var newVal = splitedVal.shift()
          sesJqueryObject('#toValues').val(newVal);
      }
    }
  });
 
  new Composer.OverText($('tag_business_input'), {
    'textOverride' : '<?php echo $this->translate('') ?>',
    'element' : 'label',
    'isPlainText' : true,
    'positionOptions' : {
      position: ( en4.orientation == 'rtl' ? 'upperRight' : 'upperLeft' ),
      edge: ( en4.orientation == 'rtl' ? 'upperRight' : 'upperLeft' ),
      offset: {
        x: ( en4.orientation == 'rtl' ? -4 : 4 ),
        y: 2
      }
    }
  });

}
sesJqueryObject(document).on('click','.sesbusiness_clk',function(){
    
});
 function removeFromSesbusiness(id){
    sesJqueryObject('#businessValues').val('');
    sesJqueryObject('.sesbusiness_post_tags_holder').find('#sesbusiness-element').remove();
    sesJqueryObject('.sesbusiness_post_tag_input').show();
    sesJqueryObject('#sesbusiness_elem_act').hide();
    if(sesJqueryObject('#tag_friend_cnt').css('display') == 'none' && sesJqueryObject('#location_elem_act').css('display') == 'none') {
      sesJqueryObject('#dash_elem_act').hide();
      sesJqueryObject('#sesact_post_tags_sesadv').hide();
    }
    sesbusinessContentSelected = "";
  }
  sesJqueryObject(document).on('click','.sesbusiness_clk',function(e){
    if(sesJqueryObject(this).hasClass('_active')){
      sesJqueryObject(this).removeClass('_active')
      sesJqueryObject('.sesact_post_business_container').show(); 
    }  else{
      sesJqueryObject(this).addClass('_active')
     sesJqueryObject('.sesact_post_business_container').hide();    
    }
  })
</script>
