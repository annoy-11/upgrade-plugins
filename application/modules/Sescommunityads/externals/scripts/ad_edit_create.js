var promotePageContent = false;
sesJqueryObject(document).on('click','.sescommunityads_promote_a',function(){
  var rel = sesJqueryObject(this).attr('rel');
  if(rel == "promote_page_cnt"){
    promotePageContent = true;
    rel = "promote_content_cnt";
  }else
    promotePageContent = false;
  sesJqueryObject('#promote_cnt').val(rel);
 (sesJqueryObject('.sescommunity_create_cnt[rel=2]').show());
 sesJqueryObject('.sescommunity_create_cnt[rel=1]').hide();
});
function hideAllType(){
  sesJqueryObject('.hideall').hide();
}
function adType(){
  return sesJqueryObject('#promote_cnt').val();
}
sesJqueryObject(document).on('change','#communityAds_campaign',function(){
  if(sesJqueryObject(this).val() == 0){
    sesJqueryObject('.sescommunityads_select_content_title').show();
  }  else{
    sesJqueryObject('.sescommunityads_select_content_title').hide();
  }
});
sesJqueryObject(document).on('keyup','#campaign_name',function(e){
  var text = sesJqueryObject(this).val();
  if(text){
      sesJqueryObject('#campaign_name').css('border','');
  }else{
      sesJqueryObject('#campaign_name').css('border','1px solid red');
  }
});
var isRequestSendBoostPost = false;

