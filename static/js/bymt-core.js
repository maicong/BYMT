/**
 * bymt.js
 *
 * @author      MaiCong <i@maicong.me>
 * @date        2015-08-12
 * @package     WordPress
 * @subpackage  BYMT
 * @since       BYMT Release 3.0.0
 */

/* NProgress v0.2.0 https://github.com/rstacruz/nprogress */
!function(n,e){"function"==typeof define&&define.amd?define(e):"object"==typeof exports?module.exports=e():n.NProgress=e()}(this,function(){function n(n,e,t){return e>n?e:n>t?t:n}function e(n){return 100*(-1+n)}function t(n,t,r){var i;return i="translate3d"===c.positionUsing?{transform:"translate3d("+e(n)+"%,0,0)"}:"translate"===c.positionUsing?{transform:"translate("+e(n)+"%,0)"}:{"margin-left":e(n)+"%"},i.transition="all "+t+"ms "+r,i}function r(n,e){var t="string"==typeof n?n:o(n);return t.indexOf(" "+e+" ")>=0}function i(n,e){var t=o(n),i=t+e;r(t,e)||(n.className=i.substring(1))}function s(n,e){var t,i=o(n);r(n,e)&&(t=i.replace(" "+e+" "," "),n.className=t.substring(1,t.length-1))}function o(n){return(" "+(n.className||"")+" ").replace(/\s+/gi," ")}function a(n){n&&n.parentNode&&n.parentNode.removeChild(n)}var u={};u.version="0.2.0";var c=u.settings={minimum:.08,easing:"ease",positionUsing:"",speed:200,trickle:!0,trickleRate:.02,trickleSpeed:800,showSpinner:!0,barSelector:'[role="bar"]',spinnerSelector:'[role="spinner"]',parent:"body",template:'<div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div>'};u.configure=function(n){var e,t;for(e in n)t=n[e],void 0!==t&&n.hasOwnProperty(e)&&(c[e]=t);return this},u.status=null,u.set=function(e){var r=u.isStarted();e=n(e,c.minimum,1),u.status=1===e?null:e;var i=u.render(!r),s=i.querySelector(c.barSelector),o=c.speed,a=c.easing;return i.offsetWidth,l(function(n){""===c.positionUsing&&(c.positionUsing=u.getPositioningCSS()),f(s,t(e,o,a)),1===e?(f(i,{transition:"none",opacity:1}),i.offsetWidth,setTimeout(function(){f(i,{transition:"all "+o+"ms linear",opacity:0}),setTimeout(function(){u.remove(),n()},o)},o)):setTimeout(n,o)}),this},u.isStarted=function(){return"number"==typeof u.status},u.start=function(){u.status||u.set(0);var n=function(){setTimeout(function(){u.status&&(u.trickle(),n())},c.trickleSpeed)};return c.trickle&&n(),this},u.done=function(n){return n||u.status?u.inc(.3+.5*Math.random()).set(1):this},u.inc=function(e){var t=u.status;return t?("number"!=typeof e&&(e=(1-t)*n(Math.random()*t,.1,.95)),t=n(t+e,0,.994),u.set(t)):u.start()},u.trickle=function(){return u.inc(Math.random()*c.trickleRate)},function(){var n=0,e=0;u.promise=function(t){return t&&"resolved"!==t.state()?(0===e&&u.start(),n++,e++,t.always(function(){e--,0===e?(n=0,u.done()):u.set((n-e)/n)}),this):this}}(),u.render=function(n){if(u.isRendered())return document.getElementById("nprogress");i(document.documentElement,"nprogress-busy");var t=document.createElement("div");t.id="nprogress",t.innerHTML=c.template;var r,s=t.querySelector(c.barSelector),o=n?"-100":e(u.status||0),l=document.querySelector(c.parent);return f(s,{transition:"all 0 linear",transform:"translate3d("+o+"%,0,0)"}),c.showSpinner||(r=t.querySelector(c.spinnerSelector),r&&a(r)),l!=document.body&&i(l,"nprogress-custom-parent"),l.appendChild(t),t},u.remove=function(){s(document.documentElement,"nprogress-busy"),s(document.querySelector(c.parent),"nprogress-custom-parent");var n=document.getElementById("nprogress");n&&a(n)},u.isRendered=function(){return!!document.getElementById("nprogress")},u.getPositioningCSS=function(){var n=document.body.style,e="WebkitTransform"in n?"Webkit":"MozTransform"in n?"Moz":"msTransform"in n?"ms":"OTransform"in n?"O":"";return e+"Perspective"in n?"translate3d":e+"Transform"in n?"translate":"margin"};var l=function(){function n(){var t=e.shift();t&&t(n)}var e=[];return function(t){e.push(t),1==e.length&&n()}}(),f=function(){function n(n){return n.replace(/^-ms-/,"ms-").replace(/-([\da-z])/gi,function(n,e){return e.toUpperCase()})}function e(n){var e=document.body.style;if(n in e)return n;for(var t,r=i.length,s=n.charAt(0).toUpperCase()+n.slice(1);r--;)if(t=i[r]+s,t in e)return t;return n}function t(t){return t=n(t),s[t]||(s[t]=e(t))}function r(n,e,r){e=t(e),n.style[e]=r}var i=["Webkit","O","Moz","ms"],s={};return function(n,e){var t,i,s=arguments;if(2==s.length)for(t in e)i=e[t],void 0!==i&&e.hasOwnProperty(t)&&r(n,t,i);else r(n,s[1],s[2])}}();return u});

/* isMobile https://github.com/kaimallea/isMobile */
!function(a){var b=/iPhone/i,c=/iPod/i,d=/iPad/i,e=/(?=.*\bAndroid\b)(?=.*\bMobile\b)/i,f=/Android/i,g=/(?=.*\bAndroid\b)(?=.*\bSD4930UR\b)/i,h=/(?=.*\bAndroid\b)(?=.*\b(?:KFOT|KFTT|KFJWI|KFJWA|KFSOWI|KFTHWI|KFTHWA|KFAPWI|KFAPWA|KFARWI|KFASWI|KFSAWI|KFSAWA)\b)/i,i=/IEMobile/i,j=/(?=.*\bWindows\b)(?=.*\bARM\b)/i,k=/BlackBerry/i,l=/BB10/i,m=/Opera Mini/i,n=/(CriOS|Chrome)(?=.*\bMobile\b)/i,o=/(?=.*\bFirefox\b)(?=.*\bMobile\b)/i,p=new RegExp("(?:Nexus 7|BNTV250|Kindle Fire|Silk|GT-P1000)","i"),q=function(a,b){return a.test(b)},r=function(a){var r=a||navigator.userAgent,s=r.split("[FBAN");return"undefined"!=typeof s[1]&&(r=s[0]),this.apple={phone:q(b,r),ipod:q(c,r),tablet:!q(b,r)&&q(d,r),device:q(b,r)||q(c,r)||q(d,r)},this.amazon={phone:q(g,r),tablet:!q(g,r)&&q(h,r),device:q(g,r)||q(h,r)},this.android={phone:q(g,r)||q(e,r),tablet:!q(g,r)&&!q(e,r)&&(q(h,r)||q(f,r)),device:q(g,r)||q(h,r)||q(e,r)||q(f,r)},this.windows={phone:q(i,r),tablet:q(j,r),device:q(i,r)||q(j,r)},this.other={blackberry:q(k,r),blackberry10:q(l,r),opera:q(m,r),firefox:q(o,r),chrome:q(n,r),device:q(k,r)||q(l,r)||q(m,r)||q(o,r)||q(n,r)},this.seven_inch=q(p,r),this.any=this.apple.device||this.android.device||this.windows.device||this.other.device||this.seven_inch,this.phone=this.apple.phone||this.android.phone||this.windows.phone,this.tablet=this.apple.tablet||this.android.tablet||this.windows.tablet,"undefined"==typeof window?this:void 0},s=function(){var a=new r;return a.Class=r,a};"undefined"!=typeof module&&module.exports&&"undefined"==typeof window?module.exports=r:"undefined"!=typeof module&&module.exports&&"undefined"!=typeof window?module.exports=s():"function"==typeof define&&define.amd?define("isMobile",[],a.isMobile=s()):a.isMobile=s()}(this);

