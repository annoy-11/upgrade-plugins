<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<!--suppress ALL -->
<div class="courses_compare_fixed sesbasic_clearfix sesbasic_bxs" style="display: none;" >
	<div class="courses_compare_heading">
		<h3><?php echo $this->translate("Compare"); ?></h3>
	</div>
	<div class="courses_compare_tabs">
		<ul class="courses_compare_tabs_ul">
			<?php
				if(!empty($_SESSION["courses_add_to_compare"])){ ?>
				<?php foreach($_SESSION["courses_add_to_compare"] as $key=>$value){
					if(!count($value))
						continue;
					$category = Engine_Api::_()->getItem('courses_category',$key);
					if(!$category)
						continue;
				?>
					<li data-category="<?php echo $key; ?>">
						<a href="javascript:;"><?php echo $category->category_name; ?> <span><?php echo count($value); ?></span></a>
					</li>
				<?php } ?>
			<?php } ?>
		</ul>
		<div class="courses_compare_cnt">
			<?php
			if(!empty($_SESSION["courses_add_to_compare"])){ ?>
				<?php foreach($_SESSION["courses_add_to_compare"] as $key=>$value){
					if(!count($value))
						continue;
					$category = Engine_Api::_()->getItem('courses_category',$key);
					if(!$category)
						continue;
					?>
				<div class="courses_compare_inner">
					<?php foreach($value as $course_id){ ?>
						<?php $course = Engine_Api::_()->getItem("courses",$course_id);
							if(!$course)
								continue;
              $compareData = Engine_Api::_()->courses()->compareData($course);
						 ?>
						<div data-attr='<?php echo $compareData; ?>'  class="courses_compare_small_course courses_course_cnt" data-courseid="<?php echo $course_id; ?>">
							<img src="<?php echo $course->getPhotoUrl(); ?>" alt="">
								<a class="courses_compare_course_a" href="javascript:;"><div class="compare_close"><i class="fa fa-close"></i></div></a>
						</div>

					<?php } ?>
				</div>
				<?php } ?>
			<?php } ?>


		</div>
	</div>
	<div class="courses_compare_btn">
		<a href="javascript:;" class="compare_cancel courses_compare_remove_all"><?php echo $this->translate("Clear All"); ?></a>
		<a href="javascript:;" data-url="<?php echo $this->url(array('action'=>'compare'),'courses_general',true); ?>" class="compare_apply courses_compare_fixed_view"><?php echo $this->translate("Let's Compare!"); ?></a>
	</div>
</div>
<script>
	sesJqueryObject(document).on('click','.courses_compare_fixed_view',function (e) {
		var url = sesJqueryObject(this).data('url');

		var index = sesJqueryObject('.courses_compare_tabs_ul').find('li').index(sesJqueryObject('.courses_compare_tabs_ul').find('li.active'));
		var coursesDic = sesJqueryObject('.courses_compare_cnt').find('.courses_compare_inner').eq(index);
		if(coursesDic.find('.courses_course_cnt').length < 2){
			alert("Select minimum 2 courses to compare");
			return;
		}
		window.location.href = url+"/id/"+sesJqueryObject('.courses_compare_tabs_ul').find('li.active').data('category');

    });
sesJqueryObject(document).ready(function() {
	sesJqueryObject(document).on('click',".courses_compare_tabs_ul li a",function() {
		var indexElem = sesJqueryObject(this).parent().index();
		sesJqueryObject('.courses_compare_tabs_ul').find('.active').removeClass('active');
		sesJqueryObject(this).parent().addClass('active');
		var elem = sesJqueryObject('.courses_compare_cnt').find('.courses_compare_inner');
		elem.hide();
		elem.eq(indexElem).show();
	});
    if(sesJqueryObject('.courses_compare_tabs_ul').find('li').length > 0){
        sesJqueryObject('.courses_compare_tabs_ul').find('li').eq(0).find('a').trigger('click');
        if(sesJqueryObject('body').attr('id') != "global_page_courses-index-compare")
        sesJqueryObject('.courses_compare_fixed').show();
    }
});
sesJqueryObject(document).on('click','.courses_compare_remove_all',function (e) {
	sesJqueryObject('.courses_compare_fixed').hide();
    sesJqueryObject('.courses_compare_tabs_ul').html('');
    sesJqueryObject('.courses_compare_cnt').html('');
    sesJqueryObject('.courses_compare_change').removeAttr('checked');
    sesJqueryObject.post('courses/index/compare-course/type/all',{},function (res) {

    });
});

