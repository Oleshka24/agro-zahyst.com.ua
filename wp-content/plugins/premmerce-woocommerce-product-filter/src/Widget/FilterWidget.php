<?php namespace Premmerce\Filter\Widget;

use Premmerce\Filter\Filter\Container;
use WP_Widget;

class FilterWidget extends WP_Widget
{


    /**
     * FilterWidget constructor.
     */
    public function __construct()
    {
        parent::__construct(
            'premmerce_filter_filter_widget',
            __('Premmerce filter', 'premmerce-filter'),
            [
                'description' => __('Product attributes filter', 'premmerce-filter'),
            ]
        );
    }

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        if (apply_filters('premmerce_product_filter_active', false)) {
            $items = Container::getInstance()->getItemsManager()->getFilters();
            $items = apply_filters('premmerce_product_filter_items', $items);
            $settings = get_option('premmerce_filter_settings', []);
            $style = isset($settings['style']) ? $settings['style'] : 'premmerce';
            $showFilterButton = !empty($settings['show_filter_button']);

            do_action('premmerce_product_filter_render', [
                'args' => $args,
                'style' => $style,
                'showFilterButton' => $showFilterButton,
                'attributes' => $items,
                'formAction' => apply_filters('premmerce_product_filter_form_action', ''),
                'instance' => $instance,
            ]);
        }
    }

    /**
     * @param array $new_instance
     * @param array $old_instance
     *
     * @return array
     */
    public function update($new_instance, $old_instance)
    {
        $instance = [];
        $instance['title'] = strip_tags($new_instance['title']);

        return $instance;
    }

    /**
     * @param array $instance
     *
     * @return string|void
     */
    public function form($instance)
    {
        do_action('premmerce_product_filter_widget_form_render', [
            'title' => isset($instance['title']) ? $instance['title'] : '',
            'widget' => $this,
        ]);
    }
}
