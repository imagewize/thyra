/**
 * WordPress dependencies
 */
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, RangeControl, SelectControl, RadioControl, ToggleControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

/**
 * Edit function that renders in the admin
 */
export default function Edit({ attributes, setAttributes }) {
  const { 
    numberOfPosts, 
    selectedCategory, 
    selectedTag, 
    queryType,
    dateFontFamily,
    dateFontSize,
    headingFontFamily,
    headingFontSize,
    postSpacing,
    showDate,
    showExcerpt
  } = attributes;
  const blockProps = useBlockProps();

  // Get categories and tags
  const { categories, tags, posts } = useSelect((select) => {
    return {
      categories: select('core').getEntityRecords('taxonomy', 'category') || [],
      tags: select('core').getEntityRecords('taxonomy', 'post_tag') || [],
      posts: select('core').getEntityRecords('postType', 'post', {
        per_page: numberOfPosts,
        _embed: true,
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

        <PanelBody title={__('Article Grid Styling', 'vendor')}>
          <ToggleControl
            label={__('Show Date', 'vendor')}
            checked={showDate}
            onChange={(value) => setAttributes({ showDate: value })}
          />

          <ToggleControl
            label={__('Show Excerpt', 'vendor')}
            checked={showExcerpt}
            onChange={(value) => setAttributes({ showExcerpt: value })}
          />

          {showDate && (
            <>
              <SelectControl
                label={__('Date Font Family', 'vendor')}
                value={dateFontFamily}
                options={[
                  { label: __('Lato (Sans Serif)', 'vendor'), value: 'lato' },
                  { label: __('Bitter (Serif)', 'vendor'), value: 'bitter' },
                  { label: __('Body (Default)', 'vendor'), value: 'body' },
                  { label: __('Heading (Default)', 'vendor'), value: 'heading' }
                ]}
                onChange={(value) => setAttributes({ dateFontFamily: value })}
              />

              <SelectControl
                label={__('Date Font Size', 'vendor')}
                value={dateFontSize}
                options={[
                  { label: __('Small', 'vendor'), value: 'small' },
                  { label: __('Normal', 'vendor'), value: 'normal' },
                  { label: __('Large', 'vendor'), value: 'large' }
                ]}
                onChange={(value) => setAttributes({ dateFontSize: value })}
              />
            </>
          )}

          <SelectControl
            label={__('Heading Font Family', 'vendor')}
            value={headingFontFamily}
            options={[
              { label: __('Bitter (Serif)', 'vendor'), value: 'bitter' },
              { label: __('Lato (Sans Serif)', 'vendor'), value: 'lato' },
              { label: __('Body (Default)', 'vendor'), value: 'body' },
              { label: __('Heading (Default)', 'vendor'), value: 'heading' }
            ]}
            onChange={(value) => setAttributes({ headingFontFamily: value })}
          />

          <SelectControl
            label={__('Heading Font Size', 'vendor')}
            value={headingFontSize}
            options={[
              { label: __('Small', 'vendor'), value: 'small' },
              { label: __('Normal', 'vendor'), value: 'normal' },
              { label: __('Large', 'vendor'), value: 'large' },
              { label: __('Subtitle', 'vendor'), value: 'subtitle' }
            ]}
            onChange={(value) => setAttributes({ headingFontSize: value })}
          />

          <SelectControl
            label={__('Post Spacing', 'vendor')}
            value={postSpacing}
            options={[
              { label: __('None', 'vendor'), value: 'none' },
              { label: __('Small', 'vendor'), value: 'small' },
              { label: __('Default', 'vendor'), value: 'default' },
              { label: __('Large', 'vendor'), value: 'large' }
            ]}
            onChange={(value) => setAttributes({ postSpacing: value })}
          />
        </PanelBody>
      </InspectorControls>

      <div {...blockProps}>
        <div className={`wp-block-columns ${postSpacing !== 'default' ? `article-grid-spacing-${postSpacing}` : ''}`}>
          {posts.slice(0, numberOfPosts).map((post) => (
            <div key={post.id} className="wp-block-column">
              {post._embedded?.['wp:featuredmedia']?.[0] && (
                <figure className="wp-block-image size-large">
                  <img 
                    src={post._embedded['wp:featuredmedia'][0].source_url} 
                    alt={post._embedded['wp:featuredmedia'][0].alt_text || post.title?.rendered || ''} 
                  />
                </figure>
              )}
              
              {showDate && (
                <div className={`has-${dateFontFamily}-font-family has-${dateFontSize}-font-size`} style={{ marginTop: '1rem' }}>
                  {new Date(post.date).toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric', 
                    year: 'numeric'
                  })}
                </div>
              )}
              
              <h2 className={`wp-block-heading has-${headingFontFamily}-font-family has-${headingFontSize}-font-size`} style={{ marginTop: '0.5rem' }}>
                {post.title?.rendered || ''}
              </h2>

              {showExcerpt && post.excerpt?.rendered && (
                <div className="has-body-font-family has-small-font-size" style={{ marginTop: '0.5rem' }}>
                  {post.excerpt.rendered.replace(/<[^>]*>/g, '').substring(0, 100)}...
                </div>
              )}
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