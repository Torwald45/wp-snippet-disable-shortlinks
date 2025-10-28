# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

## [1.0.0] - 2025-10-28

### Added
- Complete removal of WordPress shortlinks from all output locations
- Removes `<link rel="shortlink">` from HTML head section
- Removes shortlink from HTTP `Link:` response headers
- Disables `get_shortlink()` function calls (returns empty string)
- Disables `pre_get_shortlink` filter (prevents generation)
- Smart HTTP header filtering that preserves other Link entries (preload, DNS-prefetch, preconnect)
- Zero configuration required - works immediately after installation
- Lightweight implementation using WordPress filters and actions
- Unique prefixes (`torwald45_shortlink_`) for all identifiers to prevent conflicts
- Comprehensive documentation with installation methods and verification steps
