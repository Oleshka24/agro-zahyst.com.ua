<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'ay406719_db' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'root' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '&[2P]{ 6xaxgQSjgif=3-,m<Pz6];RGLTG%PX.T=~-+~U%`N [;T`Umy ^Su&^J)' );
define( 'SECURE_AUTH_KEY',  'kD!kl!*EmWiF#0b-if_1[$W/Vv/,U`5&mqOza#z#_.~;PbolbMYik~#GAb4?WaJ&' );
define( 'LOGGED_IN_KEY',    '{>tq|p7&0Zdpv|4+E?=-z#_x7iXTP.vE2T,P8<o_^WEBrG2Q((8!e*21@vZuk6v9' );
define( 'NONCE_KEY',        '%JG`m>0/CggMiyz_JcS~Ns?hHsWQN5*3g#<a@e`>@3_x7oc/(JJh$#`ucx2v%!!-' );
define( 'AUTH_SALT',        'J^Z9!5o0q9K^>qA3F;{=><Z0v(9&>C^sBYH<7,Rr/Zi%P;N{TcYhf^pCU7{E;7gY' );
define( 'SECURE_AUTH_SALT', '3)^j]U5yKM$R^R?V^r8!nW4OB}8.K 0a|Kpw^cviGB<D0&<F1afG([s51.}$-+-i' );
define( 'LOGGED_IN_SALT',   'dC^(F72<`#F0F!nEdSP*kpF+$GC0IQ@:Ku2bu6f~-+}d$Z6i+cd?l&eio.a(vpPw' );
define( 'NONCE_SALT',       '&*C5|Q2VRv@4k4Ju5Hx?p,==%rxp9@X7VDtiYJbCBdIKe}qKY=qu]/;S|8R+.M/l' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );