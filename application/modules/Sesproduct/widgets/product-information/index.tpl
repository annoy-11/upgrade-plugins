<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesproduct/externals/styles/styles.css'); ?>
<?php if($this->design == 2) { ?>
<?php include APPLICATION_PATH.'/application/modules/Sesproduct/views/scripts/view-page/design2.tpl' ?>
<?php } else if($this->design == 3) {  ?>
<?php include APPLICATION_PATH.'/application/modules/Sesproduct/views/scripts/view-page/design3.tpl' ?>
<?php } else if($this->design == 4) { ?>
<?php include APPLICATION_PATH.'/application/modules/Sesproduct/views/scripts/view-page/design4.tpl' ?>
<?php } else { ?>
	<?php include APPLICATION_PATH.'/application/modules/Sesproduct/views/scripts/view-page/design1.tpl' ?>
<?php } ?>
<script type="text/javascript">

function notifyMe(obj){
		var product_id = sesJqueryObject(obj).data('product-id');
		var gmail = sesJqueryObject('input[name="notify_gmail"]').val();
		sesJqueryObject(this).html('application/modules/Core/externals/images/loading.gif');
		requestNotify = new Request.HTML({
			method: 'post',
			'url': en4.core.baseUrl + "sesproduct/index/notify/",
			'data': {
				format: 'html',
				is_ajax : 1,
        product_id : product_id,
        gmail : gmail,
			},
			onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        
				return false;
			}
		});
	requestNotify.send();
	return false;
}


    var cartOptionValue = "<?php echo Zend_Registry::get('Zend_Translate')->translate('-- Please Select --'); ?>";
//VIEW 1
function openCity(evt, cityName) {
	var i, tabcontent, tablinks;
	tabcontent = document.getElementsByClassName("tabcontent");
	for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
	}
	tablinks = document.getElementsByClassName("tablinks");
	for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
	}
	document.getElementById(cityName).style.display = "block";
	evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen").click();
