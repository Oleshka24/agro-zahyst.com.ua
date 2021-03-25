(function ($) {

    var useAjax = !!premmerce_filter_settings.useAjax;
    var loadDeferred = !!premmerce_filter_settings.loadDeferred;
    var showFilterButton = !!premmerce_filter_settings.showFilterButton;

    function followLink(e, link) {
        e.preventDefault();
        let target = e.target;
        if (!target.dataset.premmerceActiveFilterLink) {
            target = target.parentElement;
        }

        if (
            $(target).hasClass('pc-active-filter__item-delete')
            || $(target).hasClass('pc-active-filter__item-link')
        ) {
            window.location.href = link;
            return;
        }
        if (showFilterButton) {
            ajaxUpdate(link, 'filterButton');
        } else if (useAjax) {
            ajaxUpdate(link, 'reload');
        } else {
            location.href = link;
        }
    }

    function fixWoocommerceOrdering() {
        $('.woocommerce-ordering').on('change', 'select.orderby', function () {
            $(this).closest('form').submit();
        });
    }

    function ajaxUpdate(link, action) {

        var isFilterButton = action && action === 'filterButton';
        var requestData = {'premmerce_filter_ajax_action': action};
        var spin = action === 'reload';

        $.ajax({
            'method': 'POST',
            'data': requestData,
            'url': link,
            'dataType': 'json',
            beforeSend: function () {
                if (spin) {
                    showSpinner();
                }
            },
            complete: function () {
                if (spin) {
                    hideSpinner();
                }
            },
            success: function (response) {
                if (isFilterButton) {
                    ajaxSuccessFilterButton(response, link);
                } else {
                    ajaxSuccessReload(response, link);
                }
            }
        });
    }

    function ajaxSuccessFilterButton(response, link) {
        if (response instanceof Object) {
            for (var key in response) {
                var html = response[key].html;
                var selector = response[key].selector;
                if (selector === '[data-premmerce-filter]') {
                    var part = $(html).find(selector);
                    $(selector).replaceWith(part);
                    initScrolls();
                    initSliders();
                    fixWoocommerceOrdering();
                    $(document).trigger('premmerce-filter-updated');
                    $('[data-filter-button]').data('filterUrl', link);
                }
            }
        }
    }

    function ajaxSuccessReload(response, link) {
        if (response instanceof Object) {
            for (var key in response) {

                var html = response[key].html;
                var selector = response[key].selector;

                switch (response[key].callback) {
                    case 'replacePart':
                        var part = $(html).find(selector);
                        $(selector).replaceWith(part);
                        break;
                    case 'replaceWith':
                        $(selector).replaceWith(html);
                        break;
                    case 'insertAfter':
                        $(selector).insertAfter(html);
                        break;
                    case 'append':
                        $(selector).append(html);
                        break;
                    case 'remove':
                        $(selector).remove();
                        break;
                    default:
                        $(selector).html(html);
                }
            }
        }
        history.pushState({}, null, link);

        initScrolls();
        initSliders();
        fixWoocommerceOrdering();
        $(document).trigger('premmerce-filter-updated');
    }

    var fieldMin = 'data-premmerce-filter-slider-min';
    var fieldMax = 'data-premmerce-filter-slider-max';
    var slider = 'data-premmerce-filter-range-slider';

    function initSlider(form) {

        // Default valued at start
        var initialMinVal = parseFloat(form.find('[' + fieldMin + ']').attr(fieldMin));
        var initialMaxVal = parseFloat(form.find('[' + fieldMax + ']').attr(fieldMax));

        // Values after applying filter
        var curMinVal = parseFloat(form.find('[' + fieldMin + ']').attr('value'));
        var curMaxVal = parseFloat(form.find('[' + fieldMax + ']').attr('value'));

        // Setting value into form inputs when slider is moving
        form.find('[' + slider + ']').slider({
            min: initialMinVal,
            max: initialMaxVal,
            values: [curMinVal, curMaxVal],
            range: true,
            slide: function (event, elem) {
                var instantMinVal = elem.values[0];
                var instantMaxVal = elem.values[1];

                form.find('[' + fieldMin + ']').val(instantMinVal);
                form.find('[' + fieldMax + ']').val(instantMaxVal);
            },
            change: function (event) {
                submitSliderForm(event, form);
            }
        });

        form.submit(function (e) {
            //Remove ? sign if form is empty
            if (($(this).serialize().length === 0)) {
                e.preventDefault();
                window.location.assign(window.location.pathname);
            }
        });
    }

    function submitSliderForm(event, form) {
        if (event.originalEvent) {

            var sliderEl = form.find('[' + slider + ']');

            var minField = form.find('[' + fieldMin + ']');
            var maxField = form.find('[' + fieldMax + ']');

            var minVal = parseFloat(minField.val());
            var maxVal = parseFloat(maxField.val());

            var initialMin = sliderEl.slider('option', 'min');
            var initialMax = sliderEl.slider('option', 'max');

            if (minVal === initialMin) {
                form.find('[' + fieldMin + ']').attr('disabled', true);
            }

            if (maxVal === initialMax) {
                form.find('[' + fieldMax + ']').attr('disabled', true);
            }

            if (showFilterButton) {
                $('[data-filter-button]').data('filterUrl', form.attr('action') + '?' + form.serialize());
            } else if (useAjax) {
                var search = form.serialize();
                ajaxUpdate(form.attr('action') + '?' + search, 'reload');
                form.find('[' + fieldMin + '], [' + fieldMax + ']').attr('disabled', false);
            } else {
                form.trigger('submit');
            }

        }
    }

    /**
     * Launch filter after clicking on radio or checkbox control
     */
    $(document).on('change', '[data-premmerce-filter-link]', function (e) {
        followLink(e, $(this).attr('data-premmerce-filter-link'));
    });

    /**
     * Launch filter after changing select control
     */
    $(document).on('change', '[data-filter-control-select]', function (e) {
            followLink(e, $(this).val());
        }
    );

    /**
     * Launch filter after clicking on radio or checkbox control
     */
    $(document).on('click', '[data-premmerce-active-filter-link]', function (e) {
            followLink(e, $(this).attr('href'));
        }
    );

    $(document).on('click', '[data-filter-button]', function (e) {
        window.location.href = $('[data-filter-button]').data().filterUrl;
    });

    /**
     * Toogle filter block visibility
     */
    $(document).on('click', '[data-premerce-filter-drop-handle],[data-premmerce-filter-drop-handle]', function (e) {
        e.preventDefault();

        $(this).closest('[data-premmerce-filter-drop-scope]').find('[data-premmerce-filter-inner]').slideToggle(300);
        $(this).closest('[data-premmerce-filter-drop-scope]').find('[data-premmerce-filter-drop-ico]').toggleClass('hidden', 300);
    });


    $(document).on('change', '[data-premmerce-slider-trigger-change]', function (e) {
        var form = $(e.target).closest('form');
        submitSliderForm(e, form);
    });

    $(document).on('click', '[data-hierarchy-button]', function (e) {
        e.preventDefault();
        var id = $(this).data().hierarchyId;
        var nest = $('[data-parent-id="' + id + '"]');
        if (nest.hasClass('filter__checkgroup-inner-expanded')) {
            nest.removeClass('filter__checkgroup-inner-expanded');
            nest.addClass('filter__checkgroup-inner-collapsed');
        } else {
            nest.addClass('filter__checkgroup-inner-expanded');
            nest.removeClass('filter__checkgroup-inner-collapsed');
        }
    });

    $(document).ready(function () {
        var innerHierarchies = $('.filter__checkgroup-inner');
        innerHierarchies.each(function (i, el) {
            var innerHierarchy = $(el);
            if (innerHierarchy.find('input:checked').length > 0 && !innerHierarchy.hasClass('filter__checkgroup-inner-expanded')) {
                innerHierarchy.addClass('filter__checkgroup-inner-expanded');
                innerHierarchy.removeClass('filter__checkgroup-inner-collapsed');
            }
        });
    });


    function initScrolls() {
        /**
         * Positioning scroll into the middle of checked value
         * Working only if scroll option in filter setting is true
         */
        $('[data-filter-scroll]').each(function () {
            var frame = $(this);
            var fieldActive = frame.find('[data-filter-control]:checked').first().closest('[data-filter-control-checkgroup]');

            if (fieldActive.length > 0) {
                var fieldActivePos = fieldActive.offset().top - frame.offset().top;
                frame.scrollTop(fieldActivePos - (frame.height() / 2 - fieldActive.height()));
            }
        });
    }

    function initSliders() {
        $('[data-premmerce-filter-slider-form]').each(function (p, el) {
            initSlider($(el));
        });

    }


    if (loadDeferred) {
        ajaxUpdate(location.href, 'deferred');
    } else {
        initScrolls();
        initSliders();
    }

    function showSpinner() {
        var wrapper = $('<div>', {class: 'premmerce-filter-loader-wrapper'});

        $('body').prepend(wrapper);
    }

    function hideSpinner() {
        $('.premmerce-filter-loader-wrapper').remove();
    }

})(jQuery);