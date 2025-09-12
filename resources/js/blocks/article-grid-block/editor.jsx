/**
 * WordPress dependencies
 */
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, RangeControl, SelectControl, RadioControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

/**
 * Edit function that renders in the admin
 */
export default function Edit({ attributes, setAttributes }) {
  const { numberOfPosts, selectedCategory, selectedTag, queryType } = attributes;
  const blockProps = useBlockProps();

  // Get categories and tags
  const { categories, tags, posts } = useSelect((select) => {
    return {
      categories: select('core').getEntityRecords('taxonomy', 'category') || [],
      tags: select('core').getEntityRecords('taxonomy', 'post_tag') || [],
      posts: select('core').getEntityRecords('postType', 'post', {
        per_page: numberOfPosts,
        categories: queryType === 'category' && selectedCategory ? [selectedCategory] : undefined,
        tags: queryType === 'tag' && selectedTag ? [selectedTag] : undefined,
        orderby: 'date',
        order: 'desc'
      }) || []
    };
  }, [numberOfPosts, selectedCategory, selectedTag, queryType]);

  const categoryOptions = [
    { label: __('All Categories', 'vendor'), value: 0 },
    ...(categories.map(cat => ({ label: cat.name, value: cat.id })))
  ];

  const tagOptions = [
    { label: __('All Tags', 'vendor'), value: 0 },
    ...(tags.map(tag => ({ label: tag.name, value: tag.id })))
  ];

  return (
    <>
      <InspectorControls>
        <PanelBody title={__('Article Grid Settings', 'vendor')}>
          <RangeControl
            label={__('Number of Posts', 'vendor')}
            value={numberOfPosts}
            onChange={(value) => setAttributes({ numberOfPosts: value })}
            min={1}
            max={12}
          />
          
          <RadioControl
            label={__('Query Type', 'vendor')}
            selected={queryType}
            options={[
              { label: __('Recent Posts', 'vendor'), value: 'recent' },
              { label: __('By Category', 'vendor'), value: 'category' },
              { label: __('By Tag', 'vendor'), value: 'tag' }
            ]}
            onChange={(value) => setAttributes({ queryType: value })}
          />

          {queryType === 'category' && (
            <SelectControl
              label={__('Select Category', 'vendor')}
              value={selectedCategory}
              options={categoryOptions}
              onChange={(value) => setAttributes({ selectedCategory: parseInt(value) })}
            />
          )}

          {queryType === 'tag' && (
            <SelectControl
              label={__('Select Tag', 'vendor')}
              value={selectedTag}
              options={tagOptions}
              onChange={(value) => setAttributes({ selectedTag: parseInt(value) })}
            />
          )}
        </PanelBody>
      </InspectorControls>

      <div {...blockProps}>
        <div className="wp-block-columns">
          {posts.slice(0, numberOfPosts).map((post) => (
            <div key={post.id} className="wp-block-column">
              {post.featured_media && (
                <figure className="wp-block-image size-large">
                  <img 
                    src={post._embedded?.['wp:featuredmedia']?.[0]?.source_url || ''} 
                    alt={post._embedded?.['wp:featuredmedia']?.[0]?.alt_text || ''} 
                  />
                </figure>
              )}
              
              <div className="has-body-font-family has-small-font-size">
                {post.date}
              </div>
              
              <h2 className="wp-block-heading has-heading-font-family has-subtitle-font-size">
                {post.title.rendered}
              </h2>
            </div>
          ))}
        </div>
        
        {posts.length === 0 && (
          <p>{__('No posts found. Try adjusting your settings.', 'vendor')}</p>
        )}
      </div>
    </>
  );
}