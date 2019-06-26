<?php
/**
 * Основные параметры WordPress.
 *
 * Этот файл содержит следующие параметры: настройки MySQL, префикс таблиц,
 * секретные ключи, язык WordPress и ABSPATH. Дополнительную информацию можно найти
 * на странице {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Кодекса. Настройки MySQL можно узнать у хостинг-провайдера.
 *
 * Этот файл используется сценарием создания wp-config.php в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать этот файл
 * с именем "wp-config.php" и заполнить значения.
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'dub');

/** Имя пользователя MySQL */
define('DB_USER', 'any');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'any');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется снова авторизоваться.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'W^0T33x-5$4}p(#%mjjH[+|W0F.#]?^&QkOyWjB.W1I?qSl0oS,SCWI8EGS-{JxI');
define('SECURE_AUTH_KEY',  '02}`|L2;2<kfAi2GD{=z5s)$A2S)]@/IKeHua51}sjM<hv%H@^7T>@S+U=,)n4;F');
define('LOGGED_IN_KEY',    '7I8/Oh.X.tJ2k)9[ !vW8V7+[8%<fGo^VFz5eua5*G@xnT)QT-CCvRqo^j{JcBGQ');
define('NONCE_KEY',        'T4-e{zk+)Qm:LxhQut*v+d7r*V V%S3@X(x4|$|3m*7FR_+OI1`8Aow=-=bni~?x');
define('AUTH_SALT',        '8`_T[P=/1DEZi1j(OBaLw4cYQ]3WK>+Q*SYs/f<*Pn_lHB@9P}3[_;n#%m1)1Bce');
define('SECURE_AUTH_SALT', 'DPjL@b!+j|?|8i=U/NGN_4d#z[)=!RT8xHAwb&~4[p_/@34&qKmpjnP9R27?tU+z');
define('LOGGED_IN_SALT',   'RF)e}7L?G;tct3uK?>|e%5:pl+2{ui_Pf+(89?VNY!8/eJ:F9r4Jcw>?m3r>!-]b');
define('NONCE_SALT',       '}ul Y;maM>_o|k(V _D-00]/ ;K@VvmA03,@?TLw8yD|88!Rev*u+;Y{S WOh~H<');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько блогов в одну базу данных, если вы будете использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Язык локализации WordPress, по умолчанию английский.
 *
 * Измените этот параметр, чтобы настроить локализацию. Соответствующий MO-файл
 * для выбранного языка должен быть установлен в wp-content/languages. Например,
 * чтобы включить поддержку русского языка, скопируйте ru_RU.mo в wp-content/languages
 * и присвойте WPLANG значение 'ru_RU'.
 */
define('WPLANG', 'ru_RU');

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Настоятельно рекомендуется, чтобы разработчики плагинов и тем использовали WP_DEBUG
 * в своём рабочем окружении.
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
