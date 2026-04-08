# WP Snippet: Disable WP Shortlinks Everywhere

Completely removes WP shortlinks from all output locations while preserving other HTTP Link headers.

## Features

- **Removes `<link rel="shortlink">` from HTML head** - Cleans up unnecessary meta tags
- **Removes HTTP `Link:` header with shortlink** - Eliminates shortlink from server response headers
- **Disables `get_shortlink()` and `pre_get_shortlink` functions** - Prevents shortlink generation in WP API
- **Smart filtering** - Preserves other Link headers like preload, DNS-prefetch, or preconnect
- **Zero configuration** - Works immediately after installation
- **Lightweight** - No database queries, no settings panel, pure PHP filters
- **Unique prefixes** - Uses `torwald45_shortlink_` namespace to prevent conflicts

## Why Disable Shortlinks?

WP shortlinks (e.g., `?p=123`) are enabled by default but rarely used. They add:
- Unnecessary HTML meta tags
- Extra HTTP headers
- **Exposed endpoint** - WP exposes shortlink functionality to the world (unlike static generators like Astro)
- Additional attack surface
- Bloat in your site's output

Removing shortlinks:
- Reduces HTML size
- Cleans up HTTP headers
- Removes unnecessary endpoint
- Simplifies your site's URL structure
## Requirements

- WP 5.0 or higher
- PHP 7.4 or higher

## Installation

### Method 1: functions.php

1. Open your theme's `functions.php` file
2. Copy the entire content from `disable-shortlinks.php`
3. Paste at the end of your `functions.php`
4. Save the file

### Method 2: Code Snippets Plugin

1. Install and activate the [Code Snippets](https://wordpress.org/plugins/code-snippets/) plugin
2. Go to Snippets → Add New
3. Copy content from `disable-shortlinks.php` **WITHOUT the opening `<?php` tag**
4. Paste into the Code field
5. Activate the snippet

## Usage

No configuration needed. Once installed, the snippet automatically:
1. Removes shortlinks from all pages
2. Blocks shortlink generation
3. Preserves other important Link headers

### Verification

Check if shortlinks are removed:

**1. View page source (Ctrl+U):**
```html
<!-- BEFORE: -->
<link rel='shortlink' href='https://example.com/?p=123' />

<!-- AFTER: -->
(link removed)
```

**2. Check HTTP headers:**
```bash
curl -I https://example.com/sample-page/

# BEFORE:
# Link: <https://example.com/?p=123>; rel=shortlink

# AFTER:
(header removed or shortlink entry removed)
```

## Technical Details

### WP Hooks Used
- `init` (priority 0) - Removes shortlink actions early
- `pre_get_shortlink` (priority 999) - Prevents shortlink generation
- `get_shortlink` (priority 999) - Returns empty string
- `wp_headers` (priority 999) - Filters HTTP Link header

### Actions Removed
- `wp_shortlink_wp_head` - Shortlink in HTML head
- `wp_shortlink_header` - Shortlink in HTTP headers

### Smart Filtering Logic
The snippet uses intelligent filtering on `wp_headers` to:
- Parse comma-separated Link header entries
- Remove only `rel=shortlink` entries
- Preserve other Link headers (preload, DNS-prefetch, preconnect)
- Remove entire Link header only if empty after filtering

## Compatibility

Tested with:
- WP 5.0 - 6.7+
- PHP 7.4 - 8.3
- Classic themes and block themes

**Known to work with:**
- Standard WP installations
- Multisite networks
- Custom post types

**Potential conflicts:** None known. Uses high priority (999) to ensure execution after other plugins.

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for version history.

## License

GPL v2 or later

## Author

[Torwald45](https://github.com/Torwald45)

## Support

For issues, questions, or contributions, please visit the [GitHub repository](https://github.com/Torwald45/wp-snippet-disable-shortlinks).
