<?php
/**
 * WP Snippet: Disable WP Shortlinks Everywhere
 * 
 * Removes WP shortlinks from all output locations:
 * - HTML <head> section
 * - HTTP Link headers
 * - get_shortlink() function calls
 * Smart filtering preserves other Link headers (preload, DNS-prefetch, etc.)
 * 
 * @author      Torwald45
 * @link        https://github.com/Torwald45/wp-snippet-disable-shortlinks
 * @license     GPL-2.0-or-later
 * @version     1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Run early to catch all shortlink generation
add_action('init', function () {
    // Remove shortlink from HTML <head>
    remove_action('wp_head', 'wp_shortlink_wp_head', 10);
    
    // Remove shortlink from HTTP headers
    remove_action('template_redirect', 'wp_shortlink_header', 11);
}, 0);

// Neutralize shortlink generation in API and functions
add_filter('pre_get_shortlink', '__return_empty_string', 999, 4);

// Ensure get_shortlink() always returns empty string
add_filter('get_shortlink', function ($shortlink, $id = 0, $context = '', $allow_slugs = false) {
    return '';
}, 999, 4);

// Strip only shortlink from HTTP "Link" header, preserve other Link entries
add_filter('wp_headers', function (array $headers) {
    // Exit early if no Link header exists
    if (!isset($headers['Link'])) {
        return $headers;
    }
    
    $value = $headers['Link'];
    
    // Parse multiple Link header entries (comma-separated)
    $parts = array_map('trim', explode(',', $value));
    
    // Filter out only shortlink entries, keep others (preload, DNS-prefetch, etc.)
    $filtered = array_values(array_filter($parts, function ($p) {
        return stripos($p, 'rel=shortlink') === false;
    }));
    
    // Rebuild Link header or remove if empty
    if (count($filtered) > 0) {
        $headers['Link'] = implode(', ', $filtered);
    } else {
        unset($headers['Link']);
    }
    
    return $headers;
}, 999);
