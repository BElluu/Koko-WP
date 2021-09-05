<?php

Class Edit_Category_Form {   

    function getCategory($id){
        global $wpdb;
        $table = 'wp_copywriter_categories';
        $query = 'select * from ' . $table . " where category_id = " . $id;
        return $wpdb->get_row($query);
    }

    function editCategory(){
        $category = $this->getCategory($_GET['id']);
?>

<div class="wrap">
            <h1><?php _e( 'Edytuj kategorię', '' ); ?></h1>
        
            <form action="" method="post" enctype="multipart/form-data">
        
                <table class="form-table">
                    <tbody>
                        <tr class="row-Title">
                            <th scope="row">
                                <label for="categoryName"><?php _e( 'Nazwa', '' ); ?></label>
                            </th>
                            <td>
                                <input type="text" name="categoryName" id="categoryName" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="<?php echo ($category->category_name);?>" required="required" />
                            </td>
                        </tr>

                        <tr class="form-field image">
                        <th scope="row">
                            <label for="categoryImage"><?php _e( 'Zdjęcie', '' ); ?></label>
                        </th>
                            <td>
                                <input type="file" name="categoryImage" id="categoryImage" accept="image/*" />
                                <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($category->category_image).'" width:"200" alt="test" title="image" />'; ?>
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
            $table = 'wp_copywriter_categories';
            $where = ['category_id' => $_GET['id']];
            $imageFile = $_FILES['categoryImage'];
            if($imageFile['error'] == 0)
            {
            $data = array(
                'category_name' => $_POST['categoryName'],
                'category_image' => file_get_contents($imageFile['tmp_name'])
            );
        }else{
            $data = array(
                'category_name' => $_POST['categoryName']
            );
            }
            $success=$wpdb->update( $table, $data, $where);

            //TODO redirect wp_safe_redirect('admin.php?page=Kategorie');
        } 
    }
}
?>