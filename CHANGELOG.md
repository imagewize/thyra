# Changelog

All notable changes to the Thyra WordPress theme will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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