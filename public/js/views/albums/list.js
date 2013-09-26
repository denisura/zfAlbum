// Filename: views/albums/list
define([
    'jquery',
    'underscore',
    'backbone',
    'collections/albums',
    // Using the Require.js text! plugin, we are loaded raw text
    // which will be used as our views primary template
    'text!templates/albums/list.html',
    'helpers/view',
], function ($, _, Backbone, AlbumsCollection, albumListTemplate, viewHelpers) {

    var AlbumListView = Backbone.View.extend({
        el: $('.page'),
        render: function () {
            this.collection = new AlbumsCollection();
            var that = this;
            this.collection.fetch({
                success: function (albums) {
                    that.undelegateEvents();
                    var data = {albums: albums.models};
                    _.extend(data, viewHelpers);
                    var template = _.template(albumListTemplate, data);
                    that.$el.html(template);
                }
            });
        }
    });
    // Our module now returns our view
    return AlbumListView;
});