sesJqueryObject(document).on('click','.sescommunityads_select_page',function(e){
  var id = sesJqueryObject(this).data('rel');
  var html = sesJqueryObject(this).html();
  sesJqueryObject(this).html('<i class="fa fa-circle-o-notch fa-spin"></i>');
  isRequestSendBoostPost = true;
  var $this = this;
  //get boost post data
  var request = new Request.HTML({
    url : '/sescommunityads/index/get-page-post-feed/id/'+id,
    data : {
      format : 'html',
    },
    evalScripts : true,
    onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript) {
      sesJqueryObject($this).html(html);
      sesJqueryObject('.sescommunityads_page_ad').removeClass('sescommunityads_page_ad');
      sesJqueryObject('button[data-rel='+id+']').addClass('sescommunityads_page_ad');
      sesJqueryObject('.sescommunityads_ad_preview').hide();
      sesJqueryObject('.sescmads_ad_preview_boost_post').show();
      sesJqueryObject('.sescmads_ad_preview_boost_post').html(responseHTML);
      sesJqueryObject('.ad_targetting').show();
      sesJqueryObject('.ad_scheduling').show();
      sesJqueryObject('.sescmads_create_main_left').show();
      sesJqueryObject('.sescommunityads_right_preview').show();
      sesJqueryObject('.sescmads_create_preview_image').hide();
      sesJqueryObject('.sescmads_create_preview_video').hide();
      sesJqueryObject('.sescmads_create_preview_carousel').hide();
      sesJqueryObject('.sescomm_footer_cnt').show();
    }
  });
  request.send();
})
sesJqueryObject(document).on('click','.boost_post_sescomm',function(e){
  sesJqueryObject('.sesboost_post_active').html(sesJqueryObject('.sesboost_post_active').attr('unselected-rel'));
  sesJqueryObject('.sesboost_post_active').removeClass('sesboost_post_active');
  sesJqueryObject(this).addClass('sesboost_post_active');
  sesJqueryObject(this).html(sesJqueryObject(this).attr('selected-rel'));
  return;
});
function sesCommBoostPost(elem){
  var id = sesJqueryObject('.sesboost_post_active').data('rel');
  if(!id){
      alert('Please Choose a Post to Boost it.');
      return;
  }
  var html = sesJqueryObject(elem).html();
  sesJqueryObject(elem).html('<i class="fa fa-circle-o-notch fa-spin"></i>');
  isRequestSendBoostPost = true;
  var $this = elem;
  //get boost post data
  var request = new Request.HTML({
    url : '/sescommunityads/index/get-boost-post-feed/id/'+id,
    data : {
      format : 'html',
    },
    evalScripts : true,
    onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript) {
      sesJqueryObject($this).html(html);
      sesJqueryObject('.sescommunityads_ad_preview').hide();
      sesJqueryObject('.sescmads_ad_preview_boost_post').show();
      sesJqueryObject('.sescmads_ad_preview_boost_post').html(responseHTML);
      sesJqueryObject('.ad_targetting').show();
      sesJqueryObject('.sescmads_create_main_left').show();
      sesJqueryObject('.ad_scheduling').show();
      sesJqueryObject('.boost_post_cnt').hide();
      sesJqueryObject('.sescommunityads_right_preview').show();
      sesJqueryObject('.sescomm_footer_cnt').show();
      sesJqueryObject('.sescmads_create_preview_image').hide();
      sesJqueryObject('.sescmads_create_preview_video').hide();
      sesJqueryObject('.sescmads_create_preview_carousel').hide();
    }
  });
  request.send();
}
//Edit and Back
function sescomm_back_btn(val){
 var visibleDiv = sesJqueryObject('.sescommunity_create_cnt:visible').attr('rel');
 var campaign = sesJqueryObject('#communityAds_campaign').val() == 0 && (!sesJqueryObject('#campaign_name').val() || sesJqueryObject('#campaign_name').val() == "");
 var category = true;
 if(sesJqueryObject('#category_id').length){
    if((!sesJqueryObject('#category_id').val() || sesJqueryObject('#category_id').val() == 0) && sesJqueryObject('#category_id').hasClass('mandatory')){
        category = false;
    }
 }

 if(visibleDiv == 2 && val == 3 && (campaign || !category))
 {
   if(campaign)
    sesJqueryObject('#campaign_name').css('border','1px solid red');
   if(!category)
    sesJqueryObject('#category_id').css('border','1px solid red');
    return;
 }else{
    sesJqueryObject('#campaign_name').css('border','');
    sesJqueryObject('#category_id').css('border','');
 }
 sesJqueryObject('.select_sescomm_content').hide();
 sesJqueryObject('.sescomm_promote_cnt').hide();
 sesJqueryObject('.sescomm_promote_website').hide();
  if(val == 3 && adType() == "boost_post_cnt"){
    sesJqueryObject('.sescmads_create_main_left').hide();
    sesJqueryObject('.ad_targetting').hide();
    sesJqueryObject('.ad_scheduling').hide();
    sesJqueryObject('.sescomm_footer_cnt').hide();
    sesJqueryObject('.sescommunityads_right_preview').hide();
    sesJqueryObject('.sescmads_create_preview_image').hide();
    sesJqueryObject('.sescmads_create_preview_video').hide();
    sesJqueryObject('.sescmads_create_preview_carousel').hide();
  }
  if(sesJqueryObject('#add_card').length){
    sesJqueryObject('.sescommunity_preview_sub_image').hide();
    if(sescommunityIsEditForm == "false"){
      sesJqueryObject('.sescommunity_preview_sub_image').find('a').find('img').attr('src',blankImage);
      sesJqueryObject('#add_card').prop('checked', false);
    }
    sesJqueryObject('.sescommunity_sponsored').hide();
  }
  contentTitleValue = "";
  if(val == 2 && sesJqueryObject('.sesboost_post_active').length){
    if(selectedBoostPostId == 0){
      sesJqueryObject('.sesboost_post_active').html(sesJqueryObject('.sesboost_post_active').attr('unselected-rel'));
      sesJqueryObject('.sesboost_post_active').removeClass('sesboost_post_active');
    }
    sesJqueryObject('.ad_targetting').hide();
    sesJqueryObject('.sescmads_create_main_left').hide();
    sesJqueryObject('.ad_scheduling').hide();
    sesJqueryObject('.sescomm_footer_cnt').hide();
    sesJqueryObject('.sescommunityads_ad_preview').show();
    sesJqueryObject('.sescmads_ad_preview_boost_post').hide();
    sesJqueryObject('.sescommunityads_right_preview').hide();
    sesJqueryObject('.sescmads_create_preview_image').hide();
    sesJqueryObject('.sescmads_create_preview_video').hide();
    sesJqueryObject('.sescmads_create_preview_carousel').hide();
    sesJqueryObject('.boost_post_cnt').show();
  }else if(val == 2 && sesJqueryObject('.sescommunityads_page_ad').length){
    sesJqueryObject('.sescommunityads_page_ad').removeClass('sescommunityads_page_ad');
    sesJqueryObject('.ad_targetting').hide();
    sesJqueryObject('.sescmads_create_main_left').hide();
    sesJqueryObject('.ad_scheduling').hide();
    sesJqueryObject('.sescomm_footer_cnt').hide();
    sesJqueryObject('.sescommunityads_ad_preview').show();
    sesJqueryObject('.sescmads_ad_preview_boost_post').hide();
    sesJqueryObject('.sescommunityads_right_preview').hide();
    sesJqueryObject('.sescmads_create_preview_image').hide();
    sesJqueryObject('.sescmads_create_preview_video').hide();
    sesJqueryObject('.sescmads_create_preview_carousel').hide();
  }else{
    for(i=1;i<6;i++)
      sesJqueryObject('.sescommunity_create_cnt[rel='+i+']').hide();
    sesJqueryObject('.sescommunity_create_cnt[rel='+val+']').show();
    hideAllType();
    sesJqueryObject('._preview_url').hide();
    if(adType() == "promote_website_cnt"){
      sesJqueryObject('._preview_url').show();
      sesJqueryObject('.promote_content_cnt').show();
      sesJqueryObject('.sescomm_promote_cnt').show();
      sesJqueryObject('.sescommunity_preview_sub_image').show();
      sesJqueryObject('.sescommunity_sponsored').show();
      sesJqueryObject('.sescmads_create_main_left').show();
      sesJqueryObject('.sescmads_create_main_right').show();
      sesJqueryObject('.sescomm_footer_cnt').show();
       var value = sesJqueryObject('input[name=formate_type]:checked').attr('rel');
        if(value == "carousel_div"){
         sesJqueryObject('.sescmads_create_preview_carousel').show();
        }else if(value == "image_div"){
          sesJqueryObject('.sescmads_create_preview_image').show();
        }else if(value == "banner_div"){
          sesJqueryObject('.sescmads_create_preview_image').show();
        }
        else{
          sesJqueryObject('.sescmads_create_preview_video').show();
        }
    }
    if(adType() == "promote_content_cnt"){
      sesJqueryObject('.sescommunity_preview_sub_image').show();
      sesJqueryObject('.sescommunity_sponsored').show();
      sesJqueryObject('.sescmads_create_main_left').show();
      sesJqueryObject('.sescomm_promote_cnt').show();
      sesJqueryObject('.sescmads_create_main_right').show();
      sesJqueryObject('.sescomm_footer_cnt').show();
       var value = sesJqueryObject('input[name=formate_type]:checked').attr('rel');

        if(value == "carousel_div"){
         sesJqueryObject('.sescmads_create_preview_carousel').show();
        }else if(value == "image_div"){
          sesJqueryObject('.sescmads_create_preview_image').show();
        }else if(value == "banner_div"){
          sesJqueryObject('.sescmads_create_preview_image').show();
        }
        else{
          sesJqueryObject('.sescmads_create_preview_video').show();
        }
    }
    if(val == 3){
      if(adType() == "promote_content_cnt"){
        sesJqueryObject('.select_sescomm_content').show();
      }
      var valueElem = sesJqueryObject('#sescomm_resource_type').find('option[value=sespage_page]');
      sesJqueryObject('.'+sesJqueryObject('#promote_cnt').val()).show();
      if(pageContentAdded == true){
        if(valueElem.length)
          valueElem.remove();
        pageContentAdded = false;
      }
      var buttonLink = sesJqueryObject('.'+sesJqueryObject('#promote_cnt').val()).find('.tablinks').eq(0);
      if(buttonLink.length)
      buttonLink.trigger('click');

      if(promotePageContent == true){
        sesJqueryObject('#sescomm_resource_type').closest('.sescmads_create_campaign_field').hide();
        if(!valueElem.length){
            sesJqueryObject('#sescomm_resource_type').append('<option value="sespage_page">Page</option>');
            sesJqueryObject('#sescomm_resource_type').val('sespage_page');
            pageContentAdded = true;
        }
        sesJqueryObject('#sescomm_resource_type').val('sespage_page');
        sesJqueryObject('#sescomm_resource_type').trigger('change');
      }else{
        sesJqueryObject('#sescomm_resource_type').closest('.sescmads_create_campaign_field').show();
      }
      var relval = sesJqueryObject('input[name=formate_type]:checked').attr('rel');

      sesJqueryObject('.'+relval).show();

      if(relval == 'banner_div') {
        sesJqueryObject('.promote_website_cnt').hide();
        sesJqueryObject('.preview_header').hide();
        sesJqueryObject('._cont').hide();
        //Edit Banner Ads
        sesJqueryObject('.sescmads_create_preview_image').addClass('sescmads_create_preview_banner');
        var selectWidth = sesJqueryObject('select[name="banner_id"]').find(":selected").attr('data-width');
        var selectHeight = sesJqueryObject('select[name="banner_id"]').find(":selected").attr('data-height');
        sesJqueryObject('.sescomm_img').css("width", selectWidth).css('height', selectHeight);
        var bannerType = sesJqueryObject('input[name=banner_type]:checked').val();
        if(bannerType == 0) {
            sesJqueryObject('#banner_image').hide();
            sesJqueryObject('#banner_url').hide();
            sesJqueryObject('#banner_html_code').show();
        } else {
            sesJqueryObject('#banner_image').show();
            sesJqueryObject('#banner_url').show();
            sesJqueryObject('#banner_html_code').hide();
        }
      } else {
        //Check for website type ads create
        if(adType() == 'promote_website_cnt') {
            sesJqueryObject('.promote_website_cnt').show();
        }
        sesJqueryObject('.preview_header').show();
        sesJqueryObject('._cont').show();
        sesJqueryObject('.sescmads_create_preview_image').removeClass('sescmads_create_preview_banner');
        sesJqueryObject('.sescomm_img').css("width", '').css('height', '');
      }

      if(adType() == 'promote_content_cnt') {
        if(sesJqueryObject('#banner_select_option')) {
            sesJqueryObject('#banner_select_option').hide();
        }
      } else if(adType() == 'promote_website_cnt') {
        if(sesJqueryObject('#banner_select_option')) {
            sesJqueryObject('#banner_select_option').show();
        }
      }
   }
  }

}
var pageContentAdded = false;
sesJqueryObject(document).on('change','input[name=formate_type]',function(e){



    if(sesJqueryObject(this).closest('li').hasClass('active'))
      return;
    sesJqueryObject('.sescommerror').remove();
    var relval = sesJqueryObject(this).attr('rel');

    var currentType = sesJqueryObject(this).closest('li').parent().find('li.active').find('input').attr('rel');
    console.log(currentType);
    var items = sesJqueryObject('.'+currentType).find('input, textarea, select');
    for(i=0;i<items.length;i++){
      if(sesJqueryObject(items[i]).val()){
        if(!confirm('Changes that you made may not be saved.'))
          return;
        break;
      }
    }
    sesJqueryObject('#add_card').prop('checked', false);
    sesJqueryObject(this).closest('li').parent().find('li').removeClass('active');
    sesJqueryObject(this).closest('li').addClass('active');
    sesJqueryObject('.promote_content_cnt').find('.hideall').hide();
    sesJqueryObject('.'+relval).show();
    sesJqueryObject('#sescomm_video_div').hide();
    sesJqueryObject('._preview_content_img').find('img').hide();
    sesJqueryObject('#sescomm_video_div').attr('src','');
    if(relval == "carousel_div"){
      sesJqueryObject('.sescmads_create_preview_carousel').show();
      sesJqueryObject('.sescmads_create_preview_video').hide();
      sesJqueryObject('.sescmads_create_preview_image').hide();
      sesJqueryObject('._preview_content_img').find('img').show();
      sesJqueryObject('.sescommunity_preview_content').append(sesJqueryObject('.sescommunity_preview_content').find('.sescommunity_preview_cnt').clone());
    }else{
      if(relval == "video_div"){
        sesJqueryObject('.sescmads_create_preview_video').show();
        sesJqueryObject('.sescmads_create_preview_carousel').hide();
        sesJqueryObject('.sescmads_create_preview_image').hide();
        sesJqueryObject('#sescomm_video_div').show();
        sesJqueryObject('#sescomm_video_div').attr('src',sesJqueryObject('#sescomm_video_div').attr('data-original'));
      }else{ console.log('1');
        sesJqueryObject('.sescmads_create_preview_image').show();
        sesJqueryObject('.sescmads_create_preview_video').hide();
        sesJqueryObject('.sescmads_create_preview_carousel').hide();
        sesJqueryObject('._preview_content_img').find('img').show();
      }
      sesJqueryObject('.removecarousel').trigger('click');
      sesJqueryObject('.sescommunity_preview_content').find('.sescommunity_preview_cnt').eq(1).remove();
    }
    //Banner Ads Work
    if(relval == "banner_div") {
        if(sesJqueryObject('._cont')){
            sesJqueryObject('._cont').hide();
        }
    } else {
        if(sesJqueryObject('._cont')){
            sesJqueryObject('._cont').show();
        }
    }
    if(sescommunityIsEditForm == "false"){
      sesJqueryObject('.'+currentType).find('input, select, textarea').val('');
      sesJqueryObject('.'+currentType).find('input, select, textarea').trigger('change');
      //sesJqueryObject('.sescommunityads_carousel_title').html(sesJqueryObject('.sescommunityads_carousel_title').data('original'));
      sesJqueryObject('span._preview_title').html(sesJqueryObject('span._preview_title').data('original'));
      sesJqueryObject('span._preview_des').html(sesJqueryObject('span._preview_des').data('original'));
    }
});
sesJqueryObject(document).on('click','.sescustom_field_a',function(e){
  var valueField = sesJqueryObject(this).attr('rel');
  sesJqueryObject('.sescustom_active').removeClass('sescustom_active');
  sesJqueryObject(this).parent().addClass('sescustom_active');
  sesJqueryObject('.form-elements').find('.form-wrapper').hide();
  if(valueField != "sescommunity_network_targetting"){
    sesJqueryObject('.sesprofile_field_'+valueField).closest('.form-wrapper').show();
    sesJqueryObject('#sescustom_fields').show();
    sesJqueryObject('.sescommunity_network_targetting').hide();
  }else{
    sesJqueryObject('#sescustom_fields').hide();
    sesJqueryObject('.sescommunity_network_targetting').show();
  }
});
var runOnceScriptSescomm =  true;
var changeSescommFormOption = false;
function defaultRunSescommunityads(){
  sesJqueryObject('.sescustom_field_a').closest('ul').children().eq(0).find('a').trigger('click');
  if(runOnceScriptSescomm == true){
    changeSescommFormOption = true;
    sesJqueryObject(document).on('keyup','input, textarea',function(){
      if(sesJqueryObject('.ads_preview_page').css('display') == "block"){
       //changeSescommFormOption = false;
       if(sesJqueryObject(this).val() != ""){
          sesJqueryObject(this).parent().find('.sescommerror').remove();
       }else{
          //sesJqueryObject(this).parent().append('<div class="sescommerror">'+errorMessageSescomm+'</div>');
       }
      }
    });
    sesJqueryObject(document).on('change','input[type=file], select:not(.cat)',function(){
      if(sesJqueryObject(this).val() != ""){
          sesJqueryObject(this).parent().find('.sescommerror').remove();
       }else{
          if(!sesJqueryObject(this).parent().find('.sescommerror').length)
          sesJqueryObject(this).parent().append('<div class="sescommerror">'+errorMessageSescomm+'</div>');
       }
    });
    runOnceScriptSescomm = false;
  }
}
function getBoostPostData(value){
  //get boost post data
  var action_id = "";
  if(selectedBoostPostId != 0){
    action_id = 1;
  }
    if(!value)
        value = 0
  var request = new Request.HTML({
    url : '/sescommunityads/index/get-boost-post-activity/selected/'+value+'/is_action_id/'+action_id,
    data : {
      format : 'html',
    },
    evalScripts : true,
    onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript) {
      sesJqueryObject('#sescmads_select_post_overlay').remove();
      sesJqueryObject('.sescmads_select_post').append(responseHTML);
      if(selectedBoostPostId != 0){
        sesJqueryObject('#sescommunityads_boost_feed_viewmore').hide();
      }
    }
  });
 request.send();
}
sesJqueryObject(document).on('click','.boost_post_sescomm',function(e){
  var actionid = sesJqueryObject(this).attr('data-rel');
  var request = new Request.HTML({
    url : '/sescommunityads/index/get-activity',
    data : {
      format : 'html',
      action_id:actionid,
    },
    evalScripts : true,
    onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript) {
      //insert activity id in html preview div
      if(responseHTML === 0){
        alert('<?php echo $this->translate("Please select valid post to boost"); ?>');
      }else{
        sesJqueryObject('.sescommunityads_boostpost_popup_preview').html('<div class="sesact_feed sesbasic_bxs sesbasic_clearfix"><ul class="feed sesbasic_clearfix sesbasic_bxs sescommunityads_feed">'+responseHTML+"</ul><div class='sescommunityads_feed_preview_overlay'></div></div>");
        sesJqueryObject('.sescommunityads_feed').find('.sesadvcmt_comments').hide();
      }
    }
  });
  request.send();
});
function clickAElement(obj){
  sesJqueryObject('.sescomm_active').removeClass('sescomm_active');
  sesJqueryObject(obj).parent().addClass('sescomm_active');
  var rel = sesJqueryObject(obj).attr('data-rel');
  sesJqueryObject('.sescommunityads_choose').find('.sescomm_carousel_img').hide();
  sesJqueryObject('.sescommunityads_choose').find('.sescomm_carousel_img').eq(rel - 1).show();
  sescommunityadsJqueryObject('.sescmads_create_carousel').trigger('to.owl.carousel', rel - 1);
}
sesJqueryObject(document).on('click','#sescomm_ad_car_li > li > a',function(){
  clickAElement(this);
});
sesJqueryObject(document).on('click','#add-media',function(e){
  var totalLi = sesJqueryObject('#sescomm_ad_car_li').children().length;
  if(totalLi === 9){
    sesJqueryObject(this).hide();
  }
  var length = totalLi+1;
  sesJqueryObject('#sescomm_ad_car_li').append('<li class=""><a href="javascript:;" data-rel="'+length+'">'+length+'</a></li>');
  sesJqueryObject('.sescommunityads_choose').append(sesJqueryObject('.sescommunityads_choose').find('.sescomm_carousel_img').eq(0).clone());
  var insertedDiv = sesJqueryObject('.sescommunityads_choose').find('.sescomm_carousel_img').length - 1;
  var lastDivElement = sesJqueryObject('.sescommunityads_choose').find('.sescomm_carousel_img').eq(insertedDiv);
  sesJqueryObject(lastDivElement).prepend('<div class="sescmads_create_carousel_item_remove"><a href="javascript:;" class="removecarousel">Remove</a></div>');
  lastDivElement.hide();
  lastDivElement.find('input').val('');
  //add element after given index
  // adds an item before the first item
 var html = sesJqueryObject('.sescmads_create_preview_carousel').find('.sescomm_carousel_default').find('.sescmads_create_preview_item_item')[0].outerHTML
  //redo work for add before.
  if(sesJqueryObject('#add_card:checked').length){
    sescommunityadsJqueryObject('.sescmads_create_carousel')
      .trigger('add.owl.carousel', [html, insertedDiv])
      .trigger('refresh.owl.carousel');
  }else{
    sescommunityadsJqueryObject('.sescmads_create_carousel')
      .trigger('add.owl.carousel', [sescommunityadsJqueryObject(html)])
      .trigger('refresh.owl.carousel');
  }
});

