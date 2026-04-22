## What does this PR do?

<!-- One or two sentences. The "why" matters more than the "what". -->

## Related issues

<!-- Closes #123 / Refs #456 -->

## Checklist

- [ ] Manually verified in a Shopware 6.6 (or 6.7) shop — `plugin:refresh` + `plugin:update` + cache clear
- [ ] If new config field: added to `config.xml`, both `de-DE` and `en-GB` `<label>`/`<helpText>` present
- [ ] If new user-facing string: snippet keys added under `pixzl-footer.*` in **both** `de_DE` and `en_GB`
- [ ] Twig output for any new config value passes through `| e`, `| e('css')`, `|abs`, or the existing escape pattern as appropriate
- [ ] If new public Twig block: name follows `pixzl_footer_*` convention
- [ ] CHANGELOG.md updated under `## [Unreleased]`

## Storefront screenshot

<!-- For visible changes, drop a screenshot of the rendered footer. -->
