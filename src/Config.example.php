<?php
namespace Config;

/**
 * Data Source Name for database connection.
 */
const DB_DSN = "mysql:host=localhost;dbname=zeroleaks;charset=UTF8";
const DB_USER = "zeroleaks";
const DB_PASS = "password";

/**
 * Names of GeoLite2 IP country tables in the database.
 */
const IPV4_COUNTRY_TABLE = "ipv4_country";
const IPV6_COUNTRY_TABLE = "ipv6_country";

/**
 * Path to CSV file containing IP country overrides.
 *
 * Set to false if not required.
 *
 * The format of the file must be: IP,COUNTRY CODE
 *
 * Both IPv4 and IPv6 are supported.
 *
 * Example:
 * <pre>
 * 172.67.14.95,DE
 * 2001:470:142:5::116,NL
 * </pre>
 */
const IP_COUNTRY_OVERRIDE_FILE = false;

/**
 * STUN server used for WebRTC leak test.
 */
const STUN_SERVER = "stun.framasoft.org:3478";

/**
 * URL of the ZeroLeaks helper websocket server.
 */
const HELPER_SERVER_URL = "wss://zeroleaks.org";

/**
 * Maximum number of records in the IP history.
 *
 * Set to -1 to disable, 0 for infinite.
 */
const IP_HISTORY_MAX_SIZE = 10;

/**
 * Default locale to use if that of the client cannot
 * be determined.
 */
const FALLBACK_LOCALE = "en-US";

/**
 * Path to the HTML templates to use, relative to the root of the
 * source repository.
 */
const TEMPLATES_LOCATION = "templates";

/**
 * Path to the templates compilation cache directory.
 *
 * Set to false to disable caching.
 */
const TEMPLATES_CACHE = "/tmp/ZeroLeaks/cache/templates";
