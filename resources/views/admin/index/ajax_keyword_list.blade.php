<?php foreach ($data as $key1 => $value1) {  ?>
    <hr style="margin:5px;">
    <?php echo $value1->keyword; ?>&nbsp; &nbsp;<a href="javascript:;" class="add_parent_keyword_link" id_keyword_parent="<?php echo $value1->id; ?>">add</a>
<?php } ?>
