<?php
function my_enqueue_scripts()
{
  $uri = esc_url(get_template_directory_uri());
  wp_enqueue_script('jquery');
  wp_enqueue_script('bundle_js', $uri . '/assets/js/bundle.js', array());
  wp_enqueue_style('my_styles', $uri . '/assets/css/styles.css', []);
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');
