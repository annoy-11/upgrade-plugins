<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create-shipping.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php if(!$this->is_ajax){ ?>
<?php echo $this->partial('dashboard/left-bar.tpl', 'estore', array('store' => $this->store));?>
<div class="estore_dashboard_content sesbm sesbasic_clearfix">
  <?php } ?>
  <div style="margin: 10px;">
    <a class="buttonlink sesbasic_icon_back  estore_dashboard_nopropagate_content backtoshippingmethods" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'shippings'), 'estore_dashboard', true); ?>"><?php echo $this->translate('Back to Shipping Methods');?></a>
  </div>
  <div class="estore_dashboard_form <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.create.form', 1)):?>estore_create_form<?php endif;?>">
    <?php echo $this->form->render() ?>
  </div>
  <?php if(!$this->is_ajax){ ?>
</div>
</div>
</div>
<?php  } ?>
<script type="application/javascript">
  function changeTypeShipping(value) {
    if(value == 1){
        //weight
        sesJqueryObject('#product-wrapper').hide();
        sesJqueryObject('#cost-wrapper').hide();
        sesJqueryObject('#weight-wrapper').show();

        sesJqueryObject('#price_type').append('<option value="2"><?php echo $this->translate("Per Unit Weight"); ?></option>')
        sesJqueryObject('#deduction_type-wrapper').hide();
    }else if(value == 2){
        //product and weight
        sesJqueryObject('#product-wrapper').show();
        sesJqueryObject('#cost-wrapper').hide();
        sesJqueryObject('#weight-wrapper').show();
        var children = sesJqueryObject('#price_type').children();
        if(children.length == 3){
            children.eq(2).remove();
        }
        sesJqueryObject('#deduction_type-wrapper').show();
    }else{
        //cost and weight
        sesJqueryObject('#product-wrapper').hide();
        sesJqueryObject('#cost-wrapper').show();
        sesJqueryObject('#weight-wrapper').show();
        var children = sesJqueryObject('#price_type').children();
        if(children.length == 3){
            children.eq(2).remove();
        }
        sesJqueryObject('#deduction_type-wrapper').hide();
    }
  }
  function changeDeductionType(value) {
      if(value == 1){
        sesJqueryObject('#price_type-wrapper').hide();
      }else{
          sesJqueryObject('#price_type-wrapper').show();
      }
  }
  function changePriceShipping(value) {
      if(value == 1){
          sesJqueryObject('#percentage_price-wrapper').show();
          sesJqueryObject('#fixed_price-wrapper').hide();
      }else{
          sesJqueryObject('#fixed_price-wrapper').show();
          sesJqueryObject('#percentage_price-wrapper').hide();
      }
  }

  sesJqueryObject(document).on('change','input:radio[name="location_type"]:checked',function (e) {
      var value = sesJqueryObject(this).val();
      if(value == 1){
          sesJqueryObject('#state_id-wrapper').hide();
      }else{
          sesJqueryObject('#state_id-wrapper').show();
      }
  });
  var sendreq;
  function changeCountriesShipping(value,obj) {
      if(value == 0){
          sesJqueryObject('#location_type-wrapper').hide();
          sesJqueryObject('#state_id-wrapper').hide();
      }else{
          if(sesJqueryObject('#estore_loding_image').length)
              sesJqueryObject('#estore_loding_image').remove();
          sesJqueryObject(obj).parent().append('<img src="application/modules/Estore/externals/images/ajax_loading.gif" id="estore_loding_image">');
          if(typeof sendreq != "undefined")
              sendreq.cancel();
          sendreq = new Request.HTML({
              method: 'post',
              'url': "<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'states'), 'estore_dashboard', true); ?>",
              'data': {
                  format: 'html',
                  country_id: value,
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
      }
  }
  function executeAfterLoad() {
      changePriceShipping(sesJqueryObject('#price_type').val());
      changeTypeShipping(sesJqueryObject('#types').val());
      changeDeductionType(sesJqueryObject('#deduction_type').val());
      changeCountriesShipping(sesJqueryObject('#country').val());
      executeAfterLoad = "";
  };
  en4.core.runonce.add(function() {
      executeAfterLoad();
  });
  var ajaxRequest;
  function submitShippingCreateForm(obj) {
      sesJqueryObject('#estore_loding_image').remove();
      sesJqueryObject(obj).find('#submit-element').append('<img src="application/modules/Estore/externals/images/ajax_loading.gif" id="estore_loding_image">');
      var formData = new FormData(obj);
      formData.append('is_ajax', 1);
      formData.append('submit_form',1);
      formData.append('id',"<?php echo !empty($this->shipping) ? $this->shipping->getIdentity() : ''; ?>")
      submitFormAjax = sesJqueryObject.ajax({
          type:'POST',
          url : "<?php echo $this->url(array('action'=>'create-shipping','store_id'=>$this->store->custom_url),'estore_dashboard',true); ?>",
          data:formData,
          cache:false,
          contentType: false,
          processData: false,
          success:function(response){
              if(sesJqueryObject('#estore_loding_image').length)
                  sesJqueryObject('#estore_loding_image').remove();
              if(response == 1){
                  sesJqueryObject('.backtoshippingmethods').trigger('click');
                  return;
              }else {
                  sesJqueryObject('.estore_dashboard_content').html(response);
              }

              executeAfterLoad();
          },
          error: function(data){
              //silence
          }
      });
      return false;
  }
</script>
<?php if($this->is_ajax) die; ?>
