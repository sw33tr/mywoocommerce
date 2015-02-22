<?php
/**
 * Checkout billing information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="woocommerce-billing-fields">
	<?php if ( WC()->cart->ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h3><?php _e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h3>

	<?php else : ?>

		<h3><?php _e( 'Billing Details', 'woocommerce' ); ?></h3>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<?php do_action('woocommerce_after_checkout_billing_form', $checkout ); ?>

	
	<?php
		// array de ordonare pt prima parte din formular
		$order_arr1 = array(
						'1' => 'billing_country',
						'2' => 'billing_first_name',
						'3' => 'billing_last_name',
						'9' => 'billing_email',
						'10' => 'billing_phone',
						'4' => 'billing_address_1',
						'5' => 'billing_address_2',
						'6' => 'billing_city',
						'7' => 'billing_state',
						'8' => 'billing_postcode',

						);

		// array de ordonare pt a doua parte din formular, partea ascunsa cu checkboxul (firma?)
		$order_arr2 = array(						
						'11' => 'billing_company',
						'12' => 'billing_vatno',
						'13' => 'billing_regcomno',
						'14' => 'billing_bankaccountno',
			);
		
		// reordonarea primei parti din formular
		$new_ordered_checkout_fields = array();
		foreach ($order_arr1 as $ky => $vl) {
			$new_ordered_checkout_fields[$vl] = $checkout->checkout_fields['billing'][$vl];
		}
		
		// reordonarea partii a doua din formular, partea ascunsa de checkbox (firma?)
		$new_ordered_checkout_fields2 = array();
		foreach ($order_arr2 as $k => $v) {
			$new_ordered_checkout_fields2[$v] = $checkout->checkout_fields['billing'][$v];
		}

	 	// foreach ( $checkout->checkout_fields['billing'] as $key => $field ) : // original, scos pentru a putea pune array-urile noi, reordonate
	 	foreach ( $new_ordered_checkout_fields as $key => $field ) : ?>

		<?php 

		woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); 


		if($key == 'billing_phone'){ ?>
			

				<?php // partea de create account, este pusa dupa email  ?>
				<?php if ( ! is_user_logged_in() && $checkout->enable_signup ) : ?>

					<?php if ( $checkout->enable_guest_checkout ) : ?>

						<p class="form-row form-row-wide create-account">
							<input class="input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true) ?> type="checkbox" name="createaccount" value="1" /> <label for="createaccount" class="checkbox"><?php _e( 'Create an account?', 'woocommerce' ); ?></label>
						</p>

					<?php endif; ?>

					<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

					<?php if ( ! empty( $checkout->checkout_fields['account'] ) ) : ?>

						<div class="create-account">

							<p><?php _e( 'Create an account by entering the information below. If you are a returning customer please login at the top of the page.', 'woocommerce' ); ?></p>

							<?php foreach ( $checkout->checkout_fields['account'] as $key => $field ) : ?>

								<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

							<?php endforeach; ?>

							<div class="clear"></div>

						</div>

					<?php endif; ?>

					<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>

				<?php endif; ?>
				<?php // sfarsitul partii de "create account"  ?>


		<?php		
		}

		?>

	<?php endforeach; ?>

	


	<?php
	
	// checkbox-ul pentru ascunderea field-urilor pt firma. (comp_name, cui, reg com, banca )
	echo '<h3 id="firma_input">';
		// "firma?" schimbi tu cum vrei sa arate 
		echo '<label for="firma-checkbox" class="checkbox">'. _e( 'Persoană juridică? ', 'woocommerce' ).'</label>';
		echo '<input id="firma-checkbox" class="input-checkbox" type="checkbox" name="firma" value="1" />';
	echo '</h3>';

	echo '<div class="firma" style="display: none;">';
	foreach ($new_ordered_checkout_fields2 as $kky => $vvl) {
			
		woocommerce_form_field( $kky, $vvl, $checkout->get_value( $kky ) ); 

	}

	echo "</div>";
	echo '<div class="clear"></div>';


	?>


</div>