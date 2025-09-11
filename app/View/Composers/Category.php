<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Category extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'category',
    ];

    /**
     * Data to be passed to view.
     */
    public function with()
    {
        return [
            'category_description' => $this->getCategoryDescription(),
            'posts' => $this->getCategoryPosts(),
            'post_count' => $this->getPostCount(),
            'pagination' => $this->getPagination(),
            'related_categories' => $this->getRelatedCategories(),
        ];
    }

    /**
     * Get current category description.
     */
    public function getCategoryDescription(): string
    {
        return category_description() ?: '';
    }

    /**
     * Get posts for the current category.
     */
    public function getCategoryPosts(): array
    {
        global $wp_query;

        if (! $wp_query->have_posts()) {
            return [];
        }

        $posts = [];
        while ($wp_query->have_posts()) {
            $wp_query->the_post();
            $posts[] = get_post();
        }

        wp_reset_postdata();

        return $posts;
    }

    /**
     * Get total post count for current category.
     */
    public function getPostCount(): int
    {
        $category = get_queried_object();

        if (! $category || ! isset($category->count)) {
            return 0;
        }

        return (int) $category->count;
    }

    /**
     * Get pagination links.
     */
    public function getPagination(): string
    {
        return paginate_links([
            'type' => 'plain',
            'prev_text' => '← Previous',
            'next_text' => 'Next →',
            'before_page_number' => '<span class="sr-only">Page </span>',
        ]) ?: '';
    }

    /**
     * Get related categories (other categories with posts).
     */
    public function getRelatedCategories(): array
    {
        $current_category = get_queried_object();

        if (! $current_category) {
            return [];
        }

        return get_categories([
            'hide_empty' => true,
            'number' => 6,
            'exclude' => [$current_category->term_id],
            'orderby' => 'count',
            'order' => 'DESC',
        ]);
    }
}
