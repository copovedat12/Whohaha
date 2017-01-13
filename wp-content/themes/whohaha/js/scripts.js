/*!
 * Infinite Ajax Scroll v2.2.1
 * A jQuery plugin for infinite scrolling
 * http://infiniteajaxscroll.com
 *
 * Commercial use requires one-time purchase of a commercial license
 * http://infiniteajaxscroll.com/docs/license.html
 *
 * Non-commercial use is licensed under the MIT License
 *
 * Copyright (c) 2015 Webcreate (Jeroen Fiege)
 */
var IASCallbacks=function(){return this.list=[],this.fireStack=[],this.isFiring=!1,this.isDisabled=!1,this.fire=function(a){var b=a[0],c=a[1],d=a[2];this.isFiring=!0;for(var e=0,f=this.list.length;f>e;e++)if(void 0!=this.list[e]&&!1===this.list[e].fn.apply(b,d)){c.reject();break}this.isFiring=!1,c.resolve(),this.fireStack.length&&this.fire(this.fireStack.shift())},this.inList=function(a,b){b=b||0;for(var c=b,d=this.list.length;d>c;c++)if(this.list[c].fn===a||a.guid&&this.list[c].fn.guid&&a.guid===this.list[c].fn.guid)return c;return-1},this};IASCallbacks.prototype={add:function(a,b){var c={fn:a,priority:b};b=b||0;for(var d=0,e=this.list.length;e>d;d++)if(b>this.list[d].priority)return this.list.splice(d,0,c),this;return this.list.push(c),this},remove:function(a){for(var b=0;(b=this.inList(a,b))>-1;)this.list.splice(b,1);return this},has:function(a){return this.inList(a)>-1},fireWith:function(a,b){var c=jQuery.Deferred();return this.isDisabled?c.reject():(b=b||[],b=[a,c,b.slice?b.slice():b],this.isFiring?this.fireStack.push(b):this.fire(b),c)},disable:function(){this.isDisabled=!0},enable:function(){this.isDisabled=!1}},function(a){"use strict";var b=-1,c=function(c,d){return this.itemsContainerSelector=d.container,this.itemSelector=d.item,this.nextSelector=d.next,this.paginationSelector=d.pagination,this.$scrollContainer=c,this.$container=window===c.get(0)?a(document):c,this.defaultDelay=d.delay,this.negativeMargin=d.negativeMargin,this.nextUrl=null,this.isBound=!1,this.isPaused=!1,this.isInitialized=!1,this.listeners={next:new IASCallbacks,load:new IASCallbacks,loaded:new IASCallbacks,render:new IASCallbacks,rendered:new IASCallbacks,scroll:new IASCallbacks,noneLeft:new IASCallbacks,ready:new IASCallbacks},this.extensions=[],this.scrollHandler=function(){if(this.isBound&&!this.isPaused){var a=this.getCurrentScrollOffset(this.$scrollContainer),c=this.getScrollThreshold();b!=c&&(this.fire("scroll",[a,c]),a>=c&&this.next())}},this.getItemsContainer=function(){return a(this.itemsContainerSelector)},this.getLastItem=function(){return a(this.itemSelector,this.getItemsContainer().get(0)).last()},this.getFirstItem=function(){return a(this.itemSelector,this.getItemsContainer().get(0)).first()},this.getScrollThreshold=function(a){var c;return a=a||this.negativeMargin,a=a>=0?-1*a:a,c=this.getLastItem(),0===c.length?b:c.offset().top+c.height()+a},this.getCurrentScrollOffset=function(a){var b=0,c=a.height();return b=window===a.get(0)?a.scrollTop():a.offset().top,(-1!=navigator.platform.indexOf("iPhone")||-1!=navigator.platform.indexOf("iPod"))&&(c+=80),b+c},this.getNextUrl=function(b){return b=b||this.$container,a(this.nextSelector,b).last().attr("href")},this.load=function(b,c,d){var e,f,g=this,h=[],i=+new Date;d=d||this.defaultDelay;var j={url:b};return g.fire("load",[j]),a.get(j.url,null,a.proxy(function(b){e=a(this.itemsContainerSelector,b).eq(0),0===e.length&&(e=a(b).filter(this.itemsContainerSelector).eq(0)),e&&e.find(this.itemSelector).each(function(){h.push(this)}),g.fire("loaded",[b,h]),c&&(f=+new Date-i,d>f?setTimeout(function(){c.call(g,b,h)},d-f):c.call(g,b,h))},g),"html")},this.render=function(b,c){var d=this,e=this.getLastItem(),f=0,g=this.fire("render",[b]);g.done(function(){a(b).hide(),e.after(b),a(b).fadeIn(400,function(){++f<b.length||(d.fire("rendered",[b]),c&&c())})})},this.hidePagination=function(){this.paginationSelector&&a(this.paginationSelector,this.$container).hide()},this.restorePagination=function(){this.paginationSelector&&a(this.paginationSelector,this.$container).show()},this.throttle=function(b,c){var d,e,f=0;return d=function(){function a(){f=+new Date,b.apply(d,g)}var d=this,g=arguments,h=+new Date-f;e?clearTimeout(e):a(),h>c?a():e=setTimeout(a,c)},a.guid&&(d.guid=b.guid=b.guid||a.guid++),d},this.fire=function(a,b){return this.listeners[a].fireWith(this,b)},this.pause=function(){this.isPaused=!0},this.resume=function(){this.isPaused=!1},this};c.prototype.initialize=function(){if(this.isInitialized)return!1;var a=!!("onscroll"in this.$scrollContainer.get(0)),b=this.getCurrentScrollOffset(this.$scrollContainer),c=this.getScrollThreshold();return a?(this.hidePagination(),this.bind(),this.fire("ready"),this.nextUrl=this.getNextUrl(),b>=c?(this.next(),this.one("rendered",function(){this.isInitialized=!0})):this.isInitialized=!0,this):!1},c.prototype.reinitialize=function(){this.isInitialized=!1,this.unbind(),this.initialize()},c.prototype.bind=function(){if(!this.isBound){this.$scrollContainer.on("scroll",a.proxy(this.throttle(this.scrollHandler,150),this));for(var b=0,c=this.extensions.length;c>b;b++)this.extensions[b].bind(this);this.isBound=!0,this.resume()}},c.prototype.unbind=function(){if(this.isBound){this.$scrollContainer.off("scroll",this.scrollHandler);for(var a=0,b=this.extensions.length;b>a;a++)"undefined"!=typeof this.extensions[a].unbind&&this.extensions[a].unbind(this);this.isBound=!1}},c.prototype.destroy=function(){this.unbind(),this.$scrollContainer.data("ias",null)},c.prototype.on=function(b,c,d){if("undefined"==typeof this.listeners[b])throw new Error('There is no event called "'+b+'"');return d=d||0,this.listeners[b].add(a.proxy(c,this),d),this},c.prototype.one=function(a,b){var c=this,d=function(){c.off(a,b),c.off(a,d)};return this.on(a,b),this.on(a,d),this},c.prototype.off=function(a,b){if("undefined"==typeof this.listeners[a])throw new Error('There is no event called "'+a+'"');return this.listeners[a].remove(b),this},c.prototype.next=function(){var a=this.nextUrl,b=this;if(this.pause(),!a)return this.fire("noneLeft",[this.getLastItem()]),this.listeners.noneLeft.disable(),b.resume(),!1;var c=this.fire("next",[a]);return c.done(function(){b.load(a,function(a,c){b.render(c,function(){b.nextUrl=b.getNextUrl(a),b.resume()})})}),c.fail(function(){b.resume()}),!0},c.prototype.extension=function(a){if("undefined"==typeof a.bind)throw new Error('Extension doesn\'t have required method "bind"');return"undefined"!=typeof a.initialize&&a.initialize(this),this.extensions.push(a),this.isInitialized&&this.reinitialize(),this},a.ias=function(b){var c=a(window);return c.ias.apply(c,arguments)},a.fn.ias=function(b){var d=Array.prototype.slice.call(arguments),e=this;return this.each(function(){var f=a(this),g=f.data("ias"),h=a.extend({},a.fn.ias.defaults,f.data(),"object"==typeof b&&b);if(g||(f.data("ias",g=new c(f,h)),a(document).ready(a.proxy(g.initialize,g))),"string"==typeof b){if("function"!=typeof g[b])throw new Error('There is no method called "'+b+'"');d.shift(),g[b].apply(g,d)}e=g}),e},a.fn.ias.defaults={item:".item",container:".listing",next:".next",pagination:!1,delay:600,negativeMargin:10}}(jQuery);var IASHistoryExtension=function(a){return a=jQuery.extend({},this.defaults,a),this.ias=null,this.prevSelector=a.prev,this.prevUrl=null,this.listeners={prev:new IASCallbacks},this.onPageChange=function(a,b,c){if(window.history&&window.history.replaceState){var d=history.state;history.replaceState(d,document.title,c)}},this.onScroll=function(a,b){var c=this.getScrollThresholdFirstItem();this.prevUrl&&(a-=this.ias.$scrollContainer.height(),c>=a&&this.prev())},this.onReady=function(){var a=this.ias.getCurrentScrollOffset(this.ias.$scrollContainer),b=this.getScrollThresholdFirstItem();a-=this.ias.$scrollContainer.height(),b>=a&&this.prev()},this.getPrevUrl=function(a){return a||(a=this.ias.$container),jQuery(this.prevSelector,a).last().attr("href")},this.getScrollThresholdFirstItem=function(){var a;return a=this.ias.getFirstItem(),0===a.length?-1:a.offset().top},this.renderBefore=function(a,b){var c=this.ias,d=c.getFirstItem(),e=0;c.fire("render",[a]),jQuery(a).hide(),d.before(a),jQuery(a).fadeIn(400,function(){++e<a.length||(c.fire("rendered",[a]),b&&b())})},this};IASHistoryExtension.prototype.initialize=function(a){var b=this;this.ias=a,jQuery.extend(a.listeners,this.listeners),a.prev=function(){return b.prev()},this.prevUrl=this.getPrevUrl()},IASHistoryExtension.prototype.bind=function(a){a.on("pageChange",jQuery.proxy(this.onPageChange,this)),a.on("scroll",jQuery.proxy(this.onScroll,this)),a.on("ready",jQuery.proxy(this.onReady,this))},IASHistoryExtension.prototype.unbind=function(a){a.off("pageChange",this.onPageChange),a.off("scroll",this.onScroll),a.off("ready",this.onReady)},IASHistoryExtension.prototype.prev=function(){var a=this.prevUrl,b=this,c=this.ias;if(!a)return!1;c.pause();var d=c.fire("prev",[a]);return d.done(function(){c.load(a,function(a,d){b.renderBefore(d,function(){b.prevUrl=b.getPrevUrl(a),c.resume(),b.prevUrl&&b.prev()})})}),d.fail(function(){c.resume()}),!0},IASHistoryExtension.prototype.defaults={prev:".prev"};var IASNoneLeftExtension=function(a){return a=jQuery.extend({},this.defaults,a),this.ias=null,this.uid=(new Date).getTime(),this.html=a.html.replace("{text}",a.text),this.showNoneLeft=function(){var a=jQuery(this.html).attr("id","ias_noneleft_"+this.uid),b=this.ias.getLastItem();b.after(a),a.fadeIn()},this};IASNoneLeftExtension.prototype.bind=function(a){this.ias=a,a.on("noneLeft",jQuery.proxy(this.showNoneLeft,this))},IASNoneLeftExtension.prototype.unbind=function(a){a.off("noneLeft",this.showNoneLeft)},IASNoneLeftExtension.prototype.defaults={text:"You reached the end.",html:'<div class="ias-noneleft" style="text-align: center;">{text}</div>'};var IASPagingExtension=function(){return this.ias=null,this.pagebreaks=[[0,document.location.toString()]],this.lastPageNum=1,this.enabled=!0,this.listeners={pageChange:new IASCallbacks},this.onScroll=function(a,b){if(this.enabled){var c,d=this.ias,e=this.getCurrentPageNum(a),f=this.getCurrentPagebreak(a);this.lastPageNum!==e&&(c=f[1],d.fire("pageChange",[e,a,c])),this.lastPageNum=e}},this.onNext=function(a){var b=this.ias.getCurrentScrollOffset(this.ias.$scrollContainer);this.pagebreaks.push([b,a]);var c=this.getCurrentPageNum(b)+1;this.ias.fire("pageChange",[c,b,a]),this.lastPageNum=c},this.onPrev=function(a){var b=this,c=b.ias,d=c.getCurrentScrollOffset(c.$scrollContainer),e=d-c.$scrollContainer.height(),f=c.getFirstItem();this.enabled=!1,this.pagebreaks.unshift([0,a]),c.one("rendered",function(){for(var d=1,g=b.pagebreaks.length;g>d;d++)b.pagebreaks[d][0]=b.pagebreaks[d][0]+f.offset().top;var h=b.getCurrentPageNum(e)+1;c.fire("pageChange",[h,e,a]),b.lastPageNum=h,b.enabled=!0})},this};IASPagingExtension.prototype.initialize=function(a){this.ias=a,jQuery.extend(a.listeners,this.listeners)},IASPagingExtension.prototype.bind=function(a){try{a.on("prev",jQuery.proxy(this.onPrev,this),this.priority)}catch(b){}a.on("next",jQuery.proxy(this.onNext,this),this.priority),a.on("scroll",jQuery.proxy(this.onScroll,this),this.priority)},IASPagingExtension.prototype.unbind=function(a){try{a.off("prev",this.onPrev)}catch(b){}a.off("next",this.onNext),a.off("scroll",this.onScroll)},IASPagingExtension.prototype.getCurrentPageNum=function(a){for(var b=this.pagebreaks.length-1;b>0;b--)if(a>this.pagebreaks[b][0])return b+1;return 1},IASPagingExtension.prototype.getCurrentPagebreak=function(a){for(var b=this.pagebreaks.length-1;b>=0;b--)if(a>this.pagebreaks[b][0])return this.pagebreaks[b];return null},IASPagingExtension.prototype.priority=500;var IASSpinnerExtension=function(a){return a=jQuery.extend({},this.defaults,a),this.ias=null,this.uid=(new Date).getTime(),this.src=a.src,this.html=a.html.replace("{src}",this.src),this.showSpinner=function(){var a=this.getSpinner()||this.createSpinner(),b=this.ias.getLastItem();b.after(a),a.fadeIn()},this.showSpinnerBefore=function(){var a=this.getSpinner()||this.createSpinner(),b=this.ias.getFirstItem();b.before(a),a.fadeIn()},this.removeSpinner=function(){this.hasSpinner()&&this.getSpinner().remove()},this.getSpinner=function(){var a=jQuery("#ias_spinner_"+this.uid);return a.length>0?a:!1},this.hasSpinner=function(){var a=jQuery("#ias_spinner_"+this.uid);return a.length>0},this.createSpinner=function(){var a=jQuery(this.html).attr("id","ias_spinner_"+this.uid);return a.hide(),a},this};IASSpinnerExtension.prototype.bind=function(a){this.ias=a,a.on("next",jQuery.proxy(this.showSpinner,this)),a.on("render",jQuery.proxy(this.removeSpinner,this));try{a.on("prev",jQuery.proxy(this.showSpinnerBefore,this))}catch(b){}},IASSpinnerExtension.prototype.unbind=function(a){a.off("next",this.showSpinner),a.off("render",this.removeSpinner);try{a.off("prev",this.showSpinnerBefore)}catch(b){}},IASSpinnerExtension.prototype.defaults={src:"data:image/gif;base64,R0lGODlhEAAQAPQAAP///wAAAPDw8IqKiuDg4EZGRnp6egAAAFhYWCQkJKysrL6+vhQUFJycnAQEBDY2NmhoaAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAAFdyAgAgIJIeWoAkRCCMdBkKtIHIngyMKsErPBYbADpkSCwhDmQCBethRB6Vj4kFCkQPG4IlWDgrNRIwnO4UKBXDufzQvDMaoSDBgFb886MiQadgNABAokfCwzBA8LCg0Egl8jAggGAA1kBIA1BAYzlyILczULC2UhACH5BAkKAAAALAAAAAAQABAAAAV2ICACAmlAZTmOREEIyUEQjLKKxPHADhEvqxlgcGgkGI1DYSVAIAWMx+lwSKkICJ0QsHi9RgKBwnVTiRQQgwF4I4UFDQQEwi6/3YSGWRRmjhEETAJfIgMFCnAKM0KDV4EEEAQLiF18TAYNXDaSe3x6mjidN1s3IQAh+QQJCgAAACwAAAAAEAAQAAAFeCAgAgLZDGU5jgRECEUiCI+yioSDwDJyLKsXoHFQxBSHAoAAFBhqtMJg8DgQBgfrEsJAEAg4YhZIEiwgKtHiMBgtpg3wbUZXGO7kOb1MUKRFMysCChAoggJCIg0GC2aNe4gqQldfL4l/Ag1AXySJgn5LcoE3QXI3IQAh+QQJCgAAACwAAAAAEAAQAAAFdiAgAgLZNGU5joQhCEjxIssqEo8bC9BRjy9Ag7GILQ4QEoE0gBAEBcOpcBA0DoxSK/e8LRIHn+i1cK0IyKdg0VAoljYIg+GgnRrwVS/8IAkICyosBIQpBAMoKy9dImxPhS+GKkFrkX+TigtLlIyKXUF+NjagNiEAIfkECQoAAAAsAAAAABAAEAAABWwgIAICaRhlOY4EIgjH8R7LKhKHGwsMvb4AAy3WODBIBBKCsYA9TjuhDNDKEVSERezQEL0WrhXucRUQGuik7bFlngzqVW9LMl9XWvLdjFaJtDFqZ1cEZUB0dUgvL3dgP4WJZn4jkomWNpSTIyEAIfkECQoAAAAsAAAAABAAEAAABX4gIAICuSxlOY6CIgiD8RrEKgqGOwxwUrMlAoSwIzAGpJpgoSDAGifDY5kopBYDlEpAQBwevxfBtRIUGi8xwWkDNBCIwmC9Vq0aiQQDQuK+VgQPDXV9hCJjBwcFYU5pLwwHXQcMKSmNLQcIAExlbH8JBwttaX0ABAcNbWVbKyEAIfkECQoAAAAsAAAAABAAEAAABXkgIAICSRBlOY7CIghN8zbEKsKoIjdFzZaEgUBHKChMJtRwcWpAWoWnifm6ESAMhO8lQK0EEAV3rFopIBCEcGwDKAqPh4HUrY4ICHH1dSoTFgcHUiZjBhAJB2AHDykpKAwHAwdzf19KkASIPl9cDgcnDkdtNwiMJCshACH5BAkKAAAALAAAAAAQABAAAAV3ICACAkkQZTmOAiosiyAoxCq+KPxCNVsSMRgBsiClWrLTSWFoIQZHl6pleBh6suxKMIhlvzbAwkBWfFWrBQTxNLq2RG2yhSUkDs2b63AYDAoJXAcFRwADeAkJDX0AQCsEfAQMDAIPBz0rCgcxky0JRWE1AmwpKyEAIfkECQoAAAAsAAAAABAAEAAABXkgIAICKZzkqJ4nQZxLqZKv4NqNLKK2/Q4Ek4lFXChsg5ypJjs1II3gEDUSRInEGYAw6B6zM4JhrDAtEosVkLUtHA7RHaHAGJQEjsODcEg0FBAFVgkQJQ1pAwcDDw8KcFtSInwJAowCCA6RIwqZAgkPNgVpWndjdyohACH5BAkKAAAALAAAAAAQABAAAAV5ICACAimc5KieLEuUKvm2xAKLqDCfC2GaO9eL0LABWTiBYmA06W6kHgvCqEJiAIJiu3gcvgUsscHUERm+kaCxyxa+zRPk0SgJEgfIvbAdIAQLCAYlCj4DBw0IBQsMCjIqBAcPAooCBg9pKgsJLwUFOhCZKyQDA3YqIQAh+QQJCgAAACwAAAAAEAAQAAAFdSAgAgIpnOSonmxbqiThCrJKEHFbo8JxDDOZYFFb+A41E4H4OhkOipXwBElYITDAckFEOBgMQ3arkMkUBdxIUGZpEb7kaQBRlASPg0FQQHAbEEMGDSVEAA1QBhAED1E0NgwFAooCDWljaQIQCE5qMHcNhCkjIQAh+QQJCgAAACwAAAAAEAAQAAAFeSAgAgIpnOSoLgxxvqgKLEcCC65KEAByKK8cSpA4DAiHQ/DkKhGKh4ZCtCyZGo6F6iYYPAqFgYy02xkSaLEMV34tELyRYNEsCQyHlvWkGCzsPgMCEAY7Cg04Uk48LAsDhRA8MVQPEF0GAgqYYwSRlycNcWskCkApIyEAOwAAAAAAAAAAAA==",html:'<div class="ias-spinner" style="text-align: center;"><img src="{src}"/></div>'};var IASTriggerExtension=function(a){return a=jQuery.extend({},this.defaults,a),this.ias=null,this.html=a.html.replace("{text}",a.text),this.htmlPrev=a.htmlPrev.replace("{text}",a.textPrev),this.enabled=!0,this.count=0,this.offset=a.offset,this.$triggerNext=null,this.$triggerPrev=null,this.showTriggerNext=function(){if(!this.enabled)return!0;if(!1===this.offset||++this.count<this.offset)return!0;var a=this.$triggerNext||(this.$triggerNext=this.createTrigger(this.next,this.html)),b=this.ias.getLastItem();return b.after(a),a.fadeIn(),!1},this.showTriggerPrev=function(){if(!this.enabled)return!0;var a=this.$triggerPrev||(this.$triggerPrev=this.createTrigger(this.prev,this.htmlPrev)),b=this.ias.getFirstItem();return b.before(a),a.fadeIn(),!1},this.onRendered=function(){this.enabled=!0},this.createTrigger=function(a,b){var c,d=(new Date).getTime();return b=b||this.html,c=jQuery(b).attr("id","ias_trigger_"+d),c.hide(),c.on("click",jQuery.proxy(a,this)),c},this};IASTriggerExtension.prototype.bind=function(a){this.ias=a,a.on("next",jQuery.proxy(this.showTriggerNext,this),this.priority),a.on("rendered",jQuery.proxy(this.onRendered,this),this.priority);try{a.on("prev",jQuery.proxy(this.showTriggerPrev,this),this.priority)}catch(b){}},IASTriggerExtension.prototype.unbind=function(a){a.off("next",this.showTriggerNext),a.off("rendered",this.onRendered);try{a.off("prev",this.showTriggerPrev)}catch(b){}},IASTriggerExtension.prototype.next=function(){this.enabled=!1,this.ias.pause(),this.$triggerNext&&(this.$triggerNext.remove(),this.$triggerNext=null),this.ias.next()},IASTriggerExtension.prototype.prev=function(){this.enabled=!1,this.ias.pause(),this.$triggerPrev&&(this.$triggerPrev.remove(),this.$triggerPrev=null),this.ias.prev()},IASTriggerExtension.prototype.defaults={text:"Load more items",html:'<div class="ias-trigger ias-trigger-next" style="text-align: center; cursor: pointer;"><a>{text}</a></div>',textPrev:"Load previous items",htmlPrev:'<div class="ias-trigger ias-trigger-prev" style="text-align: center; cursor: pointer;"><a>{text}</a></div>',offset:0},IASTriggerExtension.prototype.priority=1e3;
/*!
 * Lightbox v2.8.2
 * by Lokesh Dhakar
 *
 * More info:
 * http://lokeshdhakar.com/projects/lightbox2/
 *
 * Copyright 2007, 2015 Lokesh Dhakar
 * Released under the MIT license
 * https://github.com/lokesh/lightbox2/blob/master/LICENSE
 */