/* imagesLoaded PACKAGED v3.1.8 https://github.com/desandro/imagesloaded */
(function(){function e(){}function t(e,t){for(var n=e.length;n--;)if(e[n].listener===t)return n;return-1}function n(e){return function(){return this[e].apply(this,arguments)}}var i=e.prototype,r=this,o=r.EventEmitter;i.getListeners=function(e){var t,n,i=this._getEvents();if("object"==typeof e){t={};for(n in i)i.hasOwnProperty(n)&&e.test(n)&&(t[n]=i[n])}else t=i[e]||(i[e]=[]);return t},i.flattenListeners=function(e){var t,n=[];for(t=0;e.length>t;t+=1)n.push(e[t].listener);return n},i.getListenersAsObject=function(e){var t,n=this.getListeners(e);return n instanceof Array&&(t={},t[e]=n),t||n},i.addListener=function(e,n){var i,r=this.getListenersAsObject(e),o="object"==typeof n;for(i in r)r.hasOwnProperty(i)&&-1===t(r[i],n)&&r[i].push(o?n:{listener:n,once:!1});return this},i.on=n("addListener"),i.addOnceListener=function(e,t){return this.addListener(e,{listener:t,once:!0})},i.once=n("addOnceListener"),i.defineEvent=function(e){return this.getListeners(e),this},i.defineEvents=function(e){for(var t=0;e.length>t;t+=1)this.defineEvent(e[t]);return this},i.removeListener=function(e,n){var i,r,o=this.getListenersAsObject(e);for(r in o)o.hasOwnProperty(r)&&(i=t(o[r],n),-1!==i&&o[r].splice(i,1));return this},i.off=n("removeListener"),i.addListeners=function(e,t){return this.manipulateListeners(!1,e,t)},i.removeListeners=function(e,t){return this.manipulateListeners(!0,e,t)},i.manipulateListeners=function(e,t,n){var i,r,o=e?this.removeListener:this.addListener,s=e?this.removeListeners:this.addListeners;if("object"!=typeof t||t instanceof RegExp)for(i=n.length;i--;)o.call(this,t,n[i]);else for(i in t)t.hasOwnProperty(i)&&(r=t[i])&&("function"==typeof r?o.call(this,i,r):s.call(this,i,r));return this},i.removeEvent=function(e){var t,n=typeof e,i=this._getEvents();if("string"===n)delete i[e];else if("object"===n)for(t in i)i.hasOwnProperty(t)&&e.test(t)&&delete i[t];else delete this._events;return this},i.removeAllListeners=n("removeEvent"),i.emitEvent=function(e,t){var n,i,r,o,s=this.getListenersAsObject(e);for(r in s)if(s.hasOwnProperty(r))for(i=s[r].length;i--;)n=s[r][i],n.once===!0&&this.removeListener(e,n.listener),o=n.listener.apply(this,t||[]),o===this._getOnceReturnValue()&&this.removeListener(e,n.listener);return this},i.trigger=n("emitEvent"),i.emit=function(e){var t=Array.prototype.slice.call(arguments,1);return this.emitEvent(e,t)},i.setOnceReturnValue=function(e){return this._onceReturnValue=e,this},i._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},i._getEvents=function(){return this._events||(this._events={})},e.noConflict=function(){return r.EventEmitter=o,e},"function"==typeof define&&define.amd?define("eventEmitter/EventEmitter",[],function(){return e}):"object"==typeof module&&module.exports?module.exports=e:this.EventEmitter=e}).call(this),function(e){function t(t){var n=e.event;return n.target=n.target||n.srcElement||t,n}var n=document.documentElement,i=function(){};n.addEventListener?i=function(e,t,n){e.addEventListener(t,n,!1)}:n.attachEvent&&(i=function(e,n,i){e[n+i]=i.handleEvent?function(){var n=t(e);i.handleEvent.call(i,n)}:function(){var n=t(e);i.call(e,n)},e.attachEvent("on"+n,e[n+i])});var r=function(){};n.removeEventListener?r=function(e,t,n){e.removeEventListener(t,n,!1)}:n.detachEvent&&(r=function(e,t,n){e.detachEvent("on"+t,e[t+n]);try{delete e[t+n]}catch(i){e[t+n]=void 0}});var o={bind:i,unbind:r};"function"==typeof define&&define.amd?define("eventie/eventie",o):e.eventie=o}(this),function(e,t){"function"==typeof define&&define.amd?define(["eventEmitter/EventEmitter","eventie/eventie"],function(n,i){return t(e,n,i)}):"object"==typeof exports?module.exports=t(e,require("wolfy87-eventemitter"),require("eventie")):e.imagesLoaded=t(e,e.EventEmitter,e.eventie)}(window,function(e,t,n){function i(e,t){for(var n in t)e[n]=t[n];return e}function r(e){return"[object Array]"===d.call(e)}function o(e){var t=[];if(r(e))t=e;else if("number"==typeof e.length)for(var n=0,i=e.length;i>n;n++)t.push(e[n]);else t.push(e);return t}function s(e,t,n){if(!(this instanceof s))return new s(e,t);"string"==typeof e&&(e=document.querySelectorAll(e)),this.elements=o(e),this.options=i({},this.options),"function"==typeof t?n=t:i(this.options,t),n&&this.on("always",n),this.getImages(),a&&(this.jqDeferred=new a.Deferred);var r=this;setTimeout(function(){r.check()})}function f(e){this.img=e}function c(e){this.src=e,v[e]=this}var a=e.jQuery,u=e.console,h=u!==void 0,d=Object.prototype.toString;s.prototype=new t,s.prototype.options={},s.prototype.getImages=function(){this.images=[];for(var e=0,t=this.elements.length;t>e;e++){var n=this.elements[e];"IMG"===n.nodeName&&this.addImage(n);var i=n.nodeType;if(i&&(1===i||9===i||11===i))for(var r=n.querySelectorAll("img"),o=0,s=r.length;s>o;o++){var f=r[o];this.addImage(f)}}},s.prototype.addImage=function(e){var t=new f(e);this.images.push(t)},s.prototype.check=function(){function e(e,r){return t.options.debug&&h&&u.log("confirm",e,r),t.progress(e),n++,n===i&&t.complete(),!0}var t=this,n=0,i=this.images.length;if(this.hasAnyBroken=!1,!i)return this.complete(),void 0;for(var r=0;i>r;r++){var o=this.images[r];o.on("confirm",e),o.check()}},s.prototype.progress=function(e){this.hasAnyBroken=this.hasAnyBroken||!e.isLoaded;var t=this;setTimeout(function(){t.emit("progress",t,e),t.jqDeferred&&t.jqDeferred.notify&&t.jqDeferred.notify(t,e)})},s.prototype.complete=function(){var e=this.hasAnyBroken?"fail":"done";this.isComplete=!0;var t=this;setTimeout(function(){if(t.emit(e,t),t.emit("always",t),t.jqDeferred){var n=t.hasAnyBroken?"reject":"resolve";t.jqDeferred[n](t)}})},a&&(a.fn.imagesLoaded=function(e,t){var n=new s(this,e,t);return n.jqDeferred.promise(a(this))}),f.prototype=new t,f.prototype.check=function(){var e=v[this.img.src]||new c(this.img.src);if(e.isConfirmed)return this.confirm(e.isLoaded,"cached was confirmed"),void 0;if(this.img.complete&&void 0!==this.img.naturalWidth)return this.confirm(0!==this.img.naturalWidth,"naturalWidth"),void 0;var t=this;e.on("confirm",function(e,n){return t.confirm(e.isLoaded,n),!0}),e.check()},f.prototype.confirm=function(e,t){this.isLoaded=e,this.emit("confirm",this,t)};var v={};return c.prototype=new t,c.prototype.check=function(){if(!this.isChecked){var e=new Image;n.bind(e,"load",this),n.bind(e,"error",this),e.src=this.src,this.isChecked=!0}},c.prototype.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},c.prototype.onload=function(e){this.confirm(!0,"onload"),this.unbindProxyEvents(e)},c.prototype.onerror=function(e){this.confirm(!1,"onerror"),this.unbindProxyEvents(e)},c.prototype.confirm=function(e,t){this.isConfirmed=!0,this.isLoaded=e,this.emit("confirm",this,t)},c.prototype.unbindProxyEvents=function(e){n.unbind(e.target,"load",this),n.unbind(e.target,"error",this)},s});

/*! LazyLoad 1.9.5 - Modified by MaiCong https://github.com/maicong/OpenAPI/tree/master/jquery_lazyload */
!function(e,t,i,o){var r=e(t);e.fn.lazyload=function(n){function a(){var t=0;l.each(function(){var i=e(this);if(!d.skip_invisible||i.is(":visible"))if(e.abovethetop(this,d)||e.leftofbegin(this,d));else if(e.belowthefold(this,d)||e.rightoffold(this,d)){if(++t>d.failure_limit)return!1}else i.trigger("appear"),t=0})}var f,l=this,d={threshold:0,failure_limit:0,event:"scroll",effect:"show",container:t,data_attribute:"original",skip_invisible:!1,appear:null,load:null,broken_pic:"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAC0lEQVQIW2NkAAIAAAoAAggA9GkAAAAASUVORK5CYII=",placeholder:"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVQIW2O8e/fufwAIzgOYrS4BDgAAAABJRU5ErkJggg=="};if(n&&(o!==n.failurelimit&&(n.failure_limit=n.failurelimit,delete n.failurelimit),o!==n.effectspeed&&(n.effect_speed=n.effectspeed,delete n.effectspeed),e.extend(d,n)),!e.isFunction(e.fn.imagesLoaded))throw new Error("This JavaScript requires jQuery ImagesLoaded");return f=d.container===o||d.container===t?r:e(d.container),0===d.event.indexOf("scroll")&&f.bind(d.event,function(){return a()}),this.each(function(){var t=this,i=e(t);t.loaded=!1,(i.attr("src")===o||i.attr("src")===!1)&&i.is("img")&&i.attr("src",d.placeholder),i.one("appear",function(){if(!this.loaded){if(d.appear){var o=l.length;d.appear.call(t,o,d)}e("<img />").on("load",function(){var o=i.attr("data-"+d.data_attribute);i.hide(),i.is("img")?i.attr("src",o):i.css("background-image","url('"+o+"')"),i[d.effect](d.effect_speed),t.loaded=!0;var r=e.grep(l,function(e){return!e.loaded});if(l=e(r),d.load){var n=l.length;d.load.call(t,n,d)}}).attr("src",i.attr("data-"+d.data_attribute)).imagesLoaded(function(){this.hasAnyBroken&&i.attr("src",d.broken_pic)})}}),0!==d.event.indexOf("scroll")&&i.bind(d.event,function(){t.loaded||i.trigger("appear")})}),r.bind("resize",function(){a()}),/(?:iphone|ipod|ipad).*os 5/gi.test(navigator.appVersion)&&r.bind("pageshow",function(t){t.originalEvent&&t.originalEvent.persisted&&l.each(function(){e(this).trigger("appear")})}),e(i).ready(function(){a()}),this},e.belowthefold=function(i,n){var a;return a=n.container===o||n.container===t?(t.innerHeight?t.innerHeight:r.height())+r.scrollTop():e(n.container).offset().top+e(n.container).height(),a<=e(i).offset().top-n.threshold},e.rightoffold=function(i,n){var a;return a=n.container===o||n.container===t?r.width()+r.scrollLeft():e(n.container).offset().left+e(n.container).width(),a<=e(i).offset().left-n.threshold},e.abovethetop=function(i,n){var a;return a=n.container===o||n.container===t?r.scrollTop():e(n.container).offset().top,a>=e(i).offset().top+n.threshold+e(i).height()},e.leftofbegin=function(i,n){var a;return a=n.container===o||n.container===t?r.scrollLeft():e(n.container).offset().left,a>=e(i).offset().left+n.threshold+e(i).width()},e.inviewport=function(t,i){return!(e.rightoffold(t,i)||e.leftofbegin(t,i)||e.belowthefold(t,i)||e.abovethetop(t,i))},e.extend(e.expr[":"],{"below-the-fold":function(t){return e.belowthefold(t,{threshold:0})},"above-the-top":function(t){return!e.belowthefold(t,{threshold:0})},"right-of-screen":function(t){return e.rightoffold(t,{threshold:0})},"left-of-screen":function(t){return!e.rightoffold(t,{threshold:0})},"in-viewport":function(t){return e.inviewport(t,{threshold:0})},"above-the-fold":function(t){return!e.belowthefold(t,{threshold:0})},"right-of-fold":function(t){return e.rightoffold(t,{threshold:0})},"left-of-fold":function(t){return!e.rightoffold(t,{threshold:0})}})}(jQuery,window,document);

