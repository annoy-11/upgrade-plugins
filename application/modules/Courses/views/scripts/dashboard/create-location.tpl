<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: create-location.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
  <?php echo $this->form->render($this) ?>
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
          sesJqueryObject('#state_id-wrapper').show();
      }else{
          sesJqueryObject('#state_id-wrapper').hide(); 
      }
    });
    var sendreq;
    sesJqueryObject(document).on('change','#country_id',function () {
      if(sesJqueryObject('#courses_loding_image').length)
        sesJqueryObject('#courses_loding_image').remove();
      sesJqueryObject(this).parent().append('<img src="application/modules/Courses/externals/images/ajax_loading.gif" id="courses_loding_image">');

      if(typeof sendreq != "undefined")
        sendreq.cancel();
        sendreq = new Request.HTML({
            method: 'post',
            'url': "<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'states'), 'courses_dashboard', true); ?>",
            'data': {
                format: 'html',
                country_id: sesJqueryObject(this).val(),
            },
            onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
                sesJqueryObject('#courses_loding_image').remove();
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
      if (maxRegions && sesJqueryObject('.input-courses-elem').length < maxRegions) {
          sesJqueryObject('#addStatesBox').show();
      }
  });
</script>
