<?php
get_header();
?>
<section class="categoryList">
<?php
global $wpdb;
$categories = $wpdb->get_results("select * from wp_copywriter_categories");
foreach($categories as $row)
{
?>
<?php echo '<a href="http://localhost/wordpress/'.($row-> category_name).'"/>'; ?>
<?php echo '<img class=categoryImage style="height:190px;width:290px;" src="data:image/jpeg;base64,'.base64_encode($row->category_image).'"/>'; ?>
<?php  echo '<p class=categoryName>'.($row-> category_name).'</p>'?>
</a>


<?php
}
?>
</section>

<?php
get_footer();
?>