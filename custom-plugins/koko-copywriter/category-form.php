<?php

//require_once __DIR__ . '\categories-list.php';
class Category_Form{
function test(){

   // $Categories_List = new Categories_List();
?>

<table class="form-table" role="presentation">
	<tr class="form-field form-required">
		<th scope="row"><label for="article_title"><?php _e( 'Tytuł' ); ?> <span class="description"><?php _e( '(required)' ); ?></span></label></th>
		<td><input name="article_title" type="text" id="article_title" value="" /></td>
	</tr>
	<tr class="form-field form-required">
		<th scope="row"><label for="source_article"><?php _e( 'Źródło' ); ?> <span class="description"><?php _e( '(required)' ); ?></span></label></th>
		<td><input name="source_article" type="url" id="source_article" value="" /></td>
	</tr>

    <tr class="form-field image">
        <th scope="row"><label for="image_article"><?php _e( 'Zdjęcie'); ?> </label> </th>
    </tr>

		<?php
				// $categories = $Categories_List->get_all_categories();
                // foreach($categories as $category)
                // {
                //     $name = $category->name;
                // }

			?>
		<tr class="form-field wrap">
			<th scope="row">
				<label for="category">
					<?php _e( 'Kategoria' ); ?>
				</label>
			</th>
			<td>
            <p>
<select>
  <option value=""></option>
  <option value="1">Zdrowie</option>
  <option value="2">Parenting</option>
</select>
</p>
			</td>
		</tr>


	
</table>
<?php submit_button( __( 'Dodaj nowy artykuł' ), 'primary', 'addarticle', true, array( 'id' => 'addarticlesub' ) ); ?>
<!-- <div id="container">
    <form method="post" name="CategoryForm">
        Tytuł <input type="text"  name="title" />
        Źródło  <input type="text" name="source" />
        Zdjęcie  <input type="image"  name="image" />
        <input type="submit" value="Zatwierdź" />
    </form>
</div> -->
<?php
}
}
?>