//VIEW 2
//quantity
(function ($) {
$.fn.niceNumber = function(options) {
var settings = $.extend({
	autoSize: true,
	autoSizeBuffer: 1,
	buttonDecrement: '-',
	buttonIncrement: "+",
	buttonPosition: 'around'
}, options);

return this.each(function(){
	var currentInput = this,
			$currentInput = $(currentInput),
			attrMax = null,
			attrMin = null;
	if (
		typeof $currentInput.attr('max') !== typeof undefined
		&& $currentInput.attr('max') !== false
	) {
		attrMax = parseFloat($currentInput.attr('max'));
	}

	if (
		typeof $currentInput.attr('min') !== typeof undefined
		&& $currentInput.attr('min') !== false
	) {
		attrMin = parseFloat($currentInput.attr('min'));
	}
	if (
		attrMin
		&& !currentInput.value
	) {
		$currentInput.val(attrMin);
	}
	var $inputContainer = $('<div/>',{
			class: 'nice-number'
		})
		.insertAfter(currentInput);
	var interval = {};
	var $minusButton = $('<button/>')
		.attr('type', 'button')
		.html(settings.buttonDecrement)
		.on('mousedown mouseup mouseleave', function(event){
			changeInterval(event.type, interval, function(){
				if (
					attrMin == null
					|| attrMin < parseFloat(currentInput.value)
				) {
					currentInput.value--;
				}
			});
			if (
				event.type == 'mouseup'
				|| event.type == 'mouseleave'
			) {
				$currentInput.trigger('input');
			}
		});
	var $plusButton = $('<button/>')
		.attr('type', 'button')
		.html(settings.buttonIncrement)
		.on('mousedown mouseup mouseleave', function(event){
			changeInterval(event.type, interval, function(){
				if (
					attrMax == null
					|| attrMax > parseFloat(currentInput.value)
				) {
					currentInput.value++;
				}
			});
			if (
				event.type == 'mouseup'
				|| event.type == 'mouseleave'
			) {
				$currentInput.trigger('input');
			}
		});
	switch (settings.buttonPosition) {
		case 'left':
			$minusButton.appendTo($inputContainer);
			$plusButton.appendTo($inputContainer);
			$currentInput.appendTo($inputContainer);
			break;
		case 'right':
			$currentInput.appendTo($inputContainer);
			$minusButton.appendTo($inputContainer);
			$plusButton.appendTo($inputContainer);
			break;
		case 'around':
		default:
			$minusButton.appendTo($inputContainer);
			$currentInput.appendTo($inputContainer);
			$plusButton.appendTo($inputContainer);
			break;
	}
	if (settings.autoSize) {
		$currentInput.width(
			$currentInput.val().length+settings.autoSizeBuffer+"ch"
		);
		$currentInput.on('keyup input',function(){
			$currentInput.animate({
				'width': $currentInput.val().length+settings.autoSizeBuffer+"ch"
			}, 200);
		});
	}
});
};
function changeInterval(eventType, interval, callback) {
if (eventType == "mousedown") {
	interval.timeout = setTimeout(function(){
		interval.actualInterval = setInterval(function(){
			callback();
		}, 100);
	}, 200);
	callback();
} else {
	if (interval.timeout) {
		clearTimeout(interval.timeout);
	}
	if (interval.actualInterval) {
		clearInterval(interval.actualInterval);
	}
}
}
}(jQuery));
//VIEW 3 
//Slider
jQuery(document).ready(function ($) {
  
	var slideCount = $('#slider_first ul li').length;
	var slideWidth = $('#slider_first ul li').width();
	var slideHeight = $('#slider_first ul li').height();
	var sliderUlWidth = slideCount * slideWidth;
	
	$('#slider_first').css({ width: slideWidth, height: slideHeight });
	
	$('#slider_firstr ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });
	
    $('#slider_first ul li:last-child').prependTo('#slider_first ul');

    function moveLeft() {
        $('#slider_first ul').animate({
            left: + slideWidth
        }, 200, function () {
            $('#slider_first ul li:last-child').prependTo('#slider_first ul');
            $('#slider_first ul').css('left', '');
        });
    };

    function moveRight() {
        $('#slider_first ul').animate({
            left: - slideWidth
        }, 200, function () {
            $('#slider_first ul li:first-child').appendTo('#slider_first ul');
            $('#slider_first ul').css('left', '');
        });
    };

    $('a.control_prev').click(function () {
        moveLeft();
    });

    $('a.control_next').click(function () {
        moveRight();
    });

});   
//Quantity
jQuery(function(){
  var j = jQuery; 
  var addInput = '#quantity';
  var n = 1; 
  
  j(addInput).val(n);
  j('.plus_button').on('click', function(){
    j(addInput).val(++n);
  })
  j('.min_button').on('click', function(){
    if (n >= 1) {
      j(addInput).val(--n);
    } else {
    }
  });
});

//VIEW4 
//SLIDER
jQuery(document).ready(function ($) {
  
	var slideCount = $('#slider ul li').length;
	var slideWidth = $('#slider ul li').width();
	var slideHeight = $('#slider ul li').height();
	var sliderUlWidth = slideCount * slideWidth;
	
	$('#slider').css({ width: slideWidth, height: slideHeight });
	
	$('#slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });
	
    $('#slider ul li:last-child').prependTo('#slider ul');

    function moveLeft() {
        $('#slider ul').animate({
            left: + slideWidth
        }, 200, function () {
            $('#slider ul li:last-child').prependTo('#slider ul');
            $('#slider ul').css('left', '');
        });
    };

    function moveRight() {
        $('#slider ul').animate({
            left: - slideWidth
        }, 200, function () {
            $('#slider ul li:first-child').appendTo('#slider ul');
            $('#slider ul').css('left', '');
        });
    };

    $('a.control_prev').click(function () {
        moveLeft();
    });

    $('a.control_next').click(function () {
        moveRight();
    });

});   

</script> 
<script>
//View2 tabs
	var tabs = $('.tabs');
	var items = $('.tabs').find('a').length;
	var selector = $(".tabs").find(".selector");
	var activeItem = tabs.find('.active');
	var activeWidth = activeItem.innerWidth();
	$(".selector").css({
		"left": activeItem.position.left + "px", 
		"width": activeWidth + "px"
	});

	$(".tabs").on("click","a",function(){
		$('.tabs a').removeClass("active");
		$(this).addClass('active');
		var activeWidth = $(this).innerWidth();
		var itemPos = $(this).position();
		$(".selector").css({
			"left":itemPos.left + "px", 
			"width": activeWidth + "px"
		});
});

</script>
