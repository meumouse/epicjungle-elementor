<?php
namespace EpicJungleElementor\Modules\Shapes\Widgets;

use EpicJungleElementor\Base\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
exit; // Exit if accessed directly
}

class Shapes extends Base_Widget {

    public function get_name() {
        return 'ej-shapes';
    }

    public function get_title() {
        return __( 'Formas', 'epicjungle-elementor' );
    }

    public function get_icon() {
        return 'eicon-divider-shape';
    }

 protected function register_controls() {
        
        $this->start_controls_section(
            'section_title', [
                'label' => esc_html__( 'Formas', 'epicjungle-elementor' ),
            ]
        );


         $this->add_control( 'bg_color', [
            'label'     => esc_html__( 'Cor de fundo', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'dark',
            'options'   => [
                'primary'       => esc_html__( 'Primário', 'epicjungle-elementor' ),
                'secondary'     => esc_html__( 'Secundário', 'epicjungle-elementor' ),
                'primary_desat' => esc_html__( 'Desaturação Primária', 'epicjungle-elementor' ),
                'success'       => esc_html__( 'Sucesso', 'epicjungle-elementor' ),
                'info'          => esc_html__( 'Informação', 'epicjungle-elementor' ),
                'warning'       => esc_html__( 'Perigo', 'epicjungle-elementor' ),
                'danger'        => esc_html__( 'Aviso', 'epicjungle-elementor' ),
                'light'         => esc_html__( 'Claro', 'epicjungle-elementor' ),
                'dark'          => esc_html__( 'Escuro', 'epicjungle-elementor' ),
                'black'         => esc_html__( 'Preto', 'epicjungle-elementor' ),
                'white'         => esc_html__( 'Branco', 'epicjungle-elementor' ),
            ]

        ] );

          $this->add_control( 'bg_shapes', [
            'label'     => esc_html__( 'Formas', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'slant_bottom_right',
            'options'   => [
                'slant_bottom_right'       => esc_html__( 'Inclinação inferior à direita', 'epicjungle-elementor' ),
                'slant_bottom_left'     => esc_html__( 'Inclinação inferior à esquerda', 'epicjungle-elementor' ),
                'slant_top_right' => esc_html__( 'Inclinação superior à direita', 'epicjungle-elementor' ),
                'slant_top_left'       => esc_html__( 'Inclinação superior à esquerda', 'epicjungle-elementor' ),
                'curve_bottom_center'          => esc_html__( 'Curva inferior centralizada', 'epicjungle-elementor' ),
                'curve_top_center'       => esc_html__( 'Curva superior centralizado', 'epicjungle-elementor' ),
                'curve_bottom_right'        => esc_html__( 'Curva inferior à direita', 'epicjungle-elementor' ),
                'curve_bottom_left'         => esc_html__( 'Curva inferior à esquerda', 'epicjungle-elementor' ),
                'curve_top_right'          => esc_html__( 'Curva superior à direita', 'epicjungle-elementor' ),
                'curve_top_left'         => esc_html__( 'Curva superior à esquerda', 'epicjungle-elementor' ),
                'curve_right'         => esc_html__( 'Curva direita', 'epicjungle-elementor' ),
                'curve_left'         => esc_html__( 'Curva esquerda', 'epicjungle-elementor' ),
            ]

        ] );

           $this->end_controls_section();
    }

    protected function slant_bottom_right($color) { ?>

        <div class="bg-<?php echo $color; ?> position-relative py-7">
  <!-- Content goes here -->
  <div class="cs-shape cs-shape-bottom cs-shape-slant bg-body">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 260">
      <polygon fill="currentColor" points="0,257 0,260 3000,260 3000,0"></polygon>
    </svg>
  </div>
</div>
    <?php  }

    protected function slant_bottom_left($color) { ?>

        <div class="bg-<?php echo $color; ?> dark position-relative py-7">
  <!-- Content goes here -->
  <div class="cs-shape cs-shape-bottom cs-shape-slant bg-body">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 260">
      <polygon fill="currentColor" points="0,0 0,260 3000,260 3000,255"></polygon>
    </svg>
  </div>
</div>
<?php   }

    protected function slant_top_right($color) { ?>

        <div class="bg-<?php echo $color; ?> position-relative py-7">
  <!-- Content goes here -->
  <div class="cs-shape cs-shape-top cs-shape-slant bg-body">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 260">
      <polygon fill="currentColor" points="0,0 0,2.4 3000,260 3000,0"></polygon>
    </svg>
  </div>
</div>

  <?php   }

    protected function slant_top_left($color) {?>

        <div class="bg-<?php echo $color; ?> position-relative py-7">
  <!-- Content goes here -->
  <div class="cs-shape cs-shape-top cs-shape-slant bg-body">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 260">
      <polygon fill="currentColor" points="0,0 0,260 3000,2.9 3000,0"></polygon>
    </svg>
  </div>
</div>

  <?php   }

    protected function curve_bottom_center($color) { ?>

    <div class="bg-<?php echo $color; ?> position-relative py-7">
 <!---Content goes here -->
  <div class="cs-shape cs-shape-bottom cs-shape-curve bg-body">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 185.4">
      <path fill="currentColor" d="M3000,0v185.4H0V0c496.4,115.6,996.4,173.4,1500,173.4S2503.6,115.6,3000,0z"></path>
    </svg>
  </div>
</div>

   <?php  }

    protected function curve_top_center($color) { ?>

        <div class="bg-<?php echo $color; ?> position-relative py-7">
  <!-- Content goes here -->
  <div class="cs-shape cs-shape-top cs-shape-curve bg-body">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 185.4">
      <path fill="currentColor" d="M3000,185.4V0H0v185.4C496.4,69.8,996.4,12,1500,12S2503.6,69.8,3000,185.4z"></path>
    </svg>
  </div>
</div>

  <?php }

    protected function curve_bottom_right($color) { ?>

        <div class="bg-<?php echo $color; ?> position-relative py-7">
  <!-- Content goes here -->
  <div class="cs-shape cs-shape-bottom cs-shape-curve-side bg-body">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 250">
      <path fill="currentColor" d="M3000,0v250H0v-51c572.7,34.3,1125.3,34.3,1657.8,0C2190.3,164.8,2637.7,98.4,3000,0z"></path>
    </svg>
  </div>
</div>

<?php   }

    protected function curve_bottom_left($color) { ?>

    <div class="bg-<?php echo $color; ?> position-relative py-7">
  <!-- Content goes here -->
  <div class="cs-shape cs-shape-bottom cs-shape-curve-side bg-body">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 250">
      <path fill="currentColor" d="M0,0l0,250h3000v-51c-572.7,34.3-1125.3,34.3-1657.8,0C809.7,164.8,362.3,98.4,0,0z"></path>
    </svg>
  </div>
</div>

  <?php   }

    protected function curve_top_right($color) { ?>

        <div class="bg-<?php echo $color; ?> position-relative py-7">
  <!-- Content goes here -->
  <div class="cs-shape cs-shape-top cs-shape-curve-side bg-body">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 250">
      <path fill="currentColor" d="M3000,250V0H0v51c572.7-34.3,1125.3-34.3,1657.8,0C2190.3,85.2,2637.7,151.6,3000,250z"></path>
    </svg>
  </div>
</div>
 <?php }

    protected function curve_top_left($color) { ?>

    <div class="bg-<?php echo $color; ?> position-relative py-7">
  <!-- Content goes here -->
  <div class="cs-shape cs-shape-top cs-shape-curve-side bg-body">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 250">
      <path fill="currentColor" d="M0,250L0,0l3000,0v51c-572.7-34.3-1125.3-34.3-1657.8,0C809.7,85.2,362.3,151.6,0,250z"></path>
    </svg>
  </div>
</div>

  <?php   }

    protected function curve_right($color) { ?>

    <div class="bg-<?php echo $color; ?> position-relative py-7">
  <div class="bg-overlay-content">
    <!-- Content goes here -->
  </div>
  <div class="cs-shape cs-shape-right bg-body">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 228.4 2500">
      <path fill="currentColor" d="M228.4,0v2500H0c134.9-413.7,202.4-830.4,202.4-1250S134.9,413.7,0,0H228.4z"></path>
    </svg>
  </div>
</div>

  <?php   }

    protected function curve_left($color) { ?>

    <div class="bg-<?php echo $color; ?> position-relative py-7">
  <div class="bg-overlay-content">
    <!-- Content goes here -->
  </div>
  <div class="cs-shape cs-shape-left bg-body">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 228.4 2500">
      <path fill="currentColor" d="M0,0l0,2500h228.4C93.5,2086.3,26.1,1669.6,26.1,1250S93.5,413.7,228.4,0L0,0z"></path>
    </svg>
  </div>
</div>

    <?php  }


    protected function render() {

        $settings           = $this->get_settings();
        $shape               = $settings['bg_shapes'];
        $color               = $settings['bg_color'];
       //echo '<pre>'. print_r($settings,1).'</pre>';
          $this->$shape($color);
     }

}