// Filename: views/albums/list
define([
    'jquery',
    'underscore',
    'backbone',
    'models/album',
    // Using the Require.js text! plugin, we are loaded raw text
    // which will be used as our views primary template
    'text!templates/albums/delete.html',
    'helpers/view',
], function ($, _, Backbone, AlbumModel, albumDeleteTemplate, viewHelpers) {

    var DeleteAlbum = Backbone.View.extend({
        el: $('.page'),
        render: function (options) {
            var that = this;
            if (options.id) {
                that.album = new AlbumModel({id: options.id});
                that.album.fetch({
                    success: function (album) {
                        var data = {album: album };
                        _.extend(data, viewHelpers);
                        var template = _.template(albumDeleteTemplate, data);
                        that.$el.html(template);
                    }
                });
            } else {
                Backbone.history.navigate('', true);
            }
        },
        events: {
            'click .delete': 'deleteAlbum'
        },
        deleteAlbum: function (ev) {
            var that = this;
            this.album.destroy({
                success: function () {
                    that.undelegateEvents();
                    Backbone.history.navigate('', true);
                }
            });
            return false;
        }
    });
    // Our module now returns our view
    return DeleteAlbum;
});
