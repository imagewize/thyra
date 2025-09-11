<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Index extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'index',
    ];

    /**
     * Data to be passed to view.
     */
    public function with()
    {
        return [
            'latest_posts' => $this->getLatestPosts(),
            'categories' => $this->getCategories(),
        ];
    }

    /**
     * Get latest blog posts for the front page blog section.
     */
    public function getLatestPosts()
    {
        return get_posts([
            'numberposts' => 6,
            'post_status' => 'publish',
            'meta_key' => '_thumbnail_id',
        ]);
    }

    /**
     * Get categories for optional display.
     */
    public function getCategories()
    {
        return get_categories(['hide_empty' => true, 'number' => 5]);
    }
}
