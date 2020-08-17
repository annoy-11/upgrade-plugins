<?php

?>
<script>
function editIntro() {
  $('intro_edit').style.display = 'none';
  if($('introduce_content'))
  document.getElementById('introduce_content').style.display = 'none';
  if($('content_textarea'))
  document.getElementById('content_textarea').style.display = 'block';
  if($('contenttextarea'))
  $('contenttextarea').focus();
}

function saveIntro(introduce_id) {

  var description = document.getElementById('contenttextarea').value;
  
  en4.core.request.send(new Request.HTML({
    url : en4.core.baseUrl + 'sesinviter/index/saveintro',
    data : {
      format : 'html',
      description : description,
      introduce_id: introduce_id,
    },
    onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript) {

      var response = sesJqueryObject.parseJSON( responseHTML );
      if(response.status == 1) {
        var savedcontent = description.replace(/\n/g,'<br />');
        var innerHTML = '<div id="introduce_content">'+savedcontent+'</div><div id="content_textarea" style="display:none;"><textarea id="contenttextarea" onblur="saveIntro('+response.introduce_id+')" style="display:block;" rows="5" cols="12">'+savedcontent+'</textarea></div><a id="intro_edit" href="javascript:void(0);" onclick="editIntro();">Edit</a>';
        $('maincontent').innerHTML = innerHTML;
      }
    }
  }));
}
</script>

<?php echo $this->viewer()->getTitle(); ?>
<div>
  <?php echo $this->htmlLink($this->viewer()->getHref(), $this->itemPhoto($this->viewer(), 'thumb.icon')) ?>
</div>

<?php if($this->viewer_id) { ?>
  <div id="maincontent">
    <?php if($this->result->description) { ?>
      <div id="introduce_content">
        <?php echo nl2br($this->result->description); ?>
      </div>
    <?php } ?>
    <div id="content_textarea" style="display:none;">
      <textarea id="contenttextarea" onblur="saveIntro('<?php echo $this->result->introduce_id; ?>')" style='display:block;' rows="5" cols="12"><?php echo $this->result->description; ?></textarea>
    </div>
    <a id="intro_edit" href="javascript:void(0);" onclick="editIntro();"><?php if(!$this->result->description) { ?><?php echo $this->translate("Start"); ?><?php } else { ?><?php echo $this->translate("Edit"); ?><?php } ?></a>
  </div>
<?php } ?>
