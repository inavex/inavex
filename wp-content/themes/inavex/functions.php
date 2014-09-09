<?php

/**
 * Добавляем меню
 */

function registerInavexMenu() {
    register_nav_menus(
        array(
            'header-top-menu' => __( 'Header Top Menu' ),
            'header-side-menu' => __( 'Header Side Menu' ),
            'footer-menu' => __( 'Footer Menu' )
        )
    );
}
add_action( 'init', 'registerInavexMenu' );


/**
 * Виджет на главной
 */
function my_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Виджеты услуг на главной', '' ),
        'id' => 'home-widget-area',
        'description' => __( 'Виджеты услуг на главной', '' ),
        'before_widget' => '<li id="%1$s" class="widget-wrap widget-spaces-wrap span3">',
        'after_widget' => '</li>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ) );
}

add_action( 'widgets_init', 'my_widgets_init' );


/**
 * Получаем рандомно отзывы
 */
function getRandomReviews() {
    global $wpdb;
    $query = "
                SELECT *
                FROM inavex_wpcreviews";

    $reviews = $wpdb->get_results($query);
    $reviewShuffle = array();

    //var_dump(count($reviews));

    foreach ($reviews as $review):
        if (strlen($review->review_text) >= 120 && strlen($review->review_text) <= 600) {
            array_push($reviewShuffle, array(
                'content' => $review->review_text,
                'reviewer_name' => $review->reviewer_name
            ));
        }
    endforeach;

    shuffle($reviewShuffle);

    return array_slice($reviewShuffle, 0, 5);
}