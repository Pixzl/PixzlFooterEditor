# Changelog

All notable changes to this project are documented here. The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2026-04-22

### Added
- Social media links in footer: Facebook, Instagram, LinkedIn, YouTube, TikTok, X, Pinterest
- Configurable social icon color, icon size, and optional heading
- Payment method icon row with 10 selectable methods (Visa, Mastercard, Amex, PayPal, Klarna, SEPA, Sofort, Apple Pay, Google Pay, Invoice)
- Shipping provider icon row with 7 selectable providers (DHL, DPD, UPS, Hermes, GLS, FedEx, Deutsche Post)
- Per sales-channel configuration support (via Shopware's native config scope selector)
- i18n snippets under `pixzl-footer.*` for `de-DE` and `en-GB`
- New Twig sub-blocks `pixzl_footer_logo`, `pixzl_footer_social`, `pixzl_footer_copyright_text`, `pixzl_footer_payment_icons`, `pixzl_footer_shipping_icons` for theme overrides
- `PixzlFooterEditorValueAllowHtml` opt-in toggle for HTML in the copyright line
- CHANGELOG.md and expanded README

### Fixed
- **Security (XSS):** copyright text is now HTML-escaped by default; `|raw` only applies when the new `PixzlFooterEditorValueAllowHtml` toggle is enabled
- CSS config values escaped via `| e('css')` to prevent CSS injection via the admin config
- Numeric size values clamped via `|abs` to prevent negative/invalid CSS values

### Changed
- Compatibility: now requires `shopware/core ^6.6` (was `6.5.*`) and PHP `^8.2`
- Version bumped to `2.0.0`
- Config form rearranged into three cards: *Settings*, *Social Media*, *Payment & Shipping Icons*
- Default color values normalised to six-digit hex (`#000000` / `#ffffff`)
- All existing v1 config keys preserved — upgrade is drop-in for shops with only default HTML in the copyright line

### Removed
- `required="true"` on fields that never should have been required (e.g. colors, font sizes fall back to sensible defaults now)

## [1.0.0] - 2023-06-14
- Initial release: configurable copyright line, text color, link color, font sizes, optional logo above copyright
