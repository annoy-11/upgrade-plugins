<?php ?>
<div class="sesvideo_sidebar_sellbutton">
	<span class="centerT">$10.00</span>
	<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesvideosell', 'controller' => 'order', 'action' => 'process', 'video_id' => $this->subject_id, 'gateway_id' => 2), $this->translate("Purchase"), array('class' => 'sesvideo_sellbutton sesbasic_animation centerT')); ?>
</div>