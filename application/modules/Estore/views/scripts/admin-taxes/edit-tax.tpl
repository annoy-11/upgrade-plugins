<div class="settings global_form_popup">
  <?php echo $this->form->render($this) ?>
  <script type="text/javascript">
    var maxRegions = 50;
    en4.core.runonce.add(function() {
      var html = '<a href="javascript: void(0);" id="addStatesBox"><?php echo $this->translate("Add More Regions") ?></a>';
      sesJqueryObject('#states-element').append(html);
       sesJqueryObject(document).on('click','#addStatesBox',function () {
        var inputHtml = "<div class='input-estore-elem'><input type='text' name='states[]'><a href='javascript:;' class='remove-elem'>Close</a></div>";
        sesJqueryObject(inputHtml).insertBefore('#addStatesBox');
        if (maxRegions && sesJqueryObject('.input-estore-elem').length >= maxRegions) {
          sesJqueryObject('#addStatesBox').hide();
        }
       });
    });
  </script>
</div>
<script type="text/javascript">
  sesJqueryObject(document).on('click','.remove-elem',function () {
      sesJqueryObject(this).parent().remove();
      if (maxRegions && sesJqueryObject('.input-estore-elem').length < maxRegions) {
          sesJqueryObject('#addStatesBox').show();
      }
  });
</script>

<?php if (@$this->closeSmoothbox): ?>
  <script type="text/javascript">
    TB_close();
  </script>
<?php endif; ?>