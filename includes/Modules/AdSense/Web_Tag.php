<?php
/**
 * Class Google\Site_Kit\Modules\AdSense\Web_Tag
 *
 * @package   Google\Site_Kit\Modules\AdSense
 * @copyright 2021 Google LLC
 * @license   https://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @link      https://sitekit.withgoogle.com
 */

namespace Google\Site_Kit\Modules\AdSense;

use Google\Site_Kit\Core\Modules\Tags\Module_Web_Tag;
use Google\Site_Kit\Core\Util\Method_Proxy_Trait;
use Google\Site_Kit\Core\Tags\Tag_With_DNS_Prefetch_Trait;
use Google\Site_Kit\Core\Util\BC_Functions;

/**
 * Class for Web tag.
 *
 * @since 1.24.0
 * @access private
 * @ignore
 */
class Web_Tag extends Module_Web_Tag {

	use Method_Proxy_Trait, Tag_With_DNS_Prefetch_Trait;

	/**
	 * Whether or not to use ad blocker detection snippet.
	 *
	 * @since n.e.x.t
	 * @var bool
	 */
	private $use_ad_blocker_detection_snippet;

	/**
	 * Whether or not to use ad blocker detection error snippet.
	 *
	 * @since n.e.x.t
	 * @var bool
	 */
	private $use_ad_blocker_detection_error_snippet;

	/**
	 * Recovery tag HTML.
	 *
	 * @since n.e.x.t
	 * @var string
	 */
	private $recovery_tag_html;

	/**
	 * Error protection HTML.
	 *
	 * @since n.e.x.t
	 * @var string
	 */
	private $error_protection_html;

	/**
	 * Sets whether or not to use ad blocker detection snippet.
	 *
	 * @since n.e.x.t
	 *
	 * @param bool $use_ad_blocker_detection_snippet Whether or not to use ad blocker detection snippet.
	 */
	public function set_use_ad_blocker_detection_snippet( $use_ad_blocker_detection_snippet ) {
		$this->use_ad_blocker_detection_snippet = (bool) $use_ad_blocker_detection_snippet;
	}

	/**
	 * Sets whether or not to use ad blocker detection error snippet.
	 *
	 * @since n.e.x.t
	 *
	 * @param bool $use_ad_blocker_detection_error_snippet Whether or not to use ad blocker detection error snippet.
	 */
	public function set_use_ad_blocker_detection_error_snippet( $use_ad_blocker_detection_error_snippet ) {
		$this->use_ad_blocker_detection_error_snippet = (bool) $use_ad_blocker_detection_error_snippet;
	}

	/**
	 * Sets the recovery tag HTML.
	 *
	 * @since n.e.x.t
	 *
	 * @param string $recovery_tag_html Recovery tag HTML.
	 */
	public function set_recovery_tag_html( $recovery_tag_html ) {
		$this->recovery_tag_html = $recovery_tag_html;
	}

	/**
	 * Sets the error protection HTML.
	 *
	 * @since n.e.x.t
	 *
	 * @param string $error_protection_html Error protection HTML.
	 */
	public function set_error_protection_html( $error_protection_html ) {
		$this->error_protection_html = $error_protection_html;
	}

	/**
	 * Registers tag hooks.
	 *
	 * @since 1.24.0
	 */
	public function register() {
		add_action( 'wp_head', $this->get_method_proxy_once( 'render' ) );

		add_filter(
			'wp_resource_hints',
			$this->get_dns_prefetch_hints_callback( '//pagead2.googlesyndication.com' ),
			10,
			2
		);

		$this->do_init_tag_action();
	}

	/**
	 * Outputs the AdSense script tag.
	 *
	 * @since 1.24.0
	 */
	protected function render() {
		// If we haven't completed the account connection yet, we still insert the AdSense tag
		// because it is required for account verification.

		$adsense_script_src = sprintf(
			'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=%s&host=%s',
			esc_attr( $this->tag_id ), // Site owner's web property code.
			'ca-host-pub-2644536267352236' // SiteKit's web property code.
		);

		$adsense_script_attributes = array(
			'async'       => true,
			'src'         => $adsense_script_src,
			'crossorigin' => 'anonymous',
		);

		$adsense_consent_attributes = $this->get_tag_blocked_on_consent_attribute_array();
		$adsense_attributes         = $adsense_consent_attributes;

		$auto_ads_opt = array();

		$auto_ads_opt_filtered = apply_filters( 'googlesitekit_auto_ads_opt', $auto_ads_opt, $this->tag_id );

		if ( is_array( $auto_ads_opt_filtered ) && ! empty( $auto_ads_opt_filtered ) ) {
			$strip_attributes = array(
				'google_ad_client'      => '',
				'enable_page_level_ads' => '',
			);

			$auto_ads_opt_filtered = array_diff_key( $auto_ads_opt_filtered, $strip_attributes );

			$auto_ads_opt_sanitized = array();

			foreach ( $auto_ads_opt_filtered as $key => $value ) {
				$new_key  = 'data-';
				$new_key .= str_replace( '_', '-', $key );

				$auto_ads_opt_sanitized[ $new_key ] = $value;
			}

			$adsense_attributes = array_merge( $adsense_attributes, $auto_ads_opt_sanitized );
		}

		printf( "\n<!-- %s -->\n", esc_html__( 'Google AdSense snippet added by Site Kit', 'google-site-kit' ) );
		BC_Functions::wp_print_script_tag( array_merge( $adsense_script_attributes, $adsense_attributes ) );
		printf( "\n<!-- %s -->\n", esc_html__( 'End Google AdSense snippet added by Site Kit', 'google-site-kit' ) );

		if ( $this->use_ad_blocker_detection_snippet ) {
			printf( "\n<!-- %s -->\n", esc_html__( 'Ad blocker detection snippet added by Site Kit', 'google-site-kit' ) );
			BC_Functions::wp_print_inline_script_tag( $this->recovery_tag_html, $adsense_consent_attributes );
			printf( "\n<!-- %s -->\n", esc_html__( 'End ad blocker detection snippet added by Site Kit', 'google-site-kit' ) );

			if ( $this->use_ad_blocker_detection_error_snippet ) {
				printf( "\n<!-- %s -->\n", esc_html__( 'Ad blocking recovery error protection snippet added by Site Kit', 'google-site-kit' ) );
				BC_Functions::wp_print_inline_script_tag(
					$this->error_protection_html,
					$adsense_consent_attributes
				);
				printf( "\n<!-- %s -->\n", esc_html__( 'End ad blocking recovery error protection snippet added by Site Kit', 'google-site-kit' ) );
			}
		}
	}

}
