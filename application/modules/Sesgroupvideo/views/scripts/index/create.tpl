<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupvideo
 * @package    Sesgroupvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroupvideo/externals/styles/styles.css');?>

<?php

  if (APPLICATION_ENV == 'production')

    $this->headScript()

      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.min.js');

  else

    $this->headScript()

      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Observer.js')

      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.js')

      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Local.js')

      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Request.js');

?>

<div class="layout_middle">

  <div class="sesbasic_ext_breadcrumb sesbasic_bxs sesbasic_clearfix">

    <div class="_mainhumb"><a href="<?php echo $this->parentItem->getHref(); ?>"><img src="<?php echo $this->parentItem->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon" /></a></div>

    <div class="_maincont">

      <a href="<?php echo $this->parentItem->getHref(); ?>"><?php echo $this->parentItem->getTitle(); ?></a>

      <span class="sesbasic_text_light">&raquo;</span>

      <span><?php echo $this->translate("Post New Video"); ?></span>

    </div>

  </div>

</div>

<script type="text/javascript">



  en4.core.runonce.add(function() {

    var tagsUrl = '<?php echo $this->url(array('controller' => 'tag', 'action' => 'suggest'), 'default', true) ?>';

    var validationUrl = '<?php echo $this->url(array('module' => 'sesgroupvideo', 'controller' => 'index', 'action' => 'validation'), 'default', true) ?>';

    var validationErrorMessage = "<?php echo $this->translate("We could not find a video there - please check the URL and try again. If you are sure that the URL is valid, please click %s to continue.", "<a href='javascript:void(0);' onclick='javascript:ignoreValidation();'>".$this->translate("here")."</a>"); ?>";

    var checkingUrlMessage = '<?php echo $this->string()->escapeJavascript($this->translate('Checking URL...')) ?>';

    var current_code;

    var ignoreValidation = window.ignoreValidation = function() {

      $('upload-wrapper').style.display = "block";

      $('validation').style.display = "none";

      $('code').value = current_code;

      $('ignore').value = true;

    }

    var updateTextFields = window.updateTextFields = function() {

      var video_element = document.getElementById("type");

      var url_element = document.getElementById("url-wrapper");

      var file_element = document.getElementById("Filedata-wrapper");

      var submit_element = document.getElementById("upload-wrapper");

      // clear url if input field on change

      //$('code').value = "";

      $('upload-wrapper').style.display = "none";

      // If video source is empty

      if( video_element.value == 0 ) {

				//if($('photo_id-wrapper'))

					//$('photo_id-wrapper').style.display = 'none';

        $('url').value = "";

        file_element.style.display = "none";

        url_element.style.display = "none";

				sesJqueryObject('#rotation-wrapper').hide();

				sesJqueryObject('#title-wrapper').show();

				sesJqueryObject('#description-wrapper').show();

        return;

      } else if( video_element.value == 'iframely' ) {

        // If video source is youtube or vimeo

        $('url').value = '';

        $('code').value = '';

        $('id').value = '';

        file_element.style.display = "none";

        //rotation_element.style.display = "none";

        url_element.style.display = "block";

        return;

      }

//       else if( $('code').value && $('url').value ) {

// 				//if($('photo_id-wrapper'))

// 					//$('photo_id-wrapper').style.display = 'none';

//         $('type-wrapper').style.display = "none";

//         file_element.style.display = "none";

//         $('upload-wrapper').style.display = "block";

// 				if(video_element.value == 5){	

// 					sesJqueryObject('#title-wrapper').hide();

// 					sesJqueryObject('#description-wrapper').hide();

// 				}

//         return;

//       } 

      else if( video_element.value == 1 || video_element.value == 2 || video_element.value == 4 || video_element.value == 5 || video_element.value == 16 || video_element.value == 17 ) {

				

				if(video_element.value == 5){

					if($('photo_id-wrapper'))

						$('photo_id-wrapper').style.display = 'none';	

					sesJqueryObject('#title-wrapper').hide();

					sesJqueryObject('#description-wrapper').hide();

				}else{

					if($('photo_id-wrapper'))

						$('photo_id-wrapper').style.display = 'block';	

					sesJqueryObject('#title-wrapper').show();

					sesJqueryObject('#description-wrapper').show();	

				}

				sesJqueryObject('#rotation-wrapper').hide();

				//if($('photo_id-wrapper'))

					//$('photo_id-wrapper').style.display = 'none';

        // If video source is youtube or youtubePlaylist or vimeo or daily motion

        $('url').value = "";

        $('code').value = "";

        file_element.style.display = "none";

        url_element.style.display = "block";

				if(video_element.value == 17){

					url_element.style.display = "none";

					$('embedUrl-wrapper').style.display = 'block';

				}else{

					$('embedUrl-wrapper').style.display = 'none';

				}

        return;

      } else if( video_element.value == 3 ) {

				<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupvideo.direct.video', 0)){ 

								$show = 'hide';

							}else{

								$show="show";

							}

				?>

				sesJqueryObject('#rotation-wrapper').<?php echo $show; ?>();

				sesJqueryObject('#title-wrapper').show();

				sesJqueryObject('#description-wrapper').show();

				//if($('photo_id-wrapper'))

					//$('photo_id-wrapper').style.display = 'block';

        // If video source is from computer

        $('url').value = "";

        $('code').value = "";

        file_element.style.display = "block";

        url_element.style.display = "none";
        $('upload_file').style.display = "block";
        $('upload-wrapper').style.display = "";
        return;

      } else if( $('id').value ) {

				if(video_element.value == 5){	

					sesJqueryObject('#title-wrapper').hide();

					sesJqueryObject('#description-wrapper').hide();

				}

				//if($('photo_id-wrapper'))

					//$('photo_id-wrapper').style.display = 'none';

        // if there is video_id that means this form is returned from uploading 

        // because some other required field

        $('type-wrapper').style.display = "none";

        file_element.style.display = "none";

        $('upload-wrapper').style.display = "block";

        return;

      }

    }

    var video = window.video = {

      active : false,

      debug : false,

      currentUrl : null,

      currentTitle : null,

      currentDescription : null,

      currentImage : 0,

      currentImageSrc : null,

      imagesLoading : 0,

      images : [],

      maxAspect : (10 / 3), //(5 / 2), //3.1,

      minAspect : (3 / 10), //(2 / 5), //(1 / 3.1),

      minSize : 50,

      maxPixels : 500000,

      monitorInterval: null,

      monitorLastActivity : false,

      monitorDelay : 500,

      maxImageLoading : 5000,

      attach : function() {

        var bind = this;

        $('url').addEvent('keyup', function() {

          bind.monitorLastActivity = (new Date).valueOf();

        });

        var url_element = document.getElementById("url-element");

        var myElement = new Element("p");

        myElement.innerHTML = "test";

        myElement.addClass("description");

        myElement.id = "validation";

        myElement.style.display = "none";

        url_element.appendChild(myElement);

        var body = $('url');

        var lastBody = '';

        var lastMatch = '';

        var video_element = $('type');

        (function() {

          // Ignore if no change or url matches

          if( body.value == lastBody || bind.currentUrl ) {

            return;

          }

          // Ignore if delay not met yet

          if( (new Date).valueOf() < bind.monitorLastActivity + bind.monitorDelay ) {

            return;

          }

          // Check for link

//           var m = body.value.match(/https?:\/\/([-\w\.]+)+(:\d+)?(\/([-#:\w/_\.]*(\?\S+)?)?)?/);

//           if( $type(m) && $type(m[0]) && lastMatch != m[0] ) {

//             if (video_element.value == 1){

//               video.youtube(body.value);

//             } else if(video_element.value == 4){

// 							video.dailymotion(body.value);	

// 						}else if(video_element.value == 5){

// 							video.youtubePlaylist(body.value);	

// 						}else if(video_element.value == 16){

// 							video.fromURL(body.value);	

// 						}else {

//               video.vimeo(body.value);

//             }

//           }

          video.iframely(body.value);

          lastBody = body.value;

        }).periodical(250);

      },

      iframely : function(url) {

          (new Request.JSON({

            'url' : validationUrl,

            'data' : {

              'format': 'json',

              'uri' : url,

              'type' : 'iframely',

            },

            'onRequest' : function() {

              $('validation').style.display = "block";

              $('validation').innerHTML = checkingUrlMessage;

              $('upload-wrapper').style.display = "none";

            },

            'onSuccess' : function(response) {

              if( response.valid ) {

                $('upload-wrapper').style.display = "block";

                $('validation').style.display = "none";

                //$('code').value = response.iframely.code;

                $('title').value = response.iframely.title;

                $('description').value = response.iframely.description;

                $('validation').value = "none";

              } else {

                $('upload-wrapper').style.display = "none";

                $('validation').innerHTML = validationErrorMessage;

                $('code').value = '';

              }

            }

          })).send();

      },

			fromURL:function(url,mUrl){

        if( url ) {

          (new Request.HTML({

            'format': 'html',

            'url' : validationUrl,

            'data' : {

              'ajax' : true,

              'code' : url,

              'type' : 'fromurl',

            },

            'onRequest' : function() {

              $('validation').style.display = "block";

              $('validation').innerHTML = checkingUrlMessage;

              $('upload-wrapper').style.display = "none";

            },

            'onSuccess' : function(responseTree, responseElements, responseHTML, responseJavaScript) {

              if( valid ) {

                $('upload-wrapper').style.display = "block";

                $('validation').style.display = "none";

                $('code').value = url;

              } else {

                $('upload-wrapper').style.display = "none";

                current_code = url;

                $('validation').innerHTML = validationErrorMessage;

              }

            }

          })).send();

        }

			},

			fromEmbedCode:function(url,mUrl){

          (new Request.HTML({

            'format': 'html',

            'url' : validationUrl,

            'data' : {

              'ajax' : true,

              'code' : url,

              'type' : 'embedCode',

            },

            'onRequest' : function() {

              $('validation').style.display = "block";

              $('validation').innerHTML = checkingUrlMessage;

              $('upload-wrapper').style.display = "none";

            },

            'onSuccess' : function(responseTree, responseElements, responseHTML, responseJavaScript) {

              if( valid ) {

                $('upload-wrapper').style.display = "block";

                $('validation').style.display = "none";

                $('code').value = dailymotion_code;

              } else {

                $('upload-wrapper').style.display = "none";

                current_code = url;

                $('validation').innerHTML = validationErrorMessage;

              }

            }

          })).send();      

			},

			dailymotion : function(url,mUrl) {

        var myURI = new URI(url);

				var data = myURI.get('file').split('_');

        var dailymotion_code = data[0];

        if( dailymotion_code.length > 0 ) {

          (new Request.HTML({

            'format': 'html',

            'url' : validationUrl,

            'data' : {

              'ajax' : true,

              'code' : dailymotion_code,

              'type' : 'dailymotion',

            },

            'onRequest' : function() {

              $('validation').style.display = "block";

              $('validation').innerHTML = checkingUrlMessage;

              $('upload-wrapper').style.display = "none";

            },

            'onSuccess' : function(responseTree, responseElements, responseHTML, responseJavaScript) {

              if( valid ) {

                $('upload-wrapper').style.display = "block";

                $('validation').style.display = "none";

                $('code').value = dailymotion_code;

              } else {

                $('upload-wrapper').style.display = "none";

                current_code = dailymotion_code;

                $('validation').innerHTML = validationErrorMessage;

              }

            }

          })).send();

        }

      },

      youtube : function(url) {

        // extract v from url

        var myURI = new URI(url);

        var youtube_code = myURI.get('data')['v'];

        if( youtube_code === undefined ) {

          youtube_code = myURI.get('file');

        }

        if (youtube_code){

          (new Request.HTML({

            'format': 'html',

            'url' : validationUrl,

            'data' : {

              'ajax' : true,

              'code' : youtube_code,

              'type' : 'youtube'

            },

            'onRequest' : function(){

              $('validation').style.display = "block";

              $('validation').innerHTML = checkingUrlMessage;

              $('upload-wrapper').style.display = "none";

            },

            'onSuccess' : function(responseTree, responseElements, responseHTML, responseJavaScript) {

              if( valid ) {

                $('upload-wrapper').style.display = "block";

                $('validation').style.display = "none";

                $('code').value = youtube_code;

              } else {

                $('upload-wrapper').style.display = "none";

                current_code = youtube_code;

                $('validation').innerHTML = validationErrorMessage;

              }

            }

          })).send();

        }

      },

      vimeo : function(url) {

        var myURI = new URI(url);

        var vimeo_code = myURI.get('file');

        if( vimeo_code.length > 0 ) {

          (new Request.HTML({

            'format': 'html',

            'url' : validationUrl,

            'data' : {

              'ajax' : true,

              'code' : vimeo_code,

              'type' : 'vimeo'

            },

            'onRequest' : function() {

              $('validation').style.display = "block";

              $('validation').innerHTML = checkingUrlMessage;

              $('upload-wrapper').style.display = "none";

            },

            'onSuccess' : function(responseTree, responseElements, responseHTML, responseJavaScript) {

              if( valid ) {

                $('upload-wrapper').style.display = "block";

                $('validation').style.display = "none";

                $('code').value = vimeo_code;

              } else {

                $('upload-wrapper').style.display = "none";

                current_code = vimeo_code;

                $('validation').innerHTML = validationErrorMessage;

              }

            }

          })).send();

        }

      },

			youtubePlaylist : function(url) {

        var myURI = new URI(url);

        var youtubePlaylist_code = myURI.get('data')['list'];

        if( youtubePlaylist_code.length > 0 ) {

          (new Request.HTML({

            'format': 'html',

            'url' : validationUrl,

            'data' : {

              'ajax' : true,

              'code' : youtubePlaylist_code,

              'type' : 'youtubePlaylist'

            },

            'onRequest' : function() {

              $('validation').style.display = "block";

              $('validation').innerHTML = checkingUrlMessage;

              $('upload-wrapper').style.display = "none";

            },

            'onSuccess' : function(responseTree, responseElements, responseHTML, responseJavaScript) {

              if( valid ) {

                $('upload-wrapper').style.display = "block";

                $('validation').style.display = "none";

                $('code').value = youtubePlaylist_code;

              } else {

                $('upload-wrapper').style.display = "none";

                current_code = youtubePlaylist_code;

                $('validation').innerHTML = validationErrorMessage;

              }

            }

          })).send();

        }

      }

    }

    // Run stuff

    updateTextFields();

    video.attach();

    var autocompleter = new Autocompleter.Request.JSON('tags', tagsUrl, {

      'postVar' : 'text',

      'minLength': 1,

      'selectMode': 'pick',

      'autocompleteType': 'tag',

      'className': 'tag-autosuggest',

      'customChoices' : true,

      'filterSubset' : true,

      'multiple' : true,

      'injectChoice': function(token){

        var choice = new Element('li', {'class': 'autocompleter-choices', 'value':token.label, 'id':token.id});

        new Element('div', {'html': this.markQueryValue(token.label),'class': 'autocompleter-choice'}).inject(choice);

        choice.inputValue = token;

        this.addChoiceEvents(choice).inject(this.choices);

        choice.store('autocompleteChoice', token);

      }

    });

		var oldValEmbed = "";

    var newEmbedRequest;

    sesJqueryObject("#embedUrl").on("change keyup paste", function() {

      var currentVal = sesJqueryObject(this).val();

      if(currentVal == oldValEmbed || !currentVal) {

          return; //check to prevent multiple simultaneous triggers

      }

      if(typeof newEmbedRequest != 'undefined')

        newEmbedRequest.cancel();

      newEmbedRequest= (new Request.HTML({

        'format': 'html',

        'url' : validationUrl,

        'data' : {

          'ajax' : true,

          'code' : currentVal,

          'type' : 'embedCode'

        },

        'onRequest' : function() {

          $('validation').style.display = "block";

          $('validation').innerHTML = checkingUrlMessage;

          $('upload-wrapper').style.display = "none";

        },

        'onSuccess' : function(responseTree, responseElements, responseHTML, responseJavaScript) {

          if( valid ) {

            $('upload-wrapper').style.display = "block";

            $('validation').style.display = "none";

            $('code').value = currentVal;

          } else {

            $('upload-wrapper').style.display = "none";

            current_code = currentVal;

            $('validation').innerHTML = validationErrorMessage;

          }

        }

      }));

      newEmbedRequest.send();

      oldValEmbed = currentVal;

      //action to be performed on textarea changed

    });

  });