/* SmoothScroll for websites v1.3.8 https://github.com/maicong/OpenAPI/tree/master/SmoothScroll */
!function(){function n(){b.keyboardSupport&&F("keydown",v)}function o(){if(!f&&document.body){f=!0;var a=document.body,e=document.documentElement,j=window.innerHeight,k=a.scrollHeight;if(g=document.compatMode.indexOf("CSS")>=0?e:a,h=a,n(),top!=self)d=!0;else if(k>j&&(a.offsetHeight<=j||e.offsetHeight<=j)){var l=!1,m=function(){l||e.scrollHeight==document.height||(l=!0,setTimeout(function(){e.style.height=document.height+"px",l=!1},500))};e.style.oldHeight=e.style.height,e.style.height="auto",setTimeout(m,10);var o={attributes:!0,childList:!0,characterData:!1};if(i=new P(m),i.observe(a,o),g.offsetHeight<=j){var p=document.createElement("div");p.style.clear="both",a.appendChild(p)}}b.fixedBackground||c||(a.style.backgroundAttachment="scroll",e.style.backgroundAttachment="scroll")}}function t(a,c,d,e){if(e||(e=1e3),I(c,d),1!=b.accelerationMax){var f=Date.now(),g=f-s;if(g<b.accelerationDelta){var h=(1+50/g)/2;h>1&&(h=Math.min(h,b.accelerationMax),c*=h,d*=h)}s=Date.now()}if(q.push({x:c,y:d,lastX:0>c?.99:-.99,lastY:0>d?.99:-.99,start:Date.now()}),!r){var i=a===document.body,j=function(){for(var g=Date.now(),h=0,k=0,l=0;l<q.length;l++){var m=q[l],n=g-m.start,o=n>=b.animationTime,p=o?1:n/b.animationTime;b.pulseAlgorithm&&(p=S(p));var s=m.x*p-m.lastX>>0,t=m.y*p-m.lastY>>0;h+=s,k+=t,m.lastX+=s,m.lastY+=t,o&&(q.splice(l,1),l--)}i?window.scrollBy(h,k):(h&&(a.scrollLeft+=h),k&&(a.scrollTop+=k)),c||d||(q=[]),q.length?O(j,a,e/b.frameRate+1):r=!1};O(j,a,0),r=!0}}function u(a){f||o();var c=a.target,d=C(c);if(!d||a.defaultPrevented||a.ctrlKey)return!0;if(H(h,"embed")||H(c,"embed")&&/\.pdf/i.test(c.src)||H(h,"object"))return!0;var e=-a.wheelDeltaX||a.deltaX||0,g=-a.wheelDeltaY||a.deltaY||0;return l&&(a.wheelDeltaX&&L(a.wheelDeltaX,120)&&(e=-120*(a.wheelDeltaX/Math.abs(a.wheelDeltaX))),a.wheelDeltaY&&L(a.wheelDeltaY,120)&&(g=-120*(a.wheelDeltaY/Math.abs(a.wheelDeltaY)))),e||g||(g=-a.wheelDelta||0),1===a.deltaMode&&(e*=40,g*=40),!b.touchpadSupport&&K(g)?!0:(Math.abs(e)>1.2&&(e*=b.stepSize/120),Math.abs(g)>1.2&&(g*=b.stepSize/120),t(d,e,g),a.preventDefault(),A(),void 0)}function v(a){var c=a.target,d=a.ctrlKey||a.altKey||a.metaKey||a.shiftKey&&a.keyCode!==m.spacebar;if(/input|textarea|select|embed|object/i.test(c.nodeName)||H(h,"video")||N(a)||c.isContentEditable||a.defaultPrevented||d)return!0;if(H(c,"button")&&a.keyCode===m.spacebar)return!0;var e,f=0,g=0,i=C(h),j=i.clientHeight;switch(i==document.body&&(j=window.innerHeight),a.keyCode){case m.up:g=-b.arrowScroll;break;case m.down:g=b.arrowScroll;break;case m.spacebar:e=a.shiftKey?1:-1,g=.9*-e*j;break;case m.pageup:g=.9*-j;break;case m.pagedown:g=.9*j;break;case m.home:g=-i.scrollTop;break;case m.end:var k=i.scrollHeight-i.scrollTop-j;g=k>0?k+10:0;break;case m.left:f=-b.arrowScroll;break;case m.right:f=b.arrowScroll;break;default:return!0}t(i,f,g),a.preventDefault(),A()}function w(a){h=a.target}function A(){clearTimeout(z),z=setInterval(function(){y={}},1e3)}function B(a,b){for(var c=a.length;c--;)y[x(a[c])]=b;return b}function C(a){var b=[],c=document.body,e=g.scrollHeight;do{var f=y[x(a)];if(f)return B(b,f);if(b.push(a),e===a.scrollHeight){var h=d&&D(g),i=E(c)&&E(g);if(h||i)return B(b,Q())}else if(D(a)&&E(a))return B(b,a)}while(a=a.parentElement)}function D(a){return a.clientHeight+10<a.scrollHeight}function E(a){var b=getComputedStyle(a,"").getPropertyValue("overflow-y");return"BODY"===a.nodeName||"HTML"===a.nodeName?"hidden"!==b:"scroll"===b||"auto"===b}function F(a,b,c){window.addEventListener(a,b,c||!1)}function H(a,b){return(a.nodeName||"").toLowerCase()===b.toLowerCase()}function I(a,b){a=a>0?1:-1,b=b>0?1:-1,(e.x!==a||e.y!==b)&&(e.x=a,e.y=b,q=[],s=0)}function K(a){return a?(j.length||(j=[a,a,a]),a=Math.abs(a),j.push(a),j.shift(),clearTimeout(J),J=setTimeout(function(){window.localStorage&&(localStorage.SS_deltaBuffer=j.join(","))},1e3),!M(120)&&!M(100)):void 0}function L(a,b){return Math.floor(a/b)==a/b}function M(a){return L(j[0],a)&&L(j[1],a)&&L(j[2],a)}function N(a){var b=a.target,c=!1;if(-1!=document.URL.indexOf("www.youtube.com/watch"))do if(c=b.classList&&b.classList.contains("html5-video-controls"))break;while(b=b.parentNode);return c}function R(a){var c,d,e;return a*=b.pulseScale,1>a?c=a-(1-Math.exp(-a)):(d=Math.exp(-1),a-=1,e=1-Math.exp(-a),c=d+e*(1-d)),c*b.pulseNormalize}function S(a){return a>=1?1:0>=a?0:(1==b.pulseNormalize&&(b.pulseNormalize/=R(1)),R(a))}var h,i,z,J,a={frameRate:150,animationTime:400,stepSize:120,pulseAlgorithm:!0,pulseScale:8,pulseNormalize:1,accelerationDelta:20,accelerationMax:1,keyboardSupport:!0,arrowScroll:50,touchpadSupport:!0,fixedBackground:!0,excluded:""},b=a,c=!1,d=!1,e={x:0,y:0},f=!1,g=document.documentElement,j=[],l=/^Mac/.test(navigator.platform),m={left:37,up:38,right:39,down:40,spacebar:32,pageup:33,pagedown:34,end:35,home:36},b=a,q=[],r=!1,s=Date.now(),x=function(){var a=0;return function(b){return b.uniqueID||(b.uniqueID=a++)}}(),y={};window.localStorage&&localStorage.SS_deltaBuffer&&(j=localStorage.SS_deltaBuffer.split(","));var T,O=function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||function(a,b,c){window.setTimeout(a,c||1e3/60)}}(),P=window.MutationObserver||window.WebKitMutationObserver||window.MozMutationObserver,Q=function(){var a;return function(){if(!a){var b=document.createElement("div");b.style.cssText="height:10000px;width:1px;",document.body.appendChild(b);var c=document.body.scrollTop;document.documentElement.scrollTop,window.scrollBy(0,1),a=document.body.scrollTop!=c?document.body:document.documentElement,window.scrollBy(0,-1),document.body.removeChild(b)}return a}}();"onwheel"in document.createElement("div")?T="wheel":"onmousewheel"in document.createElement("div")&&(T="mousewheel"),T&&(F(T,u),F("mousedown",w),F("load",o))}();

/* jQuery.scrollTo v2.1.0 https://github.com/flesler/jquery.scrollTo */
;(function(l){'use strict';l(['jquery'],function($){var k=$.scrollTo=function(a,b,c){return $(window).scrollTo(a,b,c)};k.defaults={axis:'xy',duration:0,limit:true};function isWin(a){return!a.nodeName||$.inArray(a.nodeName.toLowerCase(),['iframe','#document','html','body'])!==-1}$.fn.scrollTo=function(f,g,h){if(typeof g==='object'){h=g;g=0}if(typeof h==='function'){h={onAfter:h}}if(f==='max'){f=9e9}h=$.extend({},k.defaults,h);g=g||h.duration;var j=h.queue&&h.axis.length>1;if(j){g/=2}h.offset=both(h.offset);h.over=both(h.over);return this.each(function(){if(f===null)return;var d=isWin(this),elem=d?this.contentWindow||window:this,$elem=$(elem),targ=f,attr={},toff;switch(typeof targ){case'number':case'string':if(/^([+-]=?)?\d+(\.\d+)?(px|%)?$/.test(targ)){targ=both(targ);break}targ=d?$(targ):$(targ,elem);if(!targ.length)return;case'object':if(targ.is||targ.style){toff=(targ=$(targ)).offset()}}var e=$.isFunction(h.offset)&&h.offset(elem,targ)||h.offset;$.each(h.axis.split(''),function(i,a){var b=a==='x'?'Left':'Top',pos=b.toLowerCase(),key='scroll'+b,prev=$elem[key](),max=k.max(elem,a);if(toff){attr[key]=toff[pos]+(d?0:prev-$elem.offset()[pos]);if(h.margin){attr[key]-=parseInt(targ.css('margin'+b),10)||0;attr[key]-=parseInt(targ.css('border'+b+'Width'),10)||0}attr[key]+=e[pos]||0;if(h.over[pos]){attr[key]+=targ[a==='x'?'width':'height']()*h.over[pos]}}else{var c=targ[pos];attr[key]=c.slice&&c.slice(-1)==='%'?parseFloat(c)/100*max:c}if(h.limit&&/^\d+$/.test(attr[key])){attr[key]=attr[key]<=0?0:Math.min(attr[key],max)}if(!i&&h.axis.length>1){if(prev===attr[key]){attr={}}else if(j){animate(h.onAfterFirst);attr={}}}});animate(h.onAfter);function animate(a){var b=$.extend({},h,{queue:true,duration:g,complete:a&&function(){a.call(elem,targ,h)}});$elem.animate(attr,b)}})};k.max=function(a,b){var c=b==='x'?'Width':'Height',scroll='scroll'+c;if(!isWin(a))return a[scroll]-$(a)[c.toLowerCase()]();var d='client'+c,doc=a.ownerDocument||a.document,html=doc.documentElement,body=doc.body;return Math.max(html[scroll],body[scroll])-Math.min(html[d],body[d])};function both(a){return $.isFunction(a)||$.isPlainObject(a)?a:{top:a,left:a}}$.Tween.propHooks.scrollLeft=$.Tween.propHooks.scrollTop={get:function(t){return $(t.elem)[t.prop]()},set:function(t){var a=this.get(t);if(t.options.interrupt&&t._last&&t._last!==a){return $(t.elem).stop()}var b=Math.round(t.now);if(a!==b){$(t.elem)[t.prop](b);t._last=this.get(t)}}};return k})}(typeof define==='function'&&define.amd?define:function(a,b){'use strict';if(typeof module!=='undefined'&&module.exports){module.exports=b(require('jquery'))}else{b(jQuery)}}));

