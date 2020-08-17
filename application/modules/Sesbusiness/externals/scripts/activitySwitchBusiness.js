//feed change user tabs work
function getBusinessSwitchData(obj,imageTab){
    (new Request.HTML({
			url : en4.core.baseUrl + 'sesbusiness/ajax/get-user-businesses',
			data : {
				format : 'html',
			},
		 onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        imageTab.attr('src',sesJqueryObject(obj).attr('data-src'));
        sesJqueryObject('#sesbusiness_switch_cnt').html(responseHTML);
        sesJqueryObject('#sesbusiness_switch_cnt').show();
        changeSwittcherPositionBusiness(obj);
		}
		})).send();
}
function changeSwittcherPositionBusiness(obj){
    var position = sesJqueryObject(currentClickElem).offset();
    sesJqueryObject('#sesbusiness_switch_cnt').css('left',position.left);
    sesJqueryObject('#sesbusiness_switch_cnt').css('top',position.top+24);
    markSwitcherCheckedBusiness(obj);
}
function markSwitcherCheckedBusiness(obj){
    var dataRel = sesJqueryObject(obj).attr('data-rel');
    sesJqueryObject('._selected').removeClass('_selected');
    sesJqueryObject('.sesbusiness_switcher_li[data-rel="'+dataRel+'"]').addClass('_selected');
}
sesJqueryObject(document).on('click','.sesbusiness_switcher_li',function(e){
    sesJqueryObject('#sesbusiness_switch_cnt').hide();
    changeUserImagesInCommentBusiness(this);
    closeSwitcherDivBusiness();
    getCommentDataForChangeUserBusiness(this);
})
function changeUserImagesInCommentBusiness(obj){
    var data = sesJqueryObject(obj).attr('data-rel');
    sesJqueryObject(currentClickElem).attr('data-rel',data);
    sesJqueryObject(currentClickElem).find('img').attr('src',sesJqueryObject(obj).find('div').find('img').attr('src'));
    sesJqueryObject(currentClickElem).attr('data-src',sesJqueryObject(obj).find('div').find('img').attr('src'));    
    if(sesJqueryObject(currentClickElem).closest('#sesact_post_box_status').length){
       sesJqueryObject(currentClickElem).closest('#sesact_post_box_status').find('.sesact_post_box_img').find('a').find('img').attr('src',sesJqueryObject(obj).find('div').find('img').attr('src'));
       return;
    }
    sesJqueryObject(currentClickElem).closest('.comment-feed').find('.sesadvcmt_comments').find('form').find('.comments_author_photo').find('img').attr('src',sesJqueryObject(obj).find('div').find('img').attr('src'));  
}
function getCommentDataForChangeUserBusiness(obj){
  var action_id = sesJqueryObject(currentClickElem).attr('data-actionid');
  var dataGuid = sesJqueryObject(currentClickElem).attr('data-rel');
   var subject = sesJqueryObject(currentClickElem).attr('data-subject');
  new Request.HTML({
      url : en4.core.baseUrl + 'sesadvancedcomment/index/get-comment',
      data : {
        format : 'html',
        dataGuid:dataGuid,
        action_id:action_id,
        subject:subject,
      },
     onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        var dataJson = sesJqueryObject.parseJSON(responseHTML);
        sesJqueryObject(currentClickElem).closest('.sesact_comments').html(dataJson.body);
        //changeUserImagesInCommentBusiness(obj);
    }
  }).send();
}
function closeSwitcherDivBusiness(){
  if(sesJqueryObject(currentClickElem).hasClass('active')){
    sesJqueryObject(currentClickElem).removeClass('active');
    sesJqueryObject('#sesbusiness_switch_cnt').hide();
  }  
}
var currentClickElem = "";
sesJqueryObject(document).on('click','.sesbusiness_feed_change_option',function(){
  currentClickElem = sesJqueryObject(this).parent().find('.sesbusiness_feed_change_option_a');
  if(sesJqueryObject(currentClickElem).hasClass('active')){
    closeSwitcherDivBusiness();
    return;
  }
  sesJqueryObject(currentClickElem).addClass('active');
  var businessContentData = true;
  if(!sesJqueryObject('#sesbusiness_switch_cnt').length)
    businessContentData = false;
  var imageTab = sesJqueryObject(currentClickElem).find('img');
  imageTab.attr('src','application/modules/Core/externals/images/loading.gif');
  
  if(!businessContentData){
    //create container div
    sesJqueryObject('<div id="sesbusiness_switch_cnt" class="sesact_owner_selector_pulldown sesbasic_bxs"></div>').appendTo('body');
    getBusinessSwitchData(currentClickElem,imageTab);
  }else{
    imageTab.attr('src',sesJqueryObject(currentClickElem).attr('data-src'));
    sesJqueryObject('#sesbusiness_switch_cnt').show();
    changeSwittcherPositionBusiness(currentClickElem);
  }
});
sesJqueryObject(document).on('click','.sesbusiness_elem_cnt',function(){
  sesJqueryObject(this).parent().trigger('click');
})
sesJqueryObject(document).click(function(e){
  var elem = sesJqueryObject('#sesbusiness_switch_cnt');
  if(!elem.has(e.target).length && !sesJqueryObject(e.target).hasClass('sesbusiness_feed_change_option')){
    closeSwitcherDivBusiness();
  }
})
//end feed switcher work