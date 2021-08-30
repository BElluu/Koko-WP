<?php

require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

class Categories_List extends WP_List_Table {

    // public function __construct() {

    //     parent::__construct( [
    //     'singular' => __( 'Kategorie', 'sp' ), //singular name of the listed records
    //     'plural' => __( 'Kategorie', 'sp' ), //plural name of the listed records
    //     'ajax' => false //should this table support ajax?
        
    //     ] );
        
        //}

    function get_all_categories(){
        global $wpdb;

        $query = $wpdb->get_results("select * from wp_copywriter_categories", ARRAY_A);
    
        // foreach ($query as $rows){
        //     echo $rows->name;
        // }

        return $query;
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
        return $query;

       //$result = $wpdb->get_results( $query, 'ARRAY_A' );
    }

    function prepare_items()
    {
        global $wpdb;
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->get_all_categories();
        usort( $data, array( &$this, 'sort_data' ) );

         $perPage = 5;
         $currentPage = $this->get_pagenum();
         $totalItems = count($data);

         $this->set_pagination_args( array(
             'total_items' => $totalItems,
             'per_page'    => $perPage
         ) );

         $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }

    // function delete_category($id){
    //     global $wpdb;

    //     $wpdb->delete(
    //         "wp_copywriter_categories",
    //         ['category_id' => $id],
    //         ['%d']
    //     );
    // }

    function record_count() {
		global $wpdb;

		$query = "SELECT COUNT(*) FROM wp_copywriter_categories";

		return $wpdb->get_var( $query );
}


    function no_categories() {
    _e( 'Brak kategori', 'sp' );
}

 function column_default( $item, $column_name ) {
    switch ( $column_name ) {
        //case 'category_id':
        case 'category_name':
            return $item[ $column_name ];
        default:
            return print_r( $item, true ); //Show the whole array for troubleshooting purposes
    }
}

 function column_name( $item ) {

    $delete_nonce = wp_create_nonce( 'sp_delete_category' );
    $title = '<strong>' . $item['category_name'] . '</strong>';


    $actions = [
        'edit' => sprintf('<a href="?page=%s&action=%s&id=%s">Edit</a>', $_REQUEST['page'], 'edit', $item['category_id']),
        'delete' => sprintf( '<a href="?page=%s&action=%s&category=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['category_id'] ), $delete_nonce )
    ];

        //  global $wpdb;

        // $wpdb->delete(
        //     "wp_copywriter_categories",
        //     ['category_id' => $item['category_id']],
        //     ['%d']
        // );

    return $title. $this->row_actions( $actions );
}

function column_cb( $item ) {
    return sprintf(
    '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['category_id']
    );
    }

function get_columns() {
    // $columns = [
    //     'cb'      => '<input type="checkbox" />',
    //     'ID' => __('column_id', 'sp'),
    //     'name' => __( 'Nazwa', 'sp' )
    // ];

    $columns = array(
        'cb'      => '<input type="checkbox" />',
        //'category_id' => 'ID',
        'name' => 'Nazwa'
    );

    return $columns;
}

function get_hidden_columns()
{
    return array();
}

function get_sortable_columns()
{
    return array('category_name' => array('category_name', false));
}

private function sort_data($a, $b)
{
    $orderby = 'category_name';
    $order = 'asc';

            // If orderby is set, use this as the sort column
            if(!empty($_GET['orderby']))
            {
                $orderby = $_GET['orderby'];
            }
    
            // If order is set use this as the order
            if(!empty($_GET['order']))
            {
                $order = $_GET['order'];
            }
    
    
            $result = strcmp( $a[$orderby], $b[$orderby] );
    
            if($order === 'asc')
            {
                return $result;
            }
    
            return -$result;
    }
}

    ?>