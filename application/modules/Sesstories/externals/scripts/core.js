document.onkeydown = function(evt) {
	evt = evt || window.event;
	var isEscape = false;
	if ("key" in evt) {
		isEscape = (evt.key === "Escape" || evt.key === "Esc");
	} else {
		isEscape = (evt.keyCode === 27);
	}
	if (isEscape) {
		if(sesJqueryObject(".sesstories_story_view_main").css('display') == "block"){
			sesJqueryObject(".sesstories_story_view_close_btn").trigger("click");
		}
	}
};


function handleFileUploadsesstories(files)
{
	for (var i = 0; i < files.length; i++)
	{
		if(sesJqueryObject('.multi_upload_sesstories').find(".filename")){
			sesJqueryObject('.multi_upload_sesstories').find(".filename").remove();
		}
		var url = files[i].name;
		var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
		if(ext == 'mp4' || ext == 'mpeg' || ext == 'mov' || ext == 'ogg' || ext == 'ogv' || ext == 'avi' || ext == 'flv' || ext == 'mpg' || ext == 'WMV'){
			//check upload limit
			var FileSize = files[i].size / 1024 / 1024; // in MB
			if(FileSize > post_max_size_sesstory){
				alert("The size of the file exceeds the limits of "+post_max_size_sesstory+"MB.");
				return;
			}
		}
		if((ext == "png" || ext == "jpeg" || ext == "jpg" ||  ext == 'gif' || ext == 'mp4' || ext == 'mpeg' || ext == 'mov' || ext == 'ogg' || ext == 'ogv' || ext == 'avi' || ext == 'flv' || ext == 'mpg' || ext == 'WMV')){
			sesJqueryObject(".sesstories_btn_submit").removeAttr('disabled');
			sesJqueryObject(".multi_upload_sesstories").append('<span class="filename">'+url+'</span>');
			sesJqueryObject("#multi_upload_sesstories").css("border",'');
		}else{
			sesJqueryObject(".sesstories_btn_submit").attr('disabled',true);
			files.value = "";
		}
	}
}
sesJqueryObject(document).on('click','.create_sesstories',function (e) {
	e.preventDefault();
	sesJqueryObject("#create-sesstories").trigger("click");
})
sesJqueryObject(document).on('submit','.submit_stories',function (e) {
	e.preventDefault();
	if(!sesJqueryObject("#file_multi_sesstories").val()){
		sesJqueryObject("#multi_upload_sesstories").css("border",'1px solid red');
		return false;
	}
	var formData = new FormData(this);
	var name = "attachmentVideo[0]";
	var url = sesJqueryObject("#file_multi_sesstories").val();
	var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
	if((ext == "png" || ext == "jpeg" || ext == "jpg" ||  ext == 'gif')){
		name = "attachmentImage[0]";
	}
	formData.append(name, sesJqueryObject('#file_multi_sesstories')[0].files[0]);
	sesJqueryObject(".submit_stories").append('<div class="sesstories_loading_image"></div>');
	formData.append('description', sesJqueryObject('#sesstories_description').val());
	var uploadURL = 'sesstories/index/create';
	sesJqueryObject(".sesstories_btn_submit").attr('disabled',true);
	sesJqueryObject.ajax({
		url: uploadURL,
		type:'POST',
		data:formData,
		cache:false,
		contentType: false,
		processData: false,
		xhr:  function() {
			var xhrobj = sesJqueryObject.ajaxSettings.xhr();
			if (xhrobj.upload) {
				xhrobj.upload.addEventListener('progress', function(event) {
					var percent = 0;
					var position = event.loaded || event.position;
					var total = event.total;
					if (event.lengthComputable) {
						percent = Math.ceil(position / total * 100);
					}
					//Set progress
				}, false);
			}
			return xhrobj;
		},
		success: function(response){
			sesJqueryObject(".sesstories_btn_submit").attr('disabled',false);
			sesJqueryObject(".sesstories_loading_image").remove();
			response = sesJqueryObject.parseJSON(response);
			if (response.message) {
				alert(response.message);
				setTimeout(function () {
					sessmoothboxclose();
				},10);
			}else{
				alert('Something went wrong, please try again later.');
			}
		}
	});
})

