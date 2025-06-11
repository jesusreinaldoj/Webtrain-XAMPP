<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'bbdd-webtrain' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database hostname */
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
define( 'AUTH_KEY',         'uleeejlx4eeuhljmlqoee5lqjn8u62rlyubv00ruunk1m1ggc9mzf1q7np0ky8wk' );
define( 'SECURE_AUTH_KEY',  '76dgfronmxt2fji5volkvwnm7cpgeiu0xrmffgfuy4bllr95iex2luzhwi966rio' );
define( 'LOGGED_IN_KEY',    's2pylxmsxoxlx2zck67aaoaffhnsdm2zgzlmeyjiwdqqci3wm5c4klwzeg6jpmgu' );
define( 'NONCE_KEY',        '56nojdxwdnaqxehcg8hedw7sev28rqfqwzdw2gkm2juqiu65zqxauzt8tymnd0rp' );
define( 'AUTH_SALT',        'zclrl3twoauszrsktxhd9itpvraebldrb0umgquzdetnle9dpsvxl15thwrbtcfu' );
define( 'SECURE_AUTH_SALT', 'mf5oizprapimveralsaffog5c2dwp9uuhkh8oqljkxcijunta1jkbwvolkjt4hfu' );
define( 'LOGGED_IN_SALT',   'eaobdzedfoaz3fhhuurkmdekjiclzz7bqya0ie9swfbe1fiyznyvu5ibfon8klu2' );
define( 'NONCE_SALT',       'l6qamekrpqji0gfx5acrwrj1wz3yboablri3gutjswofyjm02glg2omdyozrstfq' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wbt_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );


/* Add any custom values between this line and the "stop editing" line. */


define('FS_METHOD', 'direct');
define('WP_HOME', 'http://localhost/wordpress');
define('WP_SITEURL', 'http://localhost/wordpress');
define('UPLOADS', 'wp-content/uploads');


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
