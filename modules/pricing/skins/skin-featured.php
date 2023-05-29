<?php
namespace EpicJungleElementor\Modules\Pricing\Skins;

use Elementor\Widget_Base;
use Elementor\Skin_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Featured extends Skin_Base {

	public function __construct( Widget_Base $parent ) {
		$this->parent = $parent;

		add_filter( 'elementor/widget/print_template', array( $this, 'skin_print_template' ), 10, 2 );
	}

	public function get_id() {
		return 'featured';
	}

	public function get_title() {
		return esc_html__( 'Plano de preços em destaque', 'epicjungle-elementor' );
	}


	public function render() {
		$settings = $this->parent->get_settings_for_display();

		$symbol = '';

		if ( ! empty( $settings['currency_symbol'] ) ) {
			if ( 'custom' !== $settings['currency_symbol'] ) {
				$symbol = $this->parent->get_currency_symbol( $settings['currency_symbol'] );
			} else {
				$symbol = $settings['currency_symbol_custom'];
			}
		}

		$currency_format = empty( $settings['currency_format'] ) ? '.' : $settings['currency_format'];
		$price = explode( $currency_format, $settings['price'] );

		$intpart = $price[0];

		$this->parent->add_render_attribute( 'button_text', 'class', [
			'ej-elementor-price-table__button',
			'btn',

		] );

		if ( ! empty( $settings['button_type'] ) ) {
			$this->parent->add_render_attribute( 'button_text', 'class', 'btn-' . $settings['button_type'] );
		}


		if ( ! empty( $settings['button_size'] ) ) {
			$this->parent->add_render_attribute( 'button_text', 'class', 'btn-' . $settings['button_size'] );
		}

		if ( $settings['hover_animation'] ) {
			$this->parent->add_render_attribute( 'button_text', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->parent->add_link_attributes( 'button_text', $settings['link'] );
		}

		if ( ! empty( $settings[ 'button_classes' ] ) ) {
			$this->parent->add_render_attribute( 'button_text', 'class', $settings['button_classes'] );
		}

		$this->parent->add_render_attribute( 'skin_featured_heading', 'class', 'ej-elementor-price-table__heading mb-0' );
		
		$this->parent->add_render_attribute( 'price_subtext', 'class', [ 'ej-elementor-price-table__subtext mb-2' ]);;

		$this->parent->add_inline_editing_attributes( 'skin_featured_heading' );

		// $this->add_inline_editing_attributes( 'price_subtext' );
		$this->parent->add_inline_editing_attributes( 'button_text' );
		

		$heading_tag = $settings['skin_featured_heading_tag'];
		

		$migration_allowed = Icons_Manager::is_migration_allowed();
		$button_icon_migrated = isset( $settings['__fa4_migrated']['button_selected_icon'] );
		$is_new_button_icon = empty( $settings['button_icon'] ) && $migration_allowed;

		// Pricing Table Header Content
		ob_start();
			?><div class="ej-elementor-price-table__heading-container text-center card-img-top bg-<?php echo esc_attr( $settings[ 'skin_featured_heading_background_color' ] ); ?> <?php echo esc_attr( $settings[ 'heading_css_class' ] ); ?>">
				<<?php echo $heading_tag . ' ' . $this->parent->get_render_attribute_string( 'skin_featured_heading' ); ?>><?php echo $settings['skin_featured_heading'] . '</' . $heading_tag; ?>>
			</div><?php 
		$pricing_table_header_content = ob_get_clean();


		// Pricing Table Price Content
		ob_start();
			if (  '' !== $settings['price'] && $settings[ 'show_price' ] == 'yes' ): ?>
			<div class="ej-elementor-price-table__price d-flex align-items-end py-2 px-4 mb-4">
				
				<?php if ( '' !== $settings['price'] ) : $this->parent->render_currency_symbol( $symbol, 'before' ); endif;?>

				<?php if ( ( ! empty( $intpart ) || 0 <= $intpart ) ) : ?>
					<span class="ej-elementor-price-table__integer-part price cs-price <?php echo esc_attr( $settings[ 'pricing_css_class' ] ); ?>" data-current-price="<?php echo esc_attr( $settings['price']); ?>" data-new-price="<?php echo esc_attr( $settings['new_price']); ?>"><?php echo $intpart; ?></span>
				<?php endif; ?>

				<?php if ( '' !== $settings['price'] ) : $this->parent->render_currency_symbol( $symbol, 'after' ); endif;?>
					
				<?php if ( '' !== $settings['price']  && ! empty( $settings['price_subtext'] ) ): ?>
					<span <?php echo $this->parent->get_render_attribute_string( 'price_subtext' ); ?>><?php echo wp_kses_post( $settings['price_subtext'] ); ?></span>
				<?php endif; ?>

			</div>
		<?php endif;
		$pricing_table_price_content = ob_get_clean();

		// Pricing Table Description Content
		ob_start();
			if ( $settings[ 'show_description' ] == 'yes' && ! empty( $settings['pricing_box_description'] ) ): ?>
				<p <?php echo $this->parent->get_render_attribute_string( 'pricing_box_description' ); ?>><?php echo $settings['pricing_box_description']; ?></p>
			<?php endif;
		$pricing_table_desciption_content = ob_get_clean();

		// Pricing Table Features Content
		ob_start();
			if ( ! empty( $settings['features_list'] ) && $settings[ 'show_features' ] == 'yes' ) : ?>
				<ul class="ej-elementor-price-table__features-list list-unstyled py-2 mb-4">
					<?php
					foreach ( $settings['features_list'] as $index => $item ) :
						$repeater_setting_key = $this->parent->get_repeater_setting_key( 'item_text', 'features_list', $index );


						$this->parent->add_inline_editing_attributes( $repeater_setting_key );

						$migrated = isset( $item['__fa4_migrated']['selected_item_icon'] );
						// add old default
						if ( ! isset( $item['item_icon'] ) && ! $migration_allowed ) {
							$item['item_icon'] = 'fe-check';
						}
						$is_new = ! isset( $item['item_icon'] ) && $migration_allowed;
						?>
						<li class="ej-list-item elementor-repeater-item-<?php echo $item['_id']; ?> d-flex align-items-center mb-3">
							<?php if ( ! empty( $item['item_icon'] ) || ! empty( $item['selected_item_icon'] ) ) : ?>

								<?php if ( $is_new || $migrated ) : ?>

								<?php Icons_Manager::render_icon( $item['selected_item_icon'], ['aria-hidden' => 'true', 'class' => 'mr-2']);
								else : ?>
									<i class="<?php echo esc_attr( $item['item_icon'] ); ?> mr-2" aria-hidden="true"></i>
								<?php endif; ?>

							<?php endif; ?>
							<?php if ( ! empty( $item['item_text'] ) ) : ?>
								<span <?php echo $this->parent->get_render_attribute_string( $repeater_setting_key ); ?>><?php echo $item['item_text']; ?></span>
							<?php else :
								echo '&nbsp;';
							endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif;
		$pricing_table_features_content = ob_get_clean();

		// Pricing Table Button Content
		ob_start();
			if ( ! empty( $settings['button_text'] ) && $settings[ 'show_button' ] == 'yes' ) : ?>
				<div class="text-center mb-2">
					<a <?php if ( $settings[ 'button_css_id' ] ): ?>id="<?php echo esc_attr( $settings[ 'button_css_id' ] ); ?>"<?php endif; ?> <?php echo $this->parent->get_render_attribute_string( 'button_text' ); ?>>		
						<?php echo $settings['button_text']; ?>
						<?php if ( ! empty( $settings['button_icon'] ) || ! empty( $settings['button_selected_icon']['value'] ) ) : ?>
							<?php if ( $is_new_button_icon || $button_icon_migrated ) :
								Icons_Manager::render_icon( $settings['button_selected_icon'], [ 'aria-hidden' => 'true', 'class' => 'mr-2' ] );
							else : ?>
								<i class="<?php echo esc_attr( $settings['button_icon'] ); ?> ml-3" aria-hidden="true"></i>
							<?php endif; ?>
						<?php endif; ?>
					</a>
				</div>
			<?php endif;
		$pricing_table_button_content = ob_get_clean();

		?>
		<div class="ej-elementor-price-table card card-active w-100 featured-card">

			<?php 
			if ( $settings['skin_featured_heading'] && ! empty( $settings['skin_featured_heading'] ) ): ?>
				<?php echo wp_kses_post( $pricing_table_header_content ); ?>

			<?php endif; ?>
			<div class="card-body px-grid-gutter py-grid-gutter"><?php
				echo wp_kses_post( $pricing_table_price_content );
				echo wp_kses_post( $pricing_table_desciption_content );
				echo wp_kses_post( $pricing_table_features_content ); 
				echo wp_kses_post( $pricing_table_button_content ); ?>
			</div>
		</div>			
		<?php
	}


	public function skin_print_template( $content, $widget ) {
		if( 'ej-pricing' == $widget->get_name() ) {
			return '';
		}
		return $content;
	}
}