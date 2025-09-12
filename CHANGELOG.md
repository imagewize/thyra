## [1.0.0-alpha.5] - 2025-09-12

### Added
- Native Block Development infrastructure with Sage Native Block package
- Article Grid Block implementation for editorial layouts
- Menlo monospace font integration for code/technical content
- Enhanced development workflow documentation and guidelines
- HTML pattern examples for block development reference
- Comprehensive block development workflow in CLAUDE.md

### Changed
- **Font System Overhaul**: Streamlined from 3-font to 2-font system (Lato + Bitter)
- **Typography Optimization**: Removed Lora serif font in favor of Bitter variable font
- **Development Documentation**: Enhanced CLAUDE.md with Native Block vs ACF Block guidance
- **Header Navigation**: Simplified hamburger menu implementation and mobile navigation
- **Block Development**: Added preferred Native Block workflow over ACF Composer

### Improved
- **Font Loading Performance**: Optimized font files and reduced bundle size
- **Block Editor Integration**: Complete Native Block system with editor.js compilation
- **Mobile Navigation**: Enhanced hamburger menu with better touch interactions
- **Code Quality**: Updated development guidelines and architectural documentation
- **Asset Management**: Improved font file organization and loading strategy

### Technical Implementation  
- Sage Native Block package integration via Composer
- Article Grid Block with React/JSX editor components
- Menlo webfont for monospace typography needs
- Enhanced Vite configuration for block compilation
- Mobile-first navigation improvements with Alpine.js

### Dependencies
- Added `imagewize/sage-native-block` package for modern block development
- Optimized font assets (removed Lora, streamlined Bitter integration)
- Enhanced block editor JavaScript compilation pipeline

---

## [1.0.0-alpha.4] - 2025-09-11

### Added
- Minimalist header implementation with Thaiconomics editorial design
- Blade Icons integration for modern SVG icons (replaced FontAwesome)
- Mobile-first navigation with hamburger menu and responsive design
- Simple footer with horizontal navigation (About / Work / Contact)
- Centered logo with clean underline accent in header
- Mobile navigation menu with slide animations

### Changed  
- **Complete Header Redesign**: From complex sticky header with multiple CTAs to clean, editorial-style centered logo design
- **Footer Simplification**: From multi-column widget footer to simple horizontal navigation
- **Navigation Philosophy**: Minimalist approach following Thaiconomics design principles
- **Social Icons**: Replaced FontAwesome font icons with inline SVG icons for better performance
- **Mobile Experience**: Improved touch-friendly navigation and responsive spacing

### Improved
- **Typography Integration**: Proper use of `font-primary` (Lato) throughout header and footer
- **Performance**: Eliminated FontAwesome dependency, using lightweight SVG icons instead  
- **Responsive Design**: Mobile-first approach with desktop enhancements
- **Accessibility**: Added proper ARIA labels for social media icons
- **Code Quality**: Clean Blade templates following Sage conventions

### Technical Implementation
- Blade Icons package installed via Composer for SVG icon management
- Alpine.js event system for mobile menu toggling
- Responsive utility classes with mobile/desktop breakpoints
- Clean separation of mobile and desktop navigation patterns

### Dependencies
- Added `blade-ui-kit/blade-icons` package for modern SVG icon management
- Removed FontAwesome dependency from theme assets

---

## [1.0.0-alpha.3] - 2025-09-11

### Added
- Hero Section ACF Block scaffolded with ACF Composer (fields: headline, subheadline, background image, CTA text, CTA URL, accent color, overlay opacity)
- ACF Composer installed for block development
- Advanced Custom Fields Pro plugin installed and activated
- Added `docs/roots-docs/sage/` folder with official Roots Sage documentation for reference and best practices

### Changed
- Updated documentation files (`CLAUDE.md`, `.github/copilot-instructions.md`) to reference Sage docs folder and reinforce Sage conventions

### Technical Implementation
- Hero Section block fields defined in `app/Fields/HeroSection.php`
- Block scaffolded in `app/Blocks/HeroSection.php` and `resources/views/blocks/hero-section.blade.php`
- ACF Composer and ACF Pro integration confirmed

---

# Changelog

All notable changes to the Thyra WordPress theme will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0-alpha.2] - 2025-09-10

