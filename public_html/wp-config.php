<?php
/**
 * Il file base di configurazione di WordPress.
 *
 * Questo file viene utilizzato, durante l’installazione, dallo script
 * di creazione di wp-config.php. Non è necessario utilizzarlo solo via
 * web, è anche possibile copiare questo file in «wp-config.php» e
 * riempire i valori corretti.
 *
 * Questo file definisce le seguenti configurazioni:
 *
 * * Impostazioni MySQL
 * * Prefisso Tabella
 * * Chiavi Segrete
 * * ABSPATH
 *
 * È possibile trovare ultetriori informazioni visitando la pagina del Codex:
 *
 * @link https://codex.wordpress.org/it:Modificare_wp-config.php
 *
 * È possibile ottenere le impostazioni per MySQL dal proprio fornitore di hosting.
 *
 * @package WordPress
 */

// ** Impostazioni MySQL - È possibile ottenere queste informazioni dal proprio fornitore di hosting ** //
/** Il nome del database di WordPress */
define('DB_NAME', 'dbname');

/** Nome utente del database MySQL */
define('DB_USER', 'dbuser');

/** Password del database MySQL */
define('DB_PASSWORD', '123');

/** Hostname MySQL  */
define('DB_HOST', 'localhost');

/** Charset del Database da utilizzare nella creazione delle tabelle. */
define('DB_CHARSET', 'utf8mb4');

/** Il tipo di Collazione del Database. Da non modificare se non si ha idea di cosa sia. */
define('DB_COLLATE', '');

/**#@+
 * Chiavi Univoche di Autenticazione e di Salatura.
 *
 * Modificarle con frasi univoche differenti!
 * È possibile generare tali chiavi utilizzando {@link https://api.wordpress.org/secret-key/1.1/salt/ servizio di chiavi-segrete di WordPress.org}
 * È possibile cambiare queste chiavi in qualsiasi momento, per invalidare tuttii cookie esistenti. Ciò forzerà tutti gli utenti ad effettuare nuovamente il login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ij-|Z:QS0_g{nt,jLl=A:J0s?E|i-ssIzm?!/HcbyTl&y(6+c8-%,S6~GYP>O_o#');
define('SECURE_AUTH_KEY',  'CCIDtX+/`I6#,^9WpcyL-+D,Bf3^qN]m*rZ;MOt>&m$nPMjlLgyVq|.$` EUvBF}');
define('LOGGED_IN_KEY',    '-68-qQ3DF23%?j`Dq3-`R-K|A+A-e/d=5o)!<)JEBdc2c.{@^3QhL52-*9U9ArsJ');
define('NONCE_KEY',        'VveO;Q[NTN)GSuNAA$+.4x*D[%;4GJ!xTMdo~>e,S|$YC@`oKjj7H@q+E2c#@M!w');
define('AUTH_SALT',        'uqJdzbNpM#2G(:!G8#fA|Ee_LNQ*:;_nDu2oT7l+0Y-ig,kUN-dv#@`:~upd^^-~');
define('SECURE_AUTH_SALT', 'r!VA>,k.E@-yR[r0)SCgT+y;Y?.)BS]%%XWf?onmeWhk4|l[U2*>Vm}nY/G%IO7d');
define('LOGGED_IN_SALT',   'n2Uae!PQzRmV^1M`*%PuAYH+|)1tp?rUKQ$pR?C*OWh4<RCqV^NSDD#yQ9YkH+<]');
define('NONCE_SALT',       '*!}u4D}9f=G]C&?-zB%<l1$i4^lgp<c]9To^Z<;<;B}[AY|)8D4:l+;JZG@O6`L]');

/**#@-*/

/**
 * Prefisso Tabella del Database WordPress.
 *
 * È possibile avere installazioni multiple su di un unico database
 * fornendo a ciascuna installazione un prefisso univoco.
 * Solo numeri, lettere e sottolineatura!
 */
$table_prefix  = 'usv_';

/**
 * Per gli sviluppatori: modalità di debug di WordPress.
 *
 * Modificare questa voce a TRUE per abilitare la visualizzazione degli avvisi
 * durante lo sviluppo.
 * È fortemente raccomandato agli svilupaptori di temi e plugin di utilizare
 * WP_DEBUG all’interno dei loro ambienti di sviluppo.
 */
define('WP_DEBUG', false);

/* Finito, interrompere le modifiche! Buon blogging. */

/** Path assoluto alla directory di WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Imposta le variabili di WordPress ed include i file. */
require_once(ABSPATH . 'wp-settings.php');