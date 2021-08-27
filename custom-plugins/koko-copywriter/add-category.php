<?php

Class Add_Category_Form {

    function display()
    {
        ?>
        <div class="wrap">
            <h1><?php _e( 'Dodaj kategorię', '' ); ?></h1>
        
            <form action="" method="post">
        
                <table class="form-table">
                    <tbody>
                        <tr class="row-Title">
                            <th scope="row">
                                <label for="Name"><?php _e( 'Nazwa', '' ); ?></label>
                            </th>
                            <td>
                                <input type="text" name="Title" id="Title" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="" required="required" />
                            </td>
                        </tr>
                     </tbody>
                </table>
        
                <input type="hidden" name="field_id" value="0">
        
                <?php wp_nonce_field( '' ); ?>
                <?php submit_button( __( 'Zatwierdź', '' ), 'primary', 'Zatwierdź' ); ?>
        
            </form>
        </div>
        <?php
        }
    }

    ?>