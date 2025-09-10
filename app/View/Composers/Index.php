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
            'featured_posts' => $this->getFeaturedPosts(),
            'latest_posts' => $this->getLatestPosts(),
            'categories' => $this->getCategories(),
            'authors' => $this->getAuthors(),
            'category_colors' => $this->categoryColors(),
            'getCategoryColorClass' => [$this, 'getCategoryColorClass'],
        ];
    }

    /**
     * Get featured posts with thumbnails for magazine layout.
     */
    public function getFeaturedPosts()
    {
        return get_posts([
            'numberposts' => 1,
            'post_status' => 'publish',
            'meta_key' => '_thumbnail_id'
        ]);
    }

    /**
     * Get latest posts for 3-column magazine grid (excluding featured).
     */
    public function getLatestPosts()
    {
        return get_posts([
            'numberposts' => 6,
            'post_status' => 'publish',
            'meta_key' => '_thumbnail_id',
            'offset' => 1
        ]);
    }

    /**
     * Get categories.
     */
    public function getCategories()
    {
        return get_categories(['hide_empty' => true, 'number' => 5]);
    }

    /**
     * Get authors.
     */
    public function getAuthors()
    {
        return get_users([
            'who' => 'authors',
            'has_published_posts' => true,
            'number' => 3,
            'orderby' => 'post_count',
            'order' => 'DESC'
        ]);
    }

    /**
     * Category color mapping for badges.
     */
    public function categoryColors(): array
    {
        return [
            'Technology' => 'bg-category-tech/10 text-category-tech border-category-tech/20',
            'Design' => 'bg-category-design/10 text-category-design border-category-design/20',
            'Lifestyle' => 'bg-category-lifestyle/10 text-category-lifestyle border-category-lifestyle/20',
            'Business' => 'bg-category-business/10 text-category-business border-category-business/20',
            'Travel' => 'bg-category-travel/10 text-category-travel border-category-travel/20',
            'Health' => 'bg-pink-100 text-pink-800 border-pink-200',
            'default' => 'bg-gray-100 text-gray-800 border-gray-200',
        ];
    }

    /**
     * Get category color class for a given category name.
     */
    public function getCategoryColorClass(string $categoryName): string
    {
        $colors = $this->categoryColors();

        return $colors[$categoryName] ?? $colors['default'];
    }

    /**
     * Sample featured post data for hero section.
     */
    public function featuredPost(): array
    {
        return [
            'title' => 'The Future of Web Development: Embracing Modern Frameworks',
            'excerpt' => 'Discover how modern web frameworks are revolutionizing the way we build applications, from improved performance to enhanced developer experience.',
            'author' => 'Sarah Johnson',
            'category' => 'Technology',
            'read_time' => '8 min read',
            'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        ];
    }

    /**
     * Sample posts data for the grid.
     */
    public function samplePosts(): array
    {
        return [
            [
                'title' => 'Mastering Responsive Design in 2024',
                'excerpt' => 'Learn the latest techniques and best practices for creating responsive websites that work seamlessly across all devices.',
                'author' => 'Alex Chen',
                'category' => 'Design',
                'read_time' => '6 min read',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'The Art of Minimalist Living',
                'excerpt' => 'Discover how embracing minimalism can lead to a more fulfilling and intentional lifestyle in our complex modern world.',
                'author' => 'Maria Rodriguez',
                'category' => 'Lifestyle',
                'read_time' => '4 min read',
                'image' => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'Building Scalable Business Models',
                'excerpt' => 'Explore proven strategies for creating business models that can adapt and grow in today\'s rapidly changing market.',
                'author' => 'David Kim',
                'category' => 'Business',
                'read_time' => '7 min read',
                'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'Hidden Gems: European Travel Guide',
                'excerpt' => 'Uncover the most beautiful and lesser-known destinations across Europe for your next adventure.',
                'author' => 'Emma Thompson',
                'category' => 'Travel',
                'read_time' => '5 min read',
                'image' => 'https://images.unsplash.com/photo-1539650116574-75c0c6d73adf?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'Advanced JavaScript Patterns',
                'excerpt' => 'Deep dive into advanced JavaScript design patterns that will make your code more maintainable and efficient.',
                'author' => 'Ryan Foster',
                'category' => 'Technology',
                'read_time' => '9 min read',
                'image' => 'https://images.unsplash.com/photo-1579468118864-1b9ea3c0db4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'UI/UX Design Trends 2024',
                'excerpt' => 'Stay ahead of the curve with the latest design trends that are shaping user interfaces and experiences.',
                'author' => 'Jessica Wong',
                'category' => 'Design',
                'read_time' => '6 min read',
                'image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            ],
        ];
    }

    /**
     * Sample authors data.
     */
    public function featuredAuthors(): array
    {
        return [
            [
                'name' => 'Sarah Johnson',
                'bio' => 'Tech enthusiast and full-stack developer with 10+ years of experience in modern web technologies.',
                'posts_count' => 42,
                'avatar' => 'https://images.unsplash.com/photo-1494790108755-2616b612b789?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            ],
            [
                'name' => 'Alex Chen',
                'bio' => 'Creative designer passionate about creating beautiful and functional digital experiences.',
                'posts_count' => 28,
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            ],
            [
                'name' => 'Maria Rodriguez',
                'bio' => 'Lifestyle blogger and wellness coach helping people live more intentional lives.',
                'posts_count' => 35,
                'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            ],
            [
                'name' => 'David Kim',
                'bio' => 'Business strategist and entrepreneur with expertise in scaling digital products.',
                'posts_count' => 19,
                'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            ],
        ];
    }
}
