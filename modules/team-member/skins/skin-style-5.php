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

class  Skin_Style_5 extends Skin_Base {
	
	public function __construct( Widget_Base $parent ) {
		$this->parent = $parent;

		add_filter( 'elementor/widget/print_template', array( $this, 'skin_print_template' ), 10, 2 );
	}

	public function get_id() {
		return 'style-5';
	}

	public function get_title() {
		return esc_html__( 'Estilo 5', 'epicjungle-elementor' );
	}

	
	public function render() {
		$settings = $this->parent->get_settings_for_display(); 
		

		$this->parent->add_render_attribute( 'skin_title', 'class', 'ej-elementor-team-member-skin__name card-title pt-1 mb-1' );
		$this->parent->add_inline_editing_attributes( 'skin_title' );

		if ( ! empty( $settings[ 'title_css_class' ] ) ) {
            $this->parent->add_render_attribute( 'skin_title', 'class', $settings[ 'title_css_class' ] );
        }


		$this->parent->add_render_attribute( 'skin_position', 'class', 'ej-elementor-team-member-skin__position' );
		$this->parent->add_inline_editing_attributes( 'skin_position' );

		if ( ! empty( $settings[ 'position_css_class' ] ) ) {
            $this->parent->add_render_attribute( 'skin_position', 'class', $settings[ 'position_css_class' ] );
        }


		$has_image = $settings['skin_team_author_image' ]['url'];
	
		?>
		
		<div class="ej-elementor-team-member-3 team-style-5">

			<div class="card w-100 mb-4 mr-4<?php echo esc_attr( $settings['show_team_card_border'] !== 'yes' ? ' border-0' : '');?><?php echo esc_attr( $settings['show_team_card_box_shadow'] == 'yes' ? ' box-shadow' : '');?>">
				<div class="card-body">
					<?php if ( ! empty( $has_image ) && 'yes' == $settings['show_team_image'] ) : ?>
				    	<img src="<?php echo esc_attr ( $has_image ); ?>" class="d-inline-block mb-3 <?php echo esc_attr( $settings[ 'author_image_border-radius' ] ); ?>" width="96" alt="..."/>
				    
					<?php endif; ?>

					<?php if ( ! empty( $settings['skin_title'] ) ): ?>
						<!-- Title -->
						<<?php echo $settings['title_tag'] . ' ' . $this->parent->get_render_attribute_string( 'skin_title' ); ?>><?php echo $settings['skin_title'] . '</' . $settings['title_tag']; ?>>
					<?php endif;

					if ( ! empty( $settings['skin_position'] ) ): ?>
						<p <?php echo $this->parent->get_render_attribute_string( 'skin_position' ); ?>><?php echo $settings['skin_position']; ?></p> 
					<?php endif; ?>	

					<?php if ( ! empty( $settings['skin_contact_number'] ) || ! empty( $settings['skin_contact_email'] ) ): ?>
					 	<ul class="font-size-sm list-unstyled mb-4">
					 		<?php if ( ! empty( $settings['skin_contact_number'] ) ) : ?>
			                    <li><i class="fe fe-phone mr-2"></i><a class="nav-link-style" href="tel:<?php echo $settings['skin_contact_number']; ?>"><?php echo $settings['skin_contact_number']; ?></a></li>
			                <?php endif; ?>

			                <?php if ( ! empty( $settings['skin_contact_email'] ) ) : ?>
		                    	<li class="mb-0"><i class="fe fe-mail mr-2"></i><a class="nav-link-style" href="<?php echo $settings['skin_contact_email']; ?>"><?php echo $settings['skin_contact_email']; ?></a></li>
		                    <?php endif; ?>
		                 </ul>
	             	<?php endif; ?>

				 	<?php if ( 'yes' == $settings['show_social_icon'] ) : ?>
						<div class="team-style-3-social-icons">

							<?php foreach ( $settings ['skin_social_icon'] as $index => $item ) {

								$migrated = isset( $item['__fa4_migrated']['skin_selected_icon'] );

								$is_new = empty( $item['skin_item_icon'] ) && Icons_Manager::is_migration_allowed();

								$has_icon = ( ! $is_new || ! empty( $item['skin_selected_icon']['value'] ) );
								
								$icon_selected_value = '';
								if ( strpos( $item['skin_selected_icon']['value'], 'fe-' ) !== false ) {
			                        $icon_selected_value = ' ' . str_replace( 'fe-', 'sb-', $item['skin_selected_icon']['value'] );
			                    } 
									
								if ( $is_new || $migrated ) { ?>
									<a href="<?php echo esc_attr( $item['skin_icon_link']['url'] ); ?>" class="social-btn sb-sm mr-2 mb-2<?php echo esc_attr( $settings[ 'team_social_buttons_style' ] != '' ? ' ' . $settings[ 'team_social_buttons_style' ] : '' ); ?><?php echo esc_attr( $icon_selected_value ); ?>"><?php Icons_Manager::render_icon( $item['skin_selected_icon']); ?></a>
								<?php } else { ?>
									<a href="<?php echo esc_attr( $item['skin_icon_link']['url'] ); ?>" class="social-btn sb-sm mr-2 mb-2<?php echo esc_attr( $settings[ 'team_social_buttons_style' ] != '' ? ' ' . $settings[ 'team_social_buttons_style' ] : '' ); ?>"><i class="<?php echo esc_attr( $item['skin_item_icon'] ); ?>" aria-hidden="true"></i></a>
								<?php } ?>
							<?php } ?>
							
						</div>
					<?php endif; ?>	
				</div>
			</div>
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