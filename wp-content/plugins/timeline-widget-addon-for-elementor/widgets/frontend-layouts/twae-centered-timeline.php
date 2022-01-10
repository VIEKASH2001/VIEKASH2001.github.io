<?php
echo '
<div class="twae-vertical twae-wrapper '.esc_attr($timeline_layout_wrapper).'">    
    <div class="twae-timeline-centered twae-timeline-sm twae-line '.esc_attr($timeline_layout).'">';	
  if(is_array($data)){
    foreach($data as $index=>$content){
        $left_aligned = "twae-right-aligned";
        if($layout == 'centered'){
            if($countItem % 2 == 0){ 
                $left_aligned = "twae-left-aligned";  
            }
        }
        $timeline_description = $content['twae_description'];
        $show_year_label = esc_html($content['twae_show_year_label']);
        $timeline_year = esc_html($content['twae_year']);
        $story_date_label = esc_html($content['twae_date_label']);
        $story_extra_label = esc_html($content['twae_extra_label']);
        $timeline_story_title = esc_html($content['twae_story_title']);
        $story_icon = $content['twae_story_icon']['value'];
        $thumbnail_size = $content['twae_thumbnail_size'];
        $thumbnail_custom_dimension = $content['twae_thumbnail_custom_dimension'];
        
        $title_key = $this->get_repeater_setting_key( 'twae_story_title', 'twae_list', $index );
        $year_key = $this->get_repeater_setting_key( 'twae_year', 'twae_list', $index );
        $date_label_key = $this->get_repeater_setting_key( 'twae_date_label', 'twae_list', $index );
        $extra_label_key = $this->get_repeater_setting_key( 'twae_extra_label', 'twae_list', $index );
        $description_key = $this->get_repeater_setting_key( 'twae_description', 'twae_list', $index );
        
        $this->add_inline_editing_attributes( $title_key, 'none' );
        $this->add_inline_editing_attributes( $year_key, 'none' );
        $this->add_inline_editing_attributes( $date_label_key, 'none' );
        $this->add_inline_editing_attributes( $extra_label_key, 'none' );
        $this->add_inline_editing_attributes( $description_key, 'advanced' );
        
        $this->add_render_attribute( $title_key, ['class'=> 'twae-title']);
        $this->add_render_attribute( $year_key, ['class'=> 'twae-year-label twae-year']);
        $this->add_render_attribute( $date_label_key, ['class'=> 'twae-label']);
        $this->add_render_attribute( $extra_label_key, ['class'=> 'twae-extra-label']);
        $this->add_render_attribute( $description_key, ['class'=> 'twae-description']); 

        if($content['twae_image']['id']!=""){
            if($thumbnail_size =='custom'){
                $custom_size = array ( $thumbnail_custom_dimension['width'],$thumbnail_custom_dimension['height']);
                $image= wp_get_attachment_image($content['twae_image']['id'], $custom_size , true);	
                
            }
            else{
                $image= wp_get_attachment_image($content['twae_image']['id'],$thumbnail_size, true);                
            }
            $image =  '<div class="twae-timeline-img">'.$image.'</div>';
        }else if($content['twae_image']['url']!=""){
            $image = '<div class="twae-timeline-img"><img src="'.$content['twae_image']['url'].'"></img></div>';
        }
        else{
            $image ='';
        }

        if($show_year_label == 'yes'){
            echo '<span class="twae-year-container">
                <span '.$this->get_render_attribute_string( $year_key ).'>'.$timeline_year.'</span>
            </span>';
        }
        
        echo '<article class="twae-timeline-entry '.esc_attr($left_aligned).'">
            <div class="twae-timeline-entry-inner">
                <div class="twae-label-extra-label">
                    <span '.$this->get_render_attribute_string( $date_label_key).'>'.$story_date_label.'</span>
                    <span '.$this->get_render_attribute_string( $extra_label_key ).'>'.$story_extra_label.'</span>
                </div>
                <div class="twae-icon">';
                \Elementor\Icons_Manager::render_icon( $content['twae_story_icon'], [ 'aria-hidden' => 'true' ] );
                echo'</div>
                <div class="twae-data-container '.$no_border.'">
                    <span '.$this->get_render_attribute_string( $title_key ).'>'.$timeline_story_title.'</span>
                    '.$image.'
                    <div '.$this->get_render_attribute_string( $description_key ).'>'.$timeline_description.'</div>
                </div>
            </div>
        </article>';				
        $countItem = $countItem +1;
    }
}
    echo'</div></div>';