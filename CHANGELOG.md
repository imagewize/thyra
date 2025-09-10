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
  - Open Sans Regular (400) - Alternative Sans Serif
- Custom image size configuration for editorial layouts:
  - Homepage featured images (350x525 desktop, 3-column grid)
  - Single post featured images (725x825 desktop with sidebar)
  - Mobile featured images (350x568 responsive)
  - Author profile images (120x120 desktop, 80x80 mobile)
  - Thumbnail fallbacks (300x200 desktop, 280x187 mobile)
- Font loading optimization with `font-display: swap`
- Vite build system for modern asset compilation
- Laravel Blade templating system
- View Composer architecture for clean data separation
- PSR-4 autoloading with App namespace
- Service Provider pattern implementation

### Technical Implementation
- **Architecture**: Sage 11 + Laravel Acorn
- **Styling**: Tailwind CSS 4 with custom design tokens
- **Typography**: Helvetica Neue-inspired font stack with local hosting
- **Templates**: Laravel Blade with View Composers
- **Build System**: Vite with HMR support
- **Code Quality**: Laravel Pint formatter integration

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
- Site comparison testing with Playwright

### Configuration Files
- `theme.json` for WordPress theme configuration
- `vite.config.js` for build system setup
- `composer.json` for PHP dependencies
- `package.json` for Node.js dependencies
- `CLAUDE.md` for development documentation

### Project Structure
```
├── app/                    # Theme functionality (PHP classes)
│   ├── Providers/         # Laravel service providers
│   └── View/Composers/    # Blade view composers
├── resources/             # Source assets and templates
│   ├── css/              # Stylesheets and fonts
│   ├── js/               # JavaScript files
│   ├── fonts/            # Local font files
│   └── views/            # Blade templates
└── public/build/         # Compiled assets (auto-generated)
```

### Notes
- This is an alpha release focusing on foundation setup
- Theme is inspired by Thaiconomics editorial design
- Built for modern WordPress with block editor support
- Optimized for editorial and magazine-style content

### Upcoming
- Template development (Phase 2)
- Block editor integration (Phase 3)
- Component development (Phase 4)
- Content styling and layout refinements (Phase 5)
- Cross-device testing and optimization (Phase 6)