<?php
/**
 * Plugin Name:       Last Edited Shortcode
 * Plugin URI:        https://github.com/quicoto/wordpress-last-edited
 * Description:       Adds a shortcode to show last edited pages
 * Version:           1.0.0
 * Requires at least: 5.1.4
 * Requires PHP:      7.2
 * Author:            Ricard Torres
 * Author URI:        https://ricard.blog/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

function les_init( $atts ){
  $a = shortcode_atts( array(
    'number' => 5,
    'date_format' => 'F j, Y - g:i a',
    'text' => 'Last updated'
  ), $atts );

  $html = '<h3>'.$a['text'].'</h3><ul>';

  $pages = get_pages(
    array(
      'sort_column' => 'post_modified',
      'sort_order' => 'desc',
      'number' => $a['number']
    )
  );

  foreach ( $pages as $page ) {
    $link = get_page_link( $page->ID );
    $title = $page->post_title;
    $modified = get_post_modified_time($a['date_format'], false, $page->ID);
    $html = $html.'<li><a title="'.$title.'" href="'.$link.'">'.$title.'</a> - '.$modified.'</li>';
  }

  $html = $html.'</ul>';

	return $html;
}
add_shortcode( 'last_edited_pages', 'les_init' );