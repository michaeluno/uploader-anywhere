<?php
/**
 * Enqueues replacer JavaScript scripts.
 * 
 * @since   0.0.1
 */
class UploaderAnywhere_Routine_Enqueuer {
    
    /**
     * Sets up hooks
     * 
     * @since   0.0.1
     */
    public function __construct() {

        // Check whether to process.
        if ( defined( 'DOING_CRON' ) && DOING_CRON ) {
            return;
        }
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            
            return;
        }
        
        add_action( 'admin_enqueue_scripts', array( $this, '_replyToEnqueueScript' ) );
        
    }
    
    /**
     * Performs enqueuing scripts that replaces HTML elements with an uploader modal window link.
     */
    public function _replyToEnqueueScript() {

        // Check whether to process.
        if ( ! isset( $GLOBALS['pagenow'] ) ) {
            return;
        }   
        
        // Retrieve rules.
        $_oRules    = new UploaderAnywhere_Routine_Rule( $GLOBALS['pagenow'] );
        $_aRules    = $_oRules->get();
        if ( empty( $_aRules ) ) {
            return;
        }        
    
        wp_enqueue_media();
        wp_enqueue_script( 'media-upload' );    
        
        // Event binder.
        wp_enqueue_script( 
            'uploader_anywhere',     // handle id
            UploaderAnywhere_Registry::getPluginURL( '/asset/js/uploader-anywhere.js' ), // script url
            array( 'jquery', 'media-upload' ),     // dependencies
            '',     // version
            true    // in footer? yes
        );  
        
        // Element replacer.
        wp_enqueue_script( 
            'uploader_anywhere_replacer',     // handle id
            UploaderAnywhere_Registry::getPluginURL( '/asset/js/replace-with-uploader-button.js' ), // script url
            array( 'uploader_anywhere' ),     // dependencies
            '',     // version
            true    // in footer? yes
        );
        wp_localize_script( 
            'uploader_anywhere_replacer',        // handle id - the above used enqueue handl id
            'uploader_anywhere_rules',  // name of the data loaded in the script
            $_aRules // translation array
        ); 
     
    }

}