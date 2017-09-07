<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp.task');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'QN*nsF*2BK=@r5R+gW5F7A/*%al}hfw{K|A5alGz:z^U|iRQ ~-L@/_grOxg5DkW');
define('SECURE_AUTH_KEY',  'bumxJI~4fjj<?ofuU}]4|&nv1`#F9HY7m>gW>Rb1ZEt&X*S=N!C1O$MxB>eod!f7');
define('LOGGED_IN_KEY',    'HEII5$]3!EEy~XIlDA-=U#^j8;(O4R[AAd1gn~^UKij.SPG&h3&mv ;ZQQEzIl[F');
define('NONCE_KEY',        ')Ba6/Qv~,txvOO)2C{MMCoZb@ Z{{oI (QG=bZQhDqbzmSj5GK~J;zivM_.!Bm2:');
define('AUTH_SALT',        'TT%}#h/|lj-_X1n|>CmRXnwIX>>edd,:Qp>CG JnhSi(n[JszS_ILk4L 0VQ:(d{');
define('SECURE_AUTH_SALT', 'D!(*.+sS:QVj?]CmwPpuYf3.L/gy ,n1j~^@eOk`atN5 uZ-~P+K0u_#&B8P+MHR');
define('LOGGED_IN_SALT',   'R)xW2$2L!T[,!5JCp@usB?`,WXZzu;#*xkP$};:LmtX2S5hKK0>f)z8FYoWd)L3Q');
define('NONCE_SALT',       '4)k!`tpSgNk/W^KM!C;&d58z%B.LG.Z7 G>s4u!)3xPC>^SzKs49Dn*71~xf:2DP');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
