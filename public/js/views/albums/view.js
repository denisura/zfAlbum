// Filename: views/albums/list
define([
    'jquery',
    'underscore',
    'backbone',
    'models/album',
    // Using the Require.js text! plugin, we are loaded raw text
    // which will be used as our views primary template
    'text!templates/albums/view.html',
    'helpers/view',
], function ($, _, Backbone, AlbumModel, albumViewTemplate, viewHelpers) {

    var viewAlbum = Backbone.View.extend({
        el: $('.page'),
        render: function (options) {
            var that = this;
            that.album = new AlbumModel({id: options.id});
            that.album.fetch({
                success: function (album) {
                    that.undelegateEvents();
                    var data = {album: album };
                    _.extend(data, viewHelpers);
                    var template = _.template(albumViewTemplate, data);
                    that.$el.html(template);
                }
            });
        }
    });
    // Our module now returns our view
    return viewAlbum;
});
