<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesminify
 * @package    Sesminify
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: gzip.tpl  2017-10-09 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Sesminify/views/scripts/dismiss_message.tpl';
      $this->headScript()->prependFile($this->layout()->staticBaseUrl . 'externals/ses-scripts/sesJquery.js');
?>

<h3>Guidelines for GZIP Compression</h3>
<p>
  <?php $staticURL = $this->staticURL ? rtrim($this->staticURL,'/') : ''; ?>
  To enable the GZIP Compression on your website, write the below code in the .htaccess file which is available at path <?php echo $_SERVER['DOCUMENT_ROOT'].$staticURL.'/.htaccess'; ?>
</p>
<div class="sesminfy_codebox">
  <span id="textcopiedsuccess" class="sesminfy_copied_tip" style="display:none;">Text copied successfully.</span>
  <textarea style="height:520px;">
    <IfModule mod_deflate.c>
      # Compress HTML, CSS, JavaScript, Text, XML and fonts
      AddOutputFilterByType DEFLATE application/javascript
      AddOutputFilterByType DEFLATE application/rss+xml
      AddOutputFilterByType DEFLATE application/vnd.ms-fontobject
      AddOutputFilterByType DEFLATE application/x-font
      AddOutputFilterByType DEFLATE application/x-font-opentype
      AddOutputFilterByType DEFLATE application/x-font-otf
      AddOutputFilterByType DEFLATE application/x-font-truetype
      AddOutputFilterByType DEFLATE application/x-font-ttf
      AddOutputFilterByType DEFLATE application/x-javascript
      AddOutputFilterByType DEFLATE application/xhtml+xml
      AddOutputFilterByType DEFLATE application/xml
      AddOutputFilterByType DEFLATE font/opentype
      AddOutputFilterByType DEFLATE font/otf
      AddOutputFilterByType DEFLATE font/ttf
      AddOutputFilterByType DEFLATE image/svg+xml
      AddOutputFilterByType DEFLATE image/x-icon
      AddOutputFilterByType DEFLATE text/css
      AddOutputFilterByType DEFLATE text/html
      AddOutputFilterByType DEFLATE text/javascript
      AddOutputFilterByType DEFLATE text/plain
      AddOutputFilterByType DEFLATE text/xml
    
      # Remove browser bugs (only needed for really old browsers)
      BrowserMatch ^Mozilla/4 gzip-only-text/html
      BrowserMatch ^Mozilla/4\.0[678] no-gzip
      BrowserMatch \bMSIE !no-gzip !gzip-only-text/html
      Header append Vary User-Agent
    </IfModule>
  </textarea>
</div>
<script type="application/javascript">
  sesJqueryObject("textarea").focus(function(e){
    sesJqueryObject("textarea").select();
    document.execCommand('copy');
    sesJqueryObject('#textcopiedsuccess').show();
    sesJqueryObject("#textcopiedsuccess").fadeOut(3000);
  });
</script>