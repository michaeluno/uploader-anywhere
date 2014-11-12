/**
 * Replaces the target element with an uploader modal window link.
 * 
 * @since   0.0.1
 */
( function( $ ) {
	$( document ).ready(function() {
        
        // Parse each rule.
        $.each( uploader_anywhere_rules, function( iPostID, aOptions ) {
            
            // For debugging.
            // console.log( iPostID + ": " );
            // console.log( 'selector: ' + aOptions['selector'] );
            // console.log( 'found: ' +  $( aOptions['selector'] ).length );

            // Bind the uploader event.            
            if ( aOptions['nth_item'] ) {
                    
                if ( undefined !== $( aOptions['selector'] )[ aOptions['nth_item'] - 1 ] ) {
                    var _oTarget = $( aOptions['selector'] )[ aOptions['nth_item'] - 1 ];
                    $( _oTarget ).setUploaderAnywhereUploader( aOptions );
                }
                                
            } else {
                $( aOptions['selector'] )
                    .setUploaderAnywhereUploader( aOptions );
            }
            
        });

	});
})(jQuery);
