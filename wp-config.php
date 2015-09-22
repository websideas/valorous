<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'valorous');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('WP_POST_REVISIONS', false );

define('WP_MEMORY_LIMIT', '96M');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '6^#o3s]=PY+_O(|_!LKR.#b#o=&`r5wdoZ<Ku.&(3xFuJ^R-d8xK$rHBoOb[Q+w7');
define('SECURE_AUTH_KEY',  'Qh*;vW5<f~)2I8!)F ;!zD_W[tZbjK6o}_[R?ArdmX&([-K_l#Ls;SL,p<Ez*Q&k');
define('LOGGED_IN_KEY',    '`,j(ere+N#>Y!hL|sP}6a^_GcTh3.8S?K=<R>t,4ch2#8Bg1w:{rfRUYY|@fJ}vC');
define('NONCE_KEY',        'sSy+mCY%YD[@dWId_UX_e|Dq} 9@wr!{Bk(h)4Y2ZVcGz,+J6oz0?cbFk-Iv$.S/');
define('AUTH_SALT',        'L*+rr*Po9f=2Z %kA]yW}|bWmKdLS6KM-Ij?P+GyCY-+<Q-8<S+9K=:E6q9;RU/E');
define('SECURE_AUTH_SALT', 'Mc{.rzPE|W8&8FP#Lky|kN&2G7iunf_KM8#S:?+4ApT_AoET A==C/+E/9GFFyNV');
define('LOGGED_IN_SALT',   'f&>-<G#yF,PEhBXnrBY6yj#M%mGchqY`{Xj~%5P0<D|_|j)FbvbltVZZb|xr+^Fs');
define('NONCE_SALT',       'c 3|cf7]Hb=tK! (%FQzvH|NFMM$m c}VZ ..Y|h?kk-x2L16a#<]5CW_q1)iwSw');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'va_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
