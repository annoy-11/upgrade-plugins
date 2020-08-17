<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdocument
 * @package    Sesdocument
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
 <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesdocument/externals/styles/style.css'); ?> 
<div class="sesdoc_browse_doc sesbasic_bxs sesbasic_clearfix">
  <div class="sesdoc_browse_doc_inner">
    <ul class="sesdoc_view">
      <!-- GRID VIEW STARTS -->
       <li class="sesdoc_grid_item">
         <article class="sesbasic_bg">
           <div class="sesdoc_top">
              <a href="#">
                 <span style="background-image:url(application/modules/Sesdocument/externals/images/bg.jpg);"></span>
              </a>
              <div class="sesdoc_icon">
                 <img src="application/modules/Sesdocument/externals/images/pdf.png" />
              </div>
              <div class="sesdoc_labels">
                  <span class="featured" title="Featured"><i class="fa fa-star"></i></span>
                  <span class="new" title="New"><i class="fa fa-star"></i></span>
                  <span class="hot" title="Hot"><i class="fa fa-star"></i></span>
              </div>
              <div class="social_share">
                 <a href="#" onclick="#" class="sesbasic_icon_btn sesbasic_icon_facebook_btn" tabindex="-1"><i class="fa fa-facebook"></i></a>
                 <a href="#" onclick="" class="sesbasic_icon_btn sesbasic_icon_twitter_btn" tabindex="-1"><i class="fa fa-twitter"></i></a>
                 <a href="javascript:;" data-url="140" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn" tabindex="-1"> <i class="fa fa-thumbs-up"></i><span>2</span></a>
								<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn" data-url="140" tabindex="-1"><i class="fa fa-heart"></i><span>1</span></a>
                </div>
                 <span class="stats">
                     <span class="views"><i class="fa fa-eye"></i> 45 </span>
                     <span class="comment"><i class="fa fa-comment"></i> 10 </span>
                     <span class="like"><i class="fa fa-thumbs-up"></i> 50 </span>
                 </span>
           </div>
           <div class="sesdoc_bottom">
             <div class="title">
               <a href="#">Mathematics Project</a>
             </div>
             <div class="sesdoc_user_stats">
                 <span class="owner"><i class="fa fa-user"></i> Admin</span>
                 <p class="sesbasic_rating_star">
                    <span id="rate_1" class="fa fa-star" onclick="rate(1);" onmouseover="rating_over(1);"></span>
                    <span id="rate_2" class="fa fa-star" onclick="rate(2);" onmouseover="rating_over(2);"></span>
                    <span id="rate_3" class="fa fa-star" onclick="rate(3);" onmouseover="rating_over(3);"></span>
                    <span id="rate_4" class="fa fa-star" onclick="rate(4);" onmouseover="rating_over(4);"></span>
                    <span id="rate_5" class="fa fa fa-star-o star-disable" onclick="rate(5);" onmouseover="rating_over(5);"></span>
                 </p>
             </div>
           </div>
         </article>
       </li>
       <!-- GRID VIEW ENDS -->
       </ul>
       <!-- LIST VIEW STARTS -->
       <ul class="sesdoc_view sesdoc_list_view">
         <li class="sesdoc_list_item">
           <article class="sesbasic_bg">
             <div class="sesdoc_top">
              <a href="#">
                 <span style="background-image:url(application/modules/Sesdocument/externals/images/bg.jpg);"></span>
              </a>
              <div class="sesdoc_icon">
                 <img src="application/modules/Sesdocument/externals/images/pdf.png" />
              </div>
              <div class="sesdoc_labels">
                  <span class="featured" title="Featured"><i class="fa fa-star"></i></span>
                  <span class="new" title="New"><i class="fa fa-star"></i></span>
                  <span class="hot" title="Hot"><i class="fa fa-star"></i></span>
              </div>
           </div>
           <div class="sesdoc_bottom">
             <div class="title">
               <a href="#">Mathematics Project</a>
                <p class="sesbasic_rating_star">
                    <span id="rate_1" class="fa fa-star" onclick="rate(1);" onmouseover="rating_over(1);"></span>
                    <span id="rate_2" class="fa fa-star" onclick="rate(2);" onmouseover="rating_over(2);"></span>
                    <span id="rate_3" class="fa fa-star" onclick="rate(3);" onmouseover="rating_over(3);"></span>
                    <span id="rate_4" class="fa fa-star" onclick="rate(4);" onmouseover="rating_over(4);"></span>
                    <span id="rate_5" class="fa fa fa-star-o star-disable" onclick="rate(5);" onmouseover="rating_over(5);"></span>
                 </p>
             </div>
             <div class="sesdoc_user_stats">
                 <span class="owner"><a href="#"> <i class="fa fa-user"></i>Admin</a></span>
                  <span class="date"><i class="fa fa-calendar"></i> September 8, 2010</span>
                 <span class="cat"><i class="fa fa-folder"></i> Education</span>
                 <span class="stats">
                     <span class="views"><i class="fa fa-eye"></i> 45 </span>
                     <span class="comment"><i class="fa fa-comment"></i> 10 </span>
                     <span class="like"><i class="fa fa-thumbs-up"></i> 50 </span>
                 </span>
             </div>
           </div>
         </article>
       </li>
    </ul>
     <!-- LIST VIEW ENDS -->
  </div>
</div>