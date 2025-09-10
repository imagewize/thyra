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

### Phase 1: Foundation Setup ⚡

#### 1.1 Typography & Font System
- [x] **Download font files** from [Google WebFonts Helper](https://gwfh.mranftl.com/fonts)
  - [x] Lato Regular (400) - Primary Sans Serif
  - [x] Lora Regular (400) - Serif Font
  - [x] Bitter Regular (400) - Display Font
  - [x] Open Sans Regular (400) - Alternative Sans Serif
  - [x] ~~FontAwesome - Icon Font~~ (to be replaced with Blade Icons)
- [x] **Add fonts to `resources/fonts/`**
  - [x] `lato-regular.woff2`
  - [x] `lora-regular.woff2`
  - [x] `bitter-regular.woff2`
  - [x] `opensans-regular.woff2`
  - [x] ~~`fontawesome-webfont.woff2`~~ (to be removed)
- [x] **Create `resources/css/fonts.css`**
- [x] **Import fonts in `app.css` and `editor.css`**
- [x] **Configure Tailwind 4 font variables**

#### 1.2 Tailwind 4 Design System
- [x] **Update `resources/css/app.css` with Tailwind 4 `@theme`**
  - [x] Typography scale (28px-55px headlines)
  - [x] Color palette (black, charcoal, gray variants, white, off-white)
  - [x] Spacing system (generous whitespace)
  - [x] Custom CSS variables for editorial design
- [x] **Test Tailwind 4 compilation**
- [x] **Verify design tokens in browser**

#### 1.3 Image Size Configuration
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

### Phase 2: Template Architecture 📄

#### 2.1 Core Template Files
- [ ] **Homepage (`resources/views/index.blade.php`)**
  - [ ] 3-column magazine grid layout
  - [ ] Featured story section (asymmetric layout)
  - [ ] Mobile-responsive single column
- [ ] **Front Page (`resources/views/front-page.blade.php`)**
  - [ ] Static page template for users setting "Page" as homepage
  - [ ] Inherit index design or custom static page layout
- [ ] **Single Post (`resources/views/single.blade.php`)**
  - [ ] Hero image centered layout
  - [ ] Large typography (55px headlines)
  - [ ] Two-column content + sidebar
  - [ ] Subscribe box and author info sidebar
- [ ] **Category Archive (`resources/views/category.blade.php`)**
  - [ ] Similar to homepage layout
  - [ ] Category-specific post grid
  - [ ] Category header with title and description

#### 2.2 View Composers
- [ ] **Update `app/View/Composers/Index.php`**
  - [ ] Featured posts (6 posts with thumbnails)
  - [ ] Magazine-style data structure
- [ ] **Create `app/View/Composers/FrontPage.php`**
  - [ ] Static page content + optional blog section
- [ ] **Update `app/View/Composers/Post.php`**
  - [ ] Subtitle handling
  - [ ] Author information enhancement
  - [ ] Related posts logic
- [ ] **Create `app/View/Composers/Category.php`**
  - [ ] Category-specific posts
  - [ ] Category information and meta
  - [ ] Pagination handling

---

### Phase 3: Block Editor Integration 🧩

#### 3.1 ACF Blocks Setup (Rigid, Admin-Controlled Blocks)
- [ ] **Install ACF Pro and ACF Composer**
- [ ] **Create rigid editorial ACF Blocks** (blocks customers should not customize much):
  - [ ] Hero Section Block
  - [ ] Featured Articles Block  
  - [ ] Author Profile Block
  - [ ] Newsletter Subscribe Block
  - [ ] Quote/Blockquote Block (editorial style)
- [ ] **Configure ACF Block templates with ACF Composer**
- [ ] **Style blocks to match Thaiconomics design**

#### 3.2 Native Blocks Integration (Flexible, Customer-Editable Blocks)
- [ ] **Install sage-native-block for JS/React blocks** - `composer require imagewize/sage-native-block --dev`

**Important Note**: Use Sage Native Block only for blocks that need full editor flexibility without CSS flex ordering conflicts. If CSS uses flex order properties to rearrange layouts, editor changes can conflict with the styling.

---

### Phase 4: Component Development 🎨

#### 4.1 Header & Navigation
- [ ] **Update `resources/views/sections/header.blade.php`**
  - [ ] Minimalist centered logo
  - [ ] Mobile hamburger menu
  - [ ] Social icons (desktop only) - Use Blade Icons or custom SVGs
  - [ ] Clean underline accent
- [ ] **Mobile navigation implementation**
- [ ] **Responsive header behavior**
- [ ] **Replace FontAwesome with Blade Icons**
  - [ ] Install: `composer require blade-ui-kit/blade-icons`
  - [ ] Remove FontAwesome font files and CSS
  - [ ] Update social media icons to use Blade Icons or custom SVGs

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
- **ACF Blocks**: Rigid, admin-controlled editorial components (hero sections, featured articles) - customers should not customize much
- **Native Blocks**: Flexible, customer-editable content blocks (paragraphs, headings, images, galleries) - fully editable like WordPress native blocks
- **Hybrid Workflow**: Editors can mix and match block types seamlessly

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