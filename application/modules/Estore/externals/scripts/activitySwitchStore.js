//feed change user tabs work
function getStoreSwitchData(obj,imageTab){
    (new Request.HTML({
			url : en4.core.baseUrl + 'estore/ajax/get-user-stores',
			data : {
				format : 'html',
			},
		 onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        imageTab.attr('src',sesJqueryObject(obj).attr('data-src'));
        sesJqueryObject('#estore_switch_cnt').html(responseHTML);
        sesJqueryObject('#estore_switch_cnt').show();
        changeSwittcherPositionStore(obj);
		}
		})).send();
}
function changeSwittcherPositionStore(obj){
    var position = sesJqueryObject(currentClickElem).offset();
    sesJqueryObject('#estore_switch_cnt').css('left',position.left);
    sesJqueryObject('#estore_switch_cnt').css('top',position.top+24);
    markSwitcherCheckedStore(obj);
}
function markSwitcherCheckedStore(obj){
    var dataRel = sesJqueryObject(obj).attr('data-rel');
    sesJqueryObject('._selected').removeClass('_selected');
    sesJqueryObject('.estore_switcher_li[data-rel="'+dataRel+'"]').addClass('_selected');
}
sesJqueryObject(document).on('click','.estore_switcher_li',function(e){
    sesJqueryObject('#estore_switch_cnt').hide();
    changeUserImagesInCommentStore(this);
    closeSwitcherDivStore();
    getCommentDataForChangeUserStore(this);
})
function changeUserImagesInCommentStore(obj){
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
function getCommentDataForChangeUserStore(obj){
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
        //changeUserImagesInCommentStore(obj);
    }
  }).send();
}
function closeSwitcherDivStore(){
  if(sesJqueryObject(currentClickElem).hasClass('active')){
    sesJqueryObject(currentClickElem).removeClass('active');
    sesJqueryObject('#estore_switch_cnt').hide();
  }  
}
var currentClickElem = "";
sesJqueryObject(document).on('click','.estore_feed_change_option',function(){
  currentClickElem = sesJqueryObject(this).parent().find('.estore_feed_change_option_a');
  if(sesJqueryObject(currentClickElem).hasClass('active')){
    closeSwitcherDivStore();
    return;
  }
  sesJqueryObject(currentClickElem).addClass('active');
  var storeContentData = true;
  if(!sesJqueryObject('#estore_switch_cnt').length)
    storeContentData = false;
  var imageTab = sesJqueryObject(currentClickElem).find('img');
  imageTab.attr('src','application/modules/Core/externals/images/loading.gif');
  
  if(!storeContentData){
    //create container div
    sesJqueryObject('<div id="estore_switch_cnt" class="sesact_owner_selector_pulldown sesbasic_bxs"></div>').appendTo('body');
    getStoreSwitchData(currentClickElem,imageTab);
  }else{
    imageTab.attr('src',sesJqueryObject(currentClickElem).attr('data-src'));
    sesJqueryObject('#estore_switch_cnt').show();
    changeSwittcherPositionStore(currentClickElem);
  }
});
sesJqueryObject(document).on('click','.estore_elem_cnt',function(){
  sesJqueryObject(this).parent().trigger('click');
})
sesJqueryObject(document).click(function(e){
  var elem = sesJqueryObject('#estore_switch_cnt');
  if(!elem.has(e.target).length && !sesJqueryObject(e.target).hasClass('estore_feed_change_option')){
    closeSwitcherDivStore();
  }
})
//end feed switcher work