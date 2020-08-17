<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(empty($this->viewer_id)) { ?>
  <script>
    scriptJquery(document).ready(function(e) {
      if(scriptJquery('.core_mini_auth'))
        scriptJquery('.core_mini_auth').find('span').html('Sign In');
      if(scriptJquery('.core_mini_signup'))
        scriptJquery('.core_mini_signup').find('span').html('Sign Up');
    });
  </script>
  <style>
  #core_menu_mini_menu > ul > li {
    display: flex;
    }
		 #global_header .layout_core_menu_mini #core_menu_mini_menu > ul .core_mini_auth i, 
		 #global_header .layout_core_menu_mini #core_menu_mini_menu > ul .core_mini_signup i {
       display: none !important;
     }
     .layout_core_menu_mini #core_menu_mini_menu > ul > li .core_mini_auth{
	      font-size:100%;
     }
      html .layout_core_menu_mini #core_menu_mini_menu > ul > li .core_mini_auth, 
      html .layout_core_menu_mini #core_menu_mini_menu > ul > li .core_mini_signup{
	      width:auto !important;
	      line-height:21px !important;
      }
			html .layout_core_menu_mini #core_menu_mini_menu > ul > li .core_mini_auth:before{
	      display:none !important;
      }
	</style>
<?php } ?>
<?php
$baseUrl = Zend_Registry::get('StaticBaseUrl');
 ?>

<?php $enablePopUp = Engine_Api::_()->getApi('settings', 'core')->getSetting('einstaclone.popupsign', 1);  ?>
<?php $showPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('einstaclone.popup.enable', 1);?>

<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName();?>
<?php $moduleName = $request->getModuleName();?>

<?php $showSeparator = 0;?> 
<?php $settings = Engine_Api::_()->getApi('settings', 'core');?>
<?php $facebook = Engine_Api::_()->getDbtable('facebook', 'user')->getApi();?>
<?php if ('none' != $settings->getSetting('core_facebook_enable', 'none') && $settings->core_facebook_secret && $facebook):?>
  <?php $showSeparator = 1;?>
<?php elseif ('none' != $settings->getSetting('core_insta_enable', 'none') && $settings->core_insta_secret):?>
  <?php $showSeparator = 1;?>
<?php endif;?>

<?php $siteTitle = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.site.title','1');?>


<div class="<?php if($this->viewer_id){ ?> header einstaclone_bxs einstaclone_clearfix <?php } else { ?> header einstaclone_bxs <?php  } ?>">
  <div class="header_logo">
  <?php if($this->show_logo) { ?>
    <?php if($this->headerlogo): ?>
        <?php $headerlogo = Engine_Api::_()->einstaclone()->getFileUrl($this->headerlogo); ?>
        <a href=""><img alt="" src="<?php echo $headerlogo ?>"></a>
        <?php else: ?>
        <a href=""><?php echo $this->siteTitle; ?></a>
       <?php endif; ?>
      <?php } ?>
     </div>
    <div class="header_searchbox">
      <?php if($this->show_search) { ?>
      <div class="search_inner">
      <?php if(defined('sesadvancedsearch')){
            echo $this->content()->renderWidget("advancedsearch.search");
      }else{ ?>
      <?php  echo $this->content()->renderWidget("einstaclone.search"); ?>
      <?php } ?>
      </div>
      <?php } ?>
    </div>
 <div class="header_menus einstaclone_bxs einstaclone_clearfix">
    <div class="menu_middle">
       <?php if($this->show_mini) { ?>
         <?php echo $this->content()->renderWidget("core.menu-mini"); ?>
      <?php } ?> 
    <?php if($this->show_menu) { ?>
      <div class="menu_right">
        <ul>
          <li id="st-trigger-effects" class="main_menu_link st-pusher">
            <a onclick="showMenu();" href="javascript:void(0);" class="slide_btn" id="slide_btn" data-effect="st-effect-4">
						 <i class="fa fa-bars"></i>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><title/><g data-name="1" id="_1"><path d="M441.13,166.52h-372a15,15,0,1,1,0-30h372a15,15,0,0,1,0,30Z"/><path d="M441.13,279.72h-372a15,15,0,1,1,0-30h372a15,15,0,0,1,0,30Z"/><path d="M441.13,392.92h-372a15,15,0,1,1,0-30h372a15,15,0,0,1,0,30Z"/></g></svg>
           </a>
          </li>
        </ul>
      </div>
      <?php  } ?>
    </div>
  </div>
