# 📋 Project Tasks & Implementation Plan

## 🎯 Project Overview

Transform the Thyra WordPress theme into a minimalist editorial design inspired by Thaiconomics, using modern Sage architecture with Acorn, hybrid block editing (ACF Blocks + Native Blocks), and Tailwind CSS 4.

**Design Reference**: `https://thaiconomics.smtv.test`  
**Local Development**: `https://thyra.test`

---

## 🏗️ Architecture Stack

- **Framework**: Sage 11 + Laravel Acorn
- **Styling**: Tailwind CSS 4 with custom design tokens
- **Typography**: Helvetica Neue (locally hosted fonts)
- **Block Editor**: Hybrid approach - ACF Blocks + Native Blocks via [sage-native-block](https://github.com/imagewize/sage-native-block)
- **Templates**: Laravel Blade with View Composers

---

## 📅 Implementation Phases

### Phase 1: Foundation Setup ✅

#### 1.1 Typography & Font System ✅
- [x] **Download font files** from [Google WebFonts Helper](https://gwfh.mranftl.com/fonts)
  - [x] Lato Regular (400) - Primary Sans Serif
  - [x] Bitter Variable Font (100-900) - Display/Serif Font  
  - [x] Menlo Regular (400) - Monospace Font
- [x] **Add fonts to `resources/fonts/`**
  - [x] `lato-regular.woff2`
  - [x] `bitter-variable-font.woff2`
  - [x] `menlo-regular-webfont.woff2`
- [x] **Create `resources/css/fonts.css`**
- [x] **Import fonts in `app.css` and `editor.css`**
- [x] **Configure Tailwind 4 font variables**
- [x] **Streamlined to 3-font system** (removed Lora, Open Sans, FontAwesome)

#### 1.2 Tailwind 4 Design System ✅
- [x] **Update `resources/css/app.css` with Tailwind 4 `@theme`**
  - [x] Typography scale (28px-55px headlines)
  - [x] Color palette (black, charcoal, gray variants, white, off-white)
  - [x] Spacing system (generous whitespace)
  - [x] Custom CSS variables for editorial design
- [x] **Test Tailwind 4 compilation**
- [x] **Verify design tokens in browser**

#### 1.3 Image Size Configuration ✅
- [x] **Configure custom image sizes with `add_image_size()`**
  - [x] Homepage featured images (desktop: 350x525, 3 in a row grid layout)
  - [x] Single post featured image (desktop: 725x825, full-width with sidebar)
  - [x] Mobile featured images (both homepage & single: 350x568)
  - [x] Author profile images (desktop: 120x120, mobile: 80x80)
  - [x] Thumbnail fallbacks for cards/widgets (desktop: 300x200, mobile: 280x187)
- [x] **Add image sizes to `app/setup.php`**
- [x] **Test image generation and cropping**
- [x] **Verify performance impact and loading speed**

---

### Phase 2: Template Architecture ✅

#### 2.1 Core Template Files ✅
- [x] **Homepage (`resources/views/index.blade.php`)**
  - [x] 3-column magazine grid layout
  - [x] Featured story section (asymmetric layout)
  - [x] Mobile-responsive single column
  - [x] **Boxed/contained layout implementation**
- [x] **Front Page (`resources/views/front-page.blade.php`)**
  - [x] Static page template for users setting "Page" as homepage
- [x] **Single Post (`resources/views/single.blade.php`)**
  - [x] Hero image overlay layout
  - [x] Large typography (6xl headlines)
  - [x] Two-column content + sidebar
  - [x] Subscribe box and author info sidebar
  - [x] **Complete implementation with view composer**
- [x] **Page Template (`resources/views/page.blade.php`)**
  - [x] Complete implementation with view composer
- [x] **Category Archive (`resources/views/category.blade.php`)**
  - [x] Category-specific post grid
  - [x] Category header with title and description

#### 2.2 View Composers ✅
- [x] **Index composer** - Magazine-style data structure
- [x] **FrontPage composer** - Static page content integration
- [x] **Post composer** - Complete with subtitle, author, related posts, reading time
- [x] **Category composer** - Complete with pagination and related categories

---

### Phase 3: Block Editor Integration 🧩 ⭐

#### 3.1 Native Blocks Setup (Primary Approach) 🔄
- [x] **Install sage-native-block** - `composer require imagewize/sage-native-block --dev`
- [x] **Article Grid Block** - Native block implementation ✅
  - [x] Post count selection (1-12 posts)
  - [x] Query type options (recent, category, tag)
  - [x] Dynamic REST API integration with view.js
  - [x] Follows HTML pattern structure
- [ ] **Create additional native blocks**:
  - [ ] Hero Section Block (asymmetric grid layout)
  - [ ] Featured Article Block (large image + content layout)
  - [ ] Author Profile Block
  - [ ] Newsletter Subscribe Block
  - [ ] Quote/Blockquote Block (editorial style)
  - [ ] Call-to-Action Block
  - [ ] Image Gallery Block

#### 3.2 Block Development Strategy ✅
- **Primary Approach**: Native blocks for ALL blocks (flexible, customer-editable, dynamic content)
- **Dynamic Content**: view.js with WordPress REST API (no PHP render callbacks needed)
- **Registration**: Automatic via `app/setup.php` scanning `resources/js/blocks/`
- **ACF Blocks**: Exception only - when native blocks insufficient

---

### Phase 4: Component Development 🎨

#### 4.1 Header & Navigation ✅
- [x] **Update `resources/views/sections/header.blade.php`**
  - [x] Minimalist centered logo with underline accent
  - [x] Desktop layout: hamburger left, logo center, social right
  - [x] Mobile hamburger menu functionality
  - [x] Social icons (desktop only) - Using SVG icons
  - [x] Clean typography and spacing
- [x] **Mobile navigation implementation with Alpine.js**
- [x] **Responsive header behavior**
- [x] **Header title/logo styling fixes**
  - [x] Updated font size to 28px (text-2xl) using Lato font
  - [x] Removed text underline from H1 logo heading
  - [x] Enhanced border below logo (thicker and longer)
- [x] **Replace FontAwesome with Blade Icons**
  - [x] Install: `composer require blade-ui-kit/blade-icons`
  - [x] Remove FontAwesome font files and CSS
  - [x] Update social media icons to use Blade Icons or custom SVGs

#### 4.2 Footer
- [ ] **Update `resources/views/sections/footer.blade.php`**
  - [ ] Simple horizontal navigation
  - [ ] About / Work / Contact links
  - [ ] Copyright notice
  - [ ] Clean minimal styling

#### 4.3 Sidebar Components
- [ ] **Newsletter subscription form**
- [ ] **Author profile cards**
- [ ] **Related posts widget**
- [ ] **Category navigation**

---

### Phase 5: Content & Styling 💫

#### 5.1 Typography Implementation
- [ ] **Large editorial headlines** (30px desktop, 20px mobile)
- [ ] **Hero post titles** (55px desktop, 28px mobile)  
- [ ] **Body text optimization** (16px, 1.6 line-height)
- [ ] **Meta text styling** (14px, gray color)
- [ ] **Responsive typography scales**

#### 5.2 Layout Refinements
- [ ] **Generous whitespace implementation**
- [ ] **Image aspect ratios and cropping**
- [ ] **Grid system optimization**
- [ ] **Mobile-first responsive design**
- [ ] **Touch-friendly interfaces**

---

### Phase 6: Testing & Optimization 🔧

#### 6.1 Cross-Device Testing
- [ ] **Desktop layout verification**
- [ ] **Mobile responsiveness testing**
- [ ] **Tablet breakpoint optimization**
- [ ] **Touch interaction testing**

#### 6.2 Performance Optimization
- [ ] **Font loading optimization** (`font-display: swap`)
- [ ] **Image optimization and lazy loading**
- [ ] **CSS build optimization**
- [ ] **JavaScript bundle optimization**

#### 6.3 Content Testing
- [ ] **Create test posts** with various content types
- [ ] **Add sample featured images**
- [ ] **Test category organization**
- [ ] **Verify author profiles**

---

## 🛠️ Technical Implementation Notes

### Tailwind 4 Color Scheme
```css
@theme {
  /* Thaiconomics Editorial Palette */
  --color-black: #000000;
  --color-charcoal: #333333;
  --color-gray: #666666;
  --color-light-gray: #999999;
  --color-white: #ffffff;
  --color-off-white: #fafafa;
  
  /* Typography */
  --font-primary: "Lato", system-ui, sans-serif;
  --font-size-hero: 55px;
  --font-size-title: 30px;
  --font-size-subtitle: 24px;
  --font-size-body: 16px;
  --font-size-small: 14px;
}
```

### Font Implementation Checklist
1. ✅ Download from [Google WebFonts Helper](https://gwfh.mranftl.com/fonts) - Lato, Lora, Bitter, Open Sans
2. ✅ Add `.woff2` files to `resources/fonts/`
3. ✅ Create `resources/css/fonts.css` with `@font-face` declarations
4. ✅ Import in `app.css` and `editor.css`
5. ✅ Configure Tailwind 4 font variables

### Icon Implementation Strategy
- **Blade Icons**: Use `composer require blade-ui-kit/blade-icons` for modern SVG icons
- **Custom SVGs**: Create custom social media icons in `resources/images/icons/`
- **Remove FontAwesome**: Clean up font files and CSS declarations

### Block Editor Strategy
- **Native Blocks (Primary)**: All blocks use native WordPress blocks for maximum flexibility, customer editability, and modern development patterns
  - Dynamic content handled via view.js and WordPress REST API
  - Automatic registration via Sage Native Block package
  - CSS control resolves any layout conflicts
- **ACF Blocks (Exception Only)**: Use only when native blocks cannot meet requirements (extremely rigid admin control, complex server-side rendering)
- **Visual-First Workflow**: Start with block editor patterns, then convert to native blocks

---

## 📋 Template Hierarchy

```
resources/views/
├── layouts/
│   └── app.blade.php          # Main layout
├── index.blade.php            # Blog homepage
├── front-page.blade.php       # Static homepage
├── single.blade.php           # Single post
├── category.blade.php         # Category archive
├── sections/
│   ├── header.blade.php       # Site header
│   └── footer.blade.php       # Site footer
└── partials/
    ├── hero-section.blade.php
    ├── featured-articles.blade.php
    ├── newsletter-form.blade.php
    └── author-card.blade.php
```

---

## 🎯 Success Metrics

- ✅ **Visual Consistency**: Match Thaiconomics reference design
- ✅ **Mobile Responsiveness**: Perfect adaptation across all devices
- ✅ **Performance**: Fast loading times with local fonts
- ✅ **Editorial Experience**: Intuitive block editor workflow
- ✅ **Code Quality**: Clean Sage architecture with proper View Composers
- ✅ **Maintainability**: Well-documented, modular codebase

---

## 📚 Resources & References

- **Design Reference**: [Thaiconomics](https://thaiconomics.smtv.test)
- **Font Downloads**: [Google WebFonts Helper](https://gwfh.mranftl.com/fonts)
- **Block Development**: [Sage Native Block](https://github.com/imagewize/sage-native-block)
- **Tailwind 4 Docs**: [Tailwind CSS v4 Alpha](https://tailwindcss.com/docs)
- **Sage Documentation**: [Roots Sage](https://roots.io/sage/)

---

*Last Updated: September 10, 2025*  
*Project: Thyra WordPress Theme - Thaiconomics Editorial Design*