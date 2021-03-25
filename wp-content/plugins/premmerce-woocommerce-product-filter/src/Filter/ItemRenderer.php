<?php namespace Premmerce\Filter\Filter;


use Premmerce\Filter\Filter\Items\Types\TaxonomyFilter;
use Premmerce\SDK\V2\FileManager\FileManager;

class ItemRenderer
{

    /**
     * @var FileManager
     */
    private $fileManager;

    /**
     * ItemRenderer constructor.
     *
     * @param FileManager $fileManager
     */
    public function __construct($fileManager)
    {
        $this->fileManager = $fileManager;

        add_action('premmerce_filter_render_item_checkbox', [$this, 'renderCheckbox'], 10);
        add_action('premmerce_filter_render_item_radio', [$this, 'renderRadio'], 10);
        add_action('premmerce_filter_render_item_select', [$this, 'renderSelect'], 10);
        add_action('premmerce_filter_render_item_label', [$this, 'renderLabel'], 10);
        add_action('premmerce_filter_render_item_color', [$this, 'renderColor'], 10);
        add_action('premmerce_filter_render_item_slider', [$this, 'renderSlider'], 10);
        add_action('premmerce_filter_render_item_after_title', [$this, 'renderAfterTitle'], 10);
    }

    /**
     * @param TaxonomyFilter $attribute
     */
    public function renderCheckbox($attribute)
    {
        $this->fileManager->includeTemplate('frontend/types/checkbox.php', ['attribute' => $attribute]);
    }

    /**
     * @param $attribute
     */
    public function renderRadio($attribute)
    {
        $this->fileManager->includeTemplate('frontend/types/radio.php', ['attribute' => $attribute]);
    }

    /**
     * @param $attribute
     */
    public function renderSelect($attribute)
    {
        $this->fileManager->includeTemplate('frontend/types/select.php', ['attribute' => $attribute]);
    }

    /**
     * @param $attribute
     */
    public function renderColor($attribute)
    {
        $this->fileManager->includeTemplate('frontend/types/color.php', ['attribute' => $attribute]);
    }

    /**
     * @param $attribute
     */
    public function renderSlider($attribute)
    {
        $this->fileManager->includeTemplate('frontend/types/slider.php', ['attribute' => $attribute]);
    }

    /**
     * @param $attribute
     */
    public function renderLabel($attribute)
    {
        $this->fileManager->includeTemplate('frontend/types/label.php', ['attribute' => $attribute]);
    }

    /**
     * @param $attribute
     */
    public function renderAfterTitle($attribute)
    {
        $this->fileManager->includeTemplate('frontend/parts/dropdown-handle.php', ['attribute' => $attribute]);
    }

    /**
     * @param FileManager $fileManager
     * @param \WP_Term $term
     * @param TaxonomyFilter $attribute
     * @param $isRootChecked
     * @param $rootId
     * @param bool $isParentChecked
     */
    public static function renderRecursiveChildren(
        FileManager $fileManager,
        $term,
        $attribute,
        $isRootChecked,
        $rootId,
        $isParentChecked = false
    ) {
        if (!empty($term->children) && is_array($term->children) && in_array(
                $attribute->getType(),
                ['checkbox', 'radio']
            )) {
            $settings = get_option('premmerce_filter_settings', []);
            $expandCategoryHierarchy = !empty($settings['expand_category_hierarchy']);
            foreach ($term->children as $child) {
                if ($child->count === 0 && !empty($settings['hide_empty'])) {
                    continue;
                }

                $fileManager->includeTemplate(
                    "frontend/types/parts/{$attribute->getType()}.php",
                    [
                        'term' => $child,
                        'attribute' => $attribute,
                        'expandCategoryHierarchy' => $expandCategoryHierarchy,
                        'isExpanded' => $expandCategoryHierarchy || $isRootChecked || $isParentChecked,
                        'isRootChecked' => $isRootChecked,
                        'isParentChecked' => $isParentChecked,
                        'rootId' => $rootId
                    ]
                );
            }
        }
    }
}
