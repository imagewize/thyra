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
    showExcerpt,
    columnGap
  } = attributes;
  const blockProps = useBlockProps({
    className: `${postSpacing !== 'default' ? `article-grid-spacing-${postSpacing}` : ''} article-grid-gap-${columnGap}`.trim()
  });

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
    { label: __('All Categories', 'imagewize'), value: 0 },
    ...(categories.map(cat => ({ label: cat.name, value: cat.id })))
  ];

  const tagOptions = [
    { label: __('All Tags', 'imagewize'), value: 0 },
    ...(tags.map(tag => ({ label: tag.name, value: tag.id })))
  ];

  return (
    <>
      <InspectorControls>
        <PanelBody title={__('Article Grid Settings', 'imagewize')}>
          <RangeControl
            label={__('Number of Posts', 'imagewize')}
            value={numberOfPosts}
            onChange={(value) => setAttributes({ numberOfPosts: value })}
            min={1}
            max={12}
          />
          
          <RadioControl
            label={__('Query Type', 'imagewize')}
            selected={queryType}
            options={[
              { label: __('Recent Posts', 'imagewize'), value: 'recent' },
              { label: __('By Category', 'imagewize'), value: 'category' },
              { label: __('By Tag', 'imagewize'), value: 'tag' }
            ]}
            onChange={(value) => setAttributes({ queryType: value })}
          />

          {queryType === 'category' && (
            <SelectControl
              label={__('Select Category', 'imagewize')}
              value={selectedCategory}
              options={categoryOptions}
              onChange={(value) => setAttributes({ selectedCategory: parseInt(value) })}
            />
          )}

          {queryType === 'tag' && (
            <SelectControl
              label={__('Select Tag', 'imagewize')}
              value={selectedTag}
              options={tagOptions}
              onChange={(value) => setAttributes({ selectedTag: parseInt(value) })}
            />
          )}
        </PanelBody>

        <PanelBody title={__('Article Grid Styling', 'imagewize')}>
          <ToggleControl
            label={__('Show Date', 'imagewize')}
            checked={showDate}
            onChange={(value) => setAttributes({ showDate: value })}
          />

          <ToggleControl
            label={__('Show Excerpt', 'imagewize')}
            checked={showExcerpt}
            onChange={(value) => setAttributes({ showExcerpt: value })}
          />

          {showDate && (
            <>
              <SelectControl
                label={__('Date Font Family', 'imagewize')}
                value={dateFontFamily}
                options={[
                  { label: __('Lato (Sans Serif)', 'imagewize'), value: 'lato' },
                  { label: __('Bitter (Serif)', 'imagewize'), value: 'bitter' },
                  { label: __('Body (Default)', 'imagewize'), value: 'body' },
                  { label: __('Heading (Default)', 'imagewize'), value: 'heading' }
                ]}
                onChange={(value) => setAttributes({ dateFontFamily: value })}
              />

              <SelectControl
                label={__('Date Font Size', 'imagewize')}
                value={dateFontSize}
                options={[
                  { label: __('Small (14px - Tailwind sm)', 'imagewize'), value: 'small' },
                  { label: __('Medium (16px - Tailwind base)', 'imagewize'), value: 'medium' },
                  { label: __('Large (24px - Tailwind 2xl)', 'imagewize'), value: 'large' }
                ]}
                onChange={(value) => setAttributes({ dateFontSize: value })}
              />
            </>
          )}

          <SelectControl
            label={__('Heading Font Family', 'imagewize')}
            value={headingFontFamily}
            options={[
              { label: __('Bitter (Serif)', 'imagewize'), value: 'bitter' },
              { label: __('Lato (Sans Serif)', 'imagewize'), value: 'lato' },
              { label: __('Body (Default)', 'imagewize'), value: 'body' },
              { label: __('Heading (Default)', 'imagewize'), value: 'heading' }
            ]}
            onChange={(value) => setAttributes({ headingFontFamily: value })}
          />

          <SelectControl
            label={__('Heading Font Size', 'imagewize')}
            value={headingFontSize}
            options={[
              { label: __('Small (14px - Tailwind sm)', 'imagewize'), value: 'small' },
              { label: __('Medium (16px - Tailwind base)', 'imagewize'), value: 'medium' },
              { label: __('Large (24px - Tailwind 2xl)', 'imagewize'), value: 'large' },
              { label: __('X-Large (30px - Tailwind 3xl)', 'imagewize'), value: 'x-large' },
              { label: __('XX-Large (55px - Editorial)', 'imagewize'), value: 'xx-large' }
            ]}
            onChange={(value) => setAttributes({ headingFontSize: value })}
          />

          <SelectControl
            label={__('Post Spacing', 'imagewize')}
            value={postSpacing}
            options={[
              { label: __('None', 'imagewize'), value: 'none' },
              { label: __('Small', 'imagewize'), value: 'small' },
              { label: __('Default', 'imagewize'), value: 'default' },
              { label: __('Large', 'imagewize'), value: 'large' }
            ]}
            onChange={(value) => setAttributes({ postSpacing: value })}
          />

          <SelectControl
            label={__('Column Gap', 'imagewize')}
            value={columnGap}
            options={[
              { label: __('None', 'imagewize'), value: 'none' },
              { label: __('Small', 'imagewize'), value: 'small' },
              { label: __('Default', 'imagewize'), value: 'default' },
              { label: __('Large', 'imagewize'), value: 'large' },
              { label: __('Extra Large', 'imagewize'), value: 'xl' }
            ]}
            onChange={(value) => setAttributes({ columnGap: value })}
          />
        </PanelBody>
      </InspectorControls>

      <div {...blockProps}>
        <div className="wp-block-columns">
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
                <div className={`has-${dateFontFamily}-font-family article-grid-font-${dateFontSize}`} style={{ marginTop: '1rem' }}>
                  {new Date(post.date).toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric', 
                    year: 'numeric'
                  })}
                </div>
              )}
              
              <h2 className={`wp-block-heading has-${headingFontFamily}-font-family article-grid-font-${headingFontSize}`} style={{ marginTop: '0.5rem' }}>
                {post.title?.rendered || ''}
              </h2>

              {showExcerpt && post.excerpt?.rendered && (
                <div className="has-body-font-family article-grid-font-small" style={{ marginTop: '0.5rem' }}>
                  {post.excerpt.rendered.replace(/<[^>]*>/g, '').substring(0, 100)}...
                </div>
              )}
            </div>
          ))}
        </div>
        
        {posts.length === 0 && (
          <p>{__('No posts found. Try adjusting your settings.', 'imagewize')}</p>
        )}
      </div>
    </>
  );
}