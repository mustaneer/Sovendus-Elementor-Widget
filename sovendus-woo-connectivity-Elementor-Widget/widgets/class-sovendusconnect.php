<?php
/**
 * ElementorSovendus class.
 *
 * @category   Class
 *
 * @license	https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 *
 * @since	  1.0.0
 * php version 7.3.9
 */

namespace Elementor_Sovendus\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();

/**
 * Sovendusconnect widget class.
 *
 * @since 1.0.0
 */
class Sovendusconnect extends Widget_Base {

	/**
	 * Class constructor.
	 *
	 * @param array $data widget data
	 * @param array $args widget arguments
	 */
	public function __construct( $data=[], $args=null ) {
		parent::__construct( $data, $args );

		wp_register_style( 'sovendusconnect', plugins_url( '/assets/css/sovendusconnect.css', SOVENDUS_WOOCONNECT ), [], '1.0.0' );
	}

	/**
	 * Retrieve the widget name.
	 *
	 * @return string widget name
	 *
	 * @since 1.0.0
	 */
	public function get_name() {
		return 'sovendusconnect';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string widget title
	 *
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Sovendus Woo-Connect', 'sovendus-connectivity' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string widget icon
	 *
	 * @since 1.0.0
	 */
	public function get_icon() {
		return 'fa fa-pencil';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @return array widget categories
	 *
	 * @since 1.0.0
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Enqueue styles.
	 */
	public function get_style_depends() {
		return [ 'sovendusconnect' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Sovendus Keys', 'sovendus-connectivity' ),
			]
		);

		$this->add_control(
			'traffic_source_number',
			[
				'label'   => __( 'TRAFFIC SOURCE NUMBER', 'sovendus-connectivity' ),
				'type'	   => Controls_Manager::TEXT,
				'default' => __( 'TRAFFIC SOURCE NUMBER', 'sovendus-connectivity' ),
			]
		);

		$this->add_control(
			'traffic_medium_number',
			[
				'label'   => __( 'TRAFFIC MEDIUM NUMBER', 'sovendus-connectivity' ),
				'type'	   => Controls_Manager::TEXTAREA,
				'default' => __( 'TRAFFIC MEDIUM NUMBER', 'sovendus-connectivity' ),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 */
	protected function render() {
		$settings=$this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'title', 'none' );
		$this->add_inline_editing_attributes( 'description', 'basic' );

		if ( isset( $_GET['key'] ) ) {
			$order_id=wc_get_order_id_by_order_key( $_GET['key'] );
			$order=wc_get_order( $order_id );

			if ( ! empty( $order ) ) {
				$coupons_count=count( $order->get_used_coupons() );
				$coupons_list='';

				if ( ! empty( $order->get_used_coupons() ) ) {
					foreach ( $order->get_used_coupons() as $coupon ) {
						$coupons_list .= $coupon;

						if ( $i < $coupons_count ) {
							$coupons_list .= ', ';
						}
						$i ++;
					}
				}
				$trafficSourceNumber=XXXX;  // Enter your traffic source number
				$trafficMediumNumber=X;  // Enter traffic medium number
				//$sessionId =  bin2hex(random_bytes(20));
				$sessionId=$order->get_cart_hash();
				$timestamp=strtotime( $order->get_date_created() );
				$orderId=$order_id;
				$orderValue=$order->get_total();
				$orderCurrency=$order->get_currency();
				$usedCouponCode=$coupons_list;

				$consumerFirstName=$order->get_billing_first_name();
				$consumerLastName=$order->get_billing_last_name();
				$consumerEmail=$order->get_billing_email();
				$consumerCountry=$order->get_billing_country();
				$consumerZipcode=$order->get_billing_postcode(); ?>
				<!--sovendus code begin -->

				<div id="sovendus-container-1"></div>
				<!--the integration loads the content into this div element-->
				<script type="text/javascript">
					window.sovIframes = window.sovIframes || [];
					window.sovIframes.push({
						trafficSourceNumber: '<?php echo $trafficSourceNumber; ?>',
						trafficMediumNumber: '<?php echo $trafficMediumNumber; ?>',
						sessionId: '<?php echo $sessionId; ?>',
						timestamp: '<?php echo $timestamp; ?>',
						orderId: '<?php echo $orderId; ?>',
						orderValue: '<?php echo $orderValue; ?>',
						orderCurrency: '<?php echo $orderCurrency; ?>',
						usedCouponCode: '<?php echo $usedCouponCode; ?>',
						iframeContainerId: 'sovendus-container-1'
					});
					window.sovConsumer = window.sovConsumer || {};
					window.sovConsumer = {
						consumerSalutation: 'Mr.',
						consumerFirstName: '<?php echo $consumerFirstName; ?>',
						consumerLastName: '<?php echo $consumerLastName; ?>',
						consumerEmail: '<?php echo $consumerEmail; ?>',
						consumerCountry: '<?php echo $consumerCountry; ?>',
						consumerZipcode: '<?php echo $consumerZipcode; ?>'
					};
					var sovDomain = window.location.protocol + '\x2F\x2F' + 'api.sovendus.com';
					var sovJsFile = sovDomain + '\x2Fsovabo\x2Fcommon\x2Fjs\x2FflexibleIframe.js';
					document.write('<sc' + 'ript async="true" src="' + sovJsFile + '" type="text/javascript"></sc' +
						'ript>');
				</script>
				<!--sovendus code end -->
				<?php
			} // End of Order Object
		} // End of GET Condition
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 */
	protected function _content_template() {
		?>
<# view.addInlineEditingAttributes( 'title' , 'none' ); view.addInlineEditingAttributes( 'description' , 'basic' ); view.addInlineEditingAttributes( 'content' , 'advanced' ); #>
	<!-- <h2 {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</h2>
		<div {{{ view.getRenderAttributeString( 'description' ) }}}>{{{ settings.description }}}</div>
		<div {{{ view.getRenderAttributeString( 'content' ) }}}>{{{ settings.content }}}</div> -->
	<?php
	}
}