function readImageUrlsesstories(input) {
	handleFileUploadsesstories(input.files);
}
sesJqueryObject(document).on('click','.multi_upload_sesstories',function(e){
	document.getElementById('file_multi_sesstories').click();
});
function timeSince(timeStamp) {
	var now = new Date(currentDateTime),
		secondsPast = (now.getTime() - timeStamp) / 1000;
	if (secondsPast < 60) {
		return parseInt(secondsPast) + 's';
	}
	if (secondsPast < 3600) {
		return parseInt(secondsPast / 60) + 'm';
	}
	if (secondsPast <= 86400) {
		return parseInt(secondsPast / 3600) + 'h';
	}
	if (secondsPast > 86400) {
		day = timeStamp.getDate();
		month = timeStamp.toDateString().match(/ [a-zA-Z]*/)[0].replace(" ", "");
		year = timeStamp.getFullYear() == now.getFullYear() ? "" : " " + timeStamp.getFullYear();
		return day + " " + month + year;
	}
}
function getIndex(data,id){
	const index = data.findIndex(p => p.user_id == id);
	return index;
}
function getStoryIndex(data,id){
	const index = data.findIndex(p => p.story_id == id);
	return index;
}
function getStories(rel,id) {
	var storyData;
	if(rel == id){
		//my story content
		storyData = storiesData.my_story
	}else{
		//user story content
		var index = getIndex(storiesData.stories,rel)
		storyData = storiesData.stories[index]
	}
	return storyData;
}

