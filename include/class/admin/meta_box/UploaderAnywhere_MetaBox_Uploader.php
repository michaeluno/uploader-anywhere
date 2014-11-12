<?php
/**
 * Creates a meta box for the uploader options.
 * 
 * @since            0.0.1
 */
class UploaderAnywhere_MetaBox_Uploader extends UploaderAnywhere_MetaBox_Base {
                
    /**
     * Adds form fields for the basic options.
     * 
     */ 
    public function setUp() {
        
        // Register custom field types
        new UploaderAnywhere_MultipleTextFieldType( $this->oProp->sClassName );
        
        // Add fields.
        $this->addSettingFields( 
            array(
                'field_id'      => 'reload_after_upload',
                'title'         => __( 'Reload (redirect) after Upload', 'uploader-anywhere' ),
                'type'          => 'revealer',
                'select_type'   => 'checkbox',
                'default'       => true,
                'label'         => array( 
                    '.reload_after_upload_row'  => __( 'Reload (redirect) the page after a file is uploaded via the uploader.', 'uploader-anywhere' ),
                ),
            ),    
                array(
                    'field_id'      => 'redirect_url_after_upload',
                    'title'         => __( 'Redirect URL', 'uploader-anywhere' ),
                    'type'          => 'text',
                    'description'   => __( 'If the above option is enabled, set this option to specify the redirecting url. Leave it empty to reload the page instead of redirection.', 'uploader-anywhere' ),
                    'attributes'    => array(
                        'size'  => 60,
                    ),
                    'class'         => array(
                        'fieldrow'  => 'reload_after_upload_row',
                    ),
                    'hidden'        => true,
                ),    
            array(
                'field_id'      => 'enable_media_library',
                'title'         => __( 'Media Library Tab', 'uploader-anywhere' ),
                'type'          => 'revealer',
                'select_type'   => 'radio',
                'default'       => 'undefined',
                'label'         => array(
                    '.enable_media_library_options'    => __( 'On', 'uploader-anywhere' ),
                    'undefined'                         => __( 'Off', 'uploader-anywhere' ),
                ),
                // 'description'   => __( 'If this is off, the below options will not take effect', 'uploader-anywhere' ),
            ),           
            array(
                'field_id'      => 'label_button_use_this',
                'title'         => __( 'Uploader Selector Button Label', 'uploader-anywhere'  ),
                'type'          => 'text',
                'default'       => __( 'Use This', 'uploader-anywhere' ),
                'class'         => array(
                    'fieldrow'  => 'enable_media_library_options',
                ),
                'hidden'        => true,
            ),            
            array(
                'field_id'      => 'file_type_filters',
                'title'         => __( 'File Type Filters', 'uploader-anywhere' ),
                'type'          => 'text',
                'repeatable'    => true,
                'description'   => array(
                    __( 'Type MIME types to filter files. The part after the slash can be omitted.', 'uploader-anywhere' )
                    . ' ' . sprintf( __( 'For more reference, see <a href="%1$s" target="_blank">here</a>.', 'uploader-anywhere' ), esc_url( 'http://en.wikipedia.org/wiki/Internet_media_type#List_of_common_media_types' ) ),
                    'e.g. <code>audio/mp3</code>, <code>image</code>, <code>application/pdf</code>',
                ),
                'class'         => array(
                    'fieldrow'  => 'enable_media_library_options',
                ),    
                'hidden'        => true,                
            ),                             
            array(
                'field_id'      => 'is_multiple',
                'title'         => __( 'Allow Multiple File Selections', 'uploader-anywhere' ),
                'type'          => 'checkbox',
                'default'       => true,
                'label'         => __( 'Check this when the uploader allows to select multiple files.', 'uploader-anywhere' ),
                'class'         => array(
                    'fieldrow'  => 'enable_media_library_options',
                ),   
                'hidden'        => true,                
            ),            
            array()
        );    
    
    }
    

    /*
     * Validation methods
     * 
     * @since   0.0.1
     */
    public function validation_UploaderAnywhere_MetaBox_Uploader( $aInput, $aOldInput, $oMetBox ) {    // validation_ + extended class name
      
        $_bIsValid  = true;
        $_aErrors   = array();
        
        foreach( $aInput['file_type_filters'] as $_iIndex => &$_sFileTypeFilter ) {
            $_sFileTypeFilter = trim( $_sFileTypeFilter );
        }
        
        $aInput['redirect_url_after_upload'] = trim( $aInput['redirect_url_after_upload'] );
        if ( $aInput['redirect_url_after_upload'] && ! filter_var( $aInput['redirect_url_after_upload'], FILTER_VALIDATE_URL) ) {

            $_aErrors['redirect_url_after_upload'] = __( 'The entered url does not appear to be a valid url.', 'uploader-anywhere' ) . ': ' . $aInput['redirect_url_after_upload'];
            $_bIsValid = false;     

        }
        
       if ( ! $_bIsValid ) {
            
            $this->setFieldErrors( $_aErrors );
            $this->setSettingNotice( __( 'There was an error in your input in meta box form fields', 'uploader-anywhere' ) );    
            return $aOldInput;
            
        }
        
        return $aInput;
        
    }
    
}