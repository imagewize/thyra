# NON-SASS MIGRATION: T3CH Theme to Sage 11 with Tailwind CSS

## Overview

This document outlines the migration plan to convert blocks from the T3CH theme to ACF Composer blocks in the Sage 11 theme, keeping the existing Tailwind CSS setup and converting SCSS to regular CSS with Tailwind utilities.

## Migration Strategy: SCSS to Tailwind CSS

Instead of maintaining the complex SCSS system from T3CH, we'll convert blocks to use Tailwind CSS utilities while preserving the visual design and functionality.

### Why This Approach?

- ✅ **Keep existing Sage 11 + Tailwind setup** - No build system changes needed
- ✅ **Leverage Tailwind utilities** - Use existing color palette and spacing scale
- ✅ **Simplified maintenance** - No SCSS compilation or variable management
- ✅ **Better performance** - Tailwind's purging removes unused CSS
- ✅ **Design consistency** - Use Tailwind's design tokens throughout

## Phase 1: Setup ACF Composer

### 1.1 Install ACF Composer

```bash
# Install ACF Composer for block development
composer require log1x/acf-composer

# Verify installation
wp acorn list | grep make:block
```

### 1.2 Register Custom Block Categories

**File:** `app/setup.php` (add to existing file)

```php
/**
 * Register custom block categories for Thyra theme
 */
add_filter('block_categories_all', function ($categories) {
    return array_merge($categories, [
        [
            'slug'  => 'thyra-expertise',
            'title' => 'Thyra Expertise Blocks',
            'icon'  => 'star-filled',
        ],
        [
            'slug'  => 'thyra-general',
            'title' => 'Thyra General Blocks',
            'icon'  => 'admin-customizer',
        ],
        [
            'slug'  => 'thyra-home',
            'title' => 'Thyra Home Blocks',
            'icon'  => 'admin-home',
        ],
    ]);
});
```

## Phase 2: Convert T3CH Variables to Tailwind

### 2.1 Color Mapping: SCSS to Tailwind

From the T3CH `_variables.scss`, we'll map colors to Tailwind's existing palette:

**T3CH Colors → Tailwind Equivalents:**

```scss
// T3CH → Tailwind CSS equivalent
$brand-blue-50: #f0f8ff;     → bg-blue-50
$brand-blue-600: #0295DA;    → bg-blue-500 (custom)
$brand-darkblue-950: #00283C; → bg-slate-900 (custom)
$brand-orange-600: #d97d00;  → bg-orange-500 (custom)
$basic-light-50: #fff;       → bg-white
$basic-gray-300: #d1d1d1;    → bg-gray-300
$basic-gray-600: #333;       → bg-gray-700
```

### 2.2 Add Custom Colors to Tailwind Theme

**File:** `resources/css/app.css`

Add these custom colors to your existing `@theme` block:

```css
@theme {
  /* Existing Thyra colors... */

  /* T3CH Brand Colors */
  --color-t3ch-blue: #0295DA;        /* Primary brand blue */
  --color-t3ch-darkblue: #00283C;    /* Dark background blue */
  --color-t3ch-orange: #d97d00;      /* CTA orange */
  --color-t3ch-lightblue: #f0f8ff;   /* Light blue backgrounds */
}
```

### 2.3 Spacing Mapping: SCSS to Tailwind

```scss
// T3CH → Tailwind equivalent
$spacing-xs: 8px;      → space-2 (8px)
$spacing-sm: 16px;     → space-4 (16px)
$spacing-md: 24px;     → space-6 (24px)
$spacing-lg: 32px;     → space-8 (32px)
$spacing-xl: 48px;     → space-12 (48px)
$spacing-xxl: 64px;    → space-16 (64px)
$spacing-xxxl: 80px;   → space-20 (80px)
```

### 2.4 Typography Mapping

```scss
// T3CH → Tailwind equivalent
$font-size-md: 15px;   → text-base (16px) or text-sm (14px)
$font-size-lg: 16px;   → text-base (16px)
$font-size-xl: 18px;   → text-lg (18px)
$font-size-2xl: 19px;  → text-xl (20px)
$font-size-5xl: 24px;  → text-2xl (24px)
$font-size-12xl: 48px; → text-5xl (48px)
```

## Phase 3: Block Migration Process

### 3.1 Example: Expertise Detail Advantages Block

**Step 1: Generate ACF Composer Block**

```bash
wp acorn make:block ExpertiseDetailAdvantages
wp acorn make:field ExpertiseDetailAdvantages
```

