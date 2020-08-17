<div class="settings estore_admin_popup_form sesbasic_bxs">
  <?php echo $this->form->render($this) ?>
</div>

<script type="text/javascript">

    en4.core.runonce.add(function() {
    sesJqueryObject('#location_type-wrapper').hide();
    sesJqueryObject('#state_id-wrapper').hide();
    sesJqueryObject('#tax_type').trigger('change');
        sesJqueryObject('#country_id').trigger('change');
});
    sesJqueryObject(document).on('change','input:radio[name="location_type"]:checked',function (e) {
      var value = sesJqueryObject(this).val();
      if(value == 1){
          sesJqueryObject('#state_id-wrapper').hide();
      }else{
          sesJqueryObject('#state_id-wrapper').show();
      }
    });
    var sendreq;
    sesJqueryObject(document).on('change','#country_id',function () {
      if(sesJqueryObject('#estore_loding_image').length)
        sesJqueryObject('#estore_loding_image').remove();
      sesJqueryObject(this).parent().append('<img src="application/modules/Estore/externals/images/ajax_loading.gif" id="estore_loding_image">');

      if(typeof sendreq != "undefined")
        sendreq.cancel();
        sendreq = new Request.HTML({
            method: 'post',
            'url': 'admin/estore/taxes/states',
            'data': {
                format: 'html',
                country_id: sesJqueryObject(this).val(),

            },
            onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
                sesJqueryObject('#estore_loding_image').remove();
                if(responseHTML){
                    sesJqueryObject('#state_id-wrapper').show();
                    sesJqueryObject('#state_id').html(responseHTML);
                    sesJqueryObject('#location_type-wrapper').show();
                    sesJqueryObject('input:radio[name="location_type"]:checked').trigger('change');
                }
            }
        });
    sendreq.send();

    });
sesJqueryObject(document).on('change','#tax_type',function () {
    if(sesJqueryObject(this).val()== 1){
        sesJqueryObject('#percentage_price-wrapper').show();
        sesJqueryObject('#fixed_price-wrapper').hide();
    }else{
        sesJqueryObject('#fixed_price-wrapper').show();
        sesJqueryObject('#percentage_price-wrapper').hide();
    }
})
  sesJqueryObject(document).on('click','.remove-elem',function () {
      sesJqueryObject(this).parent().remove();
      if (maxRegions && sesJqueryObject('.input-estore-elem').length < maxRegions) {
          sesJqueryObject('#addStatesBox').show();
      }
  });
</script>