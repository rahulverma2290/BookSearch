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
define('DB_NAME', 'book_search');

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
define('AUTH_KEY',         'Y;;t3f_}M1kF-zLk]*/,DXpz@6=OJM2rMlG6[,(_.XUj1J&l,e0oT@#QCuQw26ed');
define('SECURE_AUTH_KEY',  '2l!i.a#XMkwcvS|9T_sz4JW=giF)osZN1e))Z|m[2#HWO4YiI08*0vp=Jz6nh/Y^');
define('LOGGED_IN_KEY',    'Jm.+:n42RRmMY)y%iAmCB,M3$g{9P>oJrc@en~p@k2IeVy*e/3BZKQo7>aI3:*yg');
define('NONCE_KEY',        '1k@^l4,ki3(ULf^L=vu;PS_^{&F79<NC]wOt.]HK/uX2IM-BSPHiFV-?tu3/.VCR');
define('AUTH_SALT',        'd@UlL-zEehRE{xdbaN=y9E|3@(haPb,p! WRR9??sRwLv~NsFeAeg?c;?~S)/|+t');
define('SECURE_AUTH_SALT', '``}<u;TQ`M.8kVWQ?L~EuB$Ba[m[#RBF,|T&08ZQ? ,PdhvwrJVoc|_ZT5dK-^h#');
define('LOGGED_IN_SALT',   'kod9b3qP>-{,rTaV;2yD`p:}mx[=?U~be>^d~(6R]5]t/.ztX_N_n:*`=# f06v$');
define('NONCE_SALT',       '>r_zuK@>T90N&WPQC.[Nw#[Mg;rf4UaE*&0yLc}o_hpfah}_|=g!!qHKSO:weQcU');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'bs_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
