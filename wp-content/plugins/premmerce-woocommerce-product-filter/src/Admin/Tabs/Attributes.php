<?php

namespace Premmerce\Filter\Admin\Tabs;

use  Premmerce\Filter\Admin\Tabs\Base\SortableListTab ;
use  Premmerce\Filter\Filter\Filter ;
use  Premmerce\Filter\FilterPlugin ;
use  Premmerce\SDK\V2\FileManager\FileManager ;
class Attributes extends SortableListTab
{
    /**
     * @var FileManager
     */
    private  $fileManager ;
    /**
     * @var array
     */
    private  $defaultAttribute = array(
        'active'       => false,
        'type'         => 'checkbox',
        'display_type' => '',
    ) ;
    /**
     * Attributes constructor.
     *
     * @param FileManager $fileManager
     */
    public function __construct( FileManager $fileManager )
    {
        parent::__construct();
        $this->fileManager = $fileManager;
        $this->bulkActions = apply_filters( 'premmerce_filter_bulk_actions_attributes', $this->bulkActions );
    }
    
    /**
     * Register action handlers
     */
    public function init()
    {
        add_action( 'wp_ajax_premmerce_filter_bulk_action_attributes', [ $this, 'bulkActionAttributes' ] );
        add_action( 'wp_ajax_premmerce_filter_sort_attributes', [ $this, 'sortAttributes' ] );
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'attributes';
    }
    
    /**
     * @return string
     */
    public function getLabel()
    {
        return __( 'Attributes', 'premmerce-filter' );
    }
    
    /**
     * @return bool
     */
    public function valid()
    {
        return function_exists( 'wc_get_attribute_taxonomies' );
    }
    
    public function swapItems( $swap, $actual )
    {
        $actualKeys = array_keys( $actual );
        $place = $swap[0];
        $target = $swap[1];
        $placePos = array_search( $place, $actualKeys );
        $targetPos = array_search( $target, $actualKeys );
        
        if ( $placePos < $targetPos ) {
            //        if place is before move target before place
            $items = [
                $target => $actual[$target],
                $place  => $actual[$place],
            ];
        } else {
            //        if place is after move target after place
            $items = [
                $place  => $actual[$place],
                $target => $actual[$target],
            ];
        }
        
        unset( $actual[$swap[1]] );
        $before = array_slice(
            $actual,
            0,
            $placePos,
            true
        );
        $after = array_slice(
            $actual,
            $placePos,
            null,
            true
        );
        return $before + $items + $after;
    }
    
    public function sortItems( $ids, $actual )
    {
        $actualKeys = array_keys( $actual );
        $prevKeyPosition = 0;
        $before = [];
        $after = [];
        
        if ( !empty($_POST['prev']) ) {
            $prev = $_POST['prev'];
            $prevKeyPosition = array_search( $prev, $actualKeys );
            $before = array_slice(
                $actual,
                0,
                ( $prevKeyPosition ? $prevKeyPosition + 1 : 0 ),
                true
            );
        }
        
        
        if ( !empty($_POST['next']) ) {
            $next = $_POST['next'];
            $nextKeyPosition = array_search( $next, $actualKeys );
            $after = array_slice(
                $actual,
                $nextKeyPosition,
                null,
                true
            );
        }
        
        $sorted = array_slice(
            $actual,
            ( $prevKeyPosition ? $prevKeyPosition + 1 : 0 ),
            count( $ids ),
            true
        );
        $ids = array_combine( $ids, $ids );
        $sorted = array_replace( $ids, $sorted );
        return $before + $sorted + $after;
    }
    
    /**
     * Ajax update attributes ordering
     */
    public function sortAttributes()
    {
        $actual = $this->getAttributesConfig();
        $items = [];
        
        if ( !empty($_POST['swap']) ) {
            $swap = explode( ',', $_POST['swap'] );
            $swap = array_filter( $swap );
            if ( count( $swap ) === 2 ) {
                $items = $this->swapItems( $swap, $actual );
            }
        } elseif ( !empty($_POST['ids']) ) {
            $ids = $_POST['ids'];
            if ( is_array( $ids ) ) {
                $items = $this->sortItems( $_POST['ids'], $actual );
            }
        }
        
        if ( count( $items ) === count( $actual ) ) {
            update_option( FilterPlugin::OPTION_ATTRIBUTES, $items );
        }
        wp_die();
    }
    
