<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use Log1x\AcfComposer\Builder;

class FeaturedArticle extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Featured Article';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A featured article block with large image and content layout.';

    /**
     * The block category.
     *
     * @var string
     */
    public $category = 'theme';

    /**
     * The block icon.
     *
     * @var string|array
     */
    public $icon = 'format-image';

    /**
     * The block keywords.
     *
     * @var array
     */
    public $keywords = ['featured', 'article', 'hero', 'post'];

    /**
     * The block post type allow list.
     *
     * @var array
     */
    public $post_types = [];

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
        'align' => false,
        'align_text' => false,
        'align_content' => false,
        'full_height' => false,
        'anchor' => false,
        'mode' => false,
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
        'article_type' => 'manual',
        'headline' => 'Covid-19 Surge in Thailand is causing another massive lay-off of personal',
        'subtitle' => 'Bangkok Real Estate Market Slowing Down',
        'featured_image' => [
            'url' => 'https://via.placeholder.com/400x600/0066cc/ffffff?text=Featured+Image',
            'alt' => 'Featured article image'
        ],
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
            'article_type' => $this->articleType(),
            'selected_post' => $this->selectedPost(),
            'headline' => $this->headline(),
            'subtitle' => $this->subtitle(),
            'featured_image' => $this->featuredImage(),
        ];
    }

    /**
     * The block field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('featured_article');

        $fields
            ->addRadio('article_type', [
                'label' => 'Article Type',
                'choices' => [
                    'latest' => 'Latest Post (Automatic)',
                    'manual' => 'Manual Content',
                    'select' => 'Select Existing Post'
                ],
                'default_value' => 'latest',
                'layout' => 'horizontal',
            ])
            ->addPostObject('selected_post', [
                'label' => 'Select Post',
                'post_type' => ['post'],
                'return_format' => 'object',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'article_type',
                            'operator' => '==',
                            'value' => 'select',
                        ],
                    ],
                ],
            ])
            ->addText('headline', [
                'label' => 'Custom Headline',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'article_type',
                            'operator' => '==',
                            'value' => 'manual',
                        ],
                    ],
                ],
            ])
            ->addText('subtitle', [
                'label' => 'Custom Subtitle',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'article_type',
                            'operator' => '==',
                            'value' => 'manual',
                        ],
                    ],
                ],
            ])
            ->addImage('featured_image', [
                'label' => 'Custom Featured Image',
                'return_format' => 'array',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'article_type',
                            'operator' => '==',
                            'value' => 'manual',
                        ],
                    ],
                ],
            ]);

        return $fields->build();
    }

    /**
     * Get the article type.
     */
    public function articleType()
    {
        return get_field('article_type') ?: 'latest';
    }

    /**
     * Get the selected post.
     */
    public function selectedPost()
    {
        if ($this->articleType() === 'select') {
            return get_field('selected_post');
        }

        if ($this->articleType() === 'latest') {
            $posts = get_posts([
                'numberposts' => 1,
                'post_status' => 'publish',
                'meta_key' => '_thumbnail_id'
            ]);
            return !empty($posts) ? $posts[0] : null;
        }

        return null;
    }

    /**
     * Get the headline.
     */
    public function headline()
    {
        if ($this->articleType() === 'manual') {
            return get_field('headline') ?: $this->example['headline'];
        }

        $post = $this->selectedPost();
        return $post ? get_the_title($post->ID) : '';
    }

    /**
     * Get the subtitle.
     */
    public function subtitle()
    {
        if ($this->articleType() === 'manual') {
            return get_field('subtitle') ?: $this->example['subtitle'];
        }

        $post = $this->selectedPost();
        return $post ? wp_trim_words(get_the_excerpt($post->ID), 30, '...') : '';
    }

    /**
     * Get the featured image.
     */
    public function featuredImage()
    {
        if ($this->articleType() === 'manual') {
            return get_field('featured_image') ?: $this->example['featured_image'];
        }

        $post = $this->selectedPost();
        if ($post && has_post_thumbnail($post->ID)) {
            $attachment_id = get_post_thumbnail_id($post->ID);
            return [
                'url' => wp_get_attachment_image_url($attachment_id, 'homepage-featured'),
                'alt' => get_post_meta($attachment_id, '_wp_attachment_image_alt', true),
                'id' => $attachment_id
            ];
        }

        return null;
    }

    /**
     * Assets enqueued with 'enqueue_block_assets' when rendering the block.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/enqueueing-assets-in-the-editor/#editor-content-scripts-and-styles
     */
    public function assets(array $block): void
    {
        //
    }
}
