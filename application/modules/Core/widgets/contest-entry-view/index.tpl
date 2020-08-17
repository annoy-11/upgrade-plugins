<?php 

?>

<div class="sescontest_entry_view_container sesbasic_clearfix sesbasic_bxs">
	
	<div class="sescontest_entry_view_top sesbasic_clearfix">
  	<div class="sescontest_entry_view_top_left">
    	<h1>Retouch - First try</h1>
      <p class="sesbasic_text_light">
      	<span>on <b><a href="">Photo Contest</a></b></span>
      	<span>&nbsp;|&nbsp;<i class="fa fa-trophy"></i> <b>$500</b></span>
      </p>
    </div>
    <div class="sescontest_entry_view_top_btns">
    	<span class="sescontest_entry_view_top_nav floatR">
      	<a href="#" class="sesbasic_button" title="Previous Entry"><i class="fa fa-angle-left"></i></a>
        <a href="#" class="sesbasic_button" title="Next Entry"><i class="fa fa-angle-right"></i></a>
      </span>
    </div>
  </div>
  
  <div class="sescontest_entry_view_media sescontest_entry_view_media_photo">
  	<img onload='doResizeForButton()' src="https://s-media-cache-ak0.pinimg.com/564x/18/72/be/1872be9bdb490a532445b21972b52666.jpg" />
  </div>
  
  <div class="sescontest_entry_view_info sesbasic_clearfix">
  	<div class="sescontest_entry_view_info_left">
  		<div class="sescontest_entry_view_owner_photo">
      	<a href="#"><img src="http://d3okg4nk8t8inh.cloudfront.net/public/user/11/74/b3d23a73ac884a14a40d208a55c7c1c0.jpg"></a>
      </div>
      <div class="sescontest_entry_view_owner_info">
      	<div class="sescontest_entry_view_owner_name">
        	<a href="#">Bharat Negi</a>
        </div>
      </div>
    </div>
  	<div class="sescontest_entry_view_info_right sescontest_entry_view_info_stats">
    	<div>
      	<span>116</span>
        <span class="sesbasic_text_light">Likes</span>
      </div>
      <div>
      	<span>116</span>
        <span class="sesbasic_text_light">Comments</span>
      </div>
      <div>
      	<span>116</span>
        <span class="sesbasic_text_light">Views</span>
      </div>
      <div>
      	<span>116</span>
        <span class="sesbasic_text_light">Favorites</span>
      </div>
    </div>
  </div>
  
  
	<div class="sescontest_entry_view_btns sesbasic_clearfix">
  	<div class="floatL">
    	<div class="sescontest_view_social_btns">
        <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn button_active"><i class="fa fa-thumbs-up"></i><span>8</span></a>
			<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn button_active"><i class="fa fa-heart"></i><span>6</span></a>
        <a href="#" class="sesbasic_icon_btn sesbasic_icon_facebook_btn"><i class="fa fa-facebook"></i></a>
        <a href="#" class="sesbasic_icon_btn sesbasic_icon_twitter_btn"><i class="fa fa-twitter"></i></a>
        <a href="#" class="sesbasic_icon_btn sesbasic_icon_pintrest_btn"><i class="fa fa-pinterest"></i></a>                       
      </div>
    </div>
    <div class="floatR sescontest_entry_view_btns_right">
    	<span class="total_votes">25 Votes</span>
      <span><a href="#" class="contest_join_btn"><span>VOTE</span></a></span>
      <span><a href="javascript:vois(0);" class="sesbasic_button sescontest_entry_view_option_btn" id="sescontest_entry_view_option_btn"><i class="fa fa-cog"></i></a></span>
    </div>
  </div>
  <div class="sescontest_entry_view_des">
  	It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
  </div>
</div>

<div class="sescontest_entry_view_options sescontest_options_dropdown" id="sescontest_entry_view_options">
	<span class="sescontest_options_dropdown_arrow"></span>
	<div class="sescontest_options_dropdown_links">
  	<ul>
    	<li><a href="#" class="buttonlink sesbasic_icon_edit">Edit Entry</a></li>
      <li><a href="#" class="buttonlink sesbasic_icon_delete">Delete Entry</a></li>
      <li><a href="#" class="buttonlink sesbasic_icon_share">Share Entry</a></li>
      <li><a href="#" class="buttonlink sesbasic_icon_report">Report Entry</a></li>
    </ul>
  </div>
</div>
<script type="text/javascript">
function doResizeForButton(){
	var topPositionOfParentSpan =  sesJqueryObject(".sescontest_entry_view_option_btn").offset().top + 34;
	topPositionOfParentSpan = topPositionOfParentSpan+'px';
	var leftPositionOfParentSpan =  sesJqueryObject(".sescontest_entry_view_option_btn").offset().left - 96;
	leftPositionOfParentSpan = leftPositionOfParentSpan+'px';
	sesJqueryObject('.sescontest_entry_view_options').css('top',topPositionOfParentSpan);
	sesJqueryObject('.sescontest_entry_view_options').css('left',leftPositionOfParentSpan);
}
window.addEvent('load',function(){
	doResizeForButton();
});
sesJqueryObject(window).resize(function(){
	doResizeForButton();
});
$('sescontest_entry_view_option_btn').addEvent('click', function(event){
	event.stop();
	if($('sescontest_entry_view_options').hasClass('show-options'))
		$('sescontest_entry_view_options').removeClass('show-options');
	else
		$('sescontest_entry_view_options').addClass('show-options');
	return false;
});
</script>