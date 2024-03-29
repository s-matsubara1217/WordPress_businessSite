<?php
function my_enqueue_scripts()
{
  $uri = esc_url(get_template_directory_uri());
  wp_enqueue_script('jquery');
  wp_enqueue_script('bundle_js', $uri . '/assets/js/bundle.js', array());
  wp_enqueue_style('my_styles', $uri . '/assets/css/styles.css', []);
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

// ヘッダー、フッターのカスタムメニュー化
register_nav_menus(array(
  'place_global' => 'グローバル',
  'place_footer' => 'フッターナビ'
));

// メイン画像上にテンプレートごとの文字列を表示
function get_main_title()
{
  if (is_singular('post')) :
    $category_obj = get_the_category();
    return $category_obj[0]->name;
  elseif (is_page()) :
    return get_the_title();
  elseif (is_category()) :
    return single_cat_title();
  endif;

  return '';
}

// 子ページを取得する関数
function get_child_pages($number = -1)
{
  $parent_id = get_the_ID();
  $args = array(
    'post_per_page' => $number,
    'post_type' => 'page',
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'post_parent' => $parent_id,
  );
  $child_pages = new WP_Query($args);
  return $child_pages;
}

// アイキャッチ画像を利用できるようにする
add_theme_support('post-thumbnails');
// トップページのメイン画像用のサイズ設定
add_image_size('top', 1077, 622, true);
// 地域貢献活動一覧画像用の設定サイズ
add_image_size('contribution', 557, 280, true);
// トップページの地域貢献活動にて使用している画像用のサイズ設定
add_image_size('front-contribution', 255, 189, true);
// 企業情報・店舗情報一覧画像用のサイズ設定
add_image_size('common', 465, 252, true);
// 各ページのメイン画像用のサイズ設定
add_image_size('detail', 1100, 330, true);
// 検索一覧画像用のサイズ設定
add_image_size('search', 168, 168, true);

// 各テンプレートごとのメイン画像を表示
function get_main_image()
{
  if (is_page()) :
    return get_the_post_thumbnail(get_queried_object()->ID, 'detail');
  elseif (is_category('news') || is_singular('post')) :
    return '<img src="' . get_template_directory_uri() . '/assets/images/bg-page-news.jpg" />';
  else :
    return '<img src="' . get_template_directory_uri() . '/assets/images/bg-page-dummy.png" />';
  endif;
}
