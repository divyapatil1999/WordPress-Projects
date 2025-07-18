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
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'l3:^h`?k5.G;Lm%TuYHx?)`UxVWuY&c&>3P?-)Yxt_=hFN,UaXYp?UfODA3gKL];' );
define( 'SECURE_AUTH_KEY',  'm@6RD($K!}XbxL,R.;2B574;F^Ym|dd)3,H9pOl+[GnO)I}%ntifu3ps5D(X!=Hf' );
define( 'LOGGED_IN_KEY',    'ipFjwV]iVr~r?0VF$3`DfUYKgyV_`AX7@@R(Xj_`2qklMEr=Whnn!C|Ot9U>,=_C' );
define( 'NONCE_KEY',        '9%4usI2.#+_,2NF]XPym}@D1kQC#xYU|pa6[Bm}_X7u~[EE:N;FOmQ$Csfh#Fzo]' );
define( 'AUTH_SALT',        'pnXpT92Y#NcJ#C}&k>IrqqM_KmVs<SRrP!PgM?i+}%)cF-0k6D#(8B)o}Ys[Pmbl' );
define( 'SECURE_AUTH_SALT', 'm<{s}9xm}rlV}u97ff.WWu  p+:t7[pV~MDR}mY]-*^2fabgDGYr~Fd?YF1@1c&i' );
define( 'LOGGED_IN_SALT',   '~e7jFzktWC]-O]BSz;N/N6Eebi>M%-.=f<Ab6(w I#to!TP]~&lQHGicQfc+WGw^' );
define( 'NONCE_SALT',       'm3X_a9 tg$eO:$w1FtQfq7=82Oe#.;+U`]n4cEb&m6AG`lWGRo:tVV@r+)-pWj/u' );

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
$table_prefix = 'dwp_';

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
/**
 * This will log all errors notices and warnings to a file called debug.log in
 * wp-content (if Apache does not have write permission, you may need to create
 * the file first and set the appropriate permissions (i.e. use 666) )
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );
@ini_set( 'display_errors', 1 );

/* Add any custom values between this line and the "stop editing" line. */

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
define('FS_METHOD', 'direct');
define( 'WP_ENVIRONMENT_TYPE', 'staging' );