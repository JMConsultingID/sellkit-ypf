(function( $ ) {
document.addEventListener('DOMContentLoaded', function() {
    var cssEditor = document.querySelector('textarea[name="sellkit_ypf_custom_css"]');
    if (cssEditor && wp.codeEditor) {
        wp.codeEditor.initialize(cssEditor, {type: 'text/css'});
    }
    var jsEditor = document.querySelector('textarea[name="sellkit_ypf_custom_js"]');
    if (jsEditor && wp.codeEditor) {
        wp.codeEditor.initialize(jsEditor, {type: 'text/javascript'});
    }
});
})( jQuery );