</div>
<nav class="st-menu st-effect-4" id="show_main_menu">
  <div class="menus_searh_close">
    <div class="menu_search_box">
    <?php if(defined('sesadvancedsearch')){
            echo $this->content()->renderWidget("advancedsearch.search");
      }else{ ?>
      <input autocomplete="off" placeholder="<?php echo $this->translate('Search'); ?>" id="einstacloneside_search" type="text" name="name" />
      <a onclick="javascript:showAllSearchResultsSearchSide();" href="javascript:void(0);"><i class="fa fa-search"></i></a> 
       <?php } ?>     
    </div>
    <div class="closer_button">
  		<a onclick="hideSidePanel();" href="javascript:void(0);" class="close_menu"><i class="fa fa-times"></i></a>  
    </div>
  </div>
  
  <div id="menu_left_panel" class="menu_right_panel mCustomScrollbar" data-mcs-theme="minimal-dark">
  
    <ul class="menu_right_list_links">
      <?php foreach( $this->mainMenuNavigation as $navigationMenu ): ?>
        <?php $class = explode(' ', $navigationMenu->class); ?>
        <?php $navClass = end($class); ?>
        <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
          <?php if($navClass == 'core_main_invite'):?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'>
          <?php elseif($navClass == 'core_main_chat'):?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'chat'), $navigationMenu->route, true) ?>'>
          <?php elseif($navClass == 'core_main_home' && ($this->viewer->getIdentity() != 0)):?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'>
          <?php else:?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>'>
          <?php endif;?>
          <i class="fa <?php echo $navigationMenu->get('icon') ? $navigationMenu->get('icon') : 'fa-star' ?>"></i>
          <span><?php echo $this->translate($navigationMenu->label); ?></span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
    <?php if($this->footersidepanel) { ?>
      <div class="menu_footer">
        <div class="menu_footer_links">
          <ul>
            <?php foreach( $this->footerNavigation as $item ): ?>
              <li><a href="<?php echo $item->getHref(); ?>"><?php echo $this->translate($item->getLabel()); ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="menu_copy_lang">
          <p class="menu_copyright"><?php echo $this->translate('Copyright &copy; %s', date('Y')) ?></p>
          <?php if( 1 !== count($this->languageNameList) ): ?>
            <div class="footer_lang">
              <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" style="display:inline-block">
                <?php $selectedLanguage = $this->translate()->getLocale() ?>
                <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
                <?php echo $this->formHidden('return', $this->url()) ?>
              </form>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php } ?>
    
  </div>
</nav>