<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupvideo_enable_location', 1)){ ?>

sesJqueryObject(document).ready(function(){

sesJqueryObject('#lat-wrapper').css('display' , 'none');

sesJqueryObject('#lng-wrapper').css('display' , 'none');

sesJqueryObject('#mapcanvas-element').attr('id','map-canvas');

sesJqueryObject('#map-canvas').css('height','200px');

sesJqueryObject('#map-canvas').css('width','500px');

sesJqueryObject('#ses_location-label').attr('id','ses_location_data_list');


sesJqueryObject('#ses_location_data_list').html("<?php echo isset($_POST['location']) ? $_POST['location'] : '' ; ?>");

sesJqueryObject('#ses_location-wrapper').css('display','none');

initializeSesGroupVideoMap();

});

<?php } ?>

</script>

<?php if (($this->current_count >= $this->quota) && !empty($this->quota)):?>

<div class="tip"> <span> <?php echo $this->translate('You have already uploaded the maximum number of videos allowed.');?> <?php echo $this->translate('If you would like to upload a new video, please <a href="%1$s">delete</a> an old one first.', $this->url(array('action' => 'manage'), 'sesgroupvideo_general'));?> </span> </div>

<br/>

<?php else:?>

	<div class="sesgroupvideo_video_form">

		<?php echo $this->form->render($this);?>

  </div>

