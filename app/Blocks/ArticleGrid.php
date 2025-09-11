<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use Log1x\AcfComposer\Builder;

class ArticleGrid extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Article Grid';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A 3-column grid of articles with thumbnails and excerpts.';

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
    public $icon = 'grid-view';

    /**
     * The block keywords.
     *
     * @var array
     */
    public $keywords = ['articles', 'grid', 'posts', 'blog'];

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
        'posts_source' => 'latest',
        'posts_count' => 6,
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
            'posts' => $this->posts(),
            'posts_source' => $this->postsSource(),
            'posts_count' => $this->postsCount(),
        ];
    }

    /**
     * The block field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('article_grid');

        $fields
            ->addRadio('posts_source', [
                'label' => 'Posts Source',
                'choices' => [
                    'latest' => 'Latest Posts',
                    'category' => 'From Category',
                    'featured' => 'Featured Posts Only',
                ],
                'default_value' => 'latest',
                'layout' => 'horizontal',
            ])
            ->addTaxonomy('selected_category', [
                'label' => 'Select Category',
                'taxonomy' => 'category',
                'return_format' => 'object',
                'multiple' => false,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'posts_source',
                            'operator' => '==',
                            'value' => 'category',
                        ],
                    ],
                ],
            ])
            ->addNumber('posts_count', [
                'label' => 'Number of Posts',
                'default_value' => 6,
                'min' => 1,
                'max' => 12,
            ]);

        return $fields->build();
    }

    /**
     * Get posts source.
     */
    public function postsSource()
    {
        return get_field('posts_source') ?: 'latest';
    }

    /**
     * Get posts count.
     */
    public function postsCount()
    {
        return get_field('posts_count') ?: 6;
    }

    /**
     * Retrieve the posts.
     *
     * @return array
     */
    public function posts()
    {
        $source = $this->postsSource();
        $count = $this->postsCount();
        
        $args = [
            'numberposts' => $count,
            'post_status' => 'publish',
            'meta_key' => '_thumbnail_id',
        ];
        
        switch ($source) {
            case 'category':
                $category = get_field('selected_category');
                if ($category) {
                    $args['cat'] = $category->term_id;
                }
                break;
                
            case 'featured':
                $args['meta_query'] = [
                    [
                        'key' => 'featured_post',
                        'value' => '1',
                        'compare' => '='
                    ]
                ];
                break;
                
            default: // latest
                // No additional args needed
                break;
        }
        
        return get_posts($args);
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
