<?php

/**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Sesqa
 * @copyright  Copyright 2014-2020 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: edit-location.tpl 2016-07-23 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

?>
<?php
  echo $this->partial('dashboard/left-bar.tpl', 'sesqa', array('question' => $this->question)); 
  ?>

 <div class="sesbasic_dashboard_content sesbasic_dashboard_form sesqa_question_form">
		<?php echo $this->form->render($this);?>
  </div>
</div>
</div>
<script>
	 function iframelyurl() {
    var checkingUrlMessage = "Checking URL..."
    var url_element = document.getElementById("video-element");
    var myElement = new Element("p");
    myElement.innerHTML = "test";
    myElement.addClass("description");
    myElement.id = "validation";
    myElement.style.display = "none";
    url_element.appendChild(myElement);
  
    var url = $('video').value;
    if(url == '') {
      return false;
    }
    new Request.JSON({
      'url' : en4.core.baseUrl + '/sesqa/index/get-iframely-information',
      'data' : {
        'format': 'json',
        'uri' : url,
      },
      'onRequest' : function() {
        $('validation').style.display = "block";
        $('validation').innerHTML = checkingUrlMessage;
      },
      'onSuccess' : function(response) {
        if( response.valid ) {
          $('validation').style.display = "block";
          $('validation').innerHTML = '<?php echo $this->translate("Your url is valid."); ?>';
        } else {
          $('validation').style.display = "block";
          $('validation').innerHTML = '<?php echo $this->translate('We could not find a video there - please check the URL and try again.'); ?>';
        }
      }
    }).send();
  }

  function showMediaType(value){
      //photo
      if(value == "1"){
        sesJqueryObject('#photo-wrapper').show();
        sesJqueryObject('#video-wrapper').hide();
      }else{
        sesJqueryObject('#photo-wrapper').hide();
        sesJqueryObject('#video-wrapper').show();  
      }
    }
    en4.core.runonce.add(function() {
      if(sesJqueryObject('.form-options-wrapper').length){
        if(sesJqueryObject('.form-options-wrapper').children().length == 1){
            sesJqueryObject('#mediatype-wrapper').hide();
        }
        showMediaType(sesJqueryObject('input[name=mediatype]:checked').val()); 
      }
    })
</script>