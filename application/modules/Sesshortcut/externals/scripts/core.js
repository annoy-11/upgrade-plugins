
  function shortcutButton(id, type) {
    
    if ($(type + '_shortcutunshortcuthidden_' + id))
    var contentId = $(type + '_shortcutunshortcuthidden_' + id).value

    en4.core.request.send(new Request.JSON({
    url: en4.core.baseUrl + 'sesshortcut/index/shortcut',
    data: {
    format: 'json',
      'id': id,
      'type': type,
      'contentId': contentId
    },
    onSuccess: function(responseJSON) {
    
      if (responseJSON.shortcut_id) {
      } else {
        if ($('shortcutsmenu_' + id)) {
          sesJqueryObject('#shortcutsmenu_' + id).remove();
        }
        if ($(type + '_shortcutunshortcuthidden_' + id))
          $(type + '_shortcutunshortcuthidden_' + id).value = 0;

        if ($(type + '_unshortcut_' + id))
          $(type + '_unshortcut_' + id).style.display = 'none';
      }
    }
    }));
  }

  function pinToTop(shortcut_id) {
    en4.core.request.send(new Request.JSON({
      url: en4.core.baseUrl + 'sesshortcut/index/pintotop',
      data: {
      format: 'json',
        'shortcut_id': shortcut_id,
      },
      onSuccess: function(responseJSON) {
        sesJqueryObject('#sesshortcut_allmenus').prepend(sesJqueryObject('#shortcutsmenu_'+shortcut_id));
        sesJqueryObject('#unpintotop_'+shortcut_id).show();
        sesJqueryObject('#pinToTop_'+shortcut_id).hide();
        sesJqueryObject('.sesshortcut_menu_toggle').removeClass('showoption');
      }
    }));
  }
  
  function unpinToTop(shortcut_id) {
    en4.core.request.send(new Request.JSON({
      url: en4.core.baseUrl + 'sesshortcut/index/unpintotop',
      data: {
      format: 'json',
        'shortcut_id': shortcut_id,
      },
      onSuccess: function(responseJSON) {
        
        sesJqueryObject('#sesshortcut_allmenus').append(sesJqueryObject('#shortcutsmenu_'+shortcut_id));
        sesJqueryObject('#pinToTop_'+shortcut_id).show();
        sesJqueryObject('#unpintotop_'+shortcut_id).hide();
        sesJqueryObject('.sesshortcut_menu_toggle').removeClass('showoption');
      }
    }));
  }

  function showExtraMenu() {
    sesJqueryObject('#sesshortcut_menu_more').remove();
    sesJqueryObject('.sesshortcut_exta_menus').show();
  }

sesJqueryObject(document).on('click','.sesshortcut_menu_toggle',function(){
	if(sesJqueryObject(this).hasClass('showoption')) {
		sesJqueryObject(this).removeClass('showoption');
	} else {
		sesJqueryObject('.sespage_button_toggle').removeClass('showoption');
		sesJqueryObject(this).addClass('showoption');
	}
	return false;
});
	sesJqueryObject(document).click(function(){
	sesJqueryObject('.sesshortcut_menu_toggle').removeClass('showoption');
});