
/* $Id: core.js 9572 2011-12-27 23:41:06Z john $ */

(function() { // START NAMESPACE
var $ = 'id' in document ? document.id : window.$;

en4.sespagepoll = {

  urls : {
    vote : 'polls/vote/',
    login : 'login'
  },

  data : {},

  addPollData : function(identity, data) {
    if( $type(data) != 'object' ) {
      data = {};
    }
    data = $H(data);
    this.data[identity] = data;
    return this;
  },

  getPollDatum : function(identity, key, defaultValue) {
    if( !defaultValue ) {
      defaultValue = false;
    }
    if( !(identity in this.data) ) {
      return defaultValue;
    }
    if( !(key in this.data[identity]) ) {
      return defaultValue;
    }
    return this.data[identity][key];
  },

  toggleResults : function(identity) {
    var pollContainer = $('sespagepoll_form_' + identity);
    if( 'none' == pollContainer.getElement('.sespagepoll_options div.sespagepoll_has_voted').getStyle('display') ) {
      pollContainer.getElements('.sespagepoll_options div.sespagepoll_has_voted').setStyle('display', 'flex');
      pollContainer.getElements('.sespagepoll_options div.sespagepoll_not_voted').hide();
      pollContainer.getElement('.sespagepoll_toggleResultsLink').set('text', en4.core.language.translate('Show Questions'));
    } else {
      pollContainer.getElements('.sespagepoll_options div.sespagepoll_has_voted').hide();
      pollContainer.getElements('.sespagepoll_options div.sespagepoll_not_voted').setStyle('display', 'flex');
      pollContainer.getElement('.sespagepoll_toggleResultsLink').set('text', en4.core.language.translate('Show Results'));
    }
  },

  renderResults : function(identity, answers, votes ,userview) {
    if( !answers || 'array' != $type(answers) ) {
      return;
    }
    var pollContainer = $('sespagepoll_form_' + identity);
		var counter = 0
    answers.each(function(option) {
      var div = $('sespagepoll-answer-' + option.poll_option_id);
      var pct = votes > 0
              ? Math.floor(100*(option.votes / votes))
              : 1;
      if (pct < 1)
          pct = 1;
      div.style.width = (1*pct)+'%';
      div.getParent().getNext('div.sespagepoll_answer_total')
         .set('text',  option.votesTranslated + ' (' + en4.core.language.translate('%1$s%%', (option.votes ? pct : '0')) + ')');
					sesJqueryObject('#sespagepoll_user_photo_'+option.poll_option_id).html(userview[counter]);
				 counter = counter + 1;
          if($('sespagepoll_delete_link') || $('sespagepoll_edit_link')){
            $('sespagepoll_delete_link').setStyle('display', 'none');
            $('sespagepoll_edit_link').setStyle('display', 'none');
          }
      if( !this.getPollDatum(identity, 'canVote') ||(!this.getPollDatum(identity, 'canChangeVote') && this.getPollDatum(identity, 'hasVoted')) || this.getPollDatum(identity, 'isClosed')) {
		 
        pollContainer.getElement('.sespagepoll_radio input').set('disabled', true);
      }
    }.bind(this));
  },

  vote: function(identity, option , isVoteShow) {
    if( !en4.user.viewer.id ) {
      window.location.href = this.urls.login + '?return_url=' + encodeURIComponent(window.location.href);
      return;
    }
    //if( en4.core.subject.type != 'poll' ) {
    //  return;
    //}
    if( $type(option) != 'element' ) {
      return;
    }
    option = $(option);

    var pollContainer = $('sespagepoll_form_' + identity);
    var value = option.value;

    $('sespagepoll_item_option_' + option.value).toggleClass('sespagepoll_radio_loading');
    var token = this.data[identity].csrfToken;
    var self = this;
    var request = new Request.JSON({
      url: this.urls.vote + '/' + identity,
      method: 'post',
      data : {
        'format' : 'json',
        'poll_id' : identity,
        'option_id' : value,
        'token': token
      },
      onComplete: function(responseJSON) {
				var userview =  responseJSON.users;
        $('sespagepoll_item_option_' + option.value).toggleClass('sespagepoll_radio_loading');
        if( $type(responseJSON) == 'object' && responseJSON.error ) {
          Smoothbox.open(new Element('div', {
            'html' : responseJSON.error
              + '<br /><br /><button onclick="parent.Smoothbox.close()">'
              + en4.core.language.translate('Close')
              + '</button>'
          }));
        } else {
			if(isVoteShow){
				pollContainer.getElement('.sespagepoll_vote_total').set('text', en4.core.language.translate(['%1$s vote', '%1$s votes', responseJSON.votes_total], responseJSON.votes_total));
			}
          this.renderResults(identity, responseJSON.pollOptions, responseJSON.votes_total,userview);
          this.toggleResults(identity);
          self.data[identity].csrfToken = responseJSON.token;
        }
        if( !this.getPollDatum(identity, 'canChangeVote') ) {
          pollContainer.getElements('.sespagepoll_radio input').set('disabled', true);
        }
      }.bind(this)
    });

    request.send()
  }
};
})(); // END NAMESPACE


