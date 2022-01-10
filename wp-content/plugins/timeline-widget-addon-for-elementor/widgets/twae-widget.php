<?php
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Controls_Manager;
//use Elementor\Scheme_Color;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
//use Elementor\Scheme_Typography;

class TWAE_Widget extends \Elementor\Widget_Base {

	public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
		wp_register_style( 'twae-centered-css', TWAE_URL  . 'assets/css/twae-centered-timeline.min.css', array());	
		wp_register_style( 'twae-horizontal-css', TWAE_URL  . 'assets/css/twae-horizontal-styles.min.css', array());	
		wp_register_style( 'twae-fontello-css', TWAE_URL  . 'assets/css/twae-fontello.css', array());	
		wp_register_script( 'swiper', ELEMENTOR_ASSETS_URL  . 'lib/swiper/swiper.min.js',[ 'elementor-frontend' ],null, true);
		wp_register_script( 'twae-horizontal-js', TWAE_URL  . 'assets/js/twae-horizontal.min.js',[ 'elementor-frontend' ],null, true );	
		wp_register_style( 'twae-color-typography', TWAE_URL  . 'assets/css/twae-colors-typography.css', array());
		wp_register_style( 'font-awesome-5-all', ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/all.min.css',	false);//load elementor fontawesome
	 }
 
	 

     public function get_script_depends() {
		if (\Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode()) {
			return [ 'swiper','twae-horizontal-js' ];
		}
		 $settings = $this->get_settings_for_display();
		$layout = $settings['twae_layout'];
		if($layout == 'horizontal'){
			return [ 'swiper','twae-horizontal-js' ];
		}else{
			return [];	
		}
     }
 
     public function get_style_depends() {
		
		if (\Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode()) {
			return [ 'twae-centered-css','twae-horizontal-css','twae-fontello-css','twae-color-typography','font-awesome-5-all' ];
		}
		$settings = $this->get_settings_for_display();
		$layout = $settings['twae_layout']; 
		$styles = ['twae-fontello-css','font-awesome-5-all'];
		if($layout == 'horizontal'){
			array_push($styles, 'twae-horizontal-css');
		}else{
			array_push($styles, 'twae-centered-css');
		}
		array_push($styles, 'twae-color-typography');
		return $styles ;
     }
	
	public function get_name() {
		return 'timeline-widget-addon';
	}

	public function get_title() {
		return __( 'Story Timeline', 'twae' );
	}

	public function get_icon() {
		return 'eicon-time-line';
	}