**Step 2: Block Registration**

**File:** `app/Blocks/ExpertiseDetailAdvantages.php`

```php
<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;

class ExpertiseDetailAdvantages extends Block
{
    public $name = 'Expertise Detail Advantages';
    public $description = 'Content section highlighting key benefits/advantages of a service with checkmark-style list items.';
    public $category = 'thyra-expertise';
    public $icon = 'yes-alt';
    public $keywords = ['expertise', 'advantages', 'benefits', 'checkmark'];
    public $supports = [
        'align' => false,
        'mode' => false,
        'jsx' => true,
        'anchor' => true,
    ];

    public function fields()
    {
        return $this->get('ExpertiseDetailAdvantages');
    }
}
```

**Step 3: ACF Fields Definition**

**File:** `app/Fields/ExpertiseDetailAdvantages.php`

```php
<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class ExpertiseDetailAdvantages extends Field
{
    public function fields()
    {
        $advantages = Builder::make('expertise_detail_advantages');

        $advantages
            ->addText('advantages_pill_text', [
                'label' => 'Pill Text',
                'default_value' => 'Voordelen',
                'instructions' => 'Text for the blue pill tag (e.g., "Voordelen")'
            ])
            ->addText('advantages_main_title', [
                'label' => 'Main Title',
                'default_value' => 'Wat levert Scan to BIM voor je op',
                'instructions' => 'Main section heading'
            ])
            ->addTextarea('advantages_description', [
                'label' => 'Description',
                'default_value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
                'instructions' => 'Description text below the main title'
            ])
            ->addRepeater('advantages_list', [
                'label' => 'Advantages List',
                'min' => 1,
                'max' => 6,
                'layout' => 'block',
                'button_label' => 'Add Advantage'
            ])
                ->addText('title', [
                    'label' => 'Advantage Title',
                    'required' => 1
                ])
                ->addTextarea('description', [
                    'label' => 'Advantage Description',
                    'required' => 1
                ])
                ->addSelect('icon_type', [
                    'label' => 'Icon Type',
                    'choices' => [
                        'checkmark' => 'Checkmark',
                        'star' => 'Star',
                        'arrow' => 'Arrow'
                    ],
                    'default_value' => 'checkmark'
                ])
            ->endRepeater();

        return $advantages->build();
    }
}
```

**Step 4: Blade Template with Tailwind CSS**

**File:** `resources/views/blocks/expertise-detail-advantages.blade.php`

```php
{{-- Expertise Detail Advantages Block --}}
@php
  $pill_text = get_field('advantages_pill_text') ?: 'Voordelen';
  $main_title = get_field('advantages_main_title') ?: 'Wat levert Scan to BIM voor je op';
  $description = get_field('advantages_description') ?: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...';
  $advantages = get_field('advantages_list') ?: [];

  // Default advantages if none are set
  if (empty($advantages)) {
      $advantages = [
          [
              'title' => 'Actueel en compleet inzicht',
              'description' => 'Je krijgt een nauwkeurig digitaal 3D-model van de bestaande situatie — ideaal voor planning, beheer en onderhoud.',
              'icon_type' => 'checkmark'
          ],
          [
              'title' => 'Minder fouten en faalkosten',
              'description' => 'Door afwijkingen vroegtidig te detecteren, voorkom je verrassingen tijdens uitvoering en bespaar je op correcties achteraf.',
              'icon_type' => 'checkmark'
          ],
          [
              'title' => 'Snellere en slimmere besluitvorming',
              'description' => 'Door afwijkingen vroegtidig te detecteren, voorkom je verrassingen tijdens uitvoering en bespaar je op correcties achteraf.',
              'icon_type' => 'checkmark'
          ]
      ];
  }
@endphp

<section id="voordelen" class="bg-allinq-darkblue text-white py-20 {{ $block['className'] ?? '' }}">
    @if (is_admin())
        <div class="bg-gray-100 p-4 mb-5 border-l-4 border-blue-600">
            <strong>Expertise Detail Advantages Block</strong>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header Section: Two-Column Layout --}}
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-12 mb-16">
            {{-- Left Column: CTA Pill Tag --}}
            <div class="lg:w-60 flex-shrink-0">
                <div class="bg-allinq-blue text-white px-6 py-3 rounded-full text-sm font-medium inline-block">
                    {{ $pill_text }}
                </div>
            </div>

            {{-- Right Column: Title and Description --}}
            <div class="flex-1">
                <h2 class="text-2xl lg:text-3xl font-semibold mb-6 leading-tight">
                    {{ $main_title }}
                </h2>
                <p class="text-base lg:text-lg leading-relaxed opacity-90">
                    {{ $description }}
                </p>
            </div>
        </div>

        {{-- Advantages List Section --}}
        <div class="space-y-8">
            @if (!empty($advantages))
                @foreach ($advantages as $index => $advantage)
                    <div class="flex flex-col sm:flex-row gap-4">
                        {{-- Title Row: Checkbox + Title --}}
                        <div class="flex items-center gap-4 sm:gap-6">
                            <div class="flex-shrink-0 w-6 h-6 bg-white bg-opacity-10 rounded flex items-center justify-center"
                                 aria-label="Checkmark" role="img">
                                <svg width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.7 13.0125L0 7.31255L1.425 5.88755L5.7 10.1625L14.875 0.987549L16.3 2.41255L5.7 13.0125Z" fill="#009F13"/>
                                </svg>
                            </div>
                            <h3 class="text-lg lg:text-xl font-semibold leading-snug">
                                {{ $advantage['title'] }}
                            </h3>
                        </div>

                        {{-- Advantage Description --}}
                        <div class="sm:ml-10">
                            <p class="text-base leading-relaxed opacity-80">
                                {{ $advantage['description'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
```

