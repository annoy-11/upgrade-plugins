
var sesaddFriendRequest,sescancelFriendRequest, sesremoveFriend, sesacceptFriend;
scriptJquery(document).on('click', '.einstaclone_member_addfriend_request', function() {
    var sesthis = this;
		var data = {
      'user_id' : scriptJquery(this).attr('data-src'),
      'format' : 'html',
			'parambutton': scriptJquery(this).attr('data-rel'),
    };
  if(typeof sesaddFriendRequest != 'undefined')
    sesaddFriendRequest.cancel();
	 data[scriptJquery(this).attr('data-tokenname')] = scriptJquery(this).attr('data-tokenvalue');
   sesaddFriendRequest =  (new Request.HTML({
     url: en4.core.baseUrl + 'einstaclone/membership/add-friend',
    'data': data,
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavascript) {
			var result = scriptJquery.parseJSON(responseHTML);
			if(result.status == 1){
     		scriptJquery(sesthis).parent().html(result.message);
				
			}
			else
				 en4.core.showError(en4.core.language.translate(result.message));
    }
  })).send();
  
});

scriptJquery(document).on('click', '.einstaclone_member_cancelfriend_request', function() {
  
    var sesthis = this;
		var data = {
      'user_id' : scriptJquery(this).attr('data-src'),
      'format' : 'html',
			'parambutton': scriptJquery(this).attr('data-rel'),
    };
    if(typeof sescancelFriendRequest != 'undefined')
      sescancelFriendRequest.cancel();
		data[scriptJquery(this).attr('data-tokenname')] = scriptJquery(this).attr('data-tokenvalue');
    sescancelFriendRequest = (new Request.HTML({
      url: en4.core.baseUrl + 'einstaclone/membership/cancel-friend',
    'data': data,
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavascript) {
     var result = scriptJquery.parseJSON(responseHTML);
			if(result.status == 1){
     		scriptJquery(sesthis).parent().html(result.message);
				
			}
			else
				 en4.core.showError(en4.core.language.translate(result.message));
    }
  })).send();
});

scriptJquery(document).on('click', '.einstaclone_member_removefriend_request', function() {
    var sesthis = this;
		var data = {
      'user_id' : scriptJquery(this).attr('data-src'),
      'format' : 'html',
			'parambutton': scriptJquery(this).attr('data-rel'),
    };
    if(typeof sesremoveFriend != 'undefined')
      sesremoveFriend.cancel();
		data[scriptJquery(this).attr('data-tokenname')] = scriptJquery(this).attr('data-tokenvalue');
    sesremoveFriend = (new Request.HTML({
      url: en4.core.baseUrl + 'einstaclone/membership/remove-friend',
    'data':data,
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavascript) {
    var result = scriptJquery.parseJSON(responseHTML);
			if(result.status == 1){
     		scriptJquery(sesthis).parent().html(result.message);
				
			}
			else
				 en4.core.showError(en4.core.language.translate(result.message));
    }
  })).send();
});

scriptJquery(document).on('click', '.einstaclone_member_acceptfriend_request', function() {
    var sesthis = this;
		var data = {
      'user_id' : scriptJquery(this).attr('data-src'),
      'format' : 'html',
			'parambutton': scriptJquery(this).attr('data-rel'),
    };
    if(typeof sesacceptFriend != 'undefined')
      sesacceptFriend.cancel();
		data[scriptJquery(this).attr('data-tokenname')] = scriptJquery(this).attr('data-tokenvalue');
    sesacceptFriend = (new Request.HTML({
      url: en4.core.baseUrl + 'einstaclone/membership/accept-friend',
    'data': data,
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavascript) {
    var result = scriptJquery.parseJSON(responseHTML);
			if(result.status == 1){
     		scriptJquery(sesthis).parent().html(result.message);
			}
			else
				 en4.core.showError(en4.core.language.translate(result.message));
    }
  })).send();
});
