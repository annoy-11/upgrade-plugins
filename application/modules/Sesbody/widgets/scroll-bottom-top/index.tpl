<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbody
 * @package    Sesbody
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<a href="javascript:;" id="scroolToToElement" onclick="scrollTopAnimated(1000)" class="scrollup"></a>
<script>
	window.addEventListener("scroll", function(event) {
    var top = this.scrollY;
		if (top > 100) {
			$('scroolToToElement').fade('in');
		} else {
			$('scroolToToElement').fade('out');
    }
	}, false);
	var stepTime = 20;
	var docBody = document.body;
	var focElem = document.documentElement;
	
	var scrollAnimationStep = function (initPos, stepAmount) {
			var newPos = initPos - stepAmount > 0 ? initPos - stepAmount : 0;
	
			docBody.scrollTop = focElem.scrollTop = newPos;
	
			newPos && setTimeout(function () {
					scrollAnimationStep(newPos, stepAmount);
			}, stepTime);
	}
	var scrollTopAnimated = function (speed) {
			var topOffset = docBody.scrollTop || focElem.scrollTop;
			var stepAmount = topOffset;
	
			speed && (stepAmount = (topOffset * stepTime)/speed);
	
			scrollAnimationStep(topOffset, stepAmount);
	};
</script>