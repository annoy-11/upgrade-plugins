<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create-slide.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sesproduct', array(
	'product' => $this->product,
      ));	
?>
	<div class="estore_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
    	<div class="estore_dashboard_form">
      <div class="sesproduct_seo_add_product">
    		<?php echo $this->form->render() ?>
      </div>
    
<?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
</div>
<?php  } ?>
<script type="application/javascript">

sesJqueryObject('#type').change(function(e){
  var value = sesJqueryObject(this).val();
  if(value == 1){
     sesJqueryObject('#file-label').find('label').removeClass('required');
     sesJqueryObject('#url-label').find('label').addClass('required');
     sesJqueryObject('#url-wrapper').show();
  }  else{
    sesJqueryObject('#url-wrapper').hide();
    sesJqueryObject('#url-label').find('label').removeClass('required');
    sesJqueryObject('#file-label').find('label').addClass('required');  
  }
})
sesJqueryObject('#url-wrapper').hide();
var ignoreValidation = window.ignoreValidation = function() {
      $('submit').style.display = "block";
      $('validation').style.display = "none";
      $('ignore').value = true;
    }
sesJqueryObject("#url").on("change keyup paste", function() {
    if(sesJqueryObject(this).val() == "")
      return;
    
    var url_element = document.getElementById("url-element");
    var myElement = new Element("p");
    myElement.innerHTML = "test";
    myElement.addClass("description");
    myElement.id = "validation";
    myElement.style.display = "none";
    url_element.appendChild(myElement);  
    
    var validationUrl = '<?php echo $this->url(array('module' => 'sesproduct', 'controller' => 'index', 'action' => 'validation'), 'default', true) ?>';
    var validationErrorMessage = "<?php echo $this->translate("We could not find a video there - please check the URL and try again. If you are sure that the URL is valid, please click %s to continue.", "<a href='javascript:void(0);' onclick='javascript:ignoreValidation();'>".$this->translate("here")."</a>"); ?>";

    var checkingUrlMessage = '<?php echo $this->string()->escapeJavascript($this->translate('Checking URL...')) ?>';

    new Request.JSON({
      'url' : validationUrl,
      'data' : {
        'format': 'json',
        'uri' : sesJqueryObject(this).val(),
        'type' : 'iframely',
      },
      'onRequest' : function() {
        $('validation').style.display = "block";
        $('validation').innerHTML = checkingUrlMessage;
        $('submit').style.display = "none";
      },
      'onSuccess' : function(response) {
        if( response.valid ) {
          $('submit').style.display = "block";
          $('validation').style.display = "none";
          //$('code').value = response.iframely.code;
          if($('title').value == "")
            $('title').value = response.iframely.title;
          if($('description').value == "")
            $('description').value = response.iframely.description;
          $('validation').value = "none";
        } else {
          $('submit').style.display = "none";
          $('validation').innerHTML = validationErrorMessage;
        }
      }
    }).send();  
});

</script>
<?php if($this->is_ajax) die; ?>