    /**
     * Ajax bulk update attributes
     */
    public function bulkActionAttributes()
    {
        $this->bulkActionsHandler( FilterPlugin::OPTION_ATTRIBUTES, $this->getAttributesConfig() );
    }
    
    public function render()
    {
        $attributesConfig = $this->getAttributesConfig();
        $attributes = array_replace( $attributesConfig, $this->getAttributes() );
        $screen_option = get_current_screen()->get_option( 'per_page', 'option' );
        $itemsPerPage = get_user_meta( get_current_user_id(), $screen_option, true );
        if ( !$itemsPerPage ) {
            $itemsPerPage = 100;
        }
        $page = ( isset( $_GET['p'] ) ? $_GET['p'] : 1 );
        $offset = ($page - 1) * $itemsPerPage;
        $total = ceil( count( $attributes ) / $itemsPerPage );
        $keys = array_keys( $attributes );
        $prevId = ( isset( $keys[$offset - 1] ) ? $keys[$offset - 1] : null );
        $nextId = ( isset( $keys[$offset + $itemsPerPage] ) ? $keys[$offset + $itemsPerPage] : null );
        $attributes = array_slice(
            $attributes,
            $offset,
            $itemsPerPage,
            true
        );
        $paginationArgs = [
            'format'             => '?p=%#%',
            'total'              => $total,
            'current'            => $page,
            'aria_current'       => 'page',
            'show_all'           => false,
            'prev_next'          => true,
            'prev_text'          => '&larr;',
            'next_text'          => '&rarr;',
            'end_size'           => 1,
            'mid_size'           => 10,
            'add_args'           => array(),
            'add_fragment'       => '',
            'before_page_number' => '',
            'after_page_number'  => '',
        ];
        $visibility = [
            "display" => __( 'Display', 'premmerce-filter' ),
            "hide"    => __( 'Hide', 'premmerce-filter' ),
        ];
        $types = [
            'checkbox' => __( 'Checkbox', 'premmerce-filter' ),
            'radio'    => __( 'Radio', 'premmerce-filter' ),
            'select'   => __( 'Select', 'premmerce-filter' ),
        ];
        $types = apply_filters( 'premmerce_filter_item_types', $types );
        $display = [
            'display_'                => __( 'Default', 'premmerce-filter' ),
            'display_dropdown'        => __( 'Dropdown', 'premmerce-filter' ),
            'display_scroll'          => __( 'Scroll', 'premmerce-filter' ),
            'display_scroll_dropdown' => __( 'Scroll + Dropdown', 'premmerce-filter' ),
        ];
        $actions = [
            "-1"                                   => __( 'Bulk Actions', 'premmerce-filter' ),
            __( 'Visibility', 'premmerce-filter' ) => $visibility,
            __( 'Field type', 'premmerce-filter' ) => $types,
            __( 'Display as', 'premmerce-filter' ) => $display,
        ];
        $actions = apply_filters( 'premmerce_filter_item_actions', $actions );
        $dataAction = 'premmerce_filter_bulk_action_attributes';
        $this->fileManager->includeTemplate( 'admin/tabs/attributes.php', compact(
            'attributes',
            'attributesConfig',
            'types',
            'actions',
            'dataAction',
            'display',
            'paginationArgs',
            'prevId',
            'nextId'
        ) );
    }
    
    /**
     * @param $id
     *
     * @return mixed
     */
    private function getTaxonomyById( $id )
    {
        if ( $attribute = wc_get_attribute( $id ) ) {
            return $attribute->slug;
        }
        return $id;
    }
    
    /**
     * Get attributes configuration
     *
     * @return mixed
     */
    private function getAttributesConfig()
    {
        return $this->getConfig( FilterPlugin::OPTION_ATTRIBUTES, $this->getAttributes(), $this->defaultAttribute );
    }
    
    /**
     * Woocommerce attributes id=>title array and custom taxonomies if exist
     *
     * @return array
     */
    private function getAttributes()
    {
        $wcAttributes = wc_get_attribute_taxonomies();
        $attributes = [];
        foreach ( $wcAttributes as $attribute ) {
            $attributes[$attribute->attribute_id] = $attribute->attribute_label;
        }
        foreach ( Filter::$taxonomies as $taxonomy ) {
            
            if ( taxonomy_exists( $taxonomy ) ) {
                $taxonomy = get_taxonomy( $taxonomy );
                $attributes[$taxonomy->name] = $taxonomy->labels->menu_name;
            }
        
        }
        return $attributes;
    }

}