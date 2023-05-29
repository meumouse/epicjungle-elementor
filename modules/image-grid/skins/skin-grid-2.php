<?php
namespace EpicJungleElementor\Modules\ImageGrid\Skins;

use Elementor\Skin_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use EpicJungleElementor\Core\Utils as EJ_Utils;
use Elementor\Widget_Base;



if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Skin_Grid_2 extends Skin_Base {

    public function get_id() {
        return 'grid-style-2';
    }

    public function get_title() {
        return __( 'Estilo 2', 'epicjungle-elementor' );
    }

    public function render() {
        $widget   = $this->parent;   
        $settings = $widget->get_settings();
        $items    = $settings[ 'content_settings' ];
        $items_2  = $settings[ 'content_settings_2' ];
        $count    = count( $settings[ 'content_settings' ] );
        $count_2  = count( $settings[ 'content_settings_2' ] );
        $column   = ! empty( $settings[  'column' ] ) ? 12/intval( $settings['column' ] ) : 6;
        $column_2 = ! empty( $settings[ 'column_2' ] ) ? 12/intval( $settings['column_2' ] ) : 6;

        $widget->add_render_attribute( 'column', 'class', [
            'col-sm-' . $column,
        ] );

        $widget->add_render_attribute( 'column_2', 'class', [
            'col-sm-' . $column_2,
        ] );

        ?>
            <div> 
                <div class="mx-auto">
                    <div class="row align-items-center">
                        <div <?php echo $widget->get_render_attribute_string( 'column' ); ?>>
                            <?php foreach( $items as $index => $item ) :
                                $grid_count = $index + 1; ?>
                                    <div class="bg-light box-shadow-lg rounded-lg p-4 mb-grid-gutter text-center text-sm-left">
                                        <img class="d-inline-block mb-4 mt-2" width="100" alt="Icon" src=<?php echo $item['image']['url'] ?>>
                                        <h3 class="h5 mb-2"><?php echo $item['title']; ?></h3>
                                        <p class="font-size-sm"><?php echo $item['content']; ?></p>
                                    </div>
                            <?php endforeach; ?>
                        </div>
                        <div <?php echo $widget->get_render_attribute_string( 'column_2' ); ?>>
                            <?php foreach( $items_2 as $index => $item2 ) :
                                $grid_count = $index + 1; ?>
                                    <div class="bg-light box-shadow-lg rounded-lg p-4 mb-grid-gutter text-center text-sm-left">
                                        <img class="d-inline-block mb-4 mt-2" width="100" alt="Icon" src=<?php echo $item2['image_2']['url'] ?>>
                                        <h3 class="h5 mb-2"><?php echo $item2['title_2']; ?></h3>
                                        <p class="font-size-sm"><?php echo $item2['content_2']; ?></p>
                                    </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
}
