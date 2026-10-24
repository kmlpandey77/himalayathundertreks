---
name: Himalaya Thunder Treks
description: A calm, trustworthy trek-operator briefing board — glacier teal, signal orange, flat cards, no bluster.
colors:
  glacier-teal: "#2C9BBA"
  fjord-teal-deep: "#1D6377"
  signal-orange: "#F89222"
  basecamp-ink: "#0C1C1F"
  slate-text: "#333333"
  surface: "#FFFFFF"
  surface-muted: "#F1F1F1"
  page-bg: "#F8F8F8"
  border-hairline: "#DEDEDE"
typography:
  display:
    fontFamily: "Montserrat, sans-serif"
    fontSize: "clamp(1.5rem, 4vw, 2.5rem)"
    fontWeight: 400
    lineHeight: 1.1
  heading:
    fontFamily: "Montserrat, sans-serif"
    fontSize: "clamp(1.5rem, 3vw, 2rem)"
    fontWeight: 400
    lineHeight: 1.1
  eyebrow:
    fontFamily: "Poppins, sans-serif"
    fontSize: "clamp(1.25rem, 2vw, 1.75rem)"
    fontWeight: 600
    letterSpacing: "0.02em"
  body:
    fontFamily: "Poppins, sans-serif"
    fontSize: "16px"
    fontWeight: 400
    lineHeight: 1.7
rounded:
  none: "0"
  sm: "4px"
  pill: "200px"
  circle: "50%"
spacing:
  xs: "5px"
  sm: "15px"
  md: "20px"
  lg: "30px"
  xl: "60px"
components:
  button-primary:
    backgroundColor: "{colors.glacier-teal}"
    textColor: "#FFFFFF"
    rounded: "{rounded.sm}"
    padding: "0 40px"
  button-primary-hover:
    backgroundColor: "#46B4D3"
    textColor: "#FFFFFF"
  button-primary-active:
    backgroundColor: "#3895AF"
    textColor: "{colors.fjord-teal-deep}"
  button-secondary:
    backgroundColor: "{colors.signal-orange}"
    textColor: "#FFFFFF"
    rounded: "{rounded.sm}"
    padding: "0 40px"
  button-rounded:
    rounded: "{rounded.pill}"
  trip-card:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.slate-text}"
    rounded: "{rounded.none}"
---

# Design System: Himalaya Thunder Treks

## Overview

**Creative North Star: "The Basecamp Briefing"**

This is the look of a trek operator who has run the logistics a thousand times and wants you to feel that before you've even picked a route: a dark, factual strip up top stating the government registration number next to the reassurance ("your exciting Himalaya experience is in safe hands"), a calm glacier-teal identity running through links, chrome, and primary actions, and a single flag-orange used only where something needs a traveler's eyes — an icon, an active menu item, a price tag. Nothing about this system performs; it reports. Cards are flat rectangles with a whisper of shadow, not stacked paper or glossy tiles. Headings are set in a clean condensed sans at regular weight — never bold, never shouting — because the confidence here comes from specificity (altitude figures, duration, government reg. numbers, WhatsApp numbers with a real first name attached) rather than from typographic volume.

It is not a glossy destination-marketing site chasing emotion through full-bleed imagery; imagery supports the briefing, it doesn't replace it. The system was never designed to feel minimal for its own sake — it inherited a bootstrap-era pragmatism (Bootstrap 4 grid, Owl Carousel, SmartMenus) — but that pragmatism is the point: it reads as operationally credible rather than as a template.

**Key Characteristics:**
- Calm, cool, glacier-blue identity color rather than an "adventure" red/orange-dominant palette
- A single accent (signal orange) spent sparingly on icons and active states — never on large surfaces
- Flat, sharp-cornered cards and bars; roundness is reserved for pill/CTA buttons and circular controls
- Regular-weight (not bold) Montserrat headings paired with Poppins body text
- A persistent top strip carrying government registration and a trust tagline — credibility stated as fact, not as a badge graphic

## Colors

A cool, glacier-fed palette: teal carries the identity and every interactive default; orange is rationed to the handful of places a traveler's eye needs to land; everything else stays white, near-white, or near-black.

### Primary
- **Glacier Teal** (`#2C9BBA`): links, primary buttons, the desktop main-menu bar, the "more details" footer bar on trip cards. This is the color of the brand — used constantly but never heavily (text and 40px-tall button bars, not large flat fields except the nav bar itself).

