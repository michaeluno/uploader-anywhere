<?php
/**
 * Handles the initial set-up for the plugin.
 *    
 * @package      Upload Anywhere
 * @copyright    Copyright (c) 2014, <Michael Uno>
 * @author       Michael Uno
 * @authorurl    http://michaeluno.jp
 * @since        0.0.1
 * 
 */

/**
 * Loads the plugin.
 * 
 * @action  do  uploader_anywhere_action_after_loading_plugin
 */
final class UploaderAnywhere_Bootstrap {
    
    /**
     * Indicates whether the bootstrap has been loaded or not so that multiple instances of this class won't be created.      
     */
    static public $_bLoaded = false;
    
    /**
     * Sets up properties and hooks.
     * 
     */
    public function __construct( $sPluginFilePath ) {
        
        // Do not allow multiple instances per page load.
        if ( self::$_bLoaded ) {
            return;
        }
        self::$_bLoaded = true;
        
        // Set up properties
        $this->_sFilePath = $sPluginFilePath;
        $this->_bIsAdmin = is_admin();
        
        // 1. Define constants.
        // $this->_defineConstants();
        
        // 2. Set global variables.
        // $this->_setGlobalVariables();
            
        // 3. Set up auto-load classes.
        $this->_loadClasses( $this->_sFilePath );

        // 4. Set up activation hook.
        register_activation_hook( $this->_sFilePath, array( $this, '_replyToDoWhenPluginActivates' ) );
        
        // 5. Set up deactivation hook.
        register_deactivation_hook( $this->_sFilePath, array( $this, '_replyToDoWhenPluginDeactivates' ) );
                
        // 7. Check requirements.
        add_action( 'admin_init', array( $this, '_replyToCheckRequirements' ) );
        
        // 8. Schedule to load plugin specific components.
        add_action( 'plugins_loaded', array( $this, '_replyToLoadPluginComponents' ) );
                        
    }    
    
    /**
     * Sets up constants.
     */
    // private function _defineConstants() {}
    
    /**
     * Sets up global variables.
     */
    // private function _setGlobalVariables() {}
    
    /**
     * Register classes to be auto-loaded.
     * 
     */
    private function _loadClasses( $sFilePath ) {
        
        $_sPluginDir =  dirname( $sFilePath );
                    
        // Include libraries            
        include( $_sPluginDir . '/include/library/admin-page-framework/uploader-anywhere-admin-page-framework.min.php' );
        include( $_sPluginDir . '/include/class/boot/UploaderAnywhere_AutoLoad.php' );
                    
        // Include the include lists. The including file reassigns the list(array) to the $_aClassFiles variable.
        $_aClassFiles        = array();
        include( $_sPluginDir . '/include/uploader-anywhere-include-class-file-list.php' );

        // Register them
        new UploaderAnywhere_AutoLoad( 
            array(),        // scanning dirs
            array(),        // options
            $_aClassFiles   // pre-generated class list
        );
                
    }

    /**
     * 
     * @since            0.0.1
     */
    public function _replyToCheckRequirements() {

        new UploaderAnywhere_Requirements( 
            $this->_sFilePath,
            array(
                'php' => array(
                    'version'    =>    UploaderAnywhere_Registry::RequiredPHPVersion,
                    'error'        =>    __( 'The plugin requires the PHP version %1$s or higher.', 'uploader-anywheere' ),
                ),
                'wordpress' => array(
                    'version'    =>    UploaderAnywhere_Registry::RequiredWordPressVersion,
                    'error'        =>    __( 'The plugin requires the WordPress version %1$s or higher.', 'uploader-anywheere' ),
                ),
                // 'mysql'    =>    array(
                    // 'version'    =>    '5.5.24',
                    // 'error' => __( 'The plugin requires the MySQL version %1$s or higher.', 'uploader-anywheere' ),
                // ),
                'functions' => array(
                    'curl_version' => sprintf( __( 'The plugin requires the %1$s to be installed.', 'uploader-anywheere' ), 'the cURL library' ),
                ),
                // 'classes' => array(
                    // 'DOMDocument' => sprintf( __( 'The plugin requires the <a href="%1$s">libxml</a> extension to be activated.', 'pseudo-image' ), 'http://www.php.net/manual/en/book.libxml.php' ),
                // ),
                'constants'    => array(),
            )
        );    
        
    }

    /**
     * The plugin activation callback method.
     */    
    public function _replyToDoWhenPluginActivates() {   
    
        new UploaderAnywhere_ExampleRule;
    
    }

    /**
     * The plugin deactivation callback method.
     */
    public function _replyToDoWhenPluginDeactivates() {
    }    
    
    /**
     * Load localization files.
     */
    private function _localize() {
        
        load_plugin_textdomain( 
            UploaderAnywhere_Registry::TextDomain, 
            false, 
            dirname( plugin_basename( $this->_sFilePath ) ) . '/language/'
        );
        
        if ( $this->_bIsAdmin ) {
            load_plugin_textdomain( 
                'admin-page-framework', 
                false, 
                dirname( plugin_basename( $this->_sFilePath ) ) . '/language/'
            );        
        }
        
    }        
    
    /**
     * Loads the plugin specific components. 
     * 
     * @remark        All the necessary classes should have been already loaded.
     */
    public function _replyToLoadPluginComponents() {

        // 1. Set up localization.
        $this->_localize();
    
        // 2. Post types.
        new UploaderAnywhere_PostType_Link( 
            UploaderAnywhere_Registry::PostType_Link,     // post type slug
            null,               // arguments
            $this->_sFilePath   // caller script path
        );
        
        // 3. Admin pages
        if ( $this->_bIsAdmin ) {
            
            // 3.1. Create admin pages - just the example link in the submenu.
            new UploaderAnywhere_AdminPage( 
                UploaderAnywhere_Registry::OptionKey,     
                $this->_sFilePath   // caller script path
            );
            new UploaderAnywhere_AdminPage_Settings;
            
            // 3.2. Meta Boxes for task editing page (post.php).
            $this->_registerMetaBoxes();
        
        }            
        
        // Modules should use this hook.
        do_action( 'uploader_anywhere_action_after_loading_plugin' );
        
        // Allow set file and mime types 
        new UploaderAnywhere_Routine_MIMETypes;
        
        // Now do the plugin routines - replace elements with uplaoder buttons.
        new UploaderAnywhere_Routine_Enqueuer;
        
    }

        /**
         * Registers meta boxes.
         */
        protected function _registerMetaBoxes() {
            
            if ( ! isset( $GLOBALS['pagenow'] ) || ! in_array( $GLOBALS['pagenow'], array( 'post.php', 'post-new.php' ) ) ) {
                return;
            }
                        
            new UploaderAnywhere_MetaBox_Main(
                null,   // the meta box id, let it auto generate
                __( 'Target Pages', 'uploader-anywheere' ),
                array( UploaderAnywhere_Registry::PostType_Link ),  // belonging post type slugs
                'normal',    // context
                'high'       // priority
            );        
            new UploaderAnywhere_MetaBox_TargetElement(
                null,   // the meta box id, let it auto generate
                __( 'Target HTML Elements', 'uploader-anywheere' ),
                array( UploaderAnywhere_Registry::PostType_Link ),  // belonging post type slugs
                'normal',    // context
                'default'    // priority
            );                    
            new UploaderAnywhere_MetaBox_Uploader(
                null,   // the meta box id, let it auto generate
                __( 'Uploader Settings', 'uploader-anywheere' ),
                array( UploaderAnywhere_Registry::PostType_Link ),  // belonging post type slugs
                'normal',    // context         
                'low'        // priority
            );
            
        } 
        
}