<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class HeroSection extends Field
{
    /**
     * The field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('Hero Section');

        $fields
            ->setLocation('block', '==', 'acf/hero-section');

        $fields
            ->addText('headline', [
                'label' => 'Headline',
                'instructions' => 'Main headline for the hero section',
                'required' => 1,
            ])
            ->addText('subheadline', [
                'label' => 'Subheadline',
                'instructions' => 'Optional subheadline text',
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
            ])
            ->addUrl('cta_url', [
                'label' => 'Call to Action URL',
                'instructions' => 'URL for the CTA button',
            ])
            ->addColorPicker('accent_color', [
                'label' => 'Accent Color',
                'instructions' => 'Optional accent color for overlay/button',
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
}
