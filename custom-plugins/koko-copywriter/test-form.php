<?php
ob_start();
Class Add_Category_Form2 {   

    function test(){
?>

<div class="wrap">
            <h1><?php _e( 'Dodaj kategorię', '' ); ?></h1>
        
            <form action="" method="post">
        
                <table class="form-table">
                    <tbody>
                        <tr class="row-Title">
                            <th scope="row">
                                <label for="categoryName"><?php _e( 'Nazwa', '' ); ?></label>
                            </th>
                            <td>
                                <input type="text" name="categoryName" id="categoryName" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="" required="required" />
                            </td>
                        </tr>

                        <tr class="form-field image">
                        <th scope="row">
                            <label for="categoryImage"><?php _e( 'Zdjęcie', '' ); ?></label>
                        </th>
                            <td>
                                <input type="file" name="categoryImage" id="categoryImage" required="required" accept="image/*" />
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
            $data = array(
                'name' => $_POST['categoryName'],
                'image' => $_POST['categoryImage']
            );
            $format = array(
                '%s'
            );
            $success=$wpdb->insert( $table, $data, $format);

            //$redirectLocation = esc_url( admin_url( 'admin.php?page=dodaj-kategorie'));
            $redirectLocation = 'https://google.pl';
            wp_safe_redirect( $redirectLocation );
            exit;
            }
        } 

    }
    ob_end_flush(); 
    ?>