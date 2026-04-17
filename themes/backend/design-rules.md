# CRUDBooster Design Rules

Use these rules before reading the full backend HTML theme references.

## Visual Direction
- Clean enterprise admin UI with soft depth, not flat default Tailwind.
- Prefer calm surfaces, clear information hierarchy, and strong readability.
- Keep new backend/admin pages consistent with existing `themes/backend/` templates instead of inventing a new layout language.

## Typography
- Primary text: `Manrope`
- Display/headings: `Sora`
- Headings should feel compact, confident, and slightly denser than body text.

## Core Color Tokens
- `brand`: `#0f766e`
- `brand-soft`: `#d7f3ef`
- `brand-deep`: `#0b4f4a`
- `accent`: `#f97316`
- `accent-soft`: `#ffedd5`
- `ink`: `#172033`
- `ink-muted`: `#5b667a`
- `canvas`: `#f3f6f4`
- `canvas-soft`: `#fbfcfb`
- `line`: `#d7dde6`
- dark canvas: `#0d141b`
- dark panel: `#111b24`
- dark line: `#243140`

## Component Style
- Cards and panels should feel refined: rounded corners, subtle border, soft shadow.
- Use generous spacing; avoid cramped tables and dense forms.
- Inputs should look premium but restrained, with clear focus state using brand color.
- CTA buttons should use brand color; secondary actions should stay neutral.
- Empty states should feel designed, not placeholder-like.

## Layout Rules
- List/index pages: follow `themes/backend/light/grid.html` or `themes/backend/dark/grid.html`.
- Create/edit forms: follow `themes/backend/light/form.html` or `themes/backend/dark/form.html`.
- Shared tokens/components: follow `themes/backend/design-system.html`.
- Match the active theme mode from preview context whenever available.

## Do Not
- Do not switch to a random new color palette.
- Do not use default Bootstrap-looking tables/forms.
- Do not mix inconsistent copy style across the same page; keep labels clear and consistent in plain English.
- Do not create a different sidebar/menu pattern from the existing layout.