### Added
- **Complete Template Architecture Implementation (Phase 2)**
  - Magazine-style homepage with 3-column grid layout and featured story hero section
  - Static front page template with optional blog section integration
  - Editorial single post template with full-width hero images and large typography (55px headlines)
  - Category archive template with magazine-style layout and category header
  
- **Enhanced View Composers**
  - Updated Index composer for magazine-style data structure (1 featured + 6 grid posts)
  - New FrontPage composer for static page content with blog integration
  - Enhanced Post composer with subtitle handling, author profiles, reading time calculation, and related posts
  - New Category composer with pagination, related categories, and post count management
  
- **Editorial Features**
  - Automatic reading time calculation and display
  - Enhanced author profiles with bio, avatar, and post count
  - Related posts based on category matching
  - Newsletter subscription forms in sidebar and sections
  - Post tags and category navigation
  - Responsive typography scaling (4xl-6xl hero headlines)
  
- **Template Enhancements**
  - Hero image overlays with gradient backgrounds
  - Two-column content layout with sidebar on single posts
  - Mobile-responsive single column layouts
  - Category-specific post filtering and navigation
  - Pagination support for archives

### Improved
- **Magazine Layout System**
  - Asymmetric featured story section with 4:5 aspect ratio images
  - Clean 3-column desktop grid with single column mobile fallback
  - Editorial typography with serif headlines and sans-serif body text
  - Generous whitespace implementation following Thaiconomics design
  
- **WordPress Integration**
  - Proper template hierarchy following Sage conventions
  - Custom field support for subtitles (ACF compatible)
  - WordPress pagination and navigation systems
  - Category and tag taxonomy integration
  - Comment system integration

### Technical Implementation
- **View Composer Architecture**: Clean data separation with dedicated composers for each template
- **Responsive Design**: Mobile-first approach with desktop enhancements
- **Performance**: Optimized image loading with custom size configurations
- **Code Quality**: Following Sage/Laravel conventions with PSR-4 autoloading

## [1.0.0-alpha] - 2025-09-10

### Added
- Initial theme setup with Sage 11 architecture
- Laravel Acorn framework integration
- Tailwind CSS 4 configuration with custom design tokens
- Typography system with locally hosted fonts:
  - Lato Regular (400) - Primary Sans Serif
  - Lora Regular (400) - Serif Font  
  - Bitter Regular (400) - Display Font
- Custom image size configuration for editorial layouts:
  - Homepage featured images (350x525 desktop, 3-column grid)
  - Single post featured images (725x825 desktop with sidebar)
  - Mobile featured images (350x568 responsive)
  - Author profile images (120x120 desktop, 80x80 mobile)
- Font loading optimization with `font-display: swap`
- Vite build system for modern asset compilation
- Laravel Blade templating system
- View Composer architecture for clean data separation
- PSR-4 autoloading with App namespace

### Technical Implementation
- **Architecture**: Sage 11 + Laravel Acorn
- **Styling**: Tailwind CSS 4 with custom design tokens
- **Typography**: Helvetica Neue-inspired font stack with local hosting
- **Templates**: Laravel Blade with View Composers
- **Build System**: Vite with HMR support

### Design System
- Editorial color palette (black, charcoal, gray variants, white, off-white)
- Typography scale optimized for readability (28px-55px headlines)
- Generous whitespace implementation
- Mobile-first responsive design approach
- Magazine-style layout foundation
### Development Workflow
- Hot module replacement with `npm run dev`
- Production builds with `npm run build`
- Code formatting with `./vendor/bin/pint`
- Translation support with pot/po/mo workflow

### Configuration Files
- `theme.json` for WordPress theme configuration
- `vite.config.js` for build system setup
- `composer.json` for PHP dependencies
- `package.json` for Node.js dependencies
- `CLAUDE.md` for development documentation
│   ├── Providers/         # Laravel service providers
│   └── View/Composers/    # Blade view composers
├── resources/             # Source assets and templates
└── public/build/         # Compiled assets (auto-generated)
```
### Notes
- This is an alpha release focusing on foundation setup

- Template development (Phase 2)
- Block editor integration (Phase 3)
- Component development (Phase 4)
- Content styling and layout refinements (Phase 5)
- Cross-device testing and optimization (Phase 6)