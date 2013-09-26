// Filename: collections/albums
define([
    'underscore',
    'backbone',
    'models/album',
    'lib/backbone.hal'
], function(_, Backbone, AlbumModel, HAL){
    var AlbumCollection = HAL.Collection.extend({
        model: AlbumModel,
        itemRel: 'albums',
        url: '/albums'
    });
    // You don't usually return a collection instantiated
    return AlbumCollection;
});
