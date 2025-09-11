<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class FrontPage extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'front-page',
    ];

    /**
     * Data to be passed to view.
     */
    public function with()
    {
        return [
            // Front page uses standard WordPress page content
            // No additional data needed as front-page.blade.php uses the_content()
        ];
    }
}