// Filename: router.js
define([
    'jquery',
    'underscore',
    'backbone',
    'views/albums/list',
    'views/albums/edit',
    'views/albums/delete',
    'views/albums/view',

], function($, _, Backbone, AlbumListView, EditAlbumView, DeleteAlbumView, ViewAlbumView){

    var Router = Backbone.Router.extend({
        routes:{
            '': 'home',
           'new': 'editAlbum',
           'edit/:id': 'editAlbum',
           'delete/:id': 'deleteAlbum',
           'view/:id': 'viewAlbum',
             // Default
            '*actions': 'defaultAction'
        }
    });

    var initialize = function(){
        $.ajaxPrefilter(function (options, originalOptions, jqXHR) {

            options.crossDomain=true;

            if (options.url.indexOf('http') !== 0){
                options.url = 'http://localhost:4080/v1' + options.url;
            }
            console.log(JSON.stringify(options));
        });

        $.fn.serializeObject = function () {
            var o = {};
            var a = this.serializeArray();
            $.each(a, function () {
                if (o[this.name] !== undefined) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        };

        var router = new Router();
        router.on('route:home',function(){
            // Call render on the module we loaded in via the dependency array
            // 'views/album/list'
            var albumListView = new AlbumListView();
            albumListView.render();
        });
        router.on('route:editAlbum',function(id){
            // Call render on the module we loaded in via the dependency array
            // 'views/album/list'
            var editAlbumView = new EditAlbumView();
            editAlbumView.render({id: id});
        });
        router.on('route:deleteAlbum',function(id){
            // Call render on the module we loaded in via the dependency array
            // 'views/album/list'
            var deleteAlbumView = new DeleteAlbumView();
            deleteAlbumView.render({id: id});
        });
        router.on('route:viewAlbum',function(id){
            // Call render on the module we loaded in via the dependency array
            // 'views/album/list'
            var viewAlbumView = new ViewAlbumView();
            viewAlbumView.render({id: id});
        });

        router.on('defaultAction', function(actions){
            // We have no matching route, lets just log what the URL was
            console.log('No route:', actions);
        });
        Backbone.history.start();
    };
    return {
        initialize: initialize
    };
});
