<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: show-container-type.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
?>
<div id="container-option" class="sespagebuilder_getcode_popup">
  <?php echo $this->form->render($this) ?>
</div>

<script type="text/javascript"> 

  function showCode() {
    
    var url = '<?php echo $this->url(Array('module' => 'sespagebuilder', 'controller' => 'admin-managetabs', 'action' => 'show-popup'), 'default') ?>';
    
    if (document.getElementById('container_type-0').checked)
      chooseValue = document.getElementById('container_type-0').value;
    if (document.getElementById('container_type-1').checked)
      chooseValue = document.getElementById('container_type-1').value;
    if (document.getElementById('container_type-2').checked) 
      chooseValue = document.getElementById('container_type-2').value;
    
    var short_code = '[tab_container_'+ '<?php echo $this->tab_id;?>_'+chooseValue+']';
    
    var request = new Request.HTML({
      url: url,
      data: {
        format: 'html',
        'short_code':short_code,
      },
      onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript) {	
	document.getElementById('container-option').innerHTML = '';   
	document.getElementById('container-option').innerHTML = responseHTML;   
      }
    });
    request.send();
  }
  
</script>