<script type='text/javascript'>

  function scrollingeinstaclone() {

    var height = scriptJquery( window ).height();
    if(document.getElementById("menu_left_panel")) {
      document.getElementById("menu_left_panel").setStyle("max-height", height+"px");
    }
    var heightPannel = scriptJquery("#menu_left_panel").height() - 51;
    scriptJquery('#global_content').css('min-height',heightPannel+'px');
  }
  
  scriptJquery(document).ready(function(){
    scrollingeinstaclone();
  });

  function showMenu() {
    if(document.getElementById('show_main_menu').style.display != 'block') { 
      <?php if($this->sidepaneldesign == 1) { ?>
        if($(document.body).hasClass('st-menu-open-design1')) { 
          hideSidePanel();
        } else { 
          $(document.body).addClass("st-menu-open-design1");
        }
      <?php } else { ?>
        if($(document.body).hasClass('st-menu-open-design2')) {
          hideSidePanel();
        } else { 
          $(document.body).addClass("st-menu-open-design2");
        }
      <?php } ?>
    }
  }
  function hideSidePanel() {  
    <?php if($this->sidepaneldesign == 1) { ?>
      $(document.body).removeClass("st-menu-open-design1");
    <?php } else { ?>
      $(document.body).removeClass("st-menu-open-design2");
    <?php } ?>
  }
	
		window.addEvent('domready', function() {
		
			$(document.body).addEvent('click', function(event) {
	
				if(event.target.className != 'fa fa-bars' && event.target.className != 'search-input' && event.target.id != 'einstacloneside_search' && event.target.className != 'menu_footer_links' && event.target.className != 'fa fa-bars' && event.target.id != 'language') {
					//$(document.body).removeClass("st-menu-open");
					<?php if($this->sidepaneldesign == 1) { ?>
						$(document.body).removeClass("st-menu-open-design1");
					<?php } else { ?>
						$(document.body).removeClass("st-menu-open-design2");
					<?php } ?>
				}
			});
		});
  
	<?php if($this->viewer_id){?>

		//Search
		en4.core.runonce.add(function() {
			var searchAutocomplete = new Autocompleter.Request.JSON('einstacloneside_search', "<?php echo $this->url(array('module' => 'einstaclone', 'controller' => 'index', 'action' => 'search'), 'default', true) ?>", {
				'postVar': 'text',
				'delay' : 250,
				'minLength': 1,
				'selectMode': 'pick',
				'autocompleteType': 'tag',
				'customChoices': true,
				'filterSubset': true,
				'multiple': false,
				'className': 'einstaclone-autosuggest',
				'indicatorClass':'input_loading',
				'injectChoice': function(token) {
				if(token.url != 'all') {
					var choice = new Element('li', {
						'class': 'autocompleter-choices',
						'html': token.photo,
						'id': token.label
					});
					new Element('div', {
						'html': this.markQueryValue(token.label),
						'class': 'autocompleter-choice'
					}).inject(choice);
					new Element('div', {
						'html': this.markQueryValue(token.resource_type),
						'class': 'autocompleter-choice bold'
					}).inject(choice);
					choice.inputValue = token;
					this.addChoiceEvents(choice).inject(this.choices);
					choice.store('autocompleteChoice', token);
				}
				else {
				 var choice = new Element('li', {
						'class': 'autocompleter-choices',
						'html': '',
						'id': 'all'
					});
					new Element('div', {
						'html': 'Show All Results',
						'class': 'autocompleter-choice',
						onclick: 'javascript:showAllSearchResultsSearch();'
					}).inject(choice);
					choice.inputValue = token;
					this.addChoiceEvents(choice).inject(this.choices);
					choice.store('autocompleteChoice', token);
				}
				}
			});
			searchAutocomplete.addEvent('onSelection', function(element, selected, value, input) {
				var url = selected.retrieve('autocompleteChoice').url;
				window.location.href = url;
			});
		});
		
		en4.core.runonce.add(function() {
			var searchAutocomplete = new Autocompleter.Request.JSON('einstaclone_search', "<?php echo $this->url(array('module' => 'einstaclone', 'controller' => 'index', 'action' => 'search'), 'default', true) ?>", {
				'postVar': 'text',
				'delay' : 250,
				'minLength': 1,
				'selectMode': 'pick',
				'autocompleteType': 'tag',
				'customChoices': true,
				'filterSubset': true,
				'multiple': false,
				'className': 'einstaclone-autosuggest',
				'indicatorClass':'input_loading',
				'injectChoice': function(token) {
				if(token.url != 'all') {
					var choice = new Element('li', {
						'class': 'autocompleter-choices',
						'html': token.photo,
						'id': token.label
					});
					new Element('div', {
						'html': this.markQueryValue(token.label),
						'class': 'autocompleter-choice'
					}).inject(choice);
					new Element('div', {
						'html': this.markQueryValue(token.resource_type),
						'class': 'autocompleter-choice bold'
					}).inject(choice);
					choice.inputValue = token;
					this.addChoiceEvents(choice).inject(this.choices);
					choice.store('autocompleteChoice', token);
				}
				else {
				 var choice = new Element('li', {
						'class': 'autocompleter-choices',
						'html': '',
						'id': 'all'
					});
					new Element('div', {
						'html': 'Show All Results',
						'class': 'autocompleter-choice',
						onclick: 'javascript:showAllSearchResultsSearch();'
					}).inject(choice);
					choice.inputValue = token;
					this.addChoiceEvents(choice).inject(this.choices);
					choice.store('autocompleteChoice', token);
				}
				}
			});
			searchAutocomplete.addEvent('onSelection', function(element, selected, value, input) {
				var url = selected.retrieve('autocompleteChoice').url;
				window.location.href = url;
			});
		});
		
		function showAllSearchResultsSearch() {
			if($('all'))
				$('all').removeEvents('click');
			window.location.href= '<?php echo $this->url(array("controller" => "search"), "default", true); ?>' + "?query=" + $('einstaclone_search').value;
		}
		
		function showAllSearchResultsSearchSide() {
			if($('all'))
				$('all').removeEvents('click');
			window.location.href= '<?php echo $this->url(array("controller" => "search"), "default", true); ?>' + "?query=" + $('einstacloneside_search').value;
		}
		
		scriptJquery(document).ready(function() {
			scriptJquery('#einstaclone_search').keydown(function(e) {
				if (e.which === 13) {
					showAllSearchResultsSearch();
				}
			});
			scriptJquery('#einstacloneside_search').keydown(function(e) {
				if (e.which === 13) {
					showAllSearchResultsSearchSide();
				}
			});
		});
   <?php } ?>
	
	scriptJquery(window).ready(function(e){
		var height = scriptJquery(".layout_page_header").height();
		if($("global_wrapper")) {
			$("global_wrapper").setStyle("margin-top", height+"px");
		}
	});
	
</script>
<?php $header_fixed = Engine_Api::_()->einstaclone()->getContantValueXML('einstaclone_header_fixed_layout');
if($header_fixed == '1'):

?>
<script>
	jqueryObjectOfSes(document).ready(function(e){
	var height = jqueryObjectOfSes('.layout_page_header').height();
		if($('global_wrapper')) {
	    $('global_wrapper').setStyle('margin-top', height+"px");
	  }
	});
	</script>
<?php endif; ?>
<?php  

if($header_fixed == '2'):

?>
<script>
	jqueryObjectOfSes(document).ready(function(e){
	var height = jqueryObjectOfSes('.layout_page_header').height();
		if($('global_wrapper')) {
	    $('global_wrapper').setStyle('margin-top', height+"px");
	  }
	});
	</script>
<?php endif; ?>
