<div align="center">
  <h1>Pixzl Footer Editor</h1>

  <p><strong>Own your Shopware 6 footer. Without touching a single line of Twig.</strong></p>

  <p>
    <a href="https://github.com/Pixzl/PixzlFooterEditor/releases"><img alt="Release" src="https://img.shields.io/github/v/release/Pixzl/PixzlFooterEditor?style=flat-square&color=189EFF"></a>
    <a href="https://shopware.com"><img alt="Shopware" src="https://img.shields.io/badge/Shopware-%5E6.6-189EFF?style=flat-square&logo=shopware&logoColor=white"></a>
    <a href="https://www.php.net"><img alt="PHP" src="https://img.shields.io/badge/PHP-%5E8.2-777BB4?style=flat-square&logo=php&logoColor=white"></a>
    <a href="#license"><img alt="License" src="https://img.shields.io/badge/License-MIT-2ecc71?style=flat-square"></a>
  </p>
</div>

---

## Why

Shopware's default footer is fine — until you want to change the copyright line. Or add your Instagram. Or show a row of payment logos. Suddenly you're in theme-override land: override `footer.html.twig`, remember the block name, escape the right variables, rebuild the theme, ship another release.

Pixzl Footer Editor keeps you out of that loop. **Every change is a config value. Every value is sales-channel-scoped. No theme rebuild, no code.**

---

## What's inside

| Area                       | What you get                                                                                   |
| -------------------------- | ---------------------------------------------------------------------------------------------- |
| **Copyright line**         | Toggle, text, text color, link color, font size — HTML opt-in with safe-by-default escaping   |
| **VAT notice**             | Independent font size control                                                                  |
| **Shop logo**              | Toggle to render the shop logo above the copyright, with a pixel-width control                 |
| **Social links**           | Facebook · Instagram · LinkedIn · YouTube · TikTok · X · Pinterest                             |
| **Social styling**         | Icon color, icon size, optional heading — icons ship from Bootstrap Icons in the Storefront    |
| **Payment badges**         | Visa · Mastercard · Amex · PayPal · Klarna · SEPA · Sofort · Apple Pay · Google Pay · Invoice  |
| **Shipping badges**        | DHL · DPD · UPS · Hermes · GLS · FedEx · Deutsche Post                                         |
| **Sales-channel scope**    | Every field configurable per sales channel via Shopware's native scope selector                |
| **i18n**                   | Full `de-DE` and `en-GB` snippet coverage under `pixzl-footer.*`                               |
| **Theme-friendly**         | Five named Twig sub-blocks for clean overrides from your own theme                             |
| **Secure by default**      | XSS-safe escaping, CSS injection hardening, validated numeric sizes                            |

---

## Install

### Via Shopware Store / Plugin Manager

1. Open your Shopware backend → **Extensions → My extensions**.
2. Search **Pixzl Footer Editor**.
3. Install, activate, configure.

### Manual (CLI)

```bash
cd custom/plugins
git clone https://github.com/Pixzl/PixzlFooterEditor.git
cd ..
bin/console plugin:refresh
bin/console plugin:install --activate PixzlFooterEditor
bin/console cache:clear
```

### Requirements

- Shopware `^6.6` — tested on 6.6 and 6.7
- PHP `^8.2`
- `shopware/storefront`

---

## Configure

Open **Extensions → My extensions → Pixzl Footer Editor → Configure**. The form is split into three cards:

1. **Settings** — copyright line, logo, typography
2. **Social Media** — per-network URLs, icon color, icon size, heading
3. **Payment & Shipping Icons** — multi-select badges and max icon height

### Per sales channel

Pick the sales channel in the selector at the top of the config page, then edit the fields you want to override. Untouched fields fall back to the **All Sales Channels** defaults. Want a German-only Instagram link but a global Facebook link? That's two clicks.

---

## Security

Pixzl Footer Editor v1 rendered the copyright line via Twig `|raw`. Any HTML in that field went to the storefront unescaped — a stored XSS if an attacker reached the admin config.

v2 escapes it by default. If you genuinely need HTML (a link, a `<br>`, a `<span>`), enable **Allow HTML in copyright text** explicitly — opt-in, documented, plain text stays the secure default.

On top of that, every CSS value piped from config is escaped via `| e('css')` and every numeric size is clamped with `|abs` — so a crafted negative font-size or an injected hex value with a newline can't break out of the `<style>` block.

---

## Theme it

The plugin's `layout_footer_copyright` override is split into five named sub-blocks so your theme can surgically override just the part it cares about:

```twig
{# Resources/views/storefront/layout/footer/footer.html.twig in your theme #}
{% sw_extends '@PixzlFooterEditor/storefront/layout/footer/footer.html.twig' %}

{% block pixzl_footer_payment_icons %}
    {# Replace the badge row with your own SVG grid #}
    <ul class="my-payment-grid">
        <li><img src="{{ asset('assets/visa.svg') }}" alt="Visa"></li>
        {# ... #}
    </ul>
{% endblock %}
```

**Available blocks**

| Block                             | Renders                                   |
| --------------------------------- | ----------------------------------------- |
| `pixzl_footer_logo`               | Shop logo above the copyright line        |
| `pixzl_footer_social`             | Social media icon row with optional heading |
| `pixzl_footer_copyright_text`     | Copyright paragraph                       |
| `pixzl_footer_payment_icons`      | Payment method badges                     |
| `pixzl_footer_shipping_icons`     | Shipping provider badges                  |

All user-facing strings (headings, aria-labels, badge text) resolve from snippet keys under `pixzl-footer.*` — override them in your theme for full control without touching PHP or Twig.

---

## Upgrading from 1.x

Drop-in. All v1 config keys are preserved (`PixzlFooterEditorActive`, `…Value`, `…TextColor`, `…LinkColor`, `…TextSize`, `…TextSizeVATNotice`, `…LogoActive`, `…LogoWidth`).

The one behavioural change is the XSS fix: if your v1 copyright text contained HTML and you want to keep it, enable **Allow HTML in copyright text** after upgrading. Plain-text copyright lines — the common case — need no action.

Full details in [CHANGELOG.md](CHANGELOG.md).

---

## Roadmap

- CMS block integration for full footer-column editing
- Newsletter signup form block
- 2–4 column footer layout preset
- Bundled SVG brand icons for payment & shipping

Got an idea? Open an issue.

---

## License

MIT — see [LICENSE](LICENSE).

Made with cold coffee by **[Pixzl](https://www.pixzl.de)**.
