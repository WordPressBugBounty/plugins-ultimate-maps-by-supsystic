<?php
/**
 * PRO feature windows of the free version (admin.upsell.js). One <dialog>; each feature is a <template> put into it.
 * The pictures are small looped CSS mocks of a map; with reduced motion they stand still.
 */
/*
 * The base map of every picture: one street grid in a 320 x 180 viewBox. The streets run along x = 30, 92, 160 (main
 * road, with a bridge), 226, 290 and y = 26, 72 (main road), 118, 146 (the embankment); the river is below the
 * embankment, the blocks lie between the streets. The colors are those of the Overview map (img/overview-map.svg), so
 * every drawn map of the plugin looks the same. Whatever is put on the map uses the points of these streets, so
 * routes turn only at crossings and pins stand on a street: a pin in % is left = x / 320, top = y / 180.
 */
$umsUpBlocks = '';
foreach ([[-10, 23], [37, 85], [99, 151.5], [168.5, 219], [233, 283], [297, 330]] as $umsUpC => $umsUpCol) {
  foreach ([[-10, 19], [33, 63.5], [80.5, 111], [125, 139]] as $umsUpR => $umsUpRow) {
    $umsUpBlocks .= '<rect x="' . $umsUpCol[0] . '" y="' . $umsUpRow[0] . '" width="' . ($umsUpCol[1] - $umsUpCol[0]) . '" height="' . ($umsUpRow[1] - $umsUpRow[0]) . '" rx="3"' . (4 === $umsUpC && 1 === $umsUpR ? ' fill="#c8e6c9"' : '') . '/>';
  }
}
$umsUpStreets = 'M30 -10V146M92 -10V146M226 -10V146M290 -10V146M-10 26H330M-10 118H330M-10 146H330';
$umsUpMain = 'M160 -10V190M-10 72H330';
$umsUpMap = '<svg class="ums-up-map" viewBox="0 0 320 180" preserveAspectRatio="xMidYMid slice" aria-hidden="true" focusable="false">'
  . '<rect width="320" height="180" fill="#f1f3f4"/>'
  . '<g fill="#e8eaed">' . $umsUpBlocks . '</g>'
  . '<path d="M-10 157 C 40 151, 90 161, 150 156 S 260 150, 330 156 L 330 190 L -10 190 Z" fill="#aadaff"/>'
  . '<g fill="none"><path d="' . $umsUpStreets . '" stroke="#dadce0" stroke-width="8"/><path d="' . $umsUpStreets . '" stroke="#fff" stroke-width="5.5"/>'
  . '<path d="' . $umsUpMain . '" stroke="#f2c14e" stroke-width="11"/><path d="' . $umsUpMain . '" stroke="#fde293" stroke-width="8"/></g>'
  . '</svg>';
/*
 * KML layers: the middle of the same base map in 4:3 (x 40-280), so pins in % are left = (x - 40) / 240 and
 * top = y / 180. Three layers from a file and a link (the same scene as in Easy Google Maps): Cafés and Restaurants
 * come from cafes.kml, Bars from the link; a sync of the link brings two more bars (drawn apart, is-n1 and is-n2).
 */
$umsUpMapKml = str_replace('viewBox="0 0 320 180"', 'viewBox="40 0 240 180"', $umsUpMap);
$umsUpKmlMarkers = [
  'cafes' => [[66, 26], [92, 44], [120, 26], [146, 26], [126, 72], [92, 96], [62, 118]],
  'rest' => [[190, 72], [226, 94], [196, 118], [160, 98], [128, 118]],
  'bars' => [[180, 26], [208, 26], [226, 48], [250, 72], [272, 72]],
];
$umsUpPin = '<svg viewBox="0 0 24 32" aria-hidden="true" focusable="false"><path d="M12 0C5.4 0 0 5.2 0 11.7 0 20.4 12 32 12 32s12-11.6 12-20.3C24 5.2 18.6 0 12 0z" fill="currentColor"/><circle cx="12" cy="11.5" r="4.6" fill="#fff"/></svg>';
?>
<dialog class="ums-up" data-ums-up aria-labelledby="ums-up-title">
    <button type="button" class="ums-up-close" data-ums-up-close aria-label="<?php echo esc_attr__('Close', UMS_LANG_CODE); ?>">&times;</button>
    <div class="ums-up-body" data-ums-up-body></div>
