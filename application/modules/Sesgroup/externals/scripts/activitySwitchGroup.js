//feed change user tabs work
function getGroupSwitchData(obj,imageTab){
    (new Request.HTML({
			url : en4.core.baseUrl + 'sesgroup/ajax/get-user-groups',
			data : {
				format : 'html',
			},
		 onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        imageTab.attr('src',sesJqueryObject(obj).attr('data-src'));
        sesJqueryObject('#sesgroup_switch_cnt').html(responseHTML);
        sesJqueryObject('#sesgroup_switch_cnt').show();
        changeSwittcherPosition(obj);
		}
		})).send();
}
function changeSwittcherPosition(obj){
    var position = sesJqueryObject(currentClickElem).offset();
    sesJqueryObject('#sesgroup_switch_cnt').css('left',position.left);
    sesJqueryObject('#sesgroup_switch_cnt').css('top',position.top+24);
    markSwitcherCheckedGroup(obj);
}
function markSwitcherCheckedGroup(obj){
    var dataRel = sesJqueryObject(obj).attr('data-rel');
    sesJqueryObject('._selected').removeClass('_selected');
    sesJqueryObject('.sesgroup_switcher_li[data-rel="'+dataRel+'"]').addClass('_selected');
}
sesJqueryObject(document).on('click','.sesgroup_switcher_li',function(e){
    sesJqueryObject('#sesgroup_switch_cnt').hide();
    changeUserImagesInCommentGroup(this);
    closeSwitcherDivGroup();
    getCommentDataForChangeUserGroup(this);
})
function changeUserImagesInCommentGroup(obj){
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
function getCommentDataForChangeUserGroup(obj){
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
        //changeUserImagesInCommentGroup(obj);
    }
  }).send();
}
function closeSwitcherDivGroup(){
  if(sesJqueryObject(currentClickElem).hasClass('active')){
    sesJqueryObject(currentClickElem).removeClass('active');
    sesJqueryObject('#sesgroup_switch_cnt').hide();
  }  
}
var currentClickElem = "";
sesJqueryObject(document).on('click','.sesgroup_feed_change_option',function(){
  currentClickElem = sesJqueryObject(this).parent().find('.sesgroup_feed_change_option_a');
  if(sesJqueryObject(currentClickElem).hasClass('active')){
    closeSwitcherDivGroup();
    return;
  }
  sesJqueryObject(currentClickElem).addClass('active');
  var groupContentData = true;
  if(!sesJqueryObject('#sesgroup_switch_cnt').length)
    groupContentData = false;
  var imageTab = sesJqueryObject(currentClickElem).find('img');
  imageTab.attr('src','application/modules/Core/externals/images/loading.gif');
  if(!groupContentData){
    //create container div
    sesJqueryObject('<div id="sesgroup_switch_cnt" class="sesact_owner_selector_pulldown sesbasic_bxs"></div>').appendTo('body');
    getGroupSwitchData(currentClickElem,imageTab);
  }else{
    imageTab.attr('src',sesJqueryObject(currentClickElem).attr('data-src'));
    sesJqueryObject('#sesgroup_switch_cnt').show();
    sesJqueryObject('#sesgroup_switch_cnt').addClass('activeDisplay');
    changeSwittcherPosition(currentClickElem);
  }
});
sesJqueryObject(document).on('click','.sesgroup_elem_cnt',function(){
  sesJqueryObject(this).parent().trigger('click');
})
sesJqueryObject(document).click(function(e){
  var elem = sesJqueryObject('#sesgroup_switch_cnt');
  if(!elem.has(e.target).length && !sesJqueryObject(e.target).hasClass('sesgroup_feed_change_option')){
    sesJqueryObject(currentClickElem).removeClass('active');
    sesJqueryObject('#sesgroup_switch_cnt').hide();
    closeSwitcherDivGroup();
  }
})
//end feed switcher work