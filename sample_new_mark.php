<?php
/**
 * @package snow-monkey
 * @author inc2734
 * @license GPL-2.0+
 * @version 11.3.3
 */

use Framework\Helper;

$args = wp_parse_args(
	// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable
	$args,
	// phpcs:enable
	[
		'_terms' => [],
	]
);

if ( ! $args['_terms'] ) {
	return;
}
?>

<?php foreach ( $args['_terms'] as $_term ) : ?>
<?php
	$_new_days = 3;
	$_now_date = date_i18n( 'U' );
	$_post_date = date_i18n( 'U', strtotime( get_post()->post_date ) );
	$_range_date = date( 'U', ( $_now_date - $_post_date ) ) / 86400;
	if ( $_new_days >= $_range_date ) {
?>
		<span class="c-entry-summary__term">新着記事（NEW）</span>
<?php
	} else {
?>
<span class="c-entry-summary__term c-entry-summary__term--<?php echo esc_attr( $_term->taxonomy . '-' . $_term->term_id ); ?>">
	<?php echo esc_html( $_term->name ); ?>
</span>
<?php
	}
?>
<?php endforeach; ?>
