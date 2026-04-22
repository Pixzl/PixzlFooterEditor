# Contributing to Pixzl Footer Editor

Thanks for considering a contribution. This is a Shopware 6 platform plugin — the contribution workflow is "install into a real Shopware shop and click through it."

## Local development setup

You need a working Shopware 6 dev environment. The fastest path:

```sh
# 1. Symlink this repo into your Shopware install
cd /path/to/shopware/custom/plugins
ln -s /path/to/this/repo PixzlFooterEditor

# 2. Register and activate
cd /path/to/shopware
bin/console plugin:refresh
bin/console plugin:install --activate PixzlFooterEditor
bin/console cache:clear

# 3. After Twig / snippet edits — clear cache and reload
bin/console cache:clear

# 4. After config.xml edits — also re-register
bin/console plugin:update PixzlFooterEditor
bin/console cache:clear
```

The plugin runs against the host shop's vendored Shopware. Your local `composer install` is for IDE / static-analysis only.

## Pull requests

1. Open an issue first for anything beyond a typo. Saves both of us time.
2. One topic per PR. Diffs that touch templates, snippets and config in one go are hard to review.
3. **Add or update snippets in BOTH `de_DE` and `en_GB`** — Shopware logs warnings for missing keys.
4. Update `CHANGELOG.md` under a `## [Unreleased]` section.
5. Don't bump `composer.json` `version` — that happens at release time.

## Edit invariants

These rules are not optional. If you need to break one, open an issue first.

- **Never rename existing config keys.** All v1 keys (`PixzlFooterEditorActive`, `…Value`, `…TextColor`, `…LinkColor`, `…TextSize`, `…TextSizeVATNotice`, `…LogoActive`, `…LogoWidth`) are preserved across major versions for drop-in upgrades. New fields → new keys, additive.
- **Copyright text MUST stay HTML-escaped by default.** v2 fixed a stored XSS that v1 had via `|raw`. The opt-in toggle is `PixzlFooterEditorValueAllowHtml`. Do not regress.
- **Every CSS-bound config value passes through `| e('css')`. Every numeric size passes through `|abs`.** Both are CSS-injection / negative-value hardening.
- **Five named Twig sub-blocks are the public theme API:** `pixzl_footer_logo`, `pixzl_footer_social`, `pixzl_footer_copyright_text`, `pixzl_footer_payment_icons`, `pixzl_footer_shipping_icons`. Renaming or removing any of these breaks downstream themes that override them. Add new blocks freely; don't remove existing ones.
- **Snippet keys live under `pixzl-footer.*`** — never under a different namespace.

## Releasing (maintainers)

Version lives in **two places that must stay in sync**: `composer.json` `version` and the `[X.Y.Z]` heading in `CHANGELOG.md`.

1. Move `## [Unreleased]` to `## [X.Y.Z] - YYYY-MM-DD` in `CHANGELOG.md`
2. Bump `version` in `composer.json`
3. `git tag -a vX.Y.Z -m "vX.Y.Z — short note"`
4. `git push origin main vX.Y.Z`
5. `gh release create vX.Y.Z --notes-from-tag --latest`

Bumping the Shopware floor (`require.shopware/core`) is SemVer-major.
