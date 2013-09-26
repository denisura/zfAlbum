// Filename: main.js

// Require.js allows us to configure shortcut alias
// There usage will become more apparent further along in the tutorial.
require.config({
    paths: {
        jquery: '//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min',
        underscore: '//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.1/underscore-min',
        backbone: '//cdnjs.cloudflare.com/ajax/libs/backbone.js/1.0.0/backbone-min',
        text: '//cdnjs.cloudflare.com/ajax/libs/require-text/2.0.10/text',
        templates: '../templates'
    },
    shim: {
        'backbone': {
            //These script dependencies should be loaded before loading
            //backbone.js
            deps: ['underscore', 'jquery'],
            //Once loaded, use the global 'Backbone' as the
            //module value.
            exports: 'Backbone'
        },
        'underscore': {
            exports: '_'
        }
    }
});
require([
    // Load our app module and pass it to our definition function
    'app',
], function(App){
    // The "app" dependency is passed in as "App"
    App.initialize();
});