<?php endif; ?>

<script type="application/javascript">

sesJqueryObject('#rotation-wrapper').hide();

sesJqueryObject('#embedUrl-wrapper').hide();

function enablePasswordFiled(value){

	if(value == 0){

		sesJqueryObject('#password-wrapper').hide();

	}else{

		sesJqueryObject('#password-wrapper').show();		

	}

}

sesJqueryObject('#password-wrapper').hide();	

</script>

<script type="text/javascript">	

	//prevent form submit on enter

	sesJqueryObject("#form-upload").bind("keypress", function (e) {		

    if (e.keyCode == 13 && sesJqueryObject('#'+e.target.id).prop('tagName') != 'TEXTAREA') {

			e.preventDefault();

    }else{

			return true;	

		}

});

//Ajax error show before form submit

var error = false;

var objectError ;

var counter = 0;

function validateForm(){

var errorPresent = false;

sesJqueryObject('#form-upload input, #form-upload select,#form-upload checkbox,#form-upload textarea,#form-upload radio').each(

	function(index){

			var input = sesJqueryObject(this);

			if(sesJqueryObject(this).closest('div').parent().css('display') != 'none' && sesJqueryObject(this).closest('div').parent().find('.form-label').find('label').first().hasClass('required') && sesJqueryObject(this).prop('type') != 'hidden' && sesJqueryObject(this).closest('div').parent().attr('class') != 'form-elements'){	

			  if(sesJqueryObject(this).prop('type') == 'checkbox'){

					value = '';

					if(sesJqueryObject('input[name="'+sesJqueryObject(this).attr('name')+'"]:checked').length > 0) { 

							value = 1;

					};

					if(value == '')

						error = true;

					else

						error = false;

				}else if(sesJqueryObject(this).prop('type') == 'select-multiple'){

					if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)

						error = true;

					else

						error = false;

				}else if(sesJqueryObject(this).prop('type') == 'select-one' || sesJqueryObject(this).prop('type') == 'select' ){

					if(sesJqueryObject(this).val() === '')

						error = true;

					else

						error = false;

				}else if(sesJqueryObject(this).prop('type') == 'radio'){

					if(sesJqueryObject("input[name='"+sesJqueryObject(this).attr('name').replace('[]','')+"']:checked").val() === '')

						error = true;

					else

						error = false;

				}else if(sesJqueryObject(this).prop('type') == 'textarea'){

					if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)

						error = true;

					else

						error = false;

				}else{

					if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)

						error = true;

					else

						error = false;

				}

				if(error){

				 if(counter == 0){

					objectError = this;

				 }

					counter++

				}else{

				}

				if(error)

					errorPresent = true;

				error = false;

			}

	}

	);

	return errorPresent ;

}

sesJqueryObject('#form-upload').submit(function(e){

	var validationFm = validateForm();

	if(validationFm)

	{

		alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');

		if(typeof objectError != 'undefined'){

		 var errorFirstObject = sesJqueryObject(objectError).parent().parent();

		 sesJqueryObject('html, body').animate({

			scrollTop: errorFirstObject.offset().top

		 }, 2000);

		}

		return false;	

	}else{

		sesJqueryObject('#upload').attr('disabled',true);

		sesJqueryObject('#upload').html('<?php echo $this->translate("Submitting Form ...") ; ?>');

		return true;

	}			

});

</script>