function addSourceToVideo(element, src, type) {
	var source = document.createElement('source');
	source.src = src;
	source.type = type;
	element.appendChild(source);
}
function seshoverStopPlay(type){
	if(type){
		sesStoriesHoverItem = true;
		if(sesStoriesvideo){
			sesStoriesvideo.pause();
		}
		if(sesJqueryObject('.sesstory_play_pause').find('i').hasClass("fa-pause")){
			sesJqueryObject('.sesstory_play_pause').find('i').addClass("fa-play");
			sesJqueryObject('.sesstory_play_pause').find('i').removeClass("fa-pause");
		}

	}else{
		if(sesStoriesvideo){
			sesStoriesvideo.play();
		}
		sesStoriesHoverItem = false;
		if(sesJqueryObject('.sesstory_play_pause').find('i').hasClass("fa-play")){
			sesJqueryObject('.sesstory_play_pause').find('i').removeClass("fa-play");
			sesJqueryObject('.sesstory_play_pause').find('i').addClass("fa-pause");
		}
	}
}
sesJqueryObject(document).on('click','.sesstories_option_elm',function (e) {
	e.preventDefault();
	seshoverStopPlay(true);
	var type = sesJqueryObject(this).attr('type');
	var id = sesJqueryObject(this).attr('rel');
	if(type == "delete"){
		openSmoothBoxInUrl("sesstories/index/delete/id/"+id);
	}else if(type == "report"){
		openSmoothBoxInUrl('report/create/route/default/subject/sesstories_story_'+id+'/format/smoothbox');
	}else if (type == "mute"){
		sesJqueryObject.post("sesstories/index/mute/story_id/"+id,{},function (res) {
			if(res){
				var storyData = storiesData
				//user story content
				var index = getIndex(storyData.stories,selectedStoryUserId)
				storyData.stories.splice(index, 1);
				storiesData = storyData;
				selectedStoryId = 0;
				if (storyData.stories.length >= index + 1){
					selectedStoryUserId = storyData.stories[index].user_id
				}else{
					sesJqueryObject(".sesstories_story_view_close_btn").trigger("click");
				}
				callNextStory();
			}
		})
	}else{
		seshoverStopPlay(false);

	}

})
function storyDeleted(){
	var storyData = storiesData
	//user story content
	var index = getStoryIndex(storyData.my_story.story_content,selectedStoryId)

	callNextStory();
	storyData.my_story.story_content.splice(index, 1);
	storiesData = storyData;
}
sesJqueryObject(document).on('click','.sesstory_play_mute',function (e) {
	e.preventDefault();
	if(sesJqueryObject(this).find('i').hasClass("fa-volume-up")){
		sesJqueryObject(this).find('i').addClass("fa-volume-mute");
		sesJqueryObject(this).find('i').removeClass("fa-volume-up");
		sesStoriesvideo.muted = true;
		sesstoriesVideoVolumeMute = true;
	}else{
		sesJqueryObject(this).find('i').removeClass("fa-volume-mute");
		sesJqueryObject(this).find('i').addClass("fa-volume-up");
		sesStoriesvideo.muted = false;
		sesstoriesVideoVolumeMute = false;
	}
})
sesJqueryObject(document).on('click','.sesstory_play_pause',function (e) {
	e.preventDefault();
	if(sesJqueryObject(this).find('i').hasClass("fa-pause")){
		stopTimerSesstories = true;
		// sesJqueryObject(this).find('i').addClass("fa-play");
		// sesJqueryObject(this).find('i').removeClass("fa-pause");
		seshoverStopPlay(true);
	}else{
		stopTimerSesstories = false;
		// sesJqueryObject(this).find('i').removeClass("fa-play");
		// sesJqueryObject(this).find('i').addClass("fa-pause");
		seshoverStopPlay(false);
	}
})
var selectedStoryId;
var selectedStoryUserId;
var sesstoriesVideoVolumeMute = false;
function createSliders(rel,id,data,index = 0){
	if(typeof data == "undefined")
		data = getStories(rel,id);
	stopTimerSesstories = false;
	if(sesStoriesvideo){
		sesStoriesvideo.pause();
	}
	sesStoriesvideo = undefined;
	seshoverStopPlay(false);

	if(data){

		var total = data.story_content.length;
		var slides = "";
		for(i=0;i<total;i++){
			if(i == index){
				sesJqueryObject(".sesstories_name").html(data.username);
				sesJqueryObject(".sesstories_user_image").attr('src',data.user_image);
				//update options
				sesJqueryObject(".sesstories_story_item_header").find(".sesstories_controller").remove();
				var optionsData = "<span class='sesstory_play_pause'><i class='fas fa-pause'></i></span>";

				if(data.story_content[index].is_video) {
					if(!sesstoriesVideoVolumeMute)
						optionsData = optionsData + "<span class='sesstory_play_mute'><i class='fas fa-volume-up'></i></span>";
					else
						optionsData = optionsData + "<span class='sesstory_play_mute'><i class='fas fa-volume-mute'></i></span>";
				}

				sesJqueryObject(".sesstories_story_item_header").append("<div class='sesstories_controller'>"+optionsData+"</div>");
				if(data.story_content[index].options && data.story_content[index].options.length){
					var optionsData = "";
					data.story_content[index].options.forEach(item => {
						optionsData = optionsData +  "<li><a href='javascript:;' class='sesstories_option_elm' type='"+item.name+"' rel='"+data.story_content[index].story_id+"'>"+item.label+"</a></li>";
					})
					sesJqueryObject(".sesstories_story_item_header").find(".sesstories_option").remove();
					sesJqueryObject(".sesstories_story_item_header").append("<div class='sesstories_option'><a href='javascript:;' class='sesbasic_pulldown_toggle'><i class='fas fa-ellipsis-h'></i></a><ul class='sesstories_option_ul sesbasic_pulldown_options'>"+optionsData+"</ul></div>");
				}
				selectedStoryId = data.story_content[index].story_id;
				selectedStoryUserId = data.user_id
				if(selectedStoryUserId == parseInt(en4.user.viewer.id) || !data.story_content[index].can_comment){
					sesJqueryObject(".sesstories_message_cnt").hide();
				}else{
					sesJqueryObject(".sesstories_message_cnt").show();
				}
				sesJqueryObject(".sesstories_time").html(timeSince(new Date(data.story_content[index].creation_date).getTime()));
				sesJqueryObject(".sesstories_story_item_caption").html(data.story_content[index].comment);
				sesJqueryObject(".sesstoriescommentlike").attr('data-storyid',data.story_content[index].story_id);
				if(!data.story_content[index].is_video)
					sesJqueryObject(".sesstories_content_bg_image").attr('src',data.story_content[index].media_url);
				else
					sesJqueryObject(".sesstories_content_bg_image").attr('src',data.story_content[index].photo);
				updateStoryReactionData(data.story_content[index])
				//check next
				var isNext = callNextStory(true);
				if(isNext){
					sesJqueryObject(".sesstories_next").show();
				}else{
					sesJqueryObject(".sesstories_next").hide();
				}
				//check previous
				var isPrev = callPreviousStory(true);
				if(isPrev){
					sesJqueryObject(".sesstories_previous").show();
				}else{
					sesJqueryObject(".sesstories_previous").hide();
				}
				if(data.story_content[index].is_video){
					sesStoriesvideo = document.createElement('video');
					sesStoriesvideo.preload = true;
					sesStoriesvideo.controls = false;
					if(sesstoriesVideoVolumeMute){
						sesStoriesvideo.muted = true;
					}
					sesJqueryObject('.sesstories_content').html(sesStoriesvideo);
					addSourceToVideo(sesStoriesvideo, data.story_content[index].media_url, 'video/mp4');
					sesStoriesvideo.play();
					sesStoriesvideo.onended = function () {
						//call next data
						callNextStory();
					}
					sesStoriesvideo.onpause = function(){
						if(!sesStoriesHoverItem && sesStoriesvideo){
							var sliderBar = sesJqueryObject(".sesstories_story_slider_loader").children().eq(index);
							sliderBar.find("span").find('span').css("width","100%");
						}
					}
					sesStoriesvideo.ontimeupdate = function (event) {
						if(!sesStoriesvideo){
							return;
						}
						var currentTime = event.srcElement.currentTime;
						var duration = event.srcElement.duration;
						//update bar
						var sliderBar = sesJqueryObject(".sesstories_story_slider_loader").children().eq(index);
						var percentage = (currentTime * 100) / duration
						sliderBar.find("span").find('span').css("width",percentage+"%");
					}
				}else{
					sesJqueryObject('.sesstories_content').html('<img rel="'+index+'" onload="imageLoaded();" src="'+data.story_content[index].media_url+'" />');
				}
			}
			slides = slides+'<div><span><span style="width: '+(i < index ? 100 : 0)+'%"></span></span></div>';
		}
		sesJqueryObject('.sesstories_story_slider_loader').html(slides);
	}
}
var sesStoriesvideo;
var currentTimeForStories = 0;
var breakTimeSesstories = false;
var sesstoriesIntervalObj;
function runTimer() {
	if(sesStoriesHoverItem){
		return;
	}
	var index = sesJqueryObject(".sesstories_content").find('img').attr('rel');
	var sliderBar = sesJqueryObject(".sesstories_story_slider_loader").children().eq(parseInt(index));
	var percentage = (currentTimeForStories * 100) / parseInt(sesstories_webstoryviewtime);
	sliderBar.find("span").find('span').css("width",percentage+"%");
	if(percentage == "100"){
		callNextStory();
	}else{
		currentTimeForStories++;
		if(!sesstoriesIntervalObj)
			sesstoriesIntervalObj = setInterval(runTimer, 1000);
	}
}
function imageLoaded() {
	breakTimeSesstories = false;
	runTimer();
}
function callPreviousStory(checkExist = false) {
	if(checkExist) {
		currentTimeForStories = 0
		breakTimeSesstories = true;
		if (sesstoriesIntervalObj) {
			clearInterval(sesstoriesIntervalObj);
			sesstoriesIntervalObj = undefined;
		}
	}
	var storyData = storiesData
	var valid = false
	if(storyData.my_story){
		//my story content
		if(storyData.my_story.user_id == selectedStoryUserId) {
			valid = true;
			var index = getStoryIndex(storyData.my_story.story_content,selectedStoryId);
			if(index > -1){
				if(index && index > index - 1){
					if(checkExist)
						return true;
					var storyData = storyData.my_story
					createSliders(0,0,storyData,index-1)
				}else{
					if(checkExist)
						return false;
					sesJqueryObject(".sesstories_content").html('');
					sesJqueryObject('.sesstories_story_view_close_btn').trigger("click");
				}
			}
		}
	}
	if(!valid){
		//user story content
		var index = getIndex(storyData.stories,selectedStoryUserId);
		var storyindex = getStoryIndex(storyData.stories[index].story_content,selectedStoryId);
		if( storyindex - 1 >= 0){
			if(checkExist)
				return true;
			var storyData = storyData.stories[index]
			createSliders(0,0,storyData,storyindex-1)
		}else if( index-1 >= 0){
			if(checkExist)
				return true;
			var storyData = storyData.stories[index-1]
			createSliders(0,0,storyData,0)
		}else if(storyData.my_story.story_content && storyData.my_story.story_content.length){
			if(checkExist)
				return true;
			var storyData = storyData.my_story
			createSliders(0,0,storyData,0)
		}else{
			if(checkExist)
				return false;
			sesJqueryObject(".sesstories_content").html('');
			sesJqueryObject('.sesstories_story_view_close_btn').trigger("click");
		}
	}
}
//hover on reactions
var sesStoriesHoverItem = false;
var stopTimerSesstories = false;
sesJqueryObject(function() {
	sesJqueryObject('.sesstories_story_item_reply_box').hover( function(){
			seshoverStopPlay(true);
		},
		function(){
			if(!stopTimerSesstories)
				seshoverStopPlay(false);
		});
});
function callNextStory(checkExist = false) {
	if(checkExist) {
		currentTimeForStories = 0
		breakTimeSesstories = true;
		if (sesstoriesIntervalObj) {
			clearInterval(sesstoriesIntervalObj);
			sesstoriesIntervalObj = undefined;
		}
	}
	var storyData = storiesData
	var valid = false
	if(storyData.my_story){
		//my story content
		if(storyData.my_story.user_id == selectedStoryUserId) {
			valid = true;
			var index = getStoryIndex(storyData.my_story.story_content,selectedStoryId);
			if(index > -1){
				var dataStory = storyData['my_story']['story_content'][index]
				if(storyData['my_story']['story_content'].length > index + 1){
					if(checkExist)
						return true;
					var storyData = storyData.my_story
					createSliders(0,0,storyData,index+1)
				}else if(storyData.stories && storyData.stories.length){
					if(checkExist)
						return true;
					createSliders(0,0,storyData.stories[0],0);
				}else{
					if(checkExist)
						return false;
					sesJqueryObject(".sesstories_content").html('');
					sesJqueryObject('.sesstories_story_view_close_btn').trigger("click");
				}
			}
		}
	}
	if(!valid){
		//user story content
		var index = getIndex(storyData.stories,selectedStoryUserId);
		var storyindex = getStoryIndex(storyData.stories[index].story_content,selectedStoryId)
		if(storyData.stories[index]['story_content'].length > storyindex + 1){
			if(checkExist)
				return true;
			var storyData = storyData.stories[index]
			createSliders(0,0,storyData,storyindex+1)
		}else if(storyData.stories.length > index+1){
			if(checkExist)
				return true;
			var storyData = storyData.stories[index+1]
			createSliders(0,0,storyData,0)
		}else{
			if(checkExist)
				return false;
			sesJqueryObject(".sesstories_content").html('');
			sesJqueryObject('.sesstories_story_view_close_btn').trigger("click");
		}
	}
}
sesJqueryObject(document).on('click','.sesstories_previous',function (e) {
	e.preventDefault();

})
sesJqueryObject(document).on('click','.sesstories_next',function (e) {
	e.preventDefault();
	callNextStory();
})

