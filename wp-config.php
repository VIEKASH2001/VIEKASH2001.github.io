<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'portfolio_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '1V==5w8XECWmjZ,5eGt92>uo62=%SVUrL/%p(tdD%8<|<qSQQ^PGAU.&XLXYt+9$' );
define( 'SECURE_AUTH_KEY',  'P )OLj8;)cfsB|}I#kgrqU[8zHVhO6DK5_f`W0X<Z$F#!rY -/ W||$oD;J@#LcZ' );
define( 'LOGGED_IN_KEY',    'H^,A9CU&1d||*<ra|j^KFlgP$9is1Kv^/<Btix7L& *=u(YH[qT(!BupZ^-qW+I-' );
define( 'NONCE_KEY',        'I(b)fW`3rl|U}IpYLhK={E0[cA:@r *-)aS8. 6ow-RM?pCI}SB@B[%%t[$T4p5v' );
define( 'AUTH_SALT',        '~iK}xW|:yGouTiB!Bkgr3+9lswM?V= qrRg)n 8,`&lO`ato3vC~b9EsU3O%OO1M' );
define( 'SECURE_AUTH_SALT', '$]fjsJ$Tbkg_})SoWu7)o,nwy][rsH+R7?5cyM=?By/Fc}@o#)ZF|WZVlwf5W#0O' );
define( 'LOGGED_IN_SALT',   '33,VNM>um+}!Gu6m!}^V?PYt3|B6$xP@Rs6i3)uo;sx$?;/!xqbffJiH8Hjg1Js~' );
define( 'NONCE_SALT',       'CMi08aEeKnpIMowjSm|kFhd#c#~*R)u+5c#6X.u)N6!+toRU<3Z%>7$[VB7xubq>' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
