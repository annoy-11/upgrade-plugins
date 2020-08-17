<?php



/**

 * SocialEngineSolutions

 *

 * @category   Application_Sesdemouser

 * @package    Sesdemouser

 * @copyright  Copyright 2015-2016 SocialEngineSolutions

 * @license    http://www.socialenginesolutions.com/license/

 * @version    $Id: index.php 2015-10-22 00:00:00 SocialEngineSolutions $

 * @author     SocialEngineSolutions

 */



?>

<?php if($this->defaultimage): ?>

<?php $icon = Engine_Api::_()->sesdemouser()->getFileUrl($this->defaultimage); ?>

<?php else: ?>

<?php $icon = $this->layout()->staticBaseUrl.'application/modules/Sesdemouser/externals/images/nophoto_user_thumb_icon.png'; ?>

<?php endif; ?>



<div id="demoUser" class="sesbasic_bxs sesdemouser_user_block<?php if($this->showside == 'right'):?> f_right<?php endif;?>">

	<img title="<?php echo $this->translate($this->headingText); ?>" alt="<?php echo $this->translate($this->headingText); ?>" src="<?php echo $icon ?>" id="showHide" class="sesdemouser_pointer">

  <h3><?php echo $this->translate($this->headingText); ?></h3>

  <div class="sesdemouser_user_block_content">

    <p><?php echo $this->translate($this->innerText); ?></p>

    <ul class="sesbasic_clearfix sesdemouser_user_list" id="imageColor">

      <?php foreach($this->results as $result):

        $user = Engine_Api::_()->getItem('user', (int) $result->user_id);

      ?>

      <?php if($this->designshow == 'gridView'): ?>

        <li class="sesdemouser_user_grid_view">
	        <?php echo $this->itemPhoto($user, "thumb.icon", $user->getTitle(), array('title' => $user->getTitle(), 'onclick'=> "loginAsUser('".$user->user_id."'); return false;")) ?>
        </li>

      <?php else: ?>

        <li class="sesdemouser_user_list_view sesbasic_clearfix">

          <?php echo $this->itemPhoto($user, "thumb.icon", $user->getTitle(), array('title' => $user->getTitle())) ?>

          <div class="sesdemouser_user_list_view_info">

          	<b><?php echo $user->getTitle(); ?></b>

            <button onclick= "loginAsUser('<?php echo $user->user_id ?>'); return false;"><?php echo $this->translate("Login"); ?></button>

          </div>

        </li>

      <?php endif; ?>

      <?php endforeach; ?>

    </ul>

  </div>

  <div style="height:0;overflow:hidden;"><?php echo $this->content()->renderWidget("user.login-or-signup"); ?></div>

</div>



<script type="text/javascript">



$('demoUser').addEvent('click', function(event){

  

if($(event.target.id)) {

  var demouserId = event.target.id;

  var demousers = demouserId.split('_');

}



event.stopPropagation();

if(event.target.id == 'showHide'){



  if($('demoUser').hasClass('openuserpanel')){

    $('demoUser').removeClass('openuserpanel');

  } else

    $('demoUser').addClass('openuserpanel');

}
});



function none(){

	document.getElementById('themeConf_loader').style.display='none';

	return false;	

}

</script> 

<style type="text/css">

.sesdemouser_user_block {

	border-radius:0 3px 3px 0;

	left:-198px;

	margin:76px 0 0;

	padding-bottom: 5px;

	position: fixed;

	top: 20px; 

	transition: all 0.7s ease 0s; 

	width: 195px;

	z-index: 99;

}

.sesdemouser_user_block.openuserpanel {

	left:0;

}

.sesdemouser_pointer { 

	cursor: pointer; 

	height:32px; 

	left:0; 

	margin:39px 0 0 193px; 

	position:absolute; 

	width:32px; 

}

.sesdemouser_user_block.f_right {

	border-radius:3px 0 0 3px;

	left:inherit;

	right:-198px;

}

.sesdemouser_user_block.f_right.openuserpanel {

	left:inherit;

	right:-1px;

}

.sesdemouser_user_block.f_right .sesdemouser_pointer{

	margin:39px 0 0 -32px; 

}

.sesdemouser_user_block_content {

	padding:10px; 

	width:195px; 

}

.sesdemouser_user_block h3 {

	font-size:14px; 

	font-weight:bold !important; 

	margin-bottom:0; 

	padding:10px 0; 

	text-align:center; 

}

.sesdemouser_user_block_content p { 

	margin-bottom:10px;

	font-size:12px;

}

.sesdemouser_user_list{

	max-height:170px;

	overflow:auto;

}

.sesdemouser_user_list li.sesdemouser_user_grid_view{

	float:left;

	margin:2px;

	float:left;

}

.sesdemouser_user_list li.sesdemouser_user_grid_view img{

	cursor:pointer;

	float:left;

}

.sesdemouser_user_list_view + .sesdemouser_user_list_view{

	margin-top:10px;

}

.sesdemouser_user_list_view img{

	float:left;

	margin-right:10px;

}

.sesdemouser_user_list_view_info{

	overflow:hidden;

}

.sesdemouser_user_list_view_info b{

	font-size:12px;

	font-weight:bold;

	display:block;

	margin-bottom:5px;

}

.sesdemouser_user_list_view_info button{

	font-size:10px;

	padding:5px 10px;

}

</style>


<script>
  function loginAsUser(id) {

  var url = en4.core.baseUrl + 'sesdemouser/index/login';
  var baseUrl = '<?php echo $this->url(array(), 'default', true) ?>';
  (new Request.JSON({
    url : url,
    data : {
      format : 'json',
      id : id
    },
    onSuccess : function() {
      window.location.replace('members/home/');
    }
  })).send();
}
</script>