sesJqueryObject(document).on('click','.courses_compare_change',function (e) {
	var data = sesJqueryObject(this).data('attr');
	var isChecked = sesJqueryObject(this).is(':checked');
	//isChecked == false remove
	//isChecked == true add
	if(isChecked == true) {
        addCourseCompareHTML(data,this);
    }else{
		removeCompareCourse(data,this);
	}
});
function removeCompareCourse(data,obj) {
    //remove
    var category_id = data.category_id;
    sesJqueryObject.post('courses/index/compare-course/type/remove',{category_id:category_id,course_id:data.course_id},function (res) {
    });
    var isCategoryLiExists = sesJqueryObject('.courses_compare_tabs_ul').find('li[data-category='+category_id+']');
    var index = isCategoryLiExists.index();
    sesJqueryObject('.courses_compare_cnt').find('.courses_course_cnt[data-courseid='+data.course_id+']').remove();

    var count = sesJqueryObject('.courses_compare_cnt').find('.courses_compare_inner').eq(index);

    if(!count.find('.courses_course_cnt').length){
        isCategoryLiExists.remove();
    }else{
        var countCourse = sesJqueryObject('.courses_compare_cnt').find('.courses_compare_inner').eq(index).find('.courses_compare_small_course').length;
        isCategoryLiExists.find('a').html(data.category_title+" <span>"+countCourse+"</span>");
    }
	if(!sesJqueryObject('.courses_compare_tabs_ul').find('li').length){
		sesJqueryObject('.courses_compare_fixed').hide();
	}
}
function addCourseCompareHTML(data,obj) {
    sesJqueryObject('.courses_compare_fixed').show();
    var course_id = data.course_id;
    var category_id = data.category_id;
    var category_title = data.category_title;
    var countElementInCategory = 1;
    var courseImage = data.image;
    sesJqueryObject.post('courses/index/compare-course/type/add',{category_id:category_id,course_id:course_id},function (res) {

    });
    if(sesJqueryObject('.courses_course_cnt[data-courseid='+course_id+']').length){
		return;
	}
	var isCategoryLiExists = sesJqueryObject('.courses_compare_tabs_ul').find('li[data-category='+category_id+']');
	if(!isCategoryLiExists.length) {
        var liHTML = '<li data-category = "' + category_id + '">' +
            '<a href="javascript:;">' + category_title + ' <span>1</span></a>' + '</li>';
		sesJqueryObject('.courses_compare_tabs_ul').append(liHTML);
		sesJqueryObject('.courses_compare_cnt').append("<div class='courses_compare_inner' style=\"display:none\"></div>");
        var index = sesJqueryObject('.courses_compare_tabs_ul').find('li[data-category='+category_id+']').index();
    }else{
	    var index = isCategoryLiExists.index();
	    var countCourse = sesJqueryObject('.courses_compare_cnt').find('.courses_compare_inner').eq(index).find('.courses_compare_small_course').length + 1;
        isCategoryLiExists.find('a').html(category_title+" <span>"+countCourse+"</span>");
	}
	var htmlCode = "<div data-attr='"+JSON.stringify(sesJqueryObject(obj).data('attr'))+"'' " +
		'class="courses_compare_small_course courses_course_cnt"  data-courseid="'+course_id+'">'
		+'<img src="'+courseImage+'" alt=""/>' +'<a class="courses_compare_course_a" href="javascript:;">' +
	'<div class="compare_close"><i class="fa fa-close"></i></div></a>' + '</div>';
    sesJqueryObject('.courses_compare_cnt').find('.courses_compare_inner').eq(index).append(htmlCode);

    if(sesJqueryObject('.courses_compare_tabs_ul').find('li').length == 1) {
        sesJqueryObject('.courses_compare_tabs_ul').find('li').eq(0).addClass('active');
        sesJqueryObject('.courses_compare_cnt').find('.courses_compare_inner').eq(0).show();
    }

}
sesJqueryObject(document).on('click','.courses_compare_course_a',function (e) {
	var elem = sesJqueryObject(this).closest('.courses_course_cnt');
	var data = elem.data('attr');
	removeCompareCourse(data,elem);
	sesJqueryObject('.courses_compare_course_'+data.course_id).removeAttr('checked');
});
</script>
