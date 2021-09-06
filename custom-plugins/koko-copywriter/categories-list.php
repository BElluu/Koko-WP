<?php

if (! function_exists('add_action')){
    echo 'Hi! I\'m a plugin. Do not call me directly.';
    exit;
}

require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

class Categories_List extends WP_List_Table {

    function get_all_categories(){
        global $wpdb;
        $query = $wpdb->get_results("select * from wp_copywriter_categories", ARRAY_A);
        return $query;
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
        case 'category_name':
            return $item[ $column_name ];
        default:
            return print_r( $item, true );
    }
}

 function column_name( $item ) {

    $delete_nonce = wp_create_nonce( 'delete_category' );
    $title = '<strong>' . $item['category_name'] . '</strong>';
    $actions = [
        'edit' => sprintf('<a href="?page=%s&id=%s">Edit</a>', 'edytuj-kategorie', $item['category_id']),
        'delete' => sprintf('<a href="admin.php?action=%s&category_id=%s&_wpnonce=%s">Delete</a>' ,'delete_category', absint($item['category_id']), $delete_nonce)
    ];
    return $title. $this->row_actions( $actions );
}

function column_cb( $item ) {
    return sprintf(
    '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['category_id']
    );
    }

function get_columns() {
    $columns = array(
        'cb'      => '<input type="checkbox" />',
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