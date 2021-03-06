<?php
/**
 * Базовая конфигурация WordPress.
 *
 * Данный файл содержит конфигурацию следующих параметров: настройки MySQL, префикс таблиц,
 * секретные ключи, язык WordPress и ABSPATH. Вы можете почитать подробнее, зайдя на
 * страницу {@link http://codex.wordpress.org/Editing_wp-config.php Редактирование
 * wp-config.php} кодекса. Вы можете узнать настройки MySQL у Вашего хостера.
 *
 * Данный файл используется при создании wp-config.php во время установки.
 * Однако Вам не обязательно пользоваться Веб-интерфейсом, Вы можете просто скопировать его в
 * "wp-config.php" и самостоятельно заполнить значения.
 *
 * @package WordPress
 */

// ** Настройки MySQL - Вы можете получить эти данные у Вашего хостера ** //
/** Название базы данных WordPress */
define('DB_NAME', 'stunko_inavext');

/** Имя пользователя MySQL */
define('DB_USER', 'stunko_inavext');

/** Пароль MySQL */
define('DB_PASSWORD', 'cHICONY78');

/** Хост MySQL */
define('DB_HOST', 'localhost');

/** Кодировка СУБД, используемая при создании таблиц. Едва ли Вам потребуется это изменять. */
define('DB_CHARSET', 'utf8');

/** Способ сравнения строк в СУБД. Не меняйте это значение, если сомневаетесь. */
define('DB_COLLATE', '');

//** Для того, чтобы включить автоматическое восстановление базы данных
define('WP_ALLOW_REPAIR', true);

/**#@+
 * Уникальные ключи аутентификации.
 *
 * Поменяйте эти строки на другие уникальные фразы! Если Вы этого не сделаете, безопасность Вашего блога будет под угрозой.
 * Вы можете сгенерировать их при помощи специального сервиса {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Вы можете поменять их в любой момент. Это приведет к тому, что всем пользователям нужно будет входить в систему заново.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Kabas');
define('SECURE_AUTH_KEY',  'Kabas');
define('LOGGED_IN_KEY',    'Kabas');
define('NONCE_KEY',        'Kabas');
define('AUTH_SALT',        'Kabas');
define('SECURE_AUTH_SALT', 'Kabas');
define('LOGGED_IN_SALT',   'Kabas');
define('NONCE_SALT',       'Kabas');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Вы можете иметь несколько установок в одной БД, давая им различные префиксы.
 * Пожалуйста, используйте только латинские буквы, арабские цифры и знаки подчеркивания!
 */
$table_prefix  = 'inavex_';

/**
 * Язык локализации WordPress.
 *
 */
define ('WPLANG', 'ru_RU');

/**
 * Для разработчиков: включение режима отладки WordPress.
 *
 * Поменяйте это значение на true, если хотите видеть сообщения по ходу разработки.
 * Крайне рекомендуется использовать WP_DEBUG разрабочикам тем и плагинов в своей среде разработки.
 */
define('WP_DEBUG', false);

/* Все, больше редактировать ничего не надо! Счастливых публикаций. */

/** Абсолютный путь к каталогу WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Настраивает переменные и модули WordPress. */
require_once(ABSPATH . 'wp-settings.php');


set_time_limit(60);
