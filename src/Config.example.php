<?php
namespace Config;

/**
 * Data Source Name for database connection.
 */
const string DB_DSN = "mysql:host=localhost;dbname=database;charset=UTF8";
const string DB_USER = "user";
const string DB_PASS = "password";

const string IP_COUNTRY_TABLE = "ip_country";

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

const string STUN_SERVER = "stun.framasoft.org:3478";

const string FALLBACK_LOCALE = "en-US";

const string TEMPLATES_LOCATION = "templates";

/**
 * Path to the templates compilation cache directory.
 *
 * Set to false to disable caching.
 */
const TEMPLATES_CACHE = "/tmp/php/All-in-One Leak Test/templates_cache";
