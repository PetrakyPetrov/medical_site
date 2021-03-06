/*! rangeslider.js - v0.3.1 | (c) 2014 @andreruffert | MIT license | https://github.com/andreruffert/rangeslider.js */

'use strict';
(function(factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory)
    } else if (typeof exports === 'object') {
        factory(require('jquery'))
    } else {
        factory(jQuery)
    }
}(function(jQuery) {
    function supportsRange() {
        var input = document.createElement('input');
        input.setAttribute('type', 'range');
        return input.type !== 'text'
    }
    var pluginName = 'rangeslider',
        pluginInstances = [],
        inputrange = supportsRange(),
        defaults = {
            polyfill: true,
            rangeClass: 'rangeslider',
            disabledClass: 'rangeslider--disabled',
            fillClass: 'rangeslider__fill',
            handleClass: 'rangeslider__handle',
            startEvent: ['mousedown', 'touchstart', 'pointerdown'],
            moveEvent: ['mousemove', 'touchmove', 'pointermove'],
            endEvent: ['mouseup', 'touchend', 'pointerup']
        };

    function delay(fn, wait) {
        var args = Array.prototype.slice.call(arguments, 2);
        return setTimeout(function() {
            return fn.apply(null, args)
        }, wait)
    }

    function debounce(fn, debounceDuration) {
        debounceDuration = debounceDuration || 100;
        return function() {
            if (!fn.debouncing) {
                var args = Array.prototype.slice.apply(arguments);
                fn.lastReturnVal = fn.apply(window, args);
                fn.debouncing = true
            }
            clearTimeout(fn.debounceTimeout);
            fn.debounceTimeout = setTimeout(function() {
                fn.debouncing = false
            }, debounceDuration);
            return fn.lastReturnVal
        }
    }

    function Plugin(element, options) {
        this.$window = jQuery(window);
        this.$document = jQuery(document);
        this.$element = jQuery(element);
        this.options = jQuery.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.startEvent = this.options.startEvent.join('.' + pluginName + ' ') + '.' + pluginName;
        this.moveEvent = this.options.moveEvent.join('.' + pluginName + ' ') + '.' + pluginName;
        this.endEvent = this.options.endEvent.join('.' + pluginName + ' ') + '.' + pluginName;
        this.polyfill = this.options.polyfill;
        this.onInit = this.options.onInit;
        this.onSlide = this.options.onSlide;
        this.onSlideEnd = this.options.onSlideEnd;
        if (this.polyfill) {
            if (inputrange) {
                return false
            }
        }
        this.identifier = 'js-' + pluginName + '-' + (+new Date());
        this.min = parseFloat(this.$element[0].getAttribute('min') || 0);
        this.max = parseFloat(this.$element[0].getAttribute('max') || 100);
        this.value = parseFloat(this.$element[0].value || this.min + (this.max - this.min) / 2);
        this.step = parseFloat(this.$element[0].getAttribute('step') || 1);
        this.$fill = jQuery('<div class="' + this.options.fillClass + '" />');
        this.$handle = jQuery('<div class="' + this.options.handleClass + '" />');
        this.$range = jQuery('<div class="' + this.options.rangeClass + '" id="' + this.identifier + '" />')
            .insertAfter(this.$element)
            .prepend(this.$fill, this.$handle);
        this.$element.css({
            'position': 'absolute',
            'width': '1px',
            'height': '1px',
            'overflow': 'hidden',
            'opacity': '0'
        });
        this.handleDown = jQuery.proxy(this.handleDown, this);
        this.handleMove = jQuery.proxy(this.handleMove, this);
        this.handleEnd = jQuery.proxy(this.handleEnd, this);
        this.init();
        var _this = this;
        this.$window.on('resize' + '.' + pluginName, debounce(function() {
            delay(function() {
                _this.update()
            }, 300)
        }, 20));
        this.$document.on(this.startEvent, '#' + this.identifier + ':not(.' + this.options.disabledClass + ')', this.handleDown);
        this.$element.on('change' + '.' + pluginName, function(e, data) {
            if (data && data.origin === pluginName) {
                return
            }
            var value = e.target.value,
                pos = _this.getPositionFromValue(value);
            _this.setPosition(pos)
        })
    }
    Plugin.prototype.init = function() {
        if (this.onInit && typeof this.onInit === 'function') {
            this.onInit()
        }
        this.update()
    };
    Plugin.prototype.update = function() {
        this.handleWidth = this.$handle[0].offsetWidth;
        this.rangeWidth = this.$range[0].offsetWidth;
        this.maxHandleX = this.rangeWidth - this.handleWidth;
        this.grabX = this.handleWidth / 2;
        this.position = this.getPositionFromValue(this.value);
        if (this.$element[0].disabled) {
            this.$range.addClass(this.options.disabledClass)
        } else {
            this.$range.removeClass(this.options.disabledClass)
        }
        this.setPosition(this.position)
    };
    Plugin.prototype.handleDown = function(e) {
        e.preventDefault();
        this.$document.on(this.moveEvent, this.handleMove);
        this.$document.on(this.endEvent, this.handleEnd);
        if ((' ' + e.target.className + ' ')
            .replace(/[\n\t]/g, ' ')
            .indexOf(this.options.handleClass) > -1) {
            return
        }
        var posX = this.getRelativePosition(this.$range[0], e),
            handleX = this.getPositionFromNode(this.$handle[0]) - this.getPositionFromNode(this.$range[0]);
        this.setPosition(posX - this.grabX);
        if (posX >= handleX && posX < handleX + this.handleWidth) {
            this.grabX = posX - handleX
        }
    };
    Plugin.prototype.handleMove = function(e) {
        e.preventDefault();
        var posX = this.getRelativePosition(this.$range[0], e);
        this.setPosition(posX - this.grabX)
    };
    Plugin.prototype.handleEnd = function(e) {
        e.preventDefault();
        this.$document.off(this.moveEvent, this.handleMove);
        this.$document.off(this.endEvent, this.handleEnd);
        var posX = this.getRelativePosition(this.$range[0], e);
        if (this.onSlideEnd && typeof this.onSlideEnd === 'function') {
            this.onSlideEnd(posX - this.grabX, this.value)
        }
    };
    Plugin.prototype.cap = function(pos, min, max) {
        if (pos < min) {
            return min
        }
        if (pos > max) {
            return max
        }
        return pos
    };
    Plugin.prototype.setPosition = function(pos) {
        var value, left;
        value = (this.getValueFromPosition(this.cap(pos, 0, this.maxHandleX)) / this.step) * this.step;
        left = this.getPositionFromValue(value);
        this.$fill[0].style.width = (left + this.grabX) + 'px';
        this.$handle[0].style.left = left + 'px';
        this.setValue(value);
        this.position = left;
        this.value = value;
        if (this.onSlide && typeof this.onSlide === 'function') {
            this.onSlide(left, value)
        }
    };
    Plugin.prototype.getPositionFromNode = function(node) {
        var i = 0;
        while (node !== null) {
            i += node.offsetLeft;
            node = node.offsetParent
        }
        return i
    };
    Plugin.prototype.getRelativePosition = function(node, e) {
        return (e.pageX || e.originalEvent.clientX || e.originalEvent.touches[0].clientX || e.currentPoint.x) - this.getPositionFromNode(node)
    };
    Plugin.prototype.getPositionFromValue = function(value) {
        var percentage, pos;
        percentage = (value - this.min) / (this.max - this.min);
        pos = percentage * this.maxHandleX;
        return pos
    };
    Plugin.prototype.getValueFromPosition = function(pos) {
        var percentage, value;
        percentage = ((pos) / (this.maxHandleX || 1));
        value = this.step * Math.ceil((((percentage) * (this.max - this.min)) + this.min) / this.step);
        return Number((value)
            .toFixed(2))
    };
    Plugin.prototype.setValue = function(value) {
        if (value !== this.value) {
            this.$element.val(value)
                .trigger('change', {
                    origin: pluginName
                })
        }
    };
    Plugin.prototype.destroy = function() {
        this.$document.off(this.startEvent, '#' + this.identifier, this.handleDown);
        this.$element.off('.' + pluginName)
            .removeAttr('style')
            .removeData('plugin_' + pluginName);
        if (this.$range && this.$range.length) {
            this.$range[0].parentNode.removeChild(this.$range[0])
        }
        pluginInstances.splice(pluginInstances.indexOf(this.$element[0]), 1);
        if (!pluginInstances.length) {
            this.$window.off('.' + pluginName)
        }
    };
    jQuery.fn[pluginName] = function(options) {
        return this.each(function() {
            var $this = jQuery(this),
                data = $this.data('plugin_' + pluginName);
            if (!data) {
                $this.data('plugin_' + pluginName, (data = new Plugin(this, options)));
                pluginInstances.push(this)
            }
            if (typeof options === 'string') {
                data[options]()
            }
        })
    }
}));

