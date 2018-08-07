/**
 * gridstack.js 0.3.0
 * http://troolee.github.io/gridstack.js/
 * (c) 2014-2016 Pavel Reznikov, Dylan Weiss
 * gridstack.js may be freely distributed under the MIT license.
 * @preserve
*/
(function(factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery', 'lodash', 'gridstack', 'jquery-ui/ui/data', 'jquery-ui/ui/disable-selection', 'jquery-ui/ui/focusable',
            'jquery-ui/ui/form', 'jquery-ui/ui/ie', 'jquery-ui/ui/keycode', 'jquery-ui/ui/labels', 'jquery-ui/ui/jquery-1-7',
            'jquery-ui/ui/plugin', 'jquery-ui/ui/safe-active-element', 'jquery-ui/ui/safe-blur', 'jquery-ui/ui/scroll-parent',
            'jquery-ui/ui/tabbable', 'jquery-ui/ui/unique-id', 'jquery-ui/ui/version', 'jquery-ui/ui/widget',
            'jquery-ui/ui/widgets/mouse', 'jquery-ui/ui/widgets/draggable', 'jquery-ui/ui/widgets/droppable',
            'jquery-ui/ui/widgets/resizable'], factory);
    } else if (typeof exports !== 'undefined') {
        try { jQuery = require('jquery'); } catch (e) {}
        try { _ = require('lodash'); } catch (e) {}
        try { GridStackUI = require('gridstack'); } catch (e) {}
        factory(jQuery, _, GridStackUI);
    } else {
        factory(jQuery, _, GridStackUI);
    }
})(function($, _, GridStackUI) {

    var scope = window;

    /**
    * @class JQueryUIGridStackDragDropPlugin
    * jQuery UI implementation of drag'n'drop gridstack plugin.
    */
    function JQueryUIGridStackDragDropPlugin(grid) {
        GridStackUI.GridStackDragDropPlugin.call(this, grid);
    }

    GridStackUI.GridStackDragDropPlugin.registerPlugin(JQueryUIGridStackDragDropPlugin);

    JQueryUIGridStackDragDropPlugin.prototype = Object.create(GridStackUI.GridStackDragDropPlugin.prototype);
    JQueryUIGridStackDragDropPlugin.prototype.constructor = JQueryUIGridStackDragDropPlugin;

    JQueryUIGridStackDragDropPlugin.prototype.resizable = function(el, opts) {
        el = $(el);
        if (opts === 'disable' || opts === 'enable') {
            el.resizable(opts);
        } else if (opts === 'option') {
            var key = arguments[2];
            var value = arguments[3];
            el.resizable(opts, key, value);
        } else {
            el.resizable(_.extend({}, this.grid.opts.resizable, {
                start: opts.start || function() {},
                stop: opts.stop || function() {},
                resize: opts.resize || function() {}
            }));
        }
        return this;
    };

    JQueryUIGridStackDragDropPlugin.prototype.draggable = function(el, opts) {
        el = $(el);
        if (opts === 'disable' || opts === 'enable') {
            el.draggable(opts);
        } else {
            el.draggable(_.extend({}, this.grid.opts.draggable, {
                containment: this.grid.opts.isNested ? this.grid.container.parent() : null,
                start: opts.start || function() {},
                stop: opts.stop || function() {},
                drag: opts.drag || function() {}
            }));
        }
        return this;
    };

    JQueryUIGridStackDragDropPlugin.prototype.droppable = function(el, opts) {
        el = $(el);
        if (opts === 'disable' || opts === 'enable') {
            el.droppable(opts);
        } else {
            el.droppable({
                accept: opts.accept
            });
        }
        return this;
    };

    JQueryUIGridStackDragDropPlugin.prototype.isDroppable = function(el, opts) {
        el = $(el);
        return Boolean(el.data('droppable'));
    };

    JQueryUIGridStackDragDropPlugin.prototype.on = function(el, eventName, callback) {
        $(el).on(eventName, callback);
        return this;
    };

    return JQueryUIGridStackDragDropPlugin;
});
