/*


   Magic Zoom  v5.0.8 DEMO
   Copyright 2015 Magic Toolbox
   Buy a license: https://www.magictoolbox.com/magiczoom/
   License agreement: https://www.magictoolbox.com/license/


*/
window.MagicZoom = (function() {
    var v, x;
    v = x = (function() {
        var R = {
            version: "v3.3-b3-8-g4bc9bfe",
            UUID: 0,
            storage: {},
            $uuid: function(V) {
                return (V.$J_UUID || (V.$J_UUID = ++L.UUID))
            },
            getStorage: function(V) {
                return (L.storage[V] || (L.storage[V] = {}))
            },
            $F: function() {},
            $false: function() {
                return false
            },
            $true: function() {
                return true
            },
            stylesId: "mjs-" + Math.floor(Math.random() * new Date().getTime()),
            defined: function(V) {
                return (undefined != V)
            },
            ifndef: function(W, V) {
                return (undefined != W) ? W : V
            },
            exists: function(V) {
                return !!(V)
            },
            jTypeOf: function(V) {
                if (!L.defined(V)) {
                    return false
                }
                if (V.$J_TYPE) {
                    return V.$J_TYPE
                }
                if (!!V.nodeType) {
                    if (1 == V.nodeType) {
                        return "element"
                    }
                    if (3 == V.nodeType) {
                        return "textnode"
                    }
                }
                if (V.length && V.item) {
                    return "collection"
                }
                if (V.length && V.callee) {
                    return "arguments"
                }
                if ((V instanceof window.Object || V instanceof window.Function) && V.constructor === L.Class) {
                    return "class"
                }
                if (V instanceof window.Array) {
                    return "array"
                }
                if (V instanceof window.Function) {
                    return "function"
                }
                if (V instanceof window.String) {
                    return "string"
                }
                if (L.jBrowser.trident) {
                    if (L.defined(V.cancelBubble)) {
                        return "event"
                    }
                } else {
                    if (V === window.event || V.constructor == window.Event || V.constructor == window.MouseEvent || V.constructor == window.UIEvent || V.constructor == window.KeyboardEvent || V.constructor == window.KeyEvent) {
                        return "event"
                    }
                }
                if (V instanceof window.Date) {
                    return "date"
                }
                if (V instanceof window.RegExp) {
                    return "regexp"
                }
                if (V === window) {
                    return "window"
                }
                if (V === document) {
                    return "document"
                }
                return typeof(V)
            },
            extend: function(aa, Z) {
                if (!(aa instanceof window.Array)) {
                    aa = [aa]
                }
                if (!Z) {
                    return aa[0]
                }
                for (var Y = 0, W = aa.length; Y < W; Y++) {
                    if (!L.defined(aa)) {
                        continue
                    }
                    for (var X in Z) {
                        if (!Object.prototype.hasOwnProperty.call(Z, X)) {
                            continue
                        }
                        try {
                            aa[Y][X] = Z[X]
                        } catch (V) {}
                    }
                }
                return aa[0]
            },
            implement: function(Z, Y) {
                if (!(Z instanceof window.Array)) {
                    Z = [Z]
                }
                for (var X = 0, V = Z.length; X < V; X++) {
                    if (!L.defined(Z[X])) {
                        continue
                    }
                    if (!Z[X].prototype) {
                        continue
                    }
                    for (var W in (Y || {})) {
                        if (!Z[X].prototype[W]) {
                            Z[X].prototype[W] = Y[W]
                        }
                    }
                }
                return Z[0]
            },
            nativize: function(X, W) {
                if (!L.defined(X)) {
                    return X
                }
                for (var V in (W || {})) {
                    if (!X[V]) {
                        X[V] = W[V]
                    }
                }
                return X
            },
            $try: function() {
                for (var W = 0, V = arguments.length; W < V; W++) {
                    try {
                        return arguments[W]()
                    } catch (X) {}
                }
                return null
            },
            $A: function(X) {
                if (!L.defined(X)) {
                    return L.$([])
                }
                if (X.toArray) {
                    return L.$(X.toArray())
                }
                if (X.item) {
                    var W = X.length || 0,
                        V = new Array(W);
                    while (W--) {
                        V[W] = X[W]
                    }
                    return L.$(V)
                }
                return L.$(Array.prototype.slice.call(X))
            },
            now: function() {
                return new Date().getTime()
            },
            detach: function(Z) {
                var X;
                switch (L.jTypeOf(Z)) {
                    case "object":
                        X = {};
                        for (var Y in Z) {
                            X[Y] = L.detach(Z[Y])
                        }
                        break;
                    case "array":
                        X = [];
                        for (var W = 0, V = Z.length; W < V; W++) {
                            X[W] = L.detach(Z[W])
                        }
                        break;
                    default:
                        return Z
                }
                return L.$(X)
            },
            $: function(X) {
                var V = true;
                if (!L.defined(X)) {
                    return null
                }
                if (X.$J_EXT) {
                    return X
                }
                switch (L.jTypeOf(X)) {
                    case "array":
                        X = L.nativize(X, L.extend(L.Array, {
                            $J_EXT: L.$F
                        }));
                        X.jEach = X.forEach;
                        return X;
                        break;
                    case "string":
                        var W = document.getElementById(X);
                        if (L.defined(W)) {
                            return L.$(W)
                        }
                        return null;
                        break;
                    case "window":
                    case "document":
                        L.$uuid(X);
                        X = L.extend(X, L.Doc);
                        break;
                    case "element":
                        L.$uuid(X);
                        X = L.extend(X, L.Element);
                        break;
                    case "event":
                        X = L.extend(X, L.Event);
                        break;
                    case "textnode":
                    case "function":
                    case "array":
                    case "date":
                    default:
                        V = false;
                        break
                }
                if (V) {
                    return L.extend(X, {
                        $J_EXT: L.$F
                    })
                } else {
                    return X
                }
            },
            $new: function(V, X, W) {
                return L.$(L.doc.createElement(V)).setProps(X || {}).jSetCss(W || {})
            },
            addCSS: function(W, Y, ac) {
                var Z, X, aa, ab = [],
                    V = -1;
                ac || (ac = L.stylesId);
                Z = L.$(ac) || L.$new("style", {
                    id: ac,
                    type: "text/css"
                }).jAppendTo((document.head || document.body), "top");
                X = Z.sheet || Z.styleSheet;
                if ("string" != L.jTypeOf(Y)) {
                    for (var aa in Y) {
                        ab.push(aa + ":" + Y[aa])
                    }
                    Y = ab.join(";")
                }
                if (X.insertRule) {
                    V = X.insertRule(W + " {" + Y + "}", X.cssRules.length)
                } else {
                    V = X.addRule(W, Y)
                }
                return V
            },
            removeCSS: function(Y, V) {
                var X, W;
                X = L.$(Y);
                if ("element" !== L.jTypeOf(X)) {
                    return
                }
                W = X.sheet || X.styleSheet;
                if (W.deleteRule) {
                    W.deleteRule(V)
                } else {
                    if (W.removeRule) {
                        W.removeRule(V)
                    }
                }
            },
            generateUUID: function() {
                return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function(X) {
                    var W = Math.random() * 16 | 0,
                        V = X == "x" ? W : (W & 3 | 8);
                    return V.toString(16)
                }).toUpperCase()
            },
            getAbsoluteURL: (function() {
                var V;
                return function(W) {
                    if (!V) {
                        V = document.createElement("a")
                    }
                    V.setAttribute("href", W);
                    return ("!!" + V.href).replace("!!", "")
                }
            })(),
            getHashCode: function(X) {
                var Y = 0,
                    V = X.length;
                for (var W = 0; W < V; ++W) {
                    Y = 31 * Y + X.charCodeAt(W);
                    Y %= 4294967296
                }
                return Y
            }
        };
        var L = R;
        var M = R.$;
        if (!window.magicJS) {
            window.magicJS = R;
            window.$mjs = R.$
        }
        L.Array = {
            $J_TYPE: "array",
            indexOf: function(Y, Z) {
                var V = this.length;
                for (var W = this.length, X = (Z < 0) ? Math.max(0, W + Z) : Z || 0; X < W; X++) {
                    if (this[X] === Y) {
                        return X
                    }
                }
                return -1
            },
            contains: function(V, W) {
                return this.indexOf(V, W) != -1
            },
            forEach: function(V, Y) {
                for (var X = 0, W = this.length; X < W; X++) {
                    if (X in this) {
                        V.call(Y, this[X], X, this)
                    }
                }
            },
            filter: function(V, aa) {
                var Z = [];
                for (var Y = 0, W = this.length; Y < W; Y++) {
                    if (Y in this) {
                        var X = this[Y];
                        if (V.call(aa, this[Y], Y, this)) {
                            Z.push(X)
                        }
                    }
                }
                return Z
            },
            map: function(V, Z) {
                var Y = [];
                for (var X = 0, W = this.length; X < W; X++) {
                    if (X in this) {
                        Y[X] = V.call(Z, this[X], X, this)
                    }
                }
                return Y
            }
        };
        L.implement(String, {
            $J_TYPE: "string",
            jTrim: function() {
                return this.replace(/^\s+|\s+$/g, "")
            },
            eq: function(V, W) {
                return (W || false) ? (this.toString() === V.toString()) : (this.toLowerCase().toString() === V.toLowerCase().toString())
            },
            jCamelize: function() {
                return this.replace(/-\D/g, function(V) {
                    return V.charAt(1).toUpperCase()
                })
            },
            dashize: function() {
                return this.replace(/[A-Z]/g, function(V) {
                    return ("-" + V.charAt(0).toLowerCase())
                })
            },
            jToInt: function(V) {
                return parseInt(this, V || 10)
            },
            toFloat: function() {
                return parseFloat(this)
            },
            jToBool: function() {
                return !this.replace(/true/i, "").jTrim()
            },
            has: function(W, V) {
                V = V || "";
                return (V + this + V).indexOf(V + W + V) > -1
            }
        });
        R.implement(Function, {
            $J_TYPE: "function",
            jBind: function() {
                var W = L.$A(arguments),
                    V = this,
                    X = W.shift();
                return function() {
                    return V.apply(X || null, W.concat(L.$A(arguments)))
                }
            },
            jBindAsEvent: function() {
                var W = L.$A(arguments),
                    V = this,
                    X = W.shift();
                return function(Y) {
                    return V.apply(X || null, L.$([Y || (L.jBrowser.ieMode ? window.event : null)]).concat(W))
                }
            },
            jDelay: function() {
                var W = L.$A(arguments),
                    V = this,
                    X = W.shift();
                return window.setTimeout(function() {
                    return V.apply(V, W)
                }, X || 0)
            },
            jDefer: function() {
                var W = L.$A(arguments),
                    V = this;
                return function() {
                    return V.jDelay.apply(V, W)
                }
            },
            interval: function() {
                var W = L.$A(arguments),
                    V = this,
                    X = W.shift();
                return window.setInterval(function() {
                    return V.apply(V, W)
                }, X || 0)
            }
        });
        var S = {},
            K = navigator.userAgent.toLowerCase(),
            J = K.match(/(webkit|gecko|trident|presto)\/(\d+\.?\d*)/i),
            O = K.match(/(edge|opr)\/(\d+\.?\d*)/i) || K.match(/(crios|chrome|safari|firefox|opera|opr)\/(\d+\.?\d*)/i),
            Q = K.match(/version\/(\d+\.?\d*)/i),
            F = document.documentElement.style;

        function G(W) {
            var V = W.charAt(0).toUpperCase() + W.slice(1);
            return W in F || ("Webkit" + V) in F || ("Moz" + V) in F || ("ms" + V) in F || ("O" + V) in F
        }
        L.jBrowser = {
            features: {
                xpath: !!(document.evaluate),
                air: !!(window.runtime),
                query: !!(document.querySelector),
                fullScreen: !!(document.fullscreenEnabled || document.msFullscreenEnabled || document.exitFullscreen || document.cancelFullScreen || document.webkitexitFullscreen || document.webkitCancelFullScreen || document.mozCancelFullScreen || document.oCancelFullScreen || document.msCancelFullScreen),
                xhr2: !!(window.ProgressEvent) && !!(window.FormData) && (window.XMLHttpRequest && "withCredentials" in new XMLHttpRequest),
                transition: G("transition"),
                transform: G("transform"),
                perspective: G("perspective"),
                animation: G("animation"),
                requestAnimationFrame: false,
                multibackground: false,
                cssFilters: false,
                svg: (function() {
                    return document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Image", "1.1")
                })()
            },
            touchScreen: function() {
                return "ontouchstart" in window || (window.DocumentTouch && document instanceof DocumentTouch)
            }(),
            mobile: K.match(/(android|bb\d+|meego).+|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(jBrowser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/) ? true : false,
            engine: (J && J[1]) ? J[1].toLowerCase() : (window.opera) ? "presto" : !!(window.ActiveXObject) ? "trident" : (undefined !== document.getBoxObjectFor || null != window.mozInnerScreenY) ? "gecko" : (null !== window.WebKitPoint || !navigator.taintEnabled) ? "webkit" : "unknown",
            version: (J && J[2]) ? parseFloat(J[2]) : 0,
            uaName: (O && O[1]) ? O[1].toLowerCase() : "",
            uaVersion: (O && O[2]) ? parseFloat(O[2]) : 0,
            cssPrefix: "",
            cssDomPrefix: "",
            domPrefix: "",
            ieMode: 0,
            platform: K.match(/ip(?:ad|od|hone)/) ? "ios" : (K.match(/(?:webos|android)/) || navigator.platform.match(/mac|win|linux/i) || ["other"])[0].toLowerCase(),
            backCompat: document.compatMode && "backcompat" == document.compatMode.toLowerCase(),
            scrollbarsWidth: 0,
            getDoc: function() {
                return (document.compatMode && "backcompat" == document.compatMode.toLowerCase()) ? document.body : document.documentElement
            },
            requestAnimationFrame: window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || undefined,
            cancelAnimationFrame: window.cancelAnimationFrame || window.mozCancelAnimationFrame || window.mozCancelAnimationFrame || window.oCancelAnimationFrame || window.msCancelAnimationFrame || window.webkitCancelRequestAnimationFrame || undefined,
            ready: false,
            onready: function() {
                if (L.jBrowser.ready) {
                    return
                }
                var Y, X;
                L.jBrowser.ready = true;
                L.body = L.$(document.body);
                L.win = L.$(window);
                try {
                    var W = L.$new("div").jSetCss({
                        width: 100,
                        height: 100,
                        overflow: "scroll",
                        position: "absolute",
                        top: -9999
                    }).jAppendTo(document.body);
                    L.jBrowser.scrollbarsWidth = W.offsetWidth - W.clientWidth;
                    W.jRemove()
                } catch (V) {}
                try {
                    Y = L.$new("div");
                    X = Y.style;
                    X.cssText = "background:url(https://),url(https://),red url(https://)";
                    L.jBrowser.features.multibackground = (/(url\s*\(.*?){3}/).test(X.background);
                    X = null;
                    Y = null
                } catch (V) {}
                if (!L.jBrowser.cssTransformProp) {
                    L.jBrowser.cssTransformProp = L.normalizeCSS("transform").dashize()
                }
                try {
                    Y = L.$new("div");
                    Y.style.cssText = L.normalizeCSS("filter").dashize() + ":blur(2px);";
                    L.jBrowser.features.cssFilters = !!Y.style.length && (!L.jBrowser.ieMode || L.jBrowser.ieMode > 9);
                    Y = null
                } catch (V) {}
                if (!L.jBrowser.features.cssFilters) {
                    L.$(document.documentElement).jAddClass("no-cssfilters-magic")
                }
                if (undefined === window.TransitionEvent && undefined !== window.WebKitTransitionEvent) {
                    S.transitionend = "webkitTransitionEnd"
                }
                L.Doc.jCallEvent.call(L.$(document), "domready")
            }
        };
        (function() {
            var Z = [],
                Y, X, W;

            function V() {
                return !!(arguments.callee.caller)
            }
            switch (L.jBrowser.engine) {
                case "trident":
                    if (!L.jBrowser.version) {
                        L.jBrowser.version = !!(window.XMLHttpRequest) ? 3 : 2
                    }
                    break;
                case "gecko":
                    L.jBrowser.version = (O && O[2]) ? parseFloat(O[2]) : 0;
                    break
            }
            L.jBrowser[L.jBrowser.engine] = true;
            if (O && "crios" === O[1]) {
                L.jBrowser.uaName = "chrome"
            }
            if (!!window.chrome) {
                L.jBrowser.chrome = true
            }
            if (O && "opr" === O[1]) {
                L.jBrowser.uaName = "opera";
                L.jBrowser.opera = true
            }
            if ("safari" === L.jBrowser.uaName && (Q && Q[1])) {
                L.jBrowser.uaVersion = parseFloat(Q[1])
            }
            if ("android" == L.jBrowser.platform && L.jBrowser.webkit && (Q && Q[1])) {
                L.jBrowser.androidBrowser = true
            }
            Y = ({
                gecko: ["-moz-", "Moz", "moz"],
                webkit: ["-webkit-", "Webkit", "webkit"],
                trident: ["-ms-", "ms", "ms"],
                presto: ["-o-", "O", "o"]
            })[L.jBrowser.engine] || ["", "", ""];
            L.jBrowser.cssPrefix = Y[0];
            L.jBrowser.cssDomPrefix = Y[1];
            L.jBrowser.domPrefix = Y[2];
            L.jBrowser.ieMode = (!L.jBrowser.trident) ? undefined : (document.documentMode) ? document.documentMode : function() {
                var aa = 0;
                if (L.jBrowser.backCompat) {
                    return 5
                }
                switch (L.jBrowser.version) {
                    case 2:
                        aa = 6;
                        break;
                    case 3:
                        aa = 7;
                        break
                }
                return aa
            }();
            Z.push(L.jBrowser.platform + "-magic");
            if (L.jBrowser.mobile) {
                Z.push("mobile-magic")
            }
            if (L.jBrowser.androidBrowser) {
                Z.push("android-jBrowser-magic")
            }
            if (L.jBrowser.ieMode) {
                L.jBrowser.uaName = "ie";
                L.jBrowser.uaVersion = L.jBrowser.ieMode;
                Z.push("ie" + L.jBrowser.ieMode + "-magic");
                for (X = 11; X > L.jBrowser.ieMode; X--) {
                    Z.push("lt-ie" + X + "-magic")
                }
            }
            if (L.jBrowser.webkit && L.jBrowser.version < 536) {
                L.jBrowser.features.fullScreen = false
            }
            if (L.jBrowser.requestAnimationFrame) {
                L.jBrowser.requestAnimationFrame.call(window, function() {
                    L.jBrowser.features.requestAnimationFrame = true
                })
            }
            if (L.jBrowser.features.svg) {
                Z.push("svg-magic")
            } else {
                Z.push("no-svg-magic")
            }
            W = (document.documentElement.className || "").match(/\S+/g) || [];
            document.documentElement.className = L.$(W).concat(Z).join(" ");
            if (L.jBrowser.ieMode && L.jBrowser.ieMode < 9) {
                document.createElement("figure");
                document.createElement("figcaption")
            }
        })();
        (function() {
            L.jBrowser.fullScreen = {
                capable: L.jBrowser.features.fullScreen,
                enabled: function() {
                    return !!(document.fullscreenElement || document[L.jBrowser.domPrefix + "FullscreenElement"] || document.fullScreen || document.webkitIsFullScreen || document[L.jBrowser.domPrefix + "FullScreen"])
                },
                request: function(V, W) {
                    W || (W = {});
                    if (this.capable) {
                        L.$(document).jAddEvent(this.changeEventName, this.onchange = function(X) {
                            if (this.enabled()) {
                                W.onEnter && W.onEnter()
                            } else {
                                L.$(document).jRemoveEvent(this.changeEventName, this.onchange);
                                W.onExit && W.onExit()
                            }
                        }.jBindAsEvent(this));
                        L.$(document).jAddEvent(this.errorEventName, this.onerror = function(X) {
                            W.fallback && W.fallback();
                            L.$(document).jRemoveEvent(this.errorEventName, this.onerror)
                        }.jBindAsEvent(this));
                        (V[L.jBrowser.domPrefix + "RequestFullscreen"] || V[L.jBrowser.domPrefix + "RequestFullScreen"] || V.requestFullscreen || function() {}).call(V)
                    } else {
                        if (W.fallback) {
                            W.fallback()
                        }
                    }
                },
                cancel: (document.exitFullscreen || document.cancelFullScreen || document[L.jBrowser.domPrefix + "ExitFullscreen"] || document[L.jBrowser.domPrefix + "CancelFullScreen"] || function() {}).jBind(document),
                changeEventName: document.msExitFullscreen ? "MSFullscreenChange" : (document.exitFullscreen ? "" : L.jBrowser.domPrefix) + "fullscreenchange",
                errorEventName: document.msExitFullscreen ? "MSFullscreenError" : (document.exitFullscreen ? "" : L.jBrowser.domPrefix) + "fullscreenerror",
                prefix: L.jBrowser.domPrefix,
                activeElement: null
            }
        })();
        var U = /\S+/g,
            I = /^(border(Top|Bottom|Left|Right)Width)|((padding|margin)(Top|Bottom|Left|Right))$/,
            N = {
                "float": ("undefined" === typeof(F.styleFloat)) ? "cssFloat" : "styleFloat"
            },
            P = {
                fontWeight: true,
                lineHeight: true,
                opacity: true,
                zIndex: true,
                zoom: true
            },
            H = (window.getComputedStyle) ? function(X, V) {
                var W = window.getComputedStyle(X, null);
                return W ? W.getPropertyValue(V) || W[V] : null
            } : function(Y, W) {
                var X = Y.currentStyle,
                    V = null;
                V = X ? X[W] : null;
                if (null == V && Y.style && Y.style[W]) {
                    V = Y.style[W]
                }
                return V
            };

        function T(X) {
            var V, W;
            W = (L.jBrowser.webkit && "filter" == X) ? false : (X in F);
            if (!W) {
                V = L.jBrowser.cssDomPrefix + X.charAt(0).toUpperCase() + X.slice(1);
                if (V in F) {
                    return V
                }
            }
            return X
        }
        L.normalizeCSS = T;
        L.Element = {
            jHasClass: function(V) {
                return !(V || "").has(" ") && (this.className || "").has(V, " ")
            },
            jAddClass: function(Z) {
                var W = (this.className || "").match(U) || [],
                    Y = (Z || "").match(U) || [],
                    V = Y.length,
                    X = 0;
                for (; X < V; X++) {
                    if (!L.$(W).contains(Y[X])) {
                        W.push(Y[X])
                    }
                }
                this.className = W.join(" ");
                return this
            },
            jRemoveClass: function(aa) {
                var W = (this.className || "").match(U) || [],
                    Z = (aa || "").match(U) || [],
                    V = Z.length,
                    Y = 0,
                    X;
                for (; Y < V; Y++) {
                    if ((X = L.$(W).indexOf(Z[Y])) > -1) {
                        W.splice(X, 1)
                    }
                }
                this.className = aa ? W.join(" ") : "";
                return this
            },
            jToggleClass: function(V) {
                return this.jHasClass(V) ? this.jRemoveClass(V) : this.jAddClass(V)
            },
            jGetCss: function(W) {
                var X = W.jCamelize(),
                    V = null;
                W = N[X] || (N[X] = T(X));
                V = H(this, W);
                if ("auto" === V) {
                    V = null
                }
                if (null !== V) {
                    if ("opacity" == W) {
                        return L.defined(V) ? parseFloat(V) : 1
                    }
                    if (I.test(W)) {
                        V = parseInt(V, 10) ? V : "0px"
                    }
                }
                return V
            },
            jSetCssProp: function(W, V) {
                var Y = W.jCamelize();
                try {
                    if ("opacity" == W) {
                        this.jSetOpacity(V);
                        return this
                    }
                    W = N[Y] || (N[Y] = T(Y));
                    this.style[W] = V + (("number" == L.jTypeOf(V) && !P[Y]) ? "px" : "")
                } catch (X) {}
                return this
            },
            jSetCss: function(W) {
                for (var V in W) {
                    this.jSetCssProp(V, W[V])
                }
                return this
            },
            jGetStyles: function() {
                var V = {};
                L.$A(arguments).jEach(function(W) {
                    V[W] = this.jGetCss(W)
                }, this);
                return V
            },
            jSetOpacity: function(X, V) {
                var W;
                V = V || false;
                this.style.opacity = X;
                X = parseInt(parseFloat(X) * 100);
                if (V) {
                    if (0 === X) {
                        if ("hidden" != this.style.visibility) {
                            this.style.visibility = "hidden"
                        }
                    } else {
                        if ("visible" != this.style.visibility) {
                            this.style.visibility = "visible"
                        }
                    }
                }
                if (L.jBrowser.ieMode && L.jBrowser.ieMode < 9) {
                    if (!isNaN(X)) {
                        if (!~this.style.filter.indexOf("Alpha")) {
                            this.style.filter += " progid:DXImageTransform.Microsoft.Alpha(Opacity=" + X + ")"
                        } else {
                            this.style.filter = this.style.filter.replace(/Opacity=\d*/i, "Opacity=" + X)
                        }
                    } else {
                        this.style.filter = this.style.filter.replace(/progid:DXImageTransform.Microsoft.Alpha\(Opacity=\d*\)/i, "").jTrim();
                        if ("" === this.style.filter) {
                            this.style.removeAttribute("filter")
                        }
                    }
                }
                return this
            },
            setProps: function(V) {
                for (var W in V) {
                    if ("class" === W) {
                        this.jAddClass("" + V[W])
                    } else {
                        this.setAttribute(W, "" + V[W])
                    }
                }
                return this
            },
            hide: function() {
                return this.jSetCss({
                    display: "none",
                    visibility: "hidden"
                })
            },
            show: function() {
                return this.jSetCss({
                    display: "",
                    visibility: "visible"
                })
            },
            jGetSize: function() {
                return {
                    width: this.offsetWidth,
                    height: this.offsetHeight
                }
            },
            getInnerSize: function(W) {
                var V = this.jGetSize();
                V.width -= (parseFloat(this.jGetCss("border-left-width") || 0) + parseFloat(this.jGetCss("border-right-width") || 0));
                V.height -= (parseFloat(this.jGetCss("border-top-width") || 0) + parseFloat(this.jGetCss("border-bottom-width") || 0));
                if (!W) {
                    V.width -= (parseFloat(this.jGetCss("padding-left") || 0) + parseFloat(this.jGetCss("padding-right") || 0));
                    V.height -= (parseFloat(this.jGetCss("padding-top") || 0) + parseFloat(this.jGetCss("padding-bottom") || 0))
                }
                return V
            },
            jGetScroll: function() {
                return {
                    top: this.scrollTop,
                    left: this.scrollLeft
                }
            },
            jGetFullScroll: function() {
                var V = this,
                    W = {
                        top: 0,
                        left: 0
                    };
                do {
                    W.left += V.scrollLeft || 0;
                    W.top += V.scrollTop || 0;
                    V = V.parentNode
                } while (V);
                return W
            },
            jGetPosition: function() {
                var Z = this,
                    W = 0,
                    Y = 0;
                if (L.defined(document.documentElement.getBoundingClientRect)) {
                    var V = this.getBoundingClientRect(),
                        X = L.$(document).jGetScroll(),
                        aa = L.jBrowser.getDoc();
                    return {
                        top: V.top + X.y - aa.clientTop,
                        left: V.left + X.x - aa.clientLeft
                    }
                }
                do {
                    W += Z.offsetLeft || 0;
                    Y += Z.offsetTop || 0;
                    Z = Z.offsetParent
                } while (Z && !(/^(?:body|html)$/i).test(Z.tagName));
                return {
                    top: Y,
                    left: W
                }
            },
            jGetRect: function() {
                var W = this.jGetPosition();
                var V = this.jGetSize();
                return {
                    top: W.top,
                    bottom: W.top + V.height,
                    left: W.left,
                    right: W.left + V.width
                }
            },
            changeContent: function(W) {
                try {
                    this.innerHTML = W
                } catch (V) {
                    this.innerText = W
                }
                return this
            },
            jRemove: function() {
                return (this.parentNode) ? this.parentNode.removeChild(this) : this
            },
            kill: function() {
                L.$A(this.childNodes).jEach(function(V) {
                    if (3 == V.nodeType || 8 == V.nodeType) {
                        return
                    }
                    L.$(V).kill()
                });
                this.jRemove();
                this.jClearEvents();
                if (this.$J_UUID) {
                    L.storage[this.$J_UUID] = null;
                    delete L.storage[this.$J_UUID]
                }
                return null
            },
            append: function(X, W) {
                W = W || "bottom";
                var V = this.firstChild;
                ("top" == W && V) ? this.insertBefore(X, V): this.appendChild(X);
                return this
            },
            jAppendTo: function(X, W) {
                var V = L.$(X).append(this, W);
                return this
            },
            enclose: function(V) {
                this.append(V.parentNode.replaceChild(this, V));
                return this
            },
            hasChild: function(V) {
                if ("element" !== L.jTypeOf("string" == L.jTypeOf(V) ? V = document.getElementById(V) : V)) {
                    return false
                }
                return (this == V) ? false : (this.contains && !(L.jBrowser.webkit419)) ? (this.contains(V)) : (this.compareDocumentPosition) ? !!(this.compareDocumentPosition(V) & 16) : L.$A(this.byTag(V.tagName)).contains(V)
            }
        };
        L.Element.jGetStyle = L.Element.jGetCss;
        L.Element.jSetStyle = L.Element.jSetCss;
        if (!window.Element) {
            window.Element = L.$F;
            if (L.jBrowser.engine.webkit) {
                window.document.createElement("iframe")
            }
            window.Element.prototype = (L.jBrowser.engine.webkit) ? window["[[DOMElement.prototype]]"] : {}
        }
        L.implement(window.Element, {
            $J_TYPE: "element"
        });
        L.Doc = {
            jGetSize: function() {
                if (L.jBrowser.touchScreen || L.jBrowser.presto925 || L.jBrowser.webkit419) {
                    return {
                        width: window.innerWidth,
                        height: window.innerHeight
                    }
                }
                return {
                    width: L.jBrowser.getDoc().clientWidth,
                    height: L.jBrowser.getDoc().clientHeight
                }
            },
            jGetScroll: function() {
                return {
                    x: window.pageXOffset || L.jBrowser.getDoc().scrollLeft,
                    y: window.pageYOffset || L.jBrowser.getDoc().scrollTop
                }
            },
            jGetFullSize: function() {
                var V = this.jGetSize();
                return {
                    width: Math.max(L.jBrowser.getDoc().scrollWidth, V.width),
                    height: Math.max(L.jBrowser.getDoc().scrollHeight, V.height)
                }
            }
        };
        L.extend(document, {
            $J_TYPE: "document"
        });
        L.extend(window, {
            $J_TYPE: "window"
        });
        L.extend([L.Element, L.Doc], {
            jFetch: function(Y, W) {
                var V = L.getStorage(this.$J_UUID),
                    X = V[Y];
                if (undefined !== W && undefined === X) {
                    X = V[Y] = W
                }
                return (L.defined(X) ? X : null)
            },
            jStore: function(X, W) {
                var V = L.getStorage(this.$J_UUID);
                V[X] = W;
                return this
            },
            jDel: function(W) {
                var V = L.getStorage(this.$J_UUID);
                delete V[W];
                return this
            }
        });
        if (!(window.HTMLElement && window.HTMLElement.prototype && window.HTMLElement.prototype.getElementsByClassName)) {
            L.extend([L.Element, L.Doc], {
                getElementsByClassName: function(V) {
                    return L.$A(this.getElementsByTagName("*")).filter(function(X) {
                        try {
                            return (1 == X.nodeType && X.className.has(V, " "))
                        } catch (W) {}
                    })
                }
            })
        }
        L.extend([L.Element, L.Doc], {
            byClass: function() {
                return this.getElementsByClassName(arguments[0])
            },
            byTag: function() {
                return this.getElementsByTagName(arguments[0])
            }
        });
        if (L.jBrowser.fullScreen.capable && !document.requestFullScreen) {
            L.Element.requestFullScreen = function() {
                L.jBrowser.fullScreen.request(this)
            }
        }
        L.Event = {
            $J_TYPE: "event",
            isQueueStopped: L.$false,
            stop: function() {
                return this.stopDistribution().stopDefaults()
            },
            stopDistribution: function() {
                if (this.stopPropagation) {
                    this.stopPropagation()
                } else {
                    this.cancelBubble = true
                }
                return this
            },
            stopDefaults: function() {
                if (this.preventDefault) {
                    this.preventDefault()
                } else {
                    this.returnValue = false
                }
                return this
            },
            stopQueue: function() {
                this.isQueueStopped = L.$true;
                return this
            },
            getClientXY: function() {
                var W, V;
                W = ((/touch/i).test(this.type)) ? this.changedTouches[0] : this;
                return (!L.defined(W)) ? {
                    x: 0,
                    y: 0
                } : {
                    x: W.clientX,
                    y: W.clientY
                }
            },
            jGetPageXY: function() {
                var W, V;
                W = ((/touch/i).test(this.type)) ? this.changedTouches[0] : this;
                return (!L.defined(W)) ? {
                    x: 0,
                    y: 0
                } : {
                    x: W.pageX || W.clientX + L.jBrowser.getDoc().scrollLeft,
                    y: W.pageY || W.clientY + L.jBrowser.getDoc().scrollTop
                }
            },
            getTarget: function() {
                var V = this.target || this.srcElement;
                while (V && 3 == V.nodeType) {
                    V = V.parentNode
                }
                return V
            },
            getRelated: function() {
                var W = null;
                switch (this.type) {
                    case "mouseover":
                    case "pointerover":
                    case "MSPointerOver":
                        W = this.relatedTarget || this.fromElement;
                        break;
                    case "mouseout":
                    case "pointerout":
                    case "MSPointerOut":
                        W = this.relatedTarget || this.toElement;
                        break;
                    default:
                        return W
                }
                try {
                    while (W && 3 == W.nodeType) {
                        W = W.parentNode
                    }
                } catch (V) {
                    W = null
                }
                return W
            },
            getButton: function() {
                if (!this.which && this.button !== undefined) {
                    return (this.button & 1 ? 1 : (this.button & 2 ? 3 : (this.button & 4 ? 2 : 0)))
                }
                return this.which
            },
            isTouchEvent: function() {
                return (this.pointerType && ("touch" === this.pointerType || this.pointerType === this.MSPOINTER_TYPE_TOUCH)) || (/touch/i).test(this.type)
            },
            isPrimaryTouch: function() {
                return this.pointerType ? (("touch" === this.pointerType || this.MSPOINTER_TYPE_TOUCH === this.pointerType) && this.isPrimary) : 1 === this.changedTouches.length && (this.targetTouches.length ? this.targetTouches[0].identifier == this.changedTouches[0].identifier : true)
            }
        };
        L._event_add_ = "addEventListener";
        L._event_del_ = "removeEventListener";
        L._event_prefix_ = "";
        if (!document.addEventListener) {
            L._event_add_ = "attachEvent";
            L._event_del_ = "detachEvent";
            L._event_prefix_ = "on"
        }
        L.Event.Custom = {
            type: "",
            x: null,
            y: null,
            timeStamp: null,
            button: null,
            target: null,
            relatedTarget: null,
            $J_TYPE: "event.custom",
            isQueueStopped: L.$false,
            events: L.$([]),
            pushToEvents: function(V) {
                var W = V;
                this.events.push(W)
            },
            stop: function() {
                return this.stopDistribution().stopDefaults()
            },
            stopDistribution: function() {
                this.events.jEach(function(W) {
                    try {
                        W.stopDistribution()
                    } catch (V) {}
                });
                return this
            },
            stopDefaults: function() {
                this.events.jEach(function(W) {
                    try {
                        W.stopDefaults()
                    } catch (V) {}
                });
                return this
            },
            stopQueue: function() {
                this.isQueueStopped = L.$true;
                return this
            },
            getClientXY: function() {
                return {
                    x: this.clientX,
                    y: this.clientY
                }
            },
            jGetPageXY: function() {
                return {
                    x: this.x,
                    y: this.y
                }
            },
            getTarget: function() {
                return this.target
            },
            getRelated: function() {
                return this.relatedTarget
            },
            getButton: function() {
                return this.button
            },
            getOriginalTarget: function() {
                return this.events.length > 0 ? this.events[0].getTarget() : undefined
            }
        };
        L.extend([L.Element, L.Doc], {
            jAddEvent: function(X, Z, aa, ad) {
                var ac, V, Y, ab, W;
                if ("string" == L.jTypeOf(X)) {
                    W = X.split(" ");
                    if (W.length > 1) {
                        X = W
                    }
                }
                if (L.jTypeOf(X) == "array") {
                    L.$(X).jEach(this.jAddEvent.jBindAsEvent(this, Z, aa, ad));
                    return this
                }
                if (!X || !Z || L.jTypeOf(X) != "string" || L.jTypeOf(Z) != "function") {
                    return this
                }
                if (X == "domready" && L.jBrowser.ready) {
                    Z.call(this);
                    return this
                }
                X = S[X] || X;
                aa = parseInt(aa || 50);
                if (!Z.$J_EUID) {
                    Z.$J_EUID = Math.floor(Math.random() * L.now())
                }
                ac = L.Doc.jFetch.call(this, "_EVENTS_", {});
                V = ac[X];
                if (!V) {
                    ac[X] = V = L.$([]);
                    Y = this;
                    if (L.Event.Custom[X]) {
                        L.Event.Custom[X].handler.add.call(this, ad)
                    } else {
                        V.handle = function(ae) {
                            ae = L.extend(ae || window.e, {
                                $J_TYPE: "event"
                            });
                            L.Doc.jCallEvent.call(Y, X, L.$(ae))
                        };
                        this[L._event_add_](L._event_prefix_ + X, V.handle, false)
                    }
                }
                ab = {
                    type: X,
                    fn: Z,
                    priority: aa,
                    euid: Z.$J_EUID
                };
                V.push(ab);
                V.sort(function(af, ae) {
                    return af.priority - ae.priority
                });
                return this
            },
            jRemoveEvent: function(ab) {
                var Z = L.Doc.jFetch.call(this, "_EVENTS_", {}),
                    X, V, W, ac, aa, Y;
                aa = arguments.length > 1 ? arguments[1] : -100;
                if ("string" == L.jTypeOf(ab)) {
                    Y = ab.split(" ");
                    if (Y.length > 1) {
                        ab = Y
                    }
                }
                if (L.jTypeOf(ab) == "array") {
                    L.$(ab).jEach(this.jRemoveEvent.jBindAsEvent(this, aa));
                    return this
                }
                ab = S[ab] || ab;
                if (!ab || L.jTypeOf(ab) != "string" || !Z || !Z[ab]) {
                    return this
                }
                X = Z[ab] || [];
                for (W = 0; W < X.length; W++) {
                    V = X[W];
                    if (-100 == aa || !!aa && aa.$J_EUID === V.euid) {
                        ac = X.splice(W--, 1)
                    }
                }
                if (0 === X.length) {
                    if (L.Event.Custom[ab]) {
                        L.Event.Custom[ab].handler.jRemove.call(this)
                    } else {
                        this[L._event_del_](L._event_prefix_ + ab, X.handle, false)
                    }
                    delete Z[ab]
                }
                return this
            },
            jCallEvent: function(Z, ab) {
                var Y = L.Doc.jFetch.call(this, "_EVENTS_", {}),
                    X, V, W;
                Z = S[Z] || Z;
                if (!Z || L.jTypeOf(Z) != "string" || !Y || !Y[Z]) {
                    return this
                }
                try {
                    ab = L.extend(ab || {}, {
                        type: Z
                    })
                } catch (aa) {}
                if (undefined === ab.timeStamp) {
                    ab.timeStamp = L.now()
                }
                X = Y[Z] || [];
                for (W = 0; W < X.length && !(ab.isQueueStopped && ab.isQueueStopped()); W++) {
                    X[W].fn.call(this, ab)
                }
            },
            jRaiseEvent: function(W, V) {
                var Z = ("domready" == W) ? false : true,
                    Y = this,
                    X;
                W = S[W] || W;
                if (!Z) {
                    L.Doc.jCallEvent.call(this, W);
                    return this
                }
                if (Y === document && document.createEvent && !Y.dispatchEvent) {
                    Y = document.documentElement
                }
                if (document.createEvent) {
                    X = document.createEvent(W);
                    X.initEvent(V, true, true)
                } else {
                    X = document.createEventObject();
                    X.eventType = W
                }
                if (document.createEvent) {
                    Y.dispatchEvent(X)
                } else {
                    Y.fireEvent("on" + V, X)
                }
                return X
            },
            jClearEvents: function() {
                var W = L.Doc.jFetch.call(this, "_EVENTS_");
                if (!W) {
                    return this
                }
                for (var V in W) {
                    L.Doc.jRemoveEvent.call(this, V)
                }
                L.Doc.jDel.call(this, "_EVENTS_");
                return this
            }
        });
        (function(V) {
            if ("complete" === document.readyState) {
                return V.jBrowser.onready.jDelay(1)
            }
            if (V.jBrowser.webkit && V.jBrowser.version < 420) {
                (function() {
                    (V.$(["loaded", "complete"]).contains(document.readyState)) ? V.jBrowser.onready(): arguments.callee.jDelay(50)
                })()
            } else {
                if (V.jBrowser.trident && V.jBrowser.ieMode < 9 && window == top) {
                    (function() {
                        (V.$try(function() {
                            V.jBrowser.getDoc().doScroll("left");
                            return true
                        })) ? V.jBrowser.onready(): arguments.callee.jDelay(50)
                    })()
                } else {
                    V.Doc.jAddEvent.call(V.$(document), "DOMContentLoaded", V.jBrowser.onready);
                    V.Doc.jAddEvent.call(V.$(window), "load", V.jBrowser.onready)
                }
            }
        })(R);
        L.Class = function() {
            var Z = null,
                W = L.$A(arguments);
            if ("class" == L.jTypeOf(W[0])) {
                Z = W.shift()
            }
            var V = function() {
                for (var ac in this) {
                    this[ac] = L.detach(this[ac])
                }
                if (this.constructor.$parent) {
                    this.$parent = {};
                    var ae = this.constructor.$parent;
                    for (var ad in ae) {
                        var ab = ae[ad];
                        switch (L.jTypeOf(ab)) {
                            case "function":
                                this.$parent[ad] = L.Class.wrap(this, ab);
                                break;
                            case "object":
                                this.$parent[ad] = L.detach(ab);
                                break;
                            case "array":
                                this.$parent[ad] = L.detach(ab);
                                break
                        }
                    }
                }
                var aa = (this.init) ? this.init.apply(this, arguments) : this;
                delete this.caller;
                return aa
            };
            if (!V.prototype.init) {
                V.prototype.init = L.$F
            }
            if (Z) {
                var Y = function() {};
                Y.prototype = Z.prototype;
                V.prototype = new Y;
                V.$parent = {};
                for (var X in Z.prototype) {
                    V.$parent[X] = Z.prototype[X]
                }
            } else {
                V.$parent = null
            }
            V.constructor = L.Class;
            V.prototype.constructor = V;
            L.extend(V.prototype, W[0]);
            L.extend(V, {
                $J_TYPE: "class"
            });
            return V
        };
        R.Class.wrap = function(V, W) {
            return function() {
                var Y = this.caller;
                var X = W.apply(V, arguments);
                return X
            }
        };
        (function(Y) {
            var X = Y.$;
            var V = 5,
                W = 300;
            Y.Event.Custom.btnclick = new Y.Class(Y.extend(Y.Event.Custom, {
                type: "btnclick",
                init: function(ab, aa) {
                    var Z = aa.jGetPageXY();
                    this.x = Z.x;
                    this.y = Z.y;
                    this.clientX = aa.clientX;
                    this.clientY = aa.clientY;
                    this.timeStamp = aa.timeStamp;
                    this.button = aa.getButton();
                    this.target = ab;
                    this.pushToEvents(aa)
                }
            }));
            Y.Event.Custom.btnclick.handler = {
                options: {
                    threshold: W,
                    button: 1
                },
                add: function(Z) {
                    this.jStore("event:btnclick:options", Y.extend(Y.detach(Y.Event.Custom.btnclick.handler.options), Z || {}));
                    this.jAddEvent("mousedown", Y.Event.Custom.btnclick.handler.handle, 1);
                    this.jAddEvent("mouseup", Y.Event.Custom.btnclick.handler.handle, 1);
                    this.jAddEvent("click", Y.Event.Custom.btnclick.handler.onclick, 1);
                    if (Y.jBrowser.trident && Y.jBrowser.ieMode < 9) {
                        this.jAddEvent("dblclick", Y.Event.Custom.btnclick.handler.handle, 1)
                    }
                },
                jRemove: function() {
                    this.jRemoveEvent("mousedown", Y.Event.Custom.btnclick.handler.handle);
                    this.jRemoveEvent("mouseup", Y.Event.Custom.btnclick.handler.handle);
                    this.jRemoveEvent("click", Y.Event.Custom.btnclick.handler.onclick);
                    if (Y.jBrowser.trident && Y.jBrowser.ieMode < 9) {
                        this.jRemoveEvent("dblclick", Y.Event.Custom.btnclick.handler.handle)
                    }
                },
                onclick: function(Z) {
                    Z.stopDefaults()
                },
                handle: function(ac) {
                    var ab, Z, aa;
                    Z = this.jFetch("event:btnclick:options");
                    if (ac.type != "dblclick" && ac.getButton() != Z.button) {
                        return
                    }
                    if (this.jFetch("event:btnclick:ignore")) {
                        this.jDel("event:btnclick:ignore");
                        return
                    }
                    if ("mousedown" == ac.type) {
                        ab = new Y.Event.Custom.btnclick(this, ac);
                        this.jStore("event:btnclick:btnclickEvent", ab)
                    } else {
                        if ("mouseup" == ac.type) {
                            ab = this.jFetch("event:btnclick:btnclickEvent");
                            if (!ab) {
                                return
                            }
                            aa = ac.jGetPageXY();
                            this.jDel("event:btnclick:btnclickEvent");
                            ab.pushToEvents(ac);
                            if (ac.timeStamp - ab.timeStamp <= Z.threshold && Math.sqrt(Math.pow(aa.x - ab.x, 2) + Math.pow(aa.y - ab.y, 2)) <= V) {
                                this.jCallEvent("btnclick", ab)
                            }
                            document.jCallEvent("mouseup", ac)
                        } else {
                            if (ac.type == "dblclick") {
                                ab = new Y.Event.Custom.btnclick(this, ac);
                                this.jCallEvent("btnclick", ab)
                            }
                        }
                    }
                }
            }
        })(R);
        (function(W) {
            var V = W.$;
            W.Event.Custom.mousedrag = new W.Class(W.extend(W.Event.Custom, {
                type: "mousedrag",
                state: "dragstart",
                dragged: false,
                init: function(aa, Z, Y) {
                    var X = Z.jGetPageXY();
                    this.x = X.x;
                    this.y = X.y;
                    this.clientX = Z.clientX;
                    this.clientY = Z.clientY;
                    this.timeStamp = Z.timeStamp;
                    this.button = Z.getButton();
                    this.target = aa;
                    this.pushToEvents(Z);
                    this.state = Y
                }
            }));
            W.Event.Custom.mousedrag.handler = {
                add: function() {
                    var Y = W.Event.Custom.mousedrag.handler.handleMouseMove.jBindAsEvent(this),
                        X = W.Event.Custom.mousedrag.handler.handleMouseUp.jBindAsEvent(this);
                    this.jAddEvent("mousedown", W.Event.Custom.mousedrag.handler.handleMouseDown, 1);
                    this.jAddEvent("mouseup", W.Event.Custom.mousedrag.handler.handleMouseUp, 1);
                    document.jAddEvent("mousemove", Y, 1);
                    document.jAddEvent("mouseup", X, 1);
                    this.jStore("event:mousedrag:listeners:document:move", Y);
                    this.jStore("event:mousedrag:listeners:document:end", X)
                },
                jRemove: function() {
                    this.jRemoveEvent("mousedown", W.Event.Custom.mousedrag.handler.handleMouseDown);
                    this.jRemoveEvent("mouseup", W.Event.Custom.mousedrag.handler.handleMouseUp);
                    V(document).jRemoveEvent("mousemove", this.jFetch("event:mousedrag:listeners:document:move") || W.$F);
                    V(document).jRemoveEvent("mouseup", this.jFetch("event:mousedrag:listeners:document:end") || W.$F);
                    this.jDel("event:mousedrag:listeners:document:move");
                    this.jDel("event:mousedrag:listeners:document:end")
                },
                handleMouseDown: function(Y) {
                    var X;
                    if (1 != Y.getButton()) {
                        return
                    }
                    Y.stopDefaults();
                    X = new W.Event.Custom.mousedrag(this, Y, "dragstart");
                    this.jStore("event:mousedrag:dragstart", X)
                },
                handleMouseUp: function(Y) {
                    var X;
                    X = this.jFetch("event:mousedrag:dragstart");
                    if (!X) {
                        return
                    }
                    Y.stopDefaults();
                    X = new W.Event.Custom.mousedrag(this, Y, "dragend");
                    this.jDel("event:mousedrag:dragstart");
                    this.jCallEvent("mousedrag", X)
                },
                handleMouseMove: function(Y) {
                    var X;
                    X = this.jFetch("event:mousedrag:dragstart");
                    if (!X) {
                        return
                    }
                    Y.stopDefaults();
                    if (!X.dragged) {
                        X.dragged = true;
                        this.jCallEvent("mousedrag", X)
                    }
                    X = new W.Event.Custom.mousedrag(this, Y, "dragmove");
                    this.jCallEvent("mousedrag", X)
                }
            }
        })(R);
        (function(W) {
            var V = W.$;
            W.Event.Custom.dblbtnclick = new W.Class(W.extend(W.Event.Custom, {
                type: "dblbtnclick",
                timedout: false,
                tm: null,
                init: function(Z, Y) {
                    var X = Y.jGetPageXY();
                    this.x = X.x;
                    this.y = X.y;
                    this.clientX = Y.clientX;
                    this.clientY = Y.clientY;
                    this.timeStamp = Y.timeStamp;
                    this.button = Y.getButton();
                    this.target = Z;
                    this.pushToEvents(Y)
                }
            }));
            W.Event.Custom.dblbtnclick.handler = {
                options: {
                    threshold: 200
                },
                add: function(X) {
                    this.jStore("event:dblbtnclick:options", W.extend(W.detach(W.Event.Custom.dblbtnclick.handler.options), X || {}));
                    this.jAddEvent("btnclick", W.Event.Custom.dblbtnclick.handler.handle, 1)
                },
                jRemove: function() {
                    this.jRemoveEvent("btnclick", W.Event.Custom.dblbtnclick.handler.handle)
                },
                handle: function(Z) {
                    var Y, X;
                    Y = this.jFetch("event:dblbtnclick:event");
                    X = this.jFetch("event:dblbtnclick:options");
                    if (!Y) {
                        Y = new W.Event.Custom.dblbtnclick(this, Z);
                        Y.tm = setTimeout(function() {
                            Y.timedout = true;
                            Z.isQueueStopped = W.$false;
                            this.jCallEvent("btnclick", Z);
                            this.jDel("event:dblbtnclick:event")
                        }.jBind(this), X.threshold + 10);
                        this.jStore("event:dblbtnclick:event", Y);
                        Z.stopQueue()
                    } else {
                        clearTimeout(Y.tm);
                        this.jDel("event:dblbtnclick:event");
                        if (!Y.timedout) {
                            Y.pushToEvents(Z);
                            Z.stopQueue().stop();
                            this.jCallEvent("dblbtnclick", Y)
                        } else {}
                    }
                }
            }
        })(R);
        (function(ab) {
            var aa = ab.$;

            function V(ac) {
                return ac.pointerType ? (("touch" === ac.pointerType || ac.MSPOINTER_TYPE_TOUCH === ac.pointerType) && ac.isPrimary) : 1 === ac.changedTouches.length && (ac.targetTouches.length ? ac.targetTouches[0].identifier == ac.changedTouches[0].identifier : true)
            }

            function X(ac) {
                if (ac.pointerType) {
                    return ("touch" === ac.pointerType || ac.MSPOINTER_TYPE_TOUCH === ac.pointerType) ? ac.pointerId : null
                } else {
                    return ac.changedTouches[0].identifier
                }
            }

            function Y(ac) {
                if (ac.pointerType) {
                    return ("touch" === ac.pointerType || ac.MSPOINTER_TYPE_TOUCH === ac.pointerType) ? ac : null
                } else {
                    return ac.changedTouches[0]
                }
            }
            ab.Event.Custom.tap = new ab.Class(ab.extend(ab.Event.Custom, {
                type: "tap",
                id: null,
                init: function(ad, ac) {
                    var ae = Y(ac);
                    this.id = ae.pointerId || ae.identifier;
                    this.x = ae.pageX;
                    this.y = ae.pageY;
                    this.pageX = ae.pageX;
                    this.pageY = ae.pageY;
                    this.clientX = ae.clientX;
                    this.clientY = ae.clientY;
                    this.timeStamp = ac.timeStamp;
                    this.button = 0;
                    this.target = ad;
                    this.pushToEvents(ac)
                }
            }));
            var W = 10,
                Z = 200;
            ab.Event.Custom.tap.handler = {
                add: function(ac) {
                    this.jAddEvent(["touchstart", window.navigator.pointerEnabled ? "pointerdown" : "MSPointerDown"], ab.Event.Custom.tap.handler.onTouchStart, 1);
                    this.jAddEvent(["touchend", window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp"], ab.Event.Custom.tap.handler.onTouchEnd, 1);
                    this.jAddEvent("click", ab.Event.Custom.tap.handler.onClick, 1)
                },
                jRemove: function() {
                    this.jRemoveEvent(["touchstart", window.navigator.pointerEnabled ? "pointerdown" : "MSPointerDown"], ab.Event.Custom.tap.handler.onTouchStart);
                    this.jRemoveEvent(["touchend", window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp"], ab.Event.Custom.tap.handler.onTouchEnd);
                    this.jRemoveEvent("click", ab.Event.Custom.tap.handler.onClick)
                },
                onClick: function(ac) {
                    ac.stopDefaults()
                },
                onTouchStart: function(ac) {
                    if (!V(ac)) {
                        this.jDel("event:tap:event");
                        return
                    }
                    this.jStore("event:tap:event", new ab.Event.Custom.tap(this, ac));
                    this.jStore("event:btnclick:ignore", true)
                },
                onTouchEnd: function(af) {
                    var ad = ab.now(),
                        ae = this.jFetch("event:tap:event"),
                        ac = this.jFetch("event:tap:options");
                    if (!ae || !V(af)) {
                        return
                    }
                    this.jDel("event:tap:event");
                    if (ae.id == X(af) && af.timeStamp - ae.timeStamp <= Z && Math.sqrt(Math.pow(Y(af).pageX - ae.x, 2) + Math.pow(Y(af).pageY - ae.y, 2)) <= W) {
                        this.jDel("event:btnclick:btnclickEvent");
                        af.stop();
                        ae.pushToEvents(af);
                        this.jCallEvent("tap", ae)
                    }
                }
            }
        })(R);
        L.Event.Custom.dbltap = new L.Class(L.extend(L.Event.Custom, {
            type: "dbltap",
            timedout: false,
            tm: null,
            init: function(W, V) {
                this.x = V.x;
                this.y = V.y;
                this.clientX = V.clientX;
                this.clientY = V.clientY;
                this.timeStamp = V.timeStamp;
                this.button = 0;
                this.target = W;
                this.pushToEvents(V)
            }
        }));
        L.Event.Custom.dbltap.handler = {
            options: {
                threshold: 300
            },
            add: function(V) {
                this.jStore("event:dbltap:options", L.extend(L.detach(L.Event.Custom.dbltap.handler.options), V || {}));
                this.jAddEvent("tap", L.Event.Custom.dbltap.handler.handle, 1)
            },
            jRemove: function() {
                this.jRemoveEvent("tap", L.Event.Custom.dbltap.handler.handle)
            },
            handle: function(X) {
                var W, V;
                W = this.jFetch("event:dbltap:event");
                V = this.jFetch("event:dbltap:options");
                if (!W) {
                    W = new L.Event.Custom.dbltap(this, X);
                    W.tm = setTimeout(function() {
                        W.timedout = true;
                        X.isQueueStopped = L.$false;
                        this.jCallEvent("tap", X)
                    }.jBind(this), V.threshold + 10);
                    this.jStore("event:dbltap:event", W);
                    X.stopQueue()
                } else {
                    clearTimeout(W.tm);
                    this.jDel("event:dbltap:event");
                    if (!W.timedout) {
                        W.pushToEvents(X);
                        X.stopQueue().stop();
                        this.jCallEvent("dbltap", W)
                    } else {}
                }
            }
        };
        (function(aa) {
            var Z = aa.$;

            function V(ab) {
                return ab.pointerType ? (("touch" === ab.pointerType || ab.MSPOINTER_TYPE_TOUCH === ab.pointerType) && ab.isPrimary) : 1 === ab.changedTouches.length && (ab.targetTouches.length ? ab.targetTouches[0].identifier == ab.changedTouches[0].identifier : true)
            }

            function X(ab) {
                if (ab.pointerType) {
                    return ("touch" === ab.pointerType || ab.MSPOINTER_TYPE_TOUCH === ab.pointerType) ? ab.pointerId : null
                } else {
                    return ab.changedTouches[0].identifier
                }
            }

            function Y(ab) {
                if (ab.pointerType) {
                    return ("touch" === ab.pointerType || ab.MSPOINTER_TYPE_TOUCH === ab.pointerType) ? ab : null
                } else {
                    return ab.changedTouches[0]
                }
            }
            var W = 10;
            aa.Event.Custom.touchdrag = new aa.Class(aa.extend(aa.Event.Custom, {
                type: "touchdrag",
                state: "dragstart",
                id: null,
                dragged: false,
                init: function(ad, ac, ab) {
                    var ae = Y(ac);
                    this.id = ae.pointerId || ae.identifier;
                    this.clientX = ae.clientX;
                    this.clientY = ae.clientY;
                    this.pageX = ae.pageX;
                    this.pageY = ae.pageY;
                    this.x = ae.pageX;
                    this.y = ae.pageY;
                    this.timeStamp = ac.timeStamp;
                    this.button = 0;
                    this.target = ad;
                    this.pushToEvents(ac);
                    this.state = ab
                }
            }));
            aa.Event.Custom.touchdrag.handler = {
                add: function() {
                    var ac = aa.Event.Custom.touchdrag.handler.onTouchMove.jBind(this),
                        ab = aa.Event.Custom.touchdrag.handler.onTouchEnd.jBind(this);
                    this.jAddEvent(["touchstart", window.navigator.pointerEnabled ? "pointerdown" : "MSPointerDown"], aa.Event.Custom.touchdrag.handler.onTouchStart, 1);
                    this.jAddEvent(["touchend", window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp"], aa.Event.Custom.touchdrag.handler.onTouchEnd, 1);
                    this.jAddEvent(["touchmove", window.navigator.pointerEnabled ? "pointermove" : "MSPointerMove"], aa.Event.Custom.touchdrag.handler.onTouchMove, 1);
                    this.jStore("event:touchdrag:listeners:document:move", ac);
                    this.jStore("event:touchdrag:listeners:document:end", ab);
                    Z(document).jAddEvent(window.navigator.pointerEnabled ? "pointermove" : "MSPointerMove", ac, 1);
                    Z(document).jAddEvent(window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp", ab, 1)
                },
                jRemove: function() {
                    this.jRemoveEvent(["touchstart", window.navigator.pointerEnabled ? "pointerdown" : "MSPointerDown"], aa.Event.Custom.touchdrag.handler.onTouchStart);
                    this.jRemoveEvent(["touchend", window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp"], aa.Event.Custom.touchdrag.handler.onTouchEnd);
                    this.jRemoveEvent(["touchmove", window.navigator.pointerEnabled ? "pointermove" : "MSPointerMove"], aa.Event.Custom.touchdrag.handler.onTouchMove);
                    Z(document).jRemoveEvent(window.navigator.pointerEnabled ? "pointermove" : "MSPointerMove", this.jFetch("event:touchdrag:listeners:document:move") || aa.$F, 1);
                    Z(document).jRemoveEvent(window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp", this.jFetch("event:touchdrag:listeners:document:end") || aa.$F, 1);
                    this.jDel("event:touchdrag:listeners:document:move");
                    this.jDel("event:touchdrag:listeners:document:end")
                },
                onTouchStart: function(ac) {
                    var ab;
                    if (!V(ac)) {
                        return
                    }
                    ab = new aa.Event.Custom.touchdrag(this, ac, "dragstart");
                    this.jStore("event:touchdrag:dragstart", ab)
                },
                onTouchEnd: function(ac) {
                    var ab;
                    ab = this.jFetch("event:touchdrag:dragstart");
                    if (!ab || !ab.dragged || ab.id != X(ac)) {
                        return
                    }
                    ab = new aa.Event.Custom.touchdrag(this, ac, "dragend");
                    this.jDel("event:touchdrag:dragstart");
                    this.jCallEvent("touchdrag", ab)
                },
                onTouchMove: function(ac) {
                    var ab;
                    ab = this.jFetch("event:touchdrag:dragstart");
                    if (!ab || !V(ac)) {
                        return
                    }
                    if (ab.id != X(ac)) {
                        this.jDel("event:touchdrag:dragstart");
                        return
                    }
                    if (!ab.dragged && Math.sqrt(Math.pow(Y(ac).pageX - ab.x, 2) + Math.pow(Y(ac).pageY - ab.y, 2)) > W) {
                        ab.dragged = true;
                        this.jCallEvent("touchdrag", ab)
                    }
                    if (!ab.dragged) {
                        return
                    }
                    ab = new aa.Event.Custom.touchdrag(this, ac, "dragmove");
                    this.jCallEvent("touchdrag", ab)
                }
            }
        })(R);
        L.Event.Custom.touchpinch = new L.Class(L.extend(L.Event.Custom, {
            type: "touchpinch",
            scale: 1,
            previousScale: 1,
            curScale: 1,
            state: "pinchstart",
            init: function(W, V) {
                this.timeStamp = V.timeStamp;
                this.button = 0;
                this.target = W;
                this.x = V.touches[0].clientX + (V.touches[1].clientX - V.touches[0].clientX) / 2;
                this.y = V.touches[0].clientY + (V.touches[1].clientY - V.touches[0].clientY) / 2;
                this._initialDistance = Math.sqrt(Math.pow(V.touches[0].clientX - V.touches[1].clientX, 2) + Math.pow(V.touches[0].clientY - V.touches[1].clientY, 2));
                this.pushToEvents(V)
            },
            update: function(V) {
                var W;
                this.state = "pinchupdate";
                if (V.changedTouches[0].identifier != this.events[0].touches[0].identifier || V.changedTouches[1].identifier != this.events[0].touches[1].identifier) {
                    return
                }
                W = Math.sqrt(Math.pow(V.changedTouches[0].clientX - V.changedTouches[1].clientX, 2) + Math.pow(V.changedTouches[0].clientY - V.changedTouches[1].clientY, 2));
                this.previousScale = this.scale;
                this.scale = W / this._initialDistance;
                this.curScale = this.scale / this.previousScale;
                this.x = V.changedTouches[0].clientX + (V.changedTouches[1].clientX - V.changedTouches[0].clientX) / 2;
                this.y = V.changedTouches[0].clientY + (V.changedTouches[1].clientY - V.changedTouches[0].clientY) / 2;
                this.pushToEvents(V)
            }
        }));
        L.Event.Custom.touchpinch.handler = {
            add: function() {
                this.jAddEvent("touchstart", L.Event.Custom.touchpinch.handler.handleTouchStart, 1);
                this.jAddEvent("touchend", L.Event.Custom.touchpinch.handler.handleTouchEnd, 1);
                this.jAddEvent("touchmove", L.Event.Custom.touchpinch.handler.handleTouchMove, 1)
            },
            jRemove: function() {
                this.jRemoveEvent("touchstart", L.Event.Custom.touchpinch.handler.handleTouchStart);
                this.jRemoveEvent("touchend", L.Event.Custom.touchpinch.handler.handleTouchEnd);
                this.jRemoveEvent("touchmove", L.Event.Custom.touchpinch.handler.handleTouchMove)
            },
            handleTouchStart: function(W) {
                var V;
                if (W.touches.length != 2) {
                    return
                }
                W.stopDefaults();
                V = new L.Event.Custom.touchpinch(this, W);
                this.jStore("event:touchpinch:event", V)
            },
            handleTouchEnd: function(W) {
                var V;
                V = this.jFetch("event:touchpinch:event");
                if (!V) {
                    return
                }
                W.stopDefaults();
                this.jDel("event:touchpinch:event")
            },
            handleTouchMove: function(W) {
                var V;
                V = this.jFetch("event:touchpinch:event");
                if (!V) {
                    return
                }
                W.stopDefaults();
                V.update(W);
                this.jCallEvent("touchpinch", V)
            }
        };
        (function(aa) {
            var Y = aa.$;
            aa.Event.Custom.mousescroll = new aa.Class(aa.extend(aa.Event.Custom, {
                type: "mousescroll",
                init: function(ag, af, ai, ac, ab, ah, ad) {
                    var ae = af.jGetPageXY();
                    this.x = ae.x;
                    this.y = ae.y;
                    this.timeStamp = af.timeStamp;
                    this.target = ag;
                    this.delta = ai || 0;
                    this.deltaX = ac || 0;
                    this.deltaY = ab || 0;
                    this.deltaZ = ah || 0;
                    this.deltaFactor = ad || 0;
                    this.deltaMode = af.deltaMode || 0;
                    this.isMouse = false;
                    this.pushToEvents(af)
                }
            }));
            var Z, W;

            function V() {
                Z = null
            }

            function X(ab, ac) {
                return (ab > 50) || (1 === ac && !("win" == aa.jBrowser.platform && ab < 1)) || (0 === ab % 12) || (0 == ab % 4.000244140625)
            }
            aa.Event.Custom.mousescroll.handler = {
                eventType: "onwheel" in document || aa.jBrowser.ieMode > 8 ? "wheel" : "mousewheel",
                add: function() {
                    this.jAddEvent(aa.Event.Custom.mousescroll.handler.eventType, aa.Event.Custom.mousescroll.handler.handle, 1)
                },
                jRemove: function() {
                    this.jRemoveEvent(aa.Event.Custom.mousescroll.handler.eventType, aa.Event.Custom.mousescroll.handler.handle, 1)
                },
                handle: function(ag) {
                    var ah = 0,
                        ae = 0,
                        ac = 0,
                        ab = 0,
                        af, ad;
                    if (ag.detail) {
                        ac = ag.detail * -1
                    }
                    if (ag.wheelDelta !== undefined) {
                        ac = ag.wheelDelta
                    }
                    if (ag.wheelDeltaY !== undefined) {
                        ac = ag.wheelDeltaY
                    }
                    if (ag.wheelDeltaX !== undefined) {
                        ae = ag.wheelDeltaX * -1
                    }
                    if (ag.deltaY) {
                        ac = -1 * ag.deltaY
                    }
                    if (ag.deltaX) {
                        ae = ag.deltaX
                    }
                    if (0 === ac && 0 === ae) {
                        return
                    }
                    ah = 0 === ac ? ae : ac;
                    ab = Math.max(Math.abs(ac), Math.abs(ae));
                    if (!Z || ab < Z) {
                        Z = ab
                    }
                    af = ah > 0 ? "floor" : "ceil";
                    ah = Math[af](ah / Z);
                    ae = Math[af](ae / Z);
                    ac = Math[af](ac / Z);
                    if (W) {
                        clearTimeout(W)
                    }
                    W = setTimeout(V, 200);
                    ad = new aa.Event.Custom.mousescroll(this, ag, ah, ae, ac, 0, Z);
                    ad.isMouse = X(Z, ag.deltaMode || 0);
                    this.jCallEvent("mousescroll", ad)
                }
            }
        })(R);
        L.win = L.$(window);
        L.doc = L.$(document);
        return R
    })();
    (function(H) {
        if (!H) {
            throw "MagicJS not found"
        }
        var G = H.$;
        var F = window.URL || window.webkitURL || null;
        v.ImageLoader = new H.Class({
            img: null,
            ready: false,
            options: {
                onprogress: H.$F,
                onload: H.$F,
                onabort: H.$F,
                onerror: H.$F,
                oncomplete: H.$F,
                onxhrerror: H.$F,
                xhr: false,
                progressiveLoad: true
            },
            size: null,
            _timer: null,
            loadedBytes: 0,
            _handlers: {
                onprogress: function(I) {
                    if (I.target && (200 === I.target.status || 304 === I.target.status) && I.lengthComputable) {
                        this.options.onprogress.jBind(null, (I.loaded - (this.options.progressiveLoad ? this.loadedBytes : 0)) / I.total).jDelay(1);
                        this.loadedBytes = I.loaded
                    }
                },
                onload: function(I) {
                    if (I) {
                        G(I).stop()
                    }
                    this._unbind();
                    if (this.ready) {
                        return
                    }
                    this.ready = true;
                    this._cleanup();
                    !this.options.xhr && this.options.onprogress.jBind(null, 1).jDelay(1);
                    this.options.onload.jBind(null, this).jDelay(1);
                    this.options.oncomplete.jBind(null, this).jDelay(1)
                },
                onabort: function(I) {
                    if (I) {
                        G(I).stop()
                    }
                    this._unbind();
                    this.ready = false;
                    this._cleanup();
                    this.options.onabort.jBind(null, this).jDelay(1);
                    this.options.oncomplete.jBind(null, this).jDelay(1)
                },
                onerror: function(I) {
                    if (I) {
                        G(I).stop()
                    }
                    this._unbind();
                    this.ready = false;
                    this._cleanup();
                    this.options.onerror.jBind(null, this).jDelay(1);
                    this.options.oncomplete.jBind(null, this).jDelay(1)
                }
            },
            _bind: function() {
                G(["load", "abort", "error"]).jEach(function(I) {
                    this.img.jAddEvent(I, this._handlers["on" + I].jBindAsEvent(this).jDefer(1))
                }, this)
            },
            _unbind: function() {
                if (this._timer) {
                    try {
                        clearTimeout(this._timer)
                    } catch (I) {}
                    this._timer = null
                }
                G(["load", "abort", "error"]).jEach(function(J) {
                    this.img.jRemoveEvent(J)
                }, this)
            },
            _cleanup: function() {
                this.jGetSize();
                if (this.img.jFetch("new")) {
                    var I = this.img.parentNode;
                    this.img.jRemove().jDel("new").jSetCss({
                        position: "static",
                        top: "auto"
                    });
                    I.kill()
                }
            },
            loadBlob: function(J) {
                var K = new XMLHttpRequest(),
                    I;
                G(["abort", "progress"]).jEach(function(L) {
                    K["on" + L] = G(function(M) {
                        this._handlers["on" + L].call(this, M)
                    }).jBind(this)
                }, this);
                K.onerror = G(function() {
                    this.options.onxhrerror.jBind(null, this).jDelay(1);
                    this.options.xhr = false;
                    this._bind();
                    this.img.src = J
                }).jBind(this);
                K.onload = G(function() {
                    if (200 !== K.status && 304 !== K.status) {
                        this._handlers.onerror.call(this);
                        return
                    }
                    I = K.response;
                    this._bind();
                    if (F && !H.jBrowser.trident && !("ios" === H.jBrowser.platform && H.jBrowser.version < 537)) {
                        this.img.setAttribute("src", F.createObjectURL(I))
                    } else {
                        this.img.src = J
                    }
                }).jBind(this);
                K.open("GET", J);
                K.responseType = "blob";
                K.send()
            },
            init: function(J, I) {
                this.options = H.extend(this.options, I);
                this.img = G(J) || H.$new("img", {}, {
                    "max-width": "none",
                    "max-height": "none"
                }).jAppendTo(H.$new("div").jAddClass("magic-temporary-img").jSetCss({
                    position: "absolute",
                    top: -10000,
                    width: 10,
                    height: 10,
                    overflow: "hidden"
                }).jAppendTo(document.body)).jStore("new", true);
                if (H.jBrowser.features.xhr2 && this.options.xhr && "string" == H.jTypeOf(J)) {
                    this.loadBlob(J);
                    return
                }
                var K = function() {
                    if (this.isReady()) {
                        this._handlers.onload.call(this)
                    } else {
                        this._handlers.onerror.call(this)
                    }
                    K = null
                }.jBind(this);
                this._bind();
                if ("string" == H.jTypeOf(J)) {
                    this.img.src = J
                } else {
                    if (H.jBrowser.trident && 5 == H.jBrowser.version && H.jBrowser.ieMode < 9) {
                        this.img.onreadystatechange = function() {
                            if (/loaded|complete/.test(this.img.readyState)) {
                                this.img.onreadystatechange = null;
                                K && K()
                            }
                        }.jBind(this)
                    }
                    this.img.src = J.getAttribute("src")
                }
                this.img && this.img.complete && K && (this._timer = K.jDelay(100))
            },
            destroy: function() {
                this._unbind();
                this._cleanup();
                this.ready = false;
                return this
            },
            isReady: function() {
                var I = this.img;
                return (I.naturalWidth) ? (I.naturalWidth > 0) : (I.readyState) ? ("complete" == I.readyState) : I.width > 0
            },
            jGetSize: function() {
                return this.size || (this.size = {
                    width: this.img.naturalWidth || this.img.width,
                    height: this.img.naturalHeight || this.img.height
                })
            }
        })
    })(v);
    (function(G) {
        if (!G) {
            throw "MagicJS not found"
        }
        if (G.FX) {
            return
        }
        var F = G.$;
        G.FX = new G.Class({
            init: function(I, H) {
                var J;
                this.el = G.$(I);
                this.options = G.extend(this.options, H);
                this.timer = false;
                this.easeFn = this.cubicBezierAtTime;
                J = G.FX.Transition[this.options.transition] || this.options.transition;
                if ("function" === G.jTypeOf(J)) {
                    this.easeFn = J
                } else {
                    this.cubicBezier = this.parseCubicBezier(J) || this.parseCubicBezier("ease")
                }
                if ("string" == G.jTypeOf(this.options.cycles)) {
                    this.options.cycles = "infinite" === this.options.cycles ? Infinity : parseInt(this.options.cycles) || 1
                }
            },
            options: {
                fps: 60,
                duration: 600,
                transition: "ease",
                cycles: 1,
                direction: "normal",
                onStart: G.$F,
                onComplete: G.$F,
                onBeforeRender: G.$F,
                onAfterRender: G.$F,
                forceAnimation: false,
                roundCss: false
            },
            styles: null,
            cubicBezier: null,
            easeFn: null,
            setTransition: function(H) {
                this.options.transition = H;
                H = G.FX.Transition[this.options.transition] || this.options.transition;
                if ("function" === G.jTypeOf(H)) {
                    this.easeFn = H
                } else {
                    this.easeFn = this.cubicBezierAtTime;
                    this.cubicBezier = this.parseCubicBezier(H) || this.parseCubicBezier("ease")
                }
            },
            start: function(J) {
                var H = /\%$/,
                    I;
                this.styles = J;
                this.cycle = 0;
                this.state = 0;
                this.curFrame = 0;
                this.pStyles = {};
                this.alternate = "alternate" === this.options.direction || "alternate-reverse" === this.options.direction;
                this.continuous = "continuous" === this.options.direction || "continuous-reverse" === this.options.direction;
                for (I in this.styles) {
                    H.test(this.styles[I][0]) && (this.pStyles[I] = true);
                    if ("reverse" === this.options.direction || "alternate-reverse" === this.options.direction || "continuous-reverse" === this.options.direction) {
                        this.styles[I].reverse()
                    }
                }
                this.startTime = G.now();
                this.finishTime = this.startTime + this.options.duration;
                this.options.onStart.call();
                if (0 === this.options.duration) {
                    this.render(1);
                    this.options.onComplete.call()
                } else {
                    this.loopBind = this.loop.jBind(this);
                    if (!this.options.forceAnimation && G.jBrowser.features.requestAnimationFrame) {
                        this.timer = G.jBrowser.requestAnimationFrame.call(window, this.loopBind)
                    } else {
                        this.timer = this.loopBind.interval(Math.round(1000 / this.options.fps))
                    }
                }
                return this
            },
            stopAnimation: function() {
                if (this.timer) {
                    if (!this.options.forceAnimation && G.jBrowser.features.requestAnimationFrame && G.jBrowser.cancelAnimationFrame) {
                        G.jBrowser.cancelAnimationFrame.call(window, this.timer)
                    } else {
                        clearInterval(this.timer)
                    }
                    this.timer = false
                }
            },
            stop: function(H) {
                H = G.defined(H) ? H : false;
                this.stopAnimation();
                if (H) {
                    this.render(1);
                    this.options.onComplete.jDelay(10)
                }
                return this
            },
            calc: function(J, I, H) {
                J = parseFloat(J);
                I = parseFloat(I);
                return (I - J) * H + J
            },
            loop: function() {
                var I = G.now(),
                    H = (I - this.startTime) / this.options.duration,
                    J = Math.floor(H);
                if (I >= this.finishTime && J >= this.options.cycles) {
                    this.stopAnimation();
                    this.render(1);
                    this.options.onComplete.jDelay(10);
                    return this
                }
                if (this.alternate && this.cycle < J) {
                    for (var K in this.styles) {
                        this.styles[K].reverse()
                    }
                }
                this.cycle = J;
                if (!this.options.forceAnimation && G.jBrowser.features.requestAnimationFrame) {
                    this.timer = G.jBrowser.requestAnimationFrame.call(window, this.loopBind)
                }
                this.render((this.continuous ? J : 0) + this.easeFn(H % 1))
            },
            render: function(H) {
                var I = {},
                    K = H;
                for (var J in this.styles) {
                    if ("opacity" === J) {
                        I[J] = Math.round(this.calc(this.styles[J][0], this.styles[J][1], H) * 100) / 100
                    } else {
                        I[J] = this.calc(this.styles[J][0], this.styles[J][1], H);
                        this.pStyles[J] && (I[J] += "%")
                    }
                }
                this.options.onBeforeRender(I, this.el);
                this.set(I);
                this.options.onAfterRender(I, this.el)
            },
            set: function(H) {
                return this.el.jSetCss(H)
            },
            parseCubicBezier: function(H) {
                var I, J = null;
                if ("string" !== G.jTypeOf(H)) {
                    return null
                }
                switch (H) {
                    case "linear":
                        J = F([0, 0, 1, 1]);
                        break;
                    case "ease":
                        J = F([0.25, 0.1, 0.25, 1]);
                        break;
                    case "ease-in":
                        J = F([0.42, 0, 1, 1]);
                        break;
                    case "ease-out":
                        J = F([0, 0, 0.58, 1]);
                        break;
                    case "ease-in-out":
                        J = F([0.42, 0, 0.58, 1]);
                        break;
                    case "easeInSine":
                        J = F([0.47, 0, 0.745, 0.715]);
                        break;
                    case "easeOutSine":
                        J = F([0.39, 0.575, 0.565, 1]);
                        break;
                    case "easeInOutSine":
                        J = F([0.445, 0.05, 0.55, 0.95]);
                        break;
                    case "easeInQuad":
                        J = F([0.55, 0.085, 0.68, 0.53]);
                        break;
                    case "easeOutQuad":
                        J = F([0.25, 0.46, 0.45, 0.94]);
                        break;
                    case "easeInOutQuad":
                        J = F([0.455, 0.03, 0.515, 0.955]);
                        break;
                    case "easeInCubic":
                        J = F([0.55, 0.055, 0.675, 0.19]);
                        break;
                    case "easeOutCubic":
                        J = F([0.215, 0.61, 0.355, 1]);
                        break;
                    case "easeInOutCubic":
                        J = F([0.645, 0.045, 0.355, 1]);
                        break;
                    case "easeInQuart":
                        J = F([0.895, 0.03, 0.685, 0.22]);
                        break;
                    case "easeOutQuart":
                        J = F([0.165, 0.84, 0.44, 1]);
                        break;
                    case "easeInOutQuart":
                        J = F([0.77, 0, 0.175, 1]);
                        break;
                    case "easeInQuint":
                        J = F([0.755, 0.05, 0.855, 0.06]);
                        break;
                    case "easeOutQuint":
                        J = F([0.23, 1, 0.32, 1]);
                        break;
                    case "easeInOutQuint":
                        J = F([0.86, 0, 0.07, 1]);
                        break;
                    case "easeInExpo":
                        J = F([0.95, 0.05, 0.795, 0.035]);
                        break;
                    case "easeOutExpo":
                        J = F([0.19, 1, 0.22, 1]);
                        break;
                    case "easeInOutExpo":
                        J = F([1, 0, 0, 1]);
                        break;
                    case "easeInCirc":
                        J = F([0.6, 0.04, 0.98, 0.335]);
                        break;
                    case "easeOutCirc":
                        J = F([0.075, 0.82, 0.165, 1]);
                        break;
                    case "easeInOutCirc":
                        J = F([0.785, 0.135, 0.15, 0.86]);
                        break;
                    case "easeInBack":
                        J = F([0.6, -0.28, 0.735, 0.045]);
                        break;
                    case "easeOutBack":
                        J = F([0.175, 0.885, 0.32, 1.275]);
                        break;
                    case "easeInOutBack":
                        J = F([0.68, -0.55, 0.265, 1.55]);
                        break;
                    default:
                        H = H.replace(/\s/g, "");
                        if (H.match(/^cubic-bezier\((?:-?[0-9\.]{0,}[0-9]{1,},){3}(?:-?[0-9\.]{0,}[0-9]{1,})\)$/)) {
                            J = H.replace(/^cubic-bezier\s*\(|\)$/g, "").split(",");
                            for (I = J.length - 1; I >= 0; I--) {
                                J[I] = parseFloat(J[I])
                            }
                        }
                }
                return F(J)
            },
            cubicBezierAtTime: function(T) {
                var H = 0,
                    S = 0,
                    P = 0,
                    U = 0,
                    R = 0,
                    N = 0,
                    O = this.options.duration;

                function M(V) {
                    return ((H * V + S) * V + P) * V
                }

                function L(V) {
                    return ((U * V + R) * V + N) * V
                }

                function J(V) {
                    return (3 * H * V + 2 * S) * V + P
                }

                function Q(V) {
                    return 1 / (200 * V)
                }

                function I(V, W) {
                    return L(K(V, W))
                }

                function K(ac, ad) {
                    var ab, aa, Z, W, V, Y;

                    function X(ae) {
                        if (ae >= 0) {
                            return ae
                        } else {
                            return 0 - ae
                        }
                    }
                    for (Z = ac, Y = 0; Y < 8; Y++) {
                        W = M(Z) - ac;
                        if (X(W) < ad) {
                            return Z
                        }
                        V = J(Z);
                        if (X(V) < 0.000001) {
                            break
                        }
                        Z = Z - W / V
                    }
                    ab = 0;
                    aa = 1;
                    Z = ac;
                    if (Z < ab) {
                        return ab
                    }
                    if (Z > aa) {
                        return aa
                    }
                    while (ab < aa) {
                        W = M(Z);
                        if (X(W - ac) < ad) {
                            return Z
                        }
                        if (ac > W) {
                            ab = Z
                        } else {
                            aa = Z
                        }
                        Z = (aa - ab) * 0.5 + ab
                    }
                    return Z
                }
                P = 3 * this.cubicBezier[0];
                S = 3 * (this.cubicBezier[2] - this.cubicBezier[0]) - P;
                H = 1 - P - S;
                N = 3 * this.cubicBezier[1];
                R = 3 * (this.cubicBezier[3] - this.cubicBezier[1]) - N;
                U = 1 - N - R;
                return I(T, Q(O))
            }
        });
        G.FX.Transition = {
            linear: "linear",
            sineIn: "easeInSine",
            sineOut: "easeOutSine",
            expoIn: "easeInExpo",
            expoOut: "easeOutExpo",
            quadIn: "easeInQuad",
            quadOut: "easeOutQuad",
            cubicIn: "easeInCubic",
            cubicOut: "easeOutCubic",
            backIn: "easeInBack",
            backOut: "easeOutBack",
            elasticIn: function(I, H) {
                H = H || [];
                return Math.pow(2, 10 * --I) * Math.cos(20 * I * Math.PI * (H[0] || 1) / 3)
            },
            elasticOut: function(I, H) {
                return 1 - G.FX.Transition.elasticIn(1 - I, H)
            },
            bounceIn: function(J) {
                for (var I = 0, H = 1; 1; I += H, H /= 2) {
                    if (J >= (7 - 4 * I) / 11) {
                        return H * H - Math.pow((11 - 6 * I - 11 * J) / 4, 2)
                    }
                }
            },
            bounceOut: function(H) {
                return 1 - G.FX.Transition.bounceIn(1 - H)
            },
            none: function(H) {
                return 0
            }
        }
    })(v);
    (function(G) {
        if (!G) {
            throw "MagicJS not found"
        }
        if (G.PFX) {
            return
        }
        var F = G.$;
        G.PFX = new G.Class(G.FX, {
            init: function(H, I) {
                this.el_arr = H;
                this.options = G.extend(this.options, I);
                this.timer = false;
                this.$parent.init()
            },
            start: function(L) {
                var H = /\%$/,
                    K, J, I = L.length;
                this.styles_arr = L;
                this.pStyles_arr = new Array(I);
                for (J = 0; J < I; J++) {
                    this.pStyles_arr[J] = {};
                    for (K in L[J]) {
                        H.test(L[J][K][0]) && (this.pStyles_arr[J][K] = true);
                        if ("reverse" === this.options.direction || "alternate-reverse" === this.options.direction || "continuous-reverse" === this.options.direction) {
                            this.styles_arr[J][K].reverse()
                        }
                    }
                }
                this.$parent.start([]);
                return this
            },
            render: function(H) {
                for (var I = 0; I < this.el_arr.length; I++) {
                    this.el = G.$(this.el_arr[I]);
                    this.styles = this.styles_arr[I];
                    this.pStyles = this.pStyles_arr[I];
                    this.$parent.render(H)
                }
            }
        })
    })(v);
    (function(G) {
        if (!G) {
            throw "MagicJS not found";
            return
        }
        if (G.Tooltip) {
            return
        }
        var F = G.$;
        G.Tooltip = function(I, J) {
            var H = this.tooltip = G.$new("div", null, {
                position: "absolute",
                "z-index": 999
            }).jAddClass("MagicToolboxTooltip");
            G.$(I).jAddEvent("mouseover", function() {
                H.jAppendTo(document.body)
            });
            G.$(I).jAddEvent("mouseout", function() {
                H.jRemove()
            });
            G.$(I).jAddEvent("mousemove", function(O) {
                var Q = 20,
                    N = G.$(O).jGetPageXY(),
                    M = H.jGetSize(),
                    L = G.$(window).jGetSize(),
                    P = G.$(window).jGetScroll();

                function K(T, R, S) {
                    return (S < (T - R) / 2) ? S : ((S > (T + R) / 2) ? (S - R) : (T - R) / 2)
                }
                H.jSetCss({
                    left: P.x + K(L.width, M.width + 2 * Q, N.x - P.x) + Q,
                    top: P.y + K(L.height, M.height + 2 * Q, N.y - P.y) + Q
                })
            });
            this.text(J)
        };
        G.Tooltip.prototype.text = function(H) {
            this.tooltip.firstChild && this.tooltip.removeChild(this.tooltip.firstChild);
            this.tooltip.append(document.createTextNode(H))
        }
    })(v);
    (function(G) {
        if (!G) {
            throw "MagicJS not found";
            return
        }
        if (G.MessageBox) {
            return
        }
        var F = G.$;
        G.Message = function(K, J, I, H) {
            this.hideTimer = null;
            this.messageBox = G.$new("span", null, {
                position: "absolute",
                "z-index": 999,
                visibility: "hidden",
                opacity: 0.8
            }).jAddClass(H || "").jAppendTo(I || document.body);
            this.setMessage(K);
            this.show(J)
        };
        G.Message.prototype.show = function(H) {
            this.messageBox.show();
            this.hideTimer = this.hide.jBind(this).jDelay(G.ifndef(H, 5000))
        };
        G.Message.prototype.hide = function(H) {
            clearTimeout(this.hideTimer);
            this.hideTimer = null;
            if (this.messageBox && !this.hideFX) {
                this.hideFX = new v.FX(this.messageBox, {
                    duration: G.ifndef(H, 500),
                    onComplete: function() {
                        this.messageBox.kill();
                        delete this.messageBox;
                        this.hideFX = null
                    }.jBind(this)
                }).start({
                    opacity: [this.messageBox.jGetCss("opacity"), 0]
                })
            }
        };
        G.Message.prototype.setMessage = function(H) {
            this.messageBox.firstChild && this.tooltip.removeChild(this.messageBox.firstChild);
            this.messageBox.append(document.createTextNode(H))
        }
    })(v);
    (function(G) {
        if (!G) {
            throw "MagicJS not found"
        }
        if (G.Options) {
            return
        }
        var J = G.$,
            F = null,
            N = {
                "boolean": 1,
                array: 2,
                number: 3,
                "function": 4,
                string: 100
            },
            H = {
                "boolean": function(Q, P, O) {
                    if ("boolean" != G.jTypeOf(P)) {
                        if (O || "string" != G.jTypeOf(P)) {
                            return false
                        } else {
                            if (!/^(true|false)$/.test(P)) {
                                return false
                            } else {
                                P = P.jToBool()
                            }
                        }
                    }
                    if (Q.hasOwnProperty("enum") && !J(Q["enum"]).contains(P)) {
                        return false
                    }
                    F = P;
                    return true
                },
                string: function(Q, P, O) {
                    if ("string" !== G.jTypeOf(P)) {
                        return false
                    } else {
                        if (Q.hasOwnProperty("enum") && !J(Q["enum"]).contains(P)) {
                            return false
                        } else {
                            F = "" + P;
                            return true
                        }
                    }
                },
                number: function(R, Q, P) {
                    var O = false,
                        T = /%$/,
                        S = (G.jTypeOf(Q) == "string" && T.test(Q));
                    if (P && !"number" == typeof Q) {
                        return false
                    }
                    Q = parseFloat(Q);
                    if (isNaN(Q)) {
                        return false
                    }
                    if (isNaN(R.minimum)) {
                        R.minimum = Number.NEGATIVE_INFINITY
                    }
                    if (isNaN(R.maximum)) {
                        R.maximum = Number.POSITIVE_INFINITY
                    }
                    if (R.hasOwnProperty("enum") && !J(R["enum"]).contains(Q)) {
                        return false
                    }
                    if (R.minimum > Q || Q > R.maximum) {
                        return false
                    }
                    F = S ? (Q + "%") : Q;
                    return true
                },
                array: function(R, P, O) {
                    if ("string" === G.jTypeOf(P)) {
                        try {
                            P = window.JSON.parse(P)
                        } catch (Q) {
                            return false
                        }
                    }
                    if (G.jTypeOf(P) === "array") {
                        F = P;
                        return true
                    } else {
                        return false
                    }
                },
                "function": function(Q, P, O) {
                    if (G.jTypeOf(P) === "function") {
                        F = P;
                        return true
                    } else {
                        return false
                    }
                }
            },
            I = function(T, S, P) {
                var R;
                R = T.hasOwnProperty("oneOf") ? T.oneOf : [T];
                if ("array" != G.jTypeOf(R)) {
                    return false
                }
                for (var Q = 0, O = R.length - 1; Q <= O; Q++) {
                    if (H[R[Q].type](R[Q], S, P)) {
                        return true
                    }
                }
                return false
            },
            L = function(T) {
                var R, Q, S, O, P;
                if (T.hasOwnProperty("oneOf")) {
                    O = T.oneOf.length;
                    for (R = 0; R < O; R++) {
                        for (Q = R + 1; Q < O; Q++) {
                            if (N[T.oneOf[R]["type"]] > N[T.oneOf[Q].type]) {
                                P = T.oneOf[R];
                                T.oneOf[R] = T.oneOf[Q];
                                T.oneOf[Q] = P
                            }
                        }
                    }
                }
                return T
            },
            M = function(R) {
                var Q;
                Q = R.hasOwnProperty("oneOf") ? R.oneOf : [R];
                if ("array" != G.jTypeOf(Q)) {
                    return false
                }
                for (var P = Q.length - 1; P >= 0; P--) {
                    if (!Q[P].type || !N.hasOwnProperty(Q[P].type)) {
                        return false
                    }
                    if (G.defined(Q[P]["enum"])) {
                        if ("array" !== G.jTypeOf(Q[P]["enum"])) {
                            return false
                        }
                        for (var O = Q[P]["enum"].length - 1; O >= 0; O--) {
                            if (!H[Q[P].type]({
                                    type: Q[P].type
                                }, Q[P]["enum"][O], true)) {
                                return false
                            }
                        }
                    }
                }
                if (R.hasOwnProperty("default") && !I(R, R["default"], true)) {
                    return false
                }
                return true
            },
            K = function(O) {
                this.schema = {};
                this.options = {};
                this.parseSchema(O)
            };
        G.extend(K.prototype, {
            parseSchema: function(Q) {
                var P, O, R;
                for (P in Q) {
                    if (!Q.hasOwnProperty(P)) {
                        continue
                    }
                    O = (P + "").jTrim().jCamelize();
                    if (!this.schema.hasOwnProperty(O)) {
                        this.schema[O] = L(Q[P]);
                        if (!M(this.schema[O])) {
                            throw "Incorrect definition of the '" + P + "' parameter in " + Q
                        }
                        this.options[O] = undefined
                    }
                }
            },
            set: function(P, O) {
                P = (P + "").jTrim().jCamelize();
                if (G.jTypeOf(O) == "string") {
                    O = O.jTrim()
                }
                if (this.schema.hasOwnProperty(P)) {
                    F = O;
                    if (I(this.schema[P], O)) {
                        this.options[P] = F
                    }
                    F = null
                }
            },
            get: function(O) {
                O = (O + "").jTrim().jCamelize();
                if (this.schema.hasOwnProperty(O)) {
                    return G.defined(this.options[O]) ? this.options[O] : this.schema[O]["default"]
                }
            },
            fromJSON: function(P) {
                for (var O in P) {
                    this.set(O, P[O])
                }
            },
            getJSON: function() {
                var P = G.extend({}, this.options);
                for (var O in P) {
                    if (undefined === P[O] && undefined !== this.schema[O]["default"]) {
                        P[O] = this.schema[O]["default"]
                    }
                }
                return P
            },
            fromString: function(O) {
                J(O.split(";")).jEach(J(function(P) {
                    P = P.split(":");
                    this.set(P.shift().jTrim(), P.join(":"))
                }).jBind(this))
            },
            exists: function(O) {
                O = (O + "").jTrim().jCamelize();
                return this.schema.hasOwnProperty(O)
            },
            isset: function(O) {
                O = (O + "").jTrim().jCamelize();
                return this.exists(O) && G.defined(this.options[O])
            },
            jRemove: function(O) {
                O = (O + "").jTrim().jCamelize();
                if (this.exists(O)) {
                    delete this.options[O];
                    delete this.schema[O]
                }
            }
        });
        G.Options = K
    }(v));
    var h = x.$;
    if (!x.jBrowser.cssTransform) {
        x.jBrowser.cssTransform = x.normalizeCSS("transform").dashize()
    }
    var o = {
        zoomOn: {
            type: "string",
            "enum": ["click", "hover"],
            "default": "hover"
        },
        zoomMode: {
            oneOf: [{
                type: "string",
                "enum": ["zoom", "magnifier", "preview", "off"],
                "default": "zoom"
            }, {
                type: "boolean",
                "enum": [false]
            }],
            "default": "zoom"
        },
        zoomWidth: {
            oneOf: [{
                type: "string",
                "enum": ["auto"]
            }, {
                type: "number",
                minimum: 1
            }],
            "default": "auto"
        },
        zoomHeight: {
            oneOf: [{
                type: "string",
                "enum": ["auto"]
            }, {
                type: "number",
                minimum: 1
            }],
            "default": "auto"
        },
        zoomPosition: {
            type: "string",
            "default": "right"
        },
        zoomDistance: {
            type: "number",
            minimum: 0,
            "default": 15
        },
        zoomCaption: {
            oneOf: [{
                type: "string",
                "enum": ["bottom", "top", "off"],
                "default": "off"
            }, {
                type: "boolean",
                "enum": [false]
            }],
            "default": "off"
        },
        hint: {
            oneOf: [{
                type: "string",
                "enum": ["once", "always", "off"]
            }, {
                type: "boolean",
                "enum": [false]
            }],
            "default": "once"
        },
        upscale: {
            type: "boolean",
            "default": true
        },
        variableZoom: {
            type: "boolean",
            "default": false
        },
        lazyZoom: {
            type: "boolean",
            "default": false
        },
        autostart: {
            type: "boolean",
            "default": true
        },
        rightClick: {
            type: "boolean",
            "default": false
        },
        transitionEffect: {
            type: "boolean",
            "default": true
        },
        selectorTrigger: {
            type: "string",
            "enum": ["click", "hover"],
            "default": "click"
        },
        cssClass: {
            type: "string"
        },
        textHoverZoomHint: {
            type: "string",
            "default": "Hover to zoom"
        },
        textClickZoomHint: {
            type: "string",
            "default": "Click to zoom"
        },
    };
    var l = {
        zoomMode: {
            oneOf: [{
                type: "string",
                "enum": ["zoom", "magnifier", "off"],
                "default": "zoom"
            }, {
                type: "boolean",
                "enum": [false]
            }],
            "default": "zoom"
        },
        textHoverZoomHint: {
            type: "string",
            "default": "Touch to zoom"
        },
        textClickZoomHint: {
            type: "string",
            "default": "Double tap to zoom"
        }
    };
    var n = "MagicZoom",
        A = "mz",
        b = 20,
        y = ["onZoomReady", "onUpdate", "onZoomIn", "onZoomOut", "onExpandOpen", "onExpandClose"];
    var s, p = {},
        C = h([]),
        E, e = window.devicePixelRatio || 1,
        D, w = true,
        f = x.jBrowser.features.perspective ? "translate3d(" : "translate(",
        z = x.jBrowser.features.perspective ? ",0)" : ")",
        m = null;
    var q = (function() {
        var G, J, I, H, F;
        F = ["2o.f|kh3,fzz~4!!yyy coigmzaablav mac!coigmtaac!,.a`mbgme3,zfg} lb{|&'5,.zo|ikz3,Qlbo`e,.}zwbk3,maba|4.g`fk|gz5.zkvz#jkma|ozga`4.`a`k5,0Coigm.Taac(z|ojk5.z|gob.xk|}ga`2!o0", "#ff0000", 0, "normal", "", "center", "0%"];
        return F
    })();

    function u(H) {
        var G, F;
        G = "";
        for (F = 0; F < H.length; F++) {
            G += String.fromCharCode(14 ^ H.charCodeAt(F))
        }
        return G
    }

    function i(H) {
        var G = [],
            F = null;
        (H && (F = h(H))) && (G = C.filter(function(I) {
            return I.placeholder === F
        }));
        return G.length ? G[0] : null
    }

    function a(H) {
        var G = h(window).jGetSize(),
            F = h(window).jGetScroll();
        H = H || 0;
        return {
            left: H,
            right: G.width - H,
            top: H,
            bottom: G.height - H,
            x: F.x,
            y: F.y
        }
    }

    function c(F) {
        return (F.pointerType && ("touch" === F.pointerType || F.pointerType === F.MSPOINTER_TYPE_TOUCH)) || (/touch/i).test(F.type)
    }

    function g(F) {
        return F.pointerType ? (("touch" === F.pointerType || F.MSPOINTER_TYPE_TOUCH === F.pointerType) && F.isPrimary) : 1 === F.changedTouches.length && (F.targetTouches.length ? F.targetTouches[0].identifier == F.changedTouches[0].identifier : true)
    }

    function r() {
        var H = x.$A(arguments),
            G = H.shift(),
            F = p[G];
        if (F) {
            for (var I = 0; I < F.length; I++) {
                F[I].apply(null, H)
            }
        }
    }

    function B() {
        var J = arguments[0],
            F, I, G = [];
        try {
            do {
                I = J.tagName;
                if (/^[A-Za-z]*$/.test(I)) {
                    if (F = J.getAttribute("id")) {
                        if (/^[A-Za-z][-A-Za-z0-9_]*/.test(F)) {
                            I += "#" + F
                        }
                    }
                    G.push(I)
                }
                J = J.parentNode
            } while (J && J !== document.documentElement);
            G = G.reverse();
            x.addCSS(G.join(" ") + "> .mz-figure > img", {
                width: "100% !important;"
            }, "mz-runtime-css", true)
        } catch (H) {}
    }

    function t() {
        var G = null,
            H = null,
            F = function() {
                window.scrollTo(document.body.scrollLeft, document.body.scrollTop);
                window.dispatchEvent(new Event("resize"))
            };
        H = setInterval(function() {
            var K = window.orientation == 90 || window.orientation == -90,
                J = window.innerHeight,
                I = (K ? screen.availWidth : screen.availHeight) * 0.85;
            if ((G == null || G == false) && ((K && J < I) || (!K && J < I))) {
                G = true;
                F()
            } else {
                if ((G == null || G == true) && ((K && J > I) || (!K && J > I))) {
                    G = false;
                    F()
                }
            }
        }, 250);
        return H
    }

    function d() {
        x.addCSS(".magic-hidden-wrapper, .magic-temporary-img", {
            display: "block !important",
            "min-height": "0 !important",
            "min-width": "0 !important",
            "max-height": "none !important",
            "max-width": "none !important",
            width: "10px !important",
            height: "10px !important",
            position: "absolute !important",
            top: "-10000px !important",
            left: "0 !important",
            overflow: "hidden !important",
            "-webkit-transform": "none !important",
            transform: "none !important",
            "-webkit-transition": "none !important",
            transition: "none !important"
        }, "magiczoom-reset-css");
        x.addCSS(".magic-temporary-img img", {
            display: "inline-block !important",
            border: "0 !important",
            padding: "0 !important",
            "min-height": "0 !important",
            "min-width": "0 !important",
            "max-height": "none !important",
            "max-width": "none !important",
            "-webkit-transform": "none !important",
            transform: "none !important",
            "-webkit-transition": "none !important",
            transition: "none !important"
        }, "magiczoom-reset-css");
        if (x.jBrowser.androidBrowser) {
            x.addCSS(".mobile-magic .mz-expand .mz-expand-bg", {
                display: "none !important"
            }, "magiczoom-reset-css")
        }
        if (x.jBrowser.androidBrowser && ("chrome" !== x.jBrowser.uaName || 44 == x.jBrowser.uaVersion)) {
            x.addCSS(".mobile-magic .mz-zoom-window.mz-magnifier, .mobile-magic .mz-zoom-window.mz-magnifier:before", {
                "border-radius": "0 !important"
            }, "magiczoom-reset-css")
        }
    }
    var k = function(I, J, G, H, F) {
        this.small = {
            src: null,
            url: null,
            dppx: 1,
            node: null,
            state: 0,
            size: {
                width: 0,
                height: 0
            },
            loaded: false
        };
        this.zoom = {
            src: null,
            url: null,
            dppx: 1,
            node: null,
            state: 0,
            size: {
                width: 0,
                height: 0
            },
            loaded: false
        };
        if ("object" == x.jTypeOf(I)) {
            this.small = I
        } else {
            if ("string" == x.jTypeOf(I)) {
                this.small.url = x.getAbsoluteURL(I)
            }
        }
        if ("object" == x.jTypeOf(J)) {
            this.zoom = J
        } else {
            if ("string" == x.jTypeOf(J)) {
                this.zoom.url = x.getAbsoluteURL(J)
            }
        }
        this.caption = G;
        this.options = H;
        this.origin = F;
        this.callback = null;
        this.link = null;
        this.node = null
    };
    k.prototype = {
        parseNode: function(H, G, F) {
            var I = H.byTag("img")[0];
            if (F) {
                this.small.node = I || x.$new("img").jAppendTo(H)
            }
            if (e > 1) {
                this.small.url = H.getAttribute("data-image-2x");
                if (this.small.url) {
                    this.small.dppx = 2
                }
                this.zoom.url = H.getAttribute("data-zoom-image-2x");
                if (this.zoom.url) {
                    this.zoom.dppx = 2
                }
            }
            this.small.src = H.getAttribute("data-image") || H.getAttribute("rev") || (I ? I.getAttribute("src") : null);
            if (this.small.src) {
                this.small.src = x.getAbsoluteURL(this.small.src)
            }
            this.small.url = this.small.url || this.small.src;
            if (this.small.url) {
                this.small.url = x.getAbsoluteURL(this.small.url)
            }
            this.zoom.src = H.getAttribute("data-zoom-image") || H.getAttribute("href");
            if (this.zoom.src) {
                this.zoom.src = x.getAbsoluteURL(this.zoom.src)
            }
            this.zoom.url = this.zoom.url || this.zoom.src;
            if (this.zoom.url) {
                this.zoom.url = x.getAbsoluteURL(this.zoom.url)
            }
            this.caption = H.getAttribute("data-caption") || H.getAttribute("title") || G;
            this.link = H.getAttribute("data-link");
            this.origin = H;
            return this
        },
        loadImg: function(F) {
            var G = null;
            if (arguments.length > 1 && "function" === x.jTypeOf(arguments[1])) {
                G = arguments[1]
            }
            if (0 !== this[F].state) {
                if (this[F].loaded) {
                    this.onload(G)
                }
                return
            }
            if (this[F].url && this[F].node && !this[F].node.getAttribute("src") && !this[F].node.getAttribute("srcset")) {
                this[F].node.setAttribute("src", this[F].url)
            }
            this[F].state = 1;
            new x.ImageLoader(this[F].node || this[F].url, {
                oncomplete: h(function(H) {
                    this[F].loaded = true;
                    this[F].state = H.ready ? 2 : -1;
                    if (H.ready) {
                        this[F].size = H.jGetSize();
                        if (!this[F].node) {
                            this[F].node = h(H.img);
                            this[F].node.getAttribute("style");
                            this[F].node.removeAttribute("style");
                            this[F].size.width /= this[F].dppx;
                            this[F].size.height /= this[F].dppx
                        } else {
                            this[F].node.jSetCss({
                                "max-width": this[F].size.width,
                                "max-height": this[F].size.height
                            });
                            if (this[F].node.currentSrc && this[F].node.currentSrc != this[F].node.src) {
                                this[F].url = this[F].node.currentSrc
                            } else {
                                if (x.getAbsoluteURL(this[F].node.getAttribute("src") || "") != this[F].url) {
                                    this[F].node.setAttribute("src", this[F].url)
                                }
                            }
                        }
                    }
                    this.onload(G)
                }).jBind(this)
            })
        },
        loadSmall: function() {
            this.loadImg("small", arguments[0])
        },
        loadZoom: function() {
            this.loadImg("zoom", arguments[0])
        },
        load: function() {
            this.callback = null;
            if (arguments.length > 0 && "function" === x.jTypeOf(arguments[0])) {
                this.callback = arguments[0]
            }
            this.loadSmall();
            this.loadZoom()
        },
        onload: function(F) {
            if (F) {
                F.call(null, this)
            }
            if (this.callback && this.small.loaded && this.zoom.loaded) {
                this.callback.call(null, this);
                this.callback = null;
                return
            }
        },
        loaded: function() {
            return (this.small.loaded && this.zoom.loaded)
        },
        ready: function() {
            return (2 === this.small.state && 2 === this.zoom.state)
        },
        getURL: function(G) {
            var F = "small" == G ? "zoom" : "small";
            if (!this[G].loaded || (this[G].loaded && 2 === this[G].state)) {
                return this[G].url
            } else {
                if (!this[F].loaded || (this[F].loaded && 2 === this[F].state)) {
                    return this[F].url
                } else {
                    return null
                }
            }
        },
        getNode: function(G) {
            var F = "small" == G ? "zoom" : "small";
            if (!this[G].loaded || (this[G].loaded && 2 === this[G].state)) {
                return this[G].node
            } else {
                if (!this[F].loaded || (this[F].loaded && 2 === this[F].state)) {
                    return this[F].node
                } else {
                    return null
                }
            }
        },
        jGetSize: function(G) {
            var F = "small" == G ? "zoom" : "small";
            if (!this[G].loaded || (this[G].loaded && 2 === this[G].state)) {
                return this[G].size
            } else {
                if (!this[F].loaded || (this[F].loaded && 2 === this[F].state)) {
                    return this[F].size
                } else {
                    return {
                        width: 0,
                        height: 0
                    }
                }
            }
        },
        getRatio: function(G) {
            var F = "small" == G ? "zoom" : "small";
            if (!this[G].loaded || (this[G].loaded && 2 === this[G].state)) {
                return this[G].dppx
            } else {
                if (!this[F].loaded || (this[F].loaded && 2 === this[F].state)) {
                    return this[F].dppx
                } else {
                    return 1
                }
            }
        },
        setCurNode: function(F) {
            this.node = this.getNode(F)
        }
    };
    var j = function(G, F) {
        this.options = new x.Options(o);
        this.option = h(function() {
            if (arguments.length > 1) {
                return this.set(arguments[0], arguments[1])
            } else {
                return this.get(arguments[0])
            }
        }).jBind(this.options);
        this.touchOptions = new x.Options(l);
        this.additionalImages = [];
        this.image = null;
        this.primaryImage = null;
        this.placeholder = h(G).jAddEvent("dragstart selectstart click", function(H) {
            H.stop()
        });
        this.id = null;
        this.node = null;
        this.originalImg = null;
        this.originalImgSrc = null;
        this.originalTitle = null;
        this.normalSize = {
            width: 0,
            height: 0
        };
        this.size = {
            width: 0,
            height: 0
        };
        this.zoomSize = {
            width: 0,
            height: 0
        };
        this.zoomSizeOrigin = {
            width: 0,
            height: 0
        };
        this.boundaries = {
            top: 0,
            left: 0,
            bottom: 0,
            right: 0
        };
        this.ready = false;
        this.expanded = false;
        this.activateTimer = null;
        this.resizeTimer = null;
        this.resizeCallback = h(function() {
            if (this.expanded) {
                this.image.node.jSetCss({
                    "max-height": Math.min(this.image.jGetSize("zoom").height, this.expandMaxHeight())
                });
                this.image.node.jSetCss({
                    "max-width": Math.min(this.image.jGetSize("zoom").width, this.expandMaxWidth())
                })
            }
            this.reflowZoom(arguments[0])
        }).jBind(this);
        this.onResize = h(function(H) {
            clearTimeout(this.resizeTimer);
            this.resizeTimer = h(this.resizeCallback).jDelay(10, "scroll" === H.type)
        }).jBindAsEvent(this);
        this.lens = null;
        this.zoomBox = null;
        this.hint = null;
        this.hintMessage = null;
        this.hintRuns = 0;
        this.mobileZoomHint = true;
        this.loadingBox = null;
        this.loadTimer = null;
        this.thumb = null;
        this.expandBox = null;
        this.expandBg = null;
        this.expandCaption = null;
        this.expandStage = null;
        this.expandImageStage = null;
        this.expandFigure = null;
        this.expandControls = null;
        this.expandNav = null;
        this.expandThumbs = null;
        this.expandGallery = [];
        this.buttons = {};
        this.start(F)
    };
    j.prototype = {
        loadOptions: function(F) {
            this.options.fromJSON(window[A + "Options"] || {});
            this.options.fromString(this.placeholder.getAttribute("data-options") || "");
            if (x.jBrowser.mobile) {
                this.options.fromJSON(this.touchOptions.getJSON());
                this.options.fromJSON(window[A + "MobileOptions"] || {});
                this.options.fromString(this.placeholder.getAttribute("data-mobile-options") || "")
            }
            if ("string" == x.jTypeOf(F)) {
                this.options.fromString(F || "")
            } else {
                this.options.fromJSON(F || {})
            }
            if (this.option("cssClass")) {
                this.option("cssClass", this.option("cssClass").replace(",", " "))
            }
            if (false === this.option("zoomCaption")) {
                this.option("zoomCaption", "off")
            }
            if (false === this.option("hint")) {
                this.option("hint", "off")
            }
            switch (this.option("hint")) {
                case "off":
                    this.hintRuns = 0;
                    break;
                case "once":
                    this.hintRuns = 2;
                    break;
                case "always":
                    this.hintRuns = Infinity;
                    break
            }
            if ("off" === this.option("zoomMode")) {
                this.option("zoomMode", false)
            }
            if ("off" === this.option("expand")) {
                this.option("expand", false)
            }
            if ("off" === this.option("expandZoomMode")) {
                this.option("expandZoomMode", false)
            }
            if (D) {
                if ("zoom" == this.option("zoomMode")) {
                    this.option("zoomPosition", "inner")
                }
            }
            if (x.jBrowser.mobile && "zoom" == this.option("zoomMode") && "inner" == this.option("zoomPosition")) {
                if (this.option("expand")) {
                    this.option("zoomMode", false)
                } else {
                    this.option("zoomOn", "click")
                }
            }
        },
        start: function(G) {
            var F;
            this.loadOptions(G);
            if (w && !this.option("autostart")) {
                return
            }
            this.id = this.placeholder.getAttribute("id") || "mz-" + Math.floor(Math.random() * x.now());
            this.placeholder.setAttribute("id", this.id);
            this.node = x.$new("figure").jAddClass("mz-figure");
            B(this.placeholder);
            this.originalImg = this.placeholder.querySelector("img");
            this.originalImgSrc = this.originalImg ? this.originalImg.getAttribute("src") : null;
            this.originalTitle = h(this.placeholder).getAttribute("title");
            h(this.placeholder).removeAttribute("title");
            this.primaryImage = new k().parseNode(this.placeholder, this.originalTitle, true);
            this.image = this.primaryImage;
            this.node.enclose(this.image.small.node).jAddClass(this.option("cssClass"));
            if (true !== this.option("rightClick")) {
                this.node.jAddEvent("contextmenu", function(H) {
                    H.stop();
                    return false
                })
            }
            this.node.jAddClass("mz-" + this.option("zoomOn") + "-zoom");
            if (!this.option("expand")) {
                this.node.jAddClass("mz-no-expand")
            }
            this.lens = {
                node: x.$new("div", {
                    "class": "mz-lens"
                }, {
                    top: 0
                }).jAppendTo(this.node),
                image: x.$new("img", {
                    src: "data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                }, {
                    position: "absolute",
                    top: 0,
                    left: 0
                }),
                width: 0,
                height: 0,
                pos: {
                    x: 0,
                    y: 0
                },
                spos: {
                    x: 0,
                    y: 0
                },
                size: {
                    width: 0,
                    height: 0
                },
                border: {
                    x: 0,
                    y: 0
                },
                dx: 0,
                dy: 0,
                innertouch: false,
                hide: function() {
                    if (x.jBrowser.features.transform) {
                        this.node.jSetCss({
                            transform: "translate(-10000px,-10000px)"
                        })
                    } else {
                        this.node.jSetCss({
                            top: -10000
                        })
                    }
                }
            };
            this.lens.hide();
            this.lens.node.append(this.lens.image);
            this.zoomBox = {
                node: x.$new("div", {
                    "class": "mz-zoom-window"
                }, {
                    top: -100000
                }).jAddClass(this.option("cssClass")).jAppendTo(E),
                image: x.$new("img", {
                    src: "data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                }, {
                    position: "absolute"
                }),
                aspectRatio: 0,
                width: 0,
                height: 0,
                innerWidth: 0,
                innerHeight: 0,
                size: {
                    width: "auto",
                    wunits: "px",
                    height: "auto",
                    hunits: "px"
                },
                mode: this.option("zoomMode"),
                position: this.option("zoomPosition"),
                custom: false,
                active: false,
                activating: false,
                enabled: false,
                enable: h(function() {
                    this.zoomBox.enabled = false !== arguments[0];
                    this.node[this.zoomBox.enabled ? "jRemoveClass" : "jAddClass"]("mz-no-zoom")
                }).jBind(this),
                hide: h(function() {
                    var H = h(this.node).jFetch("cr");
                    this.zoomBox.node.jRemoveEvent("transitionend");
                    this.zoomBox.node.jSetCss({
                        top: -100000
                    }).jAppendTo(E);
                    this.zoomBox.node.jRemoveClass("mz-deactivating mz-p-" + ("zoom" == this.zoomBox.mode ? this.zoomBox.position : this.zoomBox.mode));
                    if (!this.expanded && H) {
                        H.jRemove()
                    }
                    this.zoomBox.image.getAttribute("style");
                    this.zoomBox.image.removeAttribute("style")
                }).jBind(this),
                setMode: h(function(H) {
                    this.node[false === H ? "jAddClass" : "jRemoveClass"]("mz-no-zoom");
                    this.node["magnifier" == H ? "jAddClass" : "jRemoveClass"]("mz-magnifier-zoom");
                    this.zoomBox.node["magnifier" == H ? "jAddClass" : "jRemoveClass"]("mz-magnifier");
                    this.zoomBox.node["preview" == H ? "jAddClass" : "jRemoveClass"]("mz-preview");
                    if ("zoom" != H) {
                        this.node.jRemoveClass("mz-inner-zoom");
                        this.zoomBox.node.jRemoveClass("mz-inner")
                    }
                    this.zoomBox.mode = H;
                    if (false === H) {
                        this.zoomBox.enable(false)
                    } else {
                        if ("preview" === H) {
                            this.zoomBox.enable(true)
                        }
                    }
                }).jBind(this)
            };
            this.zoomBox.node.append(this.zoomBox.image);
            this.zoomBox.setMode(this.option("zoomMode"));
            this.zoomBox.image.removeAttribute("width");
            this.zoomBox.image.removeAttribute("height");
            if ("undefined" !== typeof(q)) {
                h(this.node).jStore("cr", x.$new(((Math.floor(Math.random() * 101) + 1) % 2) ? "span" : "div").jSetCss({
                    display: "inline",
                    overflow: "hidden",
                    visibility: "visible",
                    color: q[1],
                    fontSize: q[2],
                    fontWeight: q[3],
                    fontFamily: "sans-serif",
                    position: "absolute",
                    top: 8,
                    left: 8,
                    margin: "auto",
                    width: "auto",
                    textAlign: "right",
                    "line-height": "2em",
                    zIndex: 2147483647
                }).changeContent(u(q[0])));
                if (h(h(this.node).jFetch("cr")).byTag("a")[0]) {
                    h(h(h(this.node).jFetch("cr")).byTag("a")[0]).jAddEvent("tap btnclick", function(H) {
                        H.stopDistribution();
                        window.open(this.href)
                    })
                }
            }
            if ((F = ("" + this.option("zoomWidth")).match(/^([0-9]+)?(px|%)?$/))) {
                this.zoomBox.size.wunits = F[2] || "px";
                this.zoomBox.size.width = (parseFloat(F[1]) || "auto")
            }
            if ((F = ("" + this.option("zoomHeight")).match(/^([0-9]+)?(px|%)?$/))) {
                this.zoomBox.size.hunits = F[2] || "px";
                this.zoomBox.size.height = (parseFloat(F[1]) || "auto")
            }
            if ("magnifier" == this.zoomBox.mode) {
                this.node.jAddClass("mz-magnifier-zoom");
                this.zoomBox.node.jAddClass("mz-magnifier");
                if ("auto" === this.zoomBox.size.width) {
                    this.zoomBox.size.wunits = "%";
                    this.zoomBox.size.width = 70
                }
                if ("auto" === this.zoomBox.size.height) {
                    this.zoomBox.size.hunits = "%"
                }
            } else {
                if (this.option("zoom-position").match(/^#/)) {
                    if (this.zoomBox.custom = h(this.option("zoom-position").replace(/^#/, ""))) {
                        if (h(this.zoomBox.custom).jGetSize().height > 50) {
                            if ("auto" === this.zoomBox.size.width) {
                                this.zoomBox.size.wunits = "%";
                                this.zoomBox.size.width = 100
                            }
                            if ("auto" === this.zoomBox.size.height) {
                                this.zoomBox.size.hunits = "%";
                                this.zoomBox.size.height = 100
                            }
                        }
                    } else {
                        this.option("zoom-position", "right")
                    }
                }
                if ("preview" == this.zoomBox.mode) {
                    if ("auto" === this.zoomBox.size.width) {
                        this.zoomBox.size.wunits = "px"
                    }
                    if ("auto" === this.zoomBox.size.height) {
                        this.zoomBox.size.hunits = "px"
                    }
                }
                if ("zoom" == this.zoomBox.mode) {
                    if ("auto" === this.zoomBox.size.width || "inner" == this.option("zoom-position")) {
                        this.zoomBox.size.wunits = "%";
                        this.zoomBox.size.width = 100
                    }
                    if ("auto" === this.zoomBox.size.height || "inner" == this.option("zoom-position")) {
                        this.zoomBox.size.hunits = "%";
                        this.zoomBox.size.height = 100
                    }
                }
                if ("inner" == this.option("zoom-position")) {
                    this.node.jAddClass("mz-inner-zoom")
                }
            }
            this.zoomBox.position = this.zoomBox.custom ? "custom" : this.option("zoom-position");
            this.lens.border.x = parseFloat(this.lens.node.jGetCss("border-left-width") || "0");
            this.lens.border.y = parseFloat(this.lens.node.jGetCss("border-top-width") || "0");
            this.image.loadSmall(function() {
                if (2 !== this.image.small.state) {
                    return
                }
                this.image.setCurNode("small");
                this.size = this.image.node.jGetSize();
                this.registerEvents();
                this.ready = true;
                if (true === this.option("lazyZoom")) {
                    this.showHint()
                }
            }.jBind(this));
            if (true !== this.option("lazyZoom") || "always" == this.option("zoomOn")) {
                this.image.load(h(function(H) {
                    this.setupZoom(H, true)
                }).jBind(this));
                this.loadTimer = h(this.showLoading).jBind(this).jDelay(400)
            }
            this.setupSelectors()
        },
        stop: function() {
            this.unregisterEvents();
            if (this.zoomBox) {
                this.zoomBox.node.kill()
            }
            if (this.expandThumbs) {
                this.expandThumbs.stop();
                this.expandThumbs = null
            }
            if (this.expandBox) {
                this.expandBox.kill()
            }
            if (this.expanded) {
                h(x.jBrowser.getDoc()).jSetCss({
                    overflow: ""
                })
            }
            h(this.additionalImages).jEach(function(F) {
                h(F.origin).jRemoveClass("mz-thumb-selected").jRemoveClass(this.option("cssClass") || "mz-$dummy-css-class-to-jRemove$")
            }, this);
            if (this.originalImg) {
                this.placeholder.append(this.originalImg);
                if (this.originalImgSrc) {
                    this.originalImg.setAttribute("src", this.originalImgSrc)
                }
            }
            if (this.originalTitle) {
                this.placeholder.setAttribute("title", this.originalTitle)
            }
            if (this.node) {
                this.node.kill()
            }
        },
        setupZoom: function(H, I) {
            var G = this.initEvent,
                F = this.image;
            this.initEvent = null;
            if (2 !== H.zoom.state) {
                this.image = H;
                this.ready = true;
                this.zoomBox.enable(false);
                return
            }
            this.image = H;
            this.image.setCurNode(this.expanded ? "zoom" : "small");
            this.zoomBox.image.src = this.image.getURL("zoom");
            this.zoomBox.node.jRemoveClass("mz-preview");
            this.zoomBox.image.getAttribute("style");
            this.zoomBox.image.removeAttribute("style");
            this.zoomBox.node.jGetSize();
            setTimeout(h(function() {
                var K = this.zoomBox.image.jGetSize(),
                    J;
                this.zoomSizeOrigin = this.image.jGetSize("zoom");
                if (K.width * K.height > 1 && K.width * K.height < this.zoomSizeOrigin.width * this.zoomSizeOrigin.height) {
                    this.zoomSizeOrigin = K
                }
                this.zoomSize = x.detach(this.zoomSizeOrigin);
                if ("preview" == this.zoomBox.mode) {
                    this.zoomBox.node.jAddClass("mz-preview")
                }
                this.setCaption();
                this.lens.image.src = this.image.node.currentSrc || this.image.node.src;
                this.zoomBox.enable(this.zoomBox.mode && !(this.expanded && "preview" == this.zoomBox.mode));
                this.ready = true;
                this.activateTimer = null;
                this.resizeCallback();
                this.node.jAddClass("mz-ready");
                this.hideLoading();
                if (F !== this.image) {
                    r("onUpdate", this.id, F.origin, this.image.origin);
                    if (this.nextImage) {
                        J = this.nextImage;
                        this.nextImage = null;
                        this.update(J.image, J.onswipe)
                    }
                } else {
                    r("onZoomReady", this.id)
                }
                if (G) {
                    this.node.jCallEvent(G.type, G)
                } else {
                    if (this.expanded && "always" == this.option("expandZoomOn")) {
                        this.activate()
                    } else {
                        if (!!I) {
                            this.showHint()
                        }
                    }
                }
            }).jBind(this), 256)
        },
        setupSelectors: function() {
            var G = this.id,
                F, H;
            H = new RegExp("zoom\\-id(\\s+)?:(\\s+)?" + G + "($|;)");
            if (x.jBrowser.features.query) {
                F = x.$A(document.querySelectorAll('[data-zoom-id="' + this.id + '"]'));
                F = h(F).concat(x.$A(document.querySelectorAll('[rel*="zoom-id"]')).filter(function(I) {
                    return H.test(I.getAttribute("rel") || "")
                }))
            } else {
                F = x.$A(document.getElementsByTagName("A")).filter(function(I) {
                    return G == I.getAttribute("data-zoom-id") || H.test(I.getAttribute("rel") || "")
                })
            }
            h(F).jEach(function(J) {
                var I, K;
                h(J).jAddEvent("click", function(L) {
                    L.stopDefaults()
                });
                I = new k().parseNode(J, this.originalTitle);
                if (this.image.zoom.src.has(I.zoom.src) && this.image.small.src.has(I.small.src)) {
                    h(I.origin).jAddClass("mz-thumb-selected");
                    I = this.image;
                    I.origin = J
                }
                if (!I.link && this.image.link) {
                    I.link = this.image.link
                }
                K = h(function() {
                    this.update(I)
                }).jBind(this);
                h(J).jAddEvent("mousedown", function(L) {
                    if ("stopImmediatePropagation" in L) {
                        L.stopImmediatePropagation()
                    }
                }, 5);
                h(J).jAddEvent("tap " + ("hover" == this.option("selectorTrigger") ? "mouseover mouseout" : "btnclick"), h(function(M, L) {
                    if (this.updateTimer) {
                        clearTimeout(this.updateTimer)
                    }
                    this.updateTimer = false;
                    if ("mouseover" == M.type) {
                        this.updateTimer = h(K).jDelay(L)
                    } else {
                        if ("tap" == M.type || "btnclick" == M.type) {
                            K()
                        }
                    }
                }).jBindAsEvent(this, 60)).jAddClass(this.option("cssClass")).jAddClass("mz-thumb");
                I.loadSmall();
                if (true !== this.option("lazyZoom")) {
                    I.loadZoom()
                }
                this.additionalImages.push(I)
            }, this)
        },
        update: function(F, G) {
            if (!this.ready) {
                this.nextImage = {
                    image: F,
                    onswipe: G
                };
                return
            }
            if (!F || F === this.image) {
                return false
            }
            this.deactivate(null, true);
            this.ready = false;
            this.node.jRemoveClass("mz-ready");
            this.loadTimer = h(this.showLoading).jBind(this).jDelay(400);
            F.load(h(function(N) {
                var H, O, M, J, I, L, K = (x.jBrowser.ieMode < 10) ? "jGetSize" : "getBoundingClientRect";
                this.hideLoading();
                N.setCurNode("small");
                if (!N.node) {
                    this.ready = true;
                    this.node.jAddClass("mz-ready");
                    return
                }
                this.setActiveThumb(N);
                H = this.image.node[K]();
                if (this.expanded) {
                    N.setCurNode("zoom");
                    M = x.$new("div").jAddClass("mz-expand-bg");
                    if (x.jBrowser.features.cssFilters || x.jBrowser.ieMode < 10) {
                        M.append(x.$new("img", {
                            src: N.getURL("zoom")
                        }).jSetCss({
                            opacity: 0
                        }))
                    } else {
                        M.append(new x.SVGImage(N.node).blur(b).getNode().jSetCss({
                            opacity: 0
                        }))
                    }
                    h(M).jSetCss({
                        "z-index": -99
                    }).jAppendTo(this.expandBox)
                }
                if (this.expanded && "zoom" === this.zoomBox.mode && "always" === this.option("expandZoomOn")) {
                    h(N.node).jSetCss({
                        opacity: 0
                    }).jAppendTo(this.node);
                    O = H;
                    I = [N.node, this.image.node];
                    L = [{
                        opacity: [0, 1]
                    }, {
                        opacity: [1, 0]
                    }];
                    h(N.node).jSetCss({
                        "max-width": Math.min(N.jGetSize("zoom").width, this.expandMaxWidth()),
                        "max-height": Math.min(N.jGetSize("zoom").height, this.expandMaxHeight())
                    })
                } else {
                    this.node.jSetCss({
                        height: this.node[K]().height
                    });
                    this.image.node.jSetCss({
                        position: "absolute",
                        top: 0,
                        left: 0,
                        bottom: 0,
                        right: 0,
                        width: "100%",
                        height: "100%",
                        "max-width": "",
                        "max-height": ""
                    });
                    h(N.node).jSetCss({
                        "max-width": Math.min(N.jGetSize(this.expanded ? "zoom" : "small").width, this.expanded ? this.expandMaxWidth() : Infinity),
                        "max-height": Math.min(N.jGetSize(this.expanded ? "zoom" : "small").height, this.expanded ? this.expandMaxHeight() : Infinity),
                        position: "relative",
                        top: 0,
                        left: 0,
                        opacity: 0,
                        transform: ""
                    }).jAppendTo(this.node);
                    O = h(N.node)[K]();
                    if (!G) {
                        h(N.node).jSetCss({
                            "min-width": H.width,
                            height: H.height,
                            "max-width": H.width,
                            "max-height": ""
                        })
                    }
                    this.node.jSetCss({
                        height: "",
                        overflow: ""
                    }).jGetSize();
                    h(N.node).jGetSize();
                    I = [N.node, this.image.node];
                    L = [x.extend({
                        opacity: [0, 1]
                    }, G ? {
                        scale: [0.6, 1]
                    } : {
                        "min-width": [H.width, O.width],
                        "max-width": [H.width, O.width],
                        height: [H.height, O.height]
                    }), {
                        opacity: [1, 0]
                    }]
                }
                if (this.expanded) {
                    if (this.expandBg.firstChild && M.firstChild) {
                        J = h(this.expandBg.firstChild).jGetCss("opacity");
                        if (x.jBrowser.gecko) {
                            I = I.concat([M.firstChild]);
                            L = L.concat([{
                                opacity: [0.0001, J]
                            }])
                        } else {
                            I = I.concat([M.firstChild, this.expandBg.firstChild]);
                            L = L.concat([{
                                opacity: [0.0001, J]
                            }, {
                                opacity: [J, 0.0001]
                            }])
                        }
                    }
                }
                new x.PFX(I, {
                    duration: (G || this.option("transitionEffect")) ? G ? 400 : 350 : 0,
                    transition: G ? "cubic-bezier(0.175, 0.885, 0.320, 1.275)" : (H.width == O.width) ? "linear" : "cubic-bezier(0.25, .1, .1, 1)",
                    onComplete: h(function() {
                        this.image.node.jRemove().getAttribute("style");
                        this.image.node.removeAttribute("style");
                        h(N.node).jSetCss(this.expanded ? {
                            width: "auto",
                            height: "auto"
                        } : {
                            width: "",
                            height: ""
                        }).jSetCss({
                            "min-width": "",
                            "min-height": "",
                            opacity: "",
                            "max-width": Math.min(N.jGetSize(this.expanded ? "zoom" : "small").width, this.expanded ? this.expandMaxWidth() : Infinity),
                            "max-height": Math.min(N.jGetSize(this.expanded ? "zoom" : "small").height, this.expanded ? this.expandMaxHeight() : Infinity)
                        });
                        if (this.expanded) {
                            this.expandBg.jRemove();
                            this.expandBg = undefined;
                            this.expandBg = M.jSetCssProp("z-index", -100);
                            h(this.expandBg.firstChild).jSetCss({
                                opacity: ""
                            });
                            if (this.expandCaption) {
                                if (N.caption) {
                                    if (N.link) {
                                        this.expandCaption.changeContent("").append(x.$new("a", {
                                            href: N.link
                                        }).jAddEvent("tap btnclick", this.openLink.jBind(this)).changeContent(N.caption))
                                    } else {
                                        this.expandCaption.changeContent(N.caption).jAddClass("mz-show")
                                    }
                                } else {
                                    this.expandCaption.jRemoveClass("mz-show")
                                }
                            }
                        }
                        this.setupZoom(N)
                    }).jBind(this),
                    onBeforeRender: h(function(P, Q) {
                        if (undefined !== P.scale) {
                            Q.jSetCssProp("transform", "scale(" + P.scale + ")")
                        }
                    })
                }).start(L)
            }).jBind(this))
        },
        setActiveThumb: function(G) {
            var F = false;
            h(this.additionalImages).jEach(function(H) {
                h(H.origin).jRemoveClass("mz-thumb-selected");
                if (H === G) {
                    F = true
                }
            });
            if (F && G.origin) {
                h(G.origin).jAddClass("mz-thumb-selected")
            }
            if (this.expandThumbs) {
                this.expandThumbs.selectItem(G.selector)
            }
        },
        setCaption: function(F) {
            if (this.image.caption && "off" !== this.option("zoomCaption") && "magnifier" !== this.zoomBox.mode) {
                if (!this.zoomBox.caption) {
                    this.zoomBox.caption = x.$new("div", {
                        "class": "mz-caption"
                    }).jAppendTo(this.zoomBox.node.jAddClass("caption-" + this.option("zoomCaption")))
                }
                this.zoomBox.caption.changeContent(this.image.caption)
            }
        },
        showHint: function(F, H) {
            var G;
            if (!this.expanded) {
                if (this.hintRuns <= 0) {
                    return
                }
                this.hintRuns--
            }
            if (undefined === H) {
                if (!this.zoomBox.active && !this.zoomBox.activating) {
                    if (this.option("zoomMode")) {
                        if ("hover" == this.option("zoomOn")) {
                            H = this.option("textHoverZoomHint")
                        } else {
                            if ("click" == this.option("zoomOn")) {
                                H = this.option("textClickZoomHint")
                            }
                        }
                    } else {
                        H = this.option("expand") ? this.option("textExpandHint") : ""
                    }
                } else {
                    H = this.option("expand") ? this.option("textExpandHint") : ""
                }
            }
            if (!H) {
                this.hideHint();
                return
            }
            G = this.node;
            if (!this.hint) {
                this.hint = x.$new("div", {
                    "class": "mz-hint"
                });
                this.hintMessage = x.$new("span", {
                    "class": "mz-hint-message"
                }).append(document.createTextNode(H)).jAppendTo(this.hint);
                h(this.hint).jAppendTo(this.node)
            } else {
                h(this.hintMessage).changeContent(H)
            }
            this.hint.jSetCss({
                "transition-delay": ""
            }).jRemoveClass("mz-hint-hidden");
            if (this.expanded) {
                G = this.expandFigure
            } else {
                if ((this.zoomBox.active || this.zoomBox.activating) && "magnifier" !== this.zoomBox.mode && "inner" == this.zoomBox.position) {
                    G = this.zoomBox.node
                }
            }
            if (true === F) {
                setTimeout(h(function() {
                    this.hint.jAddClass("mz-hint-hidden")
                }).jBind(this), 16)
            }
            this.hint.jAppendTo(G)
        },
        hideHint: function() {
            if (this.hint) {
                this.hint.jSetCss({
                    "transition-delay": "0ms"
                }).jAddClass("mz-hint-hidden")
            }
        },
        showLoading: function() {
            if (!this.loadingBox) {
                this.loadingBox = x.$new("div", {
                    "class": "mz-loading"
                });
                this.node.append(this.loadingBox);
                this.loadingBox.jGetSize()
            }
            this.loadingBox.jAddClass("shown")
        },
        hideLoading: function() {
            clearTimeout(this.loadTimer);
            this.loadTimer = null;
            if (this.loadingBox) {
                h(this.loadingBox).jRemoveClass("shown")
            }
        },
        setSize: function(H, L) {
            var K = x.detach(this.zoomBox.size),
                J = (!this.expanded && this.zoomBox.custom) ? h(this.zoomBox.custom).jGetSize() : {
                    width: 0,
                    height: 0
                },
                G, F, I = this.size,
                M = {
                    x: 0,
                    y: 0
                };
            L = L || this.zoomBox.position;
            this.normalSize = this.image.node.jGetSize();
            this.size = this.image.node.jGetSize();
            this.boundaries = this.image.node.getBoundingClientRect();
            if (!J.height) {
                J = this.size
            }
            if (false === this.option("upscale") || false === this.zoomBox.mode || "preview" === this.zoomBox.mode) {
                H = false
            }
            if ("preview" == this.zoomBox.mode) {
                if ("auto" === K.width) {
                    K.width = this.zoomSizeOrigin.width
                }
                if ("auto" === K.height) {
                    K.height = this.zoomSizeOrigin.height
                }
            }
            if (this.expanded && "magnifier" == this.zoomBox.mode) {
                K.width = 70;
                K.height = "auto"
            }
            if ("magnifier" == this.zoomBox.mode && "auto" === K.height) {
                this.zoomBox.width = parseFloat(K.width / 100) * Math.min(J.width, J.height);
                this.zoomBox.height = this.zoomBox.width
            } else {
                if ("zoom" == this.zoomBox.mode && "inner" == L) {
                    this.size = this.node.jGetSize();
                    J = this.size;
                    this.boundaries = this.node.getBoundingClientRect();
                    this.zoomBox.width = J.width;
                    this.zoomBox.height = J.height
                } else {
                    this.zoomBox.width = ("%" === K.wunits) ? parseFloat(K.width / 100) * J.width : parseInt(K.width);
                    this.zoomBox.height = ("%" === K.hunits) ? parseFloat(K.height / 100) * J.height : parseInt(K.height)
                }
            }
            if ("preview" == this.zoomBox.mode) {
                F = Math.min(Math.min(this.zoomBox.width / this.zoomSizeOrigin.width, this.zoomBox.height / this.zoomSizeOrigin.height), 1);
                this.zoomBox.width = this.zoomSizeOrigin.width * F;
                this.zoomBox.height = this.zoomSizeOrigin.height * F
            }
            this.zoomBox.width = Math.ceil(this.zoomBox.width);
            this.zoomBox.height = Math.ceil(this.zoomBox.height);
            this.zoomBox.aspectRatio = this.zoomBox.width / this.zoomBox.height;
            this.zoomBox.node.jSetCss({
                width: this.zoomBox.width,
                height: this.zoomBox.height
            });
            if (H) {
                J = this.expanded ? this.expandBox.jGetSize() : this.zoomBox.node.jGetSize();
                if (!this.expanded && (this.normalSize.width * this.normalSize.height) / (this.zoomSizeOrigin.width * this.zoomSizeOrigin.height) > 0.8) {
                    this.zoomSize.width = 1.5 * this.zoomSizeOrigin.width;
                    this.zoomSize.height = 1.5 * this.zoomSizeOrigin.height
                } else {
                    this.zoomSize = x.detach(this.zoomSizeOrigin)
                }
            }
            if (false !== this.zoomBox.mode && !this.zoomBox.active && !(this.expanded && "always" == this.option("expandZoomOn"))) {
                if ((this.normalSize.width * this.normalSize.height) / (this.zoomSize.width * this.zoomSize.height) > 0.8) {
                    this.zoomSize = x.detach(this.zoomSizeOrigin);
                    this.zoomBox.enable(false)
                } else {
                    this.zoomBox.enable(true)
                }
            }
            this.zoomBox.image.jSetCss({
                width: this.zoomSize.width,
                height: this.zoomSize.height
            });
            G = this.zoomBox.node.getInnerSize();
            this.zoomBox.innerWidth = Math.ceil(G.width);
            this.zoomBox.innerHeight = Math.ceil(G.height);
            this.lens.width = Math.ceil(this.zoomBox.innerWidth / (this.zoomSize.width / this.size.width));
            this.lens.height = Math.ceil(this.zoomBox.innerHeight / (this.zoomSize.height / this.size.height));
            this.lens.node.jSetCss({
                width: this.lens.width,
                height: this.lens.height
            });
            this.lens.image.jSetCss(this.size);
            x.extend(this.lens, this.lens.node.jGetSize());
            if (this.zoomBox.active) {
                clearTimeout(this.moveTimer);
                this.moveTimer = null;
                if (this.lens.innertouch) {
                    this.lens.pos.x *= (this.size.width / I.width);
                    this.lens.pos.y *= (this.size.height / I.height);
                    M.x = this.lens.spos.x;
                    M.y = this.lens.spos.y
                } else {
                    M.x = this.boundaries.left + this.lens.width / 2 + (this.lens.pos.x * (this.size.width / I.width));
                    M.y = this.boundaries.top + this.lens.height / 2 + (this.lens.pos.y * (this.size.height / I.height))
                }
                this.animate(null, M)
            }
        },
        reflowZoom: function(J) {
            var M, L, F, K, I, H, G = h(this.node).jFetch("cr");
            F = a(5);
            I = this.zoomBox.position;
            K = this.expanded ? "inner" : this.zoomBox.custom ? "custom" : this.option("zoom-position");
            H = this.expanded && "zoom" == this.zoomBox.mode ? this.expandBox : document.body;
            if (this.expanded) {
                F.y = 0;
                F.x = 0
            }
            if (!J) {
                this.setSize(true, K)
            }
            if (!this.zoomBox.activating && !this.zoomBox.active) {
                return
            }
            M = this.boundaries.top;
            if ("magnifier" !== this.zoomBox.mode) {
                if (J) {
                    this.setSize(false);
                    return
                }
                switch (K) {
                    case "inner":
                    case "custom":
                        M = 0;
                        L = 0;
                        break;
                    case "top":
                        M = this.boundaries.top - this.zoomBox.height - this.option("zoom-distance");
                        if (F.top > M) {
                            M = this.boundaries.bottom + this.option("zoom-distance");
                            K = "bottom"
                        }
                        L = this.boundaries.left;
                        break;
                    case "bottom":
                        M = this.boundaries.bottom + this.option("zoom-distance");
                        if (F.bottom < M + this.zoomBox.height) {
                            M = this.boundaries.top - this.zoomBox.height - this.option("zoom-distance");
                            K = "top"
                        }
                        L = this.boundaries.left;
                        break;
                    case "left":
                        L = this.boundaries.left - this.zoomBox.width - this.option("zoom-distance");
                        if (F.left > L && F.right >= this.boundaries.right + this.option("zoom-distance") + this.zoomBox.width) {
                            L = this.boundaries.right + this.option("zoom-distance");
                            K = "right"
                        }
                        break;
                    case "right":
                    default:
                        L = this.boundaries.right + this.option("zoom-distance");
                        if (F.right < L + this.zoomBox.width && F.left <= this.boundaries.left - this.zoomBox.width - this.option("zoom-distance")) {
                            L = this.boundaries.left - this.zoomBox.width - this.option("zoom-distance");
                            K = "left"
                        }
                        break
                }
                switch (this.option("zoom-position")) {
                    case "top":
                    case "bottom":
                        if (F.top > M || F.bottom < M + this.zoomBox.height) {
                            K = "inner"
                        }
                        break;
                    case "left":
                    case "right":
                        if (F.left > L || F.right < L + this.zoomBox.width) {
                            K = "inner"
                        }
                        break
                }
                this.zoomBox.position = K;
                this.setSize(false);
                if (J) {
                    return
                }
                if ("custom" == K) {
                    H = this.zoomBox.custom;
                    F.y = 0;
                    F.x = 0
                }
                if ("inner" == K) {
                    if ("preview" !== this.zoomBox.mode) {
                        this.zoomBox.node.jAddClass("mz-inner");
                        this.node.jAddClass("mz-inner-zoom")
                    }
                    this.lens.hide();
                    M = this.boundaries.top + F.y;
                    L = this.boundaries.left + F.x;
                    if (!this.expanded && x.jBrowser.ieMode && x.jBrowser.ieMode < 11) {
                        M = 0;
                        L = 0;
                        H = this.node
                    }
                } else {
                    M += F.y;
                    L += F.x;
                    this.node.jRemoveClass("mz-inner-zoom");
                    this.zoomBox.node.jRemoveClass("mz-inner")
                }
                this.zoomBox.node.jSetCss({
                    top: M,
                    left: L
                })
            } else {
                this.setSize(false);
                if (x.jBrowser.ieMode && x.jBrowser.ieMode < 11) {
                    H = this.node
                }
            }
            this.zoomBox.node[this.expanded ? "jAddClass" : "jRemoveClass"]("mz-expanded");
            if (!this.expanded && G) {
                G.jAppendTo("zoom" == this.zoomBox.mode && "inner" == K ? this.zoomBox.node : this.node, ((Math.floor(Math.random() * 101) + 1) % 2) ? "top" : "bottom")
            }
            this.zoomBox.node.jAppendTo(H)
        },
        changeZoomLevel: function(L) {
            var H, F, J, I, K = false,
                G = L.isMouse ? 5 : 3 / 54;
            h(L).stop();
            G = (100 + G * Math.abs(L.deltaY)) / 100;
            if (L.deltaY < 0) {
                G = 1 / G
            }
            if ("magnifier" == this.zoomBox.mode) {
                F = Math.max(100, Math.round(this.zoomBox.width * G));
                F = Math.min(F, this.size.width * 0.9);
                J = F / this.zoomBox.aspectRatio;
                this.zoomBox.width = Math.ceil(F);
                this.zoomBox.height = Math.ceil(J);
                this.zoomBox.node.jSetCss({
                    width: this.zoomBox.width,
                    height: this.zoomBox.height
                });
                H = this.zoomBox.node.getInnerSize();
                this.zoomBox.innerWidth = Math.ceil(H.width);
                this.zoomBox.innerHeight = Math.ceil(H.height);
                K = true
            } else {
                if (!this.expanded && "zoom" == this.zoomBox.mode) {
                    F = Math.max(50, Math.round(this.lens.width * G));
                    F = Math.min(F, this.size.width * 0.9);
                    J = F / this.zoomBox.aspectRatio;
                    this.zoomSize.width = Math.ceil((this.zoomBox.innerWidth / F) * this.size.width);
                    this.zoomSize.height = Math.ceil((this.zoomBox.innerHeight / J) * this.size.height);
                    this.zoomBox.image.jSetCss({
                        width: this.zoomSize.width,
                        height: this.zoomSize.height
                    })
                } else {
                    return
                }
            }
            I = h(window).jGetScroll();
            this.lens.width = Math.ceil(this.zoomBox.innerWidth / (this.zoomSize.width / this.size.width));
            this.lens.height = Math.ceil(this.zoomBox.innerHeight / (this.zoomSize.height / this.size.height));
            this.lens.node.jSetCss({
                width: this.lens.width,
                height: this.lens.height
            });
            x.extend(this.lens, this.lens.node.jGetSize());
            if (this.zoomBox.active) {
                clearTimeout(this.moveTimer);
                this.moveTimer = null;
                if (K) {
                    this.moveTimer = true
                }
                this.animate(null, {
                    x: L.x - I.x,
                    y: L.y - I.y
                });
                if (K) {
                    this.moveTimer = null
                }
            }
        },
        registerActivateEvent: function(H) {
            var G, F = H ? "dbltap btnclick" : "touchstart" + (!x.jBrowser.mobile ? (window.navigator.pointerEnabled ? " pointermove" : window.navigator.msPointerEnabled ? " MSPointerMove" : " mousemove") : ""),
                I = this.node.jFetch("mz:handlers:activate:fn", (!H) ? h(function(J) {
                    G = (x.jBrowser.ieMode < 9) ? x.extend({}, J) : J;
                    if (!this.activateTimer) {
                        clearTimeout(this.activateTimer);
                        this.activateTimer = setTimeout(h(function() {
                            this.activate(G)
                        }).jBind(this), 120)
                    }
                }).jBindAsEvent(this) : h(this.activate).jBindAsEvent(this));
            this.node.jStore("mz:handlers:activate:event", F).jAddEvent(F, I, 10)
        },
        unregisterActivateEvent: function(G) {
            var F = this.node.jFetch("mz:handlers:activate:event"),
                H = this.node.jFetch("mz:handlers:activate:fn");
            this.node.jRemoveEvent(F, H);
            this.node.jDel("mz:handlers:activate:fn")
        },
        registerDeactivateEvent: function(G) {
            var F = G ? "dbltap btnclick" : "touchend" + (!x.jBrowser.mobile ? (window.navigator.pointerEnabled ? " pointerout" : window.navigator.msPointerEnabled ? " MSPointerOut" : " mouseout") : ""),
                H = this.node.jFetch("mz:handlers:deactivate:fn", h(function(I) {
                    if (c(I) && !g(I)) {
                        return
                    }
                    if (this.zoomBox.node !== I.getRelated() && !(("inner" == this.zoomBox.position || "magnifier" == this.zoomBox.mode) && this.zoomBox.node.hasChild(I.getRelated())) && !this.node.hasChild(I.getRelated())) {
                        this.deactivate(I)
                    }
                }).jBindAsEvent(this));
            this.node.jStore("mz:handlers:deactivate:event", F).jAddEvent(F, H, 20)
        },
        unregisterDeactivateEvent: function() {
            var F = this.node.jFetch("mz:handlers:deactivate:event"),
                G = this.node.jFetch("mz:handlers:deactivate:fn");
            this.node.jRemoveEvent(F, G);
            this.node.jDel("mz:handlers:deactivate:fn")
        },
        registerEvents: function() {
            this.moveBind = this.move.jBind(this);
            this.node.jAddEvent(["touchstart", window.navigator.pointerEnabled ? "pointerdown" : "MSPointerDown"], h(function(F) {
                if ((x.jBrowser.androidBrowser || "android" === x.jBrowser.platform && x.jBrowser.gecko) && this.option("zoomMode") && "click" !== this.option("zoomOn") && "touchstart" === F.type) {
                    F.stopDefaults();
                    if (x.jBrowser.gecko) {
                        F.stopDistribution()
                    }
                }
                if (!this.zoomBox.active) {
                    return
                }
                if ("inner" === this.zoomBox.position) {
                    this.lens.spos = F.getClientXY()
                }
            }).jBindAsEvent(this), 10);
            this.node.jAddEvent(["touchend", window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp"], h(function(F) {
                if (c(F) && g(F)) {
                    this.lens.touchmovement = false
                }
            }).jBindAsEvent(this), 10);
            this.node.jAddEvent("touchmove " + ("android" === x.jBrowser.platform ? "" : window.navigator.pointerEnabled ? "pointermove" : window.navigator.msPointerEnabled ? "MSPointerMove" : "mousemove"), h(this.animate).jBindAsEvent(this));
            if (this.option("zoomMode")) {
                this.registerActivateEvent("click" === this.option("zoomOn"));
                this.registerDeactivateEvent("click" === this.option("zoomOn") && !this.option("expand"))
            }
            this.node.jAddEvent("mousedown", function(F) {
                F.stopDistribution()
            }, 10).jAddEvent("btnclick", h(function(F) {
                this.node.jRaiseEvent("MouseEvent", "click");
                if (this.expanded) {
                    this.expandBox.jCallEvent("btnclick", F)
                }
            }).jBind(this), 15);
            if (this.option("expand")) {
                this.node.jAddEvent("tap btnclick", h(this.expand).jBindAsEvent(this), 15)
            } else {
                this.node.jAddEvent("tap btnclick", h(this.openLink).jBindAsEvent(this), 15)
            }
            if (this.additionalImages.length > 1) {
                this.swipe()
            }
            if (!x.jBrowser.mobile && this.option("variableZoom")) {
                this.node.jAddEvent("mousescroll", this.changeZoomLevel.jBindAsEvent(this))
            }
            h(window).jAddEvent("resize scroll", this.onResize)
        },
        unregisterEvents: function() {
            if (this.node) {
                this.node.jRemoveEvent("mousescroll")
            }
            h(window).jRemoveEvent("resize scroll", this.onResize);
            h(this.additionalImages).jEach(function(F) {
                h(F.origin).jClearEvents()
            })
        },
        activate: function(L) {
            var M, K, I, J, F, G = 0,
                H = 0;
            if (!this.ready || !this.zoomBox.enabled || this.zoomBox.active || this.zoomBox.activating) {
                if (!this.image.loaded()) {
                    if (L) {
                        this.initEvent = x.extend({}, L);
                        L.stopQueue()
                    }
                    this.image.load(this.setupZoom.jBind(this));
                    if (!this.loadTimer) {
                        this.loadTimer = h(this.showLoading).jBind(this).jDelay(400)
                    }
                }
                return
            }
            if (L && "pointermove" == L.type && "touch" == L.pointerType) {
                return
            }
            if (!this.option("zoomMode") && this.option("expand") && !this.expanded) {
                this.zoomBox.active = true;
                return
            }
            this.zoomBox.activating = true;
            if (this.expanded && "zoom" == this.zoomBox.mode) {
                J = this.image.node.jGetRect();
                this.expandStage.jAddClass("mz-zoom-in");
                F = this.expandFigure.jGetRect();
                H = ((J.left + J.right) / 2 - (F.left + F.right) / 2);
                G = ((J.top + J.bottom) / 2 - (F.top + F.bottom) / 2)
            }
            this.zoomBox.image.jRemoveEvent("transitionend");
            this.zoomBox.node.jRemoveClass("mz-deactivating").jRemoveEvent("transitionend");
            this.zoomBox.node.jAddClass("mz-activating");
            this.node.jAddClass("mz-activating");
            this.reflowZoom();
            K = ("zoom" == this.zoomBox.mode) ? this.zoomBox.position : this.zoomBox.mode;
            if (x.jBrowser.features.transition && !(this.expanded && "always" == this.option("expandZoomOn"))) {
                if ("inner" == K) {
                    I = this.image.node.jGetSize();
                    this.zoomBox.image.jSetCss({
                        transform: "translate3d(0," + G + "px, 0) scale(" + I.width / this.zoomSize.width + ", " + I.height / this.zoomSize.height + ")"
                    }).jGetSize();
                    this.zoomBox.image.jAddEvent("transitionend", h(function() {
                        this.zoomBox.image.jRemoveEvent("transitionend");
                        this.zoomBox.node.jRemoveClass("mz-activating mz-p-" + K);
                        this.zoomBox.activating = false;
                        this.zoomBox.active = true
                    }).jBind(this));
                    this.zoomBox.node.jAddClass("mz-p-" + K).jGetSize();
                    if (!x.jBrowser.mobile && x.jBrowser.chrome && ("chrome" === x.jBrowser.uaName || "opera" === x.jBrowser.uaName)) {
                        this.zoomBox.activating = false;
                        this.zoomBox.active = true
                    }
                } else {
                    this.zoomBox.node.jAddEvent("transitionend", h(function() {
                        this.zoomBox.node.jRemoveEvent("transitionend");
                        this.zoomBox.node.jRemoveClass("mz-activating mz-p-" + K)
                    }).jBind(this));
                    this.zoomBox.node.jAddClass("mz-p-" + K).jGetSize();
                    this.zoomBox.node.jRemoveClass("mz-p-" + K);
                    this.zoomBox.activating = false;
                    this.zoomBox.active = true
                }
            } else {
                this.zoomBox.node.jRemoveClass("mz-activating");
                this.zoomBox.activating = false;
                this.zoomBox.active = true
            }
            if (!this.expanded) {
                this.showHint(true)
            }
            if (L) {
                L.stop().stopQueue();
                M = L.getClientXY();
                if ("magnifier" == this.zoomBox.mode && (/tap/i).test(L.type)) {
                    M.y -= this.zoomBox.height / 2 + 10
                }
                if ("inner" == K && ((/tap/i).test(L.type) || c(L))) {
                    this.lens.pos = {
                        x: 0,
                        y: 0
                    };
                    M.x = -(M.x - this.boundaries.left - this.size.width / 2) * (this.zoomSize.width / this.size.width);
                    M.y = -(M.y - this.boundaries.top - this.size.height / 2) * (this.zoomSize.height / this.size.height)
                }
            } else {
                M = {
                    x: this.boundaries.left + (this.boundaries.right - this.boundaries.left) / 2,
                    y: this.boundaries.top + (this.boundaries.bottom - this.boundaries.top) / 2
                }
            }
            this.node.jRemoveClass("mz-activating").jAddClass("mz-active");
            M.x += -H;
            M.y += -G;
            this.lens.spos = {
                x: 0,
                y: 0
            };
            this.lens.dx = 0;
            this.lens.dy = 0;
            this.animate(L, M, true);
            r("onZoomIn", this.id)
        },
        deactivate: function(H, M) {
            var K, I, F, G, J = 0,
                L = 0,
                N = this.zoomBox.active;
            this.initEvent = null;
            if (!this.ready) {
                return
            }
            if (H && "pointerout" == H.type && "touch" == H.pointerType) {
                return
            }
            clearTimeout(this.moveTimer);
            this.moveTimer = null;
            clearTimeout(this.activateTimer);
            this.activateTimer = null;
            this.zoomBox.activating = false;
            this.zoomBox.active = false;
            if (true !== M && !this.expanded) {
                if (N) {
                    this.showHint()
                }
            }
            if (!this.zoomBox.enabled) {
                return
            }
            if (H) {
                H.stop()
            }
            this.zoomBox.image.jRemoveEvent("transitionend");
            this.zoomBox.node.jRemoveClass("mz-activating").jRemoveEvent("transitionend");
            if (this.expanded) {
                G = this.expandFigure.jGetRect();
                if ("always" !== this.option("expandZoomOn")) {
                    this.expandStage.jRemoveClass("mz-zoom-in")
                }
                this.image.node.jSetCss({
                    "max-height": this.expandMaxHeight()
                });
                F = this.image.node.jGetRect();
                L = ((F.left + F.right) / 2 - (G.left + G.right) / 2);
                J = ((F.top + F.bottom) / 2 - (G.top + G.bottom) / 2)
            }
            K = ("zoom" == this.zoomBox.mode) ? this.zoomBox.position : this.zoomBox.mode;
            if (x.jBrowser.features.transition && H && !(this.expanded && "always" == this.option("expandZoomOn"))) {
                if ("inner" == K) {
                    this.zoomBox.image.jAddEvent("transitionend", h(function() {
                        this.zoomBox.image.jRemoveEvent("transitionend");
                        this.node.jRemoveClass("mz-active");
                        setTimeout(h(function() {
                            this.zoomBox.hide()
                        }).jBind(this), 32)
                    }).jBind(this));
                    I = this.image.node.jGetSize();
                    this.zoomBox.node.jAddClass("mz-deactivating mz-p-" + K).jGetSize();
                    this.zoomBox.image.jSetCss({
                        transform: "translate3d(0," + J + "px,0) scale(" + I.width / this.zoomSize.width + ", " + I.height / this.zoomSize.height + ")"
                    })
                } else {
                    this.zoomBox.node.jAddEvent("transitionend", h(function() {
                        this.zoomBox.hide();
                        this.node.jRemoveClass("mz-active")
                    }).jBind(this));
                    this.zoomBox.node.jGetCss("opacity");
                    this.zoomBox.node.jAddClass("mz-deactivating mz-p-" + K);
                    this.node.jRemoveClass("mz-active")
                }
            } else {
                this.zoomBox.hide();
                this.node.jRemoveClass("mz-active")
            }
            this.lens.dx = 0;
            this.lens.dy = 0;
            this.lens.spos = {
                x: 0,
                y: 0
            };
            this.lens.hide();
            if (N) {
                r("onZoomOut", this.id)
            }
        },
        animate: function(P, O, N) {
            var H = O,
                J, I, L = 0,
                G, K = 0,
                F, Q, M = false;
            if (this.initEvent && !this.image.loaded()) {
                this.initEvent = P
            }
            if (!this.zoomBox.active && !N) {
                return
            }
            if (P) {
                h(P).stopDefaults().stopDistribution();
                if (c(P) && !g(P)) {
                    return
                }
                M = (/tap/i).test(P.type) || c(P);
                if (M && !this.lens.touchmovement) {
                    this.lens.touchmovement = M
                }
                if (!H) {
                    H = P.getClientXY()
                }
            }
            if ("preview" == this.zoomBox.mode) {
                return
            }
            if ("zoom" == this.zoomBox.mode && "inner" === this.zoomBox.position && (P && M || !P && this.lens.innertouch)) {
                this.lens.innertouch = true;
                J = this.lens.pos.x + (H.x - this.lens.spos.x);
                I = this.lens.pos.y + (H.y - this.lens.spos.y);
                this.lens.spos = H;
                L = Math.min(0, this.zoomBox.innerWidth - this.zoomSize.width) / 2;
                G = -L;
                K = Math.min(0, this.zoomBox.innerHeight - this.zoomSize.height) / 2;
                F = -K
            } else {
                this.lens.innertouch = false;
                J = H.x - this.boundaries.left;
                I = H.y - this.boundaries.top;
                G = this.size.width - this.lens.width;
                F = this.size.height - this.lens.height;
                J -= this.lens.width / 2;
                I -= this.lens.height / 2
            }
            if ("magnifier" !== this.zoomBox.mode) {
                J = Math.max(L, Math.min(J, G));
                I = Math.max(K, Math.min(I, F))
            }
            this.lens.pos.x = J = Math.round(J);
            this.lens.pos.y = I = Math.round(I);
            if ("zoom" == this.zoomBox.mode && "inner" != this.zoomBox.position) {
                if (x.jBrowser.features.transform) {
                    this.lens.node.jSetCss({
                        transform: "translate(" + this.lens.pos.x + "px," + this.lens.pos.y + "px)"
                    });
                    this.lens.image.jSetCss({
                        transform: "translate(" + -(this.lens.pos.x + this.lens.border.x) + "px, " + -(this.lens.pos.y + this.lens.border.y) + "px)"
                    })
                } else {
                    this.lens.node.jSetCss({
                        top: this.lens.pos.y,
                        left: this.lens.pos.x
                    });
                    this.lens.image.jSetCss({
                        top: -(this.lens.pos.y + this.lens.border.y),
                        left: -(this.lens.pos.x + this.lens.border.x)
                    })
                }
            }
            if ("magnifier" == this.zoomBox.mode) {
                if (this.lens.touchmovement && !(P && "dbltap" == P.type)) {
                    H.y -= this.zoomBox.height / 2 + 10
                }
                Q = h(window).jGetScroll();
                this.zoomBox.node.jSetCss((x.jBrowser.ieMode && x.jBrowser.ieMode < 11) ? {
                    top: H.y - this.boundaries.top - this.zoomBox.height / 2,
                    left: H.x - this.boundaries.left - this.zoomBox.width / 2
                } : {
                    top: H.y + Q.y - this.zoomBox.height / 2,
                    left: H.x + Q.x - this.zoomBox.width / 2
                })
            }
            if (!this.moveTimer) {
                this.lens.dx = 0;
                this.lens.dy = 0;
                this.move(1)
            }
        },
        move: function(H) {
            var G, F;
            if (!isFinite(H)) {
                H = this.lens.innertouch ? 0.2 : 0.1
            }
            G = ((this.lens.pos.x - this.lens.dx) * H);
            F = ((this.lens.pos.y - this.lens.dy) * H);
            this.lens.dx += G;
            this.lens.dy += F;
            if (!this.moveTimer || Math.abs(G) > 0.000001 || Math.abs(F) > 0.000001) {
                this.zoomBox.image.jSetCss(x.jBrowser.features.transform ? {
                    transform: f + (this.lens.innertouch ? this.lens.dx : -(this.lens.dx * (this.zoomSize.width / this.size.width) - Math.max(0, this.zoomSize.width - this.zoomBox.innerWidth) / 2)) + "px," + (this.lens.innertouch ? this.lens.dy : -(this.lens.dy * (this.zoomSize.height / this.size.height) - Math.max(0, this.zoomSize.height - this.zoomBox.innerHeight) / 2)) + "px" + z + " scale(1)"
                } : {
                    left: -(this.lens.dx * (this.zoomSize.width / this.size.width) + Math.min(0, this.zoomSize.width - this.zoomBox.innerWidth) / 2),
                    top: -(this.lens.dy * (this.zoomSize.height / this.size.height) + Math.min(0, this.zoomSize.height - this.zoomBox.innerHeight) / 2)
                })
            }
            if ("magnifier" == this.zoomBox.mode) {
                return
            }
            this.moveTimer = setTimeout(this.moveBind, 16)
        },
        swipe: function() {
            var R, H, M = 30,
                J = 201,
                O, P = "",
                G = {},
                F, L, Q = 0,
                S = {
                    transition: x.jBrowser.cssTransform + String.fromCharCode(32) + "300ms cubic-bezier(.18,.35,.58,1)"
                },
                I, N, K = h(function(T) {
                    if (!this.ready || this.zoomBox.active) {
                        return
                    }
                    if (T.state == "dragstart") {
                        clearTimeout(this.activateTimer);
                        this.activateTimer = null;
                        Q = 0;
                        G = {
                            x: T.x,
                            y: T.y,
                            ts: T.timeStamp
                        };
                        R = this.size.width;
                        H = R / 2;
                        this.image.node.jRemoveEvent("transitionend");
                        this.image.node.jSetCssProp("transition", "");
                        this.image.node.jSetCssProp("transform", "translate3d(0, 0, 0)");
                        N = null
                    } else {
                        F = (T.x - G.x);
                        L = {
                            x: 0,
                            y: 0,
                            z: 0
                        };
                        if (null === N) {
                            N = (Math.abs(T.x - G.x) < Math.abs(T.y - G.y))
                        }
                        if (N) {
                            return
                        }
                        T.stop();
                        if ("dragend" == T.state) {
                            Q = 0;
                            I = null;
                            O = T.timeStamp - G.ts;
                            if (Math.abs(F) > H || (O < J && Math.abs(F) > M)) {
                                if ((P = (F > 0) ? "backward" : (F <= 0) ? "forward" : "")) {
                                    if (P == "backward") {
                                        I = this.getPrev();
                                        Q += R * 10
                                    } else {
                                        I = this.getNext();
                                        Q -= R * 10
                                    }
                                }
                            }
                            L.x = Q;
                            L.deg = -90 * (L.x / R);
                            this.image.node.jAddEvent("transitionend", h(function(U) {
                                this.image.node.jRemoveEvent("transitionend");
                                this.image.node.jSetCssProp("transition", "");
                                if (I) {
                                    this.image.node.jSetCss({
                                        transform: "translate3d(" + L.x + "px, 0px, 0px)"
                                    });
                                    this.update(I, true)
                                }
                            }).jBind(this));
                            this.image.node.jSetCss(S);
                            this.image.node.jSetCss({
                                "transition-duration": L.x ? "100ms" : "300ms",
                                opacity: 1 - 0.7 * Math.abs(L.x / R),
                                transform: "translate3d(" + L.x + "px, 0px, 0px)"
                            });
                            F = 0;
                            return
                        }
                        L.x = F;
                        L.z = -50 * Math.abs(L.x / H);
                        L.deg = -60 * (L.x / H);
                        this.image.node.jSetCss({
                            opacity: 1 - 0.7 * Math.abs(L.x / H),
                            transform: "translate3d(" + L.x + "px, 0px, " + L.z + "px)"
                        })
                    }
                }).jBind(this);
            this.node.jAddEvent("touchdrag", K)
        },
        openLink: function() {
            if (this.image.link) {
                window.open(this.image.link, "_self")
            }
        },
        getNext: function() {
            var F = (this.expanded ? this.expandGallery : this.additionalImages).filter(function(I) {
                    return (-1 !== I.small.state || -1 !== I.zoom.state)
                }),
                G = F.length,
                H = h(F).indexOf(this.image) + 1;
            return (1 >= G) ? null : F[(H >= G) ? 0 : H]
        },
        getPrev: function() {
            var F = (this.expanded ? this.expandGallery : this.additionalImages).filter(function(I) {
                    return (-1 !== I.small.state || -1 !== I.zoom.state)
                }),
                G = F.length,
                H = h(F).indexOf(this.image) - 1;
            return (1 >= G) ? null : F[(H < 0) ? G - 1 : H]
        },
        imageByURL: function(G, H) {
            var F = this.additionalImages.filter(function(I) {
                return ((I.zoom.src.has(G) || I.zoom.url.has(G)) && (I.small.src.has(H) || I.small.url.has(H)))
            }) || [];
            return F[0] || ((H && G && "string" === x.jTypeOf(H) && "string" === x.jTypeOf(G)) ? new k(H, G) : null)
        },
        imageByOrigin: function(G) {
            var F = this.additionalImages.filter(function(H) {
                return (H.origin === G)
            }) || [];
            return F[0]
        },
        imageByIndex: function(F) {
            return this.additionalImages[F]
        }
    };
    s = {
        version: "v5.0.8",
        start: function(I, G) {
            var H = null,
                F = [];
            x.$A((I ? [h(I)] : x.$A(document.byClass("MagicZoom")).concat(x.$A(document.byClass("MagicZoomPlus"))))).jEach((function(J) {
                if (h(J)) {
                    if (!i(J)) {
                        H = new j(J, G);
                        if (w && !H.option("autostart")) {
                            H.stop();
                            H = null
                        } else {
                            C.push(H);
                            F.push(H)
                        }
                    }
                }
            }).jBind(this));
            return I ? F[0] : F
        },
        stop: function(I) {
            var G, H, F;
            if (I) {
                (H = i(I)) && (H = C.splice(C.indexOf(H), 1)) && H[0].stop() && (delete H[0]);
                return
            }
            while (G = C.length) {
                H = C.splice(G - 1, 1);
                H[0].stop();
                delete H[0]
            }
        },
        refresh: function(F) {
            this.stop(F);
            return this.start(F)
        },
        update: function(K, J, I, G) {
            var H = i(K),
                F;
            if (H) {
                F = "element" === x.jTypeOf(J) ? H.imageByOrigin(J) : H.imageByURL(J, I);
                if (F) {
                    H.update(F)
                }
            }
        },
        switchTo: function(I, H) {
            var G = i(I),
                F;
            if (G) {
                switch (x.jTypeOf(H)) {
                    case "element":
                        F = G.imageByOrigin(H);
                        break;
                    case "number":
                        F = G.imageByIndex(H);
                        break;
                    default:
                }
                if (F) {
                    G.update(F)
                }
            }
        },
        prev: function(G) {
            var F;
            (F = i(G)) && F.update(F.getPrev())
        },
        next: function(G) {
            var F;
            (F = i(G)) && F.update(F.getNext())
        },
        zoomIn: function(G) {
            var F;
            (F = i(G)) && F.activate()
        },
        zoomOut: function(G) {
            var F;
            (F = i(G)) && F.deactivate()
        },
        registerCallback: function(F, G) {
            if (!p[F]) {
                p[F] = []
            }
            if ("function" == x.jTypeOf(G)) {
                p[F].push(G)
            }
        },
        running: function(F) {
            return !!i(F)
        }
    };
    h(document).jAddEvent("domready", function() {
        var G = window[A + "Options"] || {};
        d();
        E = x.$new("div", {
            "class": "magic-hidden-wrapper"
        }).jAppendTo(document.body);
        D = (x.jBrowser.mobile && window.matchMedia && window.matchMedia("(max-device-width: 767px), (max-device-height: 767px)").matches);
        if (x.jBrowser.mobile) {
            x.extend(o, l)
        }
        for (var F = 0; F < y.length; F++) {
            if (G[y[F]] && x.$F !== G[y[F]]) {
                s.registerCallback(y[F], G[y[F]])
            }
        }
        s.start();
        w = false
    });
    window.MagicZoomPlus = window.MagicZoomPlus || {};
    return s
})();