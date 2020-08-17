<?php 

?>

<div class="sescontest_view_container sesbasic_clearfix sesbasic_bxs">
	<div class="sescontest_view_top sesbasic_clearfix">
  	<div class="sescontest_view_owner_photo">
    	<a href="#"><img src="http://d3okg4nk8t8inh.cloudfront.net/public/user/11/74/b3d23a73ac884a14a40d208a55c7c1c0.jpg"></a>
    </div>
    <div class="sescontest_view_top_cont">
    	<h1>PHOTOGRAPHY WITH QUOTES show your talent!</h1>
    	<p class="sesbasic_clearfix sesbasic_text_light">
        <span>by <a href="#">Bharat Negi</a></span>
        <span>in <a href="#">Photography</a></span>
        <span class="sescontest_view_stats">&nbsp;|&nbsp; 
          <span>
            <i class="fa fa-thumbs-up"></i>
            <span>15 Likes</span>
          </span>
          <span>
            <i class="fa fa-comment"></i>
            <span>15 Comments</span>
          </span>
          <span>
            <i class="fa fa-eye"></i>
            <span>20 Views</span>
          </span>
          <span>
            <i class="fa fa-heart"></i>
            <span>15 Favorites</span>
          </span>
        </span>
      </p>
    </div>
    <div class="sescontest_view_type">
      <i class="fa fa-picture-o" title="Photo Contest"></i>
    </div>
  </div>
  
  <div class="sescontest_view_main_photo">
  	<img src="https://www.vancouvertrails.com/images/banners/photo-contest.jpg" />
  </div>
  <div class="sescontest_view_btns sesbasic_clearfix">
  	<div class="floatL">
    	<div class="sescontest_view_social_btns">
        <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn button_active"><i class="fa fa-thumbs-up"></i><span>8</span></a>
			<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn button_active"><i class="fa fa-heart"></i><span>6</span></a>
        <a href="#" class="sesbasic_icon_btn sesbasic_icon_facebook_btn"><i class="fa fa-facebook"></i></a>
        <a href="#" class="sesbasic_icon_btn sesbasic_icon_twitter_btn"><i class="fa fa-twitter"></i></a>
        <a href="#" class="sesbasic_icon_btn sesbasic_icon_pintrest_btn"><i class="fa fa-pinterest"></i></a>                       
      </div>
    </div>
    <div class="floatR sescontest_view_btns_right">
      <span><a href="#" class="contest_join_btn"><i class="fa fa-sign-in"></i><span>Join Contest</span></a></span>
      <span><a href="javascript:void(0);" class="sesbasic_button sescontest_view_option_btn" id="sescontest_view_option_btn"><i class="fa fa-cog"></i></a></span>
    </div>
  </div>
  <div class="sescontest_view_des">
  	<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
  </div>
  
  <div class="sescontest_view_info sesbasic_clearfix">
  	<div>
    	<span class="sescontest_view_info_det">19.05.17</span>
      <span class="sescontest_view_info_label">Start date</span>
    </div>
  	<div>
    	<span class="sescontest_view_info_det">5</span>
      <span class="sescontest_view_info_label">Days Left</span>
    </div>
  	<div>
    	<span class="sescontest_view_info_det">15</span>
      <span class="sescontest_view_info_label">Participants</span>
    </div>
  	<div>
    	<span class="sescontest_view_info_det">12</span>
      <span class="sescontest_view_info_label">Entry</span>
    </div>
  	<div>
    	<span class="sescontest_view_info_det">All</span>
      <span class="sescontest_view_info_label">Participants gender</span>
    </div>
  	<div>
    	<span class="sescontest_view_info_det">All</span>
      <span class="sescontest_view_info_label">Participants country</span>
    </div>
  </div>
  
</div>

<div class="sescontest_view_options sescontest_options_dropdown" id="sescontest_view_options">
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
	var topPositionOfParentSpan =  sesJqueryObject(".sescontest_view_option_btn").offset().top + 34;
	topPositionOfParentSpan = topPositionOfParentSpan+'px';
	var leftPositionOfParentSpan =  sesJqueryObject(".sescontest_view_option_btn").offset().left - 96;
	leftPositionOfParentSpan = leftPositionOfParentSpan+'px';
	sesJqueryObject('.sescontest_view_options').css('top',topPositionOfParentSpan);
	sesJqueryObject('.sescontest_view_options').css('left',leftPositionOfParentSpan);
}
window.addEvent('load',function(){
	doResizeForButton();
});
sesJqueryObject(window).resize(function(){
	doResizeForButton();
});
$('sescontest_view_option_btn').addEvent('click', function(event){
	event.stop();
	if($('sescontest_view_options').hasClass('show-options'))
		$('sescontest_view_options').removeClass('show-options');
	else
		$('sescontest_view_options').addClass('show-options');
	return false;
});
</script>