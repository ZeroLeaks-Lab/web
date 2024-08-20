<?php
namespace Config;

/**
 * Data Source Name for database connection.
 */
const DB_DSN = "mysql:host=localhost;dbname=database;charset=UTF8";
const DB_USER = "user";
const DB_PASS = "password";

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

const STUN_SERVER = "stun.framasoft.org:3478";

const FALLBACK_LOCALE = "en-US";

const TEMPLATES_LOCATION = "templates";

/**
 * Path to the templates compilation cache directory.
 *
 * Set to false to disable caching.
 */
const TEMPLATES_CACHE = "/tmp/php/All-in-One Leak Test/templates_cache";
