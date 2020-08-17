<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: addnewuseringroup.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Emessages/externals/styles/styles.css'); ?>
<div class="emessages_popup emessages_addmember_popup sesbasic_bxs">
  <?php echo $this->form->setAttrib('class', 'emessages_popup_form')->render($this) ?>
</div>
<script type="application/javascript">
    sesJqueryObject("#addnewmemberform").submit(function () {
        var user_id = sesJqueryObject("#toValues").val();
        if (user_id.length > 0)
        {
            sesJqueryObject.ajax({
                url: en4.core.baseUrl+'emessages/messages/adduseringroup',
                method: "POST",
                data: {user_id: user_id,group_id: '<?php echo $this->groupid; ?>'},
                success: function (html) {
                    var arrays = jQuery.parseJSON(html);
                    if(parseInt(arrays['status'])==1)
                    {
                        parent.location.reload();
                        parent.Smoothbox.close();
                    }
                }
            });
        }
        else
        {
            alert('Please select user.');
            return false;
        }
    });

    function removeFromToValue(id) {
        // code to change the values in the hidden field to have updated values
        // when recipients are removed.
        var toValues = $('toValues').value;
        var toValueArray = toValues.split(",");
        var toValueIndex = "";

        var checkMulti = id.search(/,/);

        // check if we are removing multiple recipients
        if (checkMulti!=-1){
            var recipientsArray = id.split(",");
            for (var i = 0; i < recipientsArray.length; i++){
                removeToValue(recipientsArray[i], toValueArray);
            }
        }
        else{
            removeToValue(id, toValueArray);
        }

        // hide the wrapper for usernames if it is empty
        if ($('toValues').value==""){
            $('toValues-wrapper').setStyle('height', '0');
        }

        $('to').disabled = false;
    }

    function removeToValue(id, toValueArray){
        for (var i = 0; i < toValueArray.length; i++){
            if (toValueArray[i]==id) toValueIndex =i;
        }

        toValueArray.splice(toValueIndex, 1);
        $('toValues').value = toValueArray.join();
    }
    maxRecipients=10;
    en4.core.runonce.add(function() {
            new Autocompleter.Request.JSON('to', '<?php echo $this->url(array('module' => 'emessages', 'controller' => 'messages', 'action' => 'suggest','messages' => true,'groupid'=>$this->groupid), 'default', true) ?>', {
                'minLength': 1,
                'delay' : 250,
                'selectMode': 'pick',
                'autocompleteType': 'message',
                'multiple': false,
                'className': 'sesbasic-autosuggest',
                'filterSubset' : true,
                'tokenFormat' : 'object',
                'tokenValueKey' : 'label',
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
                            'class': 'autocompleter-choices friendlist',
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
                onPush : function(){
                    if( $('toValues').value.split(',').length >= maxRecipients ){
                        $('to').disabled = true;
                    }
                }
            });
    });
</script>
