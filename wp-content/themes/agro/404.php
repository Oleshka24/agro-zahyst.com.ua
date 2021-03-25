<? get_header(); ?>
    <main>
        <section class="content error">
            <div class="container">
                <div class="title">
                    <h1><? pll_e('Ошибка 404: страница не найдена'); ?> </h1>
                </div>
                <div class="subtitle">
                    <p>
                       <? pll_e('Cтраница, которую вы ищете, не существует'); ?>
                    </p>
                </div>
                <div class="main-image"><img src="<? print get_template_directory_uri(); ?>/assets/images/error.svg" alt=""></div>
                <a href="/"> <? pll_e('Вернуться на главную'); ?></a>
            </div>
        </section>
    </main>
<? get_footer(); ?>