/*! jQuery UI Touch Punch 0.2.3 | Copyright 2011a��2014, Dave Furfero | Dual licensed under the MIT or GPL Version 2 licenses. */
(function(jQuery) {
    jQuery.support.touch = 'ontouchend' in document;
    if (!jQuery.support.touch) {
        return
    }
    var mouseProto = jQuery.ui.mouse.prototype,
        _mouseInit = mouseProto._mouseInit,
        _mouseDestroy = mouseProto._mouseDestroy,
        touchHandled;

    function simulateMouseEvent(event, simulatedType) {
        if (event.originalEvent.touches.length > 1) {
            return
        }
        event.preventDefault();
        var touch = event.originalEvent.changedTouches[0],
            simulatedEvent = document.createEvent('MouseEvents');
        simulatedEvent.initMouseEvent(simulatedType, true, true, window, 1, touch.screenX, touch.screenY, touch.clientX, touch.clientY, false, false, false, false, 0, null);
        event.target.dispatchEvent(simulatedEvent)
    }
    mouseProto._touchStart = function(event) {
        var self = this;
        if (touchHandled || !self._mouseCapture(event.originalEvent.changedTouches[0])) {
            return
        }
        touchHandled = true;
        self._touchMoved = false;
        simulateMouseEvent(event, 'mouseover');
        simulateMouseEvent(event, 'mousemove');
        simulateMouseEvent(event, 'mousedown')
    };
    mouseProto._touchMove = function(event) {
        if (!touchHandled) {
            return
        }
        this._touchMoved = true;
        simulateMouseEvent(event, 'mousemove')
    };
    mouseProto._touchEnd = function(event) {
        if (!touchHandled) {
            return
        }
        simulateMouseEvent(event, 'mouseup');
        simulateMouseEvent(event, 'mouseout');
        if (!this._touchMoved) {
            simulateMouseEvent(event, 'click')
        }
        touchHandled = false
    };
    mouseProto._mouseInit = function() {
        var self = this;
        self.element.bind({
            touchstart: jQuery.proxy(self, '_touchStart'),
            touchmove: jQuery.proxy(self, '_touchMove'),
            touchend: jQuery.proxy(self, '_touchEnd')
        });
        _mouseInit.call(self)
    };
    mouseProto._mouseDestroy = function() {
        var self = this;
        self.element.unbind({
            touchstart: jQuery.proxy(self, '_touchStart'),
            touchmove: jQuery.proxy(self, '_touchMove'),
            touchend: jQuery.proxy(self, '_touchEnd')
        });
        _mouseDestroy.call(self)
    }
})(jQuery);




