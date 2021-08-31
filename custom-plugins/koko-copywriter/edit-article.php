<?php

Class Edit_Article_Form {   

    function getArticle($id){
        global $wpdb;
        $table = 'wp_copywriter_articles';
        $query = 'select * from ' . $table . " where article_id = " . $id;
        return $wpdb->get_row($query);
    }

    function editArticle(){
        $article = $this->getArticle($_GET['id']);
        $article_image = $article->article_name;
?>

<div class="wrap">
            <h1><?php _e( 'Edytuj artykuł', '' ); ?></h1>
        
            <form action="" method="post">
        
                <table class="form-table">
                    <tbody>
                        <tr class="row-Title">
                            <th scope="row">
                                <label for="articleName"><?php _e( 'Nazwa', '' ); ?></label>
                            </th>
                            <td>
                                <input type="text" name="articleName" id="articleName" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="<?php echo ($article->article_name);?>" required="required" />
                            </td>
                        </tr>

                        <tr class="row-Title">
                            <th scope="row">
                                <label for="sourceLink"><?php _e( 'Źródło', '' ); ?></label>
                            </th>
                            <td>
                                <input type="text" name="sourceLink" id="sourceLink" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="<?php echo ($article->article_source);?>" required="required" />
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
                                <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($article->article_name).'" width:"200" alt="test" title="image" />'; ?>
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
                'article_name' => $_POST['articleName'],
                'article_source' => $_POST['sourceLink'],
                'category_id' => $_POST['category'],
                'article_image' => $_POST['articleImage']
            );
            $format = array(
                '%s'
            );
            $where = ['article_id' => $_GET['id']];
            $success=$wpdb->update( $table, $data, $where);
            
            }
        } 
    }
    ?>