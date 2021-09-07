<?php
get_header();
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<section class="categoryList">
<?php
global $wpdb;
$categories = $wpdb->get_results("select * from wp_copywriter_categories");
foreach($categories as $row)
{
?>
<?php echo '<a class="categoryID" target="'.($row-> category_id).'" />'; ?>
<?php echo '<img class=categoryImage style="height:190px;width:290px;" src="data:image/jpeg;base64,'.base64_encode($row->category_image).'"/>'; ?>
<?php  echo '<p class=categoryName>'.($row-> category_name).'</p>'?>
</a>
<?php
}
?>

<section class="cnt">
<div id="div1" class="targetDiv">Content   1</div>
<div id="div2" class="targetDiv">Content   2</div>
<div id="div3" class="targetDiv">Content   3</div>
<div id="div4" class="targetDiv">Content   4</div>
<script>
jQuery(function(){
        jQuery('.categoryID').click(function(){
              jQuery('.targetDiv').hide();
              jQuery('.categoryID').hide();
        jQuery('#div'+$(this).attr('target')).show();
        });
});
</script>
</section>

</section>

<?php
get_footer();
?>