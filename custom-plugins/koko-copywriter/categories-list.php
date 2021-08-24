<?php

require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

class Categories_List extends WP_List_Table {

    public function __construct() {

        parent::__construct( [
        'singular' => __( 'Kategorie', 'sp' ), //singular name of the listed records
        'plural' => __( 'Kategorie', 'sp' ), //plural name of the listed records
        'ajax' => false //should this table support ajax?
        
        ] );
        
        }

    function get_all_categories(){
        global $wpdb;

        $query = $wpdb->get_results("select * from wp_copywriter_categories");
    
        foreach ($query as $rows){
            echo $rows->name;
        }
    }

    function get_categories($per_page = 10, $page_number = 1)
    {
       global $wpdb;
       
       $query = "SELECT * FROM wp_copywriter_categories";
       
       if (! empty( $_REQUEST['orderby'])) 
       {
        $query .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
        $query .= ! empty ($_REQUEST['order']) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
       }

       $query .= " LIMIT $per_page ";
       $query .= 'OFFSET ' . ($page_number - 1) * $per_page;

        echo $query;

       //$result = $wpdb->get_results( $query, 'ARRAY_A' );
    }

        function delete_category($id){
        global $wpdb;

        $wpdb->delete(
            "wp_copywriter_categories",
            ['category_id' => $id],
            ['%d']
        );
    }

    function record_count() {
		global $wpdb;

		$query = "SELECT COUNT(*) FROM wp_copywriter_categories";

		return $wpdb->get_var( $query );
}


    function no_categories() {
    _e( 'Brak kategori', 'sp' );
}

public function column_default( $item, $column_name ) {
    switch ( $column_name ) {
        case 'category_id':
        case 'name':
            return $item[ $column_name ];
        default:
            return print_r( $item, true ); //Show the whole array for troubleshooting purposes
    }
}

function column_name( $item ) {

    $delete_nonce = wp_create_nonce( 'sp_delete_customer' );

    $title = '<strong>' . $item['name'] . '</strong>';

    $actions = [
        'delete' => sprintf( '<a href="?page=%s&action=%s&customer=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['ID'] ), $delete_nonce )
    ];

    return $title . $this->row_actions( $actions );
}

function get_columns() {
    $columns = [
        'cb'      => '<input type="checkbox" />',
        'category_id'    => __( 'ID', 'sp' ),
        'name' => __( 'Nazwa', 'sp' )
    ];

    return $columns;
}
}

    ?>