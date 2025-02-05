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
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          '@Jr-S~P}=MB&i2G_Wja[VH58m_Zos$jEzu8wYhlifM>t:zs;b;?-k$7l;vwVttK7' );
define( 'SECURE_AUTH_KEY',   '(wC[nMR9rD!Ivqgqh%F6;#Q{3mfVV;Q7ZUab)U15/V_{)f:4vrQ>QR/60|LPVA.h' );
define( 'LOGGED_IN_KEY',     ':oupOPs[#?j7|pB$a|no@?z?&;inR8kbyj<i<#8qES351a,DYs-SIWpk|8e`DFTM' );
define( 'NONCE_KEY',         '.|tmwSH7P:UzMwKP>W5JBDMuz&tBk$nJ@+R6[?[x;0{)vTLg}=$LqaJ[7yDE;Yd=' );
define( 'AUTH_SALT',         'oh9a^Z*zB$Xv)cB$zyBODV8p4Jsp5sEfD9KeUC*GOTjx`v#Y23H:/<8u*%*:G:qm' );
define( 'SECURE_AUTH_SALT',  'ka{s QF;eH/2N$9f|.5BuayDJ)k3.DSlR4A$I;gY7Mmfu7v*5_[D|b&p%X`H?A-x' );
define( 'LOGGED_IN_SALT',    'qUTgV%oY]AyS`T8iE_Hz g2biuLXl}omAD*jjPyWksy]z},JPDZQh;-ezKu}Rpdt' );
define( 'NONCE_SALT',        'tDBU;jHpj2h$L&FO7lud6:&k;n/yAT#(x-rN2lPimI[=V&4j$Jo.G$fyEU4,H5?7' );
define( 'WP_CACHE_KEY_SALT', 'bkw(10XH5[QbAxjZdF >JW(+b&y`q=gYn2@mlVZz~b<o7d8<DC(M;iKT+JZiWk_O' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
