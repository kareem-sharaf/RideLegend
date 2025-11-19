# Branding Guidelines
## Premium Bikes Managed Marketplace

**Version:** 1.0  
**Date:** 2024  
**Status:** Phase 1 - Discovery & Architecture

---

## Table of Contents

1. [Brand Identity](#1-brand-identity)
2. [Color Palette](#2-color-palette)
3. [Typography](#3-typography)
4. [Component Spacing & System](#4-component-spacing--system)
5. [Imagery Rules](#5-imagery-rules)
6. [Tailwind Design System Mapping](#6-tailwind-design-system-mapping)
7. [Brand Style Principles](#7-brand-style-principles)

---

## 1. Brand Identity

### 1.1 Brand Positioning
**Premium Bikes Managed Marketplace** is positioned as a trusted, high-quality platform for premium bicycle transactions. The brand conveys:

- **Trust**: Through certification and inspection processes
- **Quality**: Premium products and services
- **Expertise**: Professional workshops and knowledgeable sellers
- **Modern**: Clean, contemporary design aesthetic

### 1.2 Brand Personality
- **Professional**: Serious, reliable, trustworthy
- **Premium**: High-end, quality-focused
- **Approachable**: Friendly, helpful, accessible
- **Modern**: Contemporary, clean, minimalist

### 1.3 Target Audience
- Cycling enthusiasts
- Premium bike collectors
- Professional cyclists
- Bike shop owners
- Workshop professionals

---

## 2. Color Palette

### 2.1 Primary Colors

#### Primary Blue
- **Hex**: `#1E40AF` (Blue 800)
- **RGB**: `30, 64, 175`
- **Usage**: Primary CTAs, links, brand elements
- **Tailwind**: `blue-800`

#### Primary Blue Light
- **Hex**: `#3B82F6` (Blue 500)
- **RGB**: `59, 130, 246`
- **Usage**: Hover states, secondary CTAs
- **Tailwind**: `blue-500`

#### Primary Blue Dark
- **Hex**: `#1E3A8A` (Blue 900)
- **RGB**: `30, 58, 138`
- **Usage**: Dark mode, depth elements
- **Tailwind**: `blue-900`

### 2.2 Secondary Colors

#### Accent Green (Certification)
- **Hex**: `#10B981` (Emerald 500)
- **RGB**: `16, 185, 129`
- **Usage**: Certification badges, success states
- **Tailwind**: `emerald-500`

#### Accent Orange (Trade-in)
- **Hex**: `#F59E0B` (Amber 500)
- **RGB**: `245, 158, 11`
- **Usage**: Trade-in highlights, warnings
- **Tailwind**: `amber-500`

#### Accent Red (Alerts)
- **Hex**: `#EF4444` (Red 500)
- **RGB**: `239, 68, 68`
- **Usage**: Errors, destructive actions
- **Tailwind**: `red-500`

### 2.3 Neutral Colors

#### Gray Scale
- **Gray 50**: `#F9FAFB` - Backgrounds
- **Gray 100**: `#F3F4F6` - Light backgrounds
- **Gray 200**: `#E5E7EB` - Borders, dividers
- **Gray 300**: `#D1D5DB` - Disabled states
- **Gray 400**: `#9CA3AF` - Placeholder text
- **Gray 500**: `#6B7280` - Secondary text
- **Gray 600**: `#4B5563` - Body text
- **Gray 700**: `#374151` - Headings
- **Gray 800**: `#1F2937` - Dark text
- **Gray 900**: `#111827` - Primary text

### 2.4 Semantic Colors

#### Success
- **Background**: `#D1FAE5` (Emerald 100)
- **Text**: `#065F46` (Emerald 800)
- **Border**: `#10B981` (Emerald 500)

#### Warning
- **Background**: `#FEF3C7` (Amber 100)
- **Text**: `#92400E` (Amber 800)
- **Border**: `#F59E0B` (Amber 500)

#### Error
- **Background**: `#FEE2E2` (Red 100)
- **Text**: `#991B1B` (Red 800)
- **Border**: `#EF4444` (Red 500)

#### Info
- **Background**: `#DBEAFE` (Blue 100)
- **Text**: `#1E40AF` (Blue 800)
- **Border**: `#3B82F6` (Blue 500)

### 2.5 Color Usage Guidelines

#### Do's
- ✅ Use primary blue for main CTAs and brand elements
- ✅ Use accent green for certification-related elements
- ✅ Maintain sufficient contrast (WCAG AA minimum)
- ✅ Use semantic colors for feedback (success, error, warning)

#### Don'ts
- ❌ Don't use more than 3 colors in a single component
- ❌ Don't use primary colors for body text
- ❌ Don't use low-contrast color combinations
- ❌ Don't deviate from the defined palette

---

## 3. Typography

### 3.1 Font Families

#### Primary Font: Inter
- **Usage**: Body text, UI elements, general content
- **Weights**: 400 (Regular), 500 (Medium), 600 (SemiBold), 700 (Bold)
- **Fallback**: `system-ui, -apple-system, sans-serif`

#### Secondary Font: Playfair Display (Optional)
- **Usage**: Headlines, hero sections, premium branding
- **Weights**: 400 (Regular), 700 (Bold)
- **Fallback**: `serif`

### 3.2 Type Scale

#### Headings
- **H1**: `text-4xl` (36px) / `font-bold` / `leading-tight`
  - Usage: Page titles, hero headlines
- **H2**: `text-3xl` (30px) / `font-bold` / `leading-tight`
  - Usage: Section titles
- **H3**: `text-2xl` (24px) / `font-semibold` / `leading-snug`
  - Usage: Subsection titles
- **H4**: `text-xl` (20px) / `font-semibold` / `leading-snug`
  - Usage: Card titles, small section headers
- **H5**: `text-lg` (18px) / `font-medium` / `leading-normal`
  - Usage: Component titles
- **H6**: `text-base` (16px) / `font-medium` / `leading-normal`
  - Usage: Small headings

#### Body Text
- **Large**: `text-lg` (18px) / `font-normal` / `leading-relaxed`
  - Usage: Lead paragraphs, important content
- **Base**: `text-base` (16px) / `font-normal` / `leading-normal`
  - Usage: Standard body text
- **Small**: `text-sm` (14px) / `font-normal` / `leading-normal`
  - Usage: Secondary text, captions
- **Extra Small**: `text-xs` (12px) / `font-normal` / `leading-normal`
  - Usage: Labels, fine print

### 3.3 Typography Guidelines

#### Hierarchy
- Use clear visual hierarchy with size and weight
- Maintain consistent spacing between headings and content
- Limit to 3-4 heading levels per page

#### Readability
- Line height: Minimum 1.5 for body text
- Maximum line length: 75-85 characters
- Use appropriate font weights (avoid too many bold elements)

#### Responsive Typography
- Scale down on mobile (reduce by 1-2 sizes)
- Maintain readability at all screen sizes
- Use relative units (rem, em) for scalability

---

## 4. Component Spacing & System

### 4.1 Spacing Scale

Based on 4px base unit:

- **0**: `0px` - No spacing
- **1**: `4px` - `space-1` / `p-1` / `m-1`
- **2**: `8px` - `space-2` / `p-2` / `m-2`
- **3**: `12px` - `space-3` / `p-3` / `m-3`
- **4**: `16px` - `space-4` / `p-4` / `m-4` (Base unit)
- **5**: `20px` - `space-5` / `p-5` / `m-5`
- **6**: `24px` - `space-6` / `p-6` / `m-6`
- **8**: `32px` - `space-8` / `p-8` / `m-8`
- **10**: `40px` - `space-10` / `p-10` / `m-10`
- **12**: `48px` - `space-12` / `p-12` / `m-12`
- **16**: `64px` - `space-16` / `p-16` / `m-16`
- **20**: `80px` - `space-20` / `p-20` / `m-20`

### 4.2 Component Spacing Rules

#### Cards
- **Padding**: `p-6` (24px) default, `p-4` (16px) compact
- **Margin**: `mb-6` (24px) between cards
- **Gap**: `gap-4` (16px) in card grids

#### Forms
- **Field Spacing**: `mb-4` (16px) between fields
- **Label Spacing**: `mb-2` (8px) between label and input
- **Section Spacing**: `mb-8` (32px) between form sections

#### Buttons
- **Padding**: `px-6 py-3` (24px horizontal, 12px vertical)
- **Spacing**: `space-x-3` (12px) between button groups
- **Icon Spacing**: `ml-2` (8px) for icons after text

#### Navigation
- **Item Spacing**: `space-x-6` (24px) horizontal
- **Menu Spacing**: `py-2` (8px) vertical padding
- **Dropdown Spacing**: `p-2` (8px) padding

### 4.3 Layout Spacing

#### Container Padding
- **Mobile**: `px-4` (16px)
- **Tablet**: `px-6` (24px)
- **Desktop**: `px-8` (32px)

#### Section Spacing
- **Between Sections**: `py-12` (48px) or `py-16` (64px)
- **Within Sections**: `py-8` (32px)

#### Grid Gaps
- **Card Grids**: `gap-6` (24px)
- **Form Grids**: `gap-4` (16px)
- **Image Grids**: `gap-2` (8px)

---

## 5. Imagery Rules

### 5.1 Image Guidelines

#### Product Images
- **Aspect Ratio**: 16:9 or 4:3 (consistent across products)
- **Minimum Resolution**: 1200px width
- **Format**: WebP (preferred), JPEG, PNG
- **File Size**: Maximum 500KB per image
- **Background**: White or neutral (no busy backgrounds)
- **Lighting**: Consistent, professional lighting

#### Hero Images
- **Aspect Ratio**: 21:9 or 16:9
- **Resolution**: 1920px width minimum
- **Format**: WebP or JPEG
- **File Size**: Maximum 1MB
- **Content**: High-quality, premium bike imagery

#### Avatar Images
- **Size**: 40px × 40px (default), 80px × 80px (large)
- **Format**: Square, circular crop
- **Format**: WebP or JPEG
- **Fallback**: Initials or default avatar

### 5.2 Image Treatment

#### Product Cards
- **Border Radius**: `rounded-lg` (8px)
- **Shadow**: `shadow-md` on hover
- **Overlay**: Optional gradient overlay for text readability

#### Hero Images
- **Overlay**: Dark overlay (40-60% opacity) for text contrast
- **Parallax**: Optional parallax effect (subtle)

#### Certification Badges
- **Style**: Clean, minimal badge design
- **Color**: Green accent color
- **Icon**: Checkmark or certification icon

### 5.3 Image Optimization

#### Requirements
- All images must be optimized before upload
- Use responsive images (`srcset`)
- Lazy loading for below-fold images
- Alt text required for accessibility

#### Tools
- Image optimization: TinyPNG, ImageOptim
- Format conversion: cwebp for WebP
- Responsive images: Laravel responsive images helper

---

## 6. Tailwind Design System Mapping

### 6.1 Tailwind Configuration

```javascript
// tailwind.config.js
module.exports = {
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#EFF6FF',
          100: '#DBEAFE',
          500: '#3B82F6',
          800: '#1E40AF',
          900: '#1E3A8A',
        },
        accent: {
          green: '#10B981',
          orange: '#F59E0B',
          red: '#EF4444',
        },
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
        display: ['Playfair Display', 'serif'],
      },
      spacing: {
        // Custom spacing if needed
      },
      borderRadius: {
        'card': '8px',
        'button': '6px',
      },
      boxShadow: {
        'card': '0 1px 3px 0 rgba(0, 0, 0, 0.1)',
        'card-hover': '0 4px 6px -1px rgba(0, 0, 0, 0.1)',
      },
    },
  },
}
```

### 6.2 Component Classes

#### Buttons
```html
<!-- Primary Button -->
<button class="bg-primary-800 text-white px-6 py-3 rounded-button font-medium hover:bg-primary-900 transition-colors">
  Button Text
</button>

<!-- Secondary Button -->
<button class="bg-white text-primary-800 border-2 border-primary-800 px-6 py-3 rounded-button font-medium hover:bg-primary-50 transition-colors">
  Button Text
</button>
```

#### Cards
```html
<div class="bg-white rounded-card shadow-card p-6 hover:shadow-card-hover transition-shadow">
  <!-- Card Content -->
</div>
```

#### Badges
```html
<!-- Success Badge -->
<span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-medium">
  Certified
</span>

<!-- Status Badge -->
<span class="bg-primary-100 text-primary-800 px-3 py-1 rounded-full text-sm font-medium">
  Active
</span>
```

#### Forms
```html
<!-- Input -->
<input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">

<!-- Label -->
<label class="block text-sm font-medium text-gray-700 mb-2">
  Label Text
</label>
```

### 6.3 Utility Classes

#### Spacing Utilities
- `space-y-4`: Vertical spacing between children
- `space-x-4`: Horizontal spacing between children
- `gap-4`: Grid/flex gap

#### Typography Utilities
- `text-primary-800`: Primary text color
- `font-semibold`: Semi-bold weight
- `leading-tight`: Tight line height

#### Layout Utilities
- `container`: Centered container with max-width
- `mx-auto`: Center horizontally
- `flex items-center`: Flexbox centering

---

## 7. Brand Style Principles

### 7.1 Clean & Minimal

#### Principles
- **Whitespace**: Generous use of whitespace
- **Simplicity**: Avoid unnecessary decorative elements
- **Focus**: Clear visual hierarchy guides user attention
- **Clarity**: Every element serves a purpose

#### Implementation
- Use ample padding and margins
- Remove unnecessary borders and shadows
- Use subtle shadows for depth
- Maintain consistent alignment

### 7.2 Premium Aesthetic

#### Principles
- **Quality**: High-quality imagery and typography
- **Refinement**: Polished details and interactions
- **Sophistication**: Mature, professional design
- **Exclusivity**: Conveys premium positioning

#### Implementation
- Use high-resolution images
- Smooth transitions and animations
- Premium color palette
- Refined typography choices

### 7.3 Consistency

#### Principles
- **Uniformity**: Consistent component usage
- **Predictability**: Users know what to expect
- **Cohesion**: All elements work together
- **Standards**: Follow established patterns

#### Implementation
- Reusable component library
- Consistent spacing system
- Standardized color usage
- Uniform typography scale

### 7.4 Accessibility

#### Principles
- **WCAG 2.1 AA**: Minimum compliance
- **Contrast**: Sufficient color contrast
- **Readability**: Clear, legible text
- **Usability**: Accessible to all users

#### Implementation
- Color contrast ratios ≥ 4.5:1
- Keyboard navigation support
- Screen reader compatibility
- Focus indicators visible

### 7.5 Responsive Design

#### Principles
- **Mobile-First**: Design for mobile, enhance for desktop
- **Flexibility**: Adapts to all screen sizes
- **Performance**: Optimized for all devices
- **Usability**: Functional on all devices

#### Implementation
- Breakpoint-based layouts
- Flexible grid systems
- Responsive typography
- Touch-friendly targets (minimum 44px)

---

## Appendix A: Color Swatches

### A.1 Primary Palette
```
Primary Blue 800: #1E40AF
Primary Blue 500: #3B82F6
Primary Blue 900: #1E3A8A
```

### A.2 Accent Palette
```
Accent Green: #10B981
Accent Orange: #F59E0B
Accent Red: #EF4444
```

### A.3 Neutral Palette
```
Gray 50: #F9FAFB
Gray 100: #F3F4F6
Gray 200: #E5E7EB
Gray 500: #6B7280
Gray 700: #374151
Gray 900: #111827
```

---

## Appendix B: Typography Examples

### B.1 Heading Examples
```html
<h1 class="text-4xl font-bold text-gray-900">Main Heading</h1>
<h2 class="text-3xl font-bold text-gray-800">Section Title</h2>
<h3 class="text-2xl font-semibold text-gray-700">Subsection</h3>
```

### B.2 Body Text Examples
```html
<p class="text-base text-gray-600 leading-normal">Body text content</p>
<p class="text-sm text-gray-500">Secondary text</p>
<p class="text-xs text-gray-400">Fine print</p>
```

---

## Appendix C: Component Examples

### C.1 Button Variants
- Primary: Blue background, white text
- Secondary: White background, blue border and text
- Danger: Red background, white text
- Ghost: Transparent, colored text

### C.2 Card Variants
- Default: White background, subtle shadow
- Elevated: Stronger shadow, hover effect
- Outlined: Border instead of shadow

### C.3 Badge Variants
- Success: Green background
- Warning: Orange background
- Error: Red background
- Info: Blue background
- Neutral: Gray background

---

**Document Status**: Complete  
**Next Steps**: Proceed to DevOps + Clean Code Implementation Plan

