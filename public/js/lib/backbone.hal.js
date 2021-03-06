//Filename: lib/backbone.hal.js
// Copyright (c) 2012 Mike Kelly, http://stateless.co/
// @see https://github.com/mikekelly/backbone.hal
define([
    // These are path alias that we configured in our bootstrap
    'jquery',     // lib/jquery/jquery
    'underscore', // lib/underscore/underscore
    'backbone'    // lib/backbone/backbone
], function ($, _, Backbone) {

    var __hasProp = {}.hasOwnProperty,
        __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor; child.__super__ = parent.prototype; return child; };

    var Collection, Model;
    Model = (function (_super) {

        __extends(Model, _super);

        Model.name = 'Model';

        function Model(attrs) {
            Model.__super__.constructor.call(this, this.parse(_.clone(attrs)));
        }

        Model.prototype.parse = function (attrs) {
            if (attrs == null) {
                attrs = {};
            }
            this.links = attrs._links || {};
            delete attrs._links;
            this.embedded = attrs._embedded || {};
            delete attrs._embedded;

            return attrs;
        };

        Model.prototype.url = function () {
            var _ref, _ref1;
            return ((_ref = this.links) != null ? (_ref1 = _ref.self) != null ? _ref1.href : void 0 : void 0)|| Model.__super__.url.call(this);
        };

        Model.prototype.isNew = function () {
            var _ref;
            if (typeof this.id === "undefined") {
                return true;
            }
            return  !((_ref = this.links) != null ? (typeof _ref.self !== "undefined") != null ? true : void 0 : void 0 );
        };

        return Model;

    })(Backbone.Model);

    Collection = (function (_super) {

        __extends(Collection, _super);

        Collection.name = 'Collection';

        function Collection(obj, options) {
            Collection.__super__.constructor.call(this, this.parse(_.clone(obj)), options);
        }

        Collection.prototype.parse = function (obj) {
            var items;
            if (obj == null) {
                obj = {};
            }
            this.links = obj._links || {};
            delete obj._links;
            this.embedded = obj._embedded || {};
            delete obj._embedded;
            this.attributes = obj || {};
            if (this.itemRel != null) {
                items = this.embedded[this.itemRel];
            } else {
                items = this.embedded.items;
            }
            return items;
        };

        Collection.prototype.reset = function (obj, options) {
            if (options == null) {
                options = {};
            }
            if (!_.isArray(obj)) {
                obj = this.parse(_.clone(obj));
            }
            options.parse = false;
            return Collection.__super__.reset.call(this, obj, options);
        };

        Collection.prototype.url = function () {
            var _ref, _ref1;
            return (_ref = this.links) != null ? (_ref1 = _ref.self) != null ? _ref1.href : void 0 : void 0;
        };

        return Collection;

    })(Backbone.Collection);
    return {
        Model: Model,
        Collection: Collection
    };
});