sesJqueryObject(document).on('change','.add_comm_card',function(e){
  var checked = sesJqueryObject(this).is(":checked");
  var parent = sesJqueryObject(this).closest('.sescmads_create_fields');
  var moreElemData = sesJqueryObject('.sescmads_create_preview_carousel').find('.sescomm_carousel_default').find('.sescmads_create_preview_item_more')[0].outerHTML;
  var totalLi = sesJqueryObject('#sescomm_ad_car_li').children().length;
  var owlLi = sesJqueryObject('.sescmads_create_carousel').find('.owl-stage-outer').find('.owl-stage').find('.owl-item').length;
  if(checked == true){
      parent.find('.checkbox_val').show();
      sescommunityadsJqueryObject('.sescmads_create_carousel')
        .trigger('add.owl.carousel', [sescommunityadsJqueryObject(moreElemData)])
        .trigger('refresh.owl.carousel');
  }else if(owlLi > 2){
      sescommunityadsJqueryObject('.sescmads_create_carousel').trigger( 'remove.owl.carousel', [totalLi] ).trigger('refresh.owl.carousel');
      parent.find('.checkbox_val').hide();
      sesJqueryObject('.checkbox_val').find('input').val('');
  }
})
sesJqueryObject(document).on('click','.removecarousel',function(){
  var index = sesJqueryObject('.sescommunityads_choose').find('.sescomm_carousel_img').index(sesJqueryObject(this).closest('.sescomm_carousel_img'));
  var liEment = sesJqueryObject('#sescomm_ad_car_li').children();
  var trigger = false;
  if(liEment.eq(index).hasClass('sescomm_active'))
    trigger = true;
  liEment.eq(index).remove();
  sesJqueryObject('.sescommunityads_choose').find('.sescomm_carousel_img').eq(index).remove();
  var liEmentNew = sesJqueryObject('#sescomm_ad_car_li').children();
  for(i=0;i<liEmentNew.length;i++){
    sesJqueryObject(liEmentNew[i]).find('a').attr('data-rel',i+1);
    sesJqueryObject(liEmentNew[i]).find('a').html(i+1);
  }
  if(trigger == true)
    clickAElement(sesJqueryObject('#sescomm_ad_car_li').children().eq(0).find('a'));
  if(sesJqueryObject('#sescomm_ad_car_li').children().length < 10)
      sesJqueryObject('#add-media').show();
  //remove element from carousel
  sescommunityadsJqueryObject('.sescmads_create_carousel').trigger('remove.owl.carousel',index).trigger('refresh.owl.carousel');
});
sesJqueryObject(document).on('keyup','.sescommunityads_carousel_title_text',function(){
  if(sesJqueryObject(this).val())
    sesJqueryObject('.sescommunityads_carousel_title').html(sesJqueryObject(this).val());
  else
    sesJqueryObject('.sescommunityads_carousel_title').html(sesJqueryObject('.sescommunityads_carousel_title').data('original'));
});
function imagePreview(input){

  var className = "";
  if(sesJqueryObject(input).hasClass('more_image')){
    className = "more_image";
  }
  if(sesJqueryObject(input).hasClass('_website_main_img')){
    className = "_website_main_img";
  }
  if(sesJqueryObject(input).hasClass('video_image')){
      className = "video_image";
  }

  var value = sesJqueryObject('input[name=formate_type]:checked').attr('rel');

  var url = input.value;
  var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
  if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'gif' || ext == 'GIF')) {
      var reader = new FileReader();
      reader.onload = function (e) {

        //Banner Image Work
        if(value == 'banner_div') {
            var selectWidth = sesJqueryObject('select[name="banner_id"]').find(":selected").attr('data-width');
            var selectHeight = sesJqueryObject('select[name="banner_id"]').find(":selected").attr('data-height');
            var img = new Image();
            img.src = e.target.result;
            img.onload = function () {
                var width = this.width;
                var height = this.height;
                if (height > selectHeight && width > selectWidth) {
                    if(!sesJqueryObject(input).parent().find('.sescommerror').length){
                        sesJqueryObject(input).parent().append('<div class="sescommerror">'+en4.core.language.translate('You can choose image according to banner size.')+'</div>');
                        sesJqueryObject(input).val('');
                    }
                    isValidSescommForm = true;
                } else {
                    checkTypeAds('sescomm_img',e.target.result,className);
                }
            }
        } else {
            checkTypeAds('sescomm_img',e.target.result,className);
        }
      }
      reader.readAsDataURL(input.files[0]);
  }else{
      sesJqueryObject(input).val('');
      checkTypeAds('sescomm_img','',className);
  }
};
function findElementInOwlCarousel(){
  var index = sesJqueryObject('#sescomm_ad_car_li').children().index(sesJqueryObject('#sescomm_ad_car_li').find('.sescomm_active'));
  return sesJqueryObject('.sescmads_create_carousel').find('.owl-stage-outer').find('.owl-stage').find('.owl-item').eq(index).find('.sescmads_create_preview_item');
}

