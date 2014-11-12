<?php
/**
 * Retrieves link embedding rules.
 * 
 * @since   0.0.1
 */
class UploaderAnywhere_Routine_Rule {
    
    /**
     * Stores the page base name passed in the constructor.
     * @since   0.0.1
     */
    protected $_sCurrentPageBaseName = '';
    
    
    /**
     * Sets up properties.
     * @since   0.0.1
     */
    public function __construct( $sCurrentPageBaseName ) {
        
        $this->_sCurrentPageBaseName = $sCurrentPageBaseName;
        
    }
    
    /**
     * Returns the user defined rules to replace elements.
     * 
     * @return  array the found rules.
     * @since   0.0.1
     */
    public function get() {
                
        // Retrieve posts that match the stored (current) base url name such as edit.php or post.php.
        $_aQueryArgs = array(
            'post_type'      => UploaderAnywhere_Registry::PostType_Link,
            'post_status'    => array( 'publish' ),    
            'posts_per_page' => -1,         // -1 for all            
            'orderby'        => 'date ID',  // another option: 'ID',    
            'order'          => 'ASC',      // DESC: the newest comes first, 'ASC' : the oldest comes first
            'fields'         => 'ids',      // return only post IDs by default.
            'meta_query' => array(
                array(
                    'key'     => 'base_url_name',
                    'value'   => array( '*', $this->_sCurrentPageBaseName ),
                    'compare' => 'IN',
                ),
            ),            
        );
        $_oResults      = new WP_Query( $_aQueryArgs );
        $_aPosts        = $_oResults->posts;  
        $_aPostMetas    = array();

        // Check the query key values.
        foreach( $_aPosts as $_iIndex => $_iPostID ) {
            
            $_aURLQueries = get_post_meta( $_iPostID, 'url_query_key_values', true );      
            if ( ! empty( $_aURLQueries ) && ! $this->_checkQueryKeyValues( $_aURLQueries ) ) {
                continue;
            }
            
            $_aPostMetas[ $_iPostID ] = array(
                'nth_item'                      => get_post_meta( $_iPostID, 'nth_item', true ),
                'selector'                      => get_post_meta( $_iPostID, 'selector', true ),
                'file_type_filters'             => implode( ',', ( array ) get_post_meta( $_iPostID, 'file_type_filters', true ) ),
                'is_multiple'                   => get_post_meta( $_iPostID, 'is_multiple', true ),
                'label_window_title'            => html_entity_decode( get_the_title( $_iPostID ), ENT_NOQUOTES, get_bloginfo( 'charset' ) ),
                'label_button_use_this'         => get_post_meta( $_iPostID, 'label_button_use_this', true ),
                'enable_media_library'          => $this->_getMetaValue( $_iPostID, 'enable_media_library' ),
                'reload_after_upload'           => $this->_getMetaValue( $_iPostID, 'reload_after_upload' ),
                'redirect_url_after_upload'     => get_post_meta( $_iPostID, 'redirect_url_after_upload', true ),
                'insert_method'                 => $this->_getMetaValue( $_iPostID, 'insert_method' ),
                'inserting_html_element'        => get_post_meta( $_iPostID, 'inserting_html_element', true ),
                'insert_after_or_before'        => get_post_meta( $_iPostID, 'insert_after_or_before', true ),
            );
            
        }

        return $_aPostMetas;
        
    }
        
        /**
         * Returns a sanitized value by the given meta key.
         * 
         * Used for meta values that are arrays but should return a non-array value.
         * 
         * This is used for fields of revealer field types with the checkbox selct type that stores the value as an array.
         * 
         * @since   0.0.2
         */
        private function _getMetaValue( $iPostID, $sMetaKey ) {
            
            switch( $sMetaKey ) {
                
                case 'reload_after_upload':
                
                    $_abValue = get_post_meta( $iPostID, 'reload_after_upload', true );
                    if ( isset( $_abValue['.reload_after_upload_row'] ) ) {
                        return $_abValue['.reload_after_upload_row'] ? true : false;
                    } 
                    
                    // for backward compatibility
                    return $_abValue;
                    
                break;
                case 'enable_media_library':
                    
                    $_bsValue = get_post_meta( $iPostID, 'enable_media_library', true );
                    if ( in_array( $_bsValue, array( '.enable_media_library_options', 'undefined' ) ) ) {
                        return 'undefined' === $_bsValue
                            ? false 
                            : true;
                    }
                    
                    // for backward compatibility
                    return $_bsValue;
// AdminPageFramework_Debug::log( $_bsValue );
                    // return $_bsValue;
                case 'insert_method':
                    $_sSelector = get_post_meta( $iPostID, 'insert_method', true );
                    return '.insert_method_insert' === $_sSelector
                        ? 'insert'      // return this item only if it matches the value. No value is set for example rules. So in that case, 'replace' should be returned.
                        : 'replace';    // default
                    
                
            }
            
        }
        
        /**
         * Checks if the post(rule) of the given post ID can be applied to the currently loading page.
         * 
         * @since   0.0.1
         * @return  boolean whether the post(rule) matches the currently loaded page.
         */
        private function _checkQueryKeyValues( $aURLQueries ) {
            
            if ( ! is_array( $aURLQueries ) ) {
                return false;
            }
                        
            foreach( $aURLQueries as $_iIndex => $_aKeyValue ) {
                
                $_sKey      = ( string ) isset( $_aKeyValue[ 'key' ] ) ? $_aKeyValue[ 'key' ]  : '';
                $_sValue    = ( string ) isset( $_aKeyValue[ 'value' ] ) ? $_aKeyValue[ 'value' ]  : '';
                $_sGETKey   = isset( $_GET[ $_sKey ] ) ? $_GET[ $_sKey ] : '';
                
                if ( $_sValue === $_sGETKey ) {
                    return true;
                }
                
            }
            return false;
            
        }
    
}