!function(a,b){"function"==typeof define&&define.amd?define(["jquery"],b):"object"==typeof exports?module.exports=b(require("jquery")):a.lightbox=b(a.jQuery)}(this,function(a){function b(b){this.album=[],this.currentImageIndex=void 0,this.init(),this.options=a.extend({},this.constructor.defaults),this.option(b)}return b.defaults={albumLabel:"Image %1 of %2",alwaysShowNavOnTouchDevices:!1,fadeDuration:500,fitImagesInViewport:!0,positionFromTop:50,resizeDuration:700,showImageNumberLabel:!0,wrapAround:!1,disableScrolling:!1},b.prototype.option=function(b){a.extend(this.options,b)},b.prototype.imageCountLabel=function(a,b){return this.options.albumLabel.replace(/%1/g,a).replace(/%2/g,b)},b.prototype.init=function(){this.enable(),this.build()},b.prototype.enable=function(){var b=this;a("body").on("click","a[rel^=lightbox], area[rel^=lightbox], a[data-lightbox], area[data-lightbox]",function(c){return b.start(a(c.currentTarget)),!1})},b.prototype.build=function(){var b=this;a('<div id="lightboxOverlay" class="lightboxOverlay"></div><div id="lightbox" class="lightbox"><div class="lb-outerContainer"><div class="lb-container"><img class="lb-image" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" /><div class="lb-nav"><a class="lb-prev" href="" ></a><a class="lb-next" href="" ></a></div><div class="lb-loader"><a class="lb-cancel"></a></div></div></div><div class="lb-dataContainer"><div class="lb-data"><div class="lb-details"><span class="lb-caption"></span><span class="lb-number"></span></div><div class="lb-closeContainer"><a class="lb-close"></a></div></div></div></div>').appendTo(a("body")),this.$lightbox=a("#lightbox"),this.$overlay=a("#lightboxOverlay"),this.$outerContainer=this.$lightbox.find(".lb-outerContainer"),this.$container=this.$lightbox.find(".lb-container"),this.containerTopPadding=parseInt(this.$container.css("padding-top"),10),this.containerRightPadding=parseInt(this.$container.css("padding-right"),10),this.containerBottomPadding=parseInt(this.$container.css("padding-bottom"),10),this.containerLeftPadding=parseInt(this.$container.css("padding-left"),10),this.$overlay.hide().on("click",function(){return b.end(),!1}),this.$lightbox.hide().on("click",function(c){return"lightbox"===a(c.target).attr("id")&&b.end(),!1}),this.$outerContainer.on("click",function(c){return"lightbox"===a(c.target).attr("id")&&b.end(),!1}),this.$lightbox.find(".lb-prev").on("click",function(){return 0===b.currentImageIndex?b.changeImage(b.album.length-1):b.changeImage(b.currentImageIndex-1),!1}),this.$lightbox.find(".lb-next").on("click",function(){return b.currentImageIndex===b.album.length-1?b.changeImage(0):b.changeImage(b.currentImageIndex+1),!1}),this.$lightbox.find(".lb-loader, .lb-close").on("click",function(){return b.end(),!1})},b.prototype.start=function(b){function c(a){d.album.push({link:a.attr("href"),title:a.attr("data-title")||a.attr("title")})}var d=this,e=a(window);e.on("resize",a.proxy(this.sizeOverlay,this)),a("select, object, embed").css({visibility:"hidden"}),this.sizeOverlay(),this.album=[];var f,g=0,h=b.attr("data-lightbox");if(h){f=a(b.prop("tagName")+'[data-lightbox="'+h+'"]');for(var i=0;i<f.length;i=++i)c(a(f[i])),f[i]===b[0]&&(g=i)}else if("lightbox"===b.attr("rel"))c(b);else{f=a(b.prop("tagName")+'[rel="'+b.attr("rel")+'"]');for(var j=0;j<f.length;j=++j)c(a(f[j])),f[j]===b[0]&&(g=j)}var k=e.scrollTop()+this.options.positionFromTop,l=e.scrollLeft();this.$lightbox.css({top:k+"px",left:l+"px"}).fadeIn(this.options.fadeDuration),this.options.disableScrolling&&a("body").addClass("lb-disable-scrolling"),this.changeImage(g)},b.prototype.changeImage=function(b){var c=this;this.disableKeyboardNav();var d=this.$lightbox.find(".lb-image");this.$overlay.fadeIn(this.options.fadeDuration),a(".lb-loader").fadeIn("slow"),this.$lightbox.find(".lb-image, .lb-nav, .lb-prev, .lb-next, .lb-dataContainer, .lb-numbers, .lb-caption").hide(),this.$outerContainer.addClass("animating");var e=new Image;e.onload=function(){var f,g,h,i,j,k,l;d.attr("src",c.album[b].link),f=a(e),d.width(e.width),d.height(e.height),c.options.fitImagesInViewport&&(l=a(window).width(),k=a(window).height(),j=l-c.containerLeftPadding-c.containerRightPadding-20,i=k-c.containerTopPadding-c.containerBottomPadding-120,c.options.maxWidth&&c.options.maxWidth<j&&(j=c.options.maxWidth),c.options.maxHeight&&c.options.maxHeight<j&&(i=c.options.maxHeight),(e.width>j||e.height>i)&&(e.width/j>e.height/i?(h=j,g=parseInt(e.height/(e.width/h),10),d.width(h),d.height(g)):(g=i,h=parseInt(e.width/(e.height/g),10),d.width(h),d.height(g)))),c.sizeContainer(d.width(),d.height())},e.src=this.album[b].link,this.currentImageIndex=b},b.prototype.sizeOverlay=function(){this.$overlay.width(a(document).width()).height(a(document).height())},b.prototype.sizeContainer=function(a,b){function c(){d.$lightbox.find(".lb-dataContainer").width(g),d.$lightbox.find(".lb-prevLink").height(h),d.$lightbox.find(".lb-nextLink").height(h),d.showImage()}var d=this,e=this.$outerContainer.outerWidth(),f=this.$outerContainer.outerHeight(),g=a+this.containerLeftPadding+this.containerRightPadding,h=b+this.containerTopPadding+this.containerBottomPadding;e!==g||f!==h?this.$outerContainer.animate({width:g,height:h},this.options.resizeDuration,"swing",function(){c()}):c()},b.prototype.showImage=function(){this.$lightbox.find(".lb-loader").stop(!0).hide(),this.$lightbox.find(".lb-image").fadeIn("slow"),this.updateNav(),this.updateDetails(),this.preloadNeighboringImages(),this.enableKeyboardNav()},b.prototype.updateNav=function(){var a=!1;try{document.createEvent("TouchEvent"),a=this.options.alwaysShowNavOnTouchDevices?!0:!1}catch(b){}this.$lightbox.find(".lb-nav").show(),this.album.length>1&&(this.options.wrapAround?(a&&this.$lightbox.find(".lb-prev, .lb-next").css("opacity","1"),this.$lightbox.find(".lb-prev, .lb-next").show()):(this.currentImageIndex>0&&(this.$lightbox.find(".lb-prev").show(),a&&this.$lightbox.find(".lb-prev").css("opacity","1")),this.currentImageIndex<this.album.length-1&&(this.$lightbox.find(".lb-next").show(),a&&this.$lightbox.find(".lb-next").css("opacity","1"))))},b.prototype.updateDetails=function(){var b=this;if("undefined"!=typeof this.album[this.currentImageIndex].title&&""!==this.album[this.currentImageIndex].title&&this.$lightbox.find(".lb-caption").html(this.album[this.currentImageIndex].title).fadeIn("fast").find("a").on("click",function(b){void 0!==a(this).attr("target")?window.open(a(this).attr("href"),a(this).attr("target")):location.href=a(this).attr("href")}),this.album.length>1&&this.options.showImageNumberLabel){var c=this.imageCountLabel(this.currentImageIndex+1,this.album.length);this.$lightbox.find(".lb-number").text(c).fadeIn("fast")}else this.$lightbox.find(".lb-number").hide();this.$outerContainer.removeClass("animating"),this.$lightbox.find(".lb-dataContainer").fadeIn(this.options.resizeDuration,function(){return b.sizeOverlay()})},b.prototype.preloadNeighboringImages=function(){if(this.album.length>this.currentImageIndex+1){var a=new Image;a.src=this.album[this.currentImageIndex+1].link}if(this.currentImageIndex>0){var b=new Image;b.src=this.album[this.currentImageIndex-1].link}},b.prototype.enableKeyboardNav=function(){a(document).on("keyup.keyboard",a.proxy(this.keyboardAction,this))},b.prototype.disableKeyboardNav=function(){a(document).off(".keyboard")},b.prototype.keyboardAction=function(a){var b=27,c=37,d=39,e=a.keyCode,f=String.fromCharCode(e).toLowerCase();e===b||f.match(/x|o|c/)?this.end():"p"===f||e===c?0!==this.currentImageIndex?this.changeImage(this.currentImageIndex-1):this.options.wrapAround&&this.album.length>1&&this.changeImage(this.album.length-1):("n"===f||e===d)&&(this.currentImageIndex!==this.album.length-1?this.changeImage(this.currentImageIndex+1):this.options.wrapAround&&this.album.length>1&&this.changeImage(0))},b.prototype.end=function(){this.disableKeyboardNav(),a(window).off("resize",this.sizeOverlay),this.$lightbox.fadeOut(this.options.fadeDuration),this.$overlay.fadeOut(this.options.fadeDuration),a("select, object, embed").css({visibility:"visible"}),this.options.disableScrolling&&a("body").removeClass("lb-disable-scrolling")},new b});
//# sourceMappingURL=lightbox.min.map
// Generated by CoffeeScript 1.9.2

/**
@license Sticky-kit v1.1.2 | WTFPL | Leaf Corcoran 2015 | http://leafo.net
 */

(function() {
  var $, win;

  $ = this.jQuery || window.jQuery;

  win = $(window);

  $.fn.stick_in_parent = function(opts) {
    var doc, elm, enable_bottoming, fn, i, inner_scrolling, len, manual_spacer, offset_top, parent_selector, recalc_every, sticky_class;
    if (opts == null) {
      opts = {};
    }
    sticky_class = opts.sticky_class, inner_scrolling = opts.inner_scrolling, recalc_every = opts.recalc_every, parent_selector = opts.parent, offset_top = opts.offset_top, manual_spacer = opts.spacer, enable_bottoming = opts.bottoming;
    if (offset_top == null) {
      offset_top = 0;
    }
    if (parent_selector == null) {
      parent_selector = void 0;
    }
    if (inner_scrolling == null) {
      inner_scrolling = true;
    }
    if (sticky_class == null) {
      sticky_class = "is_stuck";
    }
    doc = $(document);
    if (enable_bottoming == null) {
      enable_bottoming = true;
    }
    fn = function(elm, padding_bottom, parent_top, parent_height, top, height, el_float, detached) {
      var bottomed, detach, fixed, last_pos, last_scroll_height, offset, parent, recalc, recalc_and_tick, recalc_counter, spacer, tick;
      if (elm.data("sticky_kit")) {
        return;
      }
      elm.data("sticky_kit", true);
      last_scroll_height = doc.height();
      parent = elm.parent();
      if (parent_selector != null) {
        parent = parent.closest(parent_selector);
      }
      if (!parent.length) {
        throw "failed to find stick parent";
      }
      fixed = false;
      bottomed = false;
      spacer = manual_spacer != null ? manual_spacer && elm.closest(manual_spacer) : $("<div />");
      /*if (spacer) {
        spacer.css('position', elm.css('position'));
      }*/
      recalc = function() {
        var border_top, padding_top, restore;
        if (detached) {
          return;
        }
        last_scroll_height = doc.height();
        border_top = parseInt(parent.css("border-top-width"), 10);
        padding_top = parseInt(parent.css("padding-top"), 10);
        padding_bottom = parseInt(parent.css("padding-bottom"), 10);
        parent_top = parent.offset().top + border_top + padding_top;
        parent_height = parent.height();
        if (fixed) {
          fixed = false;
          bottomed = false;
          if (manual_spacer == null) {
            elm.insertAfter(spacer);
            spacer.detach();
          }
          elm.css({
            position: "",
            top: "",
            width: "",
            bottom: ""
          }).removeClass(sticky_class);
          restore = true;
        }
        top = elm.offset().top - (parseInt(elm.css("margin-top"), 10) || 0) - offset_top;
        height = elm.outerHeight(true);
        el_float = elm.css("float");
        if (spacer) {
          spacer.css({
            width: elm.outerWidth(true),
            height: height,
            display: elm.css("display"),
            "vertical-align": elm.css("vertical-align"),
            "float": el_float
          });
        }
        if (restore) {
          return tick();
        }
      };
      recalc();
      if (height === parent_height) {
        return;
      }
      last_pos = void 0;
      offset = offset_top;
      recalc_counter = recalc_every;
      tick = function() {
        var css, delta, recalced, scroll, will_bottom, win_height;
        if (detached) {
          return;
        }
        recalced = false;
        if (recalc_counter != null) {
          recalc_counter -= 1;
          if (recalc_counter <= 0) {
            recalc_counter = recalc_every;
            recalc();
            recalced = true;
          }
        }
        if (!recalced && doc.height() !== last_scroll_height) {
          recalc();
          recalced = true;
        }
        scroll = win.scrollTop();
        if (last_pos != null) {
          delta = scroll - last_pos;
        }
        last_pos = scroll;
        if (fixed) {
          if (enable_bottoming) {
            will_bottom = scroll + height + offset > parent_height + parent_top;
            if (bottomed && !will_bottom) {
              bottomed = false;
              elm.css({
                position: "fixed",
                bottom: "",
                top: offset
              }).trigger("sticky_kit:unbottom");
            }
          }
          if (scroll < top) {
            fixed = false;
            offset = offset_top;
            if (manual_spacer == null) {
              if (el_float === "left" || el_float === "right") {
                elm.insertAfter(spacer);
              }
              spacer.detach();
            }
            css = {
              position: "",
              width: "",
              top: ""
            };
            elm.css(css).removeClass(sticky_class).trigger("sticky_kit:unstick");
          }
          if (inner_scrolling) {
            win_height = win.height();
            if (height + offset_top > win_height) {
              if (!bottomed) {
                offset -= delta;
                offset = Math.max(win_height - height, offset);
                offset = Math.min(offset_top, offset);
                if (fixed) {
                  elm.css({
                    top: offset + "px"
                  });
                }
              }
            }
          }
        } else {
          if (scroll > top) {
            fixed = true;
            css = {
              position: "fixed",
              top: offset
            };
            css.width = elm.css("box-sizing") === "border-box" ? elm.outerWidth() + "px" : elm.width() + "px";
            elm.css(css).addClass(sticky_class);
            if (manual_spacer == null) {
              elm.after(spacer);
              if (el_float === "left" || el_float === "right") {
                spacer.append(elm);
              }
            }
            elm.trigger("sticky_kit:stick");
          }
        }
        if (fixed && enable_bottoming) {
          if (will_bottom == null) {
            will_bottom = scroll + height + offset > parent_height + parent_top;
          }
          if (!bottomed && will_bottom) {
            bottomed = true;
            if (parent.css("position") === "static") {
              parent.css({
                position: "relative"
              });
            }
            return elm.css({
              position: "absolute",
              bottom: padding_bottom,
              top: "auto"
            }).trigger("sticky_kit:bottom");
          }
        }
      };
      recalc_and_tick = function() {
        recalc();
        return tick();
      };
      detach = function() {
        detached = true;
        win.off("touchmove", tick);
        win.off("scroll", tick);
        win.off("resize", recalc_and_tick);
        $(document.body).off("sticky_kit:recalc", recalc_and_tick);
        elm.off("sticky_kit:detach", detach);
        elm.removeData("sticky_kit");
        elm.css({
          position: "",
          bottom: "",
          top: "",
          width: ""
        });
        parent.position("position", "");
        if (fixed) {
          if (manual_spacer == null) {
            if (el_float === "left" || el_float === "right") {
              elm.insertAfter(spacer);
            }
            spacer.remove();
          }
          return elm.removeClass(sticky_class);
        }
      };
      win.on("touchmove", tick);
      win.on("scroll", tick);
      win.on("resize", recalc_and_tick);
      $(document.body).on("sticky_kit:recalc", recalc_and_tick);
      elm.on("sticky_kit:detach", detach);
      return setTimeout(tick, 0);
    };
    for (i = 0, len = this.length; i < len; i++) {
      elm = this[i];
      fn($(elm));
    }
    return this;
  };

}).call(this);
/*
 *	Dev scripts for theme
 */

( function( $ ) {

	// Handles both slide navigations
	$(function(){
		var navButton = $('button.navbar-toggle'),
		socialNavButton = $('.social-toggle a'),
		showLeft = $('#slide-navigation'),
		showRight = $('#slide-nav-social'),
		body = $('body'),
		links = showLeft.find('a');

		navButton.click(function(){
			$(this).toggleClass('active');
			body.toggleClass('push-toright');
			showLeft.toggleClass('slide-nav-open');
		});
		socialNavButton.click(function(){
			$(this).toggleClass('active');
			body.toggleClass('push-toleft');
			showRight.toggleClass('slide-nav-open');
		});

		$('a.restore-body').click(function(){
			$(this).toggleClass('active');
			body.removeClass('push-toleft');
			body.removeClass('push-toright');
			showRight.removeClass('slide-nav-open');
			showLeft.removeClass('slide-nav-open');
		});
	});

	var trendingOptions = {
			dots: false,
			infinite: true,
			arrows: true,
			speed: 300,
			autoplay: false,
			autoplaySpeed: 3000,
			slidesToShow: 4,
			slidesToScroll: 4,
			responsive: [
				{
					breakpoint: 991,
					settings: {
					  slidesToShow: 3,
					  slidesToScroll: 3
					}
				},
				{
					breakpoint: 700,
					settings: {
					  slidesToShow: 2,
					  slidesToScroll: 2
					}
				},
				{
					breakpoint: 500,
					settings: {
					  slidesToShow: 1,
					  slidesToScroll: 1
					}
				}
			]
		}

	// Slick Carousels http://kenwheeler.github.io/slick/
	$(function(){
		$('#home-authors-carousel').slick({
			dots: false,
			infinite: false,
			speed: 300,
			slidesToShow: 6,
			slidesToScroll: 6,
			responsive: [
			  {
				breakpoint: 1024,
				settings: {
				  slidesToShow: 4,
				  slidesToScroll: 4
				}
			  },
			  {
				breakpoint: 600,
				settings: {
				  slidesToShow: 3,
				  slidesToScroll: 3
				}
			  },
			  {
				breakpoint: 480,
				settings: {
				  slidesToShow: 2,
				  slidesToScroll: 2
				}
			  }
			]
		});

		$('.homepage-banner .banner').slick({
			dots : true,
			arrows : false,
			autoplay: true,
			autoplaySpeed: 5000
		});

		$('.in-post-carousel').slick({
			dots: false,
			arrows : true,
			infinite: false,
			speed: 300,
			slidesToShow: 4,
			slidesToScroll: 4,
			responsive: [
			  {
				breakpoint: 1024,
				settings: {
				  slidesToShow: 4,
				  slidesToScroll: 4
				}
			  },
			  {
				breakpoint: 600,
				settings: {
				  slidesToShow: 3,
				  slidesToScroll: 3
				}
			  },
			  {
				breakpoint: 480,
				settings: {
				  slidesToShow: 2,
				  slidesToScroll: 2
				}
			  }
			]
		});

		$('.in-post-carousel-with-author').slick({
			dots: false,
			arrows : false,
			infinite: false,
			speed: 300,
			slidesToShow: 3,
			slidesToScroll: 3,
			responsive: [
			  {
				breakpoint: 1024,
				settings: {
				  slidesToShow: 3,
				  slidesToScroll: 3
				}
			  },
			  {
				breakpoint: 600,
				settings: {
				  slidesToShow: 2,
				  slidesToScroll: 2
				}
			  },
			  {
				breakpoint: 480,
				settings: {
				  slidesToShow: 1,
				  slidesToScroll: 1
				}
			  }
			]
		});

		$('.video-carousel').slick({
			arrows : true,
			infinite : true,
			autoplay: false,
			speed : 300,
			slidesToShow : 1,
			variableWidth: true,
			centerMode: true,
			draggable: false,
			asNavFor: '.caption-slider'
		});
		$('.caption-slider').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			fade: true,
			draggable: false,
			adaptiveHeight: true
		});

		$('#page-trending-slides').slick(trendingOptions);
	});

	$(function(){
	   $('.video-carousel iframe').each(function(){
			var oldSrc = $(this).attr('src');
			if( oldSrc.indexOf('youtube') > 0 || oldSrc.indexOf('vimeo') > 0 ){
				if( oldSrc.indexOf('?') > 0 ){
					$(this).attr('src', oldSrc+'&enablejsapi=1');
				}else{
					$(this).attr('src', oldSrc+'?enablejsapi=1');
				}
			}
		});

		$('.video-carousel').on('beforeChange', function(event, slick, currentSlide, nextSlide){
			var elem = document.getElementsByClassName('slick-current')[0];
			var elemIframe = elem.getElementsByTagName("iframe")[0];
			var elemSrc = elemIframe.getAttribute('src');

			if( elemSrc.indexOf('youtube') > 0 ){
				elemIframe.contentWindow.postMessage('{"event":"command","func":"stopVideo","args":""}', '*');
			} else if( elemSrc.indexOf('vine') > 0 ) {
				elemIframe.contentWindow.postMessage('mute', '*');
			} else if( elemSrc.indexOf('vimeo') > 0 ) {
				elemIframe.contentWindow.postMessage('{"method":"pause"}', elemSrc);
			} else{
				// just reload page
				elemIframe.src = elemSrc;
			}
		});
	});

	$(function(){
		// global keycode constant
		var KEYCODE_ESC = 27,
			AVAIL_CODES = {
				numbers : [48, 57],
				uppercase : [65,90],
				// lowercase : [97, 122]
			},
			CODES = {
				BACKSPACE:8,
				COMMA:188,
				DELETE:46,
				DOWN:40,
				END:35,
				ENTER:13,
				ESCAPE:27,
				HOME:36,
				LEFT:37,
				NUMPAD_ADD:107,
				NUMPAD_DECIMAL:110,
				NUMPAD_DIVIDE:111,
				NUMPAD_ENTER:108,
				NUMPAD_MULTIPLY:106,
				NUMPAD_SUBTRACT:109,
				PAGE_DOWN:34,
				PAGE_UP:33,
				PERIOD:190,
				RIGHT:39,
				SPACE:32,
				TAB:9,
				UP:38,
				CTRL:17
			},
			ctrlDown = false;
		// intialize
		$(document).ready( function() {
			// cache variables
			var $search = $('#site-search');
			var $searchtext = $('#site-search .search-field');
			var $searchBtn = $('.icon.search a');
			//turn off autocomplete
			$searchtext.attr('autocomplete', 'off');
			// on any keydown, start parsing keyboard input

			//on search button click
			$searchBtn.click(function(){
				$searchtext.show().focus();
				$search.fadeIn(200);
			});

			$(document).keydown(function(e) {
				if (e.keyCode === CODES.CTRL || e.metaKey || e.ctrlKey){
					ctrlDown = true;
					console.log('ctrl pressed');
				} else{
					ctrlDown = false;
				}

			  if($search.is(':visible')) {
				switch (e.which) {
				  case KEYCODE_ESC:
					$search.fadeOut(200);
					$searchtext.blur().hide();
				  break;
				  default:
					$searchtext.focus();
				  break;
				}
			  } else {
				for (var key in AVAIL_CODES){
					if(e.which >= AVAIL_CODES[key][0] && e.which <= AVAIL_CODES[key][1] && ctrlDown === false && !($('input, textarea').is(':focus'))){
						$searchtext.show().focus();
						$searchtext.val(String.fromCharCode(e.which).toLowerCase());
						$search.fadeIn(200);
					}
				}
			  }
			});
			$('#close-search').click(function(){
				$search.fadeOut(200);
				$searchtext.blur().hide();
			});

		});
	});

	$(function(){
		$('li.page_item.shop a').click(function(){
			ga('send', 'event', 'Nav Shop Link', 'click', 'Click on shop link in nav bar');
		});
	});

	$(function(){
		$(document).ajaxComplete(function(){
			if($('#home-break-slides').hasClass('slick-slider') !== true){
				$('#home-break-slides').slick(trendingOptions);
			}
		});
	});

	$(function(){
		if($('.sticky-sidebar').length > 0){
			var top = $('.sticky-sidebar').offset().top;
			//https://github.com/leafo/sticky-kit/issues
			$(window).on('load resize', function(){
				if($('.sticky-sidebar').length > 0){
					if($(window).width() < 991){
						$(".sticky-sidebar .sidebar").trigger('sticky_kit:detach');
					}else{
						var top = $('.sticky-sidebar').offset().top;
						$(".sticky-sidebar .sidebar").stick_in_parent({
							parent : $('.sticky-container'),
							offset_top : top
						});
					}
				}
			});
		}
	});

} )( jQuery );

(function($){
	var $list = $('.v-player-list'),
		$window = $(window),
		newHeight;

	var recalcHeight = function(){
		if($window.outerWidth() >= 992){
			newHeight = $('.player-container').outerHeight();
			$list.css({'height' : newHeight+'px'});
		}else{
			$list.css({'height' : '348px'});
		}
	}
	recalcHeight();

	$window.on('load resize', function(){
		recalcHeight();
	});
})(jQuery);

(function($){
	var containerName;
	if($('#homeposts').length > 0){
		containerName = '#homeposts';
	} else if ($('#archiveposts').length > 0){
		containerName = '#archiveposts';
	} else {
		containerName = null;
	}
	var ias = $.ias({
		container:  containerName,
		item:       '.loop-post',
		pagination: 'nav.posts-navigation',
		next:       '.posts-navigation .nav-previous a',
		negativeMargin: 100,
		delay: 1
	});
	ias.extension(new IASSpinnerExtension({
		src : '/wp-content/uploads/2015/10/default.gif'
	}));
	ias.on('rendered', function(items){
		FB.XFBML.parse();
		refreshSlots();
	});

	ias.on('noneLeft', function() {
			$('.load-more-trigger').remove();
	});

	var i = 0;
	$.ias().on('render', function(items) {
		i++;
		console.log(i);
		if(i === 2){
			ias.extension(new IASTriggerExtension({
				text: 'VIEW MORE HAHAS',
				html: '<div class="load-more-trigger text-center"><a class="btn btn-primary">{text}</a></div>'
			}));
		}
	});

})(jQuery);

(function($){
	var $body = $('body');

	$body.on('click', '.video-overlay a', function(e){
		// e.preventDefault();
		var title = $(e.currentTarget).find('span');
		ga('send', 'event', 'Video Overlay', 'click', ''+title.text()+'');
		// console.log("ga('send', 'event', 'Video Overlay', 'click', '"+title.text()+"');");
	});
})(jQuery);

(function($){
	var $links = $('img'),
		title = $('title').html();

	$links.each(function(key, value){
		if($(value).attr('alt') == null){
			$(value).prop('alt', title);
		}
	});

})(jQuery);

