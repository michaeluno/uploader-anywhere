<?php
/**
 * Adds the Settings page of the plugin.
 * 
 * @package      Uploader Anywhere
 * @copyright    Copyright (c) 2014, Michael Uno
 * @author       Michael Uno
 * @authorurl    http://michaeluno.jp
 * @since        0.0.1
 */
class UploaderAnywhere_AdminPage_Settings {

    public function __construct() {

        add_action( "load_" . UploaderAnywhere_Registry::AdminPage_Settings, array( $this, '_replyToLoadSettingPage' ) );
        add_action( "load_" . UploaderAnywhere_Registry::AdminPage_Settings . '_' . 'general', array( $this, '_replyToLoadGeneralTab' ) );
        add_action( "load_" . UploaderAnywhere_Registry::AdminPage_Settings . '_' . 'system', array( $this, '_replyToLoadSystemTab' ) );

    }
    
    public function _replyToLoadSettingPage( $oAdminPage ) {

        $oAdminPage->addInPageTabs( 
            UploaderAnywhere_Registry::AdminPage_Settings,  // the target page slug
            array(
                'tab_slug'  => 'general',
                'title'     => __( 'General', 'uploader-anywhere' ),
            ),     
            array(
                'tab_slug'  => 'system',
                'title'     => __( 'System', 'uploader-anywhere' ),
            )
        );             
    
    }

    /**
     * Defines the fields of the 'system' tab.
     * 
     */
    public function _replyToLoadGeneralTab( $oAdminPage ) {
        
        $oAdminPage->addSettingSections(    
            UploaderAnywhere_Registry::AdminPage_Settings, // the target page slug
            array(
                'section_id'        => 'general', // avoid hyphen(dash), dots, and white spaces
                'tab_slug'          => 'general',
                'title'             => __( 'General Settings', 'uploader-anywhere' ),
            )
        );        
        
        $oAdminPage->addSettingFields(
            'general',   // section id
            array(
                'field_id'      => 'allowed_file_types',
                'type'          => 'multiple_text',     
                'title'         => __( 'Allowed File Extensions and MIME Types', 'uploader-anywhere' ),
                'repeatable'    => true,
                'label'         => array(
                    'file_extensions'   => __( 'File Extensions', 'uploader-anywhere' ),
                    'mime_type'         => __( 'MIME Type', 'uploader-anywhere' ),
                ),
                'description'       => array(
                    __( 'Set the file extension(s) delimited by the pipe(|) character.', 'uploader-anywhere' )
                        . ' ' . 'e.g.<code>php|inc</code>',
                    __( 'Set the MIME type.', 'uploader-anywhere' ) . ' ' . 'e.g.<code>application/x-php</code>',                    
                    sprintf( __( 'For more reference, see <a href="%1$s" target="_blank">here</a>.', 'uploader-anywhere' ), esc_url( 'http://en.wikipedia.org/wiki/Internet_media_type#List_of_common_media_types' ) ),                    
                ),
            ),
            array(
                'field_id'          => 'submit',
                'type'              => 'submit',                 
                'value'             => __( 'Save', 'uploader-anywhere' ),
                'label_min_width'   => 0,
                'attributes'        => array(
                    'field' => array(
                        'style' => 'float:right; clear:none; display: inline;',
                    ),                
                ),
            )
        );        
        
    }
    
    /**
     * Defines the fields of the 'system' tab.
     * 
     */
    public function _replyToLoadSystemTab( $oAdminPage ) {
        
        $oAdminPage->addSettingSections(    
            UploaderAnywhere_Registry::AdminPage_Settings, // the target page slug
            array(
                'section_id'        => 'system_information', // avoid hyphen(dash), dots, and white spaces
                'tab_slug'          => 'system',
                'title'             => __( 'System Information', 'uploader-anywhere' ),
            )
        );

       $oAdminPage->addSettingFields(
            'system_information',   // section id
            array(
                'field_id'      => 'system_information',
                'type'          => 'system',     
                'title'         => __( 'System Information', 'uploader-anywhere' ),
                'data'          => array(
                    __( 'Current Time', 'admin-page-framework' )        => '', // Removes the Current Time Section.
                ),
                'attributes'    => array(
                    'name'          => '',
                ),
            )
        );
        
    }
    
}

