<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use Log1x\AcfComposer\Builder;

class HeroSection extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Hero Section';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A beautiful Hero Section block.';

    /**
     * The block category.
     *
     * @var string
     */
    public $category = 'media';

    /**
     * The block icon.
     *
     * @var string|array
     */
    public $icon = 'editor-ul';

    /**
     * The block keywords.
     *
     * @var array
     */
    public $keywords = [];

    /**
     * The block post type allow list.
     *
     * @var array
     */
    public $post_types = ['post', 'page'];

    /**
     * The parent block type allow list.
     *
     * @var array
     */
    public $parent = [];

    /**
     * The ancestor block type allow list.
     *
     * @var array
     */
    public $ancestor = [];

    /**
     * The default block mode.
     *
     * @var string
     */
    public $mode = 'preview';

    /**
     * The default block alignment.
     *
     * @var string
     */
    public $align = '';

    /**
     * The default block text alignment.
     *
     * @var string
     */
    public $align_text = '';

    /**
     * The default block content alignment.
     *
     * @var string
     */
    public $align_content = '';

    /**
     * The default block spacing.
     *
     * @var array
     */
    public $spacing = [
        'padding' => null,
        'margin' => null,
    ];

    /**
     * The supported block features.
     *
     * @var array
     */
    public $supports = [
        'align' => true,
        'align_text' => true,
        'align_content' => true,
        'full_height' => false,
        'anchor' => true,
        'mode' => true,
        'multiple' => true,
        'jsx' => true,
        'color' => [
            'background' => false,
            'text' => false,
            'gradients' => false,
        ],
        'spacing' => [
            'padding' => false,
            'margin' => false,
        ],
    ];

    /**
     * The block styles.
     *
     * @var array
     */
    public $styles = ['light', 'dark'];

    /**
     * The block preview example data.
     *
     * @var array
     */
    public $example = [
        'headline' => 'Your Headline Here',
        'subheadline' => 'Add your subheadline text here',
        'cta_text' => 'Get Started',
        'cta_url' => '#',
        'accent_color' => '#3B82F6',
        'overlay_opacity' => 60,
    ];

    /**
     * The block template.
     *
     * @var array
     */
    public $template = [];

    /**
     * Data to be passed to the block before rendering.
     */
    public function with(): array
    {
        return [
            'headline' => $this->headline(),
            'subheadline' => $this->subheadline(),
            'background_image' => $this->backgroundImage(),
            'cta_text' => $this->ctaText(),
            'cta_url' => $this->ctaUrl(),
            'accent_color' => $this->accentColor(),
            'overlay_opacity' => $this->overlayOpacity(),
        ];
    }

    /**
     * The block field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('hero_section');

        $fields
            ->addText('headline', [
                'label' => 'Headline',
                'instructions' => 'Main headline for the hero section',
                'default_value' => 'Your Headline Here',
            ])
            ->addText('subheadline', [
                'label' => 'Subheadline',
                'instructions' => 'Optional subheadline text',
                'default_value' => 'Add your subheadline text here',
            ])
            ->addImage('background_image', [
                'label' => 'Background Image',
                'instructions' => 'Large background image for the hero section',
                'return_format' => 'array',
                'preview_size' => 'large',
            ])
            ->addText('cta_text', [
                'label' => 'Call to Action Text',
                'instructions' => 'Text for the CTA button',
                'default_value' => 'Get Started',
            ])
            ->addUrl('cta_url', [
                'label' => 'Call to Action URL',
                'instructions' => 'URL for the CTA button',
                'default_value' => '#',
            ])
            ->addColorPicker('accent_color', [
                'label' => 'Accent Color',
                'instructions' => 'Optional accent color for overlay/button',
                'default_value' => '#3B82F6',
            ])
            ->addRange('overlay_opacity', [
                'label' => 'Overlay Opacity',
                'instructions' => 'Set overlay opacity (0-100)',
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default_value' => 60,
            ]);

        return $fields->build();
    }

    /**
     * Retrieve the headline.
     */
    public function headline()
    {
        return get_field('headline') ?: $this->example['headline'];
    }

    /**
     * Retrieve the subheadline.
     */
    public function subheadline()
    {
        return get_field('subheadline') ?: $this->example['subheadline'];
    }

    /**
     * Retrieve the background image.
     */
    public function backgroundImage()
    {
        return get_field('background_image');
    }

    /**
     * Retrieve the CTA text.
     */
    public function ctaText()
    {
        return get_field('cta_text') ?: $this->example['cta_text'];
    }

    /**
     * Retrieve the CTA URL.
     */
    public function ctaUrl()
    {
        return get_field('cta_url') ?: $this->example['cta_url'];
    }

    /**
     * Retrieve the accent color.
     */
    public function accentColor()
    {
        return get_field('accent_color') ?: $this->example['accent_color'];
    }

    /**
     * Retrieve the overlay opacity.
     */
    public function overlayOpacity()
    {
        return get_field('overlay_opacity') ?: $this->example['overlay_opacity'];
    }

    /**
     * Assets enqueued with 'enqueue_block_assets' when rendering the block.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/enqueueing-assets-in-the-editor/#editor-content-scripts-and-styles
     */
    public function assets(): void
    {
        //
    }
}
