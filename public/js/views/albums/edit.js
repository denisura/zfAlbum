// Filename: views/albums/list
define([
    'jquery',
    'underscore',
    'backbone',
    'models/album',
    // Using the Require.js text! plugin, we are loaded raw text
    // which will be used as our views primary template
    'text!templates/albums/edit.html',
    'helpers/view',
], function ($, _, Backbone, AlbumModel, albumEditTemplate, viewHelpers) {

    var EditAlbum = Backbone.View.extend({
        el: $('.page'),
        render: function (options) {
            var that = this;
            if (options.id) {
                that.album = new AlbumModel({id: options.id});
                that.album.fetch({
                    success: function (album) {
                        var data = {album: album };
                        _.extend(data, viewHelpers);
                        var template = _.template(albumEditTemplate, data);
                        that.$el.html(template);
                    }
                });
            } else {
                var data = {album: null };
                _.extend(data, viewHelpers);
                var template = _.template(albumEditTemplate, data);
                this.$el.html(template);
            }
        },
        events: {
            'submit .edit-album-form': 'saveAlbum'
        },
        saveAlbum: function (ev) {
            var that = this;
            var albumDetails = $(ev.currentTarget).serializeObject();
            var album = new AlbumModel();
            album.save(albumDetails, {
                success: function (album) {
                    that.undelegateEvents();
                    Backbone.history.navigate('', true);
                }
            });
            return false;
        }
    });
    // Our module now returns our view
    return EditAlbum;
});