sesJqueryObject(document).on('click','.sesstories_previous',function (e) {
	e.preventDefault();
	callPreviousStory();
})
sesJqueryObject(document).on("click",'.sessmoothbox',function (e) {
	if(sesJqueryObject(".sesstories_story_view_main").css('display') == "block"){
		seshoverStopPlay(true);
	}
})
function sessmoothboxcallbackclose() {
	seshoverStopPlay(false);
}
function updateStoryReactionData(data){
	if(data.reactionData && data.reactionData.length){
		if(data.like.image) {
			sesJqueryObject(".sesstories_comment_d").removeClass("_icon");
			sesJqueryObject(".sesstories_comment_d").css('background-image', 'url(' + data.like.image + ')');
		}
		var reactionImages = "";
		data.reactionData.forEach(item => {
			reactionImages =  reactionImages + '<span class="comments_likes_reactions"><a title="'+item['title']+'" href="javascript:;" class="sessmoothbox" data-url="sesadvancedactivity/ajax/likes/type//id/'+selectedStoryId+'/resource_type/sesstories_story/item_id/'+selectedStoryId+'/format/smoothbox"><i style="background-image:url('+item['imageUrl']+');"></i></a></span>';
		});
		var finalData = '<div class="comments_stats_likes">'+reactionImages+
			'<a href="javascript:;" class="sessmoothbox" data-url="sesadvancedcomment/ajax/likes/type//id/'+selectedStoryId+'/resource_type/sesstories_story/item_id/'+selectedStoryId+'/format/smoothbox">  '+data.reactionUserData+'</a>'+
			'</div>';
		sesJqueryObject(".sesstories_reaction_data").html(finalData);
	}else{
		sesJqueryObject(".sesstories_reaction_data").html('');
		sesJqueryObject(".sesstories_comment_d").css('background-image','url()');
		sesJqueryObject(".sesstories_comment_d").addClass("_icon");
	}
}
sesJqueryObject(document).on('click','.open_sesstory',function (e) {
	breakTimeSesstories=false;
	currentTimeForStories = 0;
	var rel = parseInt(sesJqueryObject(this).attr('rel'));
	var id = en4.user.viewer.id;
	var storyData;
	storyData = getStories();
	//make sliders sesstories_story_slider_loader
	if(typeof selectedStoryId != "undefined"){
		var storyData = storiesData
		var valid = false
		if(storyData.my_story){
			//my story content
			if(storyData.my_story.user_id == selectedStoryUserId) {
				var index = getStoryIndex(storyData.my_story.story_content,selectedStoryId);
				if(index > -1){
					valid = true;
					var storyData = storyData.my_story
					createSliders(0,0,storyData,index)
					sesJqueryObject(".sesstories_story_view_main").show();
				}
			}
		}
		if(!valid){
			//user story content
			if(storyData.stories) {
				var index = getIndex(storyData.stories, selectedStoryUserId);
				var storyindex = getStoryIndex(storyData.stories[index].story_content, selectedStoryId);
				if (storyindex > -1) {
					storyData = storyData.stories[index]
					var storyData = storyData.my_story
					createSliders(0, 0, storyData, storyindex)
					sesJqueryObject(".sesstories_story_view_main").show();
				} else {
					sesJqueryObject(".sesstories_content").html('');
					sesJqueryObject('.sesstories_story_view_close_btn').trigger("click");
					alert("Story you are looking does not exists.");
				}
			}else{
				sesJqueryObject(".sesstories_content").html('');
				sesJqueryObject('.sesstories_story_view_close_btn').trigger("click");
				alert("Story you are looking does not exists.");
			}
		}
	}else{
		createSliders(rel,id);
		sesJqueryObject(".sesstories_story_view_main").show();
	}
})
sesJqueryObject(document).on('click','.sesstories_story_view_close_btn',function (e) {
	e.preventDefault();
	breakTimeSesstories=true;
	if(sesstoriesIntervalObj){
		clearInterval(sesstoriesIntervalObj);
		sesstoriesIntervalObj = undefined;
	}
	selectedStoryId = undefined;
	seshoverStopPlay(true);
	sesJqueryObject(".sesstories_story_view_main").hide();
})

