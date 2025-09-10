<p align="center">
  <img alt="Thyra" src="resources/images/thyra-logo.svg" height="100">
</p>

<p align="center">
  <a href="https://packagist.org/packages/roots/sage"><img alt="Packagist Installs" src="https://img.shields.io/packagist/dt/roots/sage?label=projects%20created&colorB=2b3072&colorA=525ddc&style=flat-square"></a>
  <a href="https://github.com/roots/sage/actions/workflows/main.yml"><img alt="Build Status" src="https://img.shields.io/github/actions/workflow/status/roots/sage/main.yml?branch=main&logo=github&label=CI&style=flat-square"></a>
  <a href="https://bsky.app/profile/roots.dev"><img alt="Follow roots.dev on Bluesky" src="https://img.shields.io/badge/follow-@roots.dev-0085ff?logo=bluesky&style=flat-square"></a>
</p>

<h1 align="center">Thyra</h1>

**Minimalist editorial WordPress theme inspired by Thaiconomics design**

Built on Sage 11 with Laravel Blade, Tailwind CSS, and modern development workflow.

## 🎨 Design Philosophy

Thyra embodies the sophisticated minimalism of editorial publishing, drawing inspiration from the clean aesthetics of [Thaiconomics](https://thaiconomics.smtv.test). The theme focuses on:

- **Editorial Typography** — Helvetica Neue with carefully crafted type hierarchy
- **Magazine-Style Layout** — Asymmetric grids and generous whitespace  
- **Minimalist Aesthetic** — Black, white, and subtle grays color palette
- **Reading Experience** — Optimized for long-form content consumption
- **Mobile-First Design** — Responsive design that works beautifully on all devices

## 🚀 Features

- 🔧 **Modern PHP Architecture** — Laravel Blade templating with Acorn framework
- ⚡️ **Lightning Fast** — Vite build system with hot reload development
- 🎨 **Tailwind CSS** — Utility-first CSS framework with custom editorial design tokens
- 📱 **Responsive Design** — Mobile-first approach with perfect cross-device experience
- 📰 **Editorial Layout** — Magazine-style homepage with featured articles grid
- ✍️ **Typography Focus** — Optimized reading experience with proper type hierarchy
- 🔍 **SEO Optimized** — Clean semantic HTML structure
- 🎯 **Performance** — Minimal CSS footprint and optimized asset loading

## 📖 Architecture

Thyra is built on **Sage 11**, combining modern Laravel patterns with WordPress theme development:

- **Laravel Blade templates** for clean, maintainable templating
- **Roots Acorn** Laravel framework integration for WordPress
- **View Composers** for proper separation of data logic and presentation
- **PSR-4 autoloading** with Composer for organized PHP classes
- **Modern asset compilation** with Vite for optimal performance

### Key Technologies

- **PHP 8.2+** with Laravel patterns
- **Blade Templating** for clean, component-based views
- **Tailwind CSS** with custom editorial design system
- **Vite** for modern frontend build tooling
- **WordPress 6.6+** with full theme integration

## 🎯 Design Implementation

Based on comprehensive analysis of the [Thaiconomics design system](docs/DESIGN.md), Thyra implements:

### Homepage Layout
- **3-column magazine grid** for featured articles
- **Hero article section** with large imagery and excerpt
- **Clean navigation** with centered logo and minimal footer
- **Editorial spacing** with generous whitespace throughout

### Single Post Layout  
- **Large hero images** with centered presentation
- **Typography hierarchy** from hero titles to body text
- **Sidebar components** including subscribe box and author information
- **Reading-focused layout** with optimal line length and spacing

### Responsive Design
- **Mobile-first approach** with single-column mobile layout
- **Progressive enhancement** for tablet and desktop experiences
- **Touch-friendly navigation** with hamburger menu on mobile
- **Optimized typography** scaling across all device sizes

## 🛠️ Development

### Quick Start

```bash
# Install dependencies
composer install
npm install

# Start development server
npm run dev

# Build production assets
npm run build
```

### Development Commands

```bash
# Frontend development with hot reload
npm run dev

# Build production assets
npm run build

# Code formatting
./vendor/bin/pint

# Clear Blade template cache
wp acorn view:clear

# Generate View Composers
wp acorn make:composer ComposerName
```

### Local Development

For local development with Laravel Valet or similar:

```bash
# Test local site (HTTP recommended for development)
curl -i http://thyra.test

# Compare with reference design
node compare-sites.js
```

## 📂 File Structure

```
thyra/
├── app/                          # Theme functionality (PSR-4: App\)
│   ├── View/Composers/          # Data logic for Blade templates
│   ├── Providers/               # Service providers
│   ├── setup.php               # Theme setup and WordPress integration
│   └── filters.php             # WordPress filters and hooks
├── resources/
│   ├── views/                   # Blade templates (.blade.php)
│   │   ├── layouts/            # Base layout templates
│   │   ├── partials/           # Reusable template components
│   │   └── sections/           # Header, footer, navigation
│   ├── css/
│   │   ├── app.css             # Main styles with Tailwind
│   │   └── editor.css          # Block editor styles
│   └── js/
│       └── app.js              # Main JavaScript entry
├── public/build/                # Compiled assets (auto-generated)
└── docs/                        # Design system documentation
    └── DESIGN.md               # Complete Thaiconomics design analysis
```

## 🎨 Design System

### Typography
- **Primary Font**: Helvetica Neue (clean, editorial aesthetic)
- **Type Scale**: From 55px hero titles to 16px body text
- **Line Heights**: Optimized for readability (1.2 - 1.8)
- **Font Weights**: Light (300), Normal (400), Bold (700)

### Color Palette
- **Primary**: Black (#000000) for headings and navigation
- **Body Text**: Charcoal (#333333) for optimal readability  
- **Meta Text**: Gray (#666666) for dates and secondary info
- **Background**: White (#ffffff) with subtle off-white variants

### Spacing System
- **Editorial Spacing**: 80px between major sections
- **Article Spacing**: 40px between articles
- **Paragraph Spacing**: 24px between text blocks
- **Generous Whitespace**: Following magazine design principles

## 📚 Documentation

- **[Design System](docs/DESIGN.md)** — Complete Thaiconomics design analysis and implementation guide
- **[Development Guide](CLAUDE.md)** — Detailed development instructions and architecture
- **[Sage Documentation](https://roots.io/sage/docs/)** — Official Sage framework docs

## 🎯 Use Cases

Thyra is perfect for:

- **Editorial Publications** — Magazines, journals, news sites
- **Personal Blogs** — Writers and content creators focused on readability
- **Professional Portfolios** — Clean, minimal presentation of work
- **Corporate Blogs** — Companies wanting sophisticated, readable content presentation
- **Literary Sites** — Publishers and authors prioritizing typography and reading experience

## 🔧 Requirements

- **PHP**: 8.2+
- **WordPress**: 6.6+
- **Node.js**: 20.0+
- **Composer**: Latest version

## 🤝 Built With Sage

Thyra extends the powerful Sage starter theme framework:

- **Sage Framework** provides the modern WordPress development foundation
- **Laravel Integration** through Roots Acorn for advanced PHP patterns
- **Community Support** backed by the Roots ecosystem
- **Best Practices** following WordPress and Laravel conventions

---

**Thyra Theme** — Minimalist editorial design meets modern WordPress development.

Built with ❤️ using [Sage](https://roots.io/sage/) • Inspired by editorial excellence