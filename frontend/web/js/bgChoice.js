"use strict";
function _typeof(e) {
    return (_typeof =
        "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
            ? function (e) {
                  return typeof e;
              }
            : function (e) {
                  return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
              })(e);
}
(function () {
    var e, t, n, o;
    (t = window.device),
        (e = {}),
        (window.device = e),
        window.document.documentElement,
        (o = window.navigator.userAgent.toLowerCase()),
        (e.ios = function () {
            return e.iphone() || e.ipod() || e.ipad();
        }),
        (e.iphone = function () {
            return !e.windows() && n("iphone");
        }),
        (e.ipod = function () {
            return n("ipod");
        }),
        (e.ipad = function () {
            return n("ipad");
        }),
        (e.android = function () {
            return !e.windows() && n("android");
        }),
        (e.androidPhone = function () {
            return e.android() && n("mobile");
        }),
        (e.androidTablet = function () {
            return e.android() && !n("mobile");
        }),
        (e.blackberry = function () {
            return n("blackberry") || n("bb10") || n("rim");
        }),
        (e.blackberryPhone = function () {
            return e.blackberry() && !n("tablet");
        }),
        (e.blackberryTablet = function () {
            return e.blackberry() && n("tablet");
        }),
        (e.windows = function () {
            return n("windows");
        }),
        (e.windowsPhone = function () {
            return e.windows() && n("phone");
        }),
        (e.windowsTablet = function () {
            return e.windows() && n("touch") && !e.windowsPhone();
        }),
        (e.fxos = function () {
            return (n("(mobile;") || n("(tablet;")) && n("; rv:");
        }),
        (e.fxosPhone = function () {
            return e.fxos() && n("mobile");
        }),
        (e.fxosTablet = function () {
            return e.fxos() && n("tablet");
        }),
        (e.meego = function () {
            return n("meego");
        }),
        (e.cordova = function () {
            return window.cordova && "file:" === location.protocol;
        }),
        (e.nodeWebkit = function () {
            return "object" === _typeof(window.process);
        }),
        (e.mobile = function () {
            return e.androidPhone() || e.iphone() || e.ipod() || e.windowsPhone() || e.blackberryPhone() || e.fxosPhone() || e.meego();
        }),
        (e.tablet = function () {
            return e.ipad() || e.androidTablet() || e.blackberryTablet() || e.windowsTablet() || e.fxosTablet();
        }),
        (e.desktop = function () {
            return !e.tablet() && !e.mobile();
        }),
        (e.television = function () {
            var e;
            for (television = ["googletv", "viera", "smarttv", "internet.tv", "netcast", "nettv", "appletv", "boxee", "kylo", "roku", "dlnadoc", "roku", "pov_tv", "hbbtv", "ce-html"], e = 0; e < television.length; ) {
                if (n(television[e])) return !0;
                e++;
            }
            return !1;
        }),
        (e.noConflict = function () {
            return (window.device = t), this;
        }),
        (n = function (e) {
            return -1 !== o.indexOf(e);
        }),
        "function" == typeof define && "object" === _typeof(define.amd) && define.amd
            ? define(function () {
                  return e;
              })
            : "undefined" != typeof module && module.exports
            ? (module.exports = e)
            : (window.device = e);
}.call(void 0));
var BrowserDetect = {
    init: function () {
        (this.browser = this.searchString(this.dataBrowser) || "An unknown browser"),
            (this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "an unknown version"),
            (this.OS = this.searchString(this.dataOS) || "an unknown OS");
    },
    searchString: function (e) {
        for (var t = 0; t < e.length; t++) {
            var n = e[t].string,
                o = e[t].prop;
            if (((this.versionSearchString = e[t].versionSearch || e[t].identity), n)) {
                if (-1 != n.indexOf(e[t].subString)) return e[t].identity;
            } else if (o) return e[t].identity;
        }
    },
    searchVersion: function (e) {
        var t = e.indexOf(this.versionSearchString);
        if (-1 != t) return parseFloat(e.substring(t + this.versionSearchString.length + 1));
    },
    dataBrowser: [
        { string: navigator.userAgent, subString: "Chrome", identity: "Chrome" },
        { string: navigator.userAgent, subString: "OmniWeb", versionSearch: "OmniWeb/", identity: "OmniWeb" },
        { string: navigator.vendor, subString: "Apple", identity: "Safari", versionSearch: "Version" },
        { prop: window.opera, identity: "Opera", versionSearch: "Version" },
        { string: navigator.vendor, subString: "iCab", identity: "iCab" },
        { string: navigator.vendor, subString: "KDE", identity: "Konqueror" },
        { string: navigator.userAgent, subString: "Firefox", identity: "Firefox" },
        { string: navigator.vendor, subString: "Camino", identity: "Camino" },
        { string: navigator.userAgent, subString: "Netscape", identity: "Netscape" },
        { string: navigator.userAgent, subString: "MSIE", identity: "Internet Explorer", versionSearch: "MSIE" },
        { string: navigator.userAgent, subString: "Gecko", identity: "Mozilla", versionSearch: "rv" },
        { string: navigator.userAgent, subString: "Mozilla", identity: "Netscape", versionSearch: "Mozilla" },
    ],
    dataOS: [
        { string: navigator.platform, subString: "Win", identity: "Windows" },
        { string: navigator.platform, subString: "Mac", identity: "Mac" },
        { string: navigator.userAgent, subString: "iPhone", identity: "iPhone/iPod" },
        { string: navigator.platform, subString: "Linux", identity: "Linux" },
    ],
};
BrowserDetect.init();
var defaultBgr = document.querySelector(".default-background"),
    chromeDesktopBgr = document.querySelector(".header__background_chrome-desktop-webm"),
    otherDesktopBgr = document.querySelector(".header__background_other-desktop-mp4"),
    mobileBgr = document.querySelector(".header__background_mobile"),
    pathToImage = "theme/images/genieping/";
device.desktop() && "Chrome" == BrowserDetect.browser
    ? (defaultBgr.classList.remove("default-background"),
      (chromeDesktopBgr.style.display = "block"),
      (chromeDesktopBgr.innerHTML = '<video preload="auto" autoplay="autoplay" loop="true" muted="muted" poster="'
          .concat(pathToImage, 'Homepage-playstation-5-pre-order-Slide-one.webp">\n    <source src="')
          .concat(pathToImage, 'Homepage-playstation-5-pre-order-Slide-one.webm" type="video/webm">\n  </video>')))
    : device.desktop() && "Chrome" !== BrowserDetect.browser
    ? (defaultBgr.classList.remove("default-background"),
      (otherDesktopBgr.style.display = "block"),
      (otherDesktopBgr.innerHTML = '<video preload="auto" autoplay="autoplay" loop="true" muted="muted" poster="'
          .concat(pathToImage, 'Homepage-playstation-5-pre-order-Slide-one.webp">\n    <source src="')
          .concat(pathToImage, 'Homepage-playstation-5-pre-order-Slide-one.mp4" type="video/mp4">\n  </video>')))
    : (device.tablet() || device.mobile()) &&
      (defaultBgr.classList.remove("default-background"),
      (mobileBgr.style.display = "block"),
      (mobileBgr.innerHTML = '<picture>\n    <source srcset="'
          .concat(pathToImage, 'Homepage-playstation-5-pre-order-Slide-one.webp" type="image/webp"><img src="')
          .concat(pathToImage, 'Homepage-playstation-5-pre-order-Slide-one.jpg" alt="">\n  </picture>')));
