<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
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
define('DB_NAME', 'atlcurli_wo1715');

/** MySQL database username */
define('DB_USER', 'atlcurli_wo1715');

/** MySQL database password */
define('DB_PASSWORD', 'APfAgcMZvt3O');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY', 'DA%HCVIjtnsAwHk{RLbJxRni>u%Ns=>$[z|aZaTO^tHGJk?RfG=X!a/gNa{-?^!p*}YRT@X(-Q-m/_EJzF&IPDFB&[$T!FO<_tM![?bk+zUI_LW|[i^z(zpiKEgimy>u');
define('SECURE_AUTH_KEY', 'LqLg;l])jF-v>Nrhpvyi)YzofH[I&crxOCyn}m}?hff>Ejji^E{)p<kDtHzS^m[/<?LHz|ZxYUBofX<A(Jbw[Q+OhVDsQmLWZlfnK$Q}A&YMB_liIT[%CBocA/@dj+xu');
define('LOGGED_IN_KEY', 'kiW[RR_srz@btm^iPKrt?R{u]Dn[rMZpD(g<WG!Zk<I%Zf*]XO{ujJ&li_lUhCQTu)-*XgL(<M^zlIIWioF{E+ZX{>kYf;tovL%s}rf>kvpEm%y^VUhp%&FwYNHmzQg&');
define('NONCE_KEY', 'O]luq!N<j&u@FL=_eU;DvCjQQ-Hx!rZeDlT/slPv>R(K+n%fyvz(^+{hli;JFnFVVK}OwS<bC*!$X}PFFy>D;|_A+NH_TCSrFCo(=(KnK/V[eqE*T_sHLB/MkE$p*>[T');
define('AUTH_SALT', 'lb<[]bS^G-Hc-[_xzl!BkpBV(CMNU_?k<VrD;Vk<IE|?QR<=eLGaD)G-*bQ>G)VuIVN[Q?]K$&G_PCHXc-jUm+-lc%JgjzsYycz)pByOu=jSj&|qj>E]ETmery/HbXm}');
define('SECURE_AUTH_SALT', 'Si*cwEv]!!qlXXAbUiQFzIuP>DNQZ<P{FV@k!R]?nj{&D&eUYqrJLt|YZasd!b%RA)ne}@HYFiOHIw-alRFG*snDrKknNbFo[K)aMV*F(&qkV&xfWIGTY-_%FSGdOtxL');
define('LOGGED_IN_SALT', '<DUgvzI)luw[Pleud%@_&z/(dmEc%JMSL^|<wiaOWNTEFJQq;s_ABpCQEjqa]Xg{DTVTIUAKkFIetNVIFK&YxqnFjt&+l+KqB@Gr$?mndyEv;mjZP>k?e*WyH>-TnxBe');
define('NONCE_SALT', '?%;iS;KO-hvqj&}ePI[;sv;$LURLpk]IU%S;()TCQ-jT>t?z;ANs@gkONZgm<mA|{{-LC[nto|*KR;HGVkN>TWQ^KamN?hRGq|X?lDjwj%eZQOqux/%yz>=KlvvJOpPl');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_idzj_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

/**
 * Include tweaks requested by hosting providers.  You can safely
 * remove either the file or comment out the lines below to get
 * to a vanilla state.
 */
if (file_exists(ABSPATH . 'hosting_provider_filters.php')) {
	include('hosting_provider_filters.php');
}