function changeHeightWidth(value) {
    var selectWidth = sesJqueryObject('select[name="banner_id"]').find(":selected").attr('data-width');
    var selectHeight = sesJqueryObject('select[name="banner_id"]').find(":selected").attr('data-height');
    sesJqueryObject('.sescomm_img').css("width", selectWidth).css('height', selectHeight);
}

function checkTypeAds(className,valueField,classMore){
    var typeAd = adType();

    if(typeAd == "promote_content_cnt" || typeAd == "promote_website_cnt"){
        var value = sesJqueryObject('input[name=formate_type]:checked').attr('rel');
        console.log(value);
        if(value == "carousel_div"){
          var elem = findElementInOwlCarousel();
          var parentElem = elem;
          if(typeAd == "promote_content_cnt"){
            sesJqueryObject('.sescmads_create_preview_carousel').find('.sescommunity_preview_sub_image').show();
            sesJqueryObject('.sescmads_create_preview_carousel').find('.sescommunity_sponsored').show();
            sesJqueryObject('.sescmads_create_preview_carousel').find('.sescommunity_preview_sub_image').find('a').find('image').attr('src',contentImageValue);
          }
          sesJqueryObject('.sescmads_create_preview_carousel').find('.preview_title').find('a').html(contentTitleValue);
        }else if(value == "video_div"){
          var parentElem = sesJqueryObject('.sescmads_create_preview_video');
        } else if(value == 'banner_div') {
            var parentElem = sesJqueryObject('.sescmads_create_preview_image');
            sesJqueryObject('.sescmads_create_preview_image').addClass('sescmads_create_preview_banner');
            var selectWidth = sesJqueryObject('select[name="banner_id"]').find(":selected").attr('data-width');
            var selectHeight = sesJqueryObject('select[name="banner_id"]').find(":selected").attr('data-height');
            sesJqueryObject('.sescomm_img').css("width", selectWidth).css('height', selectHeight);
        }
        else{
          var parentElem = sesJqueryObject('.sescmads_create_preview_image');
          sesJqueryObject('.sescmads_create_preview_image').removeClass('sescmads_create_preview_banner');
          sesJqueryObject('.sescomm_img').css("width", '').css('height', '');
        }
        if(typeAd == "promote_content_cnt"){
          sesJqueryObject(parentElem).find('.sescommunity_preview_sub_image').show();
          sesJqueryObject(parentElem).find('.sescommunity_sponsored').show();
          sesJqueryObject(parentElem).find('.sescommunity_preview_sub_image').find('a').find('image').attr('src',contentImageValue);
        }else if(typeAd == "promote_website_cnt"){
            contentTitleValue = sesJqueryObject('.website_title').val();
        }
        sesJqueryObject(parentElem).find('.preview_title').find('a').html(contentTitleValue);
        if(value == "carousel_div"){
          if(classMore == "_website_main_img"){
            sesJqueryObject('.sescommunity_sponsored').show();
            sesJqueryObject('.sescommunity_preview_sub_image').find('a').find('img').attr('src',valueField);
          }else if(classMore == "more_image"){
            var elem = sesJqueryObject('.sescmads_create_carousel').find('.owl-stage-outer').find('.owl-stage').find('.owl-item');
            var length = elem.length;
            var div = elem.eq(length - 1);
            div.find('._img').find('a').find('img').attr('src',valueField);
          }else if(className == "more_text"){
            var elem = sesJqueryObject('.sescmads_create_carousel').find('.owl-stage-outer').find('.owl-stage').find('.owl-item');
            var length = elem.length;
            var div = elem.eq(length - 1);
            div.find('._des').html(valueField);
          }else if(className != "sescomm_call_to_action" && className != "sescomm_img" && className != "sescomm_call_to_action_overlay")
            sesJqueryObject(parentElem).find('.'+className).html(valueField);
          else if(className == "sescomm_img"){
            if(valueField != ""){
              sesJqueryObject(parentElem).find('.'+className).find('a').find('img').attr('src',valueField);
            }else{
              sesJqueryObject(parentElem).find('.'+className).find('a').find('img').attr('src',blankImage);
            }
          }else if(className == "sescomm_call_to_action"){
            if(valueField != ""){
                var elem = sesJqueryObject('.sescmads_create_carousel').find('.owl-stage-outer').find('.owl-stage').find('.owl-item');
                elem.each(function(index){
                   if(sesJqueryObject(this).find('.sescmads_create_preview_item').find('.'+className).length){
                      sesJqueryObject(this).find('.sescmads_create_preview_item').find('.'+className).show();
                      sesJqueryObject(this).find('.sescmads_create_preview_item').find('.'+className).find('a').html(valueField);
                   }
                });
            }else{
                var elem = sesJqueryObject('.sescmads_create_carousel').find('.owl-stage-outer').find('.owl-stage').find('.owl-item');
                elem.each(function(index){
                   if(sesJqueryObject(this).find('.sescmads_create_preview_item').find('.'+className).length){
                      sesJqueryObject(this).find('.sescmads_create_preview_item').find('.'+className).hide();
                   }
                });
            }
          }else if(className == "sescomm_call_to_action_overlay"){
              if(valueField != ""){
                var elem = sesJqueryObject('.sescmads_create_carousel').find('.owl-stage-outer').find('.owl-stage').find('.owl-item');
                elem.each(function(index){
                   if(sesJqueryObject(this).find('.sescmads_create_preview_item').find('.'+className).length){
                      sesJqueryObject(this).find('.sescmads_create_preview_item').find('.'+className).show();
                      sesJqueryObject(this).find('.sescmads_create_preview_item').find('.'+className).html(valueField);
                   }
                });
            }else{
                var elem = sesJqueryObject('.sescmads_create_carousel').find('.owl-stage-outer').find('.owl-stage').find('.owl-item');
                elem.each(function(index){
                   if(sesJqueryObject(this).find('.sescmads_create_preview_item').find('.'+className).length){
                      sesJqueryObject(this).find('.sescmads_create_preview_item').find('.'+className).hide();
                   }
                });
            }
          }

        }else if(value == "image_div" || value == "video_div" || value == 'banner_div') {
            if(classMore == "video_image"){
                sesJqueryObject(parentElem).find('.'+className).attr('poster',valueField)
                return;
            }
          if(className != "sescomm_call_to_action" && className != "sescomm_img")
            sesJqueryObject(parentElem).find('.'+className).html(valueField);
          else if(classMore == "_website_main_img"){
            sesJqueryObject('.sescommunity_sponsored').show();
            sesJqueryObject('.sescommunity_preview_sub_image').find('a').find('img').attr('src',valueField);
          }
          else if(className == "sescomm_img" && (value == "image_div" || value == 'banner_div')){
            if(valueField != ""){
              sesJqueryObject(parentElem).find('.'+className).find('a').find('img').attr('src',valueField);
            }else{
              sesJqueryObject(parentElem).find('.'+className).find('a').find('img').attr('src',blankImage);
            }
          }else if(className == "sescomm_img" && value == "video_div"){
             sesJqueryObject(parentElem).find('.'+className).show();
            if(valueField != ""){
              sesJqueryObject(parentElem).find('.'+className).attr('src',valueField);
            }else{
              sesJqueryObject(parentElem).find('.'+className).attr('src',blankImage);
            }
          }else if (className == "sescomm_call_to_action"){
            if(valueField != ""){
                sesJqueryObject(parentElem).find('.'+className).show();
                sesJqueryObject(parentElem).find('.'+className).find('a').html(valueField);
            }else{
                sesJqueryObject(parentElem).find('.'+className).hide();
            }
          }
          if(value == 'banner_div') {
                sesJqueryObject('.promote_website_cnt').hide();
                sesJqueryObject('.preview_header ').hide();
          } else {
            //sesJqueryObject('.promote_website_cnt').show();
            //sesJqueryObject('.preview_header ').show();
          }
        }
    }else{

    }
}
sesJqueryObject(document).on('keyup','.sescommunity_content_text',function(){
  var className = sesJqueryObject(this).attr('class');
  className = className.replace('sescommunity_content_text ','').replace('required ','');
  className = className.trim();
  checkTypeAds(className,sesJqueryObject(this).val());
  if(sesJqueryObject(this).attr('id') == "website_url"){
    sesJqueryObject('._preview_url').show();
    var value = sesJqueryObject(this).val();
    if(value.indexOf('http://') > -1 || value.indexOf('https://') > -1){
      value = value.replace('http://','').replace('https://');
      var splial = value.split('/');
      sesJqueryObject('._preview_url').html(splial[0]);
    }else{
        sesJqueryObject('._preview_url').html('');
    }
  }else{
    sesJqueryObject('._preview_url').hide();
  }
});
sesJqueryObject(document).on('change','.sescomm_call_to_action',function(){
    var text = sesJqueryObject(this).find(':selected').text();
    if(sesJqueryObject(this).val()){
      checkTypeAds('sescomm_call_to_action',text)
    }else{
      checkTypeAds('sescomm_call_to_action','')
    }
});
sesJqueryObject(document).on('change','.sescomm_call_to_action_overlay',function(){
    var text = sesJqueryObject(this).find(':selected').text();
    if(sesJqueryObject(this).val()){
      checkTypeAds('sescomm_call_to_action_overlay',text);
    }else{
      checkTypeAds('sescomm_call_to_action_overlay','');
    }
});
function uploadVideoSescomm(obj){
  var $source = sesJqueryObject('#sescomm_video_div');
   var url = obj.value;
  var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
  if (obj.files && obj.files[0] && (ext == "mp4")) {
    checkTypeAds('sescomm_img',URL.createObjectURL(obj.files[0]));
  }else{
    sesJqueryObject(obj).val('');
    checkTypeAds('sescomm_img','');
  }
};
sesJqueryObject(document).on('click','.ad_end_date',function(){
  var isChecked = sesJqueryObject('.ad_end_date:checked').length;
  if(isChecked == 1){
    sesJqueryObject('.sescomm_end_date_div').hide();
    sesJqueryObject('#sescomm_end_date').val('').attr('readonly','readonly');
    sesJqueryObject('#sescomm_end_time').val('').attr('readonly','readonly');
  }else{
    sesJqueryObject('.sescomm_end_date_div').show();
    sesJqueryObject('#sescomm_end_date').removeAttr('readonly');
    sesJqueryObject('#sescomm_end_time').removeAttr('readonly');
  }
});

