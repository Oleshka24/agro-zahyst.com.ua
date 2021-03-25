<div id="terms">
    <? if (get_locale() == 'uk')  : ?>
        <div class="confirm">
            Підтверджуючи замовлення, я приймаю умови <a href="#term" class="modal" >угоди користувача</a> і даю згоду на <a href="#personal-data" class="modal">обробку персональних даних</a>
        </div>
    <? elseif (get_locale() == 'ru_RU') : ?>
            Подтверждая заказ, я принимаю условия <a href="#term" class="modal" >пользовательского соглашения</a> и даю согласие на <a href="#personal-data" class="modal">обработку персональных данных</a>
    <? endif; ?>
</div>
            <div id="term"style="display: none;">
                <?php wc_get_template( 'checkout/term.php' ); ?>
            </div>
            
            <div id="personal-data"style="display: none;">
                <?php wc_get_template( 'checkout/personal-data.php' ); ?>
            </div>
            
            
    <script>
     jQuery(".modal").fancybox({
        wrapCSS: 'term',
        padding: 10,
        autoFocus: false,
    });
    </script>