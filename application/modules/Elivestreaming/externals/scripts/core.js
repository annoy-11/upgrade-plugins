var dataEliveStreamingUserId = '';
var dataEliveStreamingActionId = '';
var dataEliveStreamingStoryId = '';
var dataEliveStreamingHostId = '';
sesJqueryObject(document).on("click",'.elivestreaming_data_a',function (e) {
    e.preventDefault();
    dataEliveStreamingUserId = sesJqueryObject(this).data('user');
    dataEliveStreamingActionId = sesJqueryObject(this).data('action');
    dataEliveStreamingStoryId = sesJqueryObject(this).data('story');
    dataEliveStreamingHostId = sesJqueryObject(this).data('hostid');
    if(elLiveStreamingCheckContentData) {
        console.log(elLiveStreamingCheckContentData);
        var iframeURL = elLiveStreamingCheckContentData.elivestreaming_linux_base_url;
        sesJqueryObject("body").append("<div class='elive_loading'><span></span></div>");
        sesJqueryObject("body").append('<iframe id="elivestreaming_host_popup_iframe" src="'+iframeURL+'" allow="camera;microphone" style="height: 100%;width: 100%;position:fixed;top:0;z-index: 100;left:0"></iframe>');
    }
});

if (window.addEventListener) {
    window.addEventListener("message", closeIframeelivestreaming);
    window.addEventListener("message", getEliveStreamingDefaultOptions);
} else {
    window.attachEvent("onmessage", closeIframeelivestreaming);
    window.addEventListener("onmessage", getEliveStreamingDefaultOptions);
}
function getEliveStreamingDefaultOptions(evt) {
    if (evt.data == "getLiveSteamingData") {
        var frame = sesJqueryObject("#elivestreaming_popup_iframe");
        if(frame.length)
            document.getElementById("elivestreaming_popup_iframe").contentWindow.postMessage({defaultVal:"livestreaming",value:elLiveStreamingContentData}, '*');
        else{
            var elLiveStreamingCheckContentDataJson = elLiveStreamingCheckContentData
            elLiveStreamingCheckContentDataJson['elivehost_id'] = dataEliveStreamingHostId;
            elLiveStreamingCheckContentDataJson['story_id'] = dataEliveStreamingStoryId;
            elLiveStreamingCheckContentDataJson['user_id'] = dataEliveStreamingUserId;
            elLiveStreamingCheckContentDataJson['activity_id'] = dataEliveStreamingActionId;
            document.getElementById("elivestreaming_host_popup_iframe").contentWindow.postMessage({defaultVal:"livestreaming",value:elLiveStreamingCheckContentData}, '*');
        }
    }
}
function closeIframeelivestreaming(evt) {
    sesJqueryObject(".elive_loading").remove();
    if (evt.data == "closePopup") {
        var frame = sesJqueryObject("#elivestreaming_popup_iframe");
        if(frame.length)
            sesJqueryObject('#elivestreaming_popup_iframe').remove();
        else{
            sesJqueryObject('#elivestreaming_host_popup_iframe').remove();
        }
    }
}