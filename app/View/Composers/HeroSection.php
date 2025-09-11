<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class HeroSection extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.hero-section',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'featured_posts' => $this->getFeaturedPosts(),
            'category_colors' => $this->getCategoryColors(),
        ];
    }

    /**
     * Get featured posts for hero section.
     *
     * @return array
     */
    public function getFeaturedPosts()
    {
        return get_posts([
            'numberposts' => 3,
            'post_status' => 'publish',
            'meta_key' => '_thumbnail_id',
            'orderby' => 'date',
            'order' => 'DESC',
        ]);
    }

    /**
     * Get category color mappings.
     *
     * @return array
     */
    public function getCategoryColors()
    {
        return [
            'Technology' => ['text' => 'text-blue-600', 'bg' => 'bg-blue-50'],
            'Travel' => ['text' => 'text-green-600', 'bg' => 'bg-green-50'],
            'Lifestyle' => ['text' => 'text-purple-600', 'bg' => 'bg-purple-50'],
            'Business' => ['text' => 'text-orange-600', 'bg' => 'bg-orange-50'],
        ];
    }
}