### Secondary
- **Signal Orange** (`#F89222`): contact-icon color in the header, active/hovered main-menu links, the secondary CTA button, trip-fact icons. Reserved for things that should catch the eye mid-scan — never background fill.

### Neutral
- **Basecamp Ink** (`#0C1C1F`): the top utility bar background and section-title text. The closest this system gets to "dark mode" — used only for the thin trust strip and for heading text, never for large content panels.
- **Slate Text** (`#333333`): secondary body copy inside info panels (e.g. trip-facts lists).
- **Surface White** (`#FFFFFF`): card backgrounds, affiliation/payment badges, mobile nav background.
- **Surface Muted** (`#F1F1F1`): the fact-strip band under a trip card, generic muted section backgrounds.
- **Page Background** (`#F8F8F8`): the body background behind all content sections.
- **Hairline Border** (`#DEDEDE`): the thin rule separating trip-fact cells and framing card edges.

### Named Rules
**The One-Accent Rule.** Orange never fills a background larger than an icon or a button; its job is to mark the thing worth noticing, not to decorate. **The Teal-Never-Loud Rule.** Teal is the identity color precisely because it stays calm — it is never paired with saturated warm colors at equal weight, which is why orange is rationed instead of balanced against it.

## Typography

**Display/Heading Font:** Montserrat (with system sans-serif fallback)
**Body Font:** Poppins (with system sans-serif fallback)

**Character:** A plain, slightly condensed grotesque (Montserrat, always weight 400 — never bold) for anything that reads as a heading, paired with a geometric, friendly Poppins for everything a visitor actually reads. The pairing avoids typographic drama on purpose: specificity and fact density carry the page, not type weight.

### Hierarchy
- **Display** (400, `clamp(1.5rem, 4vw, 2.5rem)`, 1.1): The "Welcome to [Operator Name]" homepage hero line and other page-opening statements.
- **Heading** (400, `clamp(1.5rem, 3vw, 2rem)`, 1.1): Section titles ("Explore a Different Way of Travelling", "Featured holiday packages") and card titles (trip name at 24px).
- **Eyebrow** (600, `clamp(1.25rem, 2vw, 1.75rem)`, uppercase): The small label above a section title ("BEGIN YOUR ADVENTURE"), set in Poppins at 600 weight, uppercase, in a translucent gray — the one place this system uses letter-spacing and weight instead of size to signal hierarchy.
- **Body** (400, 16px, 1.7): Paragraph copy; justified by default on long-form text, centered inside centered content blocks. Package blurbs clamp to a short excerpt (`str_limit`) rather than running long.
- **Label** (300, 18px): Button copy, uppercase when the button is a link-styled CTA.

### Named Rules
**The No-Bold-Headings Rule.** Headings never go above weight 400. Hierarchy is built with size and the eyebrow label, not boldness.

## Layout

Bootstrap 4's 12-column grid and container system throughout, with content banded into alternating white and muted-gray full-width sections stacked vertically down the homepage (hero slider → welcome blurb → reviews/TripAdvisor → destinations → featured trips → blog). Each band is a `.container` centered on the page background.

**Header stack:** a dark 13px-text utility strip (tagline + government registration) sits above a `d-none d-sm-block` main header (logo + click-to-call/email/WhatsApp/Messenger/WeChat contact list), with a `sticky-top` main navigation bar beneath that stays pinned while scrolling. The main nav is white under 720px and switches to Glacier Teal at `≥720px` — a deliberate breakpoint swap, not a scroll-triggered state.

**Cards:** trip/package cards use a flex row (`d-md-flex`) with a fixed 200px image rail on desktop that collapses to a stacked full-width image on mobile — the same component, not a separate mobile layout.

Spacing runs on an informal scale rather than a strict system: 5px (tight icon/text gaps), 15–20px (card padding, list gaps), 30px (section gaps, card bottom margin), 60px (large section padding on desktop, halved on mobile).

## Elevation & Depth

Quiet-flat. Nothing in this system lifts off the page by default — section bands, headers, and the nav bar are all flat fills. The one surface that gets any lift is the trip card, and even there the shadow is barely perceptible (a soft, wide, very low-opacity ambient glow) paired with a thin hairline border doing most of the separation work. Depth here signals "this is a distinct card," not "this is important" — importance is signaled by the orange accent and copy, not by elevation.

### Shadow Vocabulary
- **Card Ambient** (`box-shadow: 0 0 10px rgba(0,0,0,0.08)`): the only elevation in the system, applied to trip/package cards alongside a 1px `#DEDEDE` border.

