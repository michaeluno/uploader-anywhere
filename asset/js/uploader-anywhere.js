/*
 * jQuery Plugin: binds the media uploader modal window opening function with a click event.
 
 */
( function ( $ ) {
	$.fn.setUploaderAnywhereUploader = function( aOptions ) {
        
        /**
         * Indicates whether the modal window is still open.
         */        
        var _bIsOpen = false;

        /**
         * Indicates whether a file has been uploaded or not.
         */
        var _bUploaded = false;
        
        /**
         * Stores the media uploader object to be reused if it has been created before.
         */
        var _oMediaUploader;        
        
        /**
         * Stores the settings.
         */
        var aOptions    = jQuery.extend( 
            {}, 
            { 
                selector:                   '',
                nth_item:                   1,
                is_multiple:                true,
                support_external:           false,
                label_window_title:         'Upload Files',
                label_button_use_this:      'Use This',
                file_type_filters:          '',
                enable_media_library:       false,
                reload_after_upload:        true,
                redirect_url_after_upload:  '',
                insert_method:              'replace',   // or 'insert'
                inserting_html_element:     '',
                insert_after_or_before:     'after'      // or 'before'
            },
            aOptions
        );      
        aOptions['is_multiple'] = '0' === aOptions['is_multiple'] || '' === aOptions['is_multiple'] 
            ? false 
            : aOptions['is_multiple'];        
        aOptions['enable_media_library'] = '0' === aOptions['enable_media_library'] || '' === aOptions['enable_media_library'] 
            ? false 
            : aOptions['enable_media_library'];                
        aOptions['reload_after_upload'] = '0' === aOptions['reload_after_upload'] || '' === aOptions['reload_after_upload'] 
            ? false 
            : aOptions['reload_after_upload'];                            
        aOptions['label_window_title'] = '' === aOptions['label_window_title'] 
            ? 'Upload Files' 
            : aOptions['label_window_title'];
        aOptions['label_button_use_this'] = '' === aOptions['label_button_use_this'] 
            ? 'Use This' 
            : aOptions['label_button_use_this'];     
            
        // For Debugging        
        console.log( aOptions );

        // We have either 'insert' or 'replace' at the moment.
        if ( 'insert' === aOptions['insert_method'] ) {
            
            var _oUploaderLink = $( aOptions['inserting_html_element'] );
            var _oTaretElement = this;
            _oTaretElement[ aOptions['insert_after_or_before'] ]( _oUploaderLink );
                    
        } else {
            var _oUploaderLink = this;
        }
            
        $( _oUploaderLink ).on( 'click', function( e ) {
            
            window.wpActiveEditor = null;     
            e.preventDefault();
            
            // If the uploader object has already been created, reopen the dialog
            if ( 'object' === typeof _oMediaUploader ) {
                _oMediaUploader.open();
                return;
            }     
            
            // Store the original select object and a default setting in a global variable
            goUploaderAnywhereOriginalMediaUploader = wp.media.view.MediaFrame.Select;
            gbContentUserSetting = wp.media.controller.Library.prototype.defaults.contentUserSetting;       

            wp.media.controller.Library.prototype.defaults.contentUserSetting = false;                      
            _oMediaUploader = wp.media({
                title:      _.unescape( aOptions['label_window_title'] ),
                button:     {
                    text: aOptions['label_button_use_this']
                },
                multiple:   aOptions['is_multiple'] ? true : false, // Set this to true to allow multiple files to be selected
                library: {
                    type: aOptions['file_type_filters']
                },
                metadata:   {}
            });

            // When the uploader window closes
            _oMediaUploader.on( 'close', function() {
                _bIsOpen = false;
                restoreMediaWindow();
                
                // If the user uploaded a file and close the window, reload the page. 
                if ( _bUploaded && aOptions['reload_after_upload'] ) {
                    if ( aOptions['redirect_url_after_upload'] ) {
                        window.location = aOptions['redirect_url_after_upload'];
                    } else {
                        location.reload();               
                    }
                }
            });

            // When the uploader window closes by escaping, 
            // _oMediaUploader.on( 'escape', function() {
            // return false;
            // });            
            // When a file is selected, do something
            // _oMediaUploader.on( 'select', function() {         
                // console.log( 'selected' );
            // });            

            if ( typeof wp.Uploader !== 'undefined' && 'undefined' !== typeof wp.Uploader.queue ) {
                wp.Uploader.queue.on( 'reset', function() { 
                
                    // This can be triggered by media uploaders not of this plugin. 
                    // So set the flag that is specific to this plugin's uploader modal window' state.
                    if ( ! _bIsOpen ) {
                        return;
                    }
                    
                    _bUploaded = true;
                    
                });            
            }
            
            
            // Open the uploader dialog
            _bIsOpen = true;
            _oMediaUploader.open();     
             
            // If the Media Tab is not enabled hide them.
            if ( ! aOptions['enable_media_library'] ) {
                $( '.media-modal-content .media-frame-router .media-menu-item:not(.active)' ).hide();
                $( '.media-modal-content .media-frame-toolbar' ).hide();
            }
            
            return false; // do not let it click.
            
        } );
        
        
        function restoreMediaWindow()  {
            
            // Restore the original select object.
            wp.media.view.MediaFrame.Select = goUploaderAnywhereOriginalMediaUploader;
            wp.media.controller.Library.prototype.defaults.contentUserSetting = gbContentUserSetting;            
    
        }
        
	};		
           
    
}( jQuery ) );
