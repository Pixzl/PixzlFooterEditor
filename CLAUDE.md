# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A **Shopware 6 platform plugin** (composer type `shopware-platform-plugin`). All "logic" is declarative: a config schema that Shopware turns into an admin form, plus Twig templates that override the storefront footer. There is no application server, no JavaScript build, no test suite. The plugin is dropped into a host Shopware installation under `custom/plugins/PixzlFooterEditor/`.

## Build / install / test

There is **no build step, no lint, no automated tests**. The "test loop" is installing the plugin into a real Shopware shop:

```sh
cd /path/to/shopware/custom/plugins
ln -s /path/to/this/repo PixzlFooterEditor   # symlink for fast iteration
cd ..
bin/console plugin:refresh
bin/console plugin:install --activate PixzlFooterEditor
bin/console cache:clear
# After Twig/snippet edits:
bin/console cache:clear
# After config.xml edits:
bin/console plugin:update PixzlFooterEditor
```

`composer install` only installs the Shopware core requirement for IDE/static-analysis purposes — the plugin runs against the host shop's vendored Shopware, not its own.

## Repo layout

```
src/
├── PixzlFooterEditor.php                                    # Plugin class (extends Shopware\Core\Framework\Plugin)
└── Resources/
    ├── config/
    │   ├── config.xml                                       # Single source of truth for the admin form
    │   └── icon.jpg
    ├── snippet/{de_DE,en_GB}/
    │   ├── pixzl-footer.{de-DE,en-GB}.json                  # i18n strings under "pixzl-footer.*"
    │   └── SnippetFile_{de_DE,en_GB}.php                    # Snippet registration
    └── views/storefront/
        ├── base.html.twig
        └── layout/footer/footer.html.twig                   # Core override (the actual rendering)
```

## Architecture in one paragraph

`config.xml` declares every config field (text, color, size, multi-select). Shopware reads it, generates the **per-sales-channel admin form**, persists values into the system_config table, and exposes them in Twig via `config('PixzlFooterEditor.config.<key>')`. The plugin's `footer.html.twig` `sw_extends` Shopware's core footer and renders five named sub-blocks (`pixzl_footer_logo`, `pixzl_footer_social`, `pixzl_footer_copyright_text`, `pixzl_footer_payment_icons`, `pixzl_footer_shipping_icons`) — those are the public extension points for downstream themes. Snippet keys for every user-facing string live under `pixzl-footer.*` so themes can re-translate without touching Twig.

## Invariants when editing

- **Never rename existing config keys.** All v1 keys (`PixzlFooterEditorActive`, `…Value`, `…TextColor`, `…LinkColor`, `…TextSize`, `…TextSizeVATNotice`, `…LogoActive`, `…LogoWidth`) are preserved across major versions for drop-in upgrades. New fields → new keys, additive.
- **The copyright text MUST stay HTML-escaped by default.** v1 used `|raw` and shipped a stored XSS. v2 fixed it: `|raw` only fires when `PixzlFooterEditorValueAllowHtml` is true. Don't regress this.
- **Every CSS-bound config value passes through `| e('css')`**. Every numeric size passes through `|abs`. Both are CSS-injection / negative-value hardening — don't drop them in template edits.
- **Sales-channel scope is Shopware-native.** Don't re-implement it. Fields without an explicit override fall back to the "All Sales Channels" defaults automatically.
- **Five named sub-blocks are the public theme API.** Renaming or removing any of `pixzl_footer_logo`, `pixzl_footer_social`, `pixzl_footer_copyright_text`, `pixzl_footer_payment_icons`, `pixzl_footer_shipping_icons` breaks downstream themes that `sw_extends` and `{% block %}`-override them. Add new blocks freely; don't remove existing ones.
- **i18n parity.** Anything you add to `pixzl-footer.en-GB.json` must also exist in `pixzl-footer.de-DE.json` (and vice versa). Shopware logs warnings for missing keys.

## Versioning & releases

Version lives in **two places that must stay in sync**: `composer.json` `version` and the `[X.Y.Z]` heading in `CHANGELOG.md`. `extra.label` and `extra.description` in `composer.json` are what the Shopware Plugin Manager displays — keep them in sync with the README's positioning.

Compatibility constraint: `require.shopware/core: ^6.6` and `php: ^8.2`. Bumping the Shopware floor is SemVer-major because customers on the older minor will break.

Format: SemVer per [Keep a Changelog](https://keepachangelog.com/en/1.1.0/). Tag format: `vX.Y.Z`.

## Commit identity & remote

Commit history was rewritten via `git filter-repo` to use the GitHub no-reply email (`26158645+drieken@users.noreply.github.com`). **Do not author commits with `dominikrieken@icloud.com` or `drieken@pixzl.de`** — they leak personal contact info. If the global git config still has a personal email, override per-commit:

```sh
git -c user.email="26158645+drieken@users.noreply.github.com" commit …
```

The remote uses SSH (`git@github.com:Pixzl/PixzlFooterEditor.git`). HTTPS pushes fail because the OAuth token lacks the `workflow` scope.
