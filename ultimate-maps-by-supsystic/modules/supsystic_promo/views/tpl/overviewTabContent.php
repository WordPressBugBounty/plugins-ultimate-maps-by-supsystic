<?php
$promoModule = frameUms::_()->getModule('supsystic_promo');
$isPro = $promoModule->isPro();
$adminBase = admin_url('admin.php?page=ultimate-maps-supsystic');
$addMapUrl = $adminBase . '&tab=maps_add_new';
$allMapsUrl = $adminBase . '&tab=maps';
$settingsUrl = $adminBase . '&tab=settings';
$proUrl = $promoModule->generateMainLink('utm_source=plugin&utm_medium=overview&utm_campaign=ultimate_maps_upsell');
$featureGridUrl = $promoModule->generateMainLink('utm_source=plugin&utm_medium=overview&utm_campaign=ultimate_maps_upsell&utm_content=feature_grid');
$pricingUrl = $promoModule->generateMainLink('utm_source=plugin&utm_medium=overview&utm_campaign=ultimate_maps_upsell&utm_content=pro_powerhouse');
$comparisonUrl = $promoModule->generateMainLink('utm_source=plugin&utm_medium=overview&utm_campaign=ultimate_maps_upsell&utm_content=free_pro_comparison');
?>

<div class="ums-overview">
  <section class="ums-overview-hero">
    <div class="ums-overview-hero-copy">
      <div class="ums-overview-kicker">
        <img src="<?php echo esc_url(UMS_PLUGINS_URL . '/' . UMS_PLUG_NAME . '/modules/supsystic_promo/img/plugin-icon.png'); ?>" alt="">
        <span><?php echo esc_html($isPro ? __('Ultimate Maps PRO by Supsystic', UMS_LANG_CODE) : __('Ultimate Maps by Supsystic', UMS_LANG_CODE)); ?></span>
      </div>
      <h1><?php esc_html_e('Make every place easy to find.', UMS_LANG_CODE); ?></h1>
      <p><?php esc_html_e('Create responsive maps with OpenStreetMap, Mapbox, Thunderforest or Bing. Start with rich markers and clustering in Free; add KML layers, shapes, marker lists and visitor submissions with PRO.', UMS_LANG_CODE); ?></p>
      <div class="ums-overview-actions">
        <a class="button button-primary button-hero" href="<?php echo esc_url($addMapUrl); ?>"><i class="fa fa-plus"></i> <?php esc_html_e('Create map', UMS_LANG_CODE); ?></a>
        <a class="button button-secondary button-hero" href="<?php echo esc_url($allMapsUrl); ?>"><i class="fa fa-map"></i> <?php esc_html_e('View maps', UMS_LANG_CODE); ?></a>
        <?php if (!$isPro) { ?>
          <a class="button button-secondary button-hero ums-overview-pro-button" href="<?php echo esc_url($proUrl); ?>" target="_blank" rel="noopener"><i class="fa fa-star"></i> <?php esc_html_e('Unlock PRO', UMS_LANG_CODE); ?></a>
        <?php } ?>
      </div>
      <div class="ums-overview-trust">
        <span><i class="fa fa-check"></i> <?php esc_html_e('Unlimited maps and markers', UMS_LANG_CODE); ?></span>
        <span><i class="fa fa-check"></i> <?php esc_html_e('Responsive on every device', UMS_LANG_CODE); ?></span>
        <span><i class="fa fa-check"></i> <?php esc_html_e('No Google Maps key required for OpenStreetMap', UMS_LANG_CODE); ?></span>
      </div>
    </div>

    <div class="ums-overview-hero-media" aria-hidden="true">
      <div class="ums-overview-map-window">
        <div class="ums-overview-window-bar"><span></span><span></span><span></span><em><i class="fa fa-lock"></i> yourstore.com/locations</em><b><?php esc_html_e('Store locator', UMS_LANG_CODE); ?></b></div>
        <div class="ums-overview-map-app">
          <div class="ums-overview-locator">
            <strong class="ums-overview-locator-title"><?php esc_html_e('Find your nearest store', UMS_LANG_CODE); ?></strong>
            <div class="ums-overview-locator-search"><i class="fa fa-search"></i><span><?php esc_html_e('City or ZIP', UMS_LANG_CODE); ?></span><i class="fa fa-crosshairs"></i></div>
            <small class="ums-overview-locator-count"><?php esc_html_e('4 locations within 5 km', UMS_LANG_CODE); ?></small>
            <ul class="ums-overview-locator-list">
              <li class="is-active"><b class="is-red">1</b><div><strong><?php esc_html_e('Your Store #1', UMS_LANG_CODE); ?></strong><span><?php esc_html_e('Downtown', UMS_LANG_CODE); ?> · 0.4 km · <em><?php esc_html_e('Open', UMS_LANG_CODE); ?></em></span></div></li>
              <li><b class="is-teal">2</b><div><strong><?php esc_html_e('Your Store #2', UMS_LANG_CODE); ?></strong><span><?php esc_html_e('Harbor', UMS_LANG_CODE); ?> · 1.1 km · <em><?php esc_html_e('Open', UMS_LANG_CODE); ?></em></span></div></li>
              <li><b class="is-violet">3</b><div><strong><?php esc_html_e('Your Store #3', UMS_LANG_CODE); ?></strong><span><?php esc_html_e('Midtown', UMS_LANG_CODE); ?> · 1.8 km · <?php esc_html_e('Delivery', UMS_LANG_CODE); ?></span></div></li>
              <li><b class="is-orange">4</b><div><strong><?php esc_html_e('Your Store #4', UMS_LANG_CODE); ?></strong><span><?php esc_html_e('Northside', UMS_LANG_CODE); ?> · 2.6 km · <em><?php esc_html_e('Open', UMS_LANG_CODE); ?></em></span></div></li>
            </ul>
            <div class="ums-overview-locator-layers">
              <span><i class="is-heat"></i><?php esc_html_e('OpenStreetMap', UMS_LANG_CODE); ?></span>
              <span><i class="is-zone"></i><?php esc_html_e('Mapbox', UMS_LANG_CODE); ?></span>
              <span><i class="is-route"></i><?php esc_html_e('Bing', UMS_LANG_CODE); ?></span>
            </div>
          </div>
          <div class="ums-overview-map-canvas">
            <img class="ums-overview-map-svg" src="<?php echo esc_url(UMS_PLUGINS_URL . '/' . UMS_PLUG_NAME . '/modules/supsystic_promo/img/overview-map.svg'); ?>" alt="">
            <span class="ums-overview-map-fullscreen"><i class="fa fa-expand"></i></span>
            <div class="ums-overview-map-zoom"><span>+</span><span>−</span></div>
            <div class="ums-overview-map-scale"><i></i>200 m</div>
            <div class="ums-overview-infowindow">
              <span class="ums-overview-infowindow-close">×</span>
              <img src="<?php echo esc_url(UMS_PLUGINS_URL . '/' . UMS_PLUG_NAME . '/modules/supsystic_promo/img/map-popup-place.svg'); ?>" alt="">
              <div class="ums-overview-infowindow-body">
                <strong><?php esc_html_e('Your Store #1', UMS_LANG_CODE); ?></strong>
                <span class="ums-overview-infowindow-rating">4.8 <span>★★★★★</span> (128)</span>
                <small><?php esc_html_e('Downtown · 48 Market St', UMS_LANG_CODE); ?></small>
                <span class="ums-overview-infowindow-meta"><em><?php esc_html_e('Open now', UMS_LANG_CODE); ?></em><?php esc_html_e('12 min · 1.2 km', UMS_LANG_CODE); ?></span>
                <b class="ums-overview-infowindow-btn"><i class="fa fa-location-arrow"></i> <?php esc_html_e('Directions', UMS_LANG_CODE); ?></b>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php if ($isPro) { ?>
    <section class="ums-overview-license-banner">
      <div class="ums-overview-license-aside" aria-hidden="true"><i class="fa fa-check-circle"></i><strong>PRO</strong><span><?php esc_html_e('mapping toolkit active', UMS_LANG_CODE); ?></span></div>
      <div class="ums-overview-license-content">
        <span class="ums-overview-pill"><?php esc_html_e('PRO enabled', UMS_LANG_CODE); ?></span>
        <h2><?php esc_html_e('Your complete location experience is ready.', UMS_LANG_CODE); ?></h2>
        <p><?php esc_html_e('KML layers, heatmaps, figures, marker lists and frontend marker submissions are available in the map editor.', UMS_LANG_CODE); ?></p>
        <a class="button button-primary" href="<?php echo esc_url($addMapUrl); ?>"><i class="fa fa-arrow-right"></i> <?php esc_html_e('Build a PRO map', UMS_LANG_CODE); ?></a>
      </div>
    </section>
  <?php } ?>

  <section class="ums-overview-layout">
    <div class="ums-overview-main">
      <div class="ums-overview-section-heading">
        <div><span class="ums-overview-pill"><?php esc_html_e('Mapping toolkit', UMS_LANG_CODE); ?></span><h2><?php esc_html_e('From a single pin to a complete location experience.', UMS_LANG_CODE); ?></h2></div>
        <p><?php esc_html_e('Free covers the essentials. PRO adds the tools that turn location data into a guided customer journey.', UMS_LANG_CODE); ?></p>
      </div>

      <div class="ums-overview-feature-grid">
        <div class="ums-overview-feature-card"><i class="fa fa-map-marker"></i><h3><?php esc_html_e('Unlimited maps and markers', UMS_LANG_CODE); ?></h3><p><?php esc_html_e('Create as many maps and locations as the site needs. Search an address, click the map or use exact coordinates.', UMS_LANG_CODE); ?></p><span class="ums-overview-tag is-free">FREE</span></div>
        <div class="ums-overview-feature-card"><i class="fa fa-picture-o"></i><h3><?php esc_html_e('Rich marker stories', UMS_LANG_CODE); ?></h3><p><?php esc_html_e('Combine text, photos, video, links, phone numbers and custom icons inside informative marker popups.', UMS_LANG_CODE); ?></p><span class="ums-overview-tag is-free">FREE</span></div>
        <div class="ums-overview-feature-card"><i class="fa fa-object-group"></i><h3><?php esc_html_e('Categories and clustering', UMS_LANG_CODE); ?></h3><p><?php esc_html_e('Organize locations into filterable categories and group dense marker sets into clusters as visitors zoom.', UMS_LANG_CODE); ?></p><span class="ums-overview-tag is-free">FREE</span></div>
        <div class="ums-overview-feature-card"><i class="fa fa-exchange"></i><h3><?php esc_html_e('Import, export and publish', UMS_LANG_CODE); ?></h3><p><?php esc_html_e('Move map and marker data with CSV, then publish maps using a shortcode, Gutenberg block, Elementor widget or PHP.', UMS_LANG_CODE); ?></p><span class="ums-overview-tag is-free">FREE</span></div>
        <div class="ums-overview-feature-card"><i class="fa fa-map-o"></i><h3><?php esc_html_e('Choice of map engines', UMS_LANG_CODE); ?></h3><p><?php esc_html_e('Choose OpenStreetMap with Leaflet, Mapbox, Thunderforest or Bing to fit your project and provider preferences.', UMS_LANG_CODE); ?></p><span class="ums-overview-tag is-free">FREE</span></div>
        <div class="ums-overview-feature-card"><i class="fa fa-file-code-o"></i><h3><?php esc_html_e('KML layers and filters', UMS_LANG_CODE); ?></h3><p><?php esc_html_e('Bring geographic layers into a map and let visitors filter the KML data they want to see.', UMS_LANG_CODE); ?></p><span class="ums-overview-tag is-pro">PRO</span></div>
        <div class="ums-overview-feature-card"><i class="fa fa-list-alt"></i><h3><?php esc_html_e('Marker lists and sliders', UMS_LANG_CODE); ?></h3><p><?php esc_html_e('Show a marker list, table or slider alongside the map so visitors can browse locations in more detail.', UMS_LANG_CODE); ?></p><span class="ums-overview-tag is-pro">PRO</span></div>
        <div class="ums-overview-feature-card"><i class="fa fa-pencil-square-o"></i><h3><?php esc_html_e('Shapes and visitor submissions', UMS_LANG_CODE); ?></h3><p><?php esc_html_e('Draw areas and paths, and allow controlled frontend marker submissions with category and usage limits.', UMS_LANG_CODE); ?></p><span class="ums-overview-tag is-pro">PRO</span></div>
      </div>

      <?php if (!$isPro) { ?>
        <div class="ums-overview-feature-cta">
          <a class="button button-primary button-hero" href="<?php echo esc_url($featureGridUrl); ?>" target="_blank" rel="noopener"><i class="fa fa-star"></i> <?php esc_html_e('Unlock PRO', UMS_LANG_CODE); ?></a>
        </div>
      <?php } ?>

      <section id="ums-overview-pro" class="ums-overview-pro-panel">
        <div class="ums-overview-pro-copy">
          <span class="ums-overview-pill"><?php echo esc_html($isPro ? __('PRO toolkit active', UMS_LANG_CODE) : __('Build beyond the basic map', UMS_LANG_CODE)); ?></span>
          <h2><?php echo esc_html($isPro ? __('Every advanced mapping tool is unlocked.', UMS_LANG_CODE) : __('Make the map answer the visitor’s next question.', UMS_LANG_CODE)); ?></h2>
          <p><?php echo esc_html($isPro ? __('Use KML, shapes, marker lists and frontend submissions directly in the editor.', UMS_LANG_CODE) : __('Visitors need more than pins. Help them explore areas and compare locations while your community keeps the map useful.', UMS_LANG_CODE)); ?></p>
          <?php if (!$isPro) { ?>
            <a class="button button-primary button-hero ums-overview-upgrade-cta" href="<?php echo esc_url($pricingUrl); ?>" target="_blank" rel="noopener"><i class="fa fa-star"></i> <?php esc_html_e('Unlock every PRO feature', UMS_LANG_CODE); ?></a>
            <small><i class="fa fa-check-circle"></i> <?php esc_html_e('Keep the maps you created in Free', UMS_LANG_CODE); ?></small>
          <?php } ?>
        </div>
        <div class="ums-overview-pro-stack" aria-label="<?php esc_attr_e('PRO feature highlights', UMS_LANG_CODE); ?>">
          <span><i class="fa fa-sliders"></i><b><?php esc_html_e('Submission rules', UMS_LANG_CODE); ?></b><small><?php esc_html_e('Limits and access', UMS_LANG_CODE); ?></small></span>
          <span><i class="fa fa-fire"></i><b><?php esc_html_e('Heatmaps', UMS_LANG_CODE); ?></b><small><?php esc_html_e('Density insights', UMS_LANG_CODE); ?></small></span>
          <span><i class="fa fa-file-code-o"></i><b><?php esc_html_e('KML', UMS_LANG_CODE); ?></b><small><?php esc_html_e('Layers and filters', UMS_LANG_CODE); ?></small></span>
          <span><i class="fa fa-edit"></i><b><?php esc_html_e('Frontend', UMS_LANG_CODE); ?></b><small><?php esc_html_e('Marker submissions', UMS_LANG_CODE); ?></small></span>
          <span><i class="fa fa-th-large"></i><b><?php esc_html_e('Listings', UMS_LANG_CODE); ?></b><small><?php esc_html_e('Tables and sliders', UMS_LANG_CODE); ?></small></span>
          <span><i class="fa fa-crop"></i><b><?php esc_html_e('Shapes', UMS_LANG_CODE); ?></b><small><?php esc_html_e('Zones and paths', UMS_LANG_CODE); ?></small></span>
        </div>
      </section>

      <section class="ums-overview-use-cases">
        <div class="ums-overview-use-heading"><span class="ums-overview-pill"><?php esc_html_e('Built for real businesses', UMS_LANG_CODE); ?></span><h2><?php esc_html_e('One map editor, many location workflows.', UMS_LANG_CODE); ?></h2></div>
        <div class="ums-overview-use-grid">
          <div class="ums-overview-use-item"><i class="fa fa-shopping-bag"></i><strong><?php esc_html_e('Store locations', UMS_LANG_CODE); ?></strong><span><?php esc_html_e('Show branches with photos, opening details and categories on one map.', UMS_LANG_CODE); ?></span></div>
          <div class="ums-overview-use-item"><i class="fa fa-home"></i><strong><?php esc_html_e('Real estate', UMS_LANG_CODE); ?></strong><span><?php esc_html_e('Present properties with images, descriptions and contact links.', UMS_LANG_CODE); ?></span></div>
          <div class="ums-overview-use-item"><i class="fa fa-plane"></i><strong><?php esc_html_e('Travel guides', UMS_LANG_CODE); ?></strong><span><?php esc_html_e('Collect landmarks, media-rich descriptions and KML layers in one place.', UMS_LANG_CODE); ?></span></div>
          <div class="ums-overview-use-item"><i class="fa fa-truck"></i><strong><?php esc_html_e('Service areas', UMS_LANG_CODE); ?></strong><span><?php esc_html_e('Illustrate delivery or coverage areas with PRO shapes and paths.', UMS_LANG_CODE); ?></span></div>
          <div class="ums-overview-use-item"><i class="fa fa-calendar"></i><strong><?php esc_html_e('Events and venues', UMS_LANG_CODE); ?></strong><span><?php esc_html_e('Map entrances, parking, stages and nearby points of interest.', UMS_LANG_CODE); ?></span></div>
        </div>
      </section>

      <section id="ums-overview-compare" class="ums-overview-comparison">
        <div class="ums-overview-card-head"><div><span class="ums-overview-pill"><?php esc_html_e('Free vs PRO', UMS_LANG_CODE); ?></span><h2><?php esc_html_e('Upgrade when the map becomes part of the customer journey.', UMS_LANG_CODE); ?></h2></div><p><?php esc_html_e('Nothing built in Free needs to be rebuilt after upgrading.', UMS_LANG_CODE); ?></p></div>
        <div class="ums-overview-compare-table" role="table" aria-label="<?php esc_attr_e('Free and PRO feature comparison', UMS_LANG_CODE); ?>">
          <div class="ums-overview-compare-row is-head" role="row"><strong role="columnheader"><?php esc_html_e('Capability', UMS_LANG_CODE); ?></strong><strong role="columnheader">FREE</strong><strong role="columnheader">PRO</strong></div>
          <div class="ums-overview-compare-row" role="row"><span role="cell"><?php esc_html_e('Unlimited maps, markers, categories and clustering', UMS_LANG_CODE); ?></span><i class="fa fa-check" role="cell"></i><i class="fa fa-check" role="cell"></i></div>
          <div class="ums-overview-compare-row" role="row"><span role="cell"><?php esc_html_e('CSV import/export and WordPress publishing', UMS_LANG_CODE); ?></span><i class="fa fa-check" role="cell"></i><i class="fa fa-check" role="cell"></i></div>
          <div class="ums-overview-compare-row" role="row"><span role="cell"><?php esc_html_e('OpenStreetMap, Mapbox, Thunderforest and Bing', UMS_LANG_CODE); ?></span><i class="fa fa-check" role="cell"></i><i class="fa fa-check" role="cell"></i></div>
          <div class="ums-overview-compare-row" role="row"><span role="cell"><?php esc_html_e('KML layers, import and filters', UMS_LANG_CODE); ?></span><i class="fa fa-minus" role="cell"></i><i class="fa fa-check" role="cell"></i></div>
          <div class="ums-overview-compare-row" role="row"><span role="cell"><?php esc_html_e('Shapes and heatmaps', UMS_LANG_CODE); ?></span><i class="fa fa-minus" role="cell"></i><i class="fa fa-check" role="cell"></i></div>
          <div class="ums-overview-compare-row" role="row"><span role="cell"><?php esc_html_e('Marker lists, sliders and frontend submissions', UMS_LANG_CODE); ?></span><i class="fa fa-minus" role="cell"></i><i class="fa fa-check" role="cell"></i></div>
        </div>
        <?php if (!$isPro) { ?>
          <div class="ums-overview-compare-cta"><div><strong><?php esc_html_e('Ready for the complete mapping toolkit?', UMS_LANG_CODE); ?></strong><span><?php esc_html_e('Explore the current PRO features and license options.', UMS_LANG_CODE); ?></span></div><a class="button button-primary" href="<?php echo esc_url($comparisonUrl); ?>" target="_blank" rel="noopener"><i class="fa fa-balance-scale"></i> <?php esc_html_e('Compare licenses', UMS_LANG_CODE); ?></a></div>
        <?php } ?>
      </section>

      <section class="ums-overview-workflow">
        <div class="ums-overview-workflow-heading"><span class="ums-overview-pill"><?php esc_html_e('Fast setup', UMS_LANG_CODE); ?></span><h2><?php esc_html_e('Publish a useful map in four steps.', UMS_LANG_CODE); ?></h2></div>
        <ol><li><b>1</b><div><strong><?php esc_html_e('Choose an engine', UMS_LANG_CODE); ?></strong><span><?php esc_html_e('Start with OpenStreetMap, or configure a provider key.', UMS_LANG_CODE); ?></span></div></li><li><b>2</b><div><strong><?php esc_html_e('Add locations', UMS_LANG_CODE); ?></strong><span><?php esc_html_e('Drop pins or import marker data.', UMS_LANG_CODE); ?></span></div></li><li><b>3</b><div><strong><?php esc_html_e('Design the experience', UMS_LANG_CODE); ?></strong><span><?php esc_html_e('Set the map size, marker icons and clustering; add PRO layers if needed.', UMS_LANG_CODE); ?></span></div></li><li><b>4</b><div><strong><?php esc_html_e('Publish anywhere', UMS_LANG_CODE); ?></strong><span><?php esc_html_e('Use a block, Elementor widget or shortcode.', UMS_LANG_CODE); ?></span></div></li></ol>
      </section>

      <section id="ums-overview-help" class="ums-overview-card ums-overview-help">
        <div class="ums-overview-card-head"><div><span class="ums-overview-pill"><?php esc_html_e('Help center', UMS_LANG_CODE); ?></span><h2><?php esc_html_e('Common setup questions', UMS_LANG_CODE); ?></h2></div><a class="button button-secondary" href="https://supsystic.com/docs/ultimate-maps-documentation/?utm_source=plugin&amp;utm_medium=overview&amp;utm_campaign=ultimate_maps_help" target="_blank" rel="noopener"><i class="fa fa-book"></i> <?php esc_html_e('Open documentation', UMS_LANG_CODE); ?></a></div>
        <div class="ums-overview-faq-list"><?php foreach ($this->faqList as $title => $desc) { ?><div class="ums-overview-faq-item"><button type="button" class="ums-overview-faq-question" aria-expanded="false"><?php echo esc_html($title); ?><i class="fa fa-angle-down" aria-hidden="true"></i></button><div class="ums-overview-faq-answer"><?php echo wp_kses_post($desc); ?></div></div><?php } ?></div>
      </section>

      <section id="ums-overview-videos" class="ums-overview-video-grid">
        <div class="ums-overview-card"><div class="ums-overview-card-head"><div><span class="ums-overview-pill"><?php esc_html_e('Learn', UMS_LANG_CODE); ?></span><h2><?php esc_html_e('Ultimate Maps tutorial', UMS_LANG_CODE); ?></h2></div></div><div class="ums-overview-video-frame"><iframe title="Ultimate Maps tutorial" src="https://www.youtube.com/embed/lhQoubZAZlg" frameborder="0" allowfullscreen loading="lazy"></iframe></div></div>
        <div class="ums-overview-card"><div class="ums-overview-card-head"><div><span class="ums-overview-pill"><?php esc_html_e('Discover', UMS_LANG_CODE); ?></span><h2><?php esc_html_e('Supsystic overview', UMS_LANG_CODE); ?></h2></div></div><div class="ums-overview-video-frame"><iframe title="Supsystic overview" src="https://www.youtube.com/embed/dKd_9g6JzfU" frameborder="0" allowfullscreen loading="lazy"></iframe></div></div>
      </section>

      <section id="ums-overview-server" class="ums-overview-card">
        <div class="ums-overview-card-head"><div><span class="ums-overview-pill"><?php esc_html_e('Diagnostics', UMS_LANG_CODE); ?></span><h2><?php esc_html_e('Server settings', UMS_LANG_CODE); ?></h2></div><p><?php esc_html_e('Environment details for troubleshooting.', UMS_LANG_CODE); ?></p></div>
        <div class="ums-overview-server-grid"><?php foreach ($this->serverSettings as $title => $element) { ?><div class="ums-overview-server-item <?php echo !empty($element['error']) ? 'is-error' : ''; ?>"><span><?php echo esc_html(trim($title)); ?></span><strong><?php echo esc_html(trim((string) $element['value'])); ?></strong></div><?php } ?></div>
      </section>
    </div>

    <div class="ums-overview-sidebar">
      <section class="ums-overview-card ums-overview-resource-card">
        <span class="ums-overview-pill"><?php esc_html_e('Resources', UMS_LANG_CODE); ?></span><h2><?php esc_html_e('Build your next map', UMS_LANG_CODE); ?></h2>
        <a class="ums-overview-resource-link" href="<?php echo esc_url($addMapUrl); ?>"><i class="fa fa-plus-circle"></i> <?php esc_html_e('Create a new map', UMS_LANG_CODE); ?></a>
        <a class="ums-overview-resource-link" href="<?php echo esc_url($allMapsUrl); ?>"><i class="fa fa-map"></i> <?php esc_html_e('Manage maps', UMS_LANG_CODE); ?></a>
        <a class="ums-overview-resource-link" href="<?php echo esc_url($settingsUrl); ?>"><i class="fa fa-map-o"></i> <?php esc_html_e('Choose map engine', UMS_LANG_CODE); ?></a>
        <a class="ums-overview-resource-link" href="#ums-overview-compare"><i class="fa fa-balance-scale"></i> <?php esc_html_e('Compare Free and PRO', UMS_LANG_CODE); ?></a>
        <a class="ums-overview-resource-link" href="#ums-overview-help"><i class="fa fa-book"></i> <?php esc_html_e('FAQ and documentation', UMS_LANG_CODE); ?></a>
        <a class="ums-overview-resource-link" href="#ums-overview-videos"><i class="fa fa-play"></i> <?php esc_html_e('Video tutorials', UMS_LANG_CODE); ?></a>
        <a class="ums-overview-resource-link" href="#ums-overview-server"><i class="fa fa-cog"></i> <?php esc_html_e('Server settings', UMS_LANG_CODE); ?></a>
      </section>

      <section id="ums-overview-support" class="ums-overview-card ums-overview-support-card"><span class="ums-overview-pill"><?php esc_html_e('Human support', UMS_LANG_CODE); ?></span><h2><?php esc_html_e('Need help with a map?', UMS_LANG_CODE); ?></h2><p><?php esc_html_e('Ask about map engines, markers, KML, styling or publishing.', UMS_LANG_CODE); ?></p><a class="button button-primary" href="https://supsystic.com/contact-us/?utm_source=plugin&amp;utm_medium=overview&amp;utm_campaign=ultimate_maps_support" target="_blank" rel="noopener"><i class="fa fa-life-ring"></i> <?php esc_html_e('Contact support', UMS_LANG_CODE); ?></a></section>

      <?php if (!$isPro) { ?>
        <section class="ums-overview-card ums-overview-sidebar-pro"><i class="fa fa-star"></i><span class="ums-overview-pill"><?php esc_html_e('PRO', UMS_LANG_CODE); ?></span><h2><?php esc_html_e('Build maps that guide decisions.', UMS_LANG_CODE); ?></h2><p><?php esc_html_e('Add KML layers, shapes, marker lists and visitor submissions.', UMS_LANG_CODE); ?></p><a class="button button-primary" href="<?php echo esc_url($proUrl); ?>" target="_blank" rel="noopener"><?php esc_html_e('View PRO options', UMS_LANG_CODE); ?></a></section>
      <?php } ?>
    </div>
  </section>
</div>
