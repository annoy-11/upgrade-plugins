
<script type="text/javascript">
  var fetchLevelSettings = function(level_id) {
    window.location.href = en4.core.baseUrl + 'admin/sesdocument/settings/level/id/' + level_id;
    //alert(level_id);
  }
</script>
<?php include APPLICATION_PATH .  '/application/modules/Sesdocument/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this) ?>
  </div>

</div>

<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); ?>

<script type="application/javascript">

    sesJqueryObject(document).on('change','input[type=radio][name=highlight]',function(){
    var value = sesJqueryObject(this).val();
    if(value == 1){
        sesJqueryObject('#make_highlight-wrapper').show();
        sesJqueryObject('#max_highlight-wrapper').show();
    }else{
        sesJqueryObject('#make_highlight-wrapper').hide();
        sesJqueryObject('#max_highlight-wrapper').hide();;
     }
    })
    sesJqueryObject(document).ready(function(e){
    sesJqueryObject('input[type=radio][name=highlight]:checked').trigger('change');    
    });

</script>
