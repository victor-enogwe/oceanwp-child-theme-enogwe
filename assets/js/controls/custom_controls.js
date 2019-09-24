
function customControls (wp) {
    wp.customize.OceanWPCustomizerColorControl = wp.customize.ColorControl.extend({
        ready: function() {
            var control = this,
                radios = $( '.radios', this.container ),
                selection = $( '.selection', this.container );

            radios.hide();
            $( '.layout[data-value="' + control.setting.get() + '"]', selection ).addClass( 'selected' );

            $( '.layout .icon', selection ).on( 'click', function( event ) {
                event.preventDefault();

                var layout = $( this ).closest( '.layout' );
                if ( layout.hasClass( 'selected' ) ) return;

                var container = layout.closest( '.customize-control-layout' );
                $( '.selection .layout', container ).removeClass( 'selected' );

                layout.addClass( 'selected' );

                control.setting.set( layout.data( 'value' ) );
            } );
        }
    });
}

wp.customize.bind('ready', customControls.bind(null, wp))
