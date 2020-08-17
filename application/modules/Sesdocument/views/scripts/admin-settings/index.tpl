
<?php include APPLICATION_PATH .  '/application/modules/Sesdocument/views/scripts/dismiss_message.tpl';
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
?>

<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script type="application/javascript">

  window.addEvent('domready', function() {
    hideshow("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.extensions', 1); ?>");
    showHideDescription("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.description.enable', 1); ?>");
    showHideCategory("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.category.enable', 1); ?>");
  });
  
  function hideshow(value) {
    if(value == 0){
        document.getElementById('sesdocument_extensionstype-wrapper').style.display = 'block';
    }else{
        document.getElementById('sesdocument_extensionstype-wrapper').style.display = 'none';		
    }
  }
  
  function showHideDescription(value) {
    if(value == 0){
        document.getElementById('sesdocument_description_mandatory-wrapper').style.display = 'none';
    }else{
        document.getElementById('sesdocument_description_mandatory-wrapper').style.display = 'block';		
    }
  }
  
  function showHideCategory(value) {
    if(value == 0){
        document.getElementById('sesdocument_category_mandatory-wrapper').style.display = 'none';
    }else{
        document.getElementById('sesdocument_category_mandatory-wrapper').style.display = 'block';		
    }
  }

// sesJqueryObject(document).on('change','input[type=radio][name=sesdocument_extensions]',function(){
//     var value = sesJqueryObject(this).val();
//     if(value == 1){
//         sesJqueryObject('#sesdocument_extensions_type-wrapper').show();
//     }else{
//         sesJqueryObject('#sesdocument_extensions_type-wrapper').hide();
//      }
// });
// 
// sesJqueryObject(document).ready(function(e){
//   sesJqueryObject('input[type=radio][name=sesdocument_extensions]:checked').trigger('change');    
// });

</script>
