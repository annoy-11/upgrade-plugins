<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Widgets
 * @package    Sesfixedlayout
 * @copyright  Copyright 2019 - 2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
  
?>
<script src="<?php echo $this->baseUrl(); ?>/externals/ses-scripts/sesJquery.js" type="text/javascript"></script>
<script type="application/javascript">
var leftContainerWidth = 0;
var rightContainerWidth = 0;
var middleContainerWidth = 0;
var marginLeftContainerValue = 0;
var marginRightContainerValue = 0;
var globalContentContainer = "";
var leftContainer = "";
var rightContainer = "";
var middleContainer = "";
 sesJqueryObject(window).load(function(e){
     globalContentContainer = sesJqueryObject('#global_content').find('div').eq(0).find('.layout_main');
     leftContainer = globalContentContainer.find('.layout_left');
     rightContainer = globalContentContainer.find('.layout_right');
     middleContainer = globalContentContainer.find('.layout_middle');
     if(globalContentContainer && globalContentContainer.width() >= 1024){
          leftContainerWidth = leftContainer.outerWidth( true );
          rightContainerWidth = rightContainer.outerWidth( true );
          middleContainerWidth = middleContainer.outerWidth( true );
          marginLeftContainerValue = leftContainer.outerWidth( true );
          marginRightContainerValue = (leftContainerWidth + middleContainerWidth);
         //set margin right on middle container
         if (leftContainer && middleContainer) {
              middleContainer.css('margin-left', leftContainerWidth);
         }
         //set margin left on middle container
         if (rightContainer && middleContainer) {
            middleContainer.css( 'margin-right',rightContainerWidth);
         }
          sesJqueryObject(window).scroll(function(){
            setContentPosition();
          });
     }
 });
 function setContentPosition(){
   var scrolling = window.getScrollTop();
   var leftContainerHeight = leftContainer.outerHeight(true);
   var rightContainerHeight = rightContainer.outerHeight(true);
   var middleContainerHeight = middleContainer.outerHeight(true);
   var visibleWindowHeight = window.getCoordinates().height;
   var footerContainerHeight = sesJqueryObject('#global_footer').outerHeight(true);
   var headerContainerHeight = sesJqueryObject('#global_header').find('div').eq(0).outerHeight(true);
   var mainContainerTopPosition = sesJqueryObject(globalContentContainer).offset().top
   var largestHeightLayout = 0;
   largestHeightLayout = leftContainer && (largestHeightLayout < leftContainerHeight) ? leftContainerHeight : largestHeightLayout;
   largestHeightLayout = middleContainer && (largestHeightLayout < middleContainerHeight) ? middleContainerHeight : largestHeightLayout;
   largestHeightLayout = rightContainer && (largestHeightLayout < rightContainerHeight) ? rightContainerHeight : largestHeightLayout;
   //fixed left container if layout height less than higest height
   if(leftContainer && leftContainerHeight < largestHeightLayout &&  scrolling > 9){
      var scrollPositionLeft = (mainContainerTopPosition > 100 ) ?  mainContainerTopPosition + leftContainerHeight - visibleWindowHeight : leftContainerHeight - visibleWindowHeight;
      if((mainContainerTopPosition - 100) < window.getScrollTop() &&  scrollPositionLeft < scrolling && window.getScrollTop() > 10){
          if(!leftContainer.hasClass('fixed'))
            leftContainer.addClass('fixed');
      }else
          leftContainer.removeClass('fixed');
      //set bottom height for footer
      var heightLeft = leftContainerHeight;
      if((visibleWindowHeight - headerContainerHeight ) < heightLeft) {
          bottomHeight = 0;
      } else {
          bottomHeight = visibleWindowHeight - leftContainerHeight - headerContainerHeight;
      }
      if((window.getScrollHeight() - footerContainerHeight - visibleWindowHeight) < scrolling && (leftContainerHeight > (visibleWindowHeight - headerContainerHeight))) {
          bottomHeight = footerContainerHeight;  
      }
      leftContainer.css( 'bottom',bottomHeight - 5);              
   }else{
    //remove fixed class
    if(leftContainer && leftContainer.hasClass('fixed')) {
        leftContainer.removeClass('fixed');
    }  
   }
   
   //fixed right container if layout height less than higest height
   if(rightContainer && rightContainerHeight < largestHeightLayout){
      var scrollPositionRight = (mainContainerTopPosition > 100 ) ? mainContainerTopPosition + rightContainerHeight - visibleWindowHeight : rightContainerHeight - visibleWindowHeight;
      if((mainContainerTopPosition - 100) < window.getScrollTop() && scrollPositionRight < scrolling &&  scrolling > 9){
          if(!rightContainer.hasClass('fixed')){
            rightContainer.addClass('fixed');
            rightContainer.css('margin-left',marginRightContainerValue);
          }
          var bottomHeight = 0;
          //set bottom height for footer
          var heightRight = rightContainerHeight;
          if((visibleWindowHeight - headerContainerHeight ) < heightRight) {
              bottomHeight = 0;
          } else {
              bottomHeight = visibleWindowHeight - rightContainerHeight - headerContainerHeight;
          }
          if((window.getScrollHeight() - footerContainerHeight - visibleWindowHeight) < scrolling && (rightContainerHeight > (visibleWindowHeight - headerContainerHeight))) {
              bottomHeight = footerContainerHeight;  
          }
          rightContainer.css( 'bottom',bottomHeight - 5);
          
      }else{
          rightContainer.removeClass('fixed');
          rightContainer.css('margin-left','');
      }
   }else{
    //remove fixed class
    if(rightContainer && rightContainer.hasClass('fixed')) {
        rightContainer.removeClass('fixed');
        rightContainer.css('margin-left','');
    }  
   }
   
   
   // middle layout
   if (middleContainer && (middleContainerHeight < largestHeightLayout)) {
     var scrollPositionMiddle =  (mainContainerTopPosition > 100 ) ? mainContainerTopPosition + middleContainerHeight - visibleWindowHeight : middleContainerHeight - visibleWindowHeight;
      if((mainContainerTopPosition - 100) < window.getScrollTop() && scrollPositionMiddle < scrolling &&  scrolling > 9){
          if(!middleContainer.hasClass('fixed')){
            middleContainer.addClass('fixed');
            middleContainer.css('width',middleContainerWidth);
          }
          
          var bottomHeight = 0;
          //set bottom height for footer
          var heightRight = middleContainerHeight;
          if((visibleWindowHeight - headerContainerHeight ) < heightRight) {
              bottomHeight = 0;
          } else {
              bottomHeight = visibleWindowHeight - middleContainerHeight - headerContainerHeight;
          }
          if((window.getScrollHeight() - footerContainerHeight - visibleWindowHeight) < scrolling && (middleContainerHeight > (visibleWindowHeight - headerContainerHeight))) {
              bottomHeight = footerContainerHeight;  
          }
          middleContainer.css( 'bottom',bottomHeight - 5);
          
      }else{
          middleContainer.removeClass('fixed');
          middleContainer.css('width','');
      }
   }else{
    //remove fixed class
    if(middleContainer && middleContainer.hasClass('fixed')) {
        middleContainer.removeClass('fixed');
        middleContainer.css('width','');
    }  
   }
   
     
 }
</script>
<style>
.layout_sesfixedlayout{
  display:none;
}
/*Sticky Sidebar*/
.layout_left.fixed,
.layout_right.fixed,
.layout_middle.fixed{
	position:fixed;
	bottom:0;
}
</style>
