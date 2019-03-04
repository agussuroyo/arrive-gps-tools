<?php
defined( 'ABSPATH' ) || exit();
?>
<form action="" method="post">
	<?php
	if ( isset( $success_message ) && is_array( $success_message ) ) {
		echo '<ul class="fw-flash-type-success">';
		foreach ( $success_message as $message ) {
			?>
		<li class="fw-flash-message"><?php echo $message; ?></li>
			<?php
		}
		echo '</ul>';
	}
	?>
	<div class="wrap-forms">
		<div class="fw-row">
			<div class="fw-col-xs-12 fw-col-sm-6 form-builder-item">
				<div class="field-text">
					<input type="text" name="agt_unique_name" class="" value="<?php echo isset( $fields['agt_unique_name'] ) ? $fields['agt_unique_name'] : null; ?>" placeholder="SIM Unique Name" autocomplete="off" />
				</div>
		<?php echo agt_inline_error( 'agt_unique_name' ); ?>
			</div>
		</div>
		<div class="fw-row">
			<div class="fw-col-xs-12 fw-col-sm-6 form-builder-item">
				<div class="field-select">
			<?php
			$selected = isset( $fields['agt_rates'] ) ? $fields['agt_rates'] : null;
			?>
					<select name="agt_rates">
						<option value="">Rate Plan</option>
			<?php
			foreach ( $rates as $id => $rate ) {
				?>
				<option value="<?php echo $id; ?>" <?php selected( $selected, $id ); ?>><?php echo $rate; ?></option>
				<?php
			}
			?>
					</select>
				</div>
		<?php echo agt_inline_error( 'agt_rates' ); ?>
			</div>
		</div>
		<div class="fw-row">
			<div class="fw-col-md-12">
				<button name="agt_submit" type="submit" value="1">Activate</button>
			</div>
		</div>
	</div>
</form>
