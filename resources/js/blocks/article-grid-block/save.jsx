/**
 * WordPress dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Save function that defines output on the frontend
 * The actual content is rendered dynamically by view.js
 */
export default function Save({ attributes }) {
  const { numberOfPosts, selectedCategory, selectedTag, queryType } = attributes;
  const blockProps = useBlockProps.save({
    className: 'wp-block-vendor-article-grid-block',
  });
  
  return (
    <div { ...blockProps } 
         data-number-of-posts={numberOfPosts} 
         data-query-type={queryType}
         {...(selectedCategory !== 0 && { 'data-selected-category': selectedCategory })}
         {...(selectedTag !== 0 && { 'data-selected-tag': selectedTag })}>
      <div className="wp-block-columns article-grid-container" id="article-grid-container">
        {/* Content will be loaded by view.js */}
        <div className="article-grid-loading">
          <p>Loading articles...</p>
        </div>
      </div>
    </div>
  );
}