<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use Log1x\AcfComposer\Builder;

class ExpertiseDetailAdvantages extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Expertise Detail Advantages';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'Content section highlighting key benefits/advantages of a service with checkmark-style list items.';

    /**
     * The block category.
     *
     * @var string
     */
    public $category = 'thyra-expertise';

    /**
     * The block icon.
     *
     * @var string|array
     */
    public $icon = 'yes-alt';

    /**
     * The block keywords.
     *
     * @var array
     */
    public $keywords = ['expertise', 'advantages', 'benefits', 'checkmark'];

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
    public $mode = 'edit';

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
        'mode' => true,
        'jsx' => true,
        'anchor' => true,
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
        'items' => [
            ['item' => 'Item one'],
            ['item' => 'Item two'],
            ['item' => 'Item three'],
        ],
    ];

    /**
     * The block template.
     *
     * @var array
     */
    public $template = [
        'core/heading' => ['placeholder' => 'Hello World'],
        'core/paragraph' => ['placeholder' => 'Welcome to the Expertise Detail Advantages block.'],
    ];

    /**
     * Data to be passed to the block before rendering.
     */
    public function with(): array
    {
        return [];
    }

    /**
     * The block field group.
     */
    public function fields(): array
    {
        return $this->get('ExpertiseDetailAdvantages');
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
