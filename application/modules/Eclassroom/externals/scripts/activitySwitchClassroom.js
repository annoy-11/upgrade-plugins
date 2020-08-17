//feed change user tabs work
function getClassroomSwitchData(obj,imageTab){
    (new Request.HTML({
			url : en4.core.baseUrl + 'eclassroom/ajax/get-user-classrooms',
			data : {
				format : 'html',
			},
		 onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        imageTab.attr('src',sesJqueryObject(obj).attr('data-src'));
        sesJqueryObject('#eclassroom_switch_cnt').html(responseHTML);
        sesJqueryObject('#eclassroom_switch_cnt').show();
        changeSwittcherPositionClassroom(obj);
		}
		})).send();
}
function changeSwittcherPositionClassroom(obj){
    var position = sesJqueryObject(currentClickElem).offset();
    sesJqueryObject('#eclassroom_switch_cnt').css('left',position.left);
    sesJqueryObject('#eclassroom_switch_cnt').css('top',position.top+24);
    markSwitcherCheckedClassroom(obj);
}
function markSwitcherCheckedClassroom(obj){
    var dataRel = sesJqueryObject(obj).attr('data-rel');
    sesJqueryObject('._selected').removeClass('_selected');
    sesJqueryObject('.eclassroom_switcher_li[data-rel="'+dataRel+'"]').addClass('_selected');
}
sesJqueryObject(document).on('click','.eclassroom_switcher_li',function(e){
    sesJqueryObject('#eclassroom_switch_cnt').hide();
    changeUserImagesInCommentClassroom(this);
    closeSwitcherDivClassroom();
    getCommentDataForChangeUserClassroom(this);
})
function changeUserImagesInCommentClassroom(obj){
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
function getCommentDataForChangeUserClassroom(obj){
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
        //changeUserImagesInCommentClassroom(obj);
    }
  }).send();
}
function closeSwitcherDivClassroom(){
  if(sesJqueryObject(currentClickElem).hasClass('active')){
    sesJqueryObject(currentClickElem).removeClass('active');
    sesJqueryObject('#eclassroom_switch_cnt').hide();
  }  
}
var currentClickElem = "";
sesJqueryObject(document).on('click','.eclassroom_feed_change_option',function(){
  currentClickElem = sesJqueryObject(this).parent().find('.eclassroom_feed_change_option_a');
  if(sesJqueryObject(currentClickElem).hasClass('active')){
    closeSwitcherDivClassroom();
    return;
  }
  sesJqueryObject(currentClickElem).addClass('active');
  var classroomContentData = true;
  if(!sesJqueryObject('#eclassroom_switch_cnt').length)
    classroomContentData = false;
  var imageTab = sesJqueryObject(currentClickElem).find('img');
  imageTab.attr('src','application/modules/Core/externals/images/loading.gif');
  
  if(!classroomContentData){
    //create container div
    sesJqueryObject('<div id="eclassroom_switch_cnt" class="sesact_owner_selector_pulldown sesbasic_bxs"></div>').appendTo('body');
    getClassroomSwitchData(currentClickElem,imageTab);
  }else{
    imageTab.attr('src',sesJqueryObject(currentClickElem).attr('data-src'));
    sesJqueryObject('#eclassroom_switch_cnt').show();
    changeSwittcherPositionClassroom(currentClickElem);
  }
});
sesJqueryObject(document).on('click','.eclassroom_elem_cnt',function(){
  sesJqueryObject(this).parent().trigger('click');
})
sesJqueryObject(document).click(function(e){
  var elem = sesJqueryObject('#eclassroom_switch_cnt');
  if(!elem.has(e.target).length && !sesJqueryObject(e.target).hasClass('eclassroom_feed_change_option')){
    closeSwitcherDivClassroom();
  }
})
//end feed switcher work
