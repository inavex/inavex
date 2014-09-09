<?php

/**
 * Template Name: No-theme
 *
 * @package FrameShift
 * @since 1.0
 */


    // Get post content
    $post = get_post( $parent_id );

    // Display post content like category description
    if( ! empty( $post->post_content ) )
        echo '<div class="category-description clearfix notheme">' . apply_filters( 'the_content', $post->post_content ) . '</div>';

    // Action hook after archive title
    do_action( 'frameshift_archive_title_after' );