## Phase 4: Migration Workflow

### 4.1 Block-by-Block Migration Process

For each block from T3CH:

1. **Extract Block Data Structure**
   - Copy ACF field structure from existing block
   - Note any custom PHP logic or data processing

2. **Analyze SCSS Styling**
   - Identify colors, spacing, typography used
   - Map to equivalent Tailwind classes
   - Note any custom styles that need CSS

3. **Generate ACF Composer Block**
   ```bash
   wp acorn make:block [BlockName]
   wp acorn make:field [BlockName]
   ```

4. **Convert Template**
   - Replace PHP template with Blade template
   - Convert SCSS classes to Tailwind utilities
   - Maintain responsive behavior with Tailwind breakpoints

5. **Add Custom CSS (if needed)**
   - For complex animations or styles not covered by Tailwind
   - Add to `resources/css/app.css` under block-specific comments

### 4.2 Priority Block List

Based on the AllinQ Digital theme analysis, migrate in this order:

**Phase 1 - Core Expertise Blocks:**
1. ✅ `expertise-detail-advantages-block` (example above)
2. `expertise-detail-sticky-menu-block`
3. `expertise-detail-experience-block`
4. `expertise-detail-application-block`
5. `expertise-detail-faq-block`

**Phase 2 - Inner Page Blocks:**
1. `inner-page-banner`
2. `inner-page-text`
3. `inner-page-image`
4. `inner-page-video`
5. `inner-page-accordian`

**Phase 3 - Home Page Blocks:**
1. `home-page-banner`
2. `home-services-block`
3. `home-expertise-block`
4. `home-cta-banner-block`

### 4.3 Common Tailwind Conversions

**Container Patterns:**
```scss
// T3CH SCSS:
.container {
    max-width: 1232px;
    margin: 0 auto;
    padding: 0;
}

// Tailwind equivalent:
class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
```

**Button Patterns:**
```scss
// T3CH SCSS:
.cta-button-blue-pill {
    background: $brand-blue-600;
    color: white;
    padding: 12px 24px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
}

// Tailwind equivalent:
class="bg-t3ch-blue text-white px-6 py-3 rounded-full text-sm font-medium"
```

**Responsive Grid Patterns:**
```scss
// T3CH SCSS:
.advantages-header {
    display: flex;
    gap: 48px;
    align-items: flex-start;

    @media (max-width: 991px) {
        flex-direction: column;
        gap: 32px;
    }
}

// Tailwind equivalent:
class="flex flex-col lg:flex-row gap-8 lg:gap-12 items-start"
```

## Phase 5: Custom CSS Integration

### 5.1 Block-Specific CSS

For styles that can't be achieved with Tailwind utilities, add to `resources/css/app.css`:

```css
/* =============================================================================
   T3CH MIGRATED BLOCKS - CUSTOM STYLES
   ============================================================================= */

/* Expertise Detail Advantages Block - Custom animations */
.expertise-detail-advantages-block .advantage-item {
  transition: all 0.3s ease;
}

.expertise-detail-advantages-block .advantage-item:hover {
  transform: translateY(-2px);
}

/* Sticky Menu Block - Fixed positioning */
.expertise-detail-sticky-menu-block.is-sticky {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 999;
  animation: slideDown 0.3s ease;
}

@keyframes slideDown {
  from {
    transform: translateY(-100%);
  }
  to {
    transform: translateY(0);
  }
}
```