/* Bootstrap Tooltip */
if("undefined"==typeof jQuery)throw new Error("Requires jQuery");+function(t){"use strict";var e=t.fn.jquery.split(" ")[0].split(".");if(e[0]<2&&e[1]<9||1==e[0]&&9==e[1]&&e[2]<1)throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher")}(jQuery),+function(t){"use strict";function e(e){return this.each(function(){var o=t(this),n=o.data("bs.tooltip"),s="object"==typeof e&&e;(n||!/destroy|hide/.test(e))&&(n||o.data("bs.tooltip",n=new i(this,s)),"string"==typeof e&&n[e]())})}var i=function(t,e){this.type=null,this.options=null,this.enabled=null,this.timeout=null,this.hoverState=null,this.$element=null,this.inState=null,this.init("tooltip",t,e)};i.VERSION="3.3.5",i.TRANSITION_DURATION=150,i.DEFAULTS={animation:!0,placement:"top",selector:!1,template:'<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',trigger:"hover focus",title:"",delay:0,html:!1,container:!1,viewport:{selector:"body",padding:0}},i.prototype.init=function(e,i,o){if(this.enabled=!0,this.type=e,this.$element=t(i),this.options=this.getOptions(o),this.$viewport=this.options.viewport&&t(t.isFunction(this.options.viewport)?this.options.viewport.call(this,this.$element):this.options.viewport.selector||this.options.viewport),this.inState={click:!1,hover:!1,focus:!1},this.$element[0]instanceof document.constructor&&!this.options.selector)throw new Error("`selector` option must be specified when initializing "+this.type+" on the window.document object!");for(var n=this.options.trigger.split(" "),s=n.length;s--;){var r=n[s];if("click"==r)this.$element.on("click."+this.type,this.options.selector,t.proxy(this.toggle,this));else if("manual"!=r){var a="hover"==r?"mouseenter":"focusin",l="hover"==r?"mouseleave":"focusout";this.$element.on(a+"."+this.type,this.options.selector,t.proxy(this.enter,this)),this.$element.on(l+"."+this.type,this.options.selector,t.proxy(this.leave,this))}}this.options.selector?this._options=t.extend({},this.options,{trigger:"manual",selector:""}):this.fixTitle()},i.prototype.getDefaults=function(){return i.DEFAULTS},i.prototype.getOptions=function(e){return e=t.extend({},this.getDefaults(),this.$element.data(),e),e.delay&&"number"==typeof e.delay&&(e.delay={show:e.delay,hide:e.delay}),e},i.prototype.getDelegateOptions=function(){var e={},i=this.getDefaults();return this._options&&t.each(this._options,function(t,o){i[t]!=o&&(e[t]=o)}),e},i.prototype.enter=function(e){var i=e instanceof this.constructor?e:t(e.currentTarget).data("bs."+this.type);return i||(i=new this.constructor(e.currentTarget,this.getDelegateOptions()),t(e.currentTarget).data("bs."+this.type,i)),e instanceof t.Event&&(i.inState["focusin"==e.type?"focus":"hover"]=!0),i.tip().hasClass("in")||"in"==i.hoverState?void(i.hoverState="in"):(clearTimeout(i.timeout),i.hoverState="in",i.options.delay&&i.options.delay.show?void(i.timeout=setTimeout(function(){"in"==i.hoverState&&i.show()},i.options.delay.show)):i.show())},i.prototype.isInStateTrue=function(){for(var t in this.inState)if(this.inState[t])return!0;return!1},i.prototype.leave=function(e){var i=e instanceof this.constructor?e:t(e.currentTarget).data("bs."+this.type);return i||(i=new this.constructor(e.currentTarget,this.getDelegateOptions()),t(e.currentTarget).data("bs."+this.type,i)),e instanceof t.Event&&(i.inState["focusout"==e.type?"focus":"hover"]=!1),i.isInStateTrue()?void 0:(clearTimeout(i.timeout),i.hoverState="out",i.options.delay&&i.options.delay.hide?void(i.timeout=setTimeout(function(){"out"==i.hoverState&&i.hide()},i.options.delay.hide)):i.hide())},i.prototype.show=function(){var e=t.Event("show.bs."+this.type);if(this.hasContent()&&this.enabled){this.$element.trigger(e);var o=t.contains(this.$element[0].ownerDocument.documentElement,this.$element[0]);if(e.isDefaultPrevented()||!o)return;var n=this,s=this.tip(),r=this.getUID(this.type);this.setContent(),s.attr("id",r),this.$element.attr("aria-describedby",r),this.options.animation&&s.addClass("fade");var a="function"==typeof this.options.placement?this.options.placement.call(this,s[0],this.$element[0]):this.options.placement,l=/\s?auto?\s?/i,p=l.test(a);p&&(a=a.replace(l,"")||"top"),s.detach().css({top:0,left:0,display:"block"}).addClass(a).data("bs."+this.type,this),this.options.container?s.appendTo(this.options.container):s.insertAfter(this.$element),this.$element.trigger("inserted.bs."+this.type);var h=this.getPosition(),f=s[0].offsetWidth,u=s[0].offsetHeight;if(p){var c=a,d=this.getPosition(this.$viewport);a="bottom"==a&&h.bottom+u>d.bottom?"top":"top"==a&&h.top-u<d.top?"bottom":"right"==a&&h.right+f>d.width?"left":"left"==a&&h.left-f<d.left?"right":a,s.removeClass(c).addClass(a)}var v=this.getCalculatedOffset(a,h,f,u);this.applyPlacement(v,a);var g=function(){var t=n.hoverState;n.$element.trigger("shown.bs."+n.type),n.hoverState=null,"out"==t&&n.leave(n)};t.support.transition&&this.$tip.hasClass("fade")?s.one("bsTransitionEnd",g).emulateTransitionEnd(i.TRANSITION_DURATION):g()}},i.prototype.applyPlacement=function(e,i){var o=this.tip(),n=o[0].offsetWidth,s=o[0].offsetHeight,r=parseInt(o.css("margin-top"),10),a=parseInt(o.css("margin-left"),10);isNaN(r)&&(r=0),isNaN(a)&&(a=0),e.top+=r,e.left+=a,t.offset.setOffset(o[0],t.extend({using:function(t){o.css({top:Math.round(t.top),left:Math.round(t.left)})}},e),0),o.addClass("in");var l=o[0].offsetWidth,p=o[0].offsetHeight;"top"==i&&p!=s&&(e.top=e.top+s-p);var h=this.getViewportAdjustedDelta(i,e,l,p);h.left?e.left+=h.left:e.top+=h.top;var f=/top|bottom/.test(i),u=f?2*h.left-n+l:2*h.top-s+p,c=f?"offsetWidth":"offsetHeight";o.offset(e),this.replaceArrow(u,o[0][c],f)},i.prototype.replaceArrow=function(t,e,i){this.arrow().css(i?"left":"top",50*(1-t/e)+"%").css(i?"top":"left","")},i.prototype.setContent=function(){var t=this.tip(),e=this.getTitle();t.find(".tooltip-inner")[this.options.html?"html":"text"](e),t.removeClass("fade in top bottom left right")},i.prototype.hide=function(e){function o(){"in"!=n.hoverState&&s.detach(),n.$element.removeAttr("aria-describedby").trigger("hidden.bs."+n.type),e&&e()}var n=this,s=t(this.$tip),r=t.Event("hide.bs."+this.type);return this.$element.trigger(r),r.isDefaultPrevented()?void 0:(s.removeClass("in"),t.support.transition&&s.hasClass("fade")?s.one("bsTransitionEnd",o).emulateTransitionEnd(i.TRANSITION_DURATION):o(),this.hoverState=null,this)},i.prototype.fixTitle=function(){var t=this.$element;(t.attr("title")||"string"!=typeof t.attr("data-original-title"))&&t.attr("data-original-title",t.attr("title")||"").attr("title","")},i.prototype.hasContent=function(){return this.getTitle()},i.prototype.getPosition=function(e){e=e||this.$element;var i=e[0],o="BODY"==i.tagName,n=i.getBoundingClientRect();null==n.width&&(n=t.extend({},n,{width:n.right-n.left,height:n.bottom-n.top}));var s=o?{top:0,left:0}:e.offset(),r={scroll:o?document.documentElement.scrollTop||document.body.scrollTop:e.scrollTop()},a=o?{width:t(window).width(),height:t(window).height()}:null;return t.extend({},n,r,a,s)},i.prototype.getCalculatedOffset=function(t,e,i,o){return"bottom"==t?{top:e.top+e.height,left:e.left+e.width/2-i/2}:"top"==t?{top:e.top-o,left:e.left+e.width/2-i/2}:"left"==t?{top:e.top+e.height/2-o/2,left:e.left-i}:{top:e.top+e.height/2-o/2,left:e.left+e.width}},i.prototype.getViewportAdjustedDelta=function(t,e,i,o){var n={top:0,left:0};if(!this.$viewport)return n;var s=this.options.viewport&&this.options.viewport.padding||0,r=this.getPosition(this.$viewport);if(/right|left/.test(t)){var a=e.top-s-r.scroll,l=e.top+s-r.scroll+o;a<r.top?n.top=r.top-a:l>r.top+r.height&&(n.top=r.top+r.height-l)}else{var p=e.left-s,h=e.left+s+i;p<r.left?n.left=r.left-p:h>r.right&&(n.left=r.left+r.width-h)}return n},i.prototype.getTitle=function(){var t,e=this.$element,i=this.options;return t=e.attr("data-original-title")||("function"==typeof i.title?i.title.call(e[0]):i.title)},i.prototype.getUID=function(t){do t+=~~(1e6*Math.random());while(document.getElementById(t));return t},i.prototype.tip=function(){if(!this.$tip&&(this.$tip=t(this.options.template),1!=this.$tip.length))throw new Error(this.type+" `template` option must consist of exactly 1 top-level element!");return this.$tip},i.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".tooltip-arrow")},i.prototype.enable=function(){this.enabled=!0},i.prototype.disable=function(){this.enabled=!1},i.prototype.toggleEnabled=function(){this.enabled=!this.enabled},i.prototype.toggle=function(e){var i=this;e&&(i=t(e.currentTarget).data("bs."+this.type),i||(i=new this.constructor(e.currentTarget,this.getDelegateOptions()),t(e.currentTarget).data("bs."+this.type,i))),e?(i.inState.click=!i.inState.click,i.isInStateTrue()?i.enter(i):i.leave(i)):i.tip().hasClass("in")?i.leave(i):i.enter(i)},i.prototype.destroy=function(){var t=this;clearTimeout(this.timeout),this.hide(function(){t.$element.off("."+t.type).removeData("bs."+t.type),t.$tip&&t.$tip.detach(),t.$tip=null,t.$arrow=null,t.$viewport=null})};var o=t.fn.tooltip;t.fn.tooltip=e,t.fn.tooltip.Constructor=i,t.fn.tooltip.noConflict=function(){return t.fn.tooltip=o,this}}(jQuery);

/* jquery.pjax.js https://github.com/welefen/pjax */
!function(t){var e={support:{pjax:window.history&&window.history.pushState&&window.history.replaceState&&!navigator.userAgent.match(/(iPod|iPhone|iPad|WebApps\/.+CFNetwork)/),storage:!!window.localStorage},toInt:function(t){return parseInt(t)},stack:{},getTime:function(){return 1*new Date},getRealUrl:function(t){return t=(t||"").replace(/\#.*?$/,""),t=t.replace("?pjax=true&","?").replace("?pjax=true","").replace("&pjax=true","")},getUrlHash:function(t){return t.replace(/^[^\#]*(?:\#(.*?))?$/,"$1")},getLocalKey:function(t){var e="pjax_"+encodeURIComponent(t);return{data:e+"_data",time:e+"_time",title:e+"_title"}},removeAllCache:function(){if(e.support.storage)for(var t in localStorage)"pjax"===(t.split("_")||[""])[0]&&delete localStorage[t]},getCache:function(t,o,a){var n,l,r,i;if(o=e.toInt(o),t in e.stack){if(n=e.stack[t],ctime=e.getTime(),n.time+1e3*o>ctime)return n;delete e.stack[t]}else if(a&&e.support.storage){var c=e.getLocalKey(t);if(l=c.data,r=c.time,n=localStorage.getItem(l)){if(i=e.toInt(localStorage.getItem(r)),i+1e3*o>e.getTime())return{data:n,title:localStorage.getItem(c.title)};localStorage.removeItem(l),localStorage.removeItem(r),localStorage.removeItem(c.title)}}return null},setCache:function(t,o,a,n){var l,r=e.getTime();e.stack[t]={data:o,title:a,time:r},n&&e.support.storage&&(l=e.getLocalKey(t),localStorage.setItem(l.data,o),localStorage.setItem(l.time,r),localStorage.setItem(l.title,a))},removeCache:function(t){if(t=e.getRealUrl(t||location.href),delete e.stack[t],e.support.storage){var o=e.getLocalKey(t);localStorage.removeItem(o.data),localStorage.removeItem(o.time),localStorage.removeItem(o.title)}}},o=function(a){if(a=t.extend({selector:"",container:"",callback:function(){},filter:function(){}},a),!a.container||!a.selector)throw new Error("selector & container options must be set");t("body").delegate(a.selector,"click",function(n){if(n.which>1||n.metaKey)return!0;var l=t(this),r=l.attr("href");if("function"==typeof a.filter&&a.filter.call(this,r,this)===!0)return!0;if(r===location.href)return!0;if(e.getRealUrl(r)==e.getRealUrl(location.href)){var i=e.getUrlHash(r);return i&&(location.hash=i,a.callback&&a.callback.call(this,{type:"hash"})),!0}n.preventDefault(),a=t.extend(!0,a,{url:r,element:this,title:"",push:!0}),o.request(a)})};o.xhr=null,o.options={},o.state={},o.defaultOptions={timeout:2e3,element:null,cache:86400,storage:!0,url:"",push:!0,show:"",title:"",titleSuffix:"",type:"GET",data:{pjax:!0},dataType:"html",callback:null,beforeSend:function(e){t(o.options.container).trigger("pjax.start",[e,o.options]),e&&e.setRequestHeader("X-PJAX",!0)},error:function(){o.options.callback&&o.options.callback.call(o.options.element,{type:"error"}),location.href=o.options.url},complete:function(e){t(o.options.container).trigger("pjax.end",[e,o.options])}},o.showFx={_default:function(t,e,o){this.html(t),e&&e.call(this,t,o)},fade:function(t,e,o){var a=this;o?(a.html(t),e&&e.call(a,t,o)):this.fadeOut(500,function(){a.html(t).fadeIn(500,function(){e&&e.call(a,t,o)})})}},o.showFn=function(e,a,n,l,r){var i=null;"function"==typeof e?i=e:(e in o.showFx||(e="_default"),i=o.showFx[e]),i&&i.call(a,n,function(){var e=location.hash;""!=e?(location.href=e,/Firefox/.test(navigator.userAgent)&&history.replaceState(t.extend({},o.state,{url:null}),document.title)):window.scrollTo(0,0),l&&l.call(this,n,r)},r)},o.success=function(a,n){if(n!==!0&&(n=!1),o.html&&(a=t(a).find(o.html).html()),-1!=(a||"").indexOf("<html"))return o.options.callback&&o.options.callback.call(o.options.element,{type:"error"}),location.href=o.options.url,!1;var l,r=o.options.title||"";o.options.element&&(l=t(o.options.element),r=l.attr("title")||l.text());var i=a.match(/<title>(.*?)<\/title>/);i&&(r=i[1],a=a.replace(/<title>(.*?)<\/title>/,"")),r&&-1==r.indexOf(o.options.titleSuffix)&&(r+=o.options.titleSuffix),document.title=r,o.state={container:o.options.container,timeout:o.options.timeout,cache:o.options.cache,storage:o.options.storage,show:o.options.show,title:r,url:o.options.oldUrl};var c=t.param(o.options.data);""!=c&&(o.state.url=o.options.url+(/\?/.test(o.options.url)?"&":"?")+c),o.options.push?(o.active||(history.replaceState(t.extend({},o.state,{url:null}),document.title),o.active=!0),history.pushState(o.state,document.title,o.options.oldUrl)):o.options.push===!1&&history.replaceState(o.state,document.title,o.options.oldUrl),o.options.showFn&&o.options.showFn(a,function(){o.options.callback&&o.options.callback.call(o.options.element,{type:n?"cache":"success"})},n),o.options.cache&&!n&&e.setCache(o.options.url,a,r,o.options.storage)},o.request=function(a){a=t.extend(!0,o.defaultOptions,a);var n,l=t(a.container);return a.oldUrl=a.url,a.url=e.getRealUrl(a.url),t(a.element).length&&(n=e.toInt(t(a.element).attr("data-pjax-cache")),n&&(a.cache=n)),a.cache===!0&&(a.cache=86400),a.cache=e.toInt(a.cache),0===a.cache&&e.removeAllCache(),a.showFn||(a.showFn=function(t,e,n){o.showFn(a.show,l,t,e,n)}),o.options=a,o.options.success=o.success,a.cache&&(n=e.getCache(a.url,a.cache,a.storage))?(a.beforeSend(),a.title=n.title,o.success(n.data,!0),a.complete(),!0):(o.xhr&&o.xhr.readyState<4&&(o.xhr.onreadystatechange=t.noop,o.xhr.abort()),void(o.xhr=t.ajax(o.options)))};var a="state"in window.history,n=location.href;t(window).bind("popstate",function(e){var l=!a&&location.href==n;if(a=!0,!l){var r=e.state;if(r&&r.container)if(t(r.container).length){var i={url:r.url,container:r.container,push:null,timeout:r.timeout,cache:r.cache,storage:r.storage,title:r.title,element:null};o.request(i)}else window.location=location.href}}),e.support.pjax||(o=function(){return!0},o.request=function(t){t&&t.url&&(location.href=t.url)}),t.pjax=o,t.pjax.util=e,t.inArray("state",t.event.props)<0&&t.event.props.push("state")}(jQuery);

/* Swipebox v1.4.1 https://github.com/brutaldesign/swipebox */
!function(e,i,t,s){t.swipebox=function(o,a){var n,r,l={useCSS:!0,useSVG:!0,initialIndexOnArray:0,removeBarsOnMobile:!0,hideCloseButtonOnMobile:!1,hideBarsDelay:3e3,videoMaxWidth:1140,vimeoColor:"cccccc",beforeOpen:null,afterOpen:null,afterClose:null,nextSlide:null,prevSlide:null,loopAtEnd:!1,autoplayVideos:!1,queryStringData:{},toggleClassOnLoad:""},d=this,p=[],b=o.selector,c=t(b),u=navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i),h=null!==u||i.createTouch!==s||"ontouchstart"in e||"onmsgesturechange"in e||navigator.msMaxTouchPoints,w=!!i.createElementNS&&!!i.createElementNS("http://www.w3.org/2000/svg","svg").createSVGRect,g=e.innerWidth?e.innerWidth:t(e).width(),m=e.innerHeight?e.innerHeight:t(e).height(),x=0,f='<div id="swipebox-overlay" class="swipebox-overlay"><div id="swipebox-container" class="swipebox-container"><div id="swipebox-slider" class="swipebox-slider"></div><div id="swipebox-top-bar" class="swipebox-top-bar"><div id="swipebox-title" class="swipebox-title"></div></div><div id="swipebox-bottom-bar" class="swipebox-bottom-bar"><div id="swipebox-arrows" class="swipebox-arrows"><a id="swipebox-prev" class="swipebox-prev"></a><a id="swipebox-next" class="swipebox-next"></a></div></div><a id="swipebox-close" class="swipebox-close"></a></div></div>';d.settings={},t.swipebox.close=function(){n.closeSlide()},t.swipebox.extend=function(){return n},d.init=function(){d.settings=t.extend({},l,a),t.isArray(o)?(p=o,n.target=t(e),n.init(d.settings.initialIndexOnArray)):t(i).on("click",b,function(e){if("slide current"===e.target.parentNode.className)return!1;t.isArray(o)||(n.destroy(),r=t(b),n.actions()),p=[];var i,s,a;a||(s="data-rel",a=t(this).attr(s)),a||(s="rel",a=t(this).attr(s)),r=a&&""!==a&&"nofollow"!==a?c.filter("["+s+'="'+a+'"]'):t(b),r.each(function(){var e=null,i=null;t(this).attr("title")&&(e=t(this).attr("title")),t(this).attr("href")&&(i=t(this).attr("href")),p.push({href:i,title:e})}),i=r.index(t(this)),e.preventDefault(),e.stopPropagation(),n.target=t(e.target),n.init(i)})},n={init:function(e){d.settings.beforeOpen&&d.settings.beforeOpen(),this.target.trigger("swipebox-start"),t.swipebox.isOpen=!0,this.build(),this.openSlide(e),this.openMedia(e),this.preloadMedia(e+1),this.preloadMedia(e-1),d.settings.afterOpen&&d.settings.afterOpen()},build:function(){var e,i=this;t("body").append(f),w&&d.settings.useSVG===!0&&(e=t("#swipebox-close").css("background-image"),e=e.replace("png","svg"),t("#swipebox-prev, #swipebox-next, #swipebox-close").css({"background-image":e})),u&&d.settings.removeBarsOnMobile&&t("#swipebox-bottom-bar, #swipebox-top-bar").remove(),t.each(p,function(){t("#swipebox-slider").append('<div class="slide"></div>')}),i.setDim(),i.actions(),h&&i.gesture(),i.keyboard(),i.animBars(),i.resize()},setDim:function(){var i,s,o={};"onorientationchange"in e?e.addEventListener("orientationchange",function(){0===e.orientation?(i=g,s=m):(90===e.orientation||-90===e.orientation)&&(i=m,s=g)},!1):(i=e.innerWidth?e.innerWidth:t(e).width(),s=e.innerHeight?e.innerHeight:t(e).height()),o={width:i,height:s},t("#swipebox-overlay").css(o)},resize:function(){var i=this;t(e).resize(function(){i.setDim()}).resize()},supportTransition:function(){var e,t="transition WebkitTransition MozTransition OTransition msTransition KhtmlTransition".split(" ");for(e=0;e<t.length;e++)if(i.createElement("div").style[t[e]]!==s)return t[e];return!1},doCssTrans:function(){return d.settings.useCSS&&this.supportTransition()?!0:void 0},gesture:function(){var e,i,s,o,a,n,r=this,l=!1,d=!1,b=10,c=50,u={},h={},w=t("#swipebox-top-bar, #swipebox-bottom-bar"),m=t("#swipebox-slider");w.addClass("visible-bars"),r.setTimeout(),t("body").bind("touchstart",function(r){return t(this).addClass("touching"),e=t("#swipebox-slider .slide").index(t("#swipebox-slider .slide.current")),h=r.originalEvent.targetTouches[0],u.pageX=r.originalEvent.targetTouches[0].pageX,u.pageY=r.originalEvent.targetTouches[0].pageY,t("#swipebox-slider").css({"-webkit-transform":"translate3d("+x+"%, 0, 0)",transform:"translate3d("+x+"%, 0, 0)"}),t(".touching").bind("touchmove",function(r){if(r.preventDefault(),r.stopPropagation(),h=r.originalEvent.targetTouches[0],!d&&(a=s,s=h.pageY-u.pageY,Math.abs(s)>=c||l)){var w=.75-Math.abs(s)/m.height();m.css({top:s+"px"}),m.css({opacity:w}),l=!0}o=i,i=h.pageX-u.pageX,n=100*i/g,!d&&!l&&Math.abs(i)>=b&&(t("#swipebox-slider").css({"-webkit-transition":"",transition:""}),d=!0),d&&(i>0?0===e?t("#swipebox-overlay").addClass("leftSpringTouch"):(t("#swipebox-overlay").removeClass("leftSpringTouch").removeClass("rightSpringTouch"),t("#swipebox-slider").css({"-webkit-transform":"translate3d("+(x+n)+"%, 0, 0)",transform:"translate3d("+(x+n)+"%, 0, 0)"})):0>i&&(p.length===e+1?t("#swipebox-overlay").addClass("rightSpringTouch"):(t("#swipebox-overlay").removeClass("leftSpringTouch").removeClass("rightSpringTouch"),t("#swipebox-slider").css({"-webkit-transform":"translate3d("+(x+n)+"%, 0, 0)",transform:"translate3d("+(x+n)+"%, 0, 0)"}))))}),!1}).bind("touchend",function(e){if(e.preventDefault(),e.stopPropagation(),t("#swipebox-slider").css({"-webkit-transition":"-webkit-transform 0.4s ease",transition:"transform 0.4s ease"}),s=h.pageY-u.pageY,i=h.pageX-u.pageX,n=100*i/g,l)if(l=!1,Math.abs(s)>=2*c&&Math.abs(s)>Math.abs(a)){var p=s>0?m.height():-m.height();m.animate({top:p+"px",opacity:0},300,function(){r.closeSlide()})}else m.animate({top:0,opacity:1},300);else d?(d=!1,i>=b&&i>=o?r.getPrev():-b>=i&&o>=i&&r.getNext()):w.hasClass("visible-bars")?(r.clearTimeout(),r.hideBars()):(r.showBars(),r.setTimeout());t("#swipebox-slider").css({"-webkit-transform":"translate3d("+x+"%, 0, 0)",transform:"translate3d("+x+"%, 0, 0)"}),t("#swipebox-overlay").removeClass("leftSpringTouch").removeClass("rightSpringTouch"),t(".touching").off("touchmove").removeClass("touching")})},setTimeout:function(){if(d.settings.hideBarsDelay>0){var i=this;i.clearTimeout(),i.timeout=e.setTimeout(function(){i.hideBars()},d.settings.hideBarsDelay)}},clearTimeout:function(){e.clearTimeout(this.timeout),this.timeout=null},showBars:function(){var e=t("#swipebox-top-bar, #swipebox-bottom-bar");this.doCssTrans()?e.addClass("visible-bars"):(t("#swipebox-top-bar").animate({top:0},500),t("#swipebox-bottom-bar").animate({bottom:0},500),setTimeout(function(){e.addClass("visible-bars")},1e3))},hideBars:function(){var e=t("#swipebox-top-bar, #swipebox-bottom-bar");this.doCssTrans()?e.removeClass("visible-bars"):(t("#swipebox-top-bar").animate({top:"-50px"},500),t("#swipebox-bottom-bar").animate({bottom:"-50px"},500),setTimeout(function(){e.removeClass("visible-bars")},1e3))},animBars:function(){var e=this,i=t("#swipebox-top-bar, #swipebox-bottom-bar");i.addClass("visible-bars"),e.setTimeout(),t("#swipebox-slider").click(function(){i.hasClass("visible-bars")||(e.showBars(),e.setTimeout())}),t("#swipebox-bottom-bar").hover(function(){e.showBars(),i.addClass("visible-bars"),e.clearTimeout()},function(){d.settings.hideBarsDelay>0&&(i.removeClass("visible-bars"),e.setTimeout())})},keyboard:function(){var i=this;t(e).bind("keyup",function(e){e.preventDefault(),e.stopPropagation(),37===e.keyCode?i.getPrev():39===e.keyCode?i.getNext():27===e.keyCode&&i.closeSlide()})},actions:function(){var e=this,i="touchend click";p.length<2?(t("#swipebox-bottom-bar").hide(),s===p[1]&&t("#swipebox-top-bar").hide()):(t("#swipebox-prev").bind(i,function(i){i.preventDefault(),i.stopPropagation(),e.getPrev(),e.setTimeout()}),t("#swipebox-next").bind(i,function(i){i.preventDefault(),i.stopPropagation(),e.getNext(),e.setTimeout()})),t("#swipebox-close").bind(i,function(){e.closeSlide()})},setSlide:function(e,i){i=i||!1;var s=t("#swipebox-slider");x=100*-e,this.doCssTrans()?s.css({"-webkit-transform":"translate3d("+100*-e+"%, 0, 0)",transform:"translate3d("+100*-e+"%, 0, 0)"}):s.animate({left:100*-e+"%"}),t("#swipebox-slider .slide").removeClass("current"),t("#swipebox-slider .slide").eq(e).addClass("current"),this.setTitle(e),i&&s.fadeIn(),t("#swipebox-prev, #swipebox-next").removeClass("disabled"),0===e?t("#swipebox-prev").addClass("disabled"):e===p.length-1&&d.settings.loopAtEnd!==!0&&t("#swipebox-next").addClass("disabled")},openSlide:function(i){t("html").addClass("swipebox-html"),h?(t("html").addClass("swipebox-touch"),d.settings.hideCloseButtonOnMobile&&t("html").addClass("swipebox-no-close-button")):t("html").addClass("swipebox-no-touch"),t(e).trigger("resize"),this.setSlide(i,!0)},preloadMedia:function(e){var i=this,t=null;p[e]!==s&&(t=p[e].href),i.isVideo(t)?i.openMedia(e):setTimeout(function(){i.openMedia(e)},1e3)},openMedia:function(e){var i,o,a=this;return p[e]!==s&&(i=p[e].href),0>e||e>=p.length?!1:(o=t("#swipebox-slider .slide").eq(e),void(a.isVideo(i)?o.html(a.getVideo(i)):(o.addClass("slide-loading"),a.loadMedia(i,function(){o.removeClass("slide-loading"),o.html(this)}))))},setTitle:function(e){var i=null;t("#swipebox-title").empty(),p[e]!==s&&(i=p[e].title),i?(t("#swipebox-top-bar").show(),t("#swipebox-title").append(i)):t("#swipebox-top-bar").hide()},isVideo:function(e){if(e){if(e.match(/(youtube\.com|youtube-nocookie\.com)\/watch\?v=([a-zA-Z0-9\-_]+)/)||e.match(/vimeo\.com\/([0-9]*)/)||e.match(/youtu\.be\/([a-zA-Z0-9\-_]+)/))return!0;if(e.toLowerCase().indexOf("swipeboxvideo=1")>=0)return!0}},parseUri:function(e,s){var o=i.createElement("a"),a={};return o.href=decodeURIComponent(e),o.search&&(a=JSON.parse('{"'+o.search.toLowerCase().replace("?","").replace(/&/g,'","').replace(/=/g,'":"')+'"}')),t.isPlainObject(s)&&(a=t.extend(a,s,d.settings.queryStringData)),t.map(a,function(e,i){return e&&e>""?encodeURIComponent(i)+"="+encodeURIComponent(e):void 0}).join("&")},getVideo:function(e){var i="",t=e.match(/((?:www\.)?youtube\.com|(?:www\.)?youtube-nocookie\.com)\/watch\?v=([a-zA-Z0-9\-_]+)/),s=e.match(/(?:www\.)?youtu\.be\/([a-zA-Z0-9\-_]+)/),o=e.match(/(?:www\.)?vimeo\.com\/([0-9]*)/),a="";return t||s?(s&&(t=s),a=n.parseUri(e,{autoplay:d.settings.autoplayVideos?"1":"0",v:""}),i='<iframe width="560" height="315" src="//'+t[1]+"/embed/"+t[2]+"?"+a+'" frameborder="0" allowfullscreen></iframe>'):o?(a=n.parseUri(e,{autoplay:d.settings.autoplayVideos?"1":"0",byline:"0",portrait:"0",color:d.settings.vimeoColor}),i='<iframe width="560" height="315"  src="//player.vimeo.com/video/'+o[1]+"?"+a+'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'):i='<iframe width="560" height="315" src="'+e+'" frameborder="0" allowfullscreen></iframe>','<div class="swipebox-video-container" style="max-width:'+d.settings.videoMaxWidth+'px"><div class="swipebox-video">'+i+"</div></div>"},loadMedia:function(e,i){if(0===e.trim().indexOf("#"))i.call(t("<div>",{"class":"swipebox-inline-container"}).append(t(e).clone().toggleClass(d.settings.toggleClassOnLoad)));else if(!this.isVideo(e)){var s=t("<img>").on("load",function(){i.call(s)});s.attr("src",e)}},getNext:function(){var e,i=this,s=t("#swipebox-slider .slide").index(t("#swipebox-slider .slide.current"));s+1<p.length?(e=t("#swipebox-slider .slide").eq(s).contents().find("iframe").attr("src"),t("#swipebox-slider .slide").eq(s).contents().find("iframe").attr("src",e),s++,i.setSlide(s),i.preloadMedia(s+1),d.settings.nextSlide&&d.settings.nextSlide()):d.settings.loopAtEnd===!0?(e=t("#swipebox-slider .slide").eq(s).contents().find("iframe").attr("src"),t("#swipebox-slider .slide").eq(s).contents().find("iframe").attr("src",e),s=0,i.preloadMedia(s),i.setSlide(s),i.preloadMedia(s+1),d.settings.nextSlide&&d.settings.nextSlide()):(t("#swipebox-overlay").addClass("rightSpring"),setTimeout(function(){t("#swipebox-overlay").removeClass("rightSpring")},500))},getPrev:function(){var e,i=t("#swipebox-slider .slide").index(t("#swipebox-slider .slide.current"));i>0?(e=t("#swipebox-slider .slide").eq(i).contents().find("iframe").attr("src"),t("#swipebox-slider .slide").eq(i).contents().find("iframe").attr("src",e),i--,this.setSlide(i),this.preloadMedia(i-1),d.settings.prevSlide&&d.settings.prevSlide()):(t("#swipebox-overlay").addClass("leftSpring"),setTimeout(function(){t("#swipebox-overlay").removeClass("leftSpring")},500))},nextSlide:function(){},prevSlide:function(){},closeSlide:function(){t("html").removeClass("swipebox-html"),t("html").removeClass("swipebox-touch"),t(e).trigger("resize"),this.destroy()},destroy:function(){t(e).unbind("keyup"),t("body").unbind("touchstart"),t("body").unbind("touchmove"),t("body").unbind("touchend"),t("#swipebox-slider").unbind(),t("#swipebox-overlay").remove(),t.isArray(o)||o.removeData("_swipebox"),this.target&&this.target.trigger("swipebox-destroy"),t.swipebox.isOpen=!1,d.settings.afterClose&&d.settings.afterClose()}},d.init()},t.fn.swipebox=function(e){if(!t.data(this,"_swipebox")){var i=new t.swipebox(this,e);this.data("_swipebox",i)}return this.data("_swipebox")}}(window,document,jQuery);

/* BYMT Core JS v3.0 */

jQuery(document).ready(function($) {
    "use strict";

    // 加载特效
    if (BYMT.load_effect === 'on') {
        NProgress.configure({
            parent: '.bymt-header',
            barSelector: '.bymt-progress',
            spinnerSelector: 'bymt-progress-spinner',
            template: '<div class="bymt-progress"><div class="bymt-progress-spinner"></div></div>'
        });
        NProgress.start();
    }

    // 图片加载判断
    $('img').imagesLoaded(function() {
        if (this.hasAnyBroken){
            for(var i in this.images){
                if(!this.images[i].isLoaded){
                    this.images[i].img.src = BYMT.static_url + 'images/broken_pic.jpg';
                }
            }
        }
    });

    // hash 修复
    function bymt_hash_fix() {
        if (window.location.hash && window.location.hash.replace(/#+/g, '') !== '' ) {
            var offtop = $('body').hasClass('admin-bar') ? -97 : -65;
            $('.tooltip').remove();
            $.scrollTo(location.hash, 500, {offset: {top: offtop}, onAfter: function(){
                bymt_tooltip();
            }});
        }
        $('a[href]').on('click', function(e){
            var _href = location.href.replace(/\#(.*?)$/, ''),
                href = $(this).attr('href').replace(/\#(.*?)$/, ''),
                hash = $(this).attr('href').replace(/^[^#]*(?:#(.*?))?$/, '$1');
            if ( _href === href && hash ) {
                e.preventDefault();
                $('.tooltip').remove();
                var offtop = $('body').hasClass('admin-bar') ? -97 : -65;
                $.scrollTo('#' + hash, 500, {offset: {top: offtop}, onAfter: function(){
                    bymt_tooltip();
                }});
            }
        });
    }
    bymt_hash_fix();

    // 页脚自动定位
    function bymt_footer_position() {
        var over1 = $('body')[0].scrollHeight - $('body')[0].offsetHeight;
        var over2 = $('body').offset().top + $('.bymt-header.fixed').height();
        if ( over1 > over2 ) {
            $('#bymt-footer').css({
                'position': 'absolute',
                'left': 0,
                'bottom': 0
            });
        }
    }
    bymt_footer_position();

    // 自适应菜单
    function bymt_touch_menu() {
        var $mToggle = $('#head-menu-toggle'),
            $mMenu = $('#head-menu'),
            $mNav = $('#head-nav-menu'),
            mWidth = $(document).width(),
            mHeight = $mNav.height(),
            _width = $mNav.attr('_width');
        if ( mHeight > 65 || isMobile.any || mWidth < 782 ) {
            !_width && $mNav.attr('_width', mWidth);
            !$mMenu.hasClass('touch-menu') && $mMenu.addClass('touch-menu');
            $mToggle.show();
        }
        if ( _width && mWidth >= _width ) {
            $mToggle.hide().unbind('click');
            $mMenu.removeClass('touch-menu active');
            $mNav.removeAttr('_width');
        }
        $mToggle.on('click', function(e) {
            e.preventDefault();
            $mToggle.toggleClass('active');
            $mMenu.toggleClass('active');
        });
        $mMenu.on('click', function(e) {
            if ( e.target.id && e.target.id !== 'head-nav-menu' ) {
                $mToggle.removeClass('active');
                $mMenu.removeClass('active');
            }
        });
        $mNav.children('li').on('click', function() {
            if ( !$mMenu.hasClass('touch-menu') ) {
                return;
            }
            if ( $(this).hasClass('open') ) {
                $(this).removeClass('open').stop(false,true).animate({'height':'45px'}, 300);
            } else {
                $(this).addClass('open').stop(false,true).animate({'height':this.scrollHeight}, 300);
            }
            $(this).siblings('li').removeClass('open').animate({'height':'45px'}, 300);
        });
    }
    bymt_touch_menu();

    // 图片延迟加载
    function bymt_img_lazyload() {
        if ( BYMT.img_lazyload === 'on' ) {
            $('img.lazy').lazyload({
                effect: 'fadeIn',
                broken_pic: BYMT.static_url + 'images/broken_pic.jpg'
            });
        }
    }
    bymt_img_lazyload();

    // 工具提示
    function bymt_tooltip() {
        if ( BYMT.tooltip === 'on' && !isMobile.any  ) {
            $('[title]').tooltip({
                container: 'body',
                placement: BYMT.tooltip_layout
            });
        }
    }
    bymt_tooltip();

    // 提示窗口
    function bymt_alert(title, desc, id) {
        var alert_html = '<div class="bymt-alert"><div class="alert-main"><h3 class="alert-title">' + title + '</h3><p class="alert-desc">' + desc + '</p><button class="alert-btn">OK</button></div></div>';
        id = id || '';
        var btnId = id ? ' id="btn-' + id + '"' : '';
        var alert = '<div class="bymt-alert"><div class="alert-main"><h3 class="alert-title">' + title + '</h3><div class="alert-desc">' + desc + '</div><button' + btnId + ' class="alert-btn">OK</button></div></div>'
        $('.bymt-alert').remove();
        $('body').append(alert);
        $('.bymt-alert').addClass('showAlert');
        $('.bymt-alert .alert-main').css({
            'margin-top': Math.round( $('.bymt-alert').outerHeight() / 2 - $('.bymt-alert .alert-main').outerHeight() / 2 ) + 'px'
        })
        $('.bymt-alert .alert-desc').css({
            'max-height': Math.round( $('.bymt-alert').outerHeight() / 2 ) + 'px'
        })
        $('.bymt-alert .alert-btn').focus();
        $('.bymt-alert .alert-btn').on('click',function(e){
            $('.bymt-alert').removeClass('showAlert').addClass('hideAlert');
            setTimeout(function(){
                $('.bymt-alert').remove();
            }, 400);
        });
    }

    // 加载中
    function bymt_loading(type, addclass) {
        var addclass = ' ' + addclass || '';
        if ( type === 'show' ){
            return '<div id="bymt-loading" class="bymt-loading' + addclass + '"><div class="stick"></div><div class="stick stick2"></div><div class="text">Loading</div></div>';
        }
        if ( type === 'hide' ) {
            return $('#bymt-loading').fadeOut(500, function(){
                setTimeout(function(){
                    $('#bymt-loading').remove();
                }, 1000);
            });
        }
    }

    // 焦点图
    function bymt_slider(selector, options) {
        if ( !selector ) return;
        if ($.isFunction($.fn.flexslider) && $('.slides li', selector).length > 1){
            var opts = {
                controlNav: false,
                smoothHeight: true,
                prevText: '<i class="iconfont icon-prev"></i>',
                nextText: '<i class="iconfont icon-next"></i>'
            };
            if ( !options ) return;
            opts = $.extend(opts, options);
            $(selector).flexslider(opts);
        } else {
            $('.slides li', selector).fadeIn(500);
        }
    }
    if (BYMT.slider_header === 'on') {
        bymt_slider('.bymt-header-slider', BYMT.slider_header_opt);
    }
    if (BYMT.slider_widget === 'on') {
        bymt_slider('.bymt-widget-slider',BYMT.slider_widget_opt);
    }

    // 侧栏高度自动适配
    function bymt_sidebar_auto_height() {
        if ( BYMT.sidebar_auto_height === 'on' ) {
            var sidebarHeight = 0;
            $('#sidebar .widget').each(function(i,e) {
                sidebarHeight += $(e).outerHeight();
                if (sidebarHeight - $('#main-section').outerHeight() > 50 ) {
                    if ( $(e).prev().length ) {
                        $(e).hide();
                    }
                    $(e).nextAll('.widget').hide();
                    return;
                }
            });
        }
    }
    bymt_sidebar_auto_height();

    // pjax 翻页
    function bymt_pjax_page(selector, targeter) {
        $.pjax({
            selector: selector,
            container: targeter,
            show: 'fade',
            cache: false,
            storage: false,
            timeout: 30000,
            callback: function(status, data){
                if ( status.type === 'success' ) {
                    var paged = $('#post-pagenavi .current').text();
                    $('#list-paged').text(paged);
                    bymt_hash_fix();
                    bymt_sidebar_auto_height();
                    bymt_img_lazyload();
                    bymt_tooltip();
                }
            }
        });
        $(targeter).on('pjax.start', function(e){
            var This = $(targeter), offtop = $('body').hasClass('admin-bar') ? -157 : -135;
            $('.tooltip').remove();
            $.scrollTo(targeter, 500, {offset: {top: offtop}, onAfter: function(){
                var load = bymt_loading('show', 'hentry');
                $(targeter).html(load);
            }});
        });
        $(targeter).on('pjax.end', function(e, xhr){
            if ( $(xhr.responseText).find('.media-player').length ) {
                window.location.reload();
                return;
            }
            bymt_loading('hide');
        });
    }
    // pjax 文章翻页
    if (BYMT.pjax_page_post === 'on') {
        bymt_pjax_page('#post-pagenavi a[href]', '#main-section');
    }

    // pjax 评论翻页
    if (BYMT.pjax_page_comment === 'on') {
        bymt_pjax_page('#comment-pagenavi a[href]', '#commentshow');
    }

    // LOGO 效果
    var logomask = true;
    $('#bymt-logo img').mouseover(function(){
        if (logomask) {
            var maskstart = 0;
            var This = $(this);
            var timer = setInterval(function(){
                logomask = false;
                if (maskstart > parseInt(This.width())) {
                    logomask = true;
                    clearInterval(timer);
                }
                This.css('-webkit-mask', '-webkit-gradient(radial, 0 0, ' + maskstart + ', 0 0, ' + (maskstart + 15) + ' , from(rgba(0, 0, 0, 1)), color-stop(0.5, rgba(0, 0, 0, 0.2)), to(rgba(0, 0, 0, 1)))');
                maskstart++;
            }, 0);
        }
    });

    // 公告栏
    if ( $('#bulletin-list li').length > 1 ) {
        var bscroller = setInterval(function(){
            $('#bulletin-list:first').animate({marginTop:"-40px"}, 500, function(){
                $(this).css({marginTop:"0px"}).find("li:first").appendTo(this);
            });
        }, 5000);
    }
    $('#bymt-bulletin').on('click','.icon-close',function(e){
        e.preventDefault();
        clearInterval(bscroller);
        $('#bymt-bulletin').slideUp();
    });
    $('#bymt-bulletin').on('click','.icon-bulletin',function(){
        var text = $('#bymt-bulletin').find('.blt-text').html();
        bymt_alert( '公告栏', text );
    });

    // 代码高亮
    if (BYMT.code_highlight === 'on') {
        hljs.configure({
            tabReplace: '   ',
        });
        $('pre').each(function(i, block) {
            hljs.highlightBlock(block);
        });
    }

    // 图片灯箱
    if ( BYMT.img_lightbox === 'on' ) {
        $('.post-content a:has(img)').swipebox();
    }

    // 伸缩栏
    $('#main-section').on('click', '.toggle-title', function(e){
        e.preventDefault();
        $(this).parent().toggleClass('active');
    });

    // 侧栏选项卡
    $('#widget-bymt-tab-nav').on('click', 'li', function(e){
        e.preventDefault();
        $(this).addClass('active').siblings().removeClass('active');
        $(this).closest('.widget').find('.tab-content').eq($(this).index()).fadeIn().siblings().hide();
    });

    // 内页选项卡
    $('#main-section').on('click', '.tabs-title li a', function(e){
        e.preventDefault();
        var cont = $(this).attr('href');
        $(this).parent().addClass('active').siblings().removeClass('active');
        $(cont).addClass('active').siblings().removeClass('active');
    });

    // 分享功能
    $('.copr-social a').on('click', function(e){
        e.preventDefault();
        var href = $(this).data('href');
        var title = $(this).data('original-title');
        title = title ? title : $(this).attr('title');
        if ( $(this).hasClass('share-weixin') ) {
            bymt_alert(title, '<img src="' + href + '" width="172px" height="172px" alt="qrcode" />');
        } else {
            window.open(href, '_blank', 'width=750,height=450');
        }
    });

    // 页头搜索
    $('#head-search .iconfont').on('click', function(){
        $(this).parent().toggleClass('full-search');
        if ( $(this).hasClass('icon-search') ) {
            var data = '<div id="ajax-search-data" class="ajax-search-data transition3"><ol id="ajax-search-list" class="container"></ol></div>';
            $('#ajax-search-data').remove();
            $('body').append(data);
            $(this).addClass('icon-close').removeClass('icon-search');
            $(this).next('input').focus();
            document.title = '[搜索模式] - ' + document.title;
        } else {
            $(this).addClass('icon-search').removeClass('icon-close');
            $('#search-input').val('');
            $('#ajax-search-data').removeClass('active');
            document.title = document.title.replace('[搜索模式] - ', '');
            setTimeout(function(){
                $('#ajax-search-data').remove();
            }, 500);
        }
    });

    // 社交图标
    $('#widget-socials-list li a').mouseover(function(){
        var color = $(this).data('color');
        $(this).css({
            'background-color': color,
            'border-color': color
        });
    }).mouseout(function(){
        $(this).removeAttr('style');
    });

    // 文章归档
    $('#bymt-archives').on('click', 'li.year', function(){
        var artID = $(this).attr('id'),
            $artMain = $('#bymt-archives'),
            offtop = $('body').hasClass('admin-bar') ? -97 : -65;
        $artMain.find('li.' + artID).toggleClass('active');
        if ( $artMain.find('li.active').length ) {
            $.scrollTo($(this), 500, {offset: {top: offtop}});
        } else {
            $.scrollTo(0, 500);
        }
    });

    // 评论回复
    $('#comments').on('click', '.comment-reply-link', function(e){
        e.preventDefault();
        var commId = $(this).data('comment-id'),
            icon = $(this).find('.iconfont'),
            title = icon.attr('title') ? icon.attr('title') : icon.data('original-title'),
            offtop = $('body').hasClass('admin-bar') ? -97 : -65;
        $('#comment_parent').val(commId);
        $('#respond').slideUp(500, function(){
            $('#respond h3').html('<i class="iconfont icon-forward"></i>' + title);
            $('#cancel-comment-reply-link').addClass('cancel-link').show();
            $('#comment-' + commId).append($('#respond'));
            $.scrollTo('#comment-' + commId, 500, { offset: { top: offtop }, onAfter: function(){
                $('#respond').slideDown(500, function(){
                    $('#comment-tools-editor').animate({'height':'220px'}, 500).focus();
                });
            }});
        });
    });

    // 取消回复
    $('#cancel-comment-reply-link').on('click', function(e){
        e.preventDefault();
        $('#comment_parent').val(0);
        $('#respond').slideUp(500, function(){
            $('#respond h3').html($('#respond h3').data('title'));
            $('#cancel-comment-reply-link').hide();
            $('#comment-tools-editor').removeAttr('style');
            $('#commentshow').after($('#respond'));
            $('#respond').slideDown(500);
        });
    });

    // 快捷回复 Ctrl+Enter
    $('#comment-tools-editor').on('keypress', function(e){
        if ( e.ctrlKey && $.inArray( e.keyCode, ['10', '13'] ) ) {
            $('#commentform').trigger('submit');
        }
    });

    // 编辑个人信息
    $('#edit-info').on('click', function(e){
        e.preventDefault();
        $('#comment-form-info').toggleClass('hidden');
    });

    // ajax 喜欢
    $('#main-section').on('click', '.bymt-like', function(e){
        e.preventDefault();
        var This = $(this);
        var Icon = $(this).find('.iconfont');
        var args = {
            action: 'bymt_like',
            status: This.hasClass('liked') ? 'liked' : 'like',
            type: This.data('type'),
            lid: This.data('lid'),
            nonce: This.data('nonce')
        };
        if ( Icon.hasClass('liking') ) {
            return;
        } else {
            Icon.addClass('liking');
        }
        $.post(BYMT.ajax_url, args, function(r){
            Icon.removeClass('liking');
            if (r.status === '200') {
                r.type === 'liked' ? This.addClass('liked') : This.removeClass('liked');                
                This.html(r.data);
            } else {
                bymt_alert('喜欢发送失败', r.msg);
            }
            bymt_tooltip();
        });
    });

    // ajax 搜索
    if (BYMT.ajax_search === 'on') {
        var timestamp, is_search = false;
        $('#search-input').on( 'input', function(e){
            e.preventDefault();
            var keywords = $(this).val().replace(/\s+/g, ' '),
                args = {
                    action: 'bymt_ajax',
                    type: 'search',
                    value: keywords,
                    nonce: $(this).data('nonce')
                },
                ajax_load = $(this).data('ajax-load'),
                ajax_null = $(this).data('ajax-null'),
                randcolor = function(){
                    var hex = ['66','99','cc','ff'],
                        rand1 = parseInt(Math.random() * 3),
                        rand2 = parseInt(Math.random() * 3),
                        rand3 = parseInt(Math.random() * 3);
                    return '#' + hex[rand1] + hex[rand2] + hex[rand3];
                };
            $(this).css('border-color', randcolor());
            timestamp = e.timeStamp;
            setTimeout(function(){
                if ( is_search || parseInt( timestamp - e.timeStamp ) || !keywords.replace(/\s+/g, '') ) {
                    return;
                }
                $('#ajax-search-data').addClass('active');
                $('#ajax-search-list').empty().append('<p><a><i class="iconfont icon-load"></i>' + ajax_load + '</a></p>');
                is_search = true;
                $.post( BYMT.ajax_url, args, function(r){
                    setTimeout(function(){
                        is_search = false;
                        $('#ajax-search-list').empty();
                        if(!r.length){
                            return $('#ajax-search-list').append('<p><a><i class="iconfont icon-empty"></i>' + ajax_null + '</a></p>');
                        }
                        var i = 0;
                        var timer = setInterval(function(){
                            if ( i === r.length - 1 ) {
                                clearInterval(timer);
                            }
                            $('#ajax-search-list').append('<li><a href="'+r[i]['url']+'">'+r[i]['title']+'</a><span class="time">( ' + r[i]["time"] + ' )</span></li>');
                            i++;
                        }, 120);
                    }, 500);
                });
            }, 1000);
        });
    }

    // ajax 评论
    if (BYMT.ajax_comment === 'on') {
        $('#commentform').on('submit', function(e){
            e.preventDefault();
            var data = $(this).serializeArray(),
                args = {
                    action: 'bymt_ajax',
                    type: 'comment',
                    value: 'comment',
                    nonce: $('#comment').data('nonce')
                },
                ajax_load = $('#comment').data('ajax-load'),
                ajax_empty = $('#comment').data('ajax-empty'),
                msg = '<div id="comment-msg" class="comment-msg"></div>',
                offtop = $('body').hasClass('admin-bar') ? -97 : -65,
                waiting = 500;
            $.each(data, function(i, field){
                args[field.name] = field.value;
            });
            $('#comment-msg').remove();
            $('#comment').before(msg);
            if ( args['comment'].replace(/\s+/g, '') === '' ) {
                return $('#comment-msg').html('<i class="iconfont icon-error"></i>' + ajax_empty).addClass('error').slideDown(300);
            }
            $('#comment-msg').html('<i class="iconfont icon-load"></i>' + ajax_load).removeClass('done error').slideDown(300);
            $('#submit').prop('disabled', true);
            $('#comment').prop('readonly', true);
            $('#comment-tools-editor').prop('contenteditable', false).css('opacity', '0.65');
            $.post( BYMT.ajax_url, $.param(args), function(r){
                setTimeout(function(){
                    $('#submit').prop('disabled', false);
                    $('#comment').prop('readonly', false);
                    $('#comment-tools-editor').prop('contenteditable', true).css('opacity', '1');
                    if ( !r.status || r.status !== '200' ) {
                        var rmsg = !r.status ? r : r.msg;
                        return $('#comment-msg').html('').slideUp(300, function(){
                            $('#comment-msg').html('<i class="iconfont icon-error"></i>' + rmsg).addClass('error').slideDown(300);
                        });
                    }
                    $('#comment-tools-editor').html('');
                    $('#comment').val('');
                    if (r.msg){
                        var commId = $('#comment_parent').val();
                        var child = $('#comment-' + commId).next('.children');
                        $('#comment-msg').html('').slideUp(300);
                        if ( commId > 0 ) {
                            child.length ? child.children('li').last().after(r.msg) : $('#comment-' + commId).after('<ul class="children">' + r.msg + '</ul>');
                            $('#cancel-comment-reply-link').trigger('click');
                        } else {
                            $('#commentlist').append(r.msg);
                            waiting = 0;
                        }
                        $(r.scroll).addClass('new');
                        setTimeout(function(){
                            $.scrollTo(r.scroll, 500, { offset: { top: offtop }, onAfter: function(){
                                setTimeout(function(){
                                    $(r.scroll).removeClass('new');
                                    $('#comment-msg').remove();
                                }, 1000);
                            }});
                        }, waiting);
                    }
                }, 500);
            });
        });
    }

    // 评论栏增强
    if (BYMT.comment_tools === 'on') {
        var toolbar = $('#comment-tools-bar'),
            editor = $('#comment-tools-editor'),
            updateToolbar = function () {
                toolbar.find('a[data-command]').each(function () {
                    var command = $(this).data('command').split('|')[0];
                    if (document.queryCommandState(command)) {
                        $(this).addClass('active');
                    } else {
                        $(this).removeClass('active');
                    }
                });
            },
            execCommand = function(command, value) {
                value = value || '';
                document.execCommand(command, 0, value);
                updateToolbar();
            },
            saveSelection = function () {
                if (window.getSelection) {
                    var sel = window.getSelection();
                    if (sel.rangeCount > 0) {
                        return sel.getRangeAt(0);
                    }
                } else if (document.selection && document.selection.createRange) {
                    return document.selection.createRange();
                }
                return null;
            },
            restoreSelection = function () {
                var range = saveSelection();
                if (range) {
                    if (window.getSelection) {
                        var sel = window.getSelection();
                        sel.removeAllRanges();
                        sel.addRange(range);
                    } else if (document.selection && range.select) {
                        range.select();
                    }
                }
            };
        editor.attr('contenteditable', true).on('mouseup keyup mouseout', function(e) {
            var html = $(this).html().replace(/(<br>|\s|<div><br><\/div>)*$/, '');
            $('#comment').val( html );
            $('#smilies').removeClass('active');
            saveSelection();
            updateToolbar();
        });
        toolbar.find('a[data-command]').on('click', function(e){
            var args = $(this).data('command'), command, value;
            if ( args.indexOf('|') > -1 ) {
                command = args.split('|')[0];
                value = args.split('|')[1];
            } else {
                command = args;
            }
            $(this).toggleClass('active');
            if ( command === 'custom' ) {
                switch( value ) {
                    case 'smile':
                        $('#smilies').toggleClass('active');                      
                        break;
                    case 'image':
                        var imgID = 'imgurl-' + Math.floor(Math.random()*(999-1+1)+1);
                        bymt_alert('请输入图片地址', '<input id="' + imgID + '" type="url" />', imgID);
                        $('#btn-'+imgID).on('click', function(e){
                            var imgSrc = $('#'+imgID).val();
                            if ( /https?:\/\/[^\/\.]+(?:\.){1}[^\/\.]+/i.test( imgSrc ) ) {
                                restoreSelection();
                                editor.focus();
                                execCommand( 'insertImage', imgSrc );
                                saveSelection();
                            }
                            editor.focus();
                        });
                        break;
                    case 'audio':
                        var audioID = 'audio-' + Math.floor(Math.random()*(999-1+1)+1);
                        bymt_alert('请输入音频地址', '<input id="' + audioID + '" type="url" />', audioID);
                        $('#btn-'+audioID).on('click', function(e){
                            var audioSrc = $('#'+audioID).val();
                            if ( /https?:\/\/[^\/\.]+(?:\.){1}[^\/\.]+/i.test( audioSrc ) ) {
                                restoreSelection();
                                editor.focus();
                                execCommand( 'insertHTML', '<audio preload="metadata" controls="controls" src="' + audioSrc + '"></audio><br>' );
                                saveSelection();
                            }
                            editor.focus();
                        });
                        break;
                    case 'video':
                        var videoID = 'audio-' + Math.floor(Math.random()*(999-1+1)+1);
                        bymt_alert('请输入视频地址', '<input id="' + videoID + '" type="url" />', videoID);
                        $('#btn-'+videoID).on('click', function(e){
                            var videoSrc = $('#'+videoID).val();
                            if ( /https?:\/\/[^\/\.]+(?:\.){1}[^\/\.]+/i.test( videoSrc ) ) {
                                restoreSelection();
                                editor.focus();
                                execCommand( 'insertHTML', '<video preload="metadata" controls="controls" src="' + videoSrc + '"></video><br>' );
                                saveSelection();
                            }
                            editor.focus();
                        });
                        break;
                }
            } else {
                restoreSelection();
                editor.focus();
                execCommand(command, value);
                saveSelection();
            }
        });
        $('#smilies li').on('click', function(e){
            editor.focus();
            execCommand( 'insertHTML', $(this).html() );
            saveSelection();
        });
    }

    // 返回顶部
    $(window).scroll(function(){
        if ( !$('#backtop').length ) {
            return;
        }
        var sBottom,
            sTop = $(document).scrollTop(),
            bTop = $('#backtop').offset().top,
            bHeight = $('#backtop').outerHeight(),
            fTop = $('#bymt-footer').offset().top,
            fLeft = $('#foot-copr > div').offset().left,
            fWidth = $('#foot-copr > div').width(),
            fHeight = $('#bymt-footer').outerHeight();
        if ( $('#foot-widget').length ) {
            fTop = $('#foot-copr').offset().top;
            fHeight = $('#foot-copr').outerHeight();
        }
        if ( Math.round( bTop + bHeight ) < Math.round(fTop) ) {
            sBottom = 0;
        } else {
            sBottom = fHeight;
        }
        if ( sTop < 180  ) {
            sBottom = -bHeight;
        }
        $('#backtop').css({ 
            'left': Math.round(fLeft + fWidth) + 'px',
            'bottom': sBottom + 'px'
        });
    });
    $('#backtop').on('click', function(e) {
        e.preventDefault();
        $.scrollTo(0, 700);
    });

    // 文档完全加载处理
    window.onload = function(){
        NProgress.done();
    }
    $(window).resize(function(){
        bymt_touch_menu();
    });
});