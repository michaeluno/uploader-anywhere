<?php
/* 
    Plugin Name:    Uploader Anywhere
    Plugin URI:     http://en.michaeluno.jp/
    Description:    Inserts links of the uploader modal window anywhere in the admin area.
    Author:         Michael Uno
    Author URI:     http://michaeluno.jp
    Version:        1.0.1
    Requirements:   PHP 5.2.4 or above, WordPress 3.5 or above.
*/ 

/**
 * The base class of the registry class which provides basic plugin information.
 * 
 * The minifier script and the inclusion script also refer to the constants. 
 */
class UploaderAnywhere_Registry_Base {

	const Version        = '1.0.1';    // <--- DON'T FORGET TO CHANGE THIS AS WELL!!
	const Name           = 'Uploader Anywhere';
	const Description    = 'Inserts links of the uploader modal window anywhere in the admin area.';
	const URI            = 'http://en.michaeluno.jp/';
	const Author         = 'miunosoft (Michael Uno)';
	const AuthorURI      = 'http://en.michaeluno.jp/';
	const Copyright      = 'Copyright (c) 2014, Michael Uno';
	const License        = 'GPL v2 or later';
	const Contributors   = '';
	
}
/**
 * Provides plugin information.
 */
final class UploaderAnywhere_Registry extends UploaderAnywhere_Registry_Base {
	        
	// The plugin itself uses these values.
	const OptionKey                 = 'ua_options';
	const TransientPrefix           = 'UAWhere_';    // Up to 8 characters as transient name allows 45 characters or less ( 40 for site transients ) so that md5 (32 characters) can be added
	const TextDomain                = 'uploader-anywhere';
	const TextDomainPath            = './language';
    
	// const AdminPage_ = '...';
	const AdminPage_Root            = 'UploaderAnywhere_AdminPage';    // the root menu page slug
	const AdminPage_Settings        = 'ua_settings';    // the root menu page slug
    
    // const PostType_ = '';
	const PostType_Link             = 'ua_link';        // up to 20 characters
    
	// const Taxonomy_ = '';
	const RequiredPHPVersion        = '5.2.1';
	const RequiredWordPressVersion  = '3.5';
	    
	// These properties will be defined in the setUp() method.
	static public $sFilePath = '';
	static public $sDirPath  = '';
	
	/**
	 * Sets up static properties.
	 */
	static function setUp( $sPluginFilePath=null ) {
	                    
		self::$sFilePath = $sPluginFilePath ? $sPluginFilePath : __FILE__;
		self::$sDirPath  = dirname( self::$sFilePath );
	    
	}    
	
	/**
	 * Returns the URL with the given relative path to the plugin path.
	 * 
	 * Example:  UploaderAnywhere_Registry::getPluginURL( 'asset/css/meta_box.css' );
	 */
	public static function getPluginURL( $sRelativePath='' ) {
		return plugins_url( $sRelativePath, self::$sFilePath );
	}

}
/* Initial checks. */
if ( ! defined( 'ABSPATH' ) ) { return; }
if ( ! is_admin() ) { return; }

/* Registry set up. */
UploaderAnywhere_Registry::setUp( __FILE__ );

/* Run the bootstrap. */
include( dirname( __FILE__ ) . '/include/class/boot/UploaderAnywhere_Bootstrap.php' );    
new UploaderAnywhere_Bootstrap( __FILE__ );