// Global function for social icons on post pages
function socialShare(url, width, height) {
	var winLeft = (window.innerWidth / 2) - (width / 2);
	var winTop = (window.innerHeight / 2) - (height / 2);
	window.open(url, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height='+height+',width='+width+',top='+winTop+',left='+winLeft);
}

/*
 * Add google event when youtube subscribe iframe is clicked in interstitial ad
 */
(function($){
	$(window).load(function(){
		if ($('#___ytsubscribe_0').length > 0) {
			var iframeYt = document.getElementById('___ytsubscribe_0').firstElementChild;
			focus();
			var listener = addEventListener('blur', function() {
				if(document.activeElement === iframeYt) {
					ga('send', 'event', 'Interstitial Ad', 'click', 'Subscribe to WhoHaha on Youtube');
				}
				removeEventListener('blur', listener);
			});
		}
	});
})(jQuery);

/*
 * Add controls to number input
 */
(function($){
	var woo = $(document);
	var input = $(woo).find('.quantity input');

	// $(woo).find('.quantity');
		// .prepend('<span class="input-num input-number-decrement">-</span>')
		// .append('<span class="input-num input-number-increment">+</span>');

	var val = input.val();
	var inputMin = input.attr('min');
	var incrBtn = $('.input-number-increment');
	var decrBtn = $('.input-number-decrement');

	$(document).on('click', '.input-num', function(e){
		// redefine input in case button replaced with ajax
		input = $(e.currentTarget).siblings('.quantity').find('input');
		val = input.val();

		if($(e.target).hasClass('input-number-decrement')){
			decrease();
		}
		else if($(e.target).hasClass('input-number-increment')){
			increase();
		}
		val = input.val();
		$('input[name="update_cart"]').attr('disabled', false);
	});

	function increase(){
		console.log(input);
		$(input).attr('value', parseInt(val)+1);
	}
	function decrease(){
		if(val > inputMin){
			$(input).attr('value', parseInt(val)-1);
		}
	}
})(jQuery);

(function($){
	var main_img_link = $('a.woocommerce-main-image');
	var main_img = $(main_img_link).find('img');

	$('.images .thumbnails > a').on('click', function(e){
		e.preventDefault();
		var selected = $(this);
		var selectedImg = $(selected).find('img');

		var newLink = $(selected).attr('href');
		var newSrc = $(selectedImg).attr('src');
		var newSrcset = $(selectedImg).attr('srcset');

		$(main_img_link).attr('href', newLink);
		$(main_img).attr('src', newSrc).attr('srcset', newSrcset);
	});
})(jQuery);

(function($){
	lightbox.option({
	  'resizeDuration': 300,
			'disableScrolling' : true
	});
})(jQuery);

(function($){
	if ( $('.match-height').length > 0 )
		$('.match-height').matchHeight();

	$('#page.gopitchyourself .bg-pink span').fitText(.58);
	$('#page.gopitchyourself .bg-purple span').fitText(1.05);
	$('#page.gopitchyourself .bg-blue span').fitText(.87);
})(jQuery);

(function($){
	function floatLabel(inputType){
		$(inputType).each(function(){
			var $this = $(this).find('input');
			// on focus add cladd active to label
			$this.focus(function(){
				$this.parent().siblings('label').addClass("active");
			});
			//on blur check field and remove class if needed
			$this.blur(function(){
				if($this.val() === '' || $this.val() === 'blank'){
					$this.parent().siblings('label').removeClass();
				}
			});
		});
	}
	// just add a class of "floatLabel to the input field!"
	floatLabel(".floatlabel");

	jQuery('.entry-form-container select.form-control').select2();
})(jQuery);

(function($){
	$('.whh-playlists article.has-tooltip').popover({
		html: true,
		// trigger: 'click',
		trigger : 'manual',
		container : '.whh-playlists',
		placement : 'auto right',
		title : $(this).siblings('.plist-popover-title').text(),
		content : function() {
			return $(this).siblings('.plist-popover-content').html();
		}
	})
	.on("mouseenter", function () {
		if (window.innerWidth > 700) {
			var _this = this;
			$(this).popover("show").addClass('active');
			$(".popover").on("mouseleave", function () {
				setTimeout(function(){
					if (!$(_this).is(':hover')) {
						$(_this).popover("hide").removeClass('active');
					}
				}, 100);
			});
		}
	}).on("mouseleave", function () {
		var _this = this;
		setTimeout(function () {
			if (!$(".popover:hover").length) {
				$(_this).popover("hide").removeClass('active');
			}
		}, 100);
	});

	$('.playlist-carousel').slick({
		dots: false,
		infinite: false,
		arrows: true,
		speed: 300,
		autoplay: false,
		autoplaySpeed: 3000,
		slidesToShow: 3,
		slidesToScroll: 3,
		// lazyLoad: 'ondemand',
		draggable: false,
		responsive: [
			{
				breakpoint: 991,
				settings: {
				  slidesToShow: 2,
				  slidesToScroll: 2
				}
			},
			{
				breakpoint: 700,
				settings: {
				  slidesToShow: 1,
				  slidesToScroll: 1
				}
			}
		]
	});
	$('.single-playlist-carousel').slick({
		dots: false,
		infinite: false,
		arrows: true,
		speed: 300,
		autoplay: false,
		autoplaySpeed: 3000,
		slidesToShow: 4,
		slidesToScroll: 4,
		// lazyLoad: 'ondemand',
		draggable: false,
		swipe: false,
		responsive: [
			{
				breakpoint: 991,
				settings: {
				  slidesToShow: 3,
				  slidesToScroll: 3
				}
			},
			{
				breakpoint: 700,
				settings: {
				  slidesToShow: 2,
				  slidesToScroll: 2
				}
			},
			{
				breakpoint: 500,
				settings: {
				  slidesToShow: 1,
				  slidesToScroll: 1
				}
			}
		]
	});
})(jQuery);

(function($){
	$(document).on("click", "a#tag-generate", function(event){
		event.preventDefault();

		ga('send', 'event', 'Tag Generator', 'click', 'Generate random tags in navbar');

		$clicked = $(this);
		$list = $clicked.closest('ul');
		$container = $('.generate-tags');
		$('.reloadtags').addClass('loading');

		$.ajax({
			url : '/wp-admin/admin-ajax.php',
			method : 'POST',
			data : {
				'action' : 'generate_rand_tags_ajax'
			}
		})
		.done(function(output){
			$container.html(output);
			// $container.find('a').removeAttr('style');
		})
		.fail(function(jqXHR, textStatus){
			console.log('error', textStatus);
		})
		.always(function(output){
			$('.reloadtags').removeClass('loading');
		});
	});
})(jQuery);
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbImpxdWVyeS1pYXMubWluLmpzIiwibGlnaHRib3gubWluLmpzIiwic3RpY2t5LWtpdC5qcyIsInNjcmlwdC5qcyIsIm5hdi10YWdzLmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FDWkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUNaQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FDMVBBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUMvb0JBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSIsImZpbGUiOiJzY3JpcHRzLmpzIiwic291cmNlc0NvbnRlbnQiOlsiLyohXG4gKiBJbmZpbml0ZSBBamF4IFNjcm9sbCB2Mi4yLjFcbiAqIEEgalF1ZXJ5IHBsdWdpbiBmb3IgaW5maW5pdGUgc2Nyb2xsaW5nXG4gKiBodHRwOi8vaW5maW5pdGVhamF4c2Nyb2xsLmNvbVxuICpcbiAqIENvbW1lcmNpYWwgdXNlIHJlcXVpcmVzIG9uZS10aW1lIHB1cmNoYXNlIG9mIGEgY29tbWVyY2lhbCBsaWNlbnNlXG4gKiBodHRwOi8vaW5maW5pdGVhamF4c2Nyb2xsLmNvbS9kb2NzL2xpY2Vuc2UuaHRtbFxuICpcbiAqIE5vbi1jb21tZXJjaWFsIHVzZSBpcyBsaWNlbnNlZCB1bmRlciB0aGUgTUlUIExpY2Vuc2VcbiAqXG4gKiBDb3B5cmlnaHQgKGMpIDIwMTUgV2ViY3JlYXRlIChKZXJvZW4gRmllZ2UpXG4gKi9cbnZhciBJQVNDYWxsYmFja3M9ZnVuY3Rpb24oKXtyZXR1cm4gdGhpcy5saXN0PVtdLHRoaXMuZmlyZVN0YWNrPVtdLHRoaXMuaXNGaXJpbmc9ITEsdGhpcy5pc0Rpc2FibGVkPSExLHRoaXMuZmlyZT1mdW5jdGlvbihhKXt2YXIgYj1hWzBdLGM9YVsxXSxkPWFbMl07dGhpcy5pc0ZpcmluZz0hMDtmb3IodmFyIGU9MCxmPXRoaXMubGlzdC5sZW5ndGg7Zj5lO2UrKylpZih2b2lkIDAhPXRoaXMubGlzdFtlXSYmITE9PT10aGlzLmxpc3RbZV0uZm4uYXBwbHkoYixkKSl7Yy5yZWplY3QoKTticmVha310aGlzLmlzRmlyaW5nPSExLGMucmVzb2x2ZSgpLHRoaXMuZmlyZVN0YWNrLmxlbmd0aCYmdGhpcy5maXJlKHRoaXMuZmlyZVN0YWNrLnNoaWZ0KCkpfSx0aGlzLmluTGlzdD1mdW5jdGlvbihhLGIpe2I9Ynx8MDtmb3IodmFyIGM9YixkPXRoaXMubGlzdC5sZW5ndGg7ZD5jO2MrKylpZih0aGlzLmxpc3RbY10uZm49PT1hfHxhLmd1aWQmJnRoaXMubGlzdFtjXS5mbi5ndWlkJiZhLmd1aWQ9PT10aGlzLmxpc3RbY10uZm4uZ3VpZClyZXR1cm4gYztyZXR1cm4tMX0sdGhpc307SUFTQ2FsbGJhY2tzLnByb3RvdHlwZT17YWRkOmZ1bmN0aW9uKGEsYil7dmFyIGM9e2ZuOmEscHJpb3JpdHk6Yn07Yj1ifHwwO2Zvcih2YXIgZD0wLGU9dGhpcy5saXN0Lmxlbmd0aDtlPmQ7ZCsrKWlmKGI+dGhpcy5saXN0W2RdLnByaW9yaXR5KXJldHVybiB0aGlzLmxpc3Quc3BsaWNlKGQsMCxjKSx0aGlzO3JldHVybiB0aGlzLmxpc3QucHVzaChjKSx0aGlzfSxyZW1vdmU6ZnVuY3Rpb24oYSl7Zm9yKHZhciBiPTA7KGI9dGhpcy5pbkxpc3QoYSxiKSk+LTE7KXRoaXMubGlzdC5zcGxpY2UoYiwxKTtyZXR1cm4gdGhpc30saGFzOmZ1bmN0aW9uKGEpe3JldHVybiB0aGlzLmluTGlzdChhKT4tMX0sZmlyZVdpdGg6ZnVuY3Rpb24oYSxiKXt2YXIgYz1qUXVlcnkuRGVmZXJyZWQoKTtyZXR1cm4gdGhpcy5pc0Rpc2FibGVkP2MucmVqZWN0KCk6KGI9Ynx8W10sYj1bYSxjLGIuc2xpY2U/Yi5zbGljZSgpOmJdLHRoaXMuaXNGaXJpbmc/dGhpcy5maXJlU3RhY2sucHVzaChiKTp0aGlzLmZpcmUoYiksYyl9LGRpc2FibGU6ZnVuY3Rpb24oKXt0aGlzLmlzRGlzYWJsZWQ9ITB9LGVuYWJsZTpmdW5jdGlvbigpe3RoaXMuaXNEaXNhYmxlZD0hMX19LGZ1bmN0aW9uKGEpe1widXNlIHN0cmljdFwiO3ZhciBiPS0xLGM9ZnVuY3Rpb24oYyxkKXtyZXR1cm4gdGhpcy5pdGVtc0NvbnRhaW5lclNlbGVjdG9yPWQuY29udGFpbmVyLHRoaXMuaXRlbVNlbGVjdG9yPWQuaXRlbSx0aGlzLm5leHRTZWxlY3Rvcj1kLm5leHQsdGhpcy5wYWdpbmF0aW9uU2VsZWN0b3I9ZC5wYWdpbmF0aW9uLHRoaXMuJHNjcm9sbENvbnRhaW5lcj1jLHRoaXMuJGNvbnRhaW5lcj13aW5kb3c9PT1jLmdldCgwKT9hKGRvY3VtZW50KTpjLHRoaXMuZGVmYXVsdERlbGF5PWQuZGVsYXksdGhpcy5uZWdhdGl2ZU1hcmdpbj1kLm5lZ2F0aXZlTWFyZ2luLHRoaXMubmV4dFVybD1udWxsLHRoaXMuaXNCb3VuZD0hMSx0aGlzLmlzUGF1c2VkPSExLHRoaXMuaXNJbml0aWFsaXplZD0hMSx0aGlzLmxpc3RlbmVycz17bmV4dDpuZXcgSUFTQ2FsbGJhY2tzLGxvYWQ6bmV3IElBU0NhbGxiYWNrcyxsb2FkZWQ6bmV3IElBU0NhbGxiYWNrcyxyZW5kZXI6bmV3IElBU0NhbGxiYWNrcyxyZW5kZXJlZDpuZXcgSUFTQ2FsbGJhY2tzLHNjcm9sbDpuZXcgSUFTQ2FsbGJhY2tzLG5vbmVMZWZ0Om5ldyBJQVNDYWxsYmFja3MscmVhZHk6bmV3IElBU0NhbGxiYWNrc30sdGhpcy5leHRlbnNpb25zPVtdLHRoaXMuc2Nyb2xsSGFuZGxlcj1mdW5jdGlvbigpe2lmKHRoaXMuaXNCb3VuZCYmIXRoaXMuaXNQYXVzZWQpe3ZhciBhPXRoaXMuZ2V0Q3VycmVudFNjcm9sbE9mZnNldCh0aGlzLiRzY3JvbGxDb250YWluZXIpLGM9dGhpcy5nZXRTY3JvbGxUaHJlc2hvbGQoKTtiIT1jJiYodGhpcy5maXJlKFwic2Nyb2xsXCIsW2EsY10pLGE+PWMmJnRoaXMubmV4dCgpKX19LHRoaXMuZ2V0SXRlbXNDb250YWluZXI9ZnVuY3Rpb24oKXtyZXR1cm4gYSh0aGlzLml0ZW1zQ29udGFpbmVyU2VsZWN0b3IpfSx0aGlzLmdldExhc3RJdGVtPWZ1bmN0aW9uKCl7cmV0dXJuIGEodGhpcy5pdGVtU2VsZWN0b3IsdGhpcy5nZXRJdGVtc0NvbnRhaW5lcigpLmdldCgwKSkubGFzdCgpfSx0aGlzLmdldEZpcnN0SXRlbT1mdW5jdGlvbigpe3JldHVybiBhKHRoaXMuaXRlbVNlbGVjdG9yLHRoaXMuZ2V0SXRlbXNDb250YWluZXIoKS5nZXQoMCkpLmZpcnN0KCl9LHRoaXMuZ2V0U2Nyb2xsVGhyZXNob2xkPWZ1bmN0aW9uKGEpe3ZhciBjO3JldHVybiBhPWF8fHRoaXMubmVnYXRpdmVNYXJnaW4sYT1hPj0wPy0xKmE6YSxjPXRoaXMuZ2V0TGFzdEl0ZW0oKSwwPT09Yy5sZW5ndGg/YjpjLm9mZnNldCgpLnRvcCtjLmhlaWdodCgpK2F9LHRoaXMuZ2V0Q3VycmVudFNjcm9sbE9mZnNldD1mdW5jdGlvbihhKXt2YXIgYj0wLGM9YS5oZWlnaHQoKTtyZXR1cm4gYj13aW5kb3c9PT1hLmdldCgwKT9hLnNjcm9sbFRvcCgpOmEub2Zmc2V0KCkudG9wLCgtMSE9bmF2aWdhdG9yLnBsYXRmb3JtLmluZGV4T2YoXCJpUGhvbmVcIil8fC0xIT1uYXZpZ2F0b3IucGxhdGZvcm0uaW5kZXhPZihcImlQb2RcIikpJiYoYys9ODApLGIrY30sdGhpcy5nZXROZXh0VXJsPWZ1bmN0aW9uKGIpe3JldHVybiBiPWJ8fHRoaXMuJGNvbnRhaW5lcixhKHRoaXMubmV4dFNlbGVjdG9yLGIpLmxhc3QoKS5hdHRyKFwiaHJlZlwiKX0sdGhpcy5sb2FkPWZ1bmN0aW9uKGIsYyxkKXt2YXIgZSxmLGc9dGhpcyxoPVtdLGk9K25ldyBEYXRlO2Q9ZHx8dGhpcy5kZWZhdWx0RGVsYXk7dmFyIGo9e3VybDpifTtyZXR1cm4gZy5maXJlKFwibG9hZFwiLFtqXSksYS5nZXQoai51cmwsbnVsbCxhLnByb3h5KGZ1bmN0aW9uKGIpe2U9YSh0aGlzLml0ZW1zQ29udGFpbmVyU2VsZWN0b3IsYikuZXEoMCksMD09PWUubGVuZ3RoJiYoZT1hKGIpLmZpbHRlcih0aGlzLml0ZW1zQ29udGFpbmVyU2VsZWN0b3IpLmVxKDApKSxlJiZlLmZpbmQodGhpcy5pdGVtU2VsZWN0b3IpLmVhY2goZnVuY3Rpb24oKXtoLnB1c2godGhpcyl9KSxnLmZpcmUoXCJsb2FkZWRcIixbYixoXSksYyYmKGY9K25ldyBEYXRlLWksZD5mP3NldFRpbWVvdXQoZnVuY3Rpb24oKXtjLmNhbGwoZyxiLGgpfSxkLWYpOmMuY2FsbChnLGIsaCkpfSxnKSxcImh0bWxcIil9LHRoaXMucmVuZGVyPWZ1bmN0aW9uKGIsYyl7dmFyIGQ9dGhpcyxlPXRoaXMuZ2V0TGFzdEl0ZW0oKSxmPTAsZz10aGlzLmZpcmUoXCJyZW5kZXJcIixbYl0pO2cuZG9uZShmdW5jdGlvbigpe2EoYikuaGlkZSgpLGUuYWZ0ZXIoYiksYShiKS5mYWRlSW4oNDAwLGZ1bmN0aW9uKCl7KytmPGIubGVuZ3RofHwoZC5maXJlKFwicmVuZGVyZWRcIixbYl0pLGMmJmMoKSl9KX0pfSx0aGlzLmhpZGVQYWdpbmF0aW9uPWZ1bmN0aW9uKCl7dGhpcy5wYWdpbmF0aW9uU2VsZWN0b3ImJmEodGhpcy5wYWdpbmF0aW9uU2VsZWN0b3IsdGhpcy4kY29udGFpbmVyKS5oaWRlKCl9LHRoaXMucmVzdG9yZVBhZ2luYXRpb249ZnVuY3Rpb24oKXt0aGlzLnBhZ2luYXRpb25TZWxlY3RvciYmYSh0aGlzLnBhZ2luYXRpb25TZWxlY3Rvcix0aGlzLiRjb250YWluZXIpLnNob3coKX0sdGhpcy50aHJvdHRsZT1mdW5jdGlvbihiLGMpe3ZhciBkLGUsZj0wO3JldHVybiBkPWZ1bmN0aW9uKCl7ZnVuY3Rpb24gYSgpe2Y9K25ldyBEYXRlLGIuYXBwbHkoZCxnKX12YXIgZD10aGlzLGc9YXJndW1lbnRzLGg9K25ldyBEYXRlLWY7ZT9jbGVhclRpbWVvdXQoZSk6YSgpLGg+Yz9hKCk6ZT1zZXRUaW1lb3V0KGEsYyl9LGEuZ3VpZCYmKGQuZ3VpZD1iLmd1aWQ9Yi5ndWlkfHxhLmd1aWQrKyksZH0sdGhpcy5maXJlPWZ1bmN0aW9uKGEsYil7cmV0dXJuIHRoaXMubGlzdGVuZXJzW2FdLmZpcmVXaXRoKHRoaXMsYil9LHRoaXMucGF1c2U9ZnVuY3Rpb24oKXt0aGlzLmlzUGF1c2VkPSEwfSx0aGlzLnJlc3VtZT1mdW5jdGlvbigpe3RoaXMuaXNQYXVzZWQ9ITF9LHRoaXN9O2MucHJvdG90eXBlLmluaXRpYWxpemU9ZnVuY3Rpb24oKXtpZih0aGlzLmlzSW5pdGlhbGl6ZWQpcmV0dXJuITE7dmFyIGE9ISEoXCJvbnNjcm9sbFwiaW4gdGhpcy4kc2Nyb2xsQ29udGFpbmVyLmdldCgwKSksYj10aGlzLmdldEN1cnJlbnRTY3JvbGxPZmZzZXQodGhpcy4kc2Nyb2xsQ29udGFpbmVyKSxjPXRoaXMuZ2V0U2Nyb2xsVGhyZXNob2xkKCk7cmV0dXJuIGE/KHRoaXMuaGlkZVBhZ2luYXRpb24oKSx0aGlzLmJpbmQoKSx0aGlzLmZpcmUoXCJyZWFkeVwiKSx0aGlzLm5leHRVcmw9dGhpcy5nZXROZXh0VXJsKCksYj49Yz8odGhpcy5uZXh0KCksdGhpcy5vbmUoXCJyZW5kZXJlZFwiLGZ1bmN0aW9uKCl7dGhpcy5pc0luaXRpYWxpemVkPSEwfSkpOnRoaXMuaXNJbml0aWFsaXplZD0hMCx0aGlzKTohMX0sYy5wcm90b3R5cGUucmVpbml0aWFsaXplPWZ1bmN0aW9uKCl7dGhpcy5pc0luaXRpYWxpemVkPSExLHRoaXMudW5iaW5kKCksdGhpcy5pbml0aWFsaXplKCl9LGMucHJvdG90eXBlLmJpbmQ9ZnVuY3Rpb24oKXtpZighdGhpcy5pc0JvdW5kKXt0aGlzLiRzY3JvbGxDb250YWluZXIub24oXCJzY3JvbGxcIixhLnByb3h5KHRoaXMudGhyb3R0bGUodGhpcy5zY3JvbGxIYW5kbGVyLDE1MCksdGhpcykpO2Zvcih2YXIgYj0wLGM9dGhpcy5leHRlbnNpb25zLmxlbmd0aDtjPmI7YisrKXRoaXMuZXh0ZW5zaW9uc1tiXS5iaW5kKHRoaXMpO3RoaXMuaXNCb3VuZD0hMCx0aGlzLnJlc3VtZSgpfX0sYy5wcm90b3R5cGUudW5iaW5kPWZ1bmN0aW9uKCl7aWYodGhpcy5pc0JvdW5kKXt0aGlzLiRzY3JvbGxDb250YWluZXIub2ZmKFwic2Nyb2xsXCIsdGhpcy5zY3JvbGxIYW5kbGVyKTtmb3IodmFyIGE9MCxiPXRoaXMuZXh0ZW5zaW9ucy5sZW5ndGg7Yj5hO2ErKylcInVuZGVmaW5lZFwiIT10eXBlb2YgdGhpcy5leHRlbnNpb25zW2FdLnVuYmluZCYmdGhpcy5leHRlbnNpb25zW2FdLnVuYmluZCh0aGlzKTt0aGlzLmlzQm91bmQ9ITF9fSxjLnByb3RvdHlwZS5kZXN0cm95PWZ1bmN0aW9uKCl7dGhpcy51bmJpbmQoKSx0aGlzLiRzY3JvbGxDb250YWluZXIuZGF0YShcImlhc1wiLG51bGwpfSxjLnByb3RvdHlwZS5vbj1mdW5jdGlvbihiLGMsZCl7aWYoXCJ1bmRlZmluZWRcIj09dHlwZW9mIHRoaXMubGlzdGVuZXJzW2JdKXRocm93IG5ldyBFcnJvcignVGhlcmUgaXMgbm8gZXZlbnQgY2FsbGVkIFwiJytiKydcIicpO3JldHVybiBkPWR8fDAsdGhpcy5saXN0ZW5lcnNbYl0uYWRkKGEucHJveHkoYyx0aGlzKSxkKSx0aGlzfSxjLnByb3RvdHlwZS5vbmU9ZnVuY3Rpb24oYSxiKXt2YXIgYz10aGlzLGQ9ZnVuY3Rpb24oKXtjLm9mZihhLGIpLGMub2ZmKGEsZCl9O3JldHVybiB0aGlzLm9uKGEsYiksdGhpcy5vbihhLGQpLHRoaXN9LGMucHJvdG90eXBlLm9mZj1mdW5jdGlvbihhLGIpe2lmKFwidW5kZWZpbmVkXCI9PXR5cGVvZiB0aGlzLmxpc3RlbmVyc1thXSl0aHJvdyBuZXcgRXJyb3IoJ1RoZXJlIGlzIG5vIGV2ZW50IGNhbGxlZCBcIicrYSsnXCInKTtyZXR1cm4gdGhpcy5saXN0ZW5lcnNbYV0ucmVtb3ZlKGIpLHRoaXN9LGMucHJvdG90eXBlLm5leHQ9ZnVuY3Rpb24oKXt2YXIgYT10aGlzLm5leHRVcmwsYj10aGlzO2lmKHRoaXMucGF1c2UoKSwhYSlyZXR1cm4gdGhpcy5maXJlKFwibm9uZUxlZnRcIixbdGhpcy5nZXRMYXN0SXRlbSgpXSksdGhpcy5saXN0ZW5lcnMubm9uZUxlZnQuZGlzYWJsZSgpLGIucmVzdW1lKCksITE7dmFyIGM9dGhpcy5maXJlKFwibmV4dFwiLFthXSk7cmV0dXJuIGMuZG9uZShmdW5jdGlvbigpe2IubG9hZChhLGZ1bmN0aW9uKGEsYyl7Yi5yZW5kZXIoYyxmdW5jdGlvbigpe2IubmV4dFVybD1iLmdldE5leHRVcmwoYSksYi5yZXN1bWUoKX0pfSl9KSxjLmZhaWwoZnVuY3Rpb24oKXtiLnJlc3VtZSgpfSksITB9LGMucHJvdG90eXBlLmV4dGVuc2lvbj1mdW5jdGlvbihhKXtpZihcInVuZGVmaW5lZFwiPT10eXBlb2YgYS5iaW5kKXRocm93IG5ldyBFcnJvcignRXh0ZW5zaW9uIGRvZXNuXFwndCBoYXZlIHJlcXVpcmVkIG1ldGhvZCBcImJpbmRcIicpO3JldHVyblwidW5kZWZpbmVkXCIhPXR5cGVvZiBhLmluaXRpYWxpemUmJmEuaW5pdGlhbGl6ZSh0aGlzKSx0aGlzLmV4dGVuc2lvbnMucHVzaChhKSx0aGlzLmlzSW5pdGlhbGl6ZWQmJnRoaXMucmVpbml0aWFsaXplKCksdGhpc30sYS5pYXM9ZnVuY3Rpb24oYil7dmFyIGM9YSh3aW5kb3cpO3JldHVybiBjLmlhcy5hcHBseShjLGFyZ3VtZW50cyl9LGEuZm4uaWFzPWZ1bmN0aW9uKGIpe3ZhciBkPUFycmF5LnByb3RvdHlwZS5zbGljZS5jYWxsKGFyZ3VtZW50cyksZT10aGlzO3JldHVybiB0aGlzLmVhY2goZnVuY3Rpb24oKXt2YXIgZj1hKHRoaXMpLGc9Zi5kYXRhKFwiaWFzXCIpLGg9YS5leHRlbmQoe30sYS5mbi5pYXMuZGVmYXVsdHMsZi5kYXRhKCksXCJvYmplY3RcIj09dHlwZW9mIGImJmIpO2lmKGd8fChmLmRhdGEoXCJpYXNcIixnPW5ldyBjKGYsaCkpLGEoZG9jdW1lbnQpLnJlYWR5KGEucHJveHkoZy5pbml0aWFsaXplLGcpKSksXCJzdHJpbmdcIj09dHlwZW9mIGIpe2lmKFwiZnVuY3Rpb25cIiE9dHlwZW9mIGdbYl0pdGhyb3cgbmV3IEVycm9yKCdUaGVyZSBpcyBubyBtZXRob2QgY2FsbGVkIFwiJytiKydcIicpO2Quc2hpZnQoKSxnW2JdLmFwcGx5KGcsZCl9ZT1nfSksZX0sYS5mbi5pYXMuZGVmYXVsdHM9e2l0ZW06XCIuaXRlbVwiLGNvbnRhaW5lcjpcIi5saXN0aW5nXCIsbmV4dDpcIi5uZXh0XCIscGFnaW5hdGlvbjohMSxkZWxheTo2MDAsbmVnYXRpdmVNYXJnaW46MTB9fShqUXVlcnkpO3ZhciBJQVNIaXN0b3J5RXh0ZW5zaW9uPWZ1bmN0aW9uKGEpe3JldHVybiBhPWpRdWVyeS5leHRlbmQoe30sdGhpcy5kZWZhdWx0cyxhKSx0aGlzLmlhcz1udWxsLHRoaXMucHJldlNlbGVjdG9yPWEucHJldix0aGlzLnByZXZVcmw9bnVsbCx0aGlzLmxpc3RlbmVycz17cHJldjpuZXcgSUFTQ2FsbGJhY2tzfSx0aGlzLm9uUGFnZUNoYW5nZT1mdW5jdGlvbihhLGIsYyl7aWYod2luZG93Lmhpc3RvcnkmJndpbmRvdy5oaXN0b3J5LnJlcGxhY2VTdGF0ZSl7dmFyIGQ9aGlzdG9yeS5zdGF0ZTtoaXN0b3J5LnJlcGxhY2VTdGF0ZShkLGRvY3VtZW50LnRpdGxlLGMpfX0sdGhpcy5vblNjcm9sbD1mdW5jdGlvbihhLGIpe3ZhciBjPXRoaXMuZ2V0U2Nyb2xsVGhyZXNob2xkRmlyc3RJdGVtKCk7dGhpcy5wcmV2VXJsJiYoYS09dGhpcy5pYXMuJHNjcm9sbENvbnRhaW5lci5oZWlnaHQoKSxjPj1hJiZ0aGlzLnByZXYoKSl9LHRoaXMub25SZWFkeT1mdW5jdGlvbigpe3ZhciBhPXRoaXMuaWFzLmdldEN1cnJlbnRTY3JvbGxPZmZzZXQodGhpcy5pYXMuJHNjcm9sbENvbnRhaW5lciksYj10aGlzLmdldFNjcm9sbFRocmVzaG9sZEZpcnN0SXRlbSgpO2EtPXRoaXMuaWFzLiRzY3JvbGxDb250YWluZXIuaGVpZ2h0KCksYj49YSYmdGhpcy5wcmV2KCl9LHRoaXMuZ2V0UHJldlVybD1mdW5jdGlvbihhKXtyZXR1cm4gYXx8KGE9dGhpcy5pYXMuJGNvbnRhaW5lciksalF1ZXJ5KHRoaXMucHJldlNlbGVjdG9yLGEpLmxhc3QoKS5hdHRyKFwiaHJlZlwiKX0sdGhpcy5nZXRTY3JvbGxUaHJlc2hvbGRGaXJzdEl0ZW09ZnVuY3Rpb24oKXt2YXIgYTtyZXR1cm4gYT10aGlzLmlhcy5nZXRGaXJzdEl0ZW0oKSwwPT09YS5sZW5ndGg/LTE6YS5vZmZzZXQoKS50b3B9LHRoaXMucmVuZGVyQmVmb3JlPWZ1bmN0aW9uKGEsYil7dmFyIGM9dGhpcy5pYXMsZD1jLmdldEZpcnN0SXRlbSgpLGU9MDtjLmZpcmUoXCJyZW5kZXJcIixbYV0pLGpRdWVyeShhKS5oaWRlKCksZC5iZWZvcmUoYSksalF1ZXJ5KGEpLmZhZGVJbig0MDAsZnVuY3Rpb24oKXsrK2U8YS5sZW5ndGh8fChjLmZpcmUoXCJyZW5kZXJlZFwiLFthXSksYiYmYigpKX0pfSx0aGlzfTtJQVNIaXN0b3J5RXh0ZW5zaW9uLnByb3RvdHlwZS5pbml0aWFsaXplPWZ1bmN0aW9uKGEpe3ZhciBiPXRoaXM7dGhpcy5pYXM9YSxqUXVlcnkuZXh0ZW5kKGEubGlzdGVuZXJzLHRoaXMubGlzdGVuZXJzKSxhLnByZXY9ZnVuY3Rpb24oKXtyZXR1cm4gYi5wcmV2KCl9LHRoaXMucHJldlVybD10aGlzLmdldFByZXZVcmwoKX0sSUFTSGlzdG9yeUV4dGVuc2lvbi5wcm90b3R5cGUuYmluZD1mdW5jdGlvbihhKXthLm9uKFwicGFnZUNoYW5nZVwiLGpRdWVyeS5wcm94eSh0aGlzLm9uUGFnZUNoYW5nZSx0aGlzKSksYS5vbihcInNjcm9sbFwiLGpRdWVyeS5wcm94eSh0aGlzLm9uU2Nyb2xsLHRoaXMpKSxhLm9uKFwicmVhZHlcIixqUXVlcnkucHJveHkodGhpcy5vblJlYWR5LHRoaXMpKX0sSUFTSGlzdG9yeUV4dGVuc2lvbi5wcm90b3R5cGUudW5iaW5kPWZ1bmN0aW9uKGEpe2Eub2ZmKFwicGFnZUNoYW5nZVwiLHRoaXMub25QYWdlQ2hhbmdlKSxhLm9mZihcInNjcm9sbFwiLHRoaXMub25TY3JvbGwpLGEub2ZmKFwicmVhZHlcIix0aGlzLm9uUmVhZHkpfSxJQVNIaXN0b3J5RXh0ZW5zaW9uLnByb3RvdHlwZS5wcmV2PWZ1bmN0aW9uKCl7dmFyIGE9dGhpcy5wcmV2VXJsLGI9dGhpcyxjPXRoaXMuaWFzO2lmKCFhKXJldHVybiExO2MucGF1c2UoKTt2YXIgZD1jLmZpcmUoXCJwcmV2XCIsW2FdKTtyZXR1cm4gZC5kb25lKGZ1bmN0aW9uKCl7Yy5sb2FkKGEsZnVuY3Rpb24oYSxkKXtiLnJlbmRlckJlZm9yZShkLGZ1bmN0aW9uKCl7Yi5wcmV2VXJsPWIuZ2V0UHJldlVybChhKSxjLnJlc3VtZSgpLGIucHJldlVybCYmYi5wcmV2KCl9KX0pfSksZC5mYWlsKGZ1bmN0aW9uKCl7Yy5yZXN1bWUoKX0pLCEwfSxJQVNIaXN0b3J5RXh0ZW5zaW9uLnByb3RvdHlwZS5kZWZhdWx0cz17cHJldjpcIi5wcmV2XCJ9O3ZhciBJQVNOb25lTGVmdEV4dGVuc2lvbj1mdW5jdGlvbihhKXtyZXR1cm4gYT1qUXVlcnkuZXh0ZW5kKHt9LHRoaXMuZGVmYXVsdHMsYSksdGhpcy5pYXM9bnVsbCx0aGlzLnVpZD0obmV3IERhdGUpLmdldFRpbWUoKSx0aGlzLmh0bWw9YS5odG1sLnJlcGxhY2UoXCJ7dGV4dH1cIixhLnRleHQpLHRoaXMuc2hvd05vbmVMZWZ0PWZ1bmN0aW9uKCl7dmFyIGE9alF1ZXJ5KHRoaXMuaHRtbCkuYXR0cihcImlkXCIsXCJpYXNfbm9uZWxlZnRfXCIrdGhpcy51aWQpLGI9dGhpcy5pYXMuZ2V0TGFzdEl0ZW0oKTtiLmFmdGVyKGEpLGEuZmFkZUluKCl9LHRoaXN9O0lBU05vbmVMZWZ0RXh0ZW5zaW9uLnByb3RvdHlwZS5iaW5kPWZ1bmN0aW9uKGEpe3RoaXMuaWFzPWEsYS5vbihcIm5vbmVMZWZ0XCIsalF1ZXJ5LnByb3h5KHRoaXMuc2hvd05vbmVMZWZ0LHRoaXMpKX0sSUFTTm9uZUxlZnRFeHRlbnNpb24ucHJvdG90eXBlLnVuYmluZD1mdW5jdGlvbihhKXthLm9mZihcIm5vbmVMZWZ0XCIsdGhpcy5zaG93Tm9uZUxlZnQpfSxJQVNOb25lTGVmdEV4dGVuc2lvbi5wcm90b3R5cGUuZGVmYXVsdHM9e3RleHQ6XCJZb3UgcmVhY2hlZCB0aGUgZW5kLlwiLGh0bWw6JzxkaXYgY2xhc3M9XCJpYXMtbm9uZWxlZnRcIiBzdHlsZT1cInRleHQtYWxpZ246IGNlbnRlcjtcIj57dGV4dH08L2Rpdj4nfTt2YXIgSUFTUGFnaW5nRXh0ZW5zaW9uPWZ1bmN0aW9uKCl7cmV0dXJuIHRoaXMuaWFzPW51bGwsdGhpcy5wYWdlYnJlYWtzPVtbMCxkb2N1bWVudC5sb2NhdGlvbi50b1N0cmluZygpXV0sdGhpcy5sYXN0UGFnZU51bT0xLHRoaXMuZW5hYmxlZD0hMCx0aGlzLmxpc3RlbmVycz17cGFnZUNoYW5nZTpuZXcgSUFTQ2FsbGJhY2tzfSx0aGlzLm9uU2Nyb2xsPWZ1bmN0aW9uKGEsYil7aWYodGhpcy5lbmFibGVkKXt2YXIgYyxkPXRoaXMuaWFzLGU9dGhpcy5nZXRDdXJyZW50UGFnZU51bShhKSxmPXRoaXMuZ2V0Q3VycmVudFBhZ2VicmVhayhhKTt0aGlzLmxhc3RQYWdlTnVtIT09ZSYmKGM9ZlsxXSxkLmZpcmUoXCJwYWdlQ2hhbmdlXCIsW2UsYSxjXSkpLHRoaXMubGFzdFBhZ2VOdW09ZX19LHRoaXMub25OZXh0PWZ1bmN0aW9uKGEpe3ZhciBiPXRoaXMuaWFzLmdldEN1cnJlbnRTY3JvbGxPZmZzZXQodGhpcy5pYXMuJHNjcm9sbENvbnRhaW5lcik7dGhpcy5wYWdlYnJlYWtzLnB1c2goW2IsYV0pO3ZhciBjPXRoaXMuZ2V0Q3VycmVudFBhZ2VOdW0oYikrMTt0aGlzLmlhcy5maXJlKFwicGFnZUNoYW5nZVwiLFtjLGIsYV0pLHRoaXMubGFzdFBhZ2VOdW09Y30sdGhpcy5vblByZXY9ZnVuY3Rpb24oYSl7dmFyIGI9dGhpcyxjPWIuaWFzLGQ9Yy5nZXRDdXJyZW50U2Nyb2xsT2Zmc2V0KGMuJHNjcm9sbENvbnRhaW5lciksZT1kLWMuJHNjcm9sbENvbnRhaW5lci5oZWlnaHQoKSxmPWMuZ2V0Rmlyc3RJdGVtKCk7dGhpcy5lbmFibGVkPSExLHRoaXMucGFnZWJyZWFrcy51bnNoaWZ0KFswLGFdKSxjLm9uZShcInJlbmRlcmVkXCIsZnVuY3Rpb24oKXtmb3IodmFyIGQ9MSxnPWIucGFnZWJyZWFrcy5sZW5ndGg7Zz5kO2QrKyliLnBhZ2VicmVha3NbZF1bMF09Yi5wYWdlYnJlYWtzW2RdWzBdK2Yub2Zmc2V0KCkudG9wO3ZhciBoPWIuZ2V0Q3VycmVudFBhZ2VOdW0oZSkrMTtjLmZpcmUoXCJwYWdlQ2hhbmdlXCIsW2gsZSxhXSksYi5sYXN0UGFnZU51bT1oLGIuZW5hYmxlZD0hMH0pfSx0aGlzfTtJQVNQYWdpbmdFeHRlbnNpb24ucHJvdG90eXBlLmluaXRpYWxpemU9ZnVuY3Rpb24oYSl7dGhpcy5pYXM9YSxqUXVlcnkuZXh0ZW5kKGEubGlzdGVuZXJzLHRoaXMubGlzdGVuZXJzKX0sSUFTUGFnaW5nRXh0ZW5zaW9uLnByb3RvdHlwZS5iaW5kPWZ1bmN0aW9uKGEpe3RyeXthLm9uKFwicHJldlwiLGpRdWVyeS5wcm94eSh0aGlzLm9uUHJldix0aGlzKSx0aGlzLnByaW9yaXR5KX1jYXRjaChiKXt9YS5vbihcIm5leHRcIixqUXVlcnkucHJveHkodGhpcy5vbk5leHQsdGhpcyksdGhpcy5wcmlvcml0eSksYS5vbihcInNjcm9sbFwiLGpRdWVyeS5wcm94eSh0aGlzLm9uU2Nyb2xsLHRoaXMpLHRoaXMucHJpb3JpdHkpfSxJQVNQYWdpbmdFeHRlbnNpb24ucHJvdG90eXBlLnVuYmluZD1mdW5jdGlvbihhKXt0cnl7YS5vZmYoXCJwcmV2XCIsdGhpcy5vblByZXYpfWNhdGNoKGIpe31hLm9mZihcIm5leHRcIix0aGlzLm9uTmV4dCksYS5vZmYoXCJzY3JvbGxcIix0aGlzLm9uU2Nyb2xsKX0sSUFTUGFnaW5nRXh0ZW5zaW9uLnByb3RvdHlwZS5nZXRDdXJyZW50UGFnZU51bT1mdW5jdGlvbihhKXtmb3IodmFyIGI9dGhpcy5wYWdlYnJlYWtzLmxlbmd0aC0xO2I+MDtiLS0paWYoYT50aGlzLnBhZ2VicmVha3NbYl1bMF0pcmV0dXJuIGIrMTtyZXR1cm4gMX0sSUFTUGFnaW5nRXh0ZW5zaW9uLnByb3RvdHlwZS5nZXRDdXJyZW50UGFnZWJyZWFrPWZ1bmN0aW9uKGEpe2Zvcih2YXIgYj10aGlzLnBhZ2VicmVha3MubGVuZ3RoLTE7Yj49MDtiLS0paWYoYT50aGlzLnBhZ2VicmVha3NbYl1bMF0pcmV0dXJuIHRoaXMucGFnZWJyZWFrc1tiXTtyZXR1cm4gbnVsbH0sSUFTUGFnaW5nRXh0ZW5zaW9uLnByb3RvdHlwZS5wcmlvcml0eT01MDA7dmFyIElBU1NwaW5uZXJFeHRlbnNpb249ZnVuY3Rpb24oYSl7cmV0dXJuIGE9alF1ZXJ5LmV4dGVuZCh7fSx0aGlzLmRlZmF1bHRzLGEpLHRoaXMuaWFzPW51bGwsdGhpcy51aWQ9KG5ldyBEYXRlKS5nZXRUaW1lKCksdGhpcy5zcmM9YS5zcmMsdGhpcy5odG1sPWEuaHRtbC5yZXBsYWNlKFwie3NyY31cIix0aGlzLnNyYyksdGhpcy5zaG93U3Bpbm5lcj1mdW5jdGlvbigpe3ZhciBhPXRoaXMuZ2V0U3Bpbm5lcigpfHx0aGlzLmNyZWF0ZVNwaW5uZXIoKSxiPXRoaXMuaWFzLmdldExhc3RJdGVtKCk7Yi5hZnRlcihhKSxhLmZhZGVJbigpfSx0aGlzLnNob3dTcGlubmVyQmVmb3JlPWZ1bmN0aW9uKCl7dmFyIGE9dGhpcy5nZXRTcGlubmVyKCl8fHRoaXMuY3JlYXRlU3Bpbm5lcigpLGI9dGhpcy5pYXMuZ2V0Rmlyc3RJdGVtKCk7Yi5iZWZvcmUoYSksYS5mYWRlSW4oKX0sdGhpcy5yZW1vdmVTcGlubmVyPWZ1bmN0aW9uKCl7dGhpcy5oYXNTcGlubmVyKCkmJnRoaXMuZ2V0U3Bpbm5lcigpLnJlbW92ZSgpfSx0aGlzLmdldFNwaW5uZXI9ZnVuY3Rpb24oKXt2YXIgYT1qUXVlcnkoXCIjaWFzX3NwaW5uZXJfXCIrdGhpcy51aWQpO3JldHVybiBhLmxlbmd0aD4wP2E6ITF9LHRoaXMuaGFzU3Bpbm5lcj1mdW5jdGlvbigpe3ZhciBhPWpRdWVyeShcIiNpYXNfc3Bpbm5lcl9cIit0aGlzLnVpZCk7cmV0dXJuIGEubGVuZ3RoPjB9LHRoaXMuY3JlYXRlU3Bpbm5lcj1mdW5jdGlvbigpe3ZhciBhPWpRdWVyeSh0aGlzLmh0bWwpLmF0dHIoXCJpZFwiLFwiaWFzX3NwaW5uZXJfXCIrdGhpcy51aWQpO3JldHVybiBhLmhpZGUoKSxhfSx0aGlzfTtJQVNTcGlubmVyRXh0ZW5zaW9uLnByb3RvdHlwZS5iaW5kPWZ1bmN0aW9uKGEpe3RoaXMuaWFzPWEsYS5vbihcIm5leHRcIixqUXVlcnkucHJveHkodGhpcy5zaG93U3Bpbm5lcix0aGlzKSksYS5vbihcInJlbmRlclwiLGpRdWVyeS5wcm94eSh0aGlzLnJlbW92ZVNwaW5uZXIsdGhpcykpO3RyeXthLm9uKFwicHJldlwiLGpRdWVyeS5wcm94eSh0aGlzLnNob3dTcGlubmVyQmVmb3JlLHRoaXMpKX1jYXRjaChiKXt9fSxJQVNTcGlubmVyRXh0ZW5zaW9uLnByb3RvdHlwZS51bmJpbmQ9ZnVuY3Rpb24oYSl7YS5vZmYoXCJuZXh0XCIsdGhpcy5zaG93U3Bpbm5lciksYS5vZmYoXCJyZW5kZXJcIix0aGlzLnJlbW92ZVNwaW5uZXIpO3RyeXthLm9mZihcInByZXZcIix0aGlzLnNob3dTcGlubmVyQmVmb3JlKX1jYXRjaChiKXt9fSxJQVNTcGlubmVyRXh0ZW5zaW9uLnByb3RvdHlwZS5kZWZhdWx0cz17c3JjOlwiZGF0YTppbWFnZS9naWY7YmFzZTY0LFIwbEdPRGxoRUFBUUFQUUFBUC8vL3dBQUFQRHc4SXFLaXVEZzRFWkdSbnA2ZWdBQUFGaFlXQ1FrSkt5c3JMNit2aFFVRkp5Y25BUUVCRFkyTm1ob2FBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFDSC9DMDVGVkZORFFWQkZNaTR3QXdFQUFBQWgvaHBEY21WaGRHVmtJSGRwZEdnZ1lXcGhlR3h2WVdRdWFXNW1id0FoK1FRSkNnQUFBQ3dBQUFBQUVBQVFBQUFGZHlBZ0FnSUpJZVdvQWtSQ0NNZEJrS3RJSEluZ3lNS3NFclBCWWJBRHBrU0N3aERtUUNCZXRoUkI2Vmo0a0ZDa1FQRzRJbFdEZ3JOUkl3bk80VUtCWER1ZnpRdkRNYW9TREJnRmI4ODZNaVFhZGdOQUJBb2tmQ3d6QkE4TENnMEVnbDhqQWdnR0FBMWtCSUExQkFZemx5SUxjelVMQzJVaEFDSDVCQWtLQUFBQUxBQUFBQUFRQUJBQUFBVjJJQ0FDQW1sQVpUbU9SRUVJeVVFUWpMS0t4UEhBRGhFdnF4bGdjR2drR0kxRFlTVkFJQVdNeCtsd1NLa0lDSjBRc0hpOVJnS0J3blZUaVJRUWd3RjRJNFVGRFFRRXdpNi8zWVNHV1JSbWpoRUVUQUpmSWdNRkNuQUtNMEtEVjRFRUVBUUxpRjE4VEFZTlhEYVNlM3g2bWppZE4xczNJUUFoK1FRSkNnQUFBQ3dBQUFBQUVBQVFBQUFGZUNBZ0FnTFpER1U1amdSRUNFVWlDSSt5aW9TRHdESnlMS3NYb0hGUXhCU0hBb0FBRkJocXRNSmc4RGdRQmdmckVzSkFFQWc0WWhaSUVpd2dLdEhpTUJndHBnM3diVVpYR083a09iMU1VS1JGTXlzQ0NoQW9nZ0pDSWcwR0MyYU5lNGdxUWxkZkw0bC9BZzFBWHlTSmduNUxjb0UzUVhJM0lRQWgrUVFKQ2dBQUFDd0FBQUFBRUFBUUFBQUZkaUFnQWdMWk5HVTVqb1FoQ0VqeElzc3FFbzhiQzlCUmp5OUFnN0dJTFE0UUVvRTBnQkFFQmNPcGNCQTBEb3hTSy9lOExSSUhuK2kxY0swSXlLZGcwVkFvbGpZSWcrR2duUnJ3VlMvOElBa0lDeW9zQklRcEJBTW9LeTlkSW14UGhTK0dLa0Zya1grVGlndExsSXlLWFVGK05qYWdOaUVBSWZrRUNRb0FBQUFzQUFBQUFCQUFFQUFBQld3Z0lBSUNhUmhsT1k0RUlnakg4UjdMS2hLSEd3c012YjRBQXkzV09EQklCQktDc1lBOVRqdWhETkRLRVZTRVJlelFFTDBXcmhYdWNSVVFHdWlrN2JGbG5nenFWVzlMTWw5WFd2TGRqRmFKdERGcVoxY0VaVUIwZFVndkwzZGdQNFdKWm40amtvbVdOcFNUSXlFQUlma0VDUW9BQUFBc0FBQUFBQkFBRUFBQUJYNGdJQUlDdVN4bE9ZNkNJZ2lEOFJyRUtncUdPd3h3VXJNbEFvU3dJekFHcEpwZ29TREFHaWZEWTVrb3BCWURsRXBBUUJ3ZXZ4ZkJ0UklVR2k4eHdXa0ROQkNJd21DOVZxMGFpUVFEUXVLK1ZnUVBEWFY5aENKakJ3Y0ZZVTVwTHd3SFhRY01LU21OTFFjSUFFeGxiSDhKQnd0dGFYMEFCQWNOYldWYkt5RUFJZmtFQ1FvQUFBQXNBQUFBQUJBQUVBQUFCWGtnSUFJQ1NSQmxPWTdDSWdoTjh6YkVLc0tvSWpkRnpaYUVnVUJIS0NoTUp0UndjV3BBV29XbmlmbTZFU0FNaE84bFFLMEVFQVYzckZvcElCQ0VjR3dES0FxUGg0SFVyWTRJQ0hIMWRTb1RGZ2NIVWlaakJoQUpCMkFIRHlrcEtBd0hBd2R6ZjE5S2tBU0lQbDljRGdjbkRrZHROd2lNSkNzaEFDSDVCQWtLQUFBQUxBQUFBQUFRQUJBQUFBVjNJQ0FDQWtrUVpUbU9BaW9zaXlBb3hDcStLUHhDTlZzU01SZ0JzaUNsV3JMVFNXRm9JUVpIbDZwbGVCaDZzdXhLTUlobHZ6YkF3a0JXZkZXckJRVHhOTHEyUkcyeWhTVWtEczJiNjNBWURBb0pYQWNGUndBRGVBa0pEWDBBUUNzRWZBUU1EQUlQQnowckNnY3hreTBKUldFMUFtd3BLeUVBSWZrRUNRb0FBQUFzQUFBQUFCQUFFQUFBQlhrZ0lBSUNLWnprcUo0blFaeExxWkt2NE5xTkxLSzIvUTRFazRsRlhDaHNnNXlwSmpzMUlJM2dFRFVTUkluRUdZQXc2QjZ6TTRKaHJEQXRFb3NWa0xVdEhBN1JIYUhBR0pRRWpzT0RjRWcwRkJBRlZna1FKUTFwQXdjRER3OEtjRnRTSW53SkFvd0NDQTZSSXdxWkFna1BOZ1ZwV25kamR5b2hBQ0g1QkFrS0FBQUFMQUFBQUFBUUFCQUFBQVY1SUNBQ0FpbWM1S2llTEV1VUt2bTJ4QUtMcURDZkMyR2FPOWVMMExBQldUaUJZbUEwNlc2a0hndkNxRUppQUlKaXUzZ2N2Z1Vzc2NIVUVSbStrYUN4eXhhK3pSUGswU2dKRWdmSXZiQWRJQVFMQ0FZbENqNERCdzBJQlFzTUNqSXFCQWNQQW9vQ0JnOXBLZ3NKTHdVRk9oQ1pLeVFEQTNZcUlRQWgrUVFKQ2dBQUFDd0FBQUFBRUFBUUFBQUZkU0FnQWdJcG5PU29ubXhicWlUaENySktFSEZibzhKeERET1pZRkZiK0E0MUU0SDRPaGtPaXBYd0JFbFlJVERBY2tGRU9CZ01RM2Fya01rVUJkeElVR1pwRWI3a2FRQlJsQVNQZzBGUVFIQWJFRU1HRFNWRUFBMVFCaEFFRDFFME5nd0ZBb29DRFdsamFRSVFDRTVxTUhjTmhDa2pJUUFoK1FRSkNnQUFBQ3dBQUFBQUVBQVFBQUFGZVNBZ0FnSXBuT1NvTGd4eHZxZ0tMRWNDQzY1S0VBQnlLSzhjU3BBNERBaUhRL0RrS2hHS2g0WkN0Q3laR282RjZpWVlQQXFGZ1l5MDJ4a1NhTEVNVjM0dEVMeVJZTkVzQ1F5SGx2V2tHQ3pzUGdNQ0VBWTdDZzA0VWs0OExBc0RoUkE4TVZRUEVGMEdBZ3FZWXdTUmx5Y05jV3NrQ2tBcEl5RUFPd0FBQUFBQUFBQUFBQT09XCIsaHRtbDonPGRpdiBjbGFzcz1cImlhcy1zcGlubmVyXCIgc3R5bGU9XCJ0ZXh0LWFsaWduOiBjZW50ZXI7XCI+PGltZyBzcmM9XCJ7c3JjfVwiLz48L2Rpdj4nfTt2YXIgSUFTVHJpZ2dlckV4dGVuc2lvbj1mdW5jdGlvbihhKXtyZXR1cm4gYT1qUXVlcnkuZXh0ZW5kKHt9LHRoaXMuZGVmYXVsdHMsYSksdGhpcy5pYXM9bnVsbCx0aGlzLmh0bWw9YS5odG1sLnJlcGxhY2UoXCJ7dGV4dH1cIixhLnRleHQpLHRoaXMuaHRtbFByZXY9YS5odG1sUHJldi5yZXBsYWNlKFwie3RleHR9XCIsYS50ZXh0UHJldiksdGhpcy5lbmFibGVkPSEwLHRoaXMuY291bnQ9MCx0aGlzLm9mZnNldD1hLm9mZnNldCx0aGlzLiR0cmlnZ2VyTmV4dD1udWxsLHRoaXMuJHRyaWdnZXJQcmV2PW51bGwsdGhpcy5zaG93VHJpZ2dlck5leHQ9ZnVuY3Rpb24oKXtpZighdGhpcy5lbmFibGVkKXJldHVybiEwO2lmKCExPT09dGhpcy5vZmZzZXR8fCsrdGhpcy5jb3VudDx0aGlzLm9mZnNldClyZXR1cm4hMDt2YXIgYT10aGlzLiR0cmlnZ2VyTmV4dHx8KHRoaXMuJHRyaWdnZXJOZXh0PXRoaXMuY3JlYXRlVHJpZ2dlcih0aGlzLm5leHQsdGhpcy5odG1sKSksYj10aGlzLmlhcy5nZXRMYXN0SXRlbSgpO3JldHVybiBiLmFmdGVyKGEpLGEuZmFkZUluKCksITF9LHRoaXMuc2hvd1RyaWdnZXJQcmV2PWZ1bmN0aW9uKCl7aWYoIXRoaXMuZW5hYmxlZClyZXR1cm4hMDt2YXIgYT10aGlzLiR0cmlnZ2VyUHJldnx8KHRoaXMuJHRyaWdnZXJQcmV2PXRoaXMuY3JlYXRlVHJpZ2dlcih0aGlzLnByZXYsdGhpcy5odG1sUHJldikpLGI9dGhpcy5pYXMuZ2V0Rmlyc3RJdGVtKCk7cmV0dXJuIGIuYmVmb3JlKGEpLGEuZmFkZUluKCksITF9LHRoaXMub25SZW5kZXJlZD1mdW5jdGlvbigpe3RoaXMuZW5hYmxlZD0hMH0sdGhpcy5jcmVhdGVUcmlnZ2VyPWZ1bmN0aW9uKGEsYil7dmFyIGMsZD0obmV3IERhdGUpLmdldFRpbWUoKTtyZXR1cm4gYj1ifHx0aGlzLmh0bWwsYz1qUXVlcnkoYikuYXR0cihcImlkXCIsXCJpYXNfdHJpZ2dlcl9cIitkKSxjLmhpZGUoKSxjLm9uKFwiY2xpY2tcIixqUXVlcnkucHJveHkoYSx0aGlzKSksY30sdGhpc307SUFTVHJpZ2dlckV4dGVuc2lvbi5wcm90b3R5cGUuYmluZD1mdW5jdGlvbihhKXt0aGlzLmlhcz1hLGEub24oXCJuZXh0XCIsalF1ZXJ5LnByb3h5KHRoaXMuc2hvd1RyaWdnZXJOZXh0LHRoaXMpLHRoaXMucHJpb3JpdHkpLGEub24oXCJyZW5kZXJlZFwiLGpRdWVyeS5wcm94eSh0aGlzLm9uUmVuZGVyZWQsdGhpcyksdGhpcy5wcmlvcml0eSk7dHJ5e2Eub24oXCJwcmV2XCIsalF1ZXJ5LnByb3h5KHRoaXMuc2hvd1RyaWdnZXJQcmV2LHRoaXMpLHRoaXMucHJpb3JpdHkpfWNhdGNoKGIpe319LElBU1RyaWdnZXJFeHRlbnNpb24ucHJvdG90eXBlLnVuYmluZD1mdW5jdGlvbihhKXthLm9mZihcIm5leHRcIix0aGlzLnNob3dUcmlnZ2VyTmV4dCksYS5vZmYoXCJyZW5kZXJlZFwiLHRoaXMub25SZW5kZXJlZCk7dHJ5e2Eub2ZmKFwicHJldlwiLHRoaXMuc2hvd1RyaWdnZXJQcmV2KX1jYXRjaChiKXt9fSxJQVNUcmlnZ2VyRXh0ZW5zaW9uLnByb3RvdHlwZS5uZXh0PWZ1bmN0aW9uKCl7dGhpcy5lbmFibGVkPSExLHRoaXMuaWFzLnBhdXNlKCksdGhpcy4kdHJpZ2dlck5leHQmJih0aGlzLiR0cmlnZ2VyTmV4dC5yZW1vdmUoKSx0aGlzLiR0cmlnZ2VyTmV4dD1udWxsKSx0aGlzLmlhcy5uZXh0KCl9LElBU1RyaWdnZXJFeHRlbnNpb24ucHJvdG90eXBlLnByZXY9ZnVuY3Rpb24oKXt0aGlzLmVuYWJsZWQ9ITEsdGhpcy5pYXMucGF1c2UoKSx0aGlzLiR0cmlnZ2VyUHJldiYmKHRoaXMuJHRyaWdnZXJQcmV2LnJlbW92ZSgpLHRoaXMuJHRyaWdnZXJQcmV2PW51bGwpLHRoaXMuaWFzLnByZXYoKX0sSUFTVHJpZ2dlckV4dGVuc2lvbi5wcm90b3R5cGUuZGVmYXVsdHM9e3RleHQ6XCJMb2FkIG1vcmUgaXRlbXNcIixodG1sOic8ZGl2IGNsYXNzPVwiaWFzLXRyaWdnZXIgaWFzLXRyaWdnZXItbmV4dFwiIHN0eWxlPVwidGV4dC1hbGlnbjogY2VudGVyOyBjdXJzb3I6IHBvaW50ZXI7XCI+PGE+e3RleHR9PC9hPjwvZGl2PicsdGV4dFByZXY6XCJMb2FkIHByZXZpb3VzIGl0ZW1zXCIsaHRtbFByZXY6JzxkaXYgY2xhc3M9XCJpYXMtdHJpZ2dlciBpYXMtdHJpZ2dlci1wcmV2XCIgc3R5bGU9XCJ0ZXh0LWFsaWduOiBjZW50ZXI7IGN1cnNvcjogcG9pbnRlcjtcIj48YT57dGV4dH08L2E+PC9kaXY+JyxvZmZzZXQ6MH0sSUFTVHJpZ2dlckV4dGVuc2lvbi5wcm90b3R5cGUucHJpb3JpdHk9MWUzOyIsIi8qIVxuICogTGlnaHRib3ggdjIuOC4yXG4gKiBieSBMb2tlc2ggRGhha2FyXG4gKlxuICogTW9yZSBpbmZvOlxuICogaHR0cDovL2xva2VzaGRoYWthci5jb20vcHJvamVjdHMvbGlnaHRib3gyL1xuICpcbiAqIENvcHlyaWdodCAyMDA3LCAyMDE1IExva2VzaCBEaGFrYXJcbiAqIFJlbGVhc2VkIHVuZGVyIHRoZSBNSVQgbGljZW5zZVxuICogaHR0cHM6Ly9naXRodWIuY29tL2xva2VzaC9saWdodGJveDIvYmxvYi9tYXN0ZXIvTElDRU5TRVxuICovXG4hZnVuY3Rpb24oYSxiKXtcImZ1bmN0aW9uXCI9PXR5cGVvZiBkZWZpbmUmJmRlZmluZS5hbWQ/ZGVmaW5lKFtcImpxdWVyeVwiXSxiKTpcIm9iamVjdFwiPT10eXBlb2YgZXhwb3J0cz9tb2R1bGUuZXhwb3J0cz1iKHJlcXVpcmUoXCJqcXVlcnlcIikpOmEubGlnaHRib3g9YihhLmpRdWVyeSl9KHRoaXMsZnVuY3Rpb24oYSl7ZnVuY3Rpb24gYihiKXt0aGlzLmFsYnVtPVtdLHRoaXMuY3VycmVudEltYWdlSW5kZXg9dm9pZCAwLHRoaXMuaW5pdCgpLHRoaXMub3B0aW9ucz1hLmV4dGVuZCh7fSx0aGlzLmNvbnN0cnVjdG9yLmRlZmF1bHRzKSx0aGlzLm9wdGlvbihiKX1yZXR1cm4gYi5kZWZhdWx0cz17YWxidW1MYWJlbDpcIkltYWdlICUxIG9mICUyXCIsYWx3YXlzU2hvd05hdk9uVG91Y2hEZXZpY2VzOiExLGZhZGVEdXJhdGlvbjo1MDAsZml0SW1hZ2VzSW5WaWV3cG9ydDohMCxwb3NpdGlvbkZyb21Ub3A6NTAscmVzaXplRHVyYXRpb246NzAwLHNob3dJbWFnZU51bWJlckxhYmVsOiEwLHdyYXBBcm91bmQ6ITEsZGlzYWJsZVNjcm9sbGluZzohMX0sYi5wcm90b3R5cGUub3B0aW9uPWZ1bmN0aW9uKGIpe2EuZXh0ZW5kKHRoaXMub3B0aW9ucyxiKX0sYi5wcm90b3R5cGUuaW1hZ2VDb3VudExhYmVsPWZ1bmN0aW9uKGEsYil7cmV0dXJuIHRoaXMub3B0aW9ucy5hbGJ1bUxhYmVsLnJlcGxhY2UoLyUxL2csYSkucmVwbGFjZSgvJTIvZyxiKX0sYi5wcm90b3R5cGUuaW5pdD1mdW5jdGlvbigpe3RoaXMuZW5hYmxlKCksdGhpcy5idWlsZCgpfSxiLnByb3RvdHlwZS5lbmFibGU9ZnVuY3Rpb24oKXt2YXIgYj10aGlzO2EoXCJib2R5XCIpLm9uKFwiY2xpY2tcIixcImFbcmVsXj1saWdodGJveF0sIGFyZWFbcmVsXj1saWdodGJveF0sIGFbZGF0YS1saWdodGJveF0sIGFyZWFbZGF0YS1saWdodGJveF1cIixmdW5jdGlvbihjKXtyZXR1cm4gYi5zdGFydChhKGMuY3VycmVudFRhcmdldCkpLCExfSl9LGIucHJvdG90eXBlLmJ1aWxkPWZ1bmN0aW9uKCl7dmFyIGI9dGhpczthKCc8ZGl2IGlkPVwibGlnaHRib3hPdmVybGF5XCIgY2xhc3M9XCJsaWdodGJveE92ZXJsYXlcIj48L2Rpdj48ZGl2IGlkPVwibGlnaHRib3hcIiBjbGFzcz1cImxpZ2h0Ym94XCI+PGRpdiBjbGFzcz1cImxiLW91dGVyQ29udGFpbmVyXCI+PGRpdiBjbGFzcz1cImxiLWNvbnRhaW5lclwiPjxpbWcgY2xhc3M9XCJsYi1pbWFnZVwiIHNyYz1cImRhdGE6aW1hZ2UvZ2lmO2Jhc2U2NCxSMGxHT0RsaEFRQUJBSUFBQVAvLy93QUFBQ0g1QkFFQUFBQUFMQUFBQUFBQkFBRUFBQUlDUkFFQU93PT1cIiAvPjxkaXYgY2xhc3M9XCJsYi1uYXZcIj48YSBjbGFzcz1cImxiLXByZXZcIiBocmVmPVwiXCIgPjwvYT48YSBjbGFzcz1cImxiLW5leHRcIiBocmVmPVwiXCIgPjwvYT48L2Rpdj48ZGl2IGNsYXNzPVwibGItbG9hZGVyXCI+PGEgY2xhc3M9XCJsYi1jYW5jZWxcIj48L2E+PC9kaXY+PC9kaXY+PC9kaXY+PGRpdiBjbGFzcz1cImxiLWRhdGFDb250YWluZXJcIj48ZGl2IGNsYXNzPVwibGItZGF0YVwiPjxkaXYgY2xhc3M9XCJsYi1kZXRhaWxzXCI+PHNwYW4gY2xhc3M9XCJsYi1jYXB0aW9uXCI+PC9zcGFuPjxzcGFuIGNsYXNzPVwibGItbnVtYmVyXCI+PC9zcGFuPjwvZGl2PjxkaXYgY2xhc3M9XCJsYi1jbG9zZUNvbnRhaW5lclwiPjxhIGNsYXNzPVwibGItY2xvc2VcIj48L2E+PC9kaXY+PC9kaXY+PC9kaXY+PC9kaXY+JykuYXBwZW5kVG8oYShcImJvZHlcIikpLHRoaXMuJGxpZ2h0Ym94PWEoXCIjbGlnaHRib3hcIiksdGhpcy4kb3ZlcmxheT1hKFwiI2xpZ2h0Ym94T3ZlcmxheVwiKSx0aGlzLiRvdXRlckNvbnRhaW5lcj10aGlzLiRsaWdodGJveC5maW5kKFwiLmxiLW91dGVyQ29udGFpbmVyXCIpLHRoaXMuJGNvbnRhaW5lcj10aGlzLiRsaWdodGJveC5maW5kKFwiLmxiLWNvbnRhaW5lclwiKSx0aGlzLmNvbnRhaW5lclRvcFBhZGRpbmc9cGFyc2VJbnQodGhpcy4kY29udGFpbmVyLmNzcyhcInBhZGRpbmctdG9wXCIpLDEwKSx0aGlzLmNvbnRhaW5lclJpZ2h0UGFkZGluZz1wYXJzZUludCh0aGlzLiRjb250YWluZXIuY3NzKFwicGFkZGluZy1yaWdodFwiKSwxMCksdGhpcy5jb250YWluZXJCb3R0b21QYWRkaW5nPXBhcnNlSW50KHRoaXMuJGNvbnRhaW5lci5jc3MoXCJwYWRkaW5nLWJvdHRvbVwiKSwxMCksdGhpcy5jb250YWluZXJMZWZ0UGFkZGluZz1wYXJzZUludCh0aGlzLiRjb250YWluZXIuY3NzKFwicGFkZGluZy1sZWZ0XCIpLDEwKSx0aGlzLiRvdmVybGF5LmhpZGUoKS5vbihcImNsaWNrXCIsZnVuY3Rpb24oKXtyZXR1cm4gYi5lbmQoKSwhMX0pLHRoaXMuJGxpZ2h0Ym94LmhpZGUoKS5vbihcImNsaWNrXCIsZnVuY3Rpb24oYyl7cmV0dXJuXCJsaWdodGJveFwiPT09YShjLnRhcmdldCkuYXR0cihcImlkXCIpJiZiLmVuZCgpLCExfSksdGhpcy4kb3V0ZXJDb250YWluZXIub24oXCJjbGlja1wiLGZ1bmN0aW9uKGMpe3JldHVyblwibGlnaHRib3hcIj09PWEoYy50YXJnZXQpLmF0dHIoXCJpZFwiKSYmYi5lbmQoKSwhMX0pLHRoaXMuJGxpZ2h0Ym94LmZpbmQoXCIubGItcHJldlwiKS5vbihcImNsaWNrXCIsZnVuY3Rpb24oKXtyZXR1cm4gMD09PWIuY3VycmVudEltYWdlSW5kZXg/Yi5jaGFuZ2VJbWFnZShiLmFsYnVtLmxlbmd0aC0xKTpiLmNoYW5nZUltYWdlKGIuY3VycmVudEltYWdlSW5kZXgtMSksITF9KSx0aGlzLiRsaWdodGJveC5maW5kKFwiLmxiLW5leHRcIikub24oXCJjbGlja1wiLGZ1bmN0aW9uKCl7cmV0dXJuIGIuY3VycmVudEltYWdlSW5kZXg9PT1iLmFsYnVtLmxlbmd0aC0xP2IuY2hhbmdlSW1hZ2UoMCk6Yi5jaGFuZ2VJbWFnZShiLmN1cnJlbnRJbWFnZUluZGV4KzEpLCExfSksdGhpcy4kbGlnaHRib3guZmluZChcIi5sYi1sb2FkZXIsIC5sYi1jbG9zZVwiKS5vbihcImNsaWNrXCIsZnVuY3Rpb24oKXtyZXR1cm4gYi5lbmQoKSwhMX0pfSxiLnByb3RvdHlwZS5zdGFydD1mdW5jdGlvbihiKXtmdW5jdGlvbiBjKGEpe2QuYWxidW0ucHVzaCh7bGluazphLmF0dHIoXCJocmVmXCIpLHRpdGxlOmEuYXR0cihcImRhdGEtdGl0bGVcIil8fGEuYXR0cihcInRpdGxlXCIpfSl9dmFyIGQ9dGhpcyxlPWEod2luZG93KTtlLm9uKFwicmVzaXplXCIsYS5wcm94eSh0aGlzLnNpemVPdmVybGF5LHRoaXMpKSxhKFwic2VsZWN0LCBvYmplY3QsIGVtYmVkXCIpLmNzcyh7dmlzaWJpbGl0eTpcImhpZGRlblwifSksdGhpcy5zaXplT3ZlcmxheSgpLHRoaXMuYWxidW09W107dmFyIGYsZz0wLGg9Yi5hdHRyKFwiZGF0YS1saWdodGJveFwiKTtpZihoKXtmPWEoYi5wcm9wKFwidGFnTmFtZVwiKSsnW2RhdGEtbGlnaHRib3g9XCInK2grJ1wiXScpO2Zvcih2YXIgaT0wO2k8Zi5sZW5ndGg7aT0rK2kpYyhhKGZbaV0pKSxmW2ldPT09YlswXSYmKGc9aSl9ZWxzZSBpZihcImxpZ2h0Ym94XCI9PT1iLmF0dHIoXCJyZWxcIikpYyhiKTtlbHNle2Y9YShiLnByb3AoXCJ0YWdOYW1lXCIpKydbcmVsPVwiJytiLmF0dHIoXCJyZWxcIikrJ1wiXScpO2Zvcih2YXIgaj0wO2o8Zi5sZW5ndGg7aj0rK2opYyhhKGZbal0pKSxmW2pdPT09YlswXSYmKGc9ail9dmFyIGs9ZS5zY3JvbGxUb3AoKSt0aGlzLm9wdGlvbnMucG9zaXRpb25Gcm9tVG9wLGw9ZS5zY3JvbGxMZWZ0KCk7dGhpcy4kbGlnaHRib3guY3NzKHt0b3A6aytcInB4XCIsbGVmdDpsK1wicHhcIn0pLmZhZGVJbih0aGlzLm9wdGlvbnMuZmFkZUR1cmF0aW9uKSx0aGlzLm9wdGlvbnMuZGlzYWJsZVNjcm9sbGluZyYmYShcImJvZHlcIikuYWRkQ2xhc3MoXCJsYi1kaXNhYmxlLXNjcm9sbGluZ1wiKSx0aGlzLmNoYW5nZUltYWdlKGcpfSxiLnByb3RvdHlwZS5jaGFuZ2VJbWFnZT1mdW5jdGlvbihiKXt2YXIgYz10aGlzO3RoaXMuZGlzYWJsZUtleWJvYXJkTmF2KCk7dmFyIGQ9dGhpcy4kbGlnaHRib3guZmluZChcIi5sYi1pbWFnZVwiKTt0aGlzLiRvdmVybGF5LmZhZGVJbih0aGlzLm9wdGlvbnMuZmFkZUR1cmF0aW9uKSxhKFwiLmxiLWxvYWRlclwiKS5mYWRlSW4oXCJzbG93XCIpLHRoaXMuJGxpZ2h0Ym94LmZpbmQoXCIubGItaW1hZ2UsIC5sYi1uYXYsIC5sYi1wcmV2LCAubGItbmV4dCwgLmxiLWRhdGFDb250YWluZXIsIC5sYi1udW1iZXJzLCAubGItY2FwdGlvblwiKS5oaWRlKCksdGhpcy4kb3V0ZXJDb250YWluZXIuYWRkQ2xhc3MoXCJhbmltYXRpbmdcIik7dmFyIGU9bmV3IEltYWdlO2Uub25sb2FkPWZ1bmN0aW9uKCl7dmFyIGYsZyxoLGksaixrLGw7ZC5hdHRyKFwic3JjXCIsYy5hbGJ1bVtiXS5saW5rKSxmPWEoZSksZC53aWR0aChlLndpZHRoKSxkLmhlaWdodChlLmhlaWdodCksYy5vcHRpb25zLmZpdEltYWdlc0luVmlld3BvcnQmJihsPWEod2luZG93KS53aWR0aCgpLGs9YSh3aW5kb3cpLmhlaWdodCgpLGo9bC1jLmNvbnRhaW5lckxlZnRQYWRkaW5nLWMuY29udGFpbmVyUmlnaHRQYWRkaW5nLTIwLGk9ay1jLmNvbnRhaW5lclRvcFBhZGRpbmctYy5jb250YWluZXJCb3R0b21QYWRkaW5nLTEyMCxjLm9wdGlvbnMubWF4V2lkdGgmJmMub3B0aW9ucy5tYXhXaWR0aDxqJiYoaj1jLm9wdGlvbnMubWF4V2lkdGgpLGMub3B0aW9ucy5tYXhIZWlnaHQmJmMub3B0aW9ucy5tYXhIZWlnaHQ8aiYmKGk9Yy5vcHRpb25zLm1heEhlaWdodCksKGUud2lkdGg+anx8ZS5oZWlnaHQ+aSkmJihlLndpZHRoL2o+ZS5oZWlnaHQvaT8oaD1qLGc9cGFyc2VJbnQoZS5oZWlnaHQvKGUud2lkdGgvaCksMTApLGQud2lkdGgoaCksZC5oZWlnaHQoZykpOihnPWksaD1wYXJzZUludChlLndpZHRoLyhlLmhlaWdodC9nKSwxMCksZC53aWR0aChoKSxkLmhlaWdodChnKSkpKSxjLnNpemVDb250YWluZXIoZC53aWR0aCgpLGQuaGVpZ2h0KCkpfSxlLnNyYz10aGlzLmFsYnVtW2JdLmxpbmssdGhpcy5jdXJyZW50SW1hZ2VJbmRleD1ifSxiLnByb3RvdHlwZS5zaXplT3ZlcmxheT1mdW5jdGlvbigpe3RoaXMuJG92ZXJsYXkud2lkdGgoYShkb2N1bWVudCkud2lkdGgoKSkuaGVpZ2h0KGEoZG9jdW1lbnQpLmhlaWdodCgpKX0sYi5wcm90b3R5cGUuc2l6ZUNvbnRhaW5lcj1mdW5jdGlvbihhLGIpe2Z1bmN0aW9uIGMoKXtkLiRsaWdodGJveC5maW5kKFwiLmxiLWRhdGFDb250YWluZXJcIikud2lkdGgoZyksZC4kbGlnaHRib3guZmluZChcIi5sYi1wcmV2TGlua1wiKS5oZWlnaHQoaCksZC4kbGlnaHRib3guZmluZChcIi5sYi1uZXh0TGlua1wiKS5oZWlnaHQoaCksZC5zaG93SW1hZ2UoKX12YXIgZD10aGlzLGU9dGhpcy4kb3V0ZXJDb250YWluZXIub3V0ZXJXaWR0aCgpLGY9dGhpcy4kb3V0ZXJDb250YWluZXIub3V0ZXJIZWlnaHQoKSxnPWErdGhpcy5jb250YWluZXJMZWZ0UGFkZGluZyt0aGlzLmNvbnRhaW5lclJpZ2h0UGFkZGluZyxoPWIrdGhpcy5jb250YWluZXJUb3BQYWRkaW5nK3RoaXMuY29udGFpbmVyQm90dG9tUGFkZGluZztlIT09Z3x8ZiE9PWg/dGhpcy4kb3V0ZXJDb250YWluZXIuYW5pbWF0ZSh7d2lkdGg6ZyxoZWlnaHQ6aH0sdGhpcy5vcHRpb25zLnJlc2l6ZUR1cmF0aW9uLFwic3dpbmdcIixmdW5jdGlvbigpe2MoKX0pOmMoKX0sYi5wcm90b3R5cGUuc2hvd0ltYWdlPWZ1bmN0aW9uKCl7dGhpcy4kbGlnaHRib3guZmluZChcIi5sYi1sb2FkZXJcIikuc3RvcCghMCkuaGlkZSgpLHRoaXMuJGxpZ2h0Ym94LmZpbmQoXCIubGItaW1hZ2VcIikuZmFkZUluKFwic2xvd1wiKSx0aGlzLnVwZGF0ZU5hdigpLHRoaXMudXBkYXRlRGV0YWlscygpLHRoaXMucHJlbG9hZE5laWdoYm9yaW5nSW1hZ2VzKCksdGhpcy5lbmFibGVLZXlib2FyZE5hdigpfSxiLnByb3RvdHlwZS51cGRhdGVOYXY9ZnVuY3Rpb24oKXt2YXIgYT0hMTt0cnl7ZG9jdW1lbnQuY3JlYXRlRXZlbnQoXCJUb3VjaEV2ZW50XCIpLGE9dGhpcy5vcHRpb25zLmFsd2F5c1Nob3dOYXZPblRvdWNoRGV2aWNlcz8hMDohMX1jYXRjaChiKXt9dGhpcy4kbGlnaHRib3guZmluZChcIi5sYi1uYXZcIikuc2hvdygpLHRoaXMuYWxidW0ubGVuZ3RoPjEmJih0aGlzLm9wdGlvbnMud3JhcEFyb3VuZD8oYSYmdGhpcy4kbGlnaHRib3guZmluZChcIi5sYi1wcmV2LCAubGItbmV4dFwiKS5jc3MoXCJvcGFjaXR5XCIsXCIxXCIpLHRoaXMuJGxpZ2h0Ym94LmZpbmQoXCIubGItcHJldiwgLmxiLW5leHRcIikuc2hvdygpKToodGhpcy5jdXJyZW50SW1hZ2VJbmRleD4wJiYodGhpcy4kbGlnaHRib3guZmluZChcIi5sYi1wcmV2XCIpLnNob3coKSxhJiZ0aGlzLiRsaWdodGJveC5maW5kKFwiLmxiLXByZXZcIikuY3NzKFwib3BhY2l0eVwiLFwiMVwiKSksdGhpcy5jdXJyZW50SW1hZ2VJbmRleDx0aGlzLmFsYnVtLmxlbmd0aC0xJiYodGhpcy4kbGlnaHRib3guZmluZChcIi5sYi1uZXh0XCIpLnNob3coKSxhJiZ0aGlzLiRsaWdodGJveC5maW5kKFwiLmxiLW5leHRcIikuY3NzKFwib3BhY2l0eVwiLFwiMVwiKSkpKX0sYi5wcm90b3R5cGUudXBkYXRlRGV0YWlscz1mdW5jdGlvbigpe3ZhciBiPXRoaXM7aWYoXCJ1bmRlZmluZWRcIiE9dHlwZW9mIHRoaXMuYWxidW1bdGhpcy5jdXJyZW50SW1hZ2VJbmRleF0udGl0bGUmJlwiXCIhPT10aGlzLmFsYnVtW3RoaXMuY3VycmVudEltYWdlSW5kZXhdLnRpdGxlJiZ0aGlzLiRsaWdodGJveC5maW5kKFwiLmxiLWNhcHRpb25cIikuaHRtbCh0aGlzLmFsYnVtW3RoaXMuY3VycmVudEltYWdlSW5kZXhdLnRpdGxlKS5mYWRlSW4oXCJmYXN0XCIpLmZpbmQoXCJhXCIpLm9uKFwiY2xpY2tcIixmdW5jdGlvbihiKXt2b2lkIDAhPT1hKHRoaXMpLmF0dHIoXCJ0YXJnZXRcIik/d2luZG93Lm9wZW4oYSh0aGlzKS5hdHRyKFwiaHJlZlwiKSxhKHRoaXMpLmF0dHIoXCJ0YXJnZXRcIikpOmxvY2F0aW9uLmhyZWY9YSh0aGlzKS5hdHRyKFwiaHJlZlwiKX0pLHRoaXMuYWxidW0ubGVuZ3RoPjEmJnRoaXMub3B0aW9ucy5zaG93SW1hZ2VOdW1iZXJMYWJlbCl7dmFyIGM9dGhpcy5pbWFnZUNvdW50TGFiZWwodGhpcy5jdXJyZW50SW1hZ2VJbmRleCsxLHRoaXMuYWxidW0ubGVuZ3RoKTt0aGlzLiRsaWdodGJveC5maW5kKFwiLmxiLW51bWJlclwiKS50ZXh0KGMpLmZhZGVJbihcImZhc3RcIil9ZWxzZSB0aGlzLiRsaWdodGJveC5maW5kKFwiLmxiLW51bWJlclwiKS5oaWRlKCk7dGhpcy4kb3V0ZXJDb250YWluZXIucmVtb3ZlQ2xhc3MoXCJhbmltYXRpbmdcIiksdGhpcy4kbGlnaHRib3guZmluZChcIi5sYi1kYXRhQ29udGFpbmVyXCIpLmZhZGVJbih0aGlzLm9wdGlvbnMucmVzaXplRHVyYXRpb24sZnVuY3Rpb24oKXtyZXR1cm4gYi5zaXplT3ZlcmxheSgpfSl9LGIucHJvdG90eXBlLnByZWxvYWROZWlnaGJvcmluZ0ltYWdlcz1mdW5jdGlvbigpe2lmKHRoaXMuYWxidW0ubGVuZ3RoPnRoaXMuY3VycmVudEltYWdlSW5kZXgrMSl7dmFyIGE9bmV3IEltYWdlO2Euc3JjPXRoaXMuYWxidW1bdGhpcy5jdXJyZW50SW1hZ2VJbmRleCsxXS5saW5rfWlmKHRoaXMuY3VycmVudEltYWdlSW5kZXg+MCl7dmFyIGI9bmV3IEltYWdlO2Iuc3JjPXRoaXMuYWxidW1bdGhpcy5jdXJyZW50SW1hZ2VJbmRleC0xXS5saW5rfX0sYi5wcm90b3R5cGUuZW5hYmxlS2V5Ym9hcmROYXY9ZnVuY3Rpb24oKXthKGRvY3VtZW50KS5vbihcImtleXVwLmtleWJvYXJkXCIsYS5wcm94eSh0aGlzLmtleWJvYXJkQWN0aW9uLHRoaXMpKX0sYi5wcm90b3R5cGUuZGlzYWJsZUtleWJvYXJkTmF2PWZ1bmN0aW9uKCl7YShkb2N1bWVudCkub2ZmKFwiLmtleWJvYXJkXCIpfSxiLnByb3RvdHlwZS5rZXlib2FyZEFjdGlvbj1mdW5jdGlvbihhKXt2YXIgYj0yNyxjPTM3LGQ9MzksZT1hLmtleUNvZGUsZj1TdHJpbmcuZnJvbUNoYXJDb2RlKGUpLnRvTG93ZXJDYXNlKCk7ZT09PWJ8fGYubWF0Y2goL3h8b3xjLyk/dGhpcy5lbmQoKTpcInBcIj09PWZ8fGU9PT1jPzAhPT10aGlzLmN1cnJlbnRJbWFnZUluZGV4P3RoaXMuY2hhbmdlSW1hZ2UodGhpcy5jdXJyZW50SW1hZ2VJbmRleC0xKTp0aGlzLm9wdGlvbnMud3JhcEFyb3VuZCYmdGhpcy5hbGJ1bS5sZW5ndGg+MSYmdGhpcy5jaGFuZ2VJbWFnZSh0aGlzLmFsYnVtLmxlbmd0aC0xKTooXCJuXCI9PT1mfHxlPT09ZCkmJih0aGlzLmN1cnJlbnRJbWFnZUluZGV4IT09dGhpcy5hbGJ1bS5sZW5ndGgtMT90aGlzLmNoYW5nZUltYWdlKHRoaXMuY3VycmVudEltYWdlSW5kZXgrMSk6dGhpcy5vcHRpb25zLndyYXBBcm91bmQmJnRoaXMuYWxidW0ubGVuZ3RoPjEmJnRoaXMuY2hhbmdlSW1hZ2UoMCkpfSxiLnByb3RvdHlwZS5lbmQ9ZnVuY3Rpb24oKXt0aGlzLmRpc2FibGVLZXlib2FyZE5hdigpLGEod2luZG93KS5vZmYoXCJyZXNpemVcIix0aGlzLnNpemVPdmVybGF5KSx0aGlzLiRsaWdodGJveC5mYWRlT3V0KHRoaXMub3B0aW9ucy5mYWRlRHVyYXRpb24pLHRoaXMuJG92ZXJsYXkuZmFkZU91dCh0aGlzLm9wdGlvbnMuZmFkZUR1cmF0aW9uKSxhKFwic2VsZWN0LCBvYmplY3QsIGVtYmVkXCIpLmNzcyh7dmlzaWJpbGl0eTpcInZpc2libGVcIn0pLHRoaXMub3B0aW9ucy5kaXNhYmxlU2Nyb2xsaW5nJiZhKFwiYm9keVwiKS5yZW1vdmVDbGFzcyhcImxiLWRpc2FibGUtc2Nyb2xsaW5nXCIpfSxuZXcgYn0pO1xuLy8jIHNvdXJjZU1hcHBpbmdVUkw9bGlnaHRib3gubWluLm1hcCIsIi8vIEdlbmVyYXRlZCBieSBDb2ZmZWVTY3JpcHQgMS45LjJcblxuLyoqXG5AbGljZW5zZSBTdGlja3kta2l0IHYxLjEuMiB8IFdURlBMIHwgTGVhZiBDb3Jjb3JhbiAyMDE1IHwgaHR0cDovL2xlYWZvLm5ldFxuICovXG5cbihmdW5jdGlvbigpIHtcbiAgdmFyICQsIHdpbjtcblxuICAkID0gdGhpcy5qUXVlcnkgfHwgd2luZG93LmpRdWVyeTtcblxuICB3aW4gPSAkKHdpbmRvdyk7XG5cbiAgJC5mbi5zdGlja19pbl9wYXJlbnQgPSBmdW5jdGlvbihvcHRzKSB7XG4gICAgdmFyIGRvYywgZWxtLCBlbmFibGVfYm90dG9taW5nLCBmbiwgaSwgaW5uZXJfc2Nyb2xsaW5nLCBsZW4sIG1hbnVhbF9zcGFjZXIsIG9mZnNldF90b3AsIHBhcmVudF9zZWxlY3RvciwgcmVjYWxjX2V2ZXJ5LCBzdGlja3lfY2xhc3M7XG4gICAgaWYgKG9wdHMgPT0gbnVsbCkge1xuICAgICAgb3B0cyA9IHt9O1xuICAgIH1cbiAgICBzdGlja3lfY2xhc3MgPSBvcHRzLnN0aWNreV9jbGFzcywgaW5uZXJfc2Nyb2xsaW5nID0gb3B0cy5pbm5lcl9zY3JvbGxpbmcsIHJlY2FsY19ldmVyeSA9IG9wdHMucmVjYWxjX2V2ZXJ5LCBwYXJlbnRfc2VsZWN0b3IgPSBvcHRzLnBhcmVudCwgb2Zmc2V0X3RvcCA9IG9wdHMub2Zmc2V0X3RvcCwgbWFudWFsX3NwYWNlciA9IG9wdHMuc3BhY2VyLCBlbmFibGVfYm90dG9taW5nID0gb3B0cy5ib3R0b21pbmc7XG4gICAgaWYgKG9mZnNldF90b3AgPT0gbnVsbCkge1xuICAgICAgb2Zmc2V0X3RvcCA9IDA7XG4gICAgfVxuICAgIGlmIChwYXJlbnRfc2VsZWN0b3IgPT0gbnVsbCkge1xuICAgICAgcGFyZW50X3NlbGVjdG9yID0gdm9pZCAwO1xuICAgIH1cbiAgICBpZiAoaW5uZXJfc2Nyb2xsaW5nID09IG51bGwpIHtcbiAgICAgIGlubmVyX3Njcm9sbGluZyA9IHRydWU7XG4gICAgfVxuICAgIGlmIChzdGlja3lfY2xhc3MgPT0gbnVsbCkge1xuICAgICAgc3RpY2t5X2NsYXNzID0gXCJpc19zdHVja1wiO1xuICAgIH1cbiAgICBkb2MgPSAkKGRvY3VtZW50KTtcbiAgICBpZiAoZW5hYmxlX2JvdHRvbWluZyA9PSBudWxsKSB7XG4gICAgICBlbmFibGVfYm90dG9taW5nID0gdHJ1ZTtcbiAgICB9XG4gICAgZm4gPSBmdW5jdGlvbihlbG0sIHBhZGRpbmdfYm90dG9tLCBwYXJlbnRfdG9wLCBwYXJlbnRfaGVpZ2h0LCB0b3AsIGhlaWdodCwgZWxfZmxvYXQsIGRldGFjaGVkKSB7XG4gICAgICB2YXIgYm90dG9tZWQsIGRldGFjaCwgZml4ZWQsIGxhc3RfcG9zLCBsYXN0X3Njcm9sbF9oZWlnaHQsIG9mZnNldCwgcGFyZW50LCByZWNhbGMsIHJlY2FsY19hbmRfdGljaywgcmVjYWxjX2NvdW50ZXIsIHNwYWNlciwgdGljaztcbiAgICAgIGlmIChlbG0uZGF0YShcInN0aWNreV9raXRcIikpIHtcbiAgICAgICAgcmV0dXJuO1xuICAgICAgfVxuICAgICAgZWxtLmRhdGEoXCJzdGlja3lfa2l0XCIsIHRydWUpO1xuICAgICAgbGFzdF9zY3JvbGxfaGVpZ2h0ID0gZG9jLmhlaWdodCgpO1xuICAgICAgcGFyZW50ID0gZWxtLnBhcmVudCgpO1xuICAgICAgaWYgKHBhcmVudF9zZWxlY3RvciAhPSBudWxsKSB7XG4gICAgICAgIHBhcmVudCA9IHBhcmVudC5jbG9zZXN0KHBhcmVudF9zZWxlY3Rvcik7XG4gICAgICB9XG4gICAgICBpZiAoIXBhcmVudC5sZW5ndGgpIHtcbiAgICAgICAgdGhyb3cgXCJmYWlsZWQgdG8gZmluZCBzdGljayBwYXJlbnRcIjtcbiAgICAgIH1cbiAgICAgIGZpeGVkID0gZmFsc2U7XG4gICAgICBib3R0b21lZCA9IGZhbHNlO1xuICAgICAgc3BhY2VyID0gbWFudWFsX3NwYWNlciAhPSBudWxsID8gbWFudWFsX3NwYWNlciAmJiBlbG0uY2xvc2VzdChtYW51YWxfc3BhY2VyKSA6ICQoXCI8ZGl2IC8+XCIpO1xuICAgICAgLyppZiAoc3BhY2VyKSB7XG4gICAgICAgIHNwYWNlci5jc3MoJ3Bvc2l0aW9uJywgZWxtLmNzcygncG9zaXRpb24nKSk7XG4gICAgICB9Ki9cbiAgICAgIHJlY2FsYyA9IGZ1bmN0aW9uKCkge1xuICAgICAgICB2YXIgYm9yZGVyX3RvcCwgcGFkZGluZ190b3AsIHJlc3RvcmU7XG4gICAgICAgIGlmIChkZXRhY2hlZCkge1xuICAgICAgICAgIHJldHVybjtcbiAgICAgICAgfVxuICAgICAgICBsYXN0X3Njcm9sbF9oZWlnaHQgPSBkb2MuaGVpZ2h0KCk7XG4gICAgICAgIGJvcmRlcl90b3AgPSBwYXJzZUludChwYXJlbnQuY3NzKFwiYm9yZGVyLXRvcC13aWR0aFwiKSwgMTApO1xuICAgICAgICBwYWRkaW5nX3RvcCA9IHBhcnNlSW50KHBhcmVudC5jc3MoXCJwYWRkaW5nLXRvcFwiKSwgMTApO1xuICAgICAgICBwYWRkaW5nX2JvdHRvbSA9IHBhcnNlSW50KHBhcmVudC5jc3MoXCJwYWRkaW5nLWJvdHRvbVwiKSwgMTApO1xuICAgICAgICBwYXJlbnRfdG9wID0gcGFyZW50Lm9mZnNldCgpLnRvcCArIGJvcmRlcl90b3AgKyBwYWRkaW5nX3RvcDtcbiAgICAgICAgcGFyZW50X2hlaWdodCA9IHBhcmVudC5oZWlnaHQoKTtcbiAgICAgICAgaWYgKGZpeGVkKSB7XG4gICAgICAgICAgZml4ZWQgPSBmYWxzZTtcbiAgICAgICAgICBib3R0b21lZCA9IGZhbHNlO1xuICAgICAgICAgIGlmIChtYW51YWxfc3BhY2VyID09IG51bGwpIHtcbiAgICAgICAgICAgIGVsbS5pbnNlcnRBZnRlcihzcGFjZXIpO1xuICAgICAgICAgICAgc3BhY2VyLmRldGFjaCgpO1xuICAgICAgICAgIH1cbiAgICAgICAgICBlbG0uY3NzKHtcbiAgICAgICAgICAgIHBvc2l0aW9uOiBcIlwiLFxuICAgICAgICAgICAgdG9wOiBcIlwiLFxuICAgICAgICAgICAgd2lkdGg6IFwiXCIsXG4gICAgICAgICAgICBib3R0b206IFwiXCJcbiAgICAgICAgICB9KS5yZW1vdmVDbGFzcyhzdGlja3lfY2xhc3MpO1xuICAgICAgICAgIHJlc3RvcmUgPSB0cnVlO1xuICAgICAgICB9XG4gICAgICAgIHRvcCA9IGVsbS5vZmZzZXQoKS50b3AgLSAocGFyc2VJbnQoZWxtLmNzcyhcIm1hcmdpbi10b3BcIiksIDEwKSB8fCAwKSAtIG9mZnNldF90b3A7XG4gICAgICAgIGhlaWdodCA9IGVsbS5vdXRlckhlaWdodCh0cnVlKTtcbiAgICAgICAgZWxfZmxvYXQgPSBlbG0uY3NzKFwiZmxvYXRcIik7XG4gICAgICAgIGlmIChzcGFjZXIpIHtcbiAgICAgICAgICBzcGFjZXIuY3NzKHtcbiAgICAgICAgICAgIHdpZHRoOiBlbG0ub3V0ZXJXaWR0aCh0cnVlKSxcbiAgICAgICAgICAgIGhlaWdodDogaGVpZ2h0LFxuICAgICAgICAgICAgZGlzcGxheTogZWxtLmNzcyhcImRpc3BsYXlcIiksXG4gICAgICAgICAgICBcInZlcnRpY2FsLWFsaWduXCI6IGVsbS5jc3MoXCJ2ZXJ0aWNhbC1hbGlnblwiKSxcbiAgICAgICAgICAgIFwiZmxvYXRcIjogZWxfZmxvYXRcbiAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgICAgICBpZiAocmVzdG9yZSkge1xuICAgICAgICAgIHJldHVybiB0aWNrKCk7XG4gICAgICAgIH1cbiAgICAgIH07XG4gICAgICByZWNhbGMoKTtcbiAgICAgIGlmIChoZWlnaHQgPT09IHBhcmVudF9oZWlnaHQpIHtcbiAgICAgICAgcmV0dXJuO1xuICAgICAgfVxuICAgICAgbGFzdF9wb3MgPSB2b2lkIDA7XG4gICAgICBvZmZzZXQgPSBvZmZzZXRfdG9wO1xuICAgICAgcmVjYWxjX2NvdW50ZXIgPSByZWNhbGNfZXZlcnk7XG4gICAgICB0aWNrID0gZnVuY3Rpb24oKSB7XG4gICAgICAgIHZhciBjc3MsIGRlbHRhLCByZWNhbGNlZCwgc2Nyb2xsLCB3aWxsX2JvdHRvbSwgd2luX2hlaWdodDtcbiAgICAgICAgaWYgKGRldGFjaGVkKSB7XG4gICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG4gICAgICAgIHJlY2FsY2VkID0gZmFsc2U7XG4gICAgICAgIGlmIChyZWNhbGNfY291bnRlciAhPSBudWxsKSB7XG4gICAgICAgICAgcmVjYWxjX2NvdW50ZXIgLT0gMTtcbiAgICAgICAgICBpZiAocmVjYWxjX2NvdW50ZXIgPD0gMCkge1xuICAgICAgICAgICAgcmVjYWxjX2NvdW50ZXIgPSByZWNhbGNfZXZlcnk7XG4gICAgICAgICAgICByZWNhbGMoKTtcbiAgICAgICAgICAgIHJlY2FsY2VkID0gdHJ1ZTtcbiAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICAgICAgaWYgKCFyZWNhbGNlZCAmJiBkb2MuaGVpZ2h0KCkgIT09IGxhc3Rfc2Nyb2xsX2hlaWdodCkge1xuICAgICAgICAgIHJlY2FsYygpO1xuICAgICAgICAgIHJlY2FsY2VkID0gdHJ1ZTtcbiAgICAgICAgfVxuICAgICAgICBzY3JvbGwgPSB3aW4uc2Nyb2xsVG9wKCk7XG4gICAgICAgIGlmIChsYXN0X3BvcyAhPSBudWxsKSB7XG4gICAgICAgICAgZGVsdGEgPSBzY3JvbGwgLSBsYXN0X3BvcztcbiAgICAgICAgfVxuICAgICAgICBsYXN0X3BvcyA9IHNjcm9sbDtcbiAgICAgICAgaWYgKGZpeGVkKSB7XG4gICAgICAgICAgaWYgKGVuYWJsZV9ib3R0b21pbmcpIHtcbiAgICAgICAgICAgIHdpbGxfYm90dG9tID0gc2Nyb2xsICsgaGVpZ2h0ICsgb2Zmc2V0ID4gcGFyZW50X2hlaWdodCArIHBhcmVudF90b3A7XG4gICAgICAgICAgICBpZiAoYm90dG9tZWQgJiYgIXdpbGxfYm90dG9tKSB7XG4gICAgICAgICAgICAgIGJvdHRvbWVkID0gZmFsc2U7XG4gICAgICAgICAgICAgIGVsbS5jc3Moe1xuICAgICAgICAgICAgICAgIHBvc2l0aW9uOiBcImZpeGVkXCIsXG4gICAgICAgICAgICAgICAgYm90dG9tOiBcIlwiLFxuICAgICAgICAgICAgICAgIHRvcDogb2Zmc2V0XG4gICAgICAgICAgICAgIH0pLnRyaWdnZXIoXCJzdGlja3lfa2l0OnVuYm90dG9tXCIpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgIH1cbiAgICAgICAgICBpZiAoc2Nyb2xsIDwgdG9wKSB7XG4gICAgICAgICAgICBmaXhlZCA9IGZhbHNlO1xuICAgICAgICAgICAgb2Zmc2V0ID0gb2Zmc2V0X3RvcDtcbiAgICAgICAgICAgIGlmIChtYW51YWxfc3BhY2VyID09IG51bGwpIHtcbiAgICAgICAgICAgICAgaWYgKGVsX2Zsb2F0ID09PSBcImxlZnRcIiB8fCBlbF9mbG9hdCA9PT0gXCJyaWdodFwiKSB7XG4gICAgICAgICAgICAgICAgZWxtLmluc2VydEFmdGVyKHNwYWNlcik7XG4gICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgc3BhY2VyLmRldGFjaCgpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgY3NzID0ge1xuICAgICAgICAgICAgICBwb3NpdGlvbjogXCJcIixcbiAgICAgICAgICAgICAgd2lkdGg6IFwiXCIsXG4gICAgICAgICAgICAgIHRvcDogXCJcIlxuICAgICAgICAgICAgfTtcbiAgICAgICAgICAgIGVsbS5jc3MoY3NzKS5yZW1vdmVDbGFzcyhzdGlja3lfY2xhc3MpLnRyaWdnZXIoXCJzdGlja3lfa2l0OnVuc3RpY2tcIik7XG4gICAgICAgICAgfVxuICAgICAgICAgIGlmIChpbm5lcl9zY3JvbGxpbmcpIHtcbiAgICAgICAgICAgIHdpbl9oZWlnaHQgPSB3aW4uaGVpZ2h0KCk7XG4gICAgICAgICAgICBpZiAoaGVpZ2h0ICsgb2Zmc2V0X3RvcCA+IHdpbl9oZWlnaHQpIHtcbiAgICAgICAgICAgICAgaWYgKCFib3R0b21lZCkge1xuICAgICAgICAgICAgICAgIG9mZnNldCAtPSBkZWx0YTtcbiAgICAgICAgICAgICAgICBvZmZzZXQgPSBNYXRoLm1heCh3aW5faGVpZ2h0IC0gaGVpZ2h0LCBvZmZzZXQpO1xuICAgICAgICAgICAgICAgIG9mZnNldCA9IE1hdGgubWluKG9mZnNldF90b3AsIG9mZnNldCk7XG4gICAgICAgICAgICAgICAgaWYgKGZpeGVkKSB7XG4gICAgICAgICAgICAgICAgICBlbG0uY3NzKHtcbiAgICAgICAgICAgICAgICAgICAgdG9wOiBvZmZzZXQgKyBcInB4XCJcbiAgICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICAgIH1cbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICBpZiAoc2Nyb2xsID4gdG9wKSB7XG4gICAgICAgICAgICBmaXhlZCA9IHRydWU7XG4gICAgICAgICAgICBjc3MgPSB7XG4gICAgICAgICAgICAgIHBvc2l0aW9uOiBcImZpeGVkXCIsXG4gICAgICAgICAgICAgIHRvcDogb2Zmc2V0XG4gICAgICAgICAgICB9O1xuICAgICAgICAgICAgY3NzLndpZHRoID0gZWxtLmNzcyhcImJveC1zaXppbmdcIikgPT09IFwiYm9yZGVyLWJveFwiID8gZWxtLm91dGVyV2lkdGgoKSArIFwicHhcIiA6IGVsbS53aWR0aCgpICsgXCJweFwiO1xuICAgICAgICAgICAgZWxtLmNzcyhjc3MpLmFkZENsYXNzKHN0aWNreV9jbGFzcyk7XG4gICAgICAgICAgICBpZiAobWFudWFsX3NwYWNlciA9PSBudWxsKSB7XG4gICAgICAgICAgICAgIGVsbS5hZnRlcihzcGFjZXIpO1xuICAgICAgICAgICAgICBpZiAoZWxfZmxvYXQgPT09IFwibGVmdFwiIHx8IGVsX2Zsb2F0ID09PSBcInJpZ2h0XCIpIHtcbiAgICAgICAgICAgICAgICBzcGFjZXIuYXBwZW5kKGVsbSk7XG4gICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsbS50cmlnZ2VyKFwic3RpY2t5X2tpdDpzdGlja1wiKTtcbiAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICAgICAgaWYgKGZpeGVkICYmIGVuYWJsZV9ib3R0b21pbmcpIHtcbiAgICAgICAgICBpZiAod2lsbF9ib3R0b20gPT0gbnVsbCkge1xuICAgICAgICAgICAgd2lsbF9ib3R0b20gPSBzY3JvbGwgKyBoZWlnaHQgKyBvZmZzZXQgPiBwYXJlbnRfaGVpZ2h0ICsgcGFyZW50X3RvcDtcbiAgICAgICAgICB9XG4gICAgICAgICAgaWYgKCFib3R0b21lZCAmJiB3aWxsX2JvdHRvbSkge1xuICAgICAgICAgICAgYm90dG9tZWQgPSB0cnVlO1xuICAgICAgICAgICAgaWYgKHBhcmVudC5jc3MoXCJwb3NpdGlvblwiKSA9PT0gXCJzdGF0aWNcIikge1xuICAgICAgICAgICAgICBwYXJlbnQuY3NzKHtcbiAgICAgICAgICAgICAgICBwb3NpdGlvbjogXCJyZWxhdGl2ZVwiXG4gICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgcmV0dXJuIGVsbS5jc3Moe1xuICAgICAgICAgICAgICBwb3NpdGlvbjogXCJhYnNvbHV0ZVwiLFxuICAgICAgICAgICAgICBib3R0b206IHBhZGRpbmdfYm90dG9tLFxuICAgICAgICAgICAgICB0b3A6IFwiYXV0b1wiXG4gICAgICAgICAgICB9KS50cmlnZ2VyKFwic3RpY2t5X2tpdDpib3R0b21cIik7XG4gICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICB9O1xuICAgICAgcmVjYWxjX2FuZF90aWNrID0gZnVuY3Rpb24oKSB7XG4gICAgICAgIHJlY2FsYygpO1xuICAgICAgICByZXR1cm4gdGljaygpO1xuICAgICAgfTtcbiAgICAgIGRldGFjaCA9IGZ1bmN0aW9uKCkge1xuICAgICAgICBkZXRhY2hlZCA9IHRydWU7XG4gICAgICAgIHdpbi5vZmYoXCJ0b3VjaG1vdmVcIiwgdGljayk7XG4gICAgICAgIHdpbi5vZmYoXCJzY3JvbGxcIiwgdGljayk7XG4gICAgICAgIHdpbi5vZmYoXCJyZXNpemVcIiwgcmVjYWxjX2FuZF90aWNrKTtcbiAgICAgICAgJChkb2N1bWVudC5ib2R5KS5vZmYoXCJzdGlja3lfa2l0OnJlY2FsY1wiLCByZWNhbGNfYW5kX3RpY2spO1xuICAgICAgICBlbG0ub2ZmKFwic3RpY2t5X2tpdDpkZXRhY2hcIiwgZGV0YWNoKTtcbiAgICAgICAgZWxtLnJlbW92ZURhdGEoXCJzdGlja3lfa2l0XCIpO1xuICAgICAgICBlbG0uY3NzKHtcbiAgICAgICAgICBwb3NpdGlvbjogXCJcIixcbiAgICAgICAgICBib3R0b206IFwiXCIsXG4gICAgICAgICAgdG9wOiBcIlwiLFxuICAgICAgICAgIHdpZHRoOiBcIlwiXG4gICAgICAgIH0pO1xuICAgICAgICBwYXJlbnQucG9zaXRpb24oXCJwb3NpdGlvblwiLCBcIlwiKTtcbiAgICAgICAgaWYgKGZpeGVkKSB7XG4gICAgICAgICAgaWYgKG1hbnVhbF9zcGFjZXIgPT0gbnVsbCkge1xuICAgICAgICAgICAgaWYgKGVsX2Zsb2F0ID09PSBcImxlZnRcIiB8fCBlbF9mbG9hdCA9PT0gXCJyaWdodFwiKSB7XG4gICAgICAgICAgICAgIGVsbS5pbnNlcnRBZnRlcihzcGFjZXIpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgc3BhY2VyLnJlbW92ZSgpO1xuICAgICAgICAgIH1cbiAgICAgICAgICByZXR1cm4gZWxtLnJlbW92ZUNsYXNzKHN0aWNreV9jbGFzcyk7XG4gICAgICAgIH1cbiAgICAgIH07XG4gICAgICB3aW4ub24oXCJ0b3VjaG1vdmVcIiwgdGljayk7XG4gICAgICB3aW4ub24oXCJzY3JvbGxcIiwgdGljayk7XG4gICAgICB3aW4ub24oXCJyZXNpemVcIiwgcmVjYWxjX2FuZF90aWNrKTtcbiAgICAgICQoZG9jdW1lbnQuYm9keSkub24oXCJzdGlja3lfa2l0OnJlY2FsY1wiLCByZWNhbGNfYW5kX3RpY2spO1xuICAgICAgZWxtLm9uKFwic3RpY2t5X2tpdDpkZXRhY2hcIiwgZGV0YWNoKTtcbiAgICAgIHJldHVybiBzZXRUaW1lb3V0KHRpY2ssIDApO1xuICAgIH07XG4gICAgZm9yIChpID0gMCwgbGVuID0gdGhpcy5sZW5ndGg7IGkgPCBsZW47IGkrKykge1xuICAgICAgZWxtID0gdGhpc1tpXTtcbiAgICAgIGZuKCQoZWxtKSk7XG4gICAgfVxuICAgIHJldHVybiB0aGlzO1xuICB9O1xuXG59KS5jYWxsKHRoaXMpOyIsIi8qXG4gKlx0RGV2IHNjcmlwdHMgZm9yIHRoZW1lXG4gKi9cblxuKCBmdW5jdGlvbiggJCApIHtcblxuXHQvLyBIYW5kbGVzIGJvdGggc2xpZGUgbmF2aWdhdGlvbnNcblx0JChmdW5jdGlvbigpe1xuXHRcdHZhciBuYXZCdXR0b24gPSAkKCdidXR0b24ubmF2YmFyLXRvZ2dsZScpLFxuXHRcdHNvY2lhbE5hdkJ1dHRvbiA9ICQoJy5zb2NpYWwtdG9nZ2xlIGEnKSxcblx0XHRzaG93TGVmdCA9ICQoJyNzbGlkZS1uYXZpZ2F0aW9uJyksXG5cdFx0c2hvd1JpZ2h0ID0gJCgnI3NsaWRlLW5hdi1zb2NpYWwnKSxcblx0XHRib2R5ID0gJCgnYm9keScpLFxuXHRcdGxpbmtzID0gc2hvd0xlZnQuZmluZCgnYScpO1xuXG5cdFx0bmF2QnV0dG9uLmNsaWNrKGZ1bmN0aW9uKCl7XG5cdFx0XHQkKHRoaXMpLnRvZ2dsZUNsYXNzKCdhY3RpdmUnKTtcblx0XHRcdGJvZHkudG9nZ2xlQ2xhc3MoJ3B1c2gtdG9yaWdodCcpO1xuXHRcdFx0c2hvd0xlZnQudG9nZ2xlQ2xhc3MoJ3NsaWRlLW5hdi1vcGVuJyk7XG5cdFx0fSk7XG5cdFx0c29jaWFsTmF2QnV0dG9uLmNsaWNrKGZ1bmN0aW9uKCl7XG5cdFx0XHQkKHRoaXMpLnRvZ2dsZUNsYXNzKCdhY3RpdmUnKTtcblx0XHRcdGJvZHkudG9nZ2xlQ2xhc3MoJ3B1c2gtdG9sZWZ0Jyk7XG5cdFx0XHRzaG93UmlnaHQudG9nZ2xlQ2xhc3MoJ3NsaWRlLW5hdi1vcGVuJyk7XG5cdFx0fSk7XG5cblx0XHQkKCdhLnJlc3RvcmUtYm9keScpLmNsaWNrKGZ1bmN0aW9uKCl7XG5cdFx0XHQkKHRoaXMpLnRvZ2dsZUNsYXNzKCdhY3RpdmUnKTtcblx0XHRcdGJvZHkucmVtb3ZlQ2xhc3MoJ3B1c2gtdG9sZWZ0Jyk7XG5cdFx0XHRib2R5LnJlbW92ZUNsYXNzKCdwdXNoLXRvcmlnaHQnKTtcblx0XHRcdHNob3dSaWdodC5yZW1vdmVDbGFzcygnc2xpZGUtbmF2LW9wZW4nKTtcblx0XHRcdHNob3dMZWZ0LnJlbW92ZUNsYXNzKCdzbGlkZS1uYXYtb3BlbicpO1xuXHRcdH0pO1xuXHR9KTtcblxuXHR2YXIgdHJlbmRpbmdPcHRpb25zID0ge1xuXHRcdFx0ZG90czogZmFsc2UsXG5cdFx0XHRpbmZpbml0ZTogdHJ1ZSxcblx0XHRcdGFycm93czogdHJ1ZSxcblx0XHRcdHNwZWVkOiAzMDAsXG5cdFx0XHRhdXRvcGxheTogZmFsc2UsXG5cdFx0XHRhdXRvcGxheVNwZWVkOiAzMDAwLFxuXHRcdFx0c2xpZGVzVG9TaG93OiA0LFxuXHRcdFx0c2xpZGVzVG9TY3JvbGw6IDQsXG5cdFx0XHRyZXNwb25zaXZlOiBbXG5cdFx0XHRcdHtcblx0XHRcdFx0XHRicmVha3BvaW50OiA5OTEsXG5cdFx0XHRcdFx0c2V0dGluZ3M6IHtcblx0XHRcdFx0XHQgIHNsaWRlc1RvU2hvdzogMyxcblx0XHRcdFx0XHQgIHNsaWRlc1RvU2Nyb2xsOiAzXG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9LFxuXHRcdFx0XHR7XG5cdFx0XHRcdFx0YnJlYWtwb2ludDogNzAwLFxuXHRcdFx0XHRcdHNldHRpbmdzOiB7XG5cdFx0XHRcdFx0ICBzbGlkZXNUb1Nob3c6IDIsXG5cdFx0XHRcdFx0ICBzbGlkZXNUb1Njcm9sbDogMlxuXHRcdFx0XHRcdH1cblx0XHRcdFx0fSxcblx0XHRcdFx0e1xuXHRcdFx0XHRcdGJyZWFrcG9pbnQ6IDUwMCxcblx0XHRcdFx0XHRzZXR0aW5nczoge1xuXHRcdFx0XHRcdCAgc2xpZGVzVG9TaG93OiAxLFxuXHRcdFx0XHRcdCAgc2xpZGVzVG9TY3JvbGw6IDFcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdF1cblx0XHR9XG5cblx0Ly8gU2xpY2sgQ2Fyb3VzZWxzIGh0dHA6Ly9rZW53aGVlbGVyLmdpdGh1Yi5pby9zbGljay9cblx0JChmdW5jdGlvbigpe1xuXHRcdCQoJyNob21lLWF1dGhvcnMtY2Fyb3VzZWwnKS5zbGljayh7XG5cdFx0XHRkb3RzOiBmYWxzZSxcblx0XHRcdGluZmluaXRlOiBmYWxzZSxcblx0XHRcdHNwZWVkOiAzMDAsXG5cdFx0XHRzbGlkZXNUb1Nob3c6IDYsXG5cdFx0XHRzbGlkZXNUb1Njcm9sbDogNixcblx0XHRcdHJlc3BvbnNpdmU6IFtcblx0XHRcdCAge1xuXHRcdFx0XHRicmVha3BvaW50OiAxMDI0LFxuXHRcdFx0XHRzZXR0aW5nczoge1xuXHRcdFx0XHQgIHNsaWRlc1RvU2hvdzogNCxcblx0XHRcdFx0ICBzbGlkZXNUb1Njcm9sbDogNFxuXHRcdFx0XHR9XG5cdFx0XHQgIH0sXG5cdFx0XHQgIHtcblx0XHRcdFx0YnJlYWtwb2ludDogNjAwLFxuXHRcdFx0XHRzZXR0aW5nczoge1xuXHRcdFx0XHQgIHNsaWRlc1RvU2hvdzogMyxcblx0XHRcdFx0ICBzbGlkZXNUb1Njcm9sbDogM1xuXHRcdFx0XHR9XG5cdFx0XHQgIH0sXG5cdFx0XHQgIHtcblx0XHRcdFx0YnJlYWtwb2ludDogNDgwLFxuXHRcdFx0XHRzZXR0aW5nczoge1xuXHRcdFx0XHQgIHNsaWRlc1RvU2hvdzogMixcblx0XHRcdFx0ICBzbGlkZXNUb1Njcm9sbDogMlxuXHRcdFx0XHR9XG5cdFx0XHQgIH1cblx0XHRcdF1cblx0XHR9KTtcblxuXHRcdCQoJy5ob21lcGFnZS1iYW5uZXIgLmJhbm5lcicpLnNsaWNrKHtcblx0XHRcdGRvdHMgOiB0cnVlLFxuXHRcdFx0YXJyb3dzIDogZmFsc2UsXG5cdFx0XHRhdXRvcGxheTogdHJ1ZSxcblx0XHRcdGF1dG9wbGF5U3BlZWQ6IDUwMDBcblx0XHR9KTtcblxuXHRcdCQoJy5pbi1wb3N0LWNhcm91c2VsJykuc2xpY2soe1xuXHRcdFx0ZG90czogZmFsc2UsXG5cdFx0XHRhcnJvd3MgOiB0cnVlLFxuXHRcdFx0aW5maW5pdGU6IGZhbHNlLFxuXHRcdFx0c3BlZWQ6IDMwMCxcblx0XHRcdHNsaWRlc1RvU2hvdzogNCxcblx0XHRcdHNsaWRlc1RvU2Nyb2xsOiA0LFxuXHRcdFx0cmVzcG9uc2l2ZTogW1xuXHRcdFx0ICB7XG5cdFx0XHRcdGJyZWFrcG9pbnQ6IDEwMjQsXG5cdFx0XHRcdHNldHRpbmdzOiB7XG5cdFx0XHRcdCAgc2xpZGVzVG9TaG93OiA0LFxuXHRcdFx0XHQgIHNsaWRlc1RvU2Nyb2xsOiA0XG5cdFx0XHRcdH1cblx0XHRcdCAgfSxcblx0XHRcdCAge1xuXHRcdFx0XHRicmVha3BvaW50OiA2MDAsXG5cdFx0XHRcdHNldHRpbmdzOiB7XG5cdFx0XHRcdCAgc2xpZGVzVG9TaG93OiAzLFxuXHRcdFx0XHQgIHNsaWRlc1RvU2Nyb2xsOiAzXG5cdFx0XHRcdH1cblx0XHRcdCAgfSxcblx0XHRcdCAge1xuXHRcdFx0XHRicmVha3BvaW50OiA0ODAsXG5cdFx0XHRcdHNldHRpbmdzOiB7XG5cdFx0XHRcdCAgc2xpZGVzVG9TaG93OiAyLFxuXHRcdFx0XHQgIHNsaWRlc1RvU2Nyb2xsOiAyXG5cdFx0XHRcdH1cblx0XHRcdCAgfVxuXHRcdFx0XVxuXHRcdH0pO1xuXG5cdFx0JCgnLmluLXBvc3QtY2Fyb3VzZWwtd2l0aC1hdXRob3InKS5zbGljayh7XG5cdFx0XHRkb3RzOiBmYWxzZSxcblx0XHRcdGFycm93cyA6IGZhbHNlLFxuXHRcdFx0aW5maW5pdGU6IGZhbHNlLFxuXHRcdFx0c3BlZWQ6IDMwMCxcblx0XHRcdHNsaWRlc1RvU2hvdzogMyxcblx0XHRcdHNsaWRlc1RvU2Nyb2xsOiAzLFxuXHRcdFx0cmVzcG9uc2l2ZTogW1xuXHRcdFx0ICB7XG5cdFx0XHRcdGJyZWFrcG9pbnQ6IDEwMjQsXG5cdFx0XHRcdHNldHRpbmdzOiB7XG5cdFx0XHRcdCAgc2xpZGVzVG9TaG93OiAzLFxuXHRcdFx0XHQgIHNsaWRlc1RvU2Nyb2xsOiAzXG5cdFx0XHRcdH1cblx0XHRcdCAgfSxcblx0XHRcdCAge1xuXHRcdFx0XHRicmVha3BvaW50OiA2MDAsXG5cdFx0XHRcdHNldHRpbmdzOiB7XG5cdFx0XHRcdCAgc2xpZGVzVG9TaG93OiAyLFxuXHRcdFx0XHQgIHNsaWRlc1RvU2Nyb2xsOiAyXG5cdFx0XHRcdH1cblx0XHRcdCAgfSxcblx0XHRcdCAge1xuXHRcdFx0XHRicmVha3BvaW50OiA0ODAsXG5cdFx0XHRcdHNldHRpbmdzOiB7XG5cdFx0XHRcdCAgc2xpZGVzVG9TaG93OiAxLFxuXHRcdFx0XHQgIHNsaWRlc1RvU2Nyb2xsOiAxXG5cdFx0XHRcdH1cblx0XHRcdCAgfVxuXHRcdFx0XVxuXHRcdH0pO1xuXG5cdFx0JCgnLnZpZGVvLWNhcm91c2VsJykuc2xpY2soe1xuXHRcdFx0YXJyb3dzIDogdHJ1ZSxcblx0XHRcdGluZmluaXRlIDogdHJ1ZSxcblx0XHRcdGF1dG9wbGF5OiBmYWxzZSxcblx0XHRcdHNwZWVkIDogMzAwLFxuXHRcdFx0c2xpZGVzVG9TaG93IDogMSxcblx0XHRcdHZhcmlhYmxlV2lkdGg6IHRydWUsXG5cdFx0XHRjZW50ZXJNb2RlOiB0cnVlLFxuXHRcdFx0ZHJhZ2dhYmxlOiBmYWxzZSxcblx0XHRcdGFzTmF2Rm9yOiAnLmNhcHRpb24tc2xpZGVyJ1xuXHRcdH0pO1xuXHRcdCQoJy5jYXB0aW9uLXNsaWRlcicpLnNsaWNrKHtcblx0XHRcdHNsaWRlc1RvU2hvdzogMSxcblx0XHRcdHNsaWRlc1RvU2Nyb2xsOiAxLFxuXHRcdFx0YXJyb3dzOiBmYWxzZSxcblx0XHRcdGZhZGU6IHRydWUsXG5cdFx0XHRkcmFnZ2FibGU6IGZhbHNlLFxuXHRcdFx0YWRhcHRpdmVIZWlnaHQ6IHRydWVcblx0XHR9KTtcblxuXHRcdCQoJyNwYWdlLXRyZW5kaW5nLXNsaWRlcycpLnNsaWNrKHRyZW5kaW5nT3B0aW9ucyk7XG5cdH0pO1xuXG5cdCQoZnVuY3Rpb24oKXtcblx0ICAgJCgnLnZpZGVvLWNhcm91c2VsIGlmcmFtZScpLmVhY2goZnVuY3Rpb24oKXtcblx0XHRcdHZhciBvbGRTcmMgPSAkKHRoaXMpLmF0dHIoJ3NyYycpO1xuXHRcdFx0aWYoIG9sZFNyYy5pbmRleE9mKCd5b3V0dWJlJykgPiAwIHx8IG9sZFNyYy5pbmRleE9mKCd2aW1lbycpID4gMCApe1xuXHRcdFx0XHRpZiggb2xkU3JjLmluZGV4T2YoJz8nKSA+IDAgKXtcblx0XHRcdFx0XHQkKHRoaXMpLmF0dHIoJ3NyYycsIG9sZFNyYysnJmVuYWJsZWpzYXBpPTEnKTtcblx0XHRcdFx0fWVsc2V7XG5cdFx0XHRcdFx0JCh0aGlzKS5hdHRyKCdzcmMnLCBvbGRTcmMrJz9lbmFibGVqc2FwaT0xJyk7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9KTtcblxuXHRcdCQoJy52aWRlby1jYXJvdXNlbCcpLm9uKCdiZWZvcmVDaGFuZ2UnLCBmdW5jdGlvbihldmVudCwgc2xpY2ssIGN1cnJlbnRTbGlkZSwgbmV4dFNsaWRlKXtcblx0XHRcdHZhciBlbGVtID0gZG9jdW1lbnQuZ2V0RWxlbWVudHNCeUNsYXNzTmFtZSgnc2xpY2stY3VycmVudCcpWzBdO1xuXHRcdFx0dmFyIGVsZW1JZnJhbWUgPSBlbGVtLmdldEVsZW1lbnRzQnlUYWdOYW1lKFwiaWZyYW1lXCIpWzBdO1xuXHRcdFx0dmFyIGVsZW1TcmMgPSBlbGVtSWZyYW1lLmdldEF0dHJpYnV0ZSgnc3JjJyk7XG5cblx0XHRcdGlmKCBlbGVtU3JjLmluZGV4T2YoJ3lvdXR1YmUnKSA+IDAgKXtcblx0XHRcdFx0ZWxlbUlmcmFtZS5jb250ZW50V2luZG93LnBvc3RNZXNzYWdlKCd7XCJldmVudFwiOlwiY29tbWFuZFwiLFwiZnVuY1wiOlwic3RvcFZpZGVvXCIsXCJhcmdzXCI6XCJcIn0nLCAnKicpO1xuXHRcdFx0fSBlbHNlIGlmKCBlbGVtU3JjLmluZGV4T2YoJ3ZpbmUnKSA+IDAgKSB7XG5cdFx0XHRcdGVsZW1JZnJhbWUuY29udGVudFdpbmRvdy5wb3N0TWVzc2FnZSgnbXV0ZScsICcqJyk7XG5cdFx0XHR9IGVsc2UgaWYoIGVsZW1TcmMuaW5kZXhPZigndmltZW8nKSA+IDAgKSB7XG5cdFx0XHRcdGVsZW1JZnJhbWUuY29udGVudFdpbmRvdy5wb3N0TWVzc2FnZSgne1wibWV0aG9kXCI6XCJwYXVzZVwifScsIGVsZW1TcmMpO1xuXHRcdFx0fSBlbHNle1xuXHRcdFx0XHQvLyBqdXN0IHJlbG9hZCBwYWdlXG5cdFx0XHRcdGVsZW1JZnJhbWUuc3JjID0gZWxlbVNyYztcblx0XHRcdH1cblx0XHR9KTtcblx0fSk7XG5cblx0JChmdW5jdGlvbigpe1xuXHRcdC8vIGdsb2JhbCBrZXljb2RlIGNvbnN0YW50XG5cdFx0dmFyIEtFWUNPREVfRVNDID0gMjcsXG5cdFx0XHRBVkFJTF9DT0RFUyA9IHtcblx0XHRcdFx0bnVtYmVycyA6IFs0OCwgNTddLFxuXHRcdFx0XHR1cHBlcmNhc2UgOiBbNjUsOTBdLFxuXHRcdFx0XHQvLyBsb3dlcmNhc2UgOiBbOTcsIDEyMl1cblx0XHRcdH0sXG5cdFx0XHRDT0RFUyA9IHtcblx0XHRcdFx0QkFDS1NQQUNFOjgsXG5cdFx0XHRcdENPTU1BOjE4OCxcblx0XHRcdFx0REVMRVRFOjQ2LFxuXHRcdFx0XHRET1dOOjQwLFxuXHRcdFx0XHRFTkQ6MzUsXG5cdFx0XHRcdEVOVEVSOjEzLFxuXHRcdFx0XHRFU0NBUEU6MjcsXG5cdFx0XHRcdEhPTUU6MzYsXG5cdFx0XHRcdExFRlQ6MzcsXG5cdFx0XHRcdE5VTVBBRF9BREQ6MTA3LFxuXHRcdFx0XHROVU1QQURfREVDSU1BTDoxMTAsXG5cdFx0XHRcdE5VTVBBRF9ESVZJREU6MTExLFxuXHRcdFx0XHROVU1QQURfRU5URVI6MTA4LFxuXHRcdFx0XHROVU1QQURfTVVMVElQTFk6MTA2LFxuXHRcdFx0XHROVU1QQURfU1VCVFJBQ1Q6MTA5LFxuXHRcdFx0XHRQQUdFX0RPV046MzQsXG5cdFx0XHRcdFBBR0VfVVA6MzMsXG5cdFx0XHRcdFBFUklPRDoxOTAsXG5cdFx0XHRcdFJJR0hUOjM5LFxuXHRcdFx0XHRTUEFDRTozMixcblx0XHRcdFx0VEFCOjksXG5cdFx0XHRcdFVQOjM4LFxuXHRcdFx0XHRDVFJMOjE3XG5cdFx0XHR9LFxuXHRcdFx0Y3RybERvd24gPSBmYWxzZTtcblx0XHQvLyBpbnRpYWxpemVcblx0XHQkKGRvY3VtZW50KS5yZWFkeSggZnVuY3Rpb24oKSB7XG5cdFx0XHQvLyBjYWNoZSB2YXJpYWJsZXNcblx0XHRcdHZhciAkc2VhcmNoID0gJCgnI3NpdGUtc2VhcmNoJyk7XG5cdFx0XHR2YXIgJHNlYXJjaHRleHQgPSAkKCcjc2l0ZS1zZWFyY2ggLnNlYXJjaC1maWVsZCcpO1xuXHRcdFx0dmFyICRzZWFyY2hCdG4gPSAkKCcuaWNvbi5zZWFyY2ggYScpO1xuXHRcdFx0Ly90dXJuIG9mZiBhdXRvY29tcGxldGVcblx0XHRcdCRzZWFyY2h0ZXh0LmF0dHIoJ2F1dG9jb21wbGV0ZScsICdvZmYnKTtcblx0XHRcdC8vIG9uIGFueSBrZXlkb3duLCBzdGFydCBwYXJzaW5nIGtleWJvYXJkIGlucHV0XG5cblx0XHRcdC8vb24gc2VhcmNoIGJ1dHRvbiBjbGlja1xuXHRcdFx0JHNlYXJjaEJ0bi5jbGljayhmdW5jdGlvbigpe1xuXHRcdFx0XHQkc2VhcmNodGV4dC5zaG93KCkuZm9jdXMoKTtcblx0XHRcdFx0JHNlYXJjaC5mYWRlSW4oMjAwKTtcblx0XHRcdH0pO1xuXG5cdFx0XHQkKGRvY3VtZW50KS5rZXlkb3duKGZ1bmN0aW9uKGUpIHtcblx0XHRcdFx0aWYgKGUua2V5Q29kZSA9PT0gQ09ERVMuQ1RSTCB8fCBlLm1ldGFLZXkgfHwgZS5jdHJsS2V5KXtcblx0XHRcdFx0XHRjdHJsRG93biA9IHRydWU7XG5cdFx0XHRcdFx0Y29uc29sZS5sb2coJ2N0cmwgcHJlc3NlZCcpO1xuXHRcdFx0XHR9IGVsc2V7XG5cdFx0XHRcdFx0Y3RybERvd24gPSBmYWxzZTtcblx0XHRcdFx0fVxuXG5cdFx0XHQgIGlmKCRzZWFyY2guaXMoJzp2aXNpYmxlJykpIHtcblx0XHRcdFx0c3dpdGNoIChlLndoaWNoKSB7XG5cdFx0XHRcdCAgY2FzZSBLRVlDT0RFX0VTQzpcblx0XHRcdFx0XHQkc2VhcmNoLmZhZGVPdXQoMjAwKTtcblx0XHRcdFx0XHQkc2VhcmNodGV4dC5ibHVyKCkuaGlkZSgpO1xuXHRcdFx0XHQgIGJyZWFrO1xuXHRcdFx0XHQgIGRlZmF1bHQ6XG5cdFx0XHRcdFx0JHNlYXJjaHRleHQuZm9jdXMoKTtcblx0XHRcdFx0ICBicmVhaztcblx0XHRcdFx0fVxuXHRcdFx0ICB9IGVsc2Uge1xuXHRcdFx0XHRmb3IgKHZhciBrZXkgaW4gQVZBSUxfQ09ERVMpe1xuXHRcdFx0XHRcdGlmKGUud2hpY2ggPj0gQVZBSUxfQ09ERVNba2V5XVswXSAmJiBlLndoaWNoIDw9IEFWQUlMX0NPREVTW2tleV1bMV0gJiYgY3RybERvd24gPT09IGZhbHNlICYmICEoJCgnaW5wdXQsIHRleHRhcmVhJykuaXMoJzpmb2N1cycpKSl7XG5cdFx0XHRcdFx0XHQkc2VhcmNodGV4dC5zaG93KCkuZm9jdXMoKTtcblx0XHRcdFx0XHRcdCRzZWFyY2h0ZXh0LnZhbChTdHJpbmcuZnJvbUNoYXJDb2RlKGUud2hpY2gpLnRvTG93ZXJDYXNlKCkpO1xuXHRcdFx0XHRcdFx0JHNlYXJjaC5mYWRlSW4oMjAwKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdCAgfVxuXHRcdFx0fSk7XG5cdFx0XHQkKCcjY2xvc2Utc2VhcmNoJykuY2xpY2soZnVuY3Rpb24oKXtcblx0XHRcdFx0JHNlYXJjaC5mYWRlT3V0KDIwMCk7XG5cdFx0XHRcdCRzZWFyY2h0ZXh0LmJsdXIoKS5oaWRlKCk7XG5cdFx0XHR9KTtcblxuXHRcdH0pO1xuXHR9KTtcblxuXHQkKGZ1bmN0aW9uKCl7XG5cdFx0JCgnbGkucGFnZV9pdGVtLnNob3AgYScpLmNsaWNrKGZ1bmN0aW9uKCl7XG5cdFx0XHRnYSgnc2VuZCcsICdldmVudCcsICdOYXYgU2hvcCBMaW5rJywgJ2NsaWNrJywgJ0NsaWNrIG9uIHNob3AgbGluayBpbiBuYXYgYmFyJyk7XG5cdFx0fSk7XG5cdH0pO1xuXG5cdCQoZnVuY3Rpb24oKXtcblx0XHQkKGRvY3VtZW50KS5hamF4Q29tcGxldGUoZnVuY3Rpb24oKXtcblx0XHRcdGlmKCQoJyNob21lLWJyZWFrLXNsaWRlcycpLmhhc0NsYXNzKCdzbGljay1zbGlkZXInKSAhPT0gdHJ1ZSl7XG5cdFx0XHRcdCQoJyNob21lLWJyZWFrLXNsaWRlcycpLnNsaWNrKHRyZW5kaW5nT3B0aW9ucyk7XG5cdFx0XHR9XG5cdFx0fSk7XG5cdH0pO1xuXG5cdCQoZnVuY3Rpb24oKXtcblx0XHRpZigkKCcuc3RpY2t5LXNpZGViYXInKS5sZW5ndGggPiAwKXtcblx0XHRcdHZhciB0b3AgPSAkKCcuc3RpY2t5LXNpZGViYXInKS5vZmZzZXQoKS50b3A7XG5cdFx0XHQvL2h0dHBzOi8vZ2l0aHViLmNvbS9sZWFmby9zdGlja3kta2l0L2lzc3Vlc1xuXHRcdFx0JCh3aW5kb3cpLm9uKCdsb2FkIHJlc2l6ZScsIGZ1bmN0aW9uKCl7XG5cdFx0XHRcdGlmKCQoJy5zdGlja3ktc2lkZWJhcicpLmxlbmd0aCA+IDApe1xuXHRcdFx0XHRcdGlmKCQod2luZG93KS53aWR0aCgpIDwgOTkxKXtcblx0XHRcdFx0XHRcdCQoXCIuc3RpY2t5LXNpZGViYXIgLnNpZGViYXJcIikudHJpZ2dlcignc3RpY2t5X2tpdDpkZXRhY2gnKTtcblx0XHRcdFx0XHR9ZWxzZXtcblx0XHRcdFx0XHRcdHZhciB0b3AgPSAkKCcuc3RpY2t5LXNpZGViYXInKS5vZmZzZXQoKS50b3A7XG5cdFx0XHRcdFx0XHQkKFwiLnN0aWNreS1zaWRlYmFyIC5zaWRlYmFyXCIpLnN0aWNrX2luX3BhcmVudCh7XG5cdFx0XHRcdFx0XHRcdHBhcmVudCA6ICQoJy5zdGlja3ktY29udGFpbmVyJyksXG5cdFx0XHRcdFx0XHRcdG9mZnNldF90b3AgOiB0b3Bcblx0XHRcdFx0XHRcdH0pO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXHRcdFx0fSk7XG5cdFx0fVxuXHR9KTtcblxufSApKCBqUXVlcnkgKTtcblxuKGZ1bmN0aW9uKCQpe1xuXHR2YXIgJGxpc3QgPSAkKCcudi1wbGF5ZXItbGlzdCcpLFxuXHRcdCR3aW5kb3cgPSAkKHdpbmRvdyksXG5cdFx0bmV3SGVpZ2h0O1xuXG5cdHZhciByZWNhbGNIZWlnaHQgPSBmdW5jdGlvbigpe1xuXHRcdGlmKCR3aW5kb3cub3V0ZXJXaWR0aCgpID49IDk5Mil7XG5cdFx0XHRuZXdIZWlnaHQgPSAkKCcucGxheWVyLWNvbnRhaW5lcicpLm91dGVySGVpZ2h0KCk7XG5cdFx0XHQkbGlzdC5jc3MoeydoZWlnaHQnIDogbmV3SGVpZ2h0KydweCd9KTtcblx0XHR9ZWxzZXtcblx0XHRcdCRsaXN0LmNzcyh7J2hlaWdodCcgOiAnMzQ4cHgnfSk7XG5cdFx0fVxuXHR9XG5cdHJlY2FsY0hlaWdodCgpO1xuXG5cdCR3aW5kb3cub24oJ2xvYWQgcmVzaXplJywgZnVuY3Rpb24oKXtcblx0XHRyZWNhbGNIZWlnaHQoKTtcblx0fSk7XG59KShqUXVlcnkpO1xuXG4oZnVuY3Rpb24oJCl7XG5cdHZhciBjb250YWluZXJOYW1lO1xuXHRpZigkKCcjaG9tZXBvc3RzJykubGVuZ3RoID4gMCl7XG5cdFx0Y29udGFpbmVyTmFtZSA9ICcjaG9tZXBvc3RzJztcblx0fSBlbHNlIGlmICgkKCcjYXJjaGl2ZXBvc3RzJykubGVuZ3RoID4gMCl7XG5cdFx0Y29udGFpbmVyTmFtZSA9ICcjYXJjaGl2ZXBvc3RzJztcblx0fSBlbHNlIHtcblx0XHRjb250YWluZXJOYW1lID0gbnVsbDtcblx0fVxuXHR2YXIgaWFzID0gJC5pYXMoe1xuXHRcdGNvbnRhaW5lcjogIGNvbnRhaW5lck5hbWUsXG5cdFx0aXRlbTogICAgICAgJy5sb29wLXBvc3QnLFxuXHRcdHBhZ2luYXRpb246ICduYXYucG9zdHMtbmF2aWdhdGlvbicsXG5cdFx0bmV4dDogICAgICAgJy5wb3N0cy1uYXZpZ2F0aW9uIC5uYXYtcHJldmlvdXMgYScsXG5cdFx0bmVnYXRpdmVNYXJnaW46IDEwMCxcblx0XHRkZWxheTogMVxuXHR9KTtcblx0aWFzLmV4dGVuc2lvbihuZXcgSUFTU3Bpbm5lckV4dGVuc2lvbih7XG5cdFx0c3JjIDogJy93cC1jb250ZW50L3VwbG9hZHMvMjAxNS8xMC9kZWZhdWx0LmdpZidcblx0fSkpO1xuXHRpYXMub24oJ3JlbmRlcmVkJywgZnVuY3Rpb24oaXRlbXMpe1xuXHRcdEZCLlhGQk1MLnBhcnNlKCk7XG5cdFx0cmVmcmVzaFNsb3RzKCk7XG5cdH0pO1xuXG5cdGlhcy5vbignbm9uZUxlZnQnLCBmdW5jdGlvbigpIHtcblx0XHRcdCQoJy5sb2FkLW1vcmUtdHJpZ2dlcicpLnJlbW92ZSgpO1xuXHR9KTtcblxuXHR2YXIgaSA9IDA7XG5cdCQuaWFzKCkub24oJ3JlbmRlcicsIGZ1bmN0aW9uKGl0ZW1zKSB7XG5cdFx0aSsrO1xuXHRcdGNvbnNvbGUubG9nKGkpO1xuXHRcdGlmKGkgPT09IDIpe1xuXHRcdFx0aWFzLmV4dGVuc2lvbihuZXcgSUFTVHJpZ2dlckV4dGVuc2lvbih7XG5cdFx0XHRcdHRleHQ6ICdWSUVXIE1PUkUgSEFIQVMnLFxuXHRcdFx0XHRodG1sOiAnPGRpdiBjbGFzcz1cImxvYWQtbW9yZS10cmlnZ2VyIHRleHQtY2VudGVyXCI+PGEgY2xhc3M9XCJidG4gYnRuLXByaW1hcnlcIj57dGV4dH08L2E+PC9kaXY+J1xuXHRcdFx0fSkpO1xuXHRcdH1cblx0fSk7XG5cbn0pKGpRdWVyeSk7XG5cbihmdW5jdGlvbigkKXtcblx0dmFyICRib2R5ID0gJCgnYm9keScpO1xuXG5cdCRib2R5Lm9uKCdjbGljaycsICcudmlkZW8tb3ZlcmxheSBhJywgZnVuY3Rpb24oZSl7XG5cdFx0Ly8gZS5wcmV2ZW50RGVmYXVsdCgpO1xuXHRcdHZhciB0aXRsZSA9ICQoZS5jdXJyZW50VGFyZ2V0KS5maW5kKCdzcGFuJyk7XG5cdFx0Z2EoJ3NlbmQnLCAnZXZlbnQnLCAnVmlkZW8gT3ZlcmxheScsICdjbGljaycsICcnK3RpdGxlLnRleHQoKSsnJyk7XG5cdFx0Ly8gY29uc29sZS5sb2coXCJnYSgnc2VuZCcsICdldmVudCcsICdWaWRlbyBPdmVybGF5JywgJ2NsaWNrJywgJ1wiK3RpdGxlLnRleHQoKStcIicpO1wiKTtcblx0fSk7XG59KShqUXVlcnkpO1xuXG4oZnVuY3Rpb24oJCl7XG5cdHZhciAkbGlua3MgPSAkKCdpbWcnKSxcblx0XHR0aXRsZSA9ICQoJ3RpdGxlJykuaHRtbCgpO1xuXG5cdCRsaW5rcy5lYWNoKGZ1bmN0aW9uKGtleSwgdmFsdWUpe1xuXHRcdGlmKCQodmFsdWUpLmF0dHIoJ2FsdCcpID09IG51bGwpe1xuXHRcdFx0JCh2YWx1ZSkucHJvcCgnYWx0JywgdGl0bGUpO1xuXHRcdH1cblx0fSk7XG5cbn0pKGpRdWVyeSk7XG5cbi8vIEdsb2JhbCBmdW5jdGlvbiBmb3Igc29jaWFsIGljb25zIG9uIHBvc3QgcGFnZXNcbmZ1bmN0aW9uIHNvY2lhbFNoYXJlKHVybCwgd2lkdGgsIGhlaWdodCkge1xuXHR2YXIgd2luTGVmdCA9ICh3aW5kb3cuaW5uZXJXaWR0aCAvIDIpIC0gKHdpZHRoIC8gMik7XG5cdHZhciB3aW5Ub3AgPSAod2luZG93LmlubmVySGVpZ2h0IC8gMikgLSAoaGVpZ2h0IC8gMik7XG5cdHdpbmRvdy5vcGVuKHVybCwgJycsICdtZW51YmFyPW5vLHRvb2xiYXI9bm8scmVzaXphYmxlPXllcyxzY3JvbGxiYXJzPXllcyxoZWlnaHQ9JytoZWlnaHQrJyx3aWR0aD0nK3dpZHRoKycsdG9wPScrd2luVG9wKycsbGVmdD0nK3dpbkxlZnQpO1xufVxuXG4vKlxuICogQWRkIGdvb2dsZSBldmVudCB3aGVuIHlvdXR1YmUgc3Vic2NyaWJlIGlmcmFtZSBpcyBjbGlja2VkIGluIGludGVyc3RpdGlhbCBhZFxuICovXG4oZnVuY3Rpb24oJCl7XG5cdCQod2luZG93KS5sb2FkKGZ1bmN0aW9uKCl7XG5cdFx0aWYgKCQoJyNfX195dHN1YnNjcmliZV8wJykubGVuZ3RoID4gMCkge1xuXHRcdFx0dmFyIGlmcmFtZVl0ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ19fX3l0c3Vic2NyaWJlXzAnKS5maXJzdEVsZW1lbnRDaGlsZDtcblx0XHRcdGZvY3VzKCk7XG5cdFx0XHR2YXIgbGlzdGVuZXIgPSBhZGRFdmVudExpc3RlbmVyKCdibHVyJywgZnVuY3Rpb24oKSB7XG5cdFx0XHRcdGlmKGRvY3VtZW50LmFjdGl2ZUVsZW1lbnQgPT09IGlmcmFtZVl0KSB7XG5cdFx0XHRcdFx0Z2EoJ3NlbmQnLCAnZXZlbnQnLCAnSW50ZXJzdGl0aWFsIEFkJywgJ2NsaWNrJywgJ1N1YnNjcmliZSB0byBXaG9IYWhhIG9uIFlvdXR1YmUnKTtcblx0XHRcdFx0fVxuXHRcdFx0XHRyZW1vdmVFdmVudExpc3RlbmVyKCdibHVyJywgbGlzdGVuZXIpO1xuXHRcdFx0fSk7XG5cdFx0fVxuXHR9KTtcbn0pKGpRdWVyeSk7XG5cbi8qXG4gKiBBZGQgY29udHJvbHMgdG8gbnVtYmVyIGlucHV0XG4gKi9cbihmdW5jdGlvbigkKXtcblx0dmFyIHdvbyA9ICQoZG9jdW1lbnQpO1xuXHR2YXIgaW5wdXQgPSAkKHdvbykuZmluZCgnLnF1YW50aXR5IGlucHV0Jyk7XG5cblx0Ly8gJCh3b28pLmZpbmQoJy5xdWFudGl0eScpO1xuXHRcdC8vIC5wcmVwZW5kKCc8c3BhbiBjbGFzcz1cImlucHV0LW51bSBpbnB1dC1udW1iZXItZGVjcmVtZW50XCI+LTwvc3Bhbj4nKVxuXHRcdC8vIC5hcHBlbmQoJzxzcGFuIGNsYXNzPVwiaW5wdXQtbnVtIGlucHV0LW51bWJlci1pbmNyZW1lbnRcIj4rPC9zcGFuPicpO1xuXG5cdHZhciB2YWwgPSBpbnB1dC52YWwoKTtcblx0dmFyIGlucHV0TWluID0gaW5wdXQuYXR0cignbWluJyk7XG5cdHZhciBpbmNyQnRuID0gJCgnLmlucHV0LW51bWJlci1pbmNyZW1lbnQnKTtcblx0dmFyIGRlY3JCdG4gPSAkKCcuaW5wdXQtbnVtYmVyLWRlY3JlbWVudCcpO1xuXG5cdCQoZG9jdW1lbnQpLm9uKCdjbGljaycsICcuaW5wdXQtbnVtJywgZnVuY3Rpb24oZSl7XG5cdFx0Ly8gcmVkZWZpbmUgaW5wdXQgaW4gY2FzZSBidXR0b24gcmVwbGFjZWQgd2l0aCBhamF4XG5cdFx0aW5wdXQgPSAkKGUuY3VycmVudFRhcmdldCkuc2libGluZ3MoJy5xdWFudGl0eScpLmZpbmQoJ2lucHV0Jyk7XG5cdFx0dmFsID0gaW5wdXQudmFsKCk7XG5cblx0XHRpZigkKGUudGFyZ2V0KS5oYXNDbGFzcygnaW5wdXQtbnVtYmVyLWRlY3JlbWVudCcpKXtcblx0XHRcdGRlY3JlYXNlKCk7XG5cdFx0fVxuXHRcdGVsc2UgaWYoJChlLnRhcmdldCkuaGFzQ2xhc3MoJ2lucHV0LW51bWJlci1pbmNyZW1lbnQnKSl7XG5cdFx0XHRpbmNyZWFzZSgpO1xuXHRcdH1cblx0XHR2YWwgPSBpbnB1dC52YWwoKTtcblx0XHQkKCdpbnB1dFtuYW1lPVwidXBkYXRlX2NhcnRcIl0nKS5hdHRyKCdkaXNhYmxlZCcsIGZhbHNlKTtcblx0fSk7XG5cblx0ZnVuY3Rpb24gaW5jcmVhc2UoKXtcblx0XHRjb25zb2xlLmxvZyhpbnB1dCk7XG5cdFx0JChpbnB1dCkuYXR0cigndmFsdWUnLCBwYXJzZUludCh2YWwpKzEpO1xuXHR9XG5cdGZ1bmN0aW9uIGRlY3JlYXNlKCl7XG5cdFx0aWYodmFsID4gaW5wdXRNaW4pe1xuXHRcdFx0JChpbnB1dCkuYXR0cigndmFsdWUnLCBwYXJzZUludCh2YWwpLTEpO1xuXHRcdH1cblx0fVxufSkoalF1ZXJ5KTtcblxuKGZ1bmN0aW9uKCQpe1xuXHR2YXIgbWFpbl9pbWdfbGluayA9ICQoJ2Eud29vY29tbWVyY2UtbWFpbi1pbWFnZScpO1xuXHR2YXIgbWFpbl9pbWcgPSAkKG1haW5faW1nX2xpbmspLmZpbmQoJ2ltZycpO1xuXG5cdCQoJy5pbWFnZXMgLnRodW1ibmFpbHMgPiBhJykub24oJ2NsaWNrJywgZnVuY3Rpb24oZSl7XG5cdFx0ZS5wcmV2ZW50RGVmYXVsdCgpO1xuXHRcdHZhciBzZWxlY3RlZCA9ICQodGhpcyk7XG5cdFx0dmFyIHNlbGVjdGVkSW1nID0gJChzZWxlY3RlZCkuZmluZCgnaW1nJyk7XG5cblx0XHR2YXIgbmV3TGluayA9ICQoc2VsZWN0ZWQpLmF0dHIoJ2hyZWYnKTtcblx0XHR2YXIgbmV3U3JjID0gJChzZWxlY3RlZEltZykuYXR0cignc3JjJyk7XG5cdFx0dmFyIG5ld1NyY3NldCA9ICQoc2VsZWN0ZWRJbWcpLmF0dHIoJ3NyY3NldCcpO1xuXG5cdFx0JChtYWluX2ltZ19saW5rKS5hdHRyKCdocmVmJywgbmV3TGluayk7XG5cdFx0JChtYWluX2ltZykuYXR0cignc3JjJywgbmV3U3JjKS5hdHRyKCdzcmNzZXQnLCBuZXdTcmNzZXQpO1xuXHR9KTtcbn0pKGpRdWVyeSk7XG5cbihmdW5jdGlvbigkKXtcblx0bGlnaHRib3gub3B0aW9uKHtcblx0ICAncmVzaXplRHVyYXRpb24nOiAzMDAsXG5cdFx0XHQnZGlzYWJsZVNjcm9sbGluZycgOiB0cnVlXG5cdH0pO1xufSkoalF1ZXJ5KTtcblxuKGZ1bmN0aW9uKCQpe1xuXHRpZiAoICQoJy5tYXRjaC1oZWlnaHQnKS5sZW5ndGggPiAwIClcblx0XHQkKCcubWF0Y2gtaGVpZ2h0JykubWF0Y2hIZWlnaHQoKTtcblxuXHQkKCcjcGFnZS5nb3BpdGNoeW91cnNlbGYgLmJnLXBpbmsgc3BhbicpLmZpdFRleHQoLjU4KTtcblx0JCgnI3BhZ2UuZ29waXRjaHlvdXJzZWxmIC5iZy1wdXJwbGUgc3BhbicpLmZpdFRleHQoMS4wNSk7XG5cdCQoJyNwYWdlLmdvcGl0Y2h5b3Vyc2VsZiAuYmctYmx1ZSBzcGFuJykuZml0VGV4dCguODcpO1xufSkoalF1ZXJ5KTtcblxuKGZ1bmN0aW9uKCQpe1xuXHRmdW5jdGlvbiBmbG9hdExhYmVsKGlucHV0VHlwZSl7XG5cdFx0JChpbnB1dFR5cGUpLmVhY2goZnVuY3Rpb24oKXtcblx0XHRcdHZhciAkdGhpcyA9ICQodGhpcykuZmluZCgnaW5wdXQnKTtcblx0XHRcdC8vIG9uIGZvY3VzIGFkZCBjbGFkZCBhY3RpdmUgdG8gbGFiZWxcblx0XHRcdCR0aGlzLmZvY3VzKGZ1bmN0aW9uKCl7XG5cdFx0XHRcdCR0aGlzLnBhcmVudCgpLnNpYmxpbmdzKCdsYWJlbCcpLmFkZENsYXNzKFwiYWN0aXZlXCIpO1xuXHRcdFx0fSk7XG5cdFx0XHQvL29uIGJsdXIgY2hlY2sgZmllbGQgYW5kIHJlbW92ZSBjbGFzcyBpZiBuZWVkZWRcblx0XHRcdCR0aGlzLmJsdXIoZnVuY3Rpb24oKXtcblx0XHRcdFx0aWYoJHRoaXMudmFsKCkgPT09ICcnIHx8ICR0aGlzLnZhbCgpID09PSAnYmxhbmsnKXtcblx0XHRcdFx0XHQkdGhpcy5wYXJlbnQoKS5zaWJsaW5ncygnbGFiZWwnKS5yZW1vdmVDbGFzcygpO1xuXHRcdFx0XHR9XG5cdFx0XHR9KTtcblx0XHR9KTtcblx0fVxuXHQvLyBqdXN0IGFkZCBhIGNsYXNzIG9mIFwiZmxvYXRMYWJlbCB0byB0aGUgaW5wdXQgZmllbGQhXCJcblx0ZmxvYXRMYWJlbChcIi5mbG9hdGxhYmVsXCIpO1xuXG5cdGpRdWVyeSgnLmVudHJ5LWZvcm0tY29udGFpbmVyIHNlbGVjdC5mb3JtLWNvbnRyb2wnKS5zZWxlY3QyKCk7XG59KShqUXVlcnkpO1xuXG4oZnVuY3Rpb24oJCl7XG5cdCQoJy53aGgtcGxheWxpc3RzIGFydGljbGUuaGFzLXRvb2x0aXAnKS5wb3BvdmVyKHtcblx0XHRodG1sOiB0cnVlLFxuXHRcdC8vIHRyaWdnZXI6ICdjbGljaycsXG5cdFx0dHJpZ2dlciA6ICdtYW51YWwnLFxuXHRcdGNvbnRhaW5lciA6ICcud2hoLXBsYXlsaXN0cycsXG5cdFx0cGxhY2VtZW50IDogJ2F1dG8gcmlnaHQnLFxuXHRcdHRpdGxlIDogJCh0aGlzKS5zaWJsaW5ncygnLnBsaXN0LXBvcG92ZXItdGl0bGUnKS50ZXh0KCksXG5cdFx0Y29udGVudCA6IGZ1bmN0aW9uKCkge1xuXHRcdFx0cmV0dXJuICQodGhpcykuc2libGluZ3MoJy5wbGlzdC1wb3BvdmVyLWNvbnRlbnQnKS5odG1sKCk7XG5cdFx0fVxuXHR9KVxuXHQub24oXCJtb3VzZWVudGVyXCIsIGZ1bmN0aW9uICgpIHtcblx0XHRpZiAod2luZG93LmlubmVyV2lkdGggPiA3MDApIHtcblx0XHRcdHZhciBfdGhpcyA9IHRoaXM7XG5cdFx0XHQkKHRoaXMpLnBvcG92ZXIoXCJzaG93XCIpLmFkZENsYXNzKCdhY3RpdmUnKTtcblx0XHRcdCQoXCIucG9wb3ZlclwiKS5vbihcIm1vdXNlbGVhdmVcIiwgZnVuY3Rpb24gKCkge1xuXHRcdFx0XHRzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7XG5cdFx0XHRcdFx0aWYgKCEkKF90aGlzKS5pcygnOmhvdmVyJykpIHtcblx0XHRcdFx0XHRcdCQoX3RoaXMpLnBvcG92ZXIoXCJoaWRlXCIpLnJlbW92ZUNsYXNzKCdhY3RpdmUnKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH0sIDEwMCk7XG5cdFx0XHR9KTtcblx0XHR9XG5cdH0pLm9uKFwibW91c2VsZWF2ZVwiLCBmdW5jdGlvbiAoKSB7XG5cdFx0dmFyIF90aGlzID0gdGhpcztcblx0XHRzZXRUaW1lb3V0KGZ1bmN0aW9uICgpIHtcblx0XHRcdGlmICghJChcIi5wb3BvdmVyOmhvdmVyXCIpLmxlbmd0aCkge1xuXHRcdFx0XHQkKF90aGlzKS5wb3BvdmVyKFwiaGlkZVwiKS5yZW1vdmVDbGFzcygnYWN0aXZlJyk7XG5cdFx0XHR9XG5cdFx0fSwgMTAwKTtcblx0fSk7XG5cblx0JCgnLnBsYXlsaXN0LWNhcm91c2VsJykuc2xpY2soe1xuXHRcdGRvdHM6IGZhbHNlLFxuXHRcdGluZmluaXRlOiBmYWxzZSxcblx0XHRhcnJvd3M6IHRydWUsXG5cdFx0c3BlZWQ6IDMwMCxcblx0XHRhdXRvcGxheTogZmFsc2UsXG5cdFx0YXV0b3BsYXlTcGVlZDogMzAwMCxcblx0XHRzbGlkZXNUb1Nob3c6IDMsXG5cdFx0c2xpZGVzVG9TY3JvbGw6IDMsXG5cdFx0Ly8gbGF6eUxvYWQ6ICdvbmRlbWFuZCcsXG5cdFx0ZHJhZ2dhYmxlOiBmYWxzZSxcblx0XHRyZXNwb25zaXZlOiBbXG5cdFx0XHR7XG5cdFx0XHRcdGJyZWFrcG9pbnQ6IDk5MSxcblx0XHRcdFx0c2V0dGluZ3M6IHtcblx0XHRcdFx0ICBzbGlkZXNUb1Nob3c6IDIsXG5cdFx0XHRcdCAgc2xpZGVzVG9TY3JvbGw6IDJcblx0XHRcdFx0fVxuXHRcdFx0fSxcblx0XHRcdHtcblx0XHRcdFx0YnJlYWtwb2ludDogNzAwLFxuXHRcdFx0XHRzZXR0aW5nczoge1xuXHRcdFx0XHQgIHNsaWRlc1RvU2hvdzogMSxcblx0XHRcdFx0ICBzbGlkZXNUb1Njcm9sbDogMVxuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0XVxuXHR9KTtcblx0JCgnLnNpbmdsZS1wbGF5bGlzdC1jYXJvdXNlbCcpLnNsaWNrKHtcblx0XHRkb3RzOiBmYWxzZSxcblx0XHRpbmZpbml0ZTogZmFsc2UsXG5cdFx0YXJyb3dzOiB0cnVlLFxuXHRcdHNwZWVkOiAzMDAsXG5cdFx0YXV0b3BsYXk6IGZhbHNlLFxuXHRcdGF1dG9wbGF5U3BlZWQ6IDMwMDAsXG5cdFx0c2xpZGVzVG9TaG93OiA0LFxuXHRcdHNsaWRlc1RvU2Nyb2xsOiA0LFxuXHRcdC8vIGxhenlMb2FkOiAnb25kZW1hbmQnLFxuXHRcdGRyYWdnYWJsZTogZmFsc2UsXG5cdFx0c3dpcGU6IGZhbHNlLFxuXHRcdHJlc3BvbnNpdmU6IFtcblx0XHRcdHtcblx0XHRcdFx0YnJlYWtwb2ludDogOTkxLFxuXHRcdFx0XHRzZXR0aW5nczoge1xuXHRcdFx0XHQgIHNsaWRlc1RvU2hvdzogMyxcblx0XHRcdFx0ICBzbGlkZXNUb1Njcm9sbDogM1xuXHRcdFx0XHR9XG5cdFx0XHR9LFxuXHRcdFx0e1xuXHRcdFx0XHRicmVha3BvaW50OiA3MDAsXG5cdFx0XHRcdHNldHRpbmdzOiB7XG5cdFx0XHRcdCAgc2xpZGVzVG9TaG93OiAyLFxuXHRcdFx0XHQgIHNsaWRlc1RvU2Nyb2xsOiAyXG5cdFx0XHRcdH1cblx0XHRcdH0sXG5cdFx0XHR7XG5cdFx0XHRcdGJyZWFrcG9pbnQ6IDUwMCxcblx0XHRcdFx0c2V0dGluZ3M6IHtcblx0XHRcdFx0ICBzbGlkZXNUb1Nob3c6IDEsXG5cdFx0XHRcdCAgc2xpZGVzVG9TY3JvbGw6IDFcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdF1cblx0fSk7XG59KShqUXVlcnkpO1xuIiwiKGZ1bmN0aW9uKCQpe1xuXHQkKGRvY3VtZW50KS5vbihcImNsaWNrXCIsIFwiYSN0YWctZ2VuZXJhdGVcIiwgZnVuY3Rpb24oZXZlbnQpe1xuXHRcdGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG5cblx0XHRnYSgnc2VuZCcsICdldmVudCcsICdUYWcgR2VuZXJhdG9yJywgJ2NsaWNrJywgJ0dlbmVyYXRlIHJhbmRvbSB0YWdzIGluIG5hdmJhcicpO1xuXG5cdFx0JGNsaWNrZWQgPSAkKHRoaXMpO1xuXHRcdCRsaXN0ID0gJGNsaWNrZWQuY2xvc2VzdCgndWwnKTtcblx0XHQkY29udGFpbmVyID0gJCgnLmdlbmVyYXRlLXRhZ3MnKTtcblx0XHQkKCcucmVsb2FkdGFncycpLmFkZENsYXNzKCdsb2FkaW5nJyk7XG5cblx0XHQkLmFqYXgoe1xuXHRcdFx0dXJsIDogJy93cC1hZG1pbi9hZG1pbi1hamF4LnBocCcsXG5cdFx0XHRtZXRob2QgOiAnUE9TVCcsXG5cdFx0XHRkYXRhIDoge1xuXHRcdFx0XHQnYWN0aW9uJyA6ICdnZW5lcmF0ZV9yYW5kX3RhZ3NfYWpheCdcblx0XHRcdH1cblx0XHR9KVxuXHRcdC5kb25lKGZ1bmN0aW9uKG91dHB1dCl7XG5cdFx0XHQkY29udGFpbmVyLmh0bWwob3V0cHV0KTtcblx0XHRcdC8vICRjb250YWluZXIuZmluZCgnYScpLnJlbW92ZUF0dHIoJ3N0eWxlJyk7XG5cdFx0fSlcblx0XHQuZmFpbChmdW5jdGlvbihqcVhIUiwgdGV4dFN0YXR1cyl7XG5cdFx0XHRjb25zb2xlLmxvZygnZXJyb3InLCB0ZXh0U3RhdHVzKTtcblx0XHR9KVxuXHRcdC5hbHdheXMoZnVuY3Rpb24ob3V0cHV0KXtcblx0XHRcdCQoJy5yZWxvYWR0YWdzJykucmVtb3ZlQ2xhc3MoJ2xvYWRpbmcnKTtcblx0XHR9KTtcblx0fSk7XG59KShqUXVlcnkpOyJdfQ==
