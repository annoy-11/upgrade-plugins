sesJqueryObject(document).on('click','.sesadvheader_search_optn',function(e){
  var elem = sesJqueryObject(this).closest('.exp_select').find('.exp_select_option'); 
  if(elem.hasClass('show-options')){
      elem.removeClass('show-options');
  }else{
      elem.addClass('show-options');
  }
});

sesJqueryObject(document).on('click','.sesadvheader_search_btn',function(e){
   var elem = sesJqueryObject(this).closest('.header_left');
   if(elem.length > 0){
       elem =  sesJqueryObject(this).closest('.header_left');
   }else{
        elem =  sesJqueryObject(this).closest('.header_scroll_serchbox');  
   }
   var type = elem.find('.search_hidden_val').val();
   var text = elem.find('.header_searchbox').find('input').val();
   window.location.href= 'search' + "?query=" + text+'&type='+type;
});

//close all dropdown
sesJqueryObject(document).click(function(e){
  //search options hide
  if(!sesJqueryObject(e.target).closest('.exp_select').length)
    sesJqueryObject('.show-options').removeClass('show-options');
  if(!sesJqueryObject(e.target).closest('.header_scroll_serchbox').length){
    sesJqueryObject('.header_scroll_serchbox').removeClass('open');
    sesJqueryObject('.header_bottom_searchbox').hide();
  }
  //remove notification
  if(!sesJqueryObject(e.target).closest('.exp_select').length)
    sesJqueryObject('.show-options').removeClass('show-options');
  if(!sesJqueryObject(e.target).closest('.header_middle').length){
    sesJqueryObject('.header_sidebar_panel').removeClass('header_sidebar_panel'); 
    sesJqueryObject('.main_menu_toggle_btn').removeClass('active');  
  }
  if(!sesJqueryObject(e.target).closest('#core_menu_mini_menu_update').length)
    sesJqueryObject('.updates_pulldown_active').addClass('updates_pulldown').removeClass('updates_pulldown_active');
    
  if(!sesJqueryObject(e.target).closest('.sesadvheader_minimenu_request').length)
     sesJqueryObject('.friends_pulldown_active').addClass('friends_pulldown').removeClass('friends_pulldown_active');
    
  if(!sesJqueryObject(e.target).closest('.sesadvheader_minimenu_message').length)
    sesJqueryObject('.messages_pulldown_active').addClass('messages_pulldown').removeClass('messages_pulldown_active');
    
  if(!sesJqueryObject(e.target).closest('.sesadvheader_minimenu_setting').length)
    sesJqueryObject('.settings_pulldown_active').addClass('settings_pulldown').removeClass('settings_pulldown_active');
  
})

sesJqueryObject(document).on('click','.header_scroll_serchbox a',function(e){
  var elem = sesJqueryObject(this).parent();
  if(elem.hasClass('open')){
    elem.removeClass('open');
    elem.find('.header_bottom_searchbox').hide();  
  }else{
    elem.addClass('open');
    elem.find('.header_bottom_searchbox').show();  
  }
})