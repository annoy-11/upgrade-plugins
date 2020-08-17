<?php ?>
<style>
/*Manage*/
.sessubscribeuser_manage_tabs{
	border-bottom-width:1px;
}
.sessubscribeuser_manage_tabs li{
	float:left;
}
.sessubscribeuser_manage_tabs li a{
	bottom:-1px;
	border-width:1px 1px 0;
	font-weight:bold;
	display:block;
	padding:8px 15px;
	text-decoration:none !important;
	position:relative;
}
.sessubscribeuser_manage_tabs li + li a{
	border-left-width:0;
}
.sessubscribeuser_manage_tabs_content{
	border-width:0 1px 1px;
	padding:15px;
}
/*Order Page*/
.sessubscribeuser_orders{
	margin-top:15px;
}
.sessubscribeuser_order_item{
	border-width:1px;
	margin-bottom:15px;
}
.sessubscribeuser_order_item_header{
	background-image:url(../images/transprant-bg.png);
	border-bottom-width:1px;
	padding:10px;
	font-size:15px;
}
.sessubscribeuser_order_item_header .sesbasic_link_btn{
	padding:5px 15px;
}
.sessubscribeuser_order_item_cont{
	padding:10px;
}
.sessubscribeuser_order_item_img{
	float: left;
	height: 100px;
	width: 150px;
}
.sessubscribeuser_order_item_img span{
	background-size:cover;
	background-position:center;
	display:block;
	height:100%;
	width:100%;
}
.sessubscribeuser_order_item_details{
	display:block;
	overflow:hidden;
	padding:0 10px;
	min-height:100px;
	position:relative;
}
.sessubscribeuser_order_item_title{
	font-weight:bold;
	margin-bottom:5px;
}

.sessubscribeuser_order_item_btm{
	border-top-width:1px;
	bottom:0;
	position:absolute;
	padding:7px 0 4px;
	left:10px;
	right:10px;
}
.sessubscribeuser_order_item_btm .floatL{
	font-weight:bold;
}
.sessubscribeuser_download_link a{
	text-decoration:none !important;
}
.sessubscribeuser_download_link a:before{
	margin-right:5px;
}

</style>
<div class="layout_middle sesbasic_bxs">
	<div class="generic_layout_container">
  
    <div class="sessubscribeuser_manage_tabs sesbasic_clearfix">
      <ul class="sesbasic_clearfix">
        <li class="active">
          <?php echo $this->htmlLink(array('route' => 'sessubscribeuser_extended', 'action' => 'orders', 'user_id' => $this->user_id), $this->translate("Your Purchesed Video"), array('class' => '', 'title' => $this->translate("Your Subscriber"))); ?>
        </li>
        <li class="fright"><a href="<?php echo $this->user->getHref(); ?>"><?php echo $this->translate("Back to Profile"); ?></a></li>
      </ul>
      
    </div>
    <div class="sessubscribeuser_manage_tabs_content sesbasic_clearfix">  
      <h3><?php echo $this->translate("Your Profile Subscriber"); ?></h3>
      <p><?php echo $this->translate('Below, you can see all your profile subscriber. You can use this page to monitor these subscribers.'); ?></p>
      <div class="sesbasic_clearfix sessubscribeuser_orders">
        <?php foreach($this->paginator as $result): ?>
          <?php $video = Engine_Api::_()->getItem('user', $result->user_id); ?>
          <div class="sessubscribeuser_order_item sesbasic_clearfix">
            <div class="sessubscribeuser_order_item_header sesbasic_clearfix">
              <?php echo $this->translate("Order Id:"); ?> <b><?php echo $result->order_id; ?></b>
            </div>
            <div class="sessubscribeuser_order_item_cont sesbasic_clearfix">            	
              <div class="sessubscribeuser_order_item_img">
                <?php $imageURL = $video->getPhotoUrl(); ?>
                <a href="<?php echo $video->getHref(); ?>">
                  <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
                </a>
              </div>
              <div class="sessubscribeuser_order_item_details">
                <div class="sessubscribeuser_order_item_title">
                  <a href="<?php echo $video->getHref(); ?>"><?php echo $video->getTitle(); ?></a>
                </div>
                <div class="sessubscribeuser_order_item_stat sesbasic_text_light">
                  <?php echo $this->translate("Subscribe On %s", $result->creation_date); ?>
                </div>
                <div class="sessubscribeuser_order_item_btm">
                  <span class="floatL">
                    <?php $currency = Engine_Api::_()->sesbasic()->getCurrencyPrice($result->total_useramount, $result->currency_symbol);  ?>
                    <?php echo $this->translate("Subscribe Amount: %s", $currency); ?>
                  </span>
                </div>
              </div>	
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
	</div>
</div>