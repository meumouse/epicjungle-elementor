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

class Skin_Horizontal extends Skin_Base {

	public function __construct( Widget_Base $parent ) {
		$this->parent = $parent;

		add_filter( 'elementor/widget/print_template', array( $this, 'skin_print_template' ), 10, 2 );
	}

	public function get_id() {
		return 'horizontal';
	}

	public function get_title() {
		return esc_html__( 'Plano de preços horizontais', 'epicjungle-elementor' );
	}

	public function render() {

		$settings = $this->parent->get_settings();

	
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

		$this->parent->add_render_attribute( 'skin_title', 'class', 'ej-elementor-price-table-skin__title mb-2' );
		$this->parent->add_inline_editing_attributes( 'skin_title' );

		$this->parent->add_render_attribute( 'skin_description', 'class', 'ej-elementor-price-table-skin__description' );
		$this->parent->add_inline_editing_attributes( 'skin_description' );

		if ( ! empty( $settings['description_css_class' ] ) ) {
            $this->parent->add_render_attribute( 'skin_description', 'class', $settings[ 'description_css_class' ] );    
        }

		$this->parent->add_render_attribute( 'price_subtext', 'class', [ 'ej-elementor-price-table__subtext mb-2' ] );
		$this->parent->add_inline_editing_attributes( 'price_subtext' );

		$this->parent->add_render_attribute( 'skin_features_list', 'class', 'ej-elementor-price-table-skin__features_ist' );
		$this->parent->add_inline_editing_attributes( 'skin_features_list' );


		$migration_allowed = Icons_Manager::is_migration_allowed();
		$skin_link_icon_migrated = isset( $settings['__fa4_migrated']['skin_link_selected_icon'] );
		$is_new_skin_link_icon = empty( $settings['skin_link_icon'] ) && $migration_allowed;

		?>
			
		<div class="ej-elementor-price-table__horizontal d-sm-flex align-items-start border-bottom py-4 py-sm-5">
			<?php if ( ! empty( $settings['skin_title'] ) ||  ! empty( $settings['skin_description'] ) ): ?>
				<div class="ej-elementor-price-table__title ml-4 ml-sm-0 py-2 w-100">
					<?php if ( ! empty( $settings['skin_title'] ) ): ?>
						<!-- Heading -->
						<<?php echo $settings['skin_title_tag'] . ' ' . $this->parent->get_render_attribute_string( 'skin_title' ); ?>><?php echo $settings['skin_title'] . '</' . $settings['skin_title_tag']; ?>>
					<?php endif; ?>

					<?php if ( ! empty( $settings['show_description']) && ! empty( $settings['skin_description'] ) ): ?>
						<!-- Text -->
						<div <?php echo $this->parent->get_render_attribute_string( 'skin_description' ); ?> style="max-width: 10rem;"><?php echo $settings['skin_description']; ?></div>
					<?php endif; ?>

				</div>
			<?php endif; ?>


			<?php if (   '' !== $settings['price'] && $settings[ 'show_price' ] == 'yes' ): ?>
				<div class="ej-elementor-price-table__price d-flex w-100 align-items-end py-3 py-sm-2 px-4">
					
						<?php if ( '' !== $settings['price'] ) : $this->parent->render_currency_symbol( $symbol, 'before' ); endif; ?>

						<?php if ( ( ! empty( $intpart ) || 0 <= $intpart ) ) : ?>
							<span class="ej-elementor-price-table__integer-part price cs-price <?php echo esc_attr( $settings[ 'pricing_css_class' ] ); ?>" data-current-price="<?php echo esc_attr( $settings['price']); ?>" data-new-price="<?php echo esc_attr( $settings['new_price']); ?>"><?php echo $intpart; ?></span>

						<?php endif; ?>

						<?php if ( '' !== $settings['price'] ) : $this->parent->render_currency_symbol( $symbol, 'after' ); endif; ?>
						
						<?php if ( '' !== $settings['price'] && ! empty( $settings['price_subtext'] ) ): ?>
							<span <?php echo $this->parent->get_render_attribute_string( 'price_subtext' ); ?>><?php echo wp_kses_post( $settings['price_subtext'] ); ?></span>
						<?php endif; ?>
					</div>
		
				<?php endif; ?>
				

			<?php if ( ! empty( $settings['features_list'] ) && $settings[ 'show_features' ] == 'yes' ) : ?>
				<ul class="ej-elementor-price-table__features-list list-unstyled py-2 mb-0">
					<?php

					foreach ( $settings['features_list'] as $index => $item ) : 
						$repeater_setting_key = $this->parent->get_repeater_setting_key( 'item_text', 'skin_features_list', $index );


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
			<?php endif; ?>
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