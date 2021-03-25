<?php if ( ! defined('ABSPATH')) {
    exit;
}
?>
<div class="filter__colors-box">
    <?php foreach ($attribute->terms as $term): ?>
        <?php $id = 'filter-checkgroup-id-' . $attribute->attribute_name . '-' . $term->slug; ?>

        <div class="filter__colors-item">
            <input class="filter__checkgroup-control "
                   id="<?php echo $id ?>"
                   type="checkbox"
                   data-premmerce-filter-link="<?php echo $term->link ?>"
                <?php echo $term->count == 0 ? 'disabled' : '' ?>
                   <?php if ($term->checked): ?>checked<?php endif ?>
            >
            <?php $color = $term->color ? $term->color: '#96588a'; ?>
            <label class="filter__color-button"
                   for="<?php echo $id ?>"
                   style="background-color: <?php echo $color; ?>; "
                   title="<?php echo $term->name; ?>"
            >
            </label>
        </div>
    <?php endforeach ?>
</div>