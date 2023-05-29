<?php
namespace EpicJungleElementor\Modules\Search\Widgets;

use EpicJungleElementor\Base\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
exit; // Exit if accessed directly
}

class Search extends Base_Widget {

    public function get_name() {
        return 'ej-search';
    }

    public function get_title() {
        return __( 'Pesquisa', 'epicjungle-elementor' );
    }

    public function get_icon() {
        return 'eicon-search';
    }

    protected function register_controls() {
        $this->start_controls_section( 'search_content', [
            'label' => esc_html__( 'Formulário de pesquisa', 'epicjungle-elementor' ),
        ] );

        $search_options = [
        //    'blog' => esc_html__( 'Posts', 'epicjungle-elementor' ),
            'docs' => esc_html__( 'Documentos', 'epicjungle-elementor' )
        ];

        
        $this->add_control( 'skin', [
            'label'   => esc_html__( 'Pesquisa', 'epicjungle-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => esc_html__( 'Padrão', 'epicjungle-elementor' ),
               // 'blog'    => esc_html__( 'Posts', 'epicjungle-elementor' ),
                'docs'    => esc_html__( 'Documentos', 'epicjungle-elementor' ),
        ],
        ] );

        $this->add_control( 'placeholder', [
            'label'     => esc_html__( 'Espaço reservado', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'separator' => 'before',
            'default'   => esc_html__( 'O que você procura?', 'epicjungle-elementor' ),
        ] );

        $this->add_control( 'enable_tags', [
            'label'     => esc_html__( 'Ativar tags', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'label_on'  => esc_html__( 'Ativar', 'epicjungle-elementor' ),
            'label_off' => esc_html__( 'Desativar', 'epicjungle-elementor' ),
            'default'   => 'no',
        ] );

        $this->add_control( 'taxonomy', [
                'label'   => esc_html__( 'Taxonomia', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'jetpack-portfolio-type',
                'options' => [
                    'jetpack-portfolio-type' => esc_html__( 'Postagens', 'epicjungle-elementor' ),
                    'doc_tag'                => esc_html__( 'Documentos', 'epicjungle-elementor' ),
                ],
                'frontend_available' => true,
                'condition'          => [ 'enable_tags' => 'yes' ],
            ]
        );
      

        $this->end_controls_section();
    }

    public function ej_helpcenter_tags_suggestions( $taxonomy ) {

       $terms_args = apply_filters( 'ej_helpcenter_hero_tags_args', array(
           'taxonomy'   => $taxonomy,
           'orderby'    => 'count',
           'order'      => 'DESC',
           'number'     => 4,
           'hide_empty' => false,
           'include' =>  get_theme_mod( 'ej_helpcenter_hero_tags', [] ),
       ) );

       $terms  = get_terms( $terms_args );

       
       if ( ! is_wp_error( $terms ) && ! empty( $terms ) ): ?>
          <div class="font-size-sm text-left">
               <span class="text-light opacity-70 mr-3"><?php esc_html_e( 'Sugestão:', 'epicjungle-elementor' ); ?></span>
               <?php foreach ( $terms as $term ) : 
                $link = get_tag_link( $term->term_id );
               $tags[] = "<a class='cs-fancy-link text-light mr-3' href='$link'>$term->name</a>";
               endforeach; 
               $tag_list = implode(", ",$tags); 
               echo $tag_list;  ?>
           </div><?php
       endif;
    }

    protected function render() {
        $settings               = $this->get_settings();
        $skin                   = $settings['skin'];
        $placeholder            = $settings['placeholder'];
        $enable_tags            = $settings['enable_tags'];
        $taxonomy               = $settings['taxonomy'];
     
       
        if ('default' == $skin) {

            ?>

            <div class="input-group-overlay mx-auto" style="max-width: 390px;">
                <div class="input-group-prepend-overlay"><span class="input-group-text"><i class="fe fe-search"></i></span></div>
                <input class="form-control prepended-form-control" type="text" placeholder="<?php echo $placeholder; ?>">
            </div> <?php
        } else  { ?>

         <form role="search" method="get" class="search-form input-group-overlay mb-3" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <div class="input-group-prepend-overlay"><span class="input-group-text"><i class="fe-search"></i></span></div>
            <input class="form-control prepended-form-control" type="text" placeholder="<?php echo $placeholder; ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>">
            <input type="hidden" name="post_type" value="docs" />

         </form> 

            <?php if ( $enable_tags == 'yes' ) {
                $this->ej_helpcenter_tags_suggestions( $taxonomy ); 
            }

        }
    }
}
