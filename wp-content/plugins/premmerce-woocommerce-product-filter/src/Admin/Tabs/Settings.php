<?php

namespace Premmerce\Filter\Admin\Tabs;

use  Premmerce\Filter\Admin\Tabs\Base\BaseSettings ;
use  Premmerce\Filter\FilterPlugin ;
class Settings extends BaseSettings
{
    /**
     * @var string
     */
    protected  $page = 'premmerce-filter-admin-settings' ;
    /**
     * @var string
     */
    protected  $group = 'premmerce_filter' ;
    /**
     * @var string
     */
    protected  $optionName = 'premmerce_filter_settings' ;
    /**
     * Register hooks
     */
    public function init()
    {
        add_action( 'admin_init', [ $this, 'initSettings' ] );
    }
    
    /**
     * Init settings
     */
    public function initSettings()
    {
        register_setting( $this->group, $this->optionName );
        $taxonomies = FilterPlugin::DEFAULT_TAXONOMIES;
        $taxonomyOptions = [];
        foreach ( $taxonomies as $taxonomy ) {
            if ( !taxonomy_is_product_attribute( $taxonomy ) && taxonomy_exists( $taxonomy ) ) {
                $taxonomyOptions[$taxonomy] = get_taxonomy( $taxonomy )->labels->singular_name;
            }
        }
        $settings = [
            'behavior'      => [
            'label'  => __( 'Behavior', 'premmerce-filter' ),
            'fields' => [
            'hide_empty'                => [
            'type'  => 'checkbox',
            'label' => __( 'Hide empty terms', 'premmerce-filter' ),
        ],
            'show_price_filter'         => [
            'type'  => 'checkbox',
            'label' => __( 'Show price filter', 'premmerce-filter' ),
        ],
            'show_reset_filter'         => [
            'type'  => 'checkbox',
            'label' => sprintf( __( 'Show "%s" button', 'premmerce-filter' ), __( 'Reset filter', 'premmerce-filter' ) ),
        ],
            'enable_category_hierarchy' => [
            'type'  => 'checkbox',
            'label' => __( 'Enable category hierarchy', 'premmerce-filter' ),
        ],
            'expand_category_hierarchy' => [
            'type'  => 'checkbox',
            'label' => __( 'Expand hierarchy by default', 'premmerce-filter' ),
        ],
            'show_filter_button'        => [
            'type'  => 'checkbox',
            'label' => __( 'Show filter button', 'premmerce-filter' ),
        ],
        ],
        ],
            'show_on_pages' => [
            'label'  => __( 'Show filter on pages', 'premmerce-filter' ),
            'fields' => [
            'product_cat'   => [
            'type'  => 'checkbox',
            'label' => __( 'Product category', 'premmerce-filter' ),
        ],
            'tag'           => [
            'type'  => 'checkbox',
            'label' => __( 'Tag', 'premmerce-filter' ),
        ],
            'product_brand' => [
            'type'  => 'checkbox',
            'label' => __( 'Brand', 'premmerce-filter' ),
        ],
            'search'        => [
            'type'  => 'checkbox',
            'label' => __( 'Search', 'premmerce-filter' ),
        ],
            'shop'          => [
            'type'  => 'checkbox',
            'label' => __( 'Store', 'premmerce-filter' ),
        ],
            'attribute'     => [
            'type'  => 'checkbox',
            'label' => __( 'Attribute', 'premmerce-filter' ),
        ],
        ],
        ],
            'taxonomies'    => [
            'label'  => __( 'Taxonomies', 'premmerce-filter' ),
            'fields' => [
            'taxonomies' => [
            'title'    => __( 'Use taxonomies', 'premmerce-filter' ),
            'type'     => 'select',
            'options'  => $taxonomyOptions,
            'multiple' => true,
            'help'     => __( 'Choose taxonomies used by filter.', 'premmerce-filter' ),
        ],
        ],
        ],
            'ajax'          => [
            'label'  => __( 'AJAX', 'premmerce-filter' ),
            'fields' => [
            'load_deferred' => [
            'type'  => 'checkbox',
            'label' => __( 'Load deferred', 'premmerce-filter' ),
        ],
        ],
        ],
            'styles'        => [
            'label'  => __( 'Styles', 'premmerce-filter' ),
            'fields' => [
            'style' => [
            'title'   => __( 'Filter style', 'premmerce-filter' ),
            'type'    => 'select',
            'options' => [
            'default'   => __( 'Default', 'premmerce-filter' ),
            'premmerce' => 'Premmerce',
        ],
        ],
        ],
        ],
        ];
        $settings['ajax']['fields']['use_ajax'] = [
            'type'  => 'checkbox',
            'label' => __( 'Use ajax', 'premmerce-filter' ),
        ];
        $strategies = [
            'woocommerce_content' => __( 'Woocommerce content', 'premmerce-filter' ),
            'product_archive'     => __( 'Product archive', 'premmerce-filter' ),
        ];
        $currentStrategy = apply_filters( 'premmerce_filter_ajax_current_strategy', null );
        $configurableStrategies = apply_filters( 'premmerce_filter_ajax_configurable_strategies', [] );
        if ( in_array( $currentStrategy, $configurableStrategies ) ) {
            $settings['ajax']['fields']['ajax_strategy'] = [
                'type'    => 'select',
                'title'   => __( 'Ajax Strategy', 'premmerce-filter' ),
                'help'    => __( 'Choose the strategy for replacing content during ajax product filtering.', 'premmerce-filter' ) . '<br>' . __( '<b>Woocommerce content</b> strategy - has better performance and supported most of woocommerce themes, where archive page has default woocommerce layout.', 'premmerce-filter' ) . '<br>' . __( '<b>Product archive</b> strategy - replaces all content placed in product archive template except footer and header.', 'premmerce-filter' ),
                'options' => $strategies,
            ];
        }
        $this->registerSettings( $settings, $this->page, $this->optionName );
    }
    
    /**
     * @return string
     */
    public function getLabel()
    {
        return __( 'Settings', 'premmerce-filter' );
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'settings';
    }
    
    /**
     * @return bool
     */
    public function valid()
    {
        return true;
    }

}