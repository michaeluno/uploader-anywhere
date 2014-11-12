<?php
/**
 * Allows uploadable mime types.
 * 
 * @since   0.0.1
 */
class UploaderAnywhere_Routine_MIMETypes {
    
    /**
     * Sets up hooks 
     *
    */
    public function __construct() {
    
        add_filter( 'upload_mimes', array( $this, 'replyToFilterUploadMimes' ) );
        
    }
    
    /**
     * This allows several file types to be uploaded with the WordPress media uploader.
     * 
     */
    public function replyToFilterUploadMimes( $aMimes ) {      
    
        // $aMimes[ 'eot' ]    = 'application/vnd.ms-fontobject';
        // $aMimes[ 'ttf' ]    = 'application/x-font-ttf';
        // $aMimes[ 'otf' ]    = 'font/opentype';
        // $aMimes[ 'woff' ]   = 'application/font-woff';
        // $aMimes[ 'svg' ]    = 'image/svg+xml';
        // $aMimes[ 'mp3' ]    = 'audio/mp3';
        // $aMimes[ 'mp4' ]    = 'audio/mp4';
        // 'jpg|jpeg|jpe' => 'image/jpeg', 
        // 'gif' => 'image/gif', 
        // 'png' => 'image/png',         
        
        $_aPluginOptions = get_option( UploaderAnywhere_Registry::OptionKey, array() );
        $_aAllowedTypes  = isset( $_aPluginOptions[ 'general' ][ 'allowed_file_types' ] ) ? $_aPluginOptions[ 'general' ][ 'allowed_file_types' ] : array();
        $_aAllowedTypes  = is_array( $_aAllowedTypes ) ? $_aAllowedTypes : array();
        foreach( $_aAllowedTypes as $_iIndex => $_aFileType ) {
            $aMimes = array(
                $_aFileType['file_extensions'] => $_aFileType['mime_type'],
            ) + $aMimes;
        }
        return $aMimes;
        
    }        
    
}