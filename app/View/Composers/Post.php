<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Post extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'single',
        'partials.page-header',
        'partials.content',
        'partials.content-*',
    ];

    /**
     * Retrieve the post title.
     */
    public function title(): string
    {
        if ($this->view->name() !== 'partials.page-header') {
            return get_the_title();
        }

        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }

            return __('Latest Posts', 'sage');
        }

        if (is_archive()) {
            return get_the_archive_title();
        }

        if (is_search()) {
            return sprintf(
                /* translators: %s is replaced with the search query */
                __('Search Results for %s', 'sage'),
                get_search_query()
            );
        }

        if (is_404()) {
            return __('Not Found', 'sage');
        }

        return get_the_title();
    }

    /**
     * Retrieve the pagination links.
     */
    public function pagination(): string
    {
        return wp_link_pages([
            'echo' => 0,
            'before' => '<p>'.__('Pages:', 'sage'),
            'after' => '</p>',
        ]);
    }

    /**
     * Get post categories.
     */
    public function categories(): array
    {
        return get_the_category();
    }

    /**
     * Get post subtitle (from ACF field or excerpt).
     */
    public function subtitle(): string
    {
        // First try ACF field 'subtitle'
        if (function_exists('get_field')) {
            $subtitle = get_field('subtitle');
            if ($subtitle) {
                return $subtitle;
            }
        }

        // Fall back to excerpt
        $excerpt = get_the_excerpt();

        return $excerpt ? wp_trim_words($excerpt, 25) : '';
    }

    /**
     * Get author information.
     */
    public function authorName(): string
    {
        return get_the_author();
    }

    /**
     * Get author avatar URL.
     */
    public function authorAvatar(): string
    {
        return get_avatar_url(get_the_author_meta('ID'), ['size' => 64]);
    }

    /**
     * Get author bio.
     */
    public function authorBio(): string
    {
        return get_the_author_meta('description') ?: '';
    }

    /**
     * Get author info array.
     */
    public function authorInfo(): array
    {
        return [
            'name' => $this->authorName(),
            'bio' => $this->authorBio(),
            'avatar' => $this->authorAvatar(),
            'posts_count' => count_user_posts(get_the_author_meta('ID')),
        ];
    }

    /**
     * Calculate estimated reading time.
     */
    public function readTime(): int
    {
        $content = get_the_content();
        $word_count = str_word_count(strip_tags($content));
        $reading_time = ceil($word_count / 200); // Average 200 words per minute

        return max(1, $reading_time); // Minimum 1 minute
    }

    /**
     * Get post tags.
     */
    public function tags(): array
    {
        return get_the_tags() ?: [];
    }

    /**
     * Get related posts based on categories.
     */
    public function relatedPosts(): array
    {
        $categories = get_the_category();

        if (empty($categories)) {
            return [];
        }

        $category_ids = array_map(function ($cat) {
            return $cat->term_id;
        }, $categories);

        return get_posts([
            'numberposts' => 3,
            'post_status' => 'publish',
            'post__not_in' => [get_the_ID()],
            'category__in' => $category_ids,
            'meta_key' => '_thumbnail_id',
        ]);
    }

    /**
     * Data to be passed to view.
     */
    public function with()
    {
        return [
            'title' => $this->title(),
            'pagination' => $this->pagination(),
            'categories' => $this->categories(),
            'subtitle' => $this->subtitle(),
            'author_name' => $this->authorName(),
            'author_avatar' => $this->authorAvatar(),
            'author_bio' => $this->authorBio(),
            'author_info' => $this->authorInfo(),
            'read_time' => $this->readTime(),
            'tags' => $this->tags(),
            'related_posts' => $this->relatedPosts(),
        ];
    }
}
