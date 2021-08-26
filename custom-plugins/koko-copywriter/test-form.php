<?php

class Test_Form{

function abc(){
    ?>
<div class="wrap">
    <h1><?php _e( 'Artykuł', '' ); ?></h1>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-Title">
                    <th scope="row">
                        <label for="Title"><?php _e( 'Tytuł', '' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Title" id="Title" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="" required="required" />
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field( '' ); ?>
        <?php submit_button( __( 'Dodaj Artykuł', '' ), 'primary', 'Zatwierdź' ); ?>

    </form>
</div>
<?php
}

function xyz(){
    ?>
    <div class="wrap">
    <h1><?php _e( 'Artykuł', '' ); ?></h1>



    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-Title">
                    <th scope="row">
                        <label for="Title"><?php _e( 'Tytuł', '' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Title" id="Title" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="<?php echo esc_attr( $item->Title ); ?>" required="required" />
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="<?php echo $item->id; ?>">

        <?php wp_nonce_field( '' ); ?>
        <?php submit_button( __( 'Edytuj Artykuł', '' ), 'primary', 'Zatwierdź' ); ?>

    </form>
</div>
<?php
}
}
?>