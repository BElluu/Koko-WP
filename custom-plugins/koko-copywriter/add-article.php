<?php

Class Add_Article_Form {   

    function addArticle(){
?>

<div class="wrap">
            <h1><?php _e( 'Dodaj artykuł', '' ); ?></h1>
        
            <form action="" method="post">
        
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
                                <select name='category' id='category' class="select-select2">
                                    <option value=""> Wybierz Kategorie </option>
                                    <?php
                                    global $wpdb;
                                    $categories = $wpdb->get_results("select name from wp_copywriter_categories");
                                    foreach($categories as $row)
                                    {
                                        $category_id = $row->category_id;
                                        $name = $row->name;
                                        echo '<option value = ' .$category_id. '>'. $name. '</option>';
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
            $table = 'wp_copywriter_articles';
            $data = array(
                'name' => $_POST['articleName'],
                'source' => $_POST['sourceLink'],
                'category_id' => $_POST['category'],
                'image' => $_POST['articleImage']
            );
            $format = array(
                '%s'
            );
            $success=$wpdb->insert( $table, $data, $format);

            if(!$success){
                echo $success;
            }

            // $location = esc_url( admin_url( 'admin.php?page=dodaj-kategorie'));
            // wp_safe_redirect( $location );
            //TODO REDIRECT TO LIST
            
            }
        } 

        function getCategories(){
            global $wpdb;
            $categories =$wpdb->get_results("select name from wp_copywriter_categories");
            return $categories;
        }
    }
    ?>