### 5.2 JavaScript Integration

For blocks with interactive functionality:

**File:** `resources/js/app.js`

```javascript
// T3CH Block JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Sticky Menu Block
    const stickyMenu = document.querySelector('.expertise-detail-sticky-menu-block');
    if (stickyMenu) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 100) {
                stickyMenu.classList.add('is-sticky');
            } else {
                stickyMenu.classList.remove('is-sticky');
            }
        });
    }

    // FAQ Accordion functionality
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');

        question.addEventListener('click', () => {
            item.classList.toggle('is-open');
        });
    });
});
```

## Phase 6: Testing & Validation

### 6.1 Block Testing Checklist

For each migrated block:

- [ ] **Visual Comparison**: Block matches T3CH design
- [ ] **Responsive Behavior**: Works on mobile, tablet, desktop
- [ ] **ACF Fields**: All fields save and load correctly
- [ ] **Block Editor**: Block renders correctly in WordPress editor
- [ ] **Content Migration**: Existing content displays properly
- [ ] **Performance**: No significant load time increase

### 6.2 Development Workflow

```bash
# 1. Generate new block
wp acorn make:block ExampleBlock
wp acorn make:field ExampleBlock

# 2. Develop block template
# Edit: app/Blocks/ExampleBlock.php
# Edit: app/Fields/ExampleBlock.php
# Edit: resources/views/blocks/example-block.blade.php

# 3. Build assets
npm run build

# 4. Test in WordPress admin
# Navigate to: /wp-admin/post-new.php?post_type=page
# Add block and test functionality

# 5. Clear caches if needed
wp acorn optimize:clear
```

### 6.3 Performance Optimization

- **Tailwind Purging**: Ensure unused CSS is removed in production
- **Image Optimization**: Optimize any block images/assets
- **Lazy Loading**: Implement for blocks with images/videos
- **Critical CSS**: Include block styles in critical CSS path

## Phase 7: Content Migration Strategy

### 7.1 Automated Content Migration

For large amounts of existing content using T3CH blocks:

1. **Export existing block data** from T3CH site
2. **Map field names** between old and new ACF structures
3. **Run migration script** to convert block data
4. **Validate migrated content** manually

### 7.2 Migration Script Template

```php
// wp-cli migration script template
<?php
class T3chBlockMigration {
    public function migrate_advantages_blocks() {
        $pages = get_posts([
            'post_type' => 'page',
            'numberposts' => -1,
            'meta_query' => [
                [
                    'key' => '_t3ch_advantages_data',
                    'compare' => 'EXISTS'
                ]
            ]
        ]);

        foreach ($pages as $page) {
            $old_data = get_field('_t3ch_advantages_data', $page->ID);

            // Convert to new ACF Composer structure
            $new_data = [
                'advantages_pill_text' => $old_data['pill_text'],
                'advantages_main_title' => $old_data['title'],
                'advantages_description' => $old_data['description'],
                'advantages_list' => $old_data['items']
            ];

            update_field('expertise_detail_advantages', $new_data, $page->ID);
        }
    }
}
```

## Success Criteria

### Migration Complete When:

- [ ] All T3CH blocks converted to ACF Composer blocks
- [ ] Visual parity maintained with original designs
- [ ] All blocks work in WordPress block editor
- [ ] Responsive design preserved across devices
- [ ] No performance degradation
- [ ] Content successfully migrated
- [ ] Documentation updated for new blocks

### Benefits Achieved:

- ✅ **Simplified Codebase**: No SCSS compilation or variable management
- ✅ **Improved Performance**: Tailwind's purging removes unused CSS
- ✅ **Better Maintainability**: Standardized utility classes
- ✅ **Design Consistency**: Unified design system with Tailwind
- ✅ **Modern Development**: Blade templates with ACF Composer
- ✅ **Future-Proof**: Easy to extend and modify

## Timeline Estimate

- **Phase 1 (Setup)**: 1 day
- **Phase 2 (Color/Spacing Mapping)**: 1 day
- **Phase 3 (Block Migration - 20 blocks)**: 10-15 days
- **Phase 4 (Testing & Validation)**: 3-5 days
- **Phase 5 (Content Migration)**: 2-3 days

**Total Estimated Time**: 17-25 days

This approach maintains the visual design and functionality of T3CH blocks while modernizing the codebase with Tailwind CSS and ACF Composer patterns.