</dialog>
<?php foreach ($this->features as $key => $f) { ?>
<template id="ums-up-<?php echo esc_attr($key); ?>">
    <div class="ums-up-hero">
        <span class="ums-up-eyebrow"><i class="fa fa-diamond" aria-hidden="true"></i><?php echo esc_html__('PRO feature', UMS_LANG_CODE); ?></span>
        <div class="ums-up-head">
            <div>
                <h2 id="ums-up-title"><?php echo esc_html($f['title']); ?></h2>
                <p><?php echo esc_html($f['text']); ?></p>
            </div>
            <a class="ums-up-cta" href="<?php echo esc_url($this->proUrl . '?utm_source=plugin&utm_medium=upsell_' . $key . '&utm_campaign=ultimatemaps'); ?>" target="_blank" rel="noopener"><?php echo esc_html__('Get PRO', UMS_LANG_CODE); ?><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>
    <div class="ums-up-main">
        <div class="ums-up-demo" aria-hidden="true">
            <div class="ums-up-demo-bar"><i></i><i></i><i></i><span><?php echo esc_html__('On your page', UMS_LANG_CODE); ?></span></div>
            <div class="ums-up-stage ums-up-stage-<?php echo esc_attr($key); ?>">
                <?php if ($key === 'markers_list') { ?>
                    <div class="ums-up-frame ums-up-ml">
                        <?php echo $umsUpMap; ?>
                        <span class="ums-up-pin" style="left: 28.75%; top: 27.22%;"><?php echo $umsUpPin; ?></span>
                        <span class="ums-up-pin" style="left: 60.31%; top: 40%;"><?php echo $umsUpPin; ?></span>
                        <span class="ums-up-pin" style="left: 80.63%; top: 65.56%;"><?php echo $umsUpPin; ?></span>
                    </div>
                    <div class="ums-up-ml-strip">
                        <div class="ums-up-ml-track">
                            <?php foreach (['a', 'b', 'c', 'd', 'a', 'b'] as $ph) { ?>
                                <div class="ums-up-ml-card"><span class="ums-up-ph is-<?php echo $ph; ?>"></span><b></b><i></i></div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } elseif ($key === 'kml') { ?>
                    <div class="ums-up-kml2">
                        <div class="ums-up-kml2-in">
                            <div class="ums-up-frame ums-up-kml2-map">
                                <?php echo $umsUpMapKml; ?>
                                <svg class="ums-up-over" viewBox="40 0 240 180" preserveAspectRatio="xMidYMid slice" aria-hidden="true" focusable="false">
                                    <path class="ums-up-kz is-cafes" d="M92 26H160V72H92Z"/>
                                    <path class="ums-up-kz is-rest" d="M160 72H226V118H160Z"/>
                                    <path class="ums-up-kroute is-bars" pathLength="100" d="M180 26H226V72H276"/>
                                </svg>
                                <?php foreach ($umsUpKmlMarkers as $umsUpLayer => $umsUpPoints) { ?>
                                    <?php foreach ($umsUpPoints as $umsUpI => $umsUpP) { ?>
                                        <span class="ums-up-kpin is-<?php echo esc_attr($umsUpLayer); ?> is-p<?php echo (int) $umsUpI; ?>" style="left: <?php echo esc_attr(round(($umsUpP[0] - 40) / 2.4, 2)); ?>%; top: <?php echo esc_attr(round($umsUpP[1] / 1.8, 2)); ?>%;"><?php echo $umsUpPin; ?></span>
                                    <?php } ?>
                                <?php } ?>
                                <span class="ums-up-kring is-bars is-n1" style="left: 90%; top: 14.44%;"></span>
                                <span class="ums-up-kpin is-bars is-n1" style="left: 90%; top: 14.44%;"><?php echo $umsUpPin; ?></span>
                                <span class="ums-up-kring is-bars is-n2" style="left: 90%; top: 65.56%;"></span>
                                <span class="ums-up-kpin is-bars is-n2" style="left: 90%; top: 65.56%;"><?php echo $umsUpPin; ?></span>
                            </div>
                            <div class="ums-up-kp">
                                <b class="ums-up-kp-title"><i class="fa fa-clone" aria-hidden="true"></i><?php echo esc_html__('KML layers', UMS_LANG_CODE); ?></b>
                                <span class="ums-up-kp-src"><i class="fa fa-file-code-o" aria-hidden="true"></i><b>cafes.kml</b></span>
                                <span class="ums-up-kp-src is-url"><i class="fa fa-link" aria-hidden="true"></i><b class="is-link"><span dir="ltr">https://&hellip;/bars.kml</span></b><i class="fa fa-refresh ums-up-kp-sync" aria-hidden="true"></i></span>
                                <span class="ums-up-kp-state">
                                    <span class="is-synced"><i class="fa fa-check-circle" aria-hidden="true"></i><?php echo esc_html__('Synced · just now', UMS_LANG_CODE); ?></span>
                                    <span class="is-syncing"><i class="fa fa-refresh" aria-hidden="true"></i><?php echo esc_html__('Syncing…', UMS_LANG_CODE); ?></span>
                                </span>
                                <span class="ums-up-kp-layers">
                                    <span class="ums-up-kp-row is-cafes"><i></i><span class="ums-up-kp-name"><?php echo esc_html__('Cafés', UMS_LANG_CODE); ?></span><em class="ums-up-kp-n">8</em><span class="ums-up-sw"></span></span>
                                    <span class="ums-up-kp-row is-rest"><i></i><span class="ums-up-kp-name"><?php echo esc_html__('Restaurants', UMS_LANG_CODE); ?></span><em class="ums-up-kp-n">6</em><span class="ums-up-sw"></span></span>
                                    <span class="ums-up-kp-row is-bars"><i></i><span class="ums-up-kp-name"><?php echo esc_html__('Bars', UMS_LANG_CODE); ?></span><em class="ums-up-kp-n"><span class="ums-up-kp-plus">+2</span><span class="is-old">6</span><span class="is-new">8</span></em><span class="ums-up-sw"></span></span>
                                </span>
                                <span class="ums-up-kp-foot"><i class="fa fa-refresh" aria-hidden="true"></i><?php echo esc_html__('Reads the link on every view', UMS_LANG_CODE); ?></span>
                            </div>
                        </div>
                    </div>
                <?php } elseif ($key === 'shapes') { ?>
                    <div class="ums-up-frame ums-up-shapes">
                        <?php echo $umsUpMap; ?>
                        <svg class="ums-up-over" viewBox="0 0 320 180" preserveAspectRatio="xMidYMid slice" aria-hidden="true" focusable="false">
                            <path class="ums-up-shape-fill" d="M30 26H160V118H92V146H30Z"/>
                            <path class="ums-up-shape-line" pathLength="100" d="M30 26H160V118H92V146H30Z"/>
                            <circle class="ums-up-shape-v" cx="30" cy="26" r="4"/><circle class="ums-up-shape-v" cx="160" cy="26" r="4"/><circle class="ums-up-shape-v" cx="160" cy="118" r="4"/><circle class="ums-up-shape-v" cx="92" cy="118" r="4"/><circle class="ums-up-shape-v" cx="92" cy="146" r="4"/><circle class="ums-up-shape-v" cx="30" cy="146" r="4"/>
                            <circle class="ums-up-shape-circle" cx="226" cy="118" r="32"/>
                        </svg>
                        <span class="ums-up-pop"><b><?php echo esc_html__('Delivery zone', UMS_LANG_CODE); ?></b><?php echo esc_html__('Free delivery in 30 min', UMS_LANG_CODE); ?></span>
                    </div>
                <?php } elseif ($key === 'hide_poi') { ?>
                    <div class="ums-up-frame ums-up-poi">
                        <?php echo $umsUpMap; ?>
                        <span class="ums-up-poi-i" style="left: 19.06%; top: 14.44%;"><i class="fa fa-bed" aria-hidden="true"></i></span>
                        <span class="ums-up-poi-i" style="left: 28.75%; top: 52.78%;"><i class="fa fa-coffee" aria-hidden="true"></i></span>
                        <span class="ums-up-poi-i" style="left: 38.75%; top: 40%;"><i class="fa fa-car" aria-hidden="true"></i></span>
                        <span class="ums-up-poi-i" style="left: 70.63%; top: 52.78%;"><i class="fa fa-shopping-bag" aria-hidden="true"></i></span>
                        <span class="ums-up-poi-i" style="left: 90.63%; top: 40%;"><i class="fa fa-cutlery" aria-hidden="true"></i></span>
                        <span class="ums-up-pin is-main" style="left: 50%; top: 40%;"><?php echo $umsUpPin; ?></span>
                        <span class="ums-up-toggle"><span class="ums-up-sw"></span><?php echo esc_html__('Hide POI', UMS_LANG_CODE); ?></span>
                    </div>
                <?php } elseif ($key === 'frontend_markers') { ?>
                    <div class="ums-up-fm">
                        <div class="ums-up-fm-form">
                            <b><?php echo esc_html__('Add your place', UMS_LANG_CODE); ?></b>
                            <span class="ums-up-fm-field is-title"></span>
                            <span class="ums-up-fm-field is-addr"></span>
                            <span class="ums-up-fm-btn"><?php echo esc_html__('Add marker', UMS_LANG_CODE); ?></span>
                        </div>
                        <div class="ums-up-frame ums-up-fm-map">
                            <?php echo $umsUpMap; ?>
                            <span class="ums-up-pin" style="left: 28.75%; top: 65.56%;"><?php echo $umsUpPin; ?></span>
                            <span class="ums-up-pin" style="left: 70.63%; top: 40%;"><?php echo $umsUpPin; ?></span>
                            <span class="ums-up-pin is-new" style="left: 50%; top: 40%;"><?php echo $umsUpPin; ?></span>
                        </div>
                    </div>
                <?php } elseif ($key === 'access_roles') { ?>
                    <div class="ums-up-roles">
                        <b><?php echo esc_html__('Who can work with the maps', UMS_LANG_CODE); ?></b>
                        <?php foreach ([__('Administrator', UMS_LANG_CODE), __('Editor', UMS_LANG_CODE), __('Author', UMS_LANG_CODE), __('Contributor', UMS_LANG_CODE)] as $i => $role) { ?>
                            <span class="ums-up-role is-r<?php echo $i; ?>"><i class="fa fa-user" aria-hidden="true"></i><?php echo esc_html($role); ?><span class="ums-up-sw"></span></span>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <span class="ums-up-icon"><i class="fa <?php echo esc_attr($f['icon']); ?>" aria-hidden="true"></i></span>
                <?php } ?>
            </div>
        </div>
        <div class="ums-up-info">
            <h3><?php echo esc_html__('What you get', UMS_LANG_CODE); ?></h3>
            <ul>
                <?php foreach ($f['points'] as $point) { ?><li><?php echo esc_html($point); ?></li><?php } ?>
            </ul>
            <h3><?php echo esc_html__('Great for', UMS_LANG_CODE); ?></h3>
            <div class="ums-up-uses">
                <?php foreach ($f['uses'] as $use) { ?><span><?php echo esc_html($use); ?></span><?php } ?>
            </div>
        </div>
    </div>
    <div class="ums-up-more">
        <span class="ums-up-more-label"><?php echo esc_html__('Also in PRO', UMS_LANG_CODE); ?></span>
        <?php foreach ($this->features as $otherKey => $other) { ?>
            <?php if ($otherKey !== $key) { ?>
                <button type="button" data-ums-upsell="<?php echo esc_attr($otherKey); ?>"><i class="fa <?php echo esc_attr($other['icon']); ?>" aria-hidden="true"></i> <?php echo esc_html($other['chip']); ?></button>
            <?php } ?>
        <?php } ?>
    </div>
</template>
<?php } ?>
