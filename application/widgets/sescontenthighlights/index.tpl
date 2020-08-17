<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<style>
.content_carousel_wrapper{
	padding:50px 0;
}
.content_carousel{
	position:relative;
}
.content_carousel .slick-list{
	overflow:hidden;
	margin:0 auto;
	padding:50px 0;
	max-width:1200px;
}
.content_carousel_item{
	float:left;
	position:relative;
}
.content_carousel_item > a{
	border-width:1px;
	border-radius:5px;
	overflow:hidden;
	height:250px;
	position:relative;
	display:block;
}
.content_carousel_item_photo:before {
	position:absolute;
	top:0;
	bottom:0;
	left:0;
	right:0;
	content:"";
	display:inline-block;
	background-image:-webkit-linear-gradient(top, transparent 60%, #000 110%);
	background-image:-o-linear-gradient(top, transparent 60%, #000 110%);
	background-image:linear-gradient(to bottom, transparent 60%, #000 110%);
	background-repeat:repeat-x;
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#FF000000', GradientType=0);
}
.content_carousel_item.slick-center{
	transform:scale(1.2);
	z-index:1;
}
/*.content_carousel_item.slick-center > a{
	box-shadow:0 0 5px rgba(0, 0, 0, 0.2);
}*/
.content_carousel_item_photo{
	height:100%;
	width:100%;
}
.content_carousel_item_photo img{
	height:100%;
	width:100%;
	object-fit:cover;
}
.content_carousel_item_cont{
	position:absolute;
	padding:20px;
	bottom:0;
	width:100%;
	left:0;
	color:#fff;
	font-size:17px;
	font-weight:bold;
}
.content_carousel .slick-arrow{
	font-family:FontAwesome;
	font-size:0;
	height:60px;
	width:60px;
	position:absolute;
	padding:0;
	top:50%;
	transform:translateY(-50%);
	z-index:10;
}
.content_carousel .slick-arrow:before{
	font-size:22px;
}
.content_carousel .slick-prev{
	border-radius:0 50% 50% 0;
	left:0;
}
.content_carousel .slick-next{
	border-radius:50% 0 0 50%;
	right:0;
}
.content_carousel .slick-prev:before{
	content:"\f053";
}
.content_carousel .slick-next:before{
	content:"\f054";
}
@media only screen and (max-width:768px){
	.content_carousel_wrapper{padding:30px 0 0;}
	.content_carousel .slick-list{padding:0;}
	.content_carousel_item a{margin:0 5px;}
}
@media only screen and (max-width:480px){
	.content_carousel_item a{margin:0;}
}
.layout_highlight > h3{
	display:none;
} 
/*Design 1*/
.highlights_wrapper{
	background-image:url(../images/highlight-bg.png);
	background-position:ccenter center;
	background-size:cover;
	padding:50px 0 0;
	margin:0;
	width:100%;
}
.landing_page .highlights_wrapper{
	padding-bottom:50px;
}
.highlights_cont{
	padding:17px 5px 5px;
}
.landing_page .highlights_cont{
	padding:17px 25px 0;
} 
.landing_page .highlights_cont_row{
	margin:0;
}
.highlights_item{
	float:left;
	padding:3px;
	width:33.33%;
}
[dir="rtl"] .highlights_item{
	float:right;
}
.highlights_item_inner{
	border-bottom-width:1px;
}
.highlights_item_photo{
	height:315px;
	position:relative;
	overflow:hidden;
}
.highlights_item_photo a,
.highlights_item_photo a img{
	display:block;
	height:100%;
	object-fit:cover;
	width:100%;
}
.highlights_item_cont a{
	display:block;
	font-weight:600;
	line-height:40px;
	overflow:hidden;
	padding:0 10px;
	text-align:center;
	text-overflow:ellipsis;
	white-space:nowrap;
}
.highlights_item:hover .highlights_item_photo img{
	transform:scale(1.05);
}
.highlights_item_photo a:after{
	content:"";
	position:absolute;
	left:0;
	right:0;
	top:0;
	bottom:0;
}
.highlights_item:hover .highlights_item_photo a:after{
	background-color:rgba(0, 0, 0, .2);
}
.highlights_item_photo a:after,
.highlights_item_photo a img{
	-webkit-transition:all 500ms ease 0s;
	-moz-transition:all 500ms ease 0s;
	-o-transition:all 500ms ease 0s;
	transition:all 500ms ease 0s;
}
@media only screen and (max-width:768px){
	.highlights_wrapper{
		padding:30px 0;
	}
	.landing_page .highlights_wrapper{
		padding-bottom:10px;
	}
	.landing_page .highlights_cont{
		padding:17px 0 0;
	}
	.landing_page .highlights_cont_row{
		padding:0;
	}
	.highlights_item{
		width:50%;
	}
}
@media only screen and (max-width:480px){
	.highlights_cont_row{
		margin:0;
	}
	.landing_page .highlights_cont_row{
		margin-top:10px;
		padding:0 5px;
	}
	.highlights_item{
		padding:5px !important;
	}
	.highlights_item_photo{
		height:130px;
	}
}
/*Design 2*/
.content_wrapper{
	padding:50px 0 0;
	width:100%;
}
.landing_page .content_wrapper{
	padding-bottom:50px;
}
.content_inner{
	margin:20px auto 0;
}
.landing_page .content_inner{
	max-width:1000px;
}
.content_item_big{
	height:350px;
	margin-bottom:1px;
	position:relative;
	width:100%;
}
.content_item_big_img,
.content_item_big_img img{
	object-fit:cover;
	height:100%;
	width:100%;
}
.content_item_big_cont{
	bottom:0;
	left:0;
	margin:0 auto;
	padding:30px;
	position:absolute;
	right:0;
	width:75%;
}
.content_item_big_cont:before{
	content:"";
	position:absolute;
	left:0;
	top:0;
	bottom:0;
	right:0;
	opacity:.8;
	z-index:0;
}
.content_item_big_cont_inner{
	position:relative;
	z-index:1;
}
.content_item_big_cont_inner_info{
	padding-right:70px;
}
[dir="rtl"] .content_item_big_cont_inner_info{
	padding-left:70px;
	padding-right:0;
}
.content_item_big_cont_inner_title{
	color:#fff;
	font-size:28px;
	font-weight:bold;
}
.content_item_big_cont_inner_des{
	color:#fff;
	display:block;
	font-size:17px;
	overflow:hidden;
	text-overflow:ellipsis;
	white-space:nowrap;
}
.content_item_big_cont_inner_stat{
	color:rgba(255, 255, 255, .9);
	margin-top:5px;
	font-size:12px;
}
.content_item_big_cont_inner_arrow {
	background-color:rgba(0, 0, 0, .14);
	bottom:0;
	height:100%;
	position:absolute;
	right:0;
	width:70px;
	z-index:2;
}
[dir="rtl"] .content_item_big_cont_inner_arrow {
	left:0;
	right:auto;
}
.content_item_big_cont_inner_arrow i{
	color:#fff;
	left:50%;
	position:absolute;
	top:50%;
	font-size:20px;
	transform:translate(-50%);
}
[dir="rtl"] .content_item_big_cont_inner_arrow i:before{
	content:"\f060" !important;
}
.content_item_big_cont_inner_btn{
	border:3px solid #fff;
	border-radius:3px;
	color:#fff;
	display:inline-block;
	font-size:18px;
	font-weight:bold;
	padding:10px 40px;
	position:relative;
	text-transform:uppercase;
	margin-top:20px;
}
.content_item{
	float:left;
	width:25%;
}
[dir="rtl"] .content_item{
	float:right;
}
.content_item + .content_item a{
	margin-left:1px;
}
[dir="rtl"] .content_item + .content_item a{
	margin-left:0;
	margin-right:1px;
}
.content_item a{
	display:block;
}
.content_item_img,
.content_item_img img{
	position:relative;
	overflow:hidden;
	height:200px;
	object-fit:cover;
	width:100%;
}
.content_item_img:after{
	content:"";
	position:absolute;
	left:0;
	right:0;
	top:0;
	bottom:0;
}
.content_item:hover .content_item_img:after{
	background-color:rgba(0, 0, 0, .2);
}
.content_item:hover .content_item_img img{
	transform:scale(1.05);
}
.content_item_title{
	border-width:0 1px 1px;
	display:block;
	overflow:hidden;
	padding:10px;
	text-overflow:ellipsis;
	white-space:nowrap;
}
.content_item_img img,
.content_item_img:after,
.content_item_big_cont_inner_arrow,
.content_item_big_cont_inner_btn,
.content_item_big_cont_inner_title{
	-webkit-transition:all 500ms ease 0s;
	-moz-transition:all 500ms ease 0s;
	-o-transition:all 500ms ease 0s;
	transition:all 500ms ease 0s;
}
@media only screen and (max-width:768px){
	.content_wrapper{
		padding:30px 0;
	}
	.content_item_big{
		height:250px;
	}
	.content_item_big_cont{
		padding:10px;
	}
	.content_item_big_cont_inner{
		padding:0;
	}
	.content_item_big_cont_inner_title{font-size:20px;}
	.content_item_big_cont_inner_btn{padding:8px 15px;font-size:12px;border-width:1px;}
	.content_item_img, .content_item_img img{height:100px;}
}
@media only screen and (max-width:480px){
	.content_item_big_cont{width:100%;}
	.content_item{width:50%;}
}
</style>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesariana/externals/styles/styles.css'); ?>
<?php if($this->design == 3){ ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesariana/externals/scripts/slick.min.js'); ?>


<?php $randonNumber = $this->identity; ?>

<div class="content_carousel_wrapper clearfix sesbasic_bxs">
	<h3><?php echo $this->translate($this->heading); ?></h3>
  <?php if($this->widgetdescription): ?>
    <p><?php echo $this->widgetdescription; ?></p>
  <?php endif; ?>
  <div class="content_carousel_main clearfix">
    <div class="content_carousel content_carousel_<?php echo $randonNumber; ?>">
      <?php  foreach($this->result as $result){    ?>
        <div class="content_carousel_item">
        	<a href="<?php echo $result->getHref(); ?>">
            <div class="content_carousel_item_photo">
            	<img src="<?php echo $result->getPhotoUrl(); ?>" alt="" />
            </div>
            <div class="content_carousel_item_cont clearfix">
            	<?php echo $this->translate($result->getTitle()); ?>
            </div>
        	</a>    
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<script src="<?php echo $this->baseUrl(); ?>/externals/ses-scripts/sesJquery.js" type="text/javascript"></script>
<script src="<?php echo $this->baseUrl();  ?>/externals/ses-scripts/slick.min.js" type="text/javascript"></script>

<script type="text/javascript">
sesJqueryObject('.content_carousel_<?php echo $randonNumber; ?>').slick({
  centerMode: true,
  centerPadding: '0px',
  slidesToShow: 3,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: true,
        centerMode: false,
        centerPadding: '0',
        slidesToShow: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: true,
        centerMode: false,
        centerPadding: '0',
        slidesToShow: 1
      }
    }
  ]
});
</script>
<?php } else if($this->design == 2){ ?>
<div class="highlights_wrapper clearfix sesbasic_bxs">
	<h3><?php echo $this->translate($this->heading); ?></h3>
  <?php if($this->widgetdescription): ?>
    <p><?php echo $this->widgetdescription; ?></p>
  <?php endif; ?>
  <div class="highlights_cont clearfix">
  	<div class="highlights_cont_row clearfix">
    <?php  foreach($this->result as $result){    ?>
      <div class="highlights_item">
        <div class="highlights_item_inner">
          <div class="highlights_item_photo">
            <a href="<?php echo $result->getHref(); ?>">
              <img src="<?php echo $result->getPhotoUrl(); ?>" alt="" />
            </a>
          </div>
          <div class="highlights_item_cont clearfix">
          	<a href="<?php echo $result->getHref(); ?>">
            	<?php echo $this->translate($result->getTitle()); ?>             
            </a>
          </div>
        </div>
      </div>
    <?php } ?>
    </div>
  </div>
</div>
<style>
.highlights_item:hover a,
.content_item:hover .content_item_title{
  background-color:#<?php echo $this->contentbackgroundcolor ?> !important;
}

</style>
<?php }else{ ?>
<div class="content_wrapper clearfix sesbasic_bxs">
	<h3><?php echo $this->translate($this->heading); ?></h3>
  <?php if($this->widgetdescription): ?>
    <p><?php echo $this->widgetdescription; ?></p>
  <?php endif; ?>
	<div class="content_inner clearfix">
  <?php 
    $counter = 1;
    foreach($this->result as $result){ 
    if($counter == 1){
    ?>
  	<div class="content_item_big">
    	<div class="content_item_big_img">
      	<img src="<?php echo $result->getPhotoUrl(); ?>" alt="" />
      </div>
      <a href="<?php echo $result->getHref(); ?>" class="content_item_big_cont">
      	<div class="content_item_big_cont_inner">
        	<div class="content_item_big_cont_inner_info">
            <div class="content_item_big_cont_inner_title">
              <?php echo $this->translate($result->getTitle()); ?>
            </div>
            <div class="content_item_big_cont_inner_des">
              <?php echo $this->translate($result->getDescription()); ?>
            </div>
            <?php if($result->getType() == 'sesevent_event'){ ?>
              <div class="content_item_big_cont_inner_stat">
                <?php echo $this->eventStartEndDates($result);?>
              </div>
            <?php } ?>
          </div>
          <div class="content_item_big_cont_inner_btn">View More</div>
        </div>
        <div class="content_item_big_cont_inner_arrow">
          <i class="fa fa-arrow-right" aria-hidden="true"></i>
        </div>
      </a>
    </div>
    <?php }else{ ?>
    <div class="content_item">
    	<a href="<?php echo $result->getHref(); ?>">
      	<div class="content_item_img">
        	<img src="<?php echo $result->getPhotoUrl(); ?>" alt="" />
        </div>
        <div class="content_item_title">
        	<?php echo $this->translate($result->getTitle()); ?>
        </div>
      </a>
    </div>
    <?php } ?>
 <?php 
  $counter++;
  } ?>
  </div>
	
</div>
<style>
.content_item_big_cont:before,
.content_item_big:hover .content_item_big_cont_inner_arrow{
  background-color:#<?php echo $this->contentbackgroundcolor ?> !important;
}
</style>
<?php } ?>