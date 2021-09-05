<?php

require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

class Articles_List extends WP_List_Table {

    public function __construct() {
		// Set parent defaults.
		parent::__construct( array(
			'singular' => 'article',     // Singular name of the listed records.
			'plural'   => 'articles',    // Plural name of the listed records.
			'ajax'     => false,       // Does this table support ajax?
		) );
	}

    function get_all_articles(){
        global $wpdb;
        $query = $wpdb->get_results("select * from wp_copywriter_articles as articles join wp_copywriter_categories as categories on categories.category_id = articles.category_id", ARRAY_A);
        return $query;
    }

    function prepare_items()
    {
        global $wpdb;
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->get_all_articles();
        usort( $data, array( $this, 'sort_data' ) );

         $perPage = 10;
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

		$query = "SELECT COUNT(*) FROM wp_copywriter_articles";

		return $wpdb->get_var( $query );
}


    function no_articles() {
    _e( 'Brak artykułów', 'sp' );
}

 function column_default( $item, $column_name ) {
    switch ( $column_name ) {
        case 'article_id':
        case 'article_name':
        case 'article_source':
        case 'category_name':
            return $item[ $column_name ];
        default:
            return print_r( $item, true );
    }
}

 function column_name( $item ) {
    $delete_nonce = wp_create_nonce( 'delete_article' );
    $title = '<strong>' . $item['article_name'] . '</strong>';
    $actions = [
        'edit' => sprintf('<a href="?page=%s&id=%s">Edit</a>', 'edytuj-artykul', $item['article_id']),
        'delete' => sprintf('<a href="admin.php?action=%s&article_id=%s&_wpnonce=%s">Delete</a>' ,'delete_article', absint($item['article_id']), $delete_nonce)
    ];
    return $title. $this->row_actions( $actions );
}

function column_cb( $item ) {
    return sprintf(
    '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['article_id']
    );
    }

function get_columns() {
    $columns = array(
        'cb'      => '<input type="checkbox" />',
        'name' => 'Nazwa',
        'article_source' => 'Źródło',
        'category_name' => 'Kategoria',
    );
    return $columns;
}

function get_hidden_columns()
{
    return array();
}

function get_sortable_columns()
{
    return array(
        'name' => array('article_name', false),
        'article_source' => array('article_source', false),
        'category_name' => array('category_name', false)
    );
}

private function sort_data($a, $b)
{
    $orderby = 'article_name';
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