
sesJqueryObject(document).on('submit', '#sesshoutbox_editmessage', function(e) {
  e.preventDefault();
  editMessage(this);
});
