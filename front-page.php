<?php
get_header();
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>

$(document).ready(function(){
    jQuery('.article').hide();
});

jQuery(function(){
        jQuery('.category').click(function(){
              jQuery('.category').hide();
        var $categoryId = $(this).attr('target');
        jQuery($(".article[target='" + $categoryId + "']")).show();
        });
});
</script>
<section class="categoryList">
<?php
global $wpdb;
$categories = $wpdb->get_results("select * from wp_copywriter_categories");
foreach($categories as $row)
{
?>
<?php echo '<a class="category" target="'.($row-> category_id).'" />'; ?>
<?php echo '<img class=categoryImage style="height:190px;width:290px;" src="data:image/jpeg;base64,'.base64_encode($row->category_image).'"/>'; ?>
<?php  echo '<p class=categoryName>'.($row-> category_name).'</p>'?>
</a>
<?php
}

$articles = $wpdb->get_results("select * from wp_copywriter_articles");
foreach($articles as $row)
{
?>
<?php echo '<a href="'.($row->article_source).'" class="article" target="'.($row-> category_id).'" />'; ?>
<?php echo '<img class=articleImage style="height:190px;width:290px;" src="data:image/jpeg;base64,'.base64_encode($row->article_image).'"/>'; ?>
<?php  echo '<p class=articleName>'.($row-> article_name).'</p>'?>
</a>
<?php
}
?>
</section>

<?php
get_footer();
?>