### Named Rules
**The Whisper-Shadow Rule.** If a shadow is added, it stays at or below `rgba(0,0,0,0.08)`. A card that announces its elevation is off-system.

## Shapes

A deliberate split: structural and content surfaces (cards, the fact-strip band, the nav dropdown, the top utility bar) stay sharp-cornered (`border-radius: 0`), while interactive call-to-action elements get rounded treatment — `4px` for the default "rounded" button and a full `200px` pill for primary CTAs ("View all", "Read More"). Circular treatment (`50%`) is reserved for small interactive controls: carousel prev/next arrows and modal close buttons. Borders, where used, are a single 1px hairline (`#DEDEDE`) — never thick, never colored, except the 2–3px colored outline on the "border-thick" ghost button variant.

### Named Rules
**The Content-Stays-Sharp Rule.** Anything that holds information (cards, bands, menus) is square-cornered. Roundness is earned only by things you click to act.

## Components

### Buttons
- **Shape:** sharp by default (`0`); `.button-rounded` applies `4px`; `.button-pill` applies a full `200px` pill. CTA links on the homepage ("View all") use the pill form.
- **Primary** (`.button-primary`): Glacier Teal background/border, white text, 40px line-height/height, `0 40px` padding, 18px/300-weight label text, uppercase when rendered as an `<a>`.
- **Secondary** (`.button-secondary-flat`): Signal Orange background/border, white text — same shape and sizing as primary, used where the orange accent needs to be the call-to-action itself (sparingly).
- **Primary Dark** (`.button-primarydark`): Fjord Teal Deep (`#1D6377`) background — a deeper-contrast variant of the primary button.
- **Hover / Active:** primary brightens to `#46B4D3` on hover/focus and deepens to `#3895AF` with teal text on active/pressed — a lighten-then-darken transition rather than a simple opacity shift.
- **Ghost / Border** (`.button-border-thick`): transparent background, 2–3px solid colored border, fills with a translucent tint of its color on hover.

### Cards (Trip/Package Card)
- **Corner Style:** sharp (`0`).
- **Background:** white, on the page's light-gray background — the contrast between `#F8F8F8` and `#FFFFFF` is itself the card boundary cue, reinforced by the hairline border.
- **Shadow Strategy:** Card Ambient (see Elevation).
- **Border:** 1px `#DEDEDE` hairline on all sides.
- **Internal Padding:** 20px around the text column; image rail is flush (no padding) so the photo bleeds to the card edge.
- **Distinctive behavior:** the fact strip at the bottom (duration, grade, price/altitude) sits in a muted-gray band (`#F1F1F1`) with orange icons, separated by hairline dividers between cells, capped by a teal "more info" footer bar — effectively three visually distinct zones stacked in one card (photo+title, facts, action).

### Navigation
- **Style:** `sticky-top` bar, white below 720px / Glacier Teal at 720px and up. Nav links are white text on the teal bar; dropdown menus use Fjord Teal Deep (`#1D6377`) background with white text and sharp corners; the active dropdown item gets a Signal Orange text treatment against a faint dark overlay.
- **Mobile:** collapses behind a standard Bootstrap toggler; logo and nav share the collapsed bar.

### Carousel Controls (Owl Carousel, used for hero slider and reviews)
- **Style:** circular (`50%`) buttons, translucent Fjord Teal fill (`rgba(29,99,119,0.6)`) with a solid Fjord Teal border, solidifying to full `#1D6377` on hover. This is the one place translucency appears in the system, always over imagery.

## Do's and Don'ts

### Do:
- **Do** keep orange confined to icons, active states, and at most one CTA per view — it is a pointer, not a fill color.
- **Do** keep headings at Montserrat weight 400; build emphasis with size and the uppercase eyebrow label instead of bold.
- **Do** pair sharp-cornered content surfaces with pill or circular interactive controls — don't round a card to match a button.
- **Do** keep card elevation at or below the Card Ambient shadow value; let the hairline border and background contrast do most of the separation work.
- **Do** carry the top utility strip's factual tone (registration numbers, direct phone lines with a first name) into any new trust-building surface — specificity is this brand's credibility mechanism, not badges or stock imagery.

### Don't:
- **Don't** introduce a second saturated accent color alongside Signal Orange — the system's calm comes from having exactly one "loud" color.
- **Don't** give structural surfaces (cards, bands, menus) rounded corners; that roundness vocabulary is reserved for buttons and circular controls.
- **Don't** bold headings or increase their weight for emphasis.
- **Don't** add drop shadows beyond the whisper-level Card Ambient value — nothing in this system should look like it's floating.
