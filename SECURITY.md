# Security Policy

## Supported versions

| Version | Supported |
|---------|-----------|
| 2.x     | ✅ |
| 1.x     | ❌ — see CVE-style notice below |

## Known historical issue

Pixzl Footer Editor **v1.x** rendered the copyright line via Twig `|raw`. Any HTML in that field went to the storefront unescaped — a stored XSS path if an attacker reached the admin config (e.g. via a compromised admin account).

**v2.0.0 fixes this** by escaping the copyright text by default. HTML rendering is now opt-in via the `PixzlFooterEditorValueAllowHtml` toggle. v2 additionally hardens:

- All CSS values from config via `| e('css')` (CSS injection)
- All numeric size values via `|abs` (negative / NaN values that could break out of `<style>`)

If you are still on v1.x and your admin is shared across multiple users, **upgrade to v2.x**. The upgrade is drop-in for shops with plain-text copyright lines (the common case).

## Reporting a vulnerability

**Please do not open a public issue for security reports.**

Use GitHub's private vulnerability reporting:
**https://github.com/Pixzl/PixzlFooterEditor/security/advisories/new**

What to include:
- Affected version(s)
- A clear description of the issue and its impact
- A minimal repro (config values, sales-channel scope, request/response)
- Optional: a suggested patch

You can expect:
- Acknowledgement within **3 business days**
- A status update within **7 business days**
- A fix or a public response within **30 days** for storefront-affecting issues

## Scope

In scope:
- Stored XSS via any admin config field that flows into Twig
- CSS injection via config-controlled style attributes
- Twig `|raw` usage that bypasses the HTML opt-in toggle
- Snippet content that is rendered without escape and is admin-controllable

Out of scope:
- Issues requiring a Shopware admin account that is itself already compromised by an unrelated path
- Vulnerabilities in Shopware core or other plugins
- Findings that require modifying the plugin's PHP/Twig source on disk