sesJqueryObject(document).on('click','.sesstoriescommentlike',function(){
	var obj = sesJqueryObject(this);
	previousSesadvcommLikeObj = obj.closest('.sesadvcmt_hoverbox_wrapper');
	var story_id = selectedStoryId;
	//var guid = sesJqueryObject(this).attr('data-guid');

	var type = sesJqueryObject(this).attr('data-type');
	var datatext = sesJqueryObject(this).attr('data-text');
	//check for like
	var isLikeElem = false;
	if(sesJqueryObject(this).hasClass('reaction_btn')){
		var image = sesJqueryObject(this).find('.reaction').find('i').css('background-image');
		image = image.replace('url(','').replace(')','').replace(/\"/gi, "");
		var elem = sesJqueryObject(this).parent().parent().parent().find('a');
		isLikeElem = true;
	}else{
		var image = sesJqueryObject(this).parent().find('.sesadvcmt_hoverbox').find('span').first().find('.reaction_btn').find('.reaction').find('i').css('background-image');
		image = image.replace('url(','').replace(')','').replace(/\"/gi, "");
		var elem = sesJqueryObject(this);
		isLikeElem = false
	}

	var likeWorkText = sesJqueryObject(elem).attr('data-like');
	var unlikeWordText = sesJqueryObject(elem).attr('data-unlike');

	//unlike
	if(sesJqueryObject(elem).hasClass('_reaction') && !isLikeElem){
		sesJqueryObject(elem).find('i').removeAttr('style');
		sesJqueryObject(elem).find('span').html(unlikeWordText);
		sesJqueryObject(elem).removeClass('sesstoriescommentunlike').removeClass('_reaction').addClass('sesstoriescommentlike');
		sesJqueryObject(elem).parent().addClass('feed_item_option_like').removeClass('feed_item_option_unlike');
	}else{
		//like
		sesJqueryObject(elem).find('i').css('background-image', 'url(' + image + ')');
		sesJqueryObject(elem).find('span').html(datatext);
		sesJqueryObject(elem).removeClass('sesstoriescommentlike').addClass('_reaction').addClass('sesstoriescommentunlike');
		sesJqueryObject(elem).parent().addClass('feed_item_option_unlike').removeClass('feed_item_option_like');
	}
	sesJqueryObject(".sesstories_comment_d").removeClass('_icon');
	var ajax = new Request.JSON({
		url : en4.core.baseUrl + 'sesstories/index/like',
		data : {
			format : 'json',
			story_id : story_id,
			type:type
		},
		'onComplete' : function(responseHTML) {
			if( responseHTML ) {
				changeDataReaction(responseHTML);
			}
		}
	});
	ajax.send();
});
//like feed action content
sesJqueryObject(document).on('click','.sesstoriescommentunlike',function(){
	var obj = sesJqueryObject(this);
	var story_id = selectedStoryId;
	var type = sesJqueryObject(this).attr('data-type');
	var datatext = sesJqueryObject(this).attr('data-text');
	var likeWorkText = sesJqueryObject(this).attr('data-like');
	var unlikeWordText = sesJqueryObject(this).attr('data-unlike');

	//check for unlike
	sesJqueryObject(this).find('i').removeAttr('style');
	sesJqueryObject(this).find('span').html(likeWorkText);
	sesJqueryObject(this).removeClass('sesstoriescommentunlike').removeClass('_reaction').addClass('sesstoriescommentlike');
	sesJqueryObject(this).parent().addClass('feed_item_option_like').removeClass('feed_item_option_unlike');
	sesJqueryObject(".sesstories_comment_d").addClass('_icon');
	var ajax = new Request.JSON({
		url : en4.core.baseUrl + 'sesstories/index/unlike',
		data : {
			format : 'json',
			story_id : story_id,
			type:type
		},
		'onComplete' : function(responseHTML) {
			if( responseHTML ) {
				changeDataReaction(responseHTML);

			}
		}
	});
	ajax.send();
});
function changeDataReaction(responseHTML){
	var valid = true;
	var storyData = storiesData
	var data;
	if(storyData.my_story){
		//my story content
		if(storyData.my_story.user_id == selectedStoryUserId) {
			valid = true;
			var index = getStoryIndex(storyData.my_story.story_content,selectedStoryId);
			if(index > -1){
				storyData['my_story']['story_content'][index]['reactionData'] = responseHTML.reactionData['reactionData'];
				storyData['my_story']['story_content'][index]['is_like'] = responseHTML.reactionData['is_like'];
				storyData['my_story']['story_content'][index]['like'] = responseHTML.reactionData['like'];
				storyData['my_story']['story_content'][index]['reactionUserData'] = responseHTML.reactionData['reactionUserData'];
				data = storyData['my_story']['story_content'][index]
			}
		}
	}
	if(!valid){
		//user story content
		var index = getIndex(storyData.stories,selectedStoryUserId)
		var storyindex = getStoryIndex(storyData.stories[index].story_content,selectedStoryId)
		storyData.stories[index]['story_content'][storyindex]['reactionData'] = responseHTML.reactionData['reactionData'];
		storyData.stories[index]['story_content'][storyindex]['is_like'] = responseHTML.reactionData['is_like'];
		storyData.stories[index]['story_content'][storyindex]['like'] = responseHTML.reactionData['like'];
		storyData.stories[index]['story_content'][storyindex]['reactionUserData'] = responseHTML.reactionData['reactionUserData'];
		data = storyData.stories[index]['story_content'][storyindex]
	}
	storiesData = storyData;
	updateStoryReactionData(data)
}
sesJqueryObject(document).on('click','#sesstories_setting_cnt > li',function (e) {
	var index = sesJqueryObject(this).index();
	sesJqueryObject("._active").removeClass("_active");
	sesJqueryObject(this).find("a").addClass('_active');
	sesJqueryObject('.sesstories_archive_popup_cont').children().hide();
	sesJqueryObject('.sesstories_archive_popup_cont').children().eq(index).show();
});

sesJqueryObject(document).on('click','.sestrories_highlight',function (e) {
	var id = sesJqueryObject(this).attr('rel');
	if(sesJqueryObject(this).hasClass('_active')){
		sesJqueryObject(this).removeClass('_active')
	}else{
		sesJqueryObject(this).addClass('_active')
	}
	sesJqueryObject.post(en4.core.baseUrl + 'sesstories/index/highlight',{story_id:id},function (e) {

	})
})

sesJqueryObject(document).on('click','.sesstories_unmute',function (e) {
	var id = sesJqueryObject(this).attr('rel');
	sesJqueryObject(this).closest('li').remove();
	sesJqueryObject.post(en4.core.baseUrl + 'sesstories/index/unmute',{mute_id:id},function (e) {

	})
});
sesJqueryObject(document).on('submit','#sesstories_form_create',function (e) {
	e.preventDefault();
	sesJqueryObject.post(en4.core.baseUrl + 'sesstories/index/save-form',{story_privacy:sesJqueryObject("input[name='story_privacy']:checked").val()
		,story_comment:sesJqueryObject("input[name='story_comment']:checked").val()},function (response) {
		alert(response)
	})
});
sesJqueryObject(document).on('keypress','.sesstories_message_cnt_input',function (e) {
	if (e.which == 13) {
		var value = sesJqueryObject(this).val();
		if(value){
			sesJqueryObject(this).val("");
			sesJqueryObject('.sesstories_reply_success_msg').show();
			setTimeout(function () {
				sesJqueryObject('.sesstories_reply_success_msg').hide();
			},2000)
			sesJqueryObject.post(en4.core.baseUrl + 'sesstories/index/message',{data:value,owner_id:selectedStoryUserId},function (response) {

			})
		}
	}
});
