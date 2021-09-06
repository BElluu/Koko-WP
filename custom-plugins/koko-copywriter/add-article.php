<?php

if (! function_exists('add_action')){
    echo 'Hi! I\'m a plugin. Do not call me directly.';
    exit;
}

Class Add_Article_Form {   

    function addArticle(){
?>

<div class="wrap">
            <h1><?php _e( 'Dodaj artykuł', '' ); ?></h1>
        
            <form action="" method="post" enctype="multipart/form-data">
        
                <table class="form-table">
                    <tbody>
                        <tr class="row-Title">
                            <th scope="row">
                                <label for="articleName"><?php _e( 'Nazwa', '' ); ?></label>
                            </th>
                            <td>
                                <input type="text" name="articleName" id="articleName" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="" required="required" />
                            </td>
                        </tr>

                        <tr class="row-Title">
                            <th scope="row">
                                <label for="sourceLink"><?php _e( 'Źródło', '' ); ?></label>
                            </th>
                            <td>
                                <input type="text" name="sourceLink" id="sourceLink" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="" required="required" />
                            </td>
                        </tr>

                        <tr class="row-Title">
                            <th scope="row">
                                <label for="category"><?php _e( 'Kategoria', '' ); ?></label>
                            </th>
                            <td>
                                <select name='category' id='category' class="select-select2" required="required">
                                    <option value=""> Wybierz Kategorie </option>
                                    <?php
                                    global $wpdb;
                                    $categories = $wpdb->get_results("select * from wp_copywriter_categories");
                                    foreach($categories as $row)
                                    {
                                        $category_id = $row->category_id;
                                        $category_name = $row->category_name;
                                        echo '<option value = ' .$category_id. '>'. $category_name. '</option>';
                                    }
                                    ?>
                                    </select>
                            </td>
                        </tr>

                        <tr class="form-field image">
                        <th scope="row">
                            <label for="articleImage"><?php _e( 'Zdjęcie', '' ); ?></label>
                        </th>
                            <td>
                                <input type="file" name="articleImage" id="articleImage" required="required" accept="image/*" />
                            </td>
                        </tr>
                     </tbody>
                </table>
        
                <input type="hidden" name="field_id" value="0">
        
                <?php wp_nonce_field( '' ); ?>
                <?php submit_button( __( 'Zatwierdź', '' ), 'primary', 'Submit' ); ?>

<?php

        if (!empty ($_POST)){
            global $wpdb;
            $imageFile = $_FILES['articleImage'];
            $table = 'wp_copywriter_articles';
            $data = array(
                'article_name' => $_POST['articleName'],
                'article_source' => $_POST['sourceLink'],
                'category_id' => $_POST['category'],
                'article_image' => file_get_contents($imageFile['tmp_name'])
            );
            
            $success=$wpdb->insert( $table, $data);
            wp_safe_redirect('admin.php?page=Artykuly');
            }
        } 
    }
    ?>