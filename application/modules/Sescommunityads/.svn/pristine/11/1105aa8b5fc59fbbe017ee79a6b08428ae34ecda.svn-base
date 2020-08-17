function sescommMapSearch() {
  var input = document.getElementById('locationSesList');
  var autocomplete = new google.maps.places.Autocomplete(input);
  google.maps.event.addListener(autocomplete, 'place_changed', function () {
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }
    document.getElementById('lngSesList').value = place.geometry.location.lng();
    document.getElementById('latSesList').value = place.geometry.location.lat();
  });
}
sesJqueryObject(document).on('click','.sescomm_hide_ad',function(e){ alert('121');
  sesJqueryObject(this).closest('.sescmads_ads_item_img').hide();
  if(sesJqueryObject('.sescmads_bannerad_display')) {
    sesJqueryObject('.sescmads_bannerad_display').hide();
    sesJqueryObject(this).closest('.sescmads_bannerad_item').find('.sescmads_hidden_ad').show();
  }
  sesJqueryObject(this).closest('.sescmads_ads_listing_item').find('.sescmads_hidden_ad').show();
});

sesJqueryObject(document).on('change','input[name="ad-option-spam"]',function(e){
  var value = sesJqueryObject(this).val();
  sesJqueryObject(this).closest('._ad_hidden_options').find('.sescomm_other').hide();
  if(value == "Other"){
    sesJqueryObject(this).closest('._ad_hidden_options').find('.sescomm_other').show();
    return;
  }
  sendRequestReport(value,'',this);
});
sesJqueryObject(document).on('click','.sescomm_report_other_smt',function(){
  if(sesJqueryObject(this).hasClass('active'))
    return;
  sesJqueryObject(this).addClass('active');
  var value = 'Other';
  var text = sesJqueryObject(this).closest('.sescmads_ads_item_img').find('.sescomm_other').find('textarea').val();
  sendRequestReport(value,text,this);
})
function sendRequestReport(value,text,elem){
   sesJqueryObject(elem).closest('.sescmads_ads_item_img').hide();
   sesJqueryObject(elem).closest('.sescmads_ads_listing_item').find('.sescmads_hidden_ad').hide();
   sesJqueryObject(elem).closest('.sescmads_ads_listing_item').find('.sescmads_hidden_ad').hide();
   sesJqueryObject(elem).closest('.sescmads_ads_listing_item').find('.sescomm_report_success').show();
   sesJqueryObject(elem).closest('.sescmads_ads_listing_item').find('.sescomm_report_success').find('.loading_img').show();
   sesJqueryObject(elem).closest('.sescmads_ads_listing_item').find('.sescomm_report_success').find('.success_message').hide();
   var sescommunityad_id = sesJqueryObject(elem).closest('.sescmads_ads_listing_item').attr('rel');
   sesJqueryObject.post("sescommunityads/ajax/report",{value:value,text:text,sescommunityad_id:sescommunityad_id},function(re){
      sesJqueryObject(elem).closest('.sescmads_ads_listing_item').find('.sescomm_report_success').find('.loading_img').hide();
      sesJqueryObject(elem).closest('.sescmads_ads_listing_item').find('.sescomm_report_success').find('.success_message').show();
   });
}
sesJqueryObject(document).on('click','.sescomm_undo_ad',function(){
  sesJqueryObject(this).closest('.sescmads_ads_listing_item').find('.sescmads_ads_item_img').show();
  sesJqueryObject(this).closest('.sescmads_ads_listing_item').find('.sescmads_hidden_ad').hide();
  if(sesJqueryObject('.sescmads_bannerad_display')) {
    sesJqueryObject('.sescmads_bannerad_display').show();
    sesJqueryObject(this).closest('.sescmads_bannerad_item').find('.sescmads_hidden_ad').hide();
  }
});
sesJqueryObject(document).on('click','.sescomm_useful_ad',function(e){
  var selected = sesJqueryObject(this).hasClass('active');
  var selectedText = sesJqueryObject(this).attr('data-selected');
  var unselectedText = sesJqueryObject(this).attr('data-unselected');
  if(selected == true){
    sesJqueryObject(this).html(selectedText);
    sesJqueryObject(this).removeClass('active');
  }else{
    sesJqueryObject(this).html(unselectedText);
    sesJqueryObject(this).addClass('active');
  }
  var sescommunityad_id = sesJqueryObject(this).closest('.sescmads_ads_listing_item').attr('rel');
  sesJqueryObject.post("sescommunityads/ajax/useful",{sescommunityad_id:sescommunityad_id},function(re){
  });
});
function displayCommunityadsCarousel(){
  if(!sesJqueryObject('.sescmads_display_ad_carousel').length)
    return;
  var elem = sescommunityadsJqueryObject('.sescmads_display_ad_carousel');
  elem.each(function(index){
    if(!sescommunityadsJqueryObject(this).hasClass('.sescmads_display_ad_carousel_add')){
      sescommunityadsJqueryObject(this).owlCarousel({
        nav : true,
        loop:false,
        items:1,
        navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
      })
      sesJqueryObject(this).addClass('sescmads_display_ad_carousel_add');
    }
  });
}
