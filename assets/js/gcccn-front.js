!(function (t) {
    if (!t.isInit) {
        var n = {
            getCookie: function (t) {
                var n = ("; " + document.cookie).split("; " + t + "=");
                return n.length < 2 ? void 0 : n.pop().split(";").shift();
            },
            setCookie: function (t, n, e, i, o, s) {
                if ("" != t) {
                    var c = new Date();
                    c.setDate(c.getDate() + (e || 365));
                    var r = [t + "=" + n, "expires=" + c.toUTCString(), "path=" + (o || "/")];
                    i && r.push("domain=" + i), s && r.push("secure"), (document.cookie = r.join(";"));
                }
            },
            compileTemplate: function (t, n) {
                return t.replace(/{{([a-z][a-z0-9\-_]*)}}/gi, function (t) {
                    return n(arguments[1]) || "";
                });
            },
            addClass: function (t, n) {
                t.className += " " + n;
            },
            removeClass: function (t, n) {
                var e = new RegExp("\\b" + n + "\\b");
                t.className = t.className.replace(e, "");
            },
            hasClass: function (t, n) {
                return 1 === t.nodeType && (" " + t.className + " ").replace(/[\n\t]/g, " ").indexOf(" " + n + " ") >= 0;
            },
            extend: function (t, n) {
                for (var e in n) n.hasOwnProperty(e) && (e in t && this.isPlainObj(t[e]) && this.isPlainObj(n[e]) ? this.extend(t[e], n[e]) : (t[e] = n[e]));
                return t;
            },
            isPlainObj: function (t) {
                return "object" == typeof t && null !== t && t.constructor == Object;
            },
            normalizeColor: function (t) {
                return "#" == t[0] && (t = t.substr(1)), 3 == t.length && (t = t[0] + t[0] + t[1] + t[1] + t[2] + t[2]), t;
            },
            hashColors: function (t) {
                var n,
                    e,
                    i = 0;
                if (0 === t.length) return i;
                for (n = 0, e = t.length; n < e; ++n) (i = (i << 5) - i + t.charCodeAt(n)), (i |= 0);
                return i;
            },
            getLuminance: function (t) {
                var n = parseInt(this.normalizeColor(t), 16),
                    e = (n >> 16) - 20,
                    i = ((n >> 8) & 255) - 20,
                    o = (255 & n) - 20;
                return "#" + (16777216 + 65536 * (e < 255 ? (e < 1 ? 0 : e) : 255) + 256 * (i < 255 ? (i < 1 ? 0 : i) : 255) + (o < 255 ? (o < 1 ? 0 : o) : 255)).toString(16).slice(1);
            },
            isMobile: function () {
                return /Android|webOS|iPhone|iPad|iPod|IEMobile|Opera Mini|BlackBerry/i.test(navigator.userAgent);
            },
        };
        (t.fadeEnd = (function () {
            var t = document.createElement("div"),
                n = { t: "transitionend", MozT: "transitionend", msT: "MSTransitionEnd", OT: "oTransitionEnd", WebkitT: "webkitTransitionEnd" };
            for (var e in n) if (n.hasOwnProperty(e) && void 0 !== t.style[e + "ransition"]) return n[e];
            return "";
        })()),
            (t.fading = !!t.fadeEnd),
            (t.customCSS = {}),
            (t.Popup = (function () {
                var e = {
                    enabled: !0,
                    autoOpen: !0,
                    cookie: { name: "gcccn-status", path: "/", domain: "", expiryDays: parseInt(cookie_consent_popup_object.gcccn_cookie_expiry_duration), secure: !1 },
                    content: {
                        message: cookie_consent_popup_object.gcccn_main_message,
                        link: cookie_consent_popup_object.gcccn_policy_link_text,
                        href: cookie_consent_popup_object.gcccn_url_cookie_policy,
                        target: cookie_consent_popup_object.gcccn_open_new_tab,
                        button: cookie_consent_popup_object.gcccn_dismiss_button_text,
                    },
                    container: '<div class="gcccn-container {{classes}}">{{children}}</div>',
                    template:
                        '<span class="gcccn-message">{{message}} <a class="gcccn-privacy" href="{{href}}" rel="noopener" target="{{target}}" tabindex="1">{{link}}</a></span><div class="gcccn-compliance"><a class="gcccn-btn" tabindex="2">{{button}}</a></div>',
                    pushdown: !1,
                    position: "bottom-left",
                    corners: "",
                    padding: "",
                    margin: "",
                    fontsize: "",
                    transparency: "",
                    border: "",
                    colors: null,
                    onInit: function (t) {},
                    onStatusChange: function (t, n) {},
                };
                function i() {
                    this.init.apply(this, arguments);
                }
                function o(t) {
                    (this.displayTimeout = null), n.removeClass(t, "gcccn-invisible");
                }
                function s(n) {
                    (n.style.display = "none"), n.removeEventListener(t.fadeEnd, this.afterFading), (this.afterFading = null);
                }
                function c(e) {
                    var i = this.options,
                        o = document.createElement("div"),
                        s = i.container && 1 === i.container.nodeType ? i.container : document.body;
                    o.innerHTML = e;
                    var c = o.children[0];
                    (c.style.display = "none"),
                        n.hasClass(c, "gcccn-container") && t.fading && n.addClass(c, "gcccn-invisible"),
                        (this.onButtonClick = function (t) {
                            this.setStatus("dismiss"), this.close();
                        }.bind(this)),
                        (this.onButtonEnter = function (t) {
                            13 === t.keyCode && (t.preventDefault(), this.setStatus("dismiss"), this.close());
                        }.bind(this));
                    var r = c.getElementsByClassName("gcccn-btn")[0];
                    return r.addEventListener("click", this.onButtonClick), r.addEventListener("keyup", this.onButtonEnter), s.firstChild ? s.insertBefore(c, s.firstChild) : s.appendChild(c), c;
                }
                function r(t) {
                    return "000000" == (t = n.normalizeColor(t)) ? "#222222" : n.getLuminance(t);
                }
                return (
                    (i.prototype.init = function (i) {
                        this.options && this.destroy(),
                            n.extend((this.options = {}), e),
                            n.isPlainObj(i) && n.extend(this.options, i),
                            function () {
                                var t = this.options.onInit.bind(this);
                                if (window.CookiesOK || window.navigator.CookiesOK) return t("dismiss"), !0;
                                var n = this.getStatus(),
                                    e = "dismiss" == n;
                                return e && t(n), e;
                            }.call(this) && (this.options.enabled = !1);
                        var o = this.options.container
                            .replace(
                                "{{classes}}",
                                function () {
                                    var e = this.options,
                                        i = "top" == e.position || "bottom" == e.position ? "banner" : "float";
                                    n.isMobile() && (i = "float");
                                    var o = ["gcccn-" + i];
                                    return (
                                        e.corners && o.push("gcccn-corners-round gcccn-corners-" + e.corners),
                                        e.padding && o.push("gcccn-padding-" + e.padding),
                                        e.margin && o.push("gcccn-margin-" + e.margin),
                                        e.transparency && o.push("gcccn-transparency-" + e.transparency),
                                        e.fontsize && o.push("gcccn-fontsize-" + e.fontsize),
                                        e.border && o.push("gcccn-border-" + e.border),
                                        e.pushdown && o.push("gcccn-pushdown"),
                                        o.push.apply(
                                            o,
                                            function () {
                                                var t = this.options.position.split("-"),
                                                    n = [];
                                                return (
                                                    t.forEach(function (t) {
                                                        n.push("gcccn-" + t);
                                                    }),
                                                    n
                                                );
                                            }.call(this)
                                        ),
                                        function (e) {
                                            var i = n.hashColors(JSON.stringify(e)),
                                                o = "gcccn-color-custom-" + i,
                                                s = n.isPlainObj(e);
                                            return (
                                                (this.customCSS = s ? o : null),
                                                s &&
                                                    (function (n, e, i) {
                                                        if (t.customCSS[n]) ++t.customCSS[n].references;
                                                        else {
                                                            var o = {},
                                                                s = e.popup,
                                                                c = e.button;
                                                            s &&
                                                                ((o[i + ".gcccn-container"] = ["background-color: " + s.background, "border-color: " + s.border, "color: " + s.text]),
                                                                (o[i + " .gcccn-privacy," + i + " .gcccn-privacy:active," + i + " .gcccn-privacy:visited"] = ["color: " + s.text]),
                                                                c &&
                                                                    ((o[i + " .gcccn-btn"] = ["color: " + c.text, "background-color: " + c.background]),
                                                                    (o[i + " .gcccn-btn:focus, " + i + " .gcccn-btn:hover"] = ["background-color: " + r(c.background)])));
                                                            var a = document.createElement("style");
                                                            document.head.appendChild(a), (t.customCSS[n] = { references: 1, element: a.sheet });
                                                            var l = -1;
                                                            for (var p in o) o.hasOwnProperty(p) && a.sheet.insertRule(p + "{" + o[p].join(";") + "}", ++l);
                                                        }
                                                    })(i, e, "." + o),
                                                s
                                            );
                                        }.call(this, this.options.colors),
                                        this.customCSS && o.push(this.customCSS),
                                        o
                                    );
                                }
                                    .call(this)
                                    .join(" ")
                            )
                            .replace(
                                "{{children}}",
                                function () {
                                    var t = this.options;
                                    return n.compileTemplate(t.template, function (n) {
                                        var e = t.content[n];
                                        return n && "string" == typeof e && e.length ? e : "";
                                    });
                                }.call(this)
                            );
                        this.options.pushdown
                            ? ((this.wrapper = c.call(this, '<div class="gcccn-pushdown-wrap">' + o + "</div>")),
                              (this.wrapper.style.display = ""),
                              (this.element = this.wrapper.firstChild),
                              (this.element.style.display = "none"),
                              n.addClass(this.element, "gcccn-invisible"))
                            : ((this.wrapper = null), (this.element = c.call(this, o))),
                            this.options.autoOpen && this.autoOpen();
                    }),
                    (i.prototype.destroy = function () {
                        this.onButtonClick && this.element && (this.element.removeEventListener("click", this.onButtonClick), (this.onButtonClick = null)),
                            this.onButtonEnter && this.element && (this.element.removeEventListener("keyup", this.onButtonEnter), (this.onButtonEnter = null)),
                            this.wrapper && this.wrapper.parentNode ? this.wrapper.parentNode.removeChild(this.wrapper) : this.element && this.element.parentNode && this.element.parentNode.removeChild(this.element),
                            (this.wrapper = null),
                            (this.element = null),
                            (function (e) {
                                if (n.isPlainObj(e)) {
                                    var i = n.hashColors(JSON.stringify(e)),
                                        o = t.customCSS[i];
                                    if (o && !--o.references) {
                                        var s = o.element.ownerNode;
                                        s && s.parentNode && s.parentNode.removeChild(s), (t.customCSS[i] = null);
                                    }
                                }
                            })(this.options.colors),
                            (this.options = null);
                    }),
                    (i.prototype.open = function (n) {
                        if (this.element) return this.isOpen() || (t.fading ? this.fadeIn() : (this.element.style.display = "")), this;
                    }),
                    (i.prototype.close = function () {
                        if (this.element) return this.isOpen() && (t.fading ? this.fadeOut() : (this.element.style.display = "none")), this;
                    }),
                    (i.prototype.fadeIn = function () {
                        var e = this.element;
                        if (t.fading && e && (this.afterFading && s.call(this, e), n.hasClass(e, "gcccn-invisible"))) {
                            if (((e.style.display = ""), this.options.pushdown)) {
                                var i = 0,
                                    c = this.element.clientHeight;
                                n.hasClass(this.element, "gcccn-border-1")
                                    ? (i = 1)
                                    : n.hasClass(this.element, "gcccn-border-2")
                                    ? (i = 2)
                                    : n.hasClass(this.element, "gcccn-border-3")
                                    ? (i = 3)
                                    : n.hasClass(this.element, "gcccn-border-4")
                                    ? (i = 4)
                                    : n.hasClass(this.element, "gcccn-border-5") && (i = 5),
                                    (this.element.parentNode.style.maxHeight = c + 2 * i + "px");
                            }
                            this.displayTimeout = setTimeout(o.bind(this, e), 25);
                        }
                    }),
                    (i.prototype.fadeOut = function () {
                        var e = this.element;
                        e &&
                            t.fading &&
                            (this.displayTimeout && (clearTimeout(this.displayTimeout), o.bind(this, e)),
                            n.hasClass(e, "gcccn-invisible") ||
                                (this.options.pushdown && (this.element.parentNode.style.maxHeight = ""), (this.afterFading = s.bind(this, e)), e.addEventListener(t.fadeEnd, this.afterFading), n.addClass(e, "gcccn-invisible")));
                    }),
                    (i.prototype.isOpen = function () {
                        return this.element && "" == this.element.style.display && (!t.fading || !n.hasClass(this.element, "gcccn-invisible"));
                    }),
                    (i.prototype.savedCookie = function (t) {
                        return "dismiss" == this.getStatus();
                    }),
                    (i.prototype.autoOpen = function (t) {
                        !this.savedCookie() && this.options.enabled && this.open();
                    }),
                    (i.prototype.setStatus = function (t) {
                        var e = this.options.cookie,
                            i = n.getCookie(e.name);
                        n.setCookie(e.name, t, e.expiryDays, e.domain, e.path, e.secure), this.options.onStatusChange.call(this, t, "dismiss" == i);
                    }),
                    (i.prototype.getStatus = function () {
                        return n.getCookie(this.options.cookie.name);
                    }),
                    (i.prototype.clearStatus = function () {
                        var t = this.options.cookie;
                        n.setCookie(t.name, "", -1, t.domain, t.path, t.secure);
                    }),
                    i
                );
            })()),
            (t.init = function (n, e, i) {
                e || (e = function () {}), i || (i = function () {}), e(new t.Popup(n));
            }),
            (t.isInit = !0),
            (window.gcccn = t);
    }
})(window.gcccn || {});