<#
	var countItem = 1;
    var timeline_layout = '';
    var timeline_layout_wrapper = 'twae-centered';
    if(settings.twae_layout == 'one-sided'){
        var timeline_layout = "twae-one-sided-timeline";
        var timeline_layout_wrapper = 'twae-one-sided-wrapper';
    }
    #>
    <div class="twae-vertical twae-wrapper {{{ timeline_layout_wrapper }}}">
        <div class="twae-timeline-centered twae-timeline-sm twae-line {{{ timeline_layout }}}">
        <#
        _.each( settings.twae_list, function( item, index ) {
            var timeline_image = {
                id: item.twae_image.id,
                url: item.twae_image.url,
                size: item.twae_thumbnail_size,
                dimension: item.twae_thumbnail_custom_dimension,
                model: view.getEditModel()
            };
            var image_url = elementor.imagesManager.getImageUrl( timeline_image );

            var year_key = view.getRepeaterSettingKey( 'twae_year', 'twae_list',index ),
            date_label_key = view.getRepeaterSettingKey( 'twae_date_label', 'twae_list',index ),
            extra_label_key = view.getRepeaterSettingKey( 'twae_extra_label', 'twae_list',index ),
            title_key = view.getRepeaterSettingKey( 'twae_story_title', 'twae_list',index ),
            description_key = view.getRepeaterSettingKey( 'twae_description', 'twae_list',index );

            view.addRenderAttribute( year_key, {'class':  'twae-year-label twae-year'} );
            view.addRenderAttribute( date_label_key, {'class':  'twae-label'} );
            view.addRenderAttribute( extra_label_key, {'class':  'twae-extra-label'} );
            view.addRenderAttribute( title_key, {'class': 'twae-title'});
            view.addRenderAttribute( description_key, {'class':  'twae-description'} );

            view.addInlineEditingAttributes( year_key, 'none' );
        	view.addInlineEditingAttributes( date_label_key, 'none' );
        	view.addInlineEditingAttributes( extra_label_key, 'none' );
        	view.addInlineEditingAttributes( title_key, 'none' );
        	view.addInlineEditingAttributes( description_key, 'advanced' );



            if(item.twae_show_year_label == 'yes'){
                #>
                <span class="twae-year-container">
                    <span {{{ view.getRenderAttributeString( year_key ) }}} >{{{ item.twae_year }}}</span>
                </span>
                <#
            }
            var story_alignment = "twae-right-aligned";
            if(settings.twae_layout == 'centered'){
                
                if ( countItem % 2 == 0) {
                    var story_alignment = "twae-left-aligned";						
                }
            }
            twaeiconHTML = elementor.helpers.renderIcon( view, item.twae_story_icon, { 'aria-hidden': true }, 'i' , 'object' ),

            
            #>
            <article class="twae-timeline-entry {{{ story_alignment }}}">									
                <div class="twae-timeline-entry-inner">
                    <div class="twae-label-extra-label">
                        <span {{{ view.getRenderAttributeString( date_label_key ) }}} >{{{ item.twae_date_label }}}</span>
                        <span {{{ view.getRenderAttributeString( extra_label_key ) }}} >{{{ item.twae_extra_label }}}</span>
                    </div>
                    <div class="twae-icon">
                    <# if ( twaeiconHTML && twaeiconHTML.rendered ) { #>
                        {{{ twaeiconHTML.value }}}
                    <# } else { #>
                        <i class="{{ item.twae_story_icon.value }}" aria-hidden="true"></i>
                    <# } #>
                    
                    </div>
                    <div class="twae-data-container {{{ no_border }}}">
                        <span {{{ view.getRenderAttributeString( title_key ) }}} >{{{ item.twae_story_title}}}</span>
                        <div class="twae-timeline-img"><img src="{{{ image_url }}}" /></div>
                        <div {{{ view.getRenderAttributeString( description_key ) }}} >{{{ item.twae_description }}}</div>
                    </div>
                </div>
            </article>
            <#
            countItem = countItem+1;
        });
        #>
        </div>
    </div>