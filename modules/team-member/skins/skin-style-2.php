<?php
namespace EpicJungleElementor\Modules\TeamMember\Skins;

use Elementor\Widget_Base;
use Elementor\Skin_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class  Skin_Style_2 extends Skin_Base {
	
	public function __construct( Widget_Base $parent ) {
		$this->parent = $parent;

		add_filter( 'elementor/widget/print_template', array( $this, 'skin_print_template' ), 10, 2 );
	}

	public function get_id() {
		return 'style-2';
	}

	public function get_title() {
		return esc_html__( 'Estilo 2', 'epicjungle-elementor' );
	}

	
	public function render() {
		$settings = $this->parent->get_settings_for_display(); 
		

		$this->parent->add_render_attribute( 'skin_title', 'class', 'ej-elementor-team-member-skin__name card-title mb-1' );
		$this->parent->add_inline_editing_attributes( 'skin_title' );

		if ( ! empty( $settings[ 'skin_title_css_class' ] ) ) {
            $this->parent->add_render_attribute( 'skin_title', 'class', $settings[ 'skin_title_css_class' ] );
        }


		$this->parent->add_render_attribute( 'skin_position', 'class', 'ej-elementor-team-member-skin__position mb-0' );
		$this->parent->add_inline_editing_attributes( 'skin_position' );

		if ( ! empty( $settings[ 'skin_position_css_class' ] ) ) {
            $this->parent->add_render_attribute( 'skin_position', 'class', $settings[ 'skin_position_css_class' ] );
        }

		$has_image = $settings['skin_team_author_image' ]['url'];
	
		
		?>
		
			
		<div class="team-style-2 ej-elementor-card card<?php echo esc_attr( $settings['show_team_card_border'] !== 'yes' ? ' border-0' : '');?><?php echo esc_attr( $settings['show_team_card_box_shadow'] == 'yes' ? ' box-shadow' : '');?>">

			<?php if ( ! empty( $has_image ) ) : ?>
			  	<div class="card-img">
			    	<img src="<?php echo esc_attr ( $has_image ); ?>" alt="..."/>
			  	</div>
			<?php endif; ?>

			<?php if ( ! empty( $settings['skin_title'] ) || ! empty( $settings['skin_position'] ) || ( $has_icon && 'yes' == $settings['show_social_icon'] ) ) : ?>
				<div class="card-img-overlay justify-content-end text-center">
					<?php if ( ! empty( $settings['skin_title'] ) ): ?>
						<!-- Title -->
						<<?php echo $settings['title_tag'] . ' ' . $this->parent->get_render_attribute_string( 'skin_title' ); ?>><?php echo $settings['skin_title'] . '</' . $settings['title_tag']; ?>>
					<?php endif;

					if ( ! empty( $settings['skin_position'] ) ): ?>
						<p <?php echo $this->parent->get_render_attribute_string( 'skin_position' ); ?>><?php echo $settings['skin_position']; ?></p> 
					<?php endif; ?>	
					<?php if ( 'yes' == $settings['show_social_icon'] ) : ?>
						<div class="team-style-2-social-icons d-flex justify-content-center align-items-center">

							<?php foreach ( $settings ['skin_social_icon'] as $index => $item ) {
								$migrated = isset( $item['__fa4_migrated']['skin_selected_icon'] );

								$is_new = empty( $item['skin_item_icon'] ) && Icons_Manager::is_migration_allowed();
								$has_icon = ( ! $is_new || ! empty( $item['skin_selected_icon']['value'] ) );	
								
							if ( $is_new || $migrated ) { ?>
								<a href="<?php echo esc_attr( $item['skin_icon_link']['url'] ); ?>" class="text-decoration-none p-1 mx-2"><?php Icons_Manager::render_icon( $item['skin_selected_icon']); ?></a>
							<?php } else { ?>
								<a href="<?php echo esc_attr( $item['skin_icon_link']['url'] ); ?>" class="text-decoration-none p-1 mx-2"><i class="<?php echo esc_attr( $item['skin_item_icon'] ); ?>" aria-hidden="true"></i></a>
							<?php } 
						} ?>
							
						</div>
					<?php endif; ?>
					
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

	public function skin_print_template( $content, $widget ) {
		if( 'ej-team-member' == $widget->get_name() ) {
			return '';
		}
		return $content;
	}
	
}