//time
sesJqueryObject(document).ready(function(){
  if(sesJqueryObject('#sescomm_start_date').length){
    sescommDateFn();
  }
});
 var sescommsesselectedDate;
 var sescommsesFromEndDate;
 function sescommDateFn(){
   sescommsesselectedDate = new Date(sesJqueryObject('#sescomm_start_date').val());
    sesBasicAutoScroll('#sescomm_start_time').timepicker({
        'showDuration': true,
        'timeFormat': 'g:ia',
    }).on('changeTime',function(){
      var lastTwoDigit = sesBasicAutoScroll('#sescomm_end_time').val().slice('-2');
      var endDate = new Date(sesBasicAutoScroll('#sescomm_end_date').val()+' '+sesBasicAutoScroll('#sescomm_end_time').val().replace(lastTwoDigit,'')+':00 '+lastTwoDigit);
      var lastTwoDigitStart = sesBasicAutoScroll('#sescomm_start_time').val().slice('-2');
      var startDate = new Date(sesBasicAutoScroll('#sescomm_start_date').val()+' '+sesBasicAutoScroll('#sescomm_start_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
      var error = sescommCheckDateTime(startDate,endDate);
    });
    sesBasicAutoScroll('#sescomm_end_time').timepicker({
        'showDuration': true,
        'timeFormat': 'g:ia'
    }).on('changeTime',function(){
      var lastTwoDigit = sesBasicAutoScroll('#sescomm_end_time').val().slice('-2');
      var endDate = new Date(sesBasicAutoScroll('#sescomm_end_date').val()+' '+sesBasicAutoScroll('#sescomm_end_time').val().replace(lastTwoDigit,'')+':00 '+lastTwoDigit);
      var lastTwoDigitStart = sesBasicAutoScroll('#sescomm_start_time').val().slice('-2');
      var startDate = new Date(sesBasicAutoScroll('#sescomm_start_date').val()+' '+sesBasicAutoScroll('#sescomm_start_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
      var error = sescommCheckDateTime(startDate,endDate);
    });
    sesBasicAutoScroll('#sescomm_start_date').datepicker({
        format: 'm/d/yyyy',
        weekStart: 1,
        autoclose: true,
        startDate: sescommstartCalanderDate,
        endDate: sescommsesFromEndDate,
    }).on('changeDate', function(ev){
      sescommsesselectedDate = ev.date;
        var y = sescommsesselectedDate.getFullYear(), m = sescommsesselectedDate.getMonth(), d = sescommsesselectedDate.getDate();
        m = ('0'+ (m+1)).slice(-2);

        var date = m+'/'+d+'/'+y;
      //var end_date = sesBasicAutoScroll('#sescomm_end_date').data('DateTimePicker');
      sesBasicAutoScroll('#sescomm_end_date').datepicker( "option", "minDate", date)
      var lastTwoDigit = sesBasicAutoScroll('#sescomm_end_time').val().slice('-2');
      var endDate = new Date(sesBasicAutoScroll('#sescomm_end_date').val()+' '+sesBasicAutoScroll('#sescomm_end_time').val().replace(lastTwoDigit,'')+':00 '+lastTwoDigit);
      var lastTwoDigitStart = sesBasicAutoScroll('#sescomm_start_time').val().slice('-2');
      var startDate = new Date(sesBasicAutoScroll('#sescomm_start_date').val()+' '+sesBasicAutoScroll('#sescomm_start_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
      var error = sescommCheckDateTime(startDate,endDate);
    });

    sesBasicAutoScroll('#sescomm_end_date').datepicker({
        format: 'm/d/yyyy',
        weekStart: 1,
        autoclose: true,
        startDate: sescommsesselectedDate,
    }).on('changeDate', function(ev){
      sescommsesFromEndDate = new Date(ev.date.valueOf());
      sescommsesFromEndDate.setDate(sescommsesFromEndDate.getDate(new Date(ev.date.valueOf())));
      var lastTwoDigit = sesBasicAutoScroll('#sescomm_end_time').val().slice('-2');
      var endDate = new Date(sesBasicAutoScroll('#sescomm_end_date').val()+' '+sesBasicAutoScroll('#sescomm_end_time').val().replace(lastTwoDigit,'')+':00 '+lastTwoDigit);
      var lastTwoDigitStart = sesBasicAutoScroll('#sescomm_start_time').val().slice('-2');
      var startDate = new Date(sesBasicAutoScroll('#sescomm_start_date').val()+' '+sesBasicAutoScroll('#sescomm_start_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
      var error = sescommCheckDateTime(startDate,endDate);
    });
  }
function sescommCheckDateTime(startdate,enddate){console.log(startdate,enddate);
  var errorMessage = '';
  var checkdate = true;


    var currentTime =  new Date();
    var format = 'YYYY/MM/DD HH:mm:ss';
    currentTime = moment(currentTime, format).tz(currentUserTimezone).format(format);
    currentTime =  new Date(currentTime);




  if(currentTime.valueOf() > startdate.valueOf() && sesBasicAutoScroll('#sescomm_start_date').val()){
    errorMessage = sescommStartPastDate;
  }else if(startdate.valueOf() >= enddate.valueOf() && sesBasicAutoScroll('#sescomm_start_date').val() && sesBasicAutoScroll('#sescomm_end_date').val()){
      errorMessage = sescommEndBeforeDate;
  }
  if(errorMessage != ""){
      sesJqueryObject('.shedulling_error').show();
      sesJqueryObject('.shedulling_error > span').html(errorMessage);
  }else{
      sesJqueryObject('.shedulling_error').hide();
      sesJqueryObject('.shedulling_error > span').html('');
  }
}
var isValidSescommForm = false;
//function to submit form
var submitFormAjaxReMSescommads;
function submitsescommunitycreate(){
  changeSescommFormOption = false;
  validateFunction();

  if(sesJqueryObject('#location_targetting').length) {
    if(sesJqueryObject('#location_sescomm').val() && sesJqueryObject('#sescomm_lat').val() && sesJqueryObject('#sescomm_lng').val()){
      if(!sesJqueryObject('#location_distance').val()) {
        isValidSescommForm = true;
        if(!sesJqueryObject('#location_distance').parent().find('.sescommerror').length)
          sesJqueryObject('#location_distance').parent().append('<div class="sescommerror">'+errorMessageSescomm+'</div>');
      }else{
        var id = sesJqueryObject('#location_distance').val();
        if(Math.floor(id) == id && sesJqueryObject.isNumeric(id)){}else{
          if(!sesJqueryObject('#location_distance').parent().find('.sescommerror').length)
            sesJqueryObject('#location_distance').parent().append('<div class="sescommerror">'+errorMessageSescomm+'</div>');
          isValidSescommForm = true;
        }
      }
    }
  }

  //Reverse Location Work
  if(sesJqueryObject('#location_reversetargetting').length){
    if(sesJqueryObject('#revselocation_sescomm').val() && sesJqueryObject('#revsesescomm_lat').val() && sesJqueryObject('#revsesescomm_lng').val()){
      if(!sesJqueryObject('#revselocation_distance').val()) {
        isValidSescommForm = true;
        if(!sesJqueryObject('#revselocation_distance').parent().find('.sescommerror').length)
          sesJqueryObject('#revselocation_distance').parent().append('<div class="sescommerror">'+errorMessageSescomm+'</div>');
      }else{
        var id = sesJqueryObject('#revselocation_distance').val();
        if(Math.floor(id) == id && sesJqueryObject.isNumeric(id)){}else{
          if(!sesJqueryObject('#revselocation_distance').parent().find('.sescommerror').length)
            sesJqueryObject('#revselocation_distance').parent().append('<div class="sescommerror">'+errorMessageSescomm+'</div>');
            isValidSescommForm = true;
        }
      }
    }
  }

  if(isValidSescommForm == true){
    //error in form return from here
      return;
  }

  //success, need to subit form at this point
  var promoteTypeValue = sesJqueryObject('#promote_cnt').val();
  var formDataType;
  if(promoteTypeValue == "promote_content_cnt" || promoteTypeValue == "promote_website_cnt"){
    formDataType = getPromoteContentFormData();
  }if(promoteTypeValue == "boost_post_cnt"){
    formDataType = getBoostData();
  }
  console.log(formDataType);
  if(sesJqueryObject('#sescommunityad_id').val() != 0){
    formDataType.append('sescommunityad_id',sesJqueryObject('#sescommunityad_id').val());
  }
  if(sesJqueryObject('#category_id').length){
     if(sesJqueryObject('#category_id').val())
      formDataType.append('category_id',sesJqueryObject('#category_id').val());
     if(sesJqueryObject('#subcat_id').val())
      formDataType.append('subcat_id',sesJqueryObject('#subcat_id').val());
     if(sesJqueryObject('#subsubcat_id').val())
      formDataType.append('subsubcat_id',sesJqueryObject('#subsubcat_id').val());
  }

  if(sesJqueryObject('#sescustom_fields').length){
   //target data
   var targetData = sesJqueryObject('#sescustom_fields').serialize();
   formDataType.append('targetData',targetData);
  }
  if(promoteTypeValue == "promote_content_cnt"){
    formDataType.append('resource_id',sesJqueryObject('#sescomm_resource_id').val());
    formDataType.append('resource_type',sesJqueryObject('#sescomm_resource_type').val());
  }else if (promoteTypeValue == "promote_website_cnt"){
      formDataType.append('website_title',sesJqueryObject('#website_title').val());
      formDataType.append('website_url',sesJqueryObject('#website_url').val());
      formDataType.append('website_image',sesJqueryObject('#website_image')[0].files[0]);
  }
  //schedulling data
  var schedullingData = sesJqueryObject('#schedulling').serialize();
  formDataType.append('schedullingData',schedullingData);

    //Interest Based
    if(sesJqueryObject('#interest_targetting')) {
        var interestElem = sesJqueryObject('#interest_targetting');
        if(interestElem.length > 0) {
            var selectedInterest = new Array();
            sesJqueryObject('input[name=interest_enable]:checked').each(function() {
                selectedInterest.push(this.value);
            });
        //console.log(selectedInterest);
            formDataType.append('interests',selectedInterest);
        }
    }

  //location
  var locationElem = sesJqueryObject('#location_targetting');
  if(locationElem.length > 0){
    formDataType.append('location_type',sesJqueryObject('input[name=location_type]:checked').val());
    formDataType.append('location',sesJqueryObject('#location_sescomm').val());
    formDataType.append('lat',sesJqueryObject('#sescomm_lat').val());
    formDataType.append('lng',sesJqueryObject('#sescomm_lng').val());
  }

  if(sesJqueryObject('#location_reversetargetting')) {
    var locationElem = sesJqueryObject('#location_reversetargetting');
    if(locationElem.length > 0){
        formDataType.append('revselocation_type',sesJqueryObject('input[name=revselocation_type]:checked').val());
        formDataType.append('revselocation',sesJqueryObject('#revselocation_sescomm').val());
        formDataType.append('revselat',sesJqueryObject('#revsesescomm_lat').val());
        formDataType.append('revselng',sesJqueryObject('#revsesescomm_lng').val());
    }
  }

  formDataType.append('existingpackage',sesJqueryObject('#existingpackage').val());
  //campaign
  var campaign = sesJqueryObject('#campaign_frm').serialize();
  formDataType.append('campaign',campaign);
  formDataType.append('package_id',sesJqueryObject('#package_id').val());
  //send form submit request
  formDataType.append('ad_type', promoteTypeValue);
  if(sesJqueryObject('#networks').length)
    formDataType.append('networks',sesJqueryObject('#networks').val());
  if(typeof submitFormAjaxReMSescommads != 'undefined')
			submitFormAjaxReMSescommads.abort();
    sesJqueryObject('#sesbasic_loading_cont_overlay_submit').show();
		submitFormAjaxReMSescommads = sesJqueryObject.ajax({
				type:'POST',
				url: en4.core.baseUrl+'sescommunityads/index/create/',
				data:formDataType,
				cache:false,
				contentType: false,
				processData: false,
				success:function(data){
          sesJqueryObject('#sesbasic_loading_cont_overlay_submit').hide();
					try{
						var result  = sesJqueryObject.parseJSON(data);
            if(result.error == 1)
              alert(result.message);
            else
              window.location.href = result.url;
					}catch(err){
            alert(en4.core.language.translate("Something went wrong, please try again later."));
					}
				},
				error: function(data){
          sesJqueryObject('#sesbasic_loading_cont_overlay_submit').hide();
           alert(en4.core.language.translate("Something went wrong, please try again later."));
				}
		});
}
function getBoostData(){
  var form = new FormData();
  form.append('boost_post_id',sesJqueryObject('.sesboost_post_active').attr('data-rel'));
  return form;
}
function getPromoteContentFormData(){
    var value = sesJqueryObject('input[name=formate_type]:checked').attr('rel');
    if(value == "carousel_div"){
      var form = new FormData(sesJqueryObject('#carousel_form')[0]);
      form.append('uploadType','carousel');
    }else if(value == "image_div"){
      var form = new FormData(sesJqueryObject('#image_form')[0]);
      form.append('uploadType','image');
    }else if(value == "banner_div"){
      var form = new FormData(sesJqueryObject('#banner_form')[0]);
      form.append('uploadType','banner');
    }
    else{
      var form = new FormData(sesJqueryObject('#video_form')[0]);
      form.append('uploadType','video');
    }
    return form;
}
function validateFunction(){
  var promoteTypeValue = sesJqueryObject('#promote_cnt').val();

  //promote content type
  if(promoteTypeValue == "promote_content_cnt" || promoteTypeValue == "promote_website_cnt"){
    if(changeSescommFormOption == false)
    checkPromoteContent();
    changeSescommFormOption = true;
  }
}
//validate functions
function checkPromoteContent(){
  isValidSescommForm = false;
  var type = adType();
  var value = sesJqueryObject('input[name=formate_type]:checked').attr('rel');
  /*var valueField = sesJqueryObject('.'+value).find('.sescommunityads_carousel_title_text').val();
  if(!valueField){
    isValidSescommForm = true;
    if(!sesJqueryObject('.'+value).find('.sescommunityads_carousel_title_text').parent().find('.sescommerror').length)
      sesJqueryObject('.'+value).find('.sescommunityads_carousel_title_text').parent().append('<div class="sescommerror">'+errorMessageSescomm+'</div>');
  }else
      sesJqueryObject('.'+value).find('.sescommunityads_carousel_title_text').parent().find('.sescommerror').remove();*/

  if(type == "promote_content_cnt"){
    var sescomm_resource_type = sesJqueryObject('#sescomm_resource_type');
    var sescomm_resource_id = sesJqueryObject('#sescomm_resource_id');
    if(sescomm_resource_type.val() == ""){
        isValidSescommForm = true;
        if(!sescomm_resource_type.parent().find('.sescommerror').length)
          sescomm_resource_type.parent().append('<div class="sescommerror">'+errorMessageSescomm+'</div>');
        else
          sescomm_resource_type.parent().find('.sescommerror').remove();
    }
    if(sescomm_resource_id.val() == "" || sescomm_resource_id.val() == null){
        isValidSescommForm = true;
        if(!sescomm_resource_id.parent().find('.sescommerror').length)
            sescomm_resource_id.parent().append('<div class="sescommerror">'+errorMessageSescomm+'</div>');
        else
          sescomm_resource_id.parent().find('.sescommerror').remove();
    }
  }else{

      if(value != 'banner_div') {
        var websiteurl = sesJqueryObject('#website_url');
        var websitetitle = sesJqueryObject('#website_title');
        if(websiteurl.val() == ""){
                isValidSescommForm = true;
                if(!websiteurl.parent().find('.sescommerror').length)
                    websiteurl.parent().append('<div class="sescommerror">'+errorMessageSescomm+'</div>');
        }else if(!validateUrl(websiteurl.val())){
            isValidSescommForm = true;
            if(!websiteurl.parent().find('.sescommerror').length)
                websiteurl.parent().append('<div class="sescommerror">'+invalidUrlerrorMessageSescomm+'</div>');
        }else
            websiteurl.parent().find('.sescommerror').remove();

        if(websitetitle.val() == ""){
                isValidSescommForm = true;
                if(!websitetitle.parent().find('.sescommerror').length)
                    websitetitle.parent().append('<div class="sescommerror">'+errorMessageSescomm+'</div>');
        }else
            websitetitle.parent().find('.sescommerror').remove();
      }
  }
  if(value == "carousel_div"){
    var addtocard = sesJqueryObject('.carousel_div').find('.add_comm_card:checked');
    var imgValue = sesJqueryObject('.carousel_div').find('.more_image');
    var seemore = sesJqueryObject('.carousel_div').find('#see_more_url');
    var seemorelink = sesJqueryObject('.carousel_div').find('#see_more_display_link');

    if(addtocard.length){
       if(!imgValue.val() && (typeValue == "" || typeValue != adType())){
            isValidSescommForm = true;
            if(!imgValue.parent().find('.sescommerror').length)
                imgValue.parent().append('<div class="sescommerror">'+errorMessageSescomm+'</div>');
       }else{
        imgValue.parent().find('.sescommerror').remove();
       }
       if(seemore.val() == ""){
            isValidSescommForm = true;
            if(!seemore.parent().find('.sescommerror').length)
                seemore.parent().append('<div class="sescommerror">'+errorMessageSescomm+'</div>');

       }else if(!validateUrl(seemore.val())){
         isValidSescommForm = true;
         if(!seemore.parent().find('.sescommerror').length)
            seemore.parent().append('<div class="sescommerror">'+invalidUrlerrorMessageSescomm+'</div>');

       }else{
          seemore.parent().find('.sescommerror').remove();
       }
       if(seemorelink.val() == ""){
            isValidSescommForm = true;
            if(!seemorelink.parent().find('.sescommerror').length)
                seemorelink.parent().append('<div class="sescommerror">'+errorMessageSescomm+'</div>');

       }else{
          seemorelink.parent().find('.sescommerror').remove();
       }
    }
    /*var valueCallToAction = sesJqueryObject('.carousel_div').find('.sescomm_call_to_action').val();
    //var callToactionField = sesJqueryObject('.carousel_div').find('input[name=calltoaction_url]').val();
    if(valueCallToAction /*&& !validateUrl(callToactionField)){
      if(!sesJqueryObject('.carousel_div').find('.sescomm_call_to_action').parent().find('.sescommerror').length)
        sesJqueryObject('.carousel_div').find('.sescomm_call_to_action').parent().append('<div class="sescommerror">'+invalidUrlerrorMessageSescomm+'</div>');
    }else
      sesJqueryObject('.carousel_div').find('.sescomm_call_to_action').parent().find('.sescommerror').remove();*/
    var errorElementDivContainer = "";
    var counterErrorElement = false;

    var element = sesJqueryObject('.sescommunityads_choose').find('.sescomm_carousel_img');
    for(i=0;i<element.length;i++){
      var field = sesJqueryObject(element[i]).find('input');
      for(j=0;j<field.length;j++){
        var typeElem = sesJqueryObject(field[j]).prop('type');
        if(sesJqueryObject(field[j]).hasClass('required') && (typeElem != "file" ||  (typeElem == "file" && !sesJqueryObject(field[j]).hasClass('fromedit')))){
          var valueField = sesJqueryObject(field[j]).val();
          if(!valueField){
              if(!sesJqueryObject(sesJqueryObject(field[j])).parent().find('.sescommerror').length){
                sesJqueryObject(sesJqueryObject(field[j])).parent().append('<div class="sescommerror">'+errorMessageSescomm+'</div>');
              }
              isValidSescommForm = true;
          }else{
              sesJqueryObject(sesJqueryObject(field[j])).parent().find('.sescommerror').remove();
          }
          if(sesJqueryObject(field[j]).hasClass('url')){
             if(!validateUrl(valueField)){
               if(!sesJqueryObject(sesJqueryObject(field[j])).parent().find('.sescommerror').length){
                  sesJqueryObject(sesJqueryObject(field[j])).parent().append('<div class="sescommerror">'+invalidUrlerrorMessageSescomm+'</div>');
               }
              isValidSescommForm = true;
             }else{
               sesJqueryObject(sesJqueryObject(field[j])).parent().find('.sescommerror').remove();
             }
          }
        }
      }

      if(isValidSescommForm == true && counterErrorElement == false){
        errorElementDivContainer =  sesJqueryObject(element[i]);
        counterErrorElement = true;
      }
    }

    if(isValidSescommForm == true){
        var indexError  = sesJqueryObject('.sescommunityads_choose').find('.sescomm_carousel_img').index(errorElementDivContainer);
        sesJqueryObject('#sescomm_ad_car_li').children().eq(indexError).find('a').trigger('click');
    }
  }else if(value == "image_div"){
   /* var valueCallToAction = sesJqueryObject('.image_div').find('.sescomm_call_to_action').val();
   // var callToactionField = sesJqueryObject('.image_div').find('input[name=calltoaction_url]').val();
    if(valueCallToAction /*&& !validateUrl(callToactionField)){
      if(!sesJqueryObject('.image_div').find('.sescomm_call_to_action').parent().find('.sescommerror').length)
        sesJqueryObject('.image_div').find('.sescomm_call_to_action').parent().append('<div class="sescommerror">'+invalidUrlerrorMessageSescomm+'</div>');
    }else
      sesJqueryObject('.image_div').find('.sescomm_call_to_action').parent().find('.sescommerror').remove(); */
    var element = sesJqueryObject('.image_div').find('input.required');
    for(j=0;j<element.length;j++){
        var typeElem = sesJqueryObject(element[j]).prop('type');
        var valueField = sesJqueryObject(element[j]).val();
        if(!valueField && (typeElem != "file" ||  (typeElem != "file" ||  (typeElem == "file" && !sesJqueryObject(element[j]).hasClass('fromedit'))))){
            if(!sesJqueryObject(sesJqueryObject(element[j])).parent().find('.sescommerror').length){
              sesJqueryObject(sesJqueryObject(element[j])).parent().append('<div class="sescommerror">'+errorMessageSescomm+'</div>');
            }
            isValidSescommForm = true;
        }else{
            sesJqueryObject(sesJqueryObject(element[j])).parent().find('.sescommerror').remove();
        }
        if(sesJqueryObject(element[j]).hasClass('url')){
           if(!validateUrl(valueField)){
             if(!sesJqueryObject(sesJqueryObject(element[j])).parent().find('.sescommerror').length){
                sesJqueryObject(sesJqueryObject(element[j])).parent().append('<div class="sescommerror">'+invalidUrlerrorMessageSescomm+'</div>');
             }
            isValidSescommForm = true;
           }else{
             sesJqueryObject(sesJqueryObject(element[j])).parent().find('.sescommerror').remove();
           }
        }
    }
  }
  else if(value == "banner_div"){
    //var valueCallToAction = sesJqueryObject('.banner_div').find('.sescomm_banner_size').val();
   //var callToactionField = sesJqueryObject('.banner_div').find('input[name=calltoaction_url]').val();
//     if(valueCallToAction){
//       if(!sesJqueryObject('.banner_div').find('.sescomm_banner_size').parent().find('.sescommerror').length)
//         sesJqueryObject('.banner_div').find('.sescomm_banner_size').parent().append('<div class="sescommerror">'+invalidUrlerrorMessageSescomm+'</div>');
//     }else
//       sesJqueryObject('.banner_div').find('.sescomm_banner_size').parent().find('.sescommerror').remove();

    var element = sesJqueryObject('.banner_div').find('input.required');
    var banner_type = sesJqueryObject('input[name=banner_type]:checked').val();
    for(j=0;j<element.length;j++){
        var typeElem = sesJqueryObject(element[j]).prop('type');
        var valueField = sesJqueryObject(element[j]).val();

        if(!valueField && (typeElem != "file" ||  (typeElem != "file" ||  (typeElem == "file" && !sesJqueryObject(element[j]).hasClass('fromedit')))) ){ console.log(typeElem, 'banner');

            if(banner_type == 1 && typeElem != "file") {
                if(!sesJqueryObject(sesJqueryObject(element[j])).parent().find('.sescommerror').length){
                    sesJqueryObject(sesJqueryObject(element[j])).parent().append('<div class="sescommerror">'+errorMessageSescomm+'</div>');
                }
                isValidSescommForm = true;
            }
        } else {
            sesJqueryObject(sesJqueryObject(element[j])).parent().find('.sescommerror').remove();
        }

        if(banner_type == 1) {
            if(sesJqueryObject(element[j]).hasClass('url')){
                if(!validateUrl(valueField)){
                    if(!sesJqueryObject(sesJqueryObject(element[j])).parent().find('.sescommerror').length){
                        sesJqueryObject(sesJqueryObject(element[j])).parent().append('<div class="sescommerror">'+invalidUrlerrorMessageSescomm+'</div>');
                    }
                    isValidSescommForm = true;
                }else{
                    sesJqueryObject(sesJqueryObject(element[j])).parent().find('.sescommerror').remove();
                }
            }
        }
    }
  }
  else{
    /*var valueCallToAction = sesJqueryObject('.video_div').find('.sescomm_call_to_action').val();
    //var callToactionField = sesJqueryObject('.video_div').find('input[name=calltoaction_url]').val();
    if(valueCallToAction /*&& !validateUrl(callToactionField)){
      if(!sesJqueryObject('.video_div').find('.sescomm_call_to_action').parent().find('.sescommerror').length)
        sesJqueryObject('.video_div').find('.sescomm_call_to_action').parent().append('<div class="sescommerror">'+invalidUrlerrorMessageSescomm+'</div>');
    }else
      sesJqueryObject('.video_div').find('.sescomm_call_to_action').parent().find('.sescommerror').remove();*/
    var element = sesJqueryObject('.video_div').find('input.required');
    for(j=0;j<element.length;j++){
        var typeElem = sesJqueryObject(element[j]).prop('type');
        var valueField = sesJqueryObject(element[j]).val();
        if(!valueField && (typeElem != "file" ||  (typeElem != "file" ||  (typeElem == "file" && !sesJqueryObject(element[j]).hasClass('fromedit'))))){
            if(!sesJqueryObject(sesJqueryObject(element[j])).parent().find('.sescommerror').length){
              sesJqueryObject(sesJqueryObject(element[j])).parent().append('<div class="sescommerror">'+errorMessageSescomm+'</div>');
            }
            isValidSescommForm = true;
        }else{
            sesJqueryObject(sesJqueryObject(element[j])).parent().find('.sescommerror').remove();
        }
        if(sesJqueryObject(element[j]).hasClass('url')){
           if(!validateUrl(valueField)){
             if(!sesJqueryObject(sesJqueryObject(element[j])).parent().find('.sescommerror').length){
                sesJqueryObject(sesJqueryObject(element[j])).parent().append('<div class="sescommerror">'+invalidUrlerrorMessageSescomm+'</div>');
             }
            isValidSescommForm = true;
           }else{
             sesJqueryObject(sesJqueryObject(element[j])).parent().find('.sescommerror').remove();
           }
        }
    }
  }
}


function validateUrl(url){
    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
}
var errorMessageSescomm = "This is required field.";
var invalidUrlerrorMessageSescomm = "Please enter valid URL";




sesJqueryObject(document).on('click','input[name=camapign_delete]',function(){
  var value = sesJqueryObject(this).is(':checked');
  if(value == true){
    sesJqueryObject('#sescommunityads_campaigns').find('input[type=checkbox]').prop('checked',true);
  }else{
    sesJqueryObject('#sescommunityads_campaigns').find('input[type=checkbox]').prop('checked',false);
  }
});

sesJqueryObject(document).on('click','#sescommunityads_campaigns input[type=checkbox]',function(){
    var elements = sesJqueryObject('#sescommunityads_campaigns input[type=checkbox]');
    var valid = true;
    for(i=0;i<elements.length;i++){
      if(sesJqueryObject(elements[i]).is(':checked') == false){
        sesJqueryObject('input[name=camapign_delete]').prop('checked',false);
        valid = false;
      }
    }
    if(valid == true)
    sesJqueryObject('input[name=camapign_delete]').prop('checked',true);
});
  sesJqueryObject(document).on('change','#sescomm_resource_type',function(e){
    var type = sesJqueryObject(this).val();
    sesJqueryObject('#sescomm_resource_id').html('');
    if(type){
      sesJqueryObject.post('sescommunityads/index/module-data',{type:type,selected:selectedType},function(response){
        if(response != false){
          sesJqueryObject('#sescomm_resource_id').html(response);
        }else{
            sesJqueryObject('#sescomm_resource_id').html('<option value="">No content created by you yet.</option>');
        }
        if(selectedType){
          sesJqueryObject('#sescomm_resource_id').trigger('change');
        }
      });
    }
  });
  sesJqueryObject(document).on('change','#sescomm_resource_id',function(e){
     var text = sesJqueryObject('#sescomm_resource_id').find(':selected').text();
     var image = sesJqueryObject('#sescomm_resource_id').find(':selected').attr('data-src');
     if(typeof image == "undefined")
      image = blankImage;
     sesJqueryObject('.sescommunity_preview_sub_image').show();
     sesJqueryObject('.sescommunity_sponsored').show();
     sesJqueryObject('.sescommunity_preview_sub_image').find('a').find('img').attr('src',image);
     sesJqueryObject('.preview_title').find('a').html(text);
     contentTitleValue = text;
  });
sesJqueryObject(document).on('submit','#sescommunityads_campaign_frm',function(e){
    var elements = sesJqueryObject('#sescommunityads_campaigns input[type=checkbox]');
    var valid = false;
    for(i=0;i<elements.length;i++){
      if(sesJqueryObject(elements[i]).is(':checked') == true){
        valid = true;
      }
    }
    return valid;
});
sesJqueryObject(document).on('click','.sescomm_campaign_del',function(e){
  if(confirm(en4.core.language.translate('Are you sure want to delete the selected campaign, this action can not be undone?'))){
     sesJqueryObject('#sescommunityads_campaign_frm').trigger('submit');
  }
});
function createSesadvCarousel(){
  if(!sesJqueryObject('.sescmads_create_carousel').length)
    return;
  sescommunityadsJqueryObject('.sescmads_create_carousel').owlCarousel({
    nav : true,
    loop:false,
    items:1,
  })
  sescommunityadsJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
  sescommunityadsJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
}
function sescommMapList() {
  var input = document.getElementById('location_sescomm');
  var autocomplete = new google.maps.places.Autocomplete(input);
  google.maps.event.addListener(autocomplete, 'place_changed', function () {
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }
    document.getElementById('sescomm_lng').value = place.geometry.location.lng();
    document.getElementById('sescomm_lat').value = place.geometry.location.lat();
  });
}

function sescommRevseMapList() {
  var input = document.getElementById('revselocation_sescomm');
  var autocomplete = new google.maps.places.Autocomplete(input);
  google.maps.event.addListener(autocomplete, 'place_changed', function () {
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }
    document.getElementById('revsesescomm_lng').value = place.geometry.location.lng();
    document.getElementById('revsesescomm_lat').value = place.geometry.location.lat();
  });
}

function showBannerAds(value) {
    if(value == 1) {
        //sesJqueryObject('#banner_size').show();
        sesJqueryObject('#banner_image').show();
        sesJqueryObject('#banner_url').show();
        sesJqueryObject('#banner_html_code').hide();
    } else {
        //sesJqueryObject('#banner_size').hide();
        sesJqueryObject('#banner_image').hide();
        sesJqueryObject('#banner_url').hide();
        sesJqueryObject('#banner_html_code').show();
        sesJqueryObject('#image-banner').val('');
        sesJqueryObject('#destination_url').val('');
        checkTypeAds('sescomm_img','');
    }
}
