//Like Function
function sesforumLike(resource_id, resource_type) {

  if ($(resource_type + '_likehidden_' + resource_id))
    var like_id = $(resource_type + '_likehidden_' + resource_id).value

  en4.core.request.send(new Request.JSON({
    url: en4.core.baseUrl + 'sesforum/index/like',
    data: {
      format: 'json',
      'resource_type': resource_type,
      'resource_id': resource_id,
      'like_id': like_id
    },
    onSuccess: function(responseJSON) {
      if (responseJSON.like_id) {
        if ($(resource_type + '_unlike_' + resource_id))
          $(resource_type + '_unlike_' + resource_id).style.display = 'inline-block';
        if ($(resource_type + '_likehidden_' + resource_id))
          $(resource_type + '_likehidden_' + resource_id).value = responseJSON.like_id;
        if ($(resource_type + '_like_' + resource_id))
          $(resource_type + '_like_' + resource_id).style.display = 'none';
      } else {
        if ($(resource_type + '_likehidden_' + resource_id))
          $(resource_type + '_likehidden_' + resource_id).value = 0;
        if ($(resource_type + '_unlike_' + resource_id))
          $(resource_type + '_unlike_' + resource_id).style.display = 'none';
        if ($(resource_type + '_like_' + resource_id))
          $(resource_type + '_like_' + resource_id).style.display = 'inline-block';

      }
    }
  }));
}

//Subscribe Function
function sesforumSubscribe(resource_id, resource_type) {

  if ($(resource_type + '_subscribehidden_' + resource_id))
    var subscribe_id = $(resource_type + '_subscribehidden_' + resource_id).value

  en4.core.request.send(new Request.JSON({
    url: en4.core.baseUrl + 'sesforum/index/subscribe',
    data: {
      format: 'json',
      'resource_type': resource_type,
      'resource_id': resource_id,
      'subscribe_id': subscribe_id
    },
    onSuccess: function(responseJSON) {
      if (responseJSON.subscribe_id) {
        if ($(resource_type + '_unsubscribe_' + resource_id))
          $(resource_type + '_unsubscribe_' + resource_id).style.display = 'inline-block';
        if ($(resource_type + '_subscribehidden_' + resource_id))
          $(resource_type + '_subscribehidden_' + resource_id).value = responseJSON.subscribe_id;
        if ($(resource_type + '_subscribe_' + resource_id))
          $(resource_type + '_subscribe_' + resource_id).style.display = 'none';
      } else {
        if ($(resource_type + '_subscribehidden_' + resource_id))
          $(resource_type + '_subscribehidden_' + resource_id).value = 0;
        if ($(resource_type + '_unsubscribe_' + resource_id))
          $(resource_type + '_unsubscribe_' + resource_id).style.display = 'none';
        if ($(resource_type + '_subscribe_' + resource_id))
          $(resource_type + '_subscribe_' + resource_id).style.display = 'inline-block';

      }
    }
  }));
}

function sesTopicThank(resource_id, resource_type, topicuser_id) {

  if ($(resource_type + '_thankhidden_' + resource_id))
    var thank_id = $(resource_type + '_thankhidden_' + resource_id).value

  en4.core.request.send(new Request.JSON({
    url: en4.core.baseUrl + 'sesforum/index/thank',
    data: {
      format: 'json',
      'thank_id': thank_id,
      'topicuser_id': topicuser_id,
      'resource_id' : resource_id,
      'resource_type' : resource_type,
    },
    onSuccess: function(responseJSON) {
      if (responseJSON.thank_id) {
        if ($(resource_type + '_thankhidden_' + resource_id))
          $(resource_type + '_thankhidden_' + resource_id).value = responseJSON.thank_id;
        if ($(resource_type + '_thank_' + resource_id))
          $(resource_type + '_thank_' + resource_id).style.display = 'none';
      }
    }
  }));
}
