<?php
/**
 * Plugin Name: Get Parent Theme Mod by Kmical Lights
 * Plugin URI: https://github.com/kmix-39
 * Description: This is Sample Code
 * Version: 0.1.0
 * Requires at least: 5.5
 * Requires PHP: 7.0
 * Tested up to: 5.5.1
 * Author: Kmical Lights
 * Author URI: https://github.com/kmix-39
 * License: GPL2 or later
 * License URI: https://github.com/kmix-39
 * Text Domain: kl-get-parent-theme-mod
 * Domain Path: /languages
 */
namespace KmicalLights\SampleCode\GetParentThemeMod;

defined( 'ABSPATH' ) || exit;

class Bootstrap {

	private $_mod_name = '';
	private $_parent_theme_mods = [];
	private $_child_theme_mods = [];

	function __construct() {
		add_action( 'plugins_loaded', [ $this, '_plugins_loaded' ] );
	}
	
	function _plugins_loaded() {
		// TODO: ここを親テーマのテーマ設定値すべてロードすればよさそう
		$_mods_name = [
			'custom_logo',	// テスト用：カスタムロゴ
		];

		foreach ( $_mods_name as $_mod_name ) {
			// TODO: ここでMOD設定値を親テーマから読むかを判定し、 true なら 下記の処理をすればよし
			$this->_mod_name = $_mod_name;
			add_filter( 'theme_mod_' . $_mod_name, [ $this, '_get_parent_theme_mod' ] );
		}
	}

	function _get_parent_theme_mod( $_value ) {
		// 子テーマの値を読む
		$_child_value = $this->get_child_theme_mod( $this->_mod_name, $_value );
		// 親テーマの値を読む
		$_parent_value = $this->get_parent_theme_mod( $this->_mod_name, $_child_value );

		return $_parent_value;
	}

	function get_parent_theme_mod( $_name, $_default ) {
		$this->get_parent_theme_mods();
		if ( isset( $this->_parent_theme_mods[$_name] ) ) {
			return $this->_parent_theme_mods[$_name];
		}
		return $_default;
	}

	function get_child_theme_mod( $_name, $_default ) {
		$this->get_child_theme_mods();
		if ( isset( $this->_child_theme_mods[$_name] ) ) {
			return $this->_child_theme_mods[$_name];
		}
		return $_default;
	}

	private function get_parent_theme_mods() {
		if ( empty( $this->_parent_theme_mods ) ) {
			$_child_theme = wp_get_theme( get_stylesheet() );
			$_parent_theme_slug = $_child_theme->Template;
			$this->_parent_theme_mods = get_option( 'theme_mods_' . $_parent_theme_slug );
		}
		return $this->_parent_theme_mods;
	}

	private function get_child_theme_mods() {
		if ( empty( $this->_child_theme_mods ) ) {
			$_child_theme_slug = get_stylesheet();
			$this->_child_theme_mods = get_option( 'theme_mods_' . $_child_theme_slug );
		}
		return $this->_child_theme_mods;
	}

}

new Bootstrap();
