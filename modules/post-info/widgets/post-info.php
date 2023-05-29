<?php
namespace EpicJungleElementor\Modules\PostInfo\Widgets;


use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Post_Info extends Base {

	public function get_name() {
		return 'ej-post-info';
	}

	public function get_title() {
		return __( 'Informações da postagem', 'epicjungle-elementor' );
	}

	public function get_icon() {
		return 'eicon-post-info';
	}

	public function get_keywords() {
		return [ 'post', 'info', 'date', 'time', 'author', 'taxonomy', 'comments', 'terms', 'avatar' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_icon',
			[
				'label' => esc_html__( 'Metadados', 'epicjungle-elementor' ),
			]
		);


		$repeater = new Repeater();

		$repeater->add_control(
			'type',
			[
				'label' => esc_html__( 'Tipo', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'author' => esc_html__( 'Autor', 'epicjungle-elementor' ),
					'date' => esc_html__( 'Data', 'epicjungle-elementor' ),
					'time' => esc_html__( 'Tempo', 'epicjungle-elementor' ),
					'comments' => esc_html__( 'Comentários', 'epicjungle-elementor' ),
					'terms' => esc_html__( 'Termos', 'epicjungle-elementor' ),
					'custom' => esc_html__( 'Personalizado', 'epicjungle-elementor' ),
				],
			]
		);

		$repeater->add_control(
			'date_format',
			[
				'label' => esc_html__( 'Formato de data', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'default' => 'Padrão',
					'0' => _x( 'March 6, 2022 (F j, Y)', 'Formato de data', 'epicjungle-elementor' ),
					'1' => '2018-03-06 (Y-m-d)',
					'2' => '03/06/2022 (m/d/Y)',
					'3' => '06/03/2022 (d/m/Y)',
					'custom' => esc_html__( 'Personalizado', 'epicjungle-elementor' ),
				],
				'condition' => [
					'type' => 'date',
				],
			]
		);

		$repeater->add_control(
			'custom_date_format',
			[
				'label' => esc_html__( 'Formato de data personalizado', 'epicjungle-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'F j, Y',
				'condition' => [
					'type' => 'date',
					'date_format' => 'custom',
				],
				'description' => sprintf(
					/* translators: %s: Allowed data letters (see: http://php.net/manual/en/function.date.php). */
					__( 'Use as letras: %s', 'epicjungle-elementor' ),
					'l D d j S F m M n Y y'
				),
			]
		);

		$repeater->add_control(
			'time_format',
			[
				'label' => esc_html__( 'Formato de hora', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '2',
				'options' => [
					'default' => 'Padrão',
					'0' => '3:31 pm (g:i a)',
					'1' => '3:31 PM (g:i A)',
					'2' => '15:31 (H:i)',
					'custom' => esc_html__( 'Personalizado', 'epicjungle-elementor' ),
				],
				'condition' => [
					'type' => 'time',
				],
			]
		);
		$repeater->add_control(
			'custom_time_format',
			[
				'label' => esc_html__( 'Formato de hora personalizado', 'epicjungle-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'g:i a',
				'placeholder' => 'g:i a',
				'condition' => [
					'type' => 'time',
					'time_format' => 'custom',
				],
				'description' => sprintf(
					/* translators: %s: Allowed time letters (see: http://php.net/manual/en/function.time.php). */
					__( 'Use the letters: %s', 'epicjungle-elementor' ),
					'g G H i a A'
				),
			]
		);

		$repeater->add_control(
			'taxonomy',
			[
				'label' => esc_html__( 'Taxonomia', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'default' => [],
				'options' => $this->get_taxonomies(),
				'condition' => [
					'type' => 'terms',
				],
			]
		);

		$repeater->add_control(
			'text_prefix',
			[
				'label' => esc_html__( 'Antes', 'epicjungle-elementor' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'type!' => 'custom',
				],
			]
		);

		$repeater->add_control(
			'show_avatar',
			[
				'label' => esc_html__( 'Avatar', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'type' => 'author',
				],
			]
		);

		$repeater->add_responsive_control(
			'avatar_size',
			[
				'label' => esc_html__( 'Tamanho', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-icon-list-icon' => 'width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'show_avatar' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'comments_custom_strings',
			[
				'label' => esc_html__( 'Formato personalizado', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => false,
				'condition' => [
					'type' => 'comments',
				],
			]
		);

		$repeater->add_control(
			'string_no_comments',
			[
				'label' => esc_html__( 'Sem comentários', 'epicjungle-elementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Sem comentários', 'epicjungle-elementor' ),
				'condition' => [
					'comments_custom_strings' => 'yes',
					'type' => 'comments',
				],
			]
		);

		$repeater->add_control(
			'string_one_comment',
			[
				'label' => esc_html__( 'Um comentário', 'epicjungle-elementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Um comentário', 'epicjungle-elementor' ),
				'condition' => [
					'comments_custom_strings' => 'yes',
					'type' => 'comments',
				],
			]
		);

		$repeater->add_control(
			'string_comments',
			[
				'label' => esc_html__( 'Comentários', 'epicjungle-elementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( '%s comentários', 'epicjungle-elementor' ),
				'condition' => [
					'comments_custom_strings' => 'yes',
					'type' => 'comments',
				],
			]
		);

		$repeater->add_control(
			'custom_text',
			[
				'label' => esc_html__( 'Personalizado', 'epicjungle-elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'condition' => [
					'type' => 'custom',
				],
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'type!' => 'time',
				],
			]
		);

		$repeater->add_control(
			'custom_url',
			[
				'label' => esc_html__( 'URL personalizado', 'epicjungle-elementor' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'type' => 'custom',
				],
			]
		);

		$repeater->add_control(
			'show_icon',
			[
				'label' => esc_html__( 'Ícone', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'Nenhum', 'epicjungle-elementor' ),
					'default' => esc_html__( 'Padrão', 'epicjungle-elementor' ),
					'custom' => esc_html__( 'Personalizado', 'epicjungle-elementor' ),
				],
				'default' => 'default',
				'condition' => [
					'show_avatar!' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Escolher ícone', 'epicjungle-elementor' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'condition' => [
					'show_icon' => 'custom',
					'show_avatar!' => 'yes',
				],
			]
		);

		$this->add_control(
			'icon_list',
			[
				'label' => '',
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'type' => 'author',
						'selected_icon' => [
							'value' => 'fe-user',
							'library' => 'feather-icons',
						],
					],
					[
						'type' => 'date',
						'selected_icon' => [
							'value' => 'fe-calendar',
							'library' => 'feather-icons',
						],
					],
					[
						'type' => 'time',
						'selected_icon' => [
							'value' => 'fe-clock',
							'library' => 'feather-icons',
						],
					],
					[
						'type' => 'comments',
						'selected_icon' => [
							'value' => 'fe-message-square',
							'library' => 'feather-icons',
						],
					],
				],
				'title_field' => '{{{ elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} <span style="text-transform: capitalize;">{{{ type }}}</span>',
			]
		);

		$this->end_controls_section();

		}

	protected function get_taxonomies() {
		$taxonomies = get_taxonomies( [
			'show_in_nav_menus' => true,
		], 'objects' );

		$options = [
			'' => esc_html__( 'Escolher', 'epicjungle-elementor' ),
		];

		foreach ( $taxonomies as $taxonomy ) {
			$options[ $taxonomy->name ] = $taxonomy->label;
		}

		return $options;
	}

	protected function get_meta_data( $repeater_item ) {
		$item_data = [];

		switch ( $repeater_item['type'] ) {
			case 'author':
				$item_data['text'] = get_the_author_meta( 'display_name' );
				$item_data['icon'] = 'fe-user'; // Default icon.
				$item_data['selected_icon'] = [
					'value' => 'fe-user',
					'library' => 'feather-icons',
				]; // Default icons.
				$item_data['itemprop'] = 'author';

				if ( 'yes' === $repeater_item['link'] ) {
					$item_data['url'] = [
						'url' => get_author_posts_url( get_the_author_meta( 'ID' ) ),
					];
				}

				if ( 'yes' === $repeater_item['show_avatar'] ) {
					$item_data['image'] = get_avatar_url( get_the_author_meta( 'ID' ), 96 );
				}

				break;

			case 'date':
				$custom_date_format = empty( $repeater_item['custom_date_format'] ) ? 'F j, Y' : $repeater_item['custom_date_format'];

				$format_options = [
					'default' => 'F j, Y',
					'0' => 'F j, Y',
					'1' => 'Y-m-d',
					'2' => 'm/d/Y',
					'3' => 'd/m/Y',
					'custom' => $custom_date_format,
				];

				$item_data['text'] = get_the_time( $format_options[ $repeater_item['date_format'] ] );
				$item_data['icon'] = 'fe-calendar'; // Default icon
				$item_data['selected_icon'] = [
					'value' => 'fe-calendar',
					'library' => 'feather-icons',
				]; // Default icons.
				$item_data['itemprop'] = 'datePublished';

				if ( 'yes' === $repeater_item['link'] ) {
					$item_data['url'] = [
						'url' => get_day_link( get_post_time( 'Y' ), get_post_time( 'm' ), get_post_time( 'j' ) ),
					];
				}
				break;

			case 'time':
				$custom_time_format = empty( $repeater_item['custom_time_format'] ) ? 'g:i a' : $repeater_item['custom_time_format'];

				$format_options = [
					'default' => 'g:i a',
					'0' => 'g:i a',
					'1' => 'g:i A',
					'2' => 'H:i',
					'custom' => $custom_time_format,
				];
				$item_data['text'] = get_the_time( $format_options[ $repeater_item['time_format'] ] );
				$item_data['icon'] = 'fe-clock'; // Default icon
				$item_data['selected_icon'] = [
					'value' => 'fe-clock',
					'library' => 'feather-icons',
				]; // Default icons.
				break;

			case 'comments':
				if ( comments_open() ) {
					$default_strings = [
						'string_no_comments' => esc_html__( 'Sem comentários', 'epicjungle-elementor' ),
						'string_one_comment' => esc_html__( 'Um comentário', 'epicjungle-elementor' ),
						'string_comments' => esc_html__( '%s comentários', 'epicjungle-elementor' ),
					];

					if ( 'yes' === $repeater_item['comments_custom_strings'] ) {
						if ( ! empty( $repeater_item['string_no_comments'] ) ) {
							$default_strings['string_no_comments'] = $repeater_item['string_no_comments'];
						}

						if ( ! empty( $repeater_item['string_one_comment'] ) ) {
							$default_strings['string_one_comment'] = $repeater_item['string_one_comment'];
						}

						if ( ! empty( $repeater_item['string_comments'] ) ) {
							$default_strings['string_comments'] = $repeater_item['string_comments'];
						}
					}

					$num_comments = (int) get_comments_number(); // get_comments_number returns only a numeric value

					if ( 0 === $num_comments ) {
						$item_data['text'] = $default_strings['string_no_comments'];
					} else {
						$item_data['text'] = sprintf( _n( $default_strings['string_one_comment'], $default_strings['string_comments'], $num_comments, 'epicjungle-elementor' ), $num_comments );
					}

					if ( 'yes' === $repeater_item['link'] ) {
						$item_data['url'] = [
							'url' => get_comments_link(),
						];
					}
					$item_data['icon'] = 'fe-message-square'; // Default icon
					$item_data['selected_icon'] = [
						'value' => 'fe-message-square',
						'library' => 'feather-icons',
					]; // Default icons.
					$item_data['itemprop'] = 'commentCount';
				}
				break;

			case 'terms':
				$item_data['icon'] = 'fe-tag'; // Default icon
				$item_data['selected_icon'] = [
					'value' => 'fe-tag',
					'library' => 'feather-icons',
				]; // Default icons.
				$item_data['itemprop'] = 'about';

				$taxonomy = $repeater_item['taxonomy'];
				$terms = wp_get_post_terms( get_the_ID(), $taxonomy );
				foreach ( $terms as $term ) {
					$item_data['terms_list'][ $term->term_id ]['text'] = $term->name;
					if ( 'yes' === $repeater_item['link'] ) {
						$item_data['terms_list'][ $term->term_id ]['url'] = get_term_link( $term );
					}
				}
				break;

			case 'custom':
				$item_data['text'] = $repeater_item['custom_text'];
				$item_data['icon'] = 'fe-info'; // Default icon.
				$item_data['selected_icon'] = [
					'value' => 'fe-info',
					'library' => 'feather-icons',
				]; // Default icons.

				if ( 'yes' === $repeater_item['link'] && ! empty( $repeater_item['custom_url'] ) ) {
					$item_data['url'] = $repeater_item['custom_url'];
				}

				break;
		}

		$item_data['type'] = $repeater_item['type'];

		if ( ! empty( $repeater_item['text_prefix'] ) ) {
			$item_data['text_prefix'] = esc_html( $repeater_item['text_prefix'] );
		}

		return $item_data;
	}

	protected function render_item( $repeater_item ) {
		$item_data = $this->get_meta_data( $repeater_item );
		$repeater_index = $repeater_item['_id'];

		if ( empty( $item_data['text'] ) && empty( $item_data['terms_list'] ) ) {
			return;
		}

		$has_link = false;
		$link_key = 'link_' . $repeater_index;
		$item_key = 'item_' . $repeater_index;

		//$this->add_render_attribute( $item_key, 'class',
		//	[
			//	'elementor-icon-list-item',
			//	'elementor-repeater-item-' . $repeater_item['_id'],
			//]
		//);

		$active_settings = $this->get_active_settings();

		 
			$this->add_render_attribute( $item_key, 'class', ['text-nowrap','text-muted' ,'mr-3']);
	

		if ( ! empty( $item_data['url']['url'] ) ) {
			$has_link = true;

			$this->add_link_attributes( $link_key, $item_data['url'] );
		}

		if ( ! empty( $item_data['itemprop'] ) ) {
			$this->add_render_attribute( $item_key, 'itemprop', $item_data['itemprop'] );
		}

		?>
		<li <?php echo $this->get_render_attribute_string( $item_key ); ?>>
			<?php if ( $has_link ) : ?>
			<a <?php echo $this->get_render_attribute_string( $link_key ); ?> class="text-reset"> 
				<?php endif; ?>
				<?php $this->render_item_icon_or_image( $item_data, $repeater_item, $repeater_index ); ?>
				<?php $this->render_item_text( $item_data, $repeater_index ); ?>
				<?php if ( $has_link ) : ?>
			</a>
		<?php endif; ?>
		</li>
		<?php
	}

	  

	protected function render_item_icon_or_image( $item_data, $repeater_item, $repeater_index ) {
		// Set icon according to user settings.
		$migration_allowed = Icons_Manager::is_migration_allowed();
		if ( ! $migration_allowed ) {
			if ( 'custom' === $repeater_item['show_icon'] && ! empty( $repeater_item['icon'] ) ) {
				$item_data['icon'] = $repeater_item['icon'];
			} elseif ( 'none' === $repeater_item['show_icon'] ) {
				$item_data['icon'] = '';
			}
		} else {
			if ( 'custom' === $repeater_item['show_icon'] && ! empty( $repeater_item['selected_icon'] ) ) {
				$item_data['selected_icon'] = $repeater_item['selected_icon'];
			} elseif ( 'none' === $repeater_item['show_icon'] ) {
				$item_data['selected_icon'] = [];
			}
		}

		if ( empty( $item_data['icon'] ) && empty( $item_data['selected_icon'] ) && empty( $item_data['image'] ) ) {
			return;
		}

		$migrated = isset( $repeater_item['__fa4_migrated']['selected_icon'] );
		$is_new = empty( $repeater_item['icon'] ) && $migration_allowed;
		$show_icon = 'none' !== $repeater_item['show_icon'];

		if ( ! empty( $item_data['image'] ) || $show_icon ) {
			?>
			<?php
			if ( ! empty( $item_data['image'] ) ) :
				$image_data = 'image_' . $repeater_index;
				$this->add_render_attribute( $image_data, 'src', $item_data['image'] );
				$this->add_render_attribute( $image_data, 'alt', $item_data['text'] );
				?>
					<img class="elementor-avatar" <?php echo $this->get_render_attribute_string( $image_data ); ?>>
				<?php elseif ( $show_icon ) : ?>
					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $item_data['selected_icon'], [ 'aria-hidden' => 'true' ] );
					else : ?>
						<i class="<?php echo esc_attr( $item_data['icon'] ); ?>" aria-hidden="true"></i>
					<?php endif; ?>
				<?php endif; ?>
			<?php
		}
	}

	protected function render_item_text( $item_data, $repeater_index ) {
		$repeater_setting_key = $this->get_repeater_setting_key( 'text', 'icon_list', $repeater_index );

		$this->add_render_attribute( $repeater_setting_key, 'class', [ 'elementor-icon-list-text', 'elementor-post-info__item', 'elementor-post-info__item--type-' . $item_data['type'] ] );
		if ( ! empty( $item['terms_list'] ) ) {
			$this->add_render_attribute( $repeater_setting_key, 'class', 'elementor-terms-list' );
		}

		?>
		<span <?php echo $this->get_render_attribute_string( $repeater_setting_key ); ?>>
			<?php if ( ! empty( $item_data['text_prefix'] ) ) : ?>
				<span class="elementor-post-info__item-prefix"><?php echo esc_html( $item_data['text_prefix'] ); ?></span>
			<?php endif; ?>
			<?php
			if ( ! empty( $item_data['terms_list'] ) ) :
				$terms_list = [];
				$item_class = 'text-reset';
				?>
				<span class="elementor-post-info__terms-list">
				<?php
				foreach ( $item_data['terms_list'] as $term ) :
					if ( ! empty( $term['url'] ) ) :
						$terms_list[] = '<a href="' . esc_attr( $term['url'] ) . '" class="' . $item_class . '">' . esc_html( $term['text'] ) . '</a>';
					else :
						$terms_list[] = '<span class="' . $item_class . '">' . esc_html( $term['text'] ) . '</span>';
					endif;
				endforeach;

				echo implode( ', ', $terms_list );
				?>
				</span>
			<?php else : ?>
				<?php
				echo wp_kses( $item_data['text'], [
					'a' => [
						'href' => [],
						'title' => [],
						'rel' => [],
					],
				] );
				?>
			<?php endif; ?>
		</span>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		ob_start();
		if ( ! empty( $settings['icon_list'] ) ) {
			foreach ( $settings['icon_list'] as $repeater_item ) {
				$this->render_item( $repeater_item );
			}
		}
		$items_html = ob_get_clean();

		if ( empty( $items_html ) ) {
			return;
		}
			$this->add_render_attribute( 'icon_list', 'class',[ 'list-unstyled','d-flex','align-items-center','mb-3'] );


		?>
		<ul <?php echo $this->get_render_attribute_string( 'icon_list' ); ?> itemscope="" itemtype="http://schema.org/Article">
			<?php echo $items_html; ?>
		</ul>
		<?php

	}
}
