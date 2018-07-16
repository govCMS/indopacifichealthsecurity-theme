<?php
/**
 * @file
 * Returns the HTML for a single Drupal page.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728148
 */


$accountid = 6248; /* Open read speaker customer id */
$open_readspeaker_i18n = "en_au"; /* Open read speaker language value */
$custom_style = "content"; /* Open read speaker custom button style */
$custom_param = ""; /* Open read speaker custom parameters */
?>
<div id="load"></div>
<div class="main-page-box">
    <header class="header" id="header" role="banner">
        <div class="header__inner">

            <?php if ($secondary_menu): ?>
                <nav class="header__secondary-menu" id="secondary-menu" role="navigation">
                    <?php
                    print theme('links__system_secondary_menu', array(
                        'links' => $secondary_menu,
                        'attributes' => array(
                            'class' => array(
                                'links',
                                'inlineLinks--bordered--double',
                                'clearfix',
                            ),
                        ),
                        'heading' => array(
                            'text' => isset($secondary_menu_heading) ? $secondary_menu_heading : '',
                            'level' => 'h2',
                            'class' => array('element-invisible'),
                        ),
                    ));
                    ?>
                </nav>
            <?php endif; ?>

            <?php if ($logo): ?>
                <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" class="header__logo" id="logo"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" class="header__logo-image" /></a>
            <?php endif; ?>
            <div class="custom-header-right">
                <?php print render($page['header']); ?>
                <div class="header-action-section">
                    <div class="custom-search-section" id="custom-search-section">
                        <div class="custom-search-icon" id="custom-search-icon"></div>
                        <?php
                        $block = module_invoke('search', 'block_view', 'search');
                        print render($block);
                        ?>
                    </div>
                    <?php
                    /* $speak_content_block = module_invoke('open_readspeaker', 'block_view','open_readspeaker_ui'); */
                    ?>
                    <?php /* if( !empty( $speak_content_block ) && !empty( $speak_content_block['content']) ){ */ ?>
                    <div class="custom-speaker-section">
                        <div class="header-speaker-icon" id="header-speaker-icon">
                            <?php
                            global $is_https;

                            $output = '';

                            $http = 'http';



                            if ($is_https) {
                                $http = 'https';
                            }

                            drupal_add_js($http . "://f1.eu.readspeaker.com/script/$accountid/ReadSpeaker.js?pids=embhl{$custom_param}", 'external');
                            drupal_add_css(drupal_get_path('theme', 'gov_subtheme') . '/css/open_readspeaker.css', array(
                                'group' => CSS_THEME,
                                'media' => 'screen',
                            ));

                            $request_path = url(request_path(), array('absolute' => TRUE));

                            $output .= '<!-- RS_MODULE_CODE -->';
                            $output .= '<div id="readspeaker_button1" class="rs_skip rsbtn rs_preserve"' . $custom_style . '>';
                            $output .= '<a class="rsbtn_play" title="' . t('Listen to this page using ReadSpeaker') . '" accesskey="L" href="' . $http . '://app.eu.readspeaker.com/cgi-bin/rsent?customerid=' . $accountid . '&amp;lang=' . $open_readspeaker_i18n . '&amp;readid=' . variable_get('open_readspeaker_reading_area', 'rs_read_this') . '&amp;url=' . urlencode($request_path) . '">';
                            $output .= '<span class="rsbtn_left rsimg rspart"><span class="rsbtn_text"><span>' . t('Listen') . '</span></span></span>';
                            $output .= '<span class="rsbtn_right rsimg rsplay rspart"></span>';
                            $output .= '</a></div>';
                            $output .= '<div id="rs_read_this">';
                            $output .= '</div>';
                            echo $output;
                            /* print render($speak_content_block['content']); */
                            ?>
                        </div>
                    </div>
                            <?php /* } */ ?>
                </div>
            </div>  
        </div>
    </header>

<?php print $breadcrumb; ?>
<?php print render($page['navigation']); ?>

    <div id="page">

<?php print render($page['highlighted']); ?>


        <div id="main">
<?php
// Render the sidebars to see if there's anything in them.
$sidebar_first = render($page['sidebar_first']);
?>
            <?php if ($sidebar_first) { ?>
                <div class="sidebars left-sidebar">
                <?php print $sidebar_first; ?>
                </div>
                <?php } ?>
                <?php $content_class = drupal_is_front_page() ? '' : 'content-area'; ?>
            <div id="content" class="column <?php print $content_class; ?>" role="main">

                <a id="main-content"></a>
<?php print render($title_prefix); ?>
<?php if ($title): ?>
                    <h1 class="page__title title" id="page-title"><?php print $title; ?></h1>
                <?php endif; ?>
                <?php print render($title_suffix); ?>
                <?php print $messages; ?>
                <?php print render($tabs); ?>
                <?php print render($page['help']); ?>
                <?php if ($action_links): ?>
                    <ul class="action-links"><?php print render($action_links); ?></ul>
                <?php endif; ?>
                <?php print render($page['content']); ?>
                <?php print $feed_icons; ?>
            </div>
                <?php
                $sidebar_second = render($page['sidebar_second']);
                ?>
            <?php if ($sidebar_second) { ?>
                <div class="sidebars right-sidebar">
                <?php print $sidebar_second; ?>
                </div>
                <?php } ?>



        </div>

<?php print render($page['footer']); ?>

    </div>

<?php print render($page['bottom']); ?>
</div>  
