<?php
/**
 * Review request card (models/review.php): "Is it working well?" leads to the WordPress.org review form or to support.
 * @var array $card
 */
$card = $this->card;
?>
<section class="ums-review<?php echo $card['tab'] === 'overview' ? ' is-overview' : ''; ?>" data-ums-review data-ajax-url="<?php echo esc_url($card['ajaxUrl']); ?>" data-nonce="<?php echo esc_attr($card['nonce']); ?>" data-pl="<?php echo esc_attr(UMS_CODE); ?>" aria-label="<?php echo esc_attr__('Rate Ultimate Maps', UMS_LANG_CODE); ?>">
    <div class="ums-review-art" aria-hidden="true">
        <svg class="ums-review-icon" viewBox="0 0 48 48" width="48" height="48" focusable="false">
            <path d="M8 13l10-4 12 4 10-4v26l-10 4-12-4-10 4z" fill="#fff" fill-opacity=".18" stroke="#fff" stroke-width="2.4" stroke-linejoin="round"/>
            <path d="M18 9v26M30 13v26" stroke="#fff" stroke-opacity=".55" stroke-width="2"/>
            <path d="M24 15.5c-3.3 0-6 2.6-6 5.9 0 4.4 6 10.1 6 10.1s6-5.7 6-10.1c0-3.3-2.7-5.9-6-5.9z" fill="#fff"/>
            <circle cx="24" cy="21.3" r="2.3" fill="#149b93"/>
        </svg>
        <span class="ums-review-badge">
            <svg viewBox="0 0 16 16" width="14" height="14" focusable="false"><path d="M3.5 8.3l3 3 6-6.6" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </span>
        <svg class="ums-review-spark is-one" viewBox="0 0 10 10" width="12" height="12" focusable="false"><path d="M5 0l1.2 3.8L10 5 6.2 6.2 5 10 3.8 6.2 0 5l3.8-1.2z" fill="#ffc53d"/></svg>
        <svg class="ums-review-spark is-two" viewBox="0 0 10 10" width="9" height="9" focusable="false"><path d="M5 0l1.2 3.8L10 5 6.2 6.2 5 10 3.8 6.2 0 5l3.8-1.2z" fill="#4ae8ea"/></svg>
        <svg class="ums-review-spark is-three" viewBox="0 0 10 10" width="7" height="7" focusable="false"><path d="M5 0l1.2 3.8L10 5 6.2 6.2 5 10 3.8 6.2 0 5l3.8-1.2z" fill="#ffc53d"/></svg>
    </div>

    <div class="ums-review-body" aria-live="polite">
        <div class="ums-review-step is-active" data-review-step="ask">
            <p class="ums-review-eyebrow"><?php echo esc_html($card['eyebrow']); ?></p>
            <h3 class="ums-review-title"><?php echo esc_html($card['title']); ?></h3>
            <p class="ums-review-text">
                <?php echo esc_html($card['text']); ?>
                <?php if (!empty($card['link'])) { ?>
                    <a class="ums-review-inline-link" href="<?php echo esc_url($card['link']); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($card['linkText']); ?> &rarr;</a>
                <?php } ?>
            </p>
            <div class="ums-review-question"><?php echo esc_html__('Is Ultimate Maps working well for you?', UMS_LANG_CODE); ?></div>
            <div class="ums-review-actions">
                <button type="button" class="ums-review-btn is-primary" data-review-go="yes"><?php echo esc_html__('Yes, it works great', UMS_LANG_CODE); ?></button>
                <button type="button" class="ums-review-btn" data-review-go="no"><?php echo esc_html__('Not really', UMS_LANG_CODE); ?></button>
            </div>
        </div>

        <div class="ums-review-step" data-review-step="yes" hidden>
            <p class="ums-review-eyebrow"><?php echo esc_html__('Glad to hear it', UMS_LANG_CODE); ?></p>
            <h3 class="ums-review-title"><?php echo esc_html__('Would you rate Ultimate Maps on WordPress.org?', UMS_LANG_CODE); ?></h3>
            <p class="ums-review-text"><?php echo esc_html__('It takes about a minute. Your review helps other site owners find the plugin and keeps us improving it.', UMS_LANG_CODE); ?></p>
            <div class="ums-review-stars" aria-hidden="true">
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <svg class="ums-review-star" style="--ums-star: <?php echo (int) $i; ?>" viewBox="0 0 24 24" width="26" height="26" focusable="false"><path d="M12 2.6l2.9 5.9 6.5.9-4.7 4.6 1.1 6.5L12 17.4l-5.8 3.1 1.1-6.5-4.7-4.6 6.5-.9z"/></svg>
                <?php } ?>
            </div>
            <div class="ums-review-actions">
                <a class="ums-review-btn is-primary" href="<?php echo esc_url($card['reviewUrl']); ?>" target="_blank" rel="noopener noreferrer" data-review-answer="rate">
                    <?php echo esc_html__('Write a review', UMS_LANG_CODE); ?>
                    <svg viewBox="0 0 16 16" width="13" height="13" aria-hidden="true" focusable="false"><path d="M6 3h7v7M13 3L5 11" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <button type="button" class="ums-review-btn" data-review-answer="later"><?php echo esc_html__('Not now', UMS_LANG_CODE); ?></button>
                <button type="button" class="ums-review-link" data-review-answer="done"><?php echo esc_html__('I already did', UMS_LANG_CODE); ?></button>
            </div>
        </div>

        <div class="ums-review-step" data-review-step="no" hidden>
            <p class="ums-review-eyebrow"><?php echo esc_html__('We are here to help', UMS_LANG_CODE); ?></p>
            <h3 class="ums-review-title"><?php echo esc_html__('Sorry it is not working the way you need', UMS_LANG_CODE); ?></h3>
            <p class="ums-review-text"><?php echo esc_html__('Tell us what went wrong and our support team will help you sort it out.', UMS_LANG_CODE); ?></p>
            <div class="ums-review-actions">
                <a class="ums-review-btn is-primary" href="<?php echo esc_url($card['supportUrl']); ?>" target="_blank" rel="noopener noreferrer" data-review-answer="support"><?php echo esc_html__('Contact support', UMS_LANG_CODE); ?></a>
                <button type="button" class="ums-review-btn" data-review-answer="later"><?php echo esc_html__('Not now', UMS_LANG_CODE); ?></button>
                <a class="ums-review-link" href="<?php echo esc_url($card['reviewUrl']); ?>" target="_blank" rel="noopener noreferrer" data-review-answer="rate"><?php echo esc_html__('Leave a review anyway', UMS_LANG_CODE); ?></a>
            </div>
        </div>

        <div class="ums-review-step" data-review-step="thanks" hidden>
            <p class="ums-review-eyebrow"><?php echo esc_html__('Thank you', UMS_LANG_CODE); ?></p>
            <h3 class="ums-review-title"><?php echo esc_html__('You made our day', UMS_LANG_CODE); ?></h3>
            <p class="ums-review-text"><?php echo esc_html__('Every review helps the whole Supsystic team keep making Ultimate Maps better.', UMS_LANG_CODE); ?></p>
        </div>

        <div class="ums-review-step" data-review-step="support" hidden>
            <p class="ums-review-eyebrow"><?php echo esc_html__('Thank you', UMS_LANG_CODE); ?></p>
            <h3 class="ums-review-title"><?php echo esc_html__('We will get it sorted', UMS_LANG_CODE); ?></h3>
            <p class="ums-review-text"><?php echo esc_html__('Our support page is open in a new tab. Describe the problem and we will get back to you.', UMS_LANG_CODE); ?></p>
        </div>
    </div>

    <button type="button" class="ums-review-close" data-review-answer="close" aria-label="<?php echo esc_html__('Dismiss', UMS_LANG_CODE); ?>">
        <svg viewBox="0 0 16 16" width="14" height="14" aria-hidden="true" focusable="false"><path d="M4 4l8 8M12 4l-8 8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
    </button>
</section>