	public function get_categories() {
		return [ 'twae' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'twae_layout_section',
			[
				'label' => __( 'Layout Settings', 'twae' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
	
		$this->add_control(
			'twae_layout',
			[
				'label' => __( 'Layout', 'twae' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'centered',
				'options'=>[
					'centered'=>'Both Sided',
					'one-sided'=>'One Sided',
					'horizontal'=>'Horizontal',
				],
				'default' => 'centered',
			]
		);

		$this->add_control(
			'twae_style_option',
			[
				'label' => __('','twae'),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<span class="twae-option-label">'.__('Style','twae').'</span><a  href="'.TWAE_BUY_PRO_LINK.'" target="_blank"><span class="twae-pro-label">'.__('Pro','twae').'</span></a>
							<select name="twae_style" disabled>				
								<option value="style-1">Classic</option>	
							</select>',
				'content_classes' => 'twae_style_option',
			]
		);
				
		$this->add_control(
			'twae_slides_to_show',
			[
				'label' => __( 'Slides To Show', 'twae' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '2',
				'condition'   => [
					'twae_layout'   => [
					   'horizontal'
					],
				]
			]
		);

		$this->add_control(
			'twae_slides_height',
			[
				'label' => __( 'Equal Height Slides', 'twae' ),
				'description' => __('Make all slides the same height based on the tallest slide','twae'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'no-height',
				'options'=>[
					'auto-height'=>'Yes',
					'no-height'=>'No',
				],
				'condition'   => [
					'twae_layout'   => [
					   'horizontal'
					],
				]
			]
		);

		$this->add_control(
			'twae_autoplay',
			[
				'label' => __( 'Autoplay', 'twae' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'false',
				'options'=>[
					'true'=>'True',
					'false'=>'False',
				],
				'condition'   => [
					'twae_layout'   => [
					   'horizontal'
					],
				]
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'twae_Basic_styles_section',
			[
				'label' => __( 'Color & Typography Settings', 'twae' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'twae_title_section',
				[
					'label' => __( 'Title', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::HEADING,
				]
			);
			
			/*---- Story Title ----*/
			$this->add_control(
				'twae_story_title_color',
				[
					'label' => __( 'Color', 'twae' ),
					'type' => Controls_Manager::COLOR,
					'scheme' => [
						'type' => Elementor\Core\Schemes\Color::get_type(),
						'value' => Elementor\Core\Schemes\Color::COLOR_1,
					],
					'selectors' => [
						'{{WRAPPER}} .twae-wrapper .twae-data-container span.twae-title' => 'color: {{twae_story_title_color}}',
						'{{WRAPPER}} .twae-horizontal span.twae-title' => 'color: {{twae_story_title_color}}',
					],
					//'default' => '#23A455',
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'twae_title_typography',
					'label' => __( 'Typography', 'twae' ),
					'selector' => '{{WRAPPER}} .twae-wrapper span.twae-title',
				]
			);			

		$this->add_control(
			'twae_label_section',
			[
				'label' => __( 'Primary Label', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'twae_date_label_color',
			[
				'label' => __( 'Color', 'twae' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Elementor\Core\Schemes\Color::get_type(),
					'value' => Elementor\Core\Schemes\Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .twae-wrapper span.twae-label' => 'color: {{twae_date_label_color}}',
				],
				//'default' => '#23A455',
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'twae_label_typography',
				'label' => __( 'Typography', 'twae' ),
				'selector' => '{{WRAPPER}} .twae-wrapper span.twae-label',
			]
		);

		$this->add_control(
			'twae_description_section',
			[
				'label' => __( 'Description', 'twae' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'twae_description_color',
			[
				'label' => __( 'Color', 'twae' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Elementor\Core\Schemes\Color::get_type(),
					'value' => Elementor\Core\Schemes\Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .twae-wrapper .twae-description' => 'color: {{twae_description_color}}',
				],
				//'default' => '#333333',
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'twae_description_typography',
				'label' => __( 'Typography', 'twae' ),
				'selector' => '{{WRAPPER}} .twae-wrapper .twae-description',
			]
		);

		$this->add_control(
			'twae_middle_line_section',
			[
				'label' => __( 'Middle Line', 'twae' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'twae_line_color',
			[
				'label' => __( 'Line Color', 'twae' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .twae-wrapper .twae-line::before' => 'background-color: {{twae_line_color}}',
					'{{WRAPPER}} .twae-wrapper .twae-timeline-centered .twae-icon' => 'border-color: {{twae_line_color}}',
					'{{WRAPPER}} .twae-wrapper .twae-timeline-centered .twae-year' => 'border-color: {{twae_line_color}}',
					'{{WRAPPER}} .twae-wrapper:before' => 'background-color: {{twae_line_color}}',
					'{{WRAPPER}} .twae-wrapper:after' => 'background-color: {{twae_line_color}}',
					'{{WRAPPER}} .twae-horizontal .twae-pagination.swiper-pagination-progressbar' => 'background-color: {{twae_line_color}}',
					'{{WRAPPER}} .twae-horizontal .twae-button-prev' => 'color: {{twae_line_color}}',
					'{{WRAPPER}} .twae-horizontal .twae-button-next' => 'color: {{twae_line_color}}',
				],
				//'default' => '#D6D6D6',
			]
		);

		
		$this->add_control(
			'twae_icon_section',
			[
				'label' => __( 'Icon/Icon placeholder', 'twae' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'twae_icon_bgcolor',
			[
				'label' => __( 'Background Color', 'twae' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Elementor\Core\Schemes\Color::get_type(),
					'value' => Elementor\Core\Schemes\Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .twae-wrapper .twae-icon' => 'background-color: {{twae_icon_bgcolor}}',
					'{{WRAPPER}} .twae-horizontal .twae-story-info' => 'border-color: {{twae_icon_bgcolor}}',	
					'{{WRAPPER}} .twae-horizontal .twae-story-info:before' => 'border-bottom-color: {{twae_icon_bgcolor}}',	
					'{{WRAPPER}} .twae-wrapper .twae-data-container:after' => 'border-right-color: {{twae_icon_bgcolor}}',
					'{{WRAPPER}} .twae-wrapper .twae-right-aligned .twae-data-container' => 'border-left-color: {{twae_icon_bgcolor}}',
					'body[data-elementor-device-mode=desktop] {{WRAPPER}} .twae-wrapper .twae-left-aligned .twae-data-container,
					body[data-elementor-device-mode=tablet] {{WRAPPER}} .twae-wrapper .twae-left-aligned .twae-data-container' => 'border-right-color: {{twae_icon_bgcolor}}',
					'body[data-elementor-device-mode=mobile] {{WRAPPER}} .twae-wrapper .twae-left-aligned .twae-data-container' => 'border-left-color: {{twae_icon_bgcolor}}',
				],
				//'default' => '#23A455',
			]
		);

		$this->add_control(
			'twae_story_bgcolor_section',
			[
				'label' => __( 'Story Background', 'twae' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'twae_story_bgcolor',
			[
				'label' => __( 'Background Color', 'twae' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .twae-wrapper .twae-data-container' => 'background-color: {{twae_story_bgcolor}}',
					'{{WRAPPER}} .twae-wrapper .twae-icon' => 'color: {{twae_story_bgcolor}}',
					'{{WRAPPER}} .twae-horizontal .twae-story-info' => 'background-color: {{twae_story_bgcolor}}',

					'{{WRAPPER}} .twae-horizontal .twae-story-info.twae-no-border' => 'border-color: {{twae_story_bgcolor}}',					
					'{{WRAPPER}} .twae-horizontal .twae-story-info.twae-no-border:before' => 'border-bottom-color: {{twae_story_bgcolor}}',	
					'{{WRAPPER}} .twae-wrapper .twae-data-container.twae-no-border:after' => 'border-right-color: {{twae_story_bgcolor}}',
					'{{WRAPPER}} .twae-wrapper .twae-right-aligned .twae-data-container.twae-no-border' => 'border-left-color: {{twae_story_bgcolor}}',
					'body[data-elementor-device-mode=desktop] {{WRAPPER}} .twae-wrapper .twae-left-aligned .twae-data-container.twae-no-border,
					body[data-elementor-device-mode=tablet] {{WRAPPER}} .twae-wrapper .twae-left-aligned .twae-data-container.twae-no-border' => 'border-right-color: {{twae_story_bgcolor}}',
					'body[data-elementor-device-mode=mobile] {{WRAPPER}} .twae-wrapper .twae-left-aligned .twae-data-container.twae-no-border' => 'border-left-color: {{twae_story_bgcolor}}',
				
				],
				//'default' => '#fff9ed',

			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'twae_extra_styles_section',
			[
				'label' => __( 'Extra Settings', 'twae' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
			
			/*---- Year Label ----*/
			$this->add_control(
				'twae_year_label_section',
				[
					'label' => __( 'Middle Line Label', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			
			$this->add_control(
				'twae_year_label_color',
				[
					'label' => __( 'Color', 'twae' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .twae-wrapper .twae-year' => 'color: {{twae_year_label_color}}',
					],
					//'default' => '#ffffff',
				]
			);
			
			$this->add_control(
				'twae_year_label_bgcolor',
				[
					'label' => __( 'Background Color', 'twae' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .twae-wrapper .twae-year' => 'background-color: {{twae_year_label_bgcolor}}',
					],
					//'default' => '#54595F',
				]
			);		

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'twae_year_typography',
					'label' => __( 'Typography', 'twae' ),
					'selector' => '{{WRAPPER}} .twae-wrapper .twae-year',
				]
			);

			/*---- Sub Label ----*/
			$this->add_control(
				'twae_sub_label_section',
				[
					'label' => __( 'Sub Label', 'twae' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'twae_extra_label_color',
				[
					'label' => __( 'Color', 'twae' ),
					'type' => Controls_Manager::COLOR,
					'scheme' => [
						'type' => Elementor\Core\Schemes\Color::get_type(),
						'value' => Elementor\Core\Schemes\Color::COLOR_3,
					],
					'selectors' => [
						'{{WRAPPER}} .twae-wrapper span.twae-extra-label' => 'color: {{twae_extra_label_color}}',
					],
					//'default' => '#7A7A7A',
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'twae_extra_label_typography',
					'label' => __( 'Typography', 'twae' ),
					'selector' => '{{WRAPPER}} .twae-wrapper span.twae-extra-label',
				]
			);

			/*---- Icon ----*/
			$this->add_control(
				'twae_icon_styles_section',
				[
					'label' => __( 'Icon', 'twae' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'twae_icon_size',
				[
					'label' => __( 'Icon Size', 'twae' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 12,
							'max' => 36,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .twae-wrapper .twae-icon i' => 'font-size: {{SIZE}}{{UNIT}}',
					],
					//'default' => '.75rem',
				]
			);
	
			$this->add_control(
				'twae_icon_padding',
				[
					'label' => __( 'Icon Padding', 'twae' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .twae-wrapper .twae-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			/*---- Icon ----*/
			$this->add_control(
				'twae_border_section',
				[
					'label' => __( 'Border', 'twae' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'twae_border',
				[
					'label' => __( 'Border', 'twae' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'your-plugin' ),
					'label_off' => __( 'Hide', 'your-plugin' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'twae_content_section',
			[
				'label' => __( 'Timeline Stories', 'twae' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->start_controls_tabs(
			'twae_story_tabs'
		);

		$repeater->start_controls_tab(
			'twae_content_tab',
			[
				'label' => __( 'Content', 'twae' ),
			]
		);	



		$repeater->add_control(
			'twae_date_label',
			[
				'label' => __( 'Primary Label', 'twae' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '01 Jan 2020',
			]
		);

		$repeater->add_control(
			'twae_extra_label',
			[
				'label' => __( 'Sub Label', 'twae' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Sub Label',
			]
		);

		$repeater->add_control(
			'twae_story_title',
			[
				'label' => __( 'Timeline Story Title', 'twae' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Timeline Story',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'twae_image',
			[
				'label' => __( 'Choose Image', 'twae' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => __('Image Size will not work with default image','twae'),
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		

		$repeater->add_control(
			'twae_description',
			[
				'label' => __( 'Description', 'twae' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => 'Add Description Here',
			]
		);
	
		
		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'twae_advanced_tab',
			[
				'label' => __( 'Extra Settings', 'twae' ),
			]
		);

		$repeater->add_control(
			'twae_show_year_label',
			[
				'label' => __( 'Middle Line Label', 'twae' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'twae' ),
				'label_off' => __( 'Hide', 'twae' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$repeater->add_control(
			'twae_year',
			[
				'label' => __( 'Label Text', 'twae' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '2020',
				'condition'   => [
					'twae_show_year_label'   => [
					   'yes'
					],
				]

			]
		);
			
		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[ 
				 
				'name' => 'twae_thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'separator' => 'none',
			]
		);

		$repeater->add_control(
			'twae_image_size_notice',
			[
				'label' => __( 'Image Size will not work with default image', 'twae' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'none',				
			]
		);

		$repeater->add_control(
			'twae_story_icon',
			[
				'label' => __( 'Icon', 'twae' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fab fa-amazon',
					'library' => 'solid',
				],
			]
		);

		$repeater->add_control(
			'twae_pro_options',
			[
				'label' => __('','twae'),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '
				<strong>'.__('Timeline Widget Addon','twae'). '</strong> 
				<a href="'.TWAE_BUY_PRO_LINK.'" target="_blank"><span class="twae-pro-label">'.__('Pro','twae').'</a></span>',
				'content_classes' => 'twae_pro_options',
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'twae_pro_content',
			[
				'label' => '',
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<a target="_blank" href="'.TWAE_BUY_PRO_LINK.'"><img class="twae-screenshots" src="'.TWAE_URL  . 'assets/images/slideshow-images.png"></a></br>
							<a target="_blank" href="'.TWAE_BUY_PRO_LINK.'"><img class="twae-screenshots" src="'.TWAE_URL  . 'assets/images/story-custom-colors.png"></a>',
				'content_classes' => 'twae_pro_content',
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'twae_list',
			[
				
				'label' => __( 'Content', 'twae' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'twae_story_title' => __( 'Amazon Founded', 'twae' ),
						'twae_description' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Erat enim res aperta. Ne discipulum abducam, times. Primum quid tu dicis breve? An haec ab eo non dicuntur?','twae'),
						'twae_year'			=> __('1994','twae'),
						'twae_date_label'   => __('Jul 1994','twae'),
						'twae_extra_label'  => __('Amazon History','twae'),
						'twae_image' =>[
							'url' => TWAE_URL  . 'assets/images/amazon-1.png',	
							'id' => '',						
						],
					],
					[
						'twae_story_title' => __( 'Amazon Prime Services', 'twae' ),
						'twae_description' => __('Aliter homines, aliter philosophos loqui putas oportere? Sin aliud quid voles, postea. Mihi enim satis est, ipsis non satis. Negat enim summo bono afferre incrementum diem. Quod ea non occurrentia fingunt, vincunt Aristonem.','twae'),
						'twae_year'			=> __('2005','twae'),
						'twae_date_label'   => __('Feb 2005','twae'),
						'twae_extra_label'  => __('Amazon History','twae'),
						'twae_image' =>[
							'url' => TWAE_URL  . 'assets/images/amazon-2.png',
							'id' => '',							
						],
						
					],
					[
						'twae_story_title' => __( 'Amazon Announced Amazon Fresh Pickup', 'twae' ),
						'twae_description' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.','twae'),
						'twae_year'			=> __('2007','twae'),
						'twae_date_label'   => __('Aug 2007','twae'),
						'twae_extra_label'  => __('Amazon History','twae'),
						'twae_image' =>[
							'url' => TWAE_URL  . 'assets/images/amazon-3.png',
							'id' => '',						
						],
					],
				],
				'title_field' => '{{{ twae_story_title }}}',
			]
		);

		$this->end_controls_section();


		
        $this->start_controls_section(
			'twae_advanced_section',
			[
				'label' => __( 'Advanced Settings', 'twae' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'twae_animation_option',
			[
				'label' => __('','twae'),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => __('Animation','twae').' <a target="_blank" href="'.TWAE_BUY_PRO_LINK.'"><span class="twae-pro-label">'.__('Pro','twae').'</span></a><select name="twae_animation" disabled>				
					<option value="style-1">Fade</option>		
				</select>',
				'content_classes' => 'twae_animation_option',
			]
		);

		/* $this->add_control(
			'twae_image_size_notice',
			[
				'label' => __( 'Pro version more features', 'twae' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'none',				
			]
		);
		
		$this->add_control(
			'twae_pro_features_1',
			[
				'label' => __( '', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<div class="twae-pro-features"><ul>			
							<li>3 styles in each layout( Both Sided, One Sided, Horizontal )</li>
							<li>Images Slideshow/Video</li>
							<li>Animation Effects</li>
							<li>Custom text or image as icon</li>
							<li>Custom Color for each Timeline Story</li>
							<li>Icons enable/disable option</li>
							<li>Post Timeline( Timeline of blog posts )</li>
							<li>Pagination( for Post Timeline )</li>
							</ul></br>
							<a href="https://cooltimeline.com/elementor-timeline-widget-pro-demo/">'.__('View Demo','twae').'</a>
						</div>',
				'content_classes' => 'twae-pro-features-list',
			]
		); */


		$this->end_controls_section();		
		
        $this->start_controls_section(
			'twae_pro_feature_section',
			[
				'label' => __( 'Pro Features', 'twae' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
 
		$this->add_control(
			'twae_pro_features',
			[
				'label' => __( '', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '
				<style>.twae-pro-features ul li p {
    padding: 5px;
}</style>
				<div class="twae-pro-features"><ul>			
							<li><strong>15+ Timeline Designs</strong>
							<p>Create beautiful vertical & horizontal timeline designs.</p>
							</li>
							<li><strong>Post Timeline</strong>
							<p>Show your blog posts in a timeline layout anywhere on the website.</p>
							</li>
							<li><strong>Animation Effect</strong>
							<p>It has 15+ animation effects, fade-in, flip-up, zoom, etc.</p>
							</li>
							<li><strong>Colors & Typography</strong>
							<p>Use the advanced settings option to manage text size and colors.</p>
							</li>
							<li><strong>Custom Color Story</strong>
							<p>Easily apply different colors to each story in a timeline.</p>
							</li>

							<li><strong>Image / Video / Slideshow</strong>
							<p>Add image, video, or slideshow image.</p>
							</li>
							<li><strong>Ajax Load More</strong>
							<p>Load stories with page scroll via ajax pagination.</p>
							</li>

							<li><strong>Icons in Timeline</strong>
							<p>Font Awesome icon, custom text, or image as timeline Icon.</p>
							</li>
							</ul></br>
							<a target="_blank" href="'.TWAE_VIEW_DEMO.'">'.__('View Demo','twae').'</a> |
							<a  style="padding:6px;" class="elementor-button elementor-button-success" href="'.TWAE_BUY_PRO_LINK.'" target="_blank"> Buy PRO</a>
						</div>',
				'content_classes' => 'twae-pro-features-list',
			]
		);

		$this->end_controls_section();

	}

	// for frontend
	protected function render() {

		$settings = $this->get_settings_for_display();
		$data	  = $settings['twae_list'];
		$layout = $settings['twae_layout'];
		$autoplay = $settings['twae_autoplay'];
		$sidesHeight = $settings['twae_slides_height'];
		$border = $settings['twae_border'];	
		$no_border = '';
		if($border !='yes'){
			$no_border = 'twae-no-border';
		}	
		
		$isRTL = is_rtl();
		$dir = '';
		if($isRTL){
			$dir = 'rtl';
		}

			$timeline_layout_wrapper = "twae-centered";
			$timeline_layout = '';
			if($layout == 'one-sided'){
				$timeline_layout = "twae-one-sided-timeline";
				$timeline_layout_wrapper = "twae-one-sided-wrapper";
			}

			$countItem = 1;
			if($layout == 'horizontal'){
				$timeline_layout = "twae-horizontal-timeline";
				$timeline_layout_wrapper = "twae-horizontal-wrapper";
				require TWAE_PATH . 'widgets/frontend-layouts/twae-horizontal-timeline.php';
							
				
			}else{
				require TWAE_PATH . 'widgets/frontend-layouts/twae-centered-timeline.php';
			}
			
		
	}

	// for live editor
 	protected function content_template() {
		
		?>
	<#
		if( settings.twae_list ) {
			
			#>
				<?php
				$isRTL = is_rtl();
				$dir = '';
				if($isRTL){
					$dir = 'rtl';
				}
				?>
			<#	
				var border = settings.twae_border;	
				var no_border = '';
				if(border !='yes'){
					no_border = 'twae-no-border';
				}

			if(settings.twae_layout == 'horizontal'){
				var sidesToShow = settings.twae_slides_to_show;
				var sidesHeight = settings.twae_slides_height;
				var autoplay = settings.twae_autoplay;
				if(sidesToShow==''){
					sidesToShow = 2;
				}
				#>
				<?php require TWAE_PATH . 'widgets/editor-layouts/horizontal-template.php';
						
				?>
				<#		
				
			}
			else{
				#>	
			
				<?php require TWAE_PATH . 'widgets/editor-layouts/vertical-template.php'; ?>
			<#
				}		
		}	
		
		#>
		<?php 
		
	} 

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TWAE_Widget() );

