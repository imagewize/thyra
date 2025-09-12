/**
 * View script for the Article Grid block.
 * 
 * This file handles loading the articles dynamically on the frontend
 * using the WordPress REST API.
 */

(function() {
  document.addEventListener('DOMContentLoaded', () => {
    // Select all instances of this block on the page
    const blocks = document.querySelectorAll('.wp-block-vendor-article-grid-block');
  
    // Function to fetch and display articles
    async function loadArticles(block) {
      const container = block.querySelector('#article-grid-container');
      const numberOfPosts = parseInt(block.getAttribute('data-number-of-posts')) || 3;
      const queryType = block.getAttribute('data-query-type') || 'recent';
      const selectedCategory = parseInt(block.getAttribute('data-selected-category')) || 0;
      const selectedTag = parseInt(block.getAttribute('data-selected-tag')) || 0;
      
      // Get styling attributes
      const dateFontFamily = block.getAttribute('data-date-font-family') || 'body';
      const dateFontSize = block.getAttribute('data-date-font-size') || 'small';
      const headingFontFamily = block.getAttribute('data-heading-font-family') || 'heading';
      const headingFontSize = block.getAttribute('data-heading-font-size') || 'subtitle';
      const postSpacing = block.getAttribute('data-post-spacing') || 'default';
      const showDate = block.getAttribute('data-show-date') !== 'false';
      const showExcerpt = block.getAttribute('data-show-excerpt') === 'true';
      
      try {
        let apiUrl = `${window.location.origin}/wp-json/wp/v2/posts?per_page=${numberOfPosts}&_embed&status=publish&orderby=date&order=desc`;
        
        // Add category or tag filter if specified
        if (queryType === 'category' && selectedCategory > 0) {
          apiUrl += `&categories=${selectedCategory}`;
        } else if (queryType === 'tag' && selectedTag > 0) {
          apiUrl += `&tags=${selectedTag}`;
        }
        
        // Fetch posts from WordPress REST API
        const response = await fetch(apiUrl);
        
        if (!response.ok) {
          throw new Error(`Failed to fetch articles: ${response.status} ${response.statusText}`);
        }
        
        const posts = await response.json();
        
        // Clear loading message
        container.innerHTML = '';
        
        if (posts.length === 0) {
          container.innerHTML = '<p class="no-articles">No articles found.</p>';
          return;
        }
        
        // Create grid container based on HTML pattern
        const gridContainer = document.createElement('div');
        gridContainer.className = `wp-block-columns ${postSpacing !== 'default' ? `article-grid-spacing-${postSpacing}` : ''}`;
        
        // Create articles HTML based on the HTML pattern structure
        posts.forEach(post => {
          const column = document.createElement('div');
          column.className = 'wp-block-column';
          
          let featuredImage = '';
          if (post._embedded && post._embedded['wp:featuredmedia'] && post._embedded['wp:featuredmedia'][0]) {
            const media = post._embedded['wp:featuredmedia'][0];
            featuredImage = `
              <figure class="wp-block-image size-large">
                <img src="${media.source_url}" alt="${media.alt_text || ''}" />
              </figure>
            `;
          }
          
          // Format date
          const postDate = new Date(post.date).toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
          });
          
          // Build column HTML following the pattern structure
          let columnHTML = `
            ${featuredImage}
          `;
          
          if (showDate) {
            columnHTML += `
            <div class="has-${dateFontFamily}-font-family has-${dateFontSize}-font-size" style="margin-top: 1rem;">
              ${postDate}
            </div>
            `;
          }
          
          columnHTML += `
            <h2 class="wp-block-heading has-${headingFontFamily}-font-family has-${headingFontSize}-font-size" style="margin-top: 0.5rem;">
              <a href="${post.link}" style="text-decoration: none; color: inherit;">
                ${post.title.rendered}
              </a>
            </h2>
          `;
          
          if (showExcerpt && post.excerpt && post.excerpt.rendered) {
            const excerptText = post.excerpt.rendered.replace(/<[^>]*>/g, '').substring(0, 100);
            columnHTML += `
            <div class="has-body-font-family has-small-font-size" style="margin-top: 0.5rem;">
              ${excerptText}...
            </div>
            `;
          }
          
          column.innerHTML = columnHTML;
          
          gridContainer.appendChild(column);
        });
        
        container.appendChild(gridContainer);
        
      } catch (error) {
        console.error('Error loading articles:', error);
        container.innerHTML = '<p class="articles-error">Error loading articles. Please try again later.</p>';
      }
    }
  
    // Initialize each block found
    if (blocks.length) {
      blocks.forEach(block => {
        loadArticles(block);
      });
    }
  });
})();