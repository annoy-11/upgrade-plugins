//feed change user tabs work
function getPageSwitchData(obj,imageTab){
    (new Request.HTML({
			url : en4.core.baseUrl + 'sespage/ajax/get-user-pages',
			data : {
				format : 'html',
			},
		 onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        imageTab.attr('src',sesJqueryObject(obj).attr('data-src'));
        sesJqueryObject('#sespage_switch_cnt').html(responseHTML);
        sesJqueryObject('#sespage_switch_cnt').show();
        changeSwittcherPositionSespage(obj);
		}
		})).send();
}
function changeSwittcherPositionSespage(obj){
    var position = sesJqueryObject(currentClickElem).offset();
    sesJqueryObject('#sespage_switch_cnt').css('left',position.left);
    sesJqueryObject('#sespage_switch_cnt').css('top',position.top+24);
    markSwitcherChecked(obj);
}
function markSwitcherChecked(obj){
    var dataRel = sesJqueryObject(obj).attr('data-rel');
    sesJqueryObject('._selected').removeClass('_selected');
    sesJqueryObject('.sespage_switcher_li[data-rel="'+dataRel+'"]').addClass('_selected');
}
sesJqueryObject(document).on('click','.sespage_switcher_li',function(e){
    sesJqueryObject('#sespage_switch_cnt').hide();
    changeUserImagesInComment(this);
    closeSwitcherDiv();
    getCommentDataForChangeUser(this);
})
function changeUserImagesInComment(obj){
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
function getCommentDataForChangeUser(obj){
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
        //changeUserImagesInComment(obj);
    }
  }).send();
}
function closeSwitcherDiv(){
  if(sesJqueryObject(currentClickElem).hasClass('active')){
    sesJqueryObject(currentClickElem).removeClass('active');
    sesJqueryObject('#sespage_switch_cnt').hide();
  }  
}
var currentClickElem = "";
sesJqueryObject(document).on('click','.sespage_feed_change_option',function(){
  currentClickElem = sesJqueryObject(this).parent().find('.sespage_feed_change_option_a');
  if(sesJqueryObject(currentClickElem).hasClass('active')){
    closeSwitcherDiv();
    return;
  }
  sesJqueryObject(currentClickElem).addClass('active');
  var pageContentData = true;
  if(!sesJqueryObject('#sespage_switch_cnt').length)
    pageContentData = false;
  var imageTab = sesJqueryObject(currentClickElem).find('img');
  imageTab.attr('src','application/modules/Core/externals/images/loading.gif');
  
  if(!pageContentData){
    //create container div
    sesJqueryObject('<div id="sespage_switch_cnt" class="sesact_owner_selector_pulldown sesbasic_bxs"></div>').appendTo('body');
    getPageSwitchData(currentClickElem,imageTab);
  }else{
    imageTab.attr('src',sesJqueryObject(currentClickElem).attr('data-src'));
    sesJqueryObject('#sespage_switch_cnt').show();
    changeSwittcherPositionSespage(currentClickElem);
  }
});
sesJqueryObject(document).on('click','.sespage_elem_cnt',function(){
  sesJqueryObject(this).parent().trigger('click');
})
sesJqueryObject(document).click(function(e){
  var elem = sesJqueryObject('#sespage_switch_cnt');
  if(!elem.has(e.target).length && !sesJqueryObject(e.target).hasClass('sespage_feed_change_option')){
     sesJqueryObject(currentClickElem).removeClass('active');
    sesJqueryObject('#sespage_switch_cnt').hide();
    closeSwitcherDiv();
  }
})
//end feed switcher work