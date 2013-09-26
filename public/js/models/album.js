// Filename: models/album
define([
    'lib/backbone.hal'
], function(HAL){
    var AlbumModel = HAL.Model.extend({
       urlRoot: '/albums'
    });
    // Return the model for the module
    return AlbumModel;
});
