//////////////////////////////////////////////////////////////////////
// Pano2VR HTML5/CSS3 & WebGL Panorama Player 3.1.0/1777            //
// Trial License: For evaluation only!                              //
// (c) 2011, Garden Gnome Software, http://gardengnomesoftware.com  //
//////////////////////////////////////////////////////////////////////
function iji(px, Ill, ilj) {
    this.x = px;
    this.y = Ill;
    this.lii = ilj;
    this.llj1 = function (px, Ill, ilj) {
        this.x = px;
        this.y = Ill;
        this.lii = ilj;
    };
    this.lljl = function (lI) {
        var j1 = Math.sin(lI);
        var I1 = Math.cos(lI);
        var IlI = this.y;
        var Ili = this.lii;
        this.y = I1 * IlI - j1 * Ili;
        this.lii = j1 * IlI + I1 * Ili;
    };
    this.llij = function (lI) {
        var j1 = Math.sin(lI);
        var I1 = Math.cos(lI);
        var I1I = this.x;
        var Ili = this.lii;
        this.x = I1 * I1I + j1 * Ili;
        this.lii = -j1 * I1I + I1 * Ili;
    };
    this.llIl = function (lI) {
        var j1 = Math.sin(lI);
        var I1 = Math.cos(lI);
        var I1I = this.x;
        var IlI = this.y;
        this.x = I1 * I1I - j1 * IlI;
        this.y = j1 * I1I + I1 * IlI;
    };
}
function lll1() {
    this.llji = function () {
        this.lljI = 1;
        this.lljj = 0;
        this.l1ll = 0;
        this.l1l1 = 0;
        this.l1lI = 1;
        this.llii = 0;
        this.lliI = 0;
        this.lli1 = 0;
        this.llil = 1;
    };
    this.llji();
    this.llIj = function (lI) {
        var I1 = Math.cos(lI);
        var j1 = Math.sin(lI);
        this.lljI = 1;
        this.lljj = 0;
        this.l1ll = 0;
        this.l1l1 = 0;
        this.l1lI = I1;
        this.llii = -j1;
        this.lliI = 0;
        this.lli1 = j1;
        this.llil = I1;
    };
    this.ll11 = function (lI) {
        var I1 = Math.cos(lI);
        var j1 = Math.sin(lI);
        this.lljI = I1;
        this.lljj = 0;
        this.l1ll = j1;
        this.l1l1 = 0;
        this.l1lI = 1;
        this.llii = 0;
        this.lliI = -j1;
        this.lli1 = 0;
        this.llil = I1;
    };
    this.ll1I = function (lI) {
        var I1 = Math.cos(lI);
        var j1 = Math.sin(lI);
        this.lljI = I1;
        this.lljj = -j1;
        this.l1ll = 0;
        this.l1l1 = j1;
        this.l1lI = I1;
        this.llii = 0;
        this.lliI = 0;
        this.lli1 = 0;
        this.llil = 1;
    };
    this.ll1i = function (ll1, llI) {
        this.lljI = ll1.lljI * llI.lljI + ll1.lljj * llI.l1l1 + ll1.l1ll * llI.lliI;
        this.lljj = ll1.lljI * llI.lljj + ll1.lljj * llI.l1lI + ll1.l1ll * llI.lli1;
        this.l1ll = ll1.lljI * llI.l1ll + ll1.lljj * llI.llii + ll1.l1ll * llI.llil;
        this.l1l1 = ll1.l1l1 * llI.lljI + ll1.l1lI * llI.l1l1 + ll1.llii * llI.lliI;
        this.l1lI = ll1.l1l1 * llI.lljj + ll1.l1lI * llI.l1lI + ll1.llii * llI.lli1;
        this.llii = ll1.l1l1 * llI.l1ll + ll1.l1lI * llI.llii + ll1.llii * llI.llil;
        this.lliI = ll1.lliI * llI.lljI + ll1.lli1 * llI.l1l1 + ll1.llil * llI.lliI;
        this.lli1 = ll1.lliI * llI.lljj + ll1.lli1 * llI.l1lI + ll1.llil * llI.lli1;
        this.llil = ll1.lliI * llI.l1ll + ll1.lli1 * llI.llii + ll1.llil * llI.llil;
    };
    this.ll1j = function (v) {
        var l1l = new iji;
        l1l.x = v.x * this.lljI + v.y * this.lljj + v.lii * this.l1ll;
        l1l.y = v.x * this.l1l1 + v.y * this.l1lI + v.lii * this.llii;
        l1l.lii = v.x * this.lliI + v.y * this.lli1 + v.lii * this.llil;
        return l1l;
    };
}
glMatrixArrayType = typeof Float32Array != "undefined" ? Float32Array : typeof WebGLFloatArray != "undefined" ? WebGLFloatArray : Array;
var mat4 = {};
mat4.create = function (lI) {
    var b = new glMatrixArrayType(16);
    if (lI) {
        b[0] = lI[0];
        b[1] = lI[1];
        b[2] = lI[2];
        b[3] = lI[3];
        b[4] = lI[4];
        b[5] = lI[5];
        b[6] = lI[6];
        b[7] = lI[7];
        b[8] = lI[8];
        b[9] = lI[9];
        b[10] = lI[10];
        b[11] = lI[11];
        b[12] = lI[12];
        b[13] = lI[13];
        b[14] = lI[14];
        b[15] = lI[15];
    }
    return b;
};
mat4.llj1 = function (lI, b) {
    b[0] = lI[0];
    b[1] = lI[1];
    b[2] = lI[2];
    b[3] = lI[3];
    b[4] = lI[4];
    b[5] = lI[5];
    b[6] = lI[6];
    b[7] = lI[7];
    b[8] = lI[8];
    b[9] = lI[9];
    b[10] = lI[10];
    b[11] = lI[11];
    b[12] = lI[12];
    b[13] = lI[13];
    b[14] = lI[14];
    b[15] = lI[15];
    return b;
};
mat4.identity = function (lI) {
    lI[0] = 1;
    lI[1] = 0;
    lI[2] = 0;
    lI[3] = 0;
    lI[4] = 0;
    lI[5] = 1;
    lI[6] = 0;
    lI[7] = 0;
    lI[8] = 0;
    lI[9] = 0;
    lI[10] = 1;
    lI[11] = 0;
    lI[12] = 0;
    lI[13] = 0;
    lI[14] = 0;
    lI[15] = 1;
    return lI;
};
mat4.ll1i = function (lI, b, I1) {
    I1 || (I1 = lI);
    var II = lI[0],
        e = lI[1],
        g = lI[2],
        Ii = lI[3],
        lll = lI[4],
        I = lI[5],
        j = lI[6],
        k = lI[7],
        l = lI[8],
        o = lI[9],
        m = lI[10],
        n = lI[11],
        llj = lI[12],
        r = lI[13],
        j1 = lI[14];
    lI = lI[15];
    var A = b[0],
        B = b[1],
        Ij = b[2],
        u = b[3],
        v = b[4],
        l1l = b[5],
        x = b[6],
        y = b[7],
        lii = b[8],
        C = b[9],
        D = b[10],
        E = b[11],
        q = b[12],
        F = b[13],
        G = b[14];
    b = b[15];
    I1[0] = A * II + B * lll + Ij * l + u * llj;
    I1[1] = A * e + B * I + Ij * o + u * r;
    I1[2] = A * g + B * j + Ij * m + u * j1;
    I1[3] = A * Ii + B * k + Ij * n + u * lI;
    I1[4] = v * II + l1l * lll + x * l + y * llj;
    I1[5] = v * e + l1l * I + x * o + y * r;
    I1[6] = v * g + l1l * j + x * m + y * j1;
    I1[7] = v * Ii + l1l * k + x * n + y * lI;
    I1[8] = lii * II + C * lll + D * l + E * llj;
    I1[9] = lii * e + C * I + D * o + E * r;
    I1[10] = lii * g + C * j + D * m + E * j1;
    I1[11] = lii * Ii + C * k + D * n + E * lI;
    I1[12] = q * II + F * lll + G * l + b * llj;
    I1[13] = q * e + F * I + G * o + b * r;
    I1[14] = q * g + F * j + G * m + b * j1;
    I1[15] = q * Ii + F * k + G * n + b * lI;
    return I1;
};
mat4.rotate = function (lI, b, I1, II) {
    var e = I1[0],
        g = I1[1];
    I1 = I1[2];
    var Ii = Math.sqrt(e * e + g * g + I1 * I1);
    if (!Ii) {
        return null;
    }
    if (Ii != 1) {
        Ii = 1 / Ii;
        e *= Ii;
        g *= Ii;
        I1 *= Ii;
    }
    var lll = Math.sin(b),
        I = Math.cos(b),
        j = 1 - I;
    b = lI[0];
    Ii = lI[1];
    var k = lI[2],
        l = lI[3],
        o = lI[4],
        m = lI[5],
        n = lI[6],
        llj = lI[7],
        r = lI[8],
        j1 = lI[9],
        A = lI[10],
        B = lI[11],
        Ij = e * e * j + I,
        u = g * e * j + I1 * lll,
        v = I1 * e * j - g * lll,
        l1l = e * g * j - I1 * lll,
        x = g * g * j + I,
        y = I1 * g * j + e * lll,
        lii = e * I1 * j + g * lll;
    e = g * I1 * j - e * lll;
    g = I1 * I1 * j + I;
    if (II) {
        if (lI != II) {
            II[12] = lI[12];
            II[13] = lI[13];
            II[14] = lI[14];
            II[15] = lI[15];
        }
    } else {
        II = lI;
    }
    II[0] = b * Ij + o * u + r * v;
    II[1] = Ii * Ij + m * u + j1 * v;
    II[2] = k * Ij + n * u + A * v;
    II[3] = l * Ij + llj * u + B * v;
    II[4] = b * l1l + o * x + r * y;
    II[5] = Ii * l1l + m * x + j1 * y;
    II[6] = k * l1l + n * x + A * y;
    II[7] = l * l1l + llj * x + B * y;
    II[8] = b * lii + o * e + r * g;
    II[9] = Ii * lii + m * e + j1 * g;
    II[10] = k * lii + n * e + A * g;
    II[11] = l * lii + llj * e + B * g;
    return II;
};
mat4.frustum = function (lI, b, I1, II, e, g, Ii) {
    Ii || (Ii = mat4.create());
    var lll = b - lI,
        I = II - I1,
        j = g - e;
    Ii[0] = e * 2 / lll;
    Ii[1] = 0;
    Ii[2] = 0;
    Ii[3] = 0;
    Ii[4] = 0;
    Ii[5] = e * 2 / I;
    Ii[6] = 0;
    Ii[7] = 0;
    Ii[8] = (b + lI) / lll;
    Ii[9] = (II + I1) / I;
    Ii[10] = -(g + e) / j;
    Ii[11] = -1;
    Ii[12] = 0;
    Ii[13] = 0;
    Ii[14] = -(g * e * 2) / j;
    Ii[15] = 0;
    return Ii;
};
mat4.perspective = function (lI, b, I1, II, e) {
    lI = I1 * Math.tan(lI * Math.PI / 360);
    b = lI * b;
    return mat4.frustum(-b, b, -lI, lI, I1, II, e);
};

function ggHasHtml5Css3D() {


    var lji = "perspective";
    var li1 = "Webkit,Moz,O,ms,Ms".split(",");
    var I;
    var r = false;
    for (I = 0; I < li1.length; I++) {
        if (typeof document.documentElement.style[li1[I] + "Perspective"] !== "undefined") {
            lji = li1[I] + "Perspective";
        }
    }
    if (typeof document.documentElement.style[lji] !== "undefined") {
        if ("webkitPerspective" in document.documentElement.style) {
            var st = document.createElement("style");
            var div = document.createElement("div");
            var docHead = document.head || document.getElementsByTagName("head")[0];
            st.textContent = "@media (-webkit-transform-3d) {#ggswhtml5{height:5px}}";
            docHead.appendChild(st);
            div.id = "ggswhtml5";
            document.documentElement.appendChild(div);
            r = div.offsetHeight === 5;
            st.parentNode.removeChild(st);
            div.parentNode.removeChild(div);
        } else {
            r = true;
        }
    } else {
        r = false;
    }
    return r;
}
function ggHasWebGL() {
    var r;
    r = !! window.WebGLRenderingContext;
    if (r) {
        try {
            var test = document.createElement("canvas");
            test.width = 100;
            test.height = 100;
            var testgl = test.getContext("webgl", {preserveDrawingBuffer: true});
            if (!testgl) {
                testgl = test.getContext("experimental-webgl", {preserveDrawingBuffer: true});
            }
            if (testgl) {
                r = true;
            } else {
                r = false;
            }
        } catch (e) {
            r = false;
        }
    }
    return r;
}
function pano2vrPlayer(ili) {
    var l1 = this;
    this.transitionsDisabled = false;
    var Il = {
        I1i: 0,
        iil: 0,
        min: 0,
        max: 360,
        II: 0
    };
    var lj = {
        I1i: 0,
        iil: 0,
        min: -90,
        max: 90,
        II: 0
    };
    var li = {
        I1i: 90,
        iil: 90,
        min: 1,
        max: 170,
        lllI: 0,
        II: 0,
        mode: 0
    };
    var il = {
        width: 320,
        height: 480
    };
    var ii = {
        jil: {
            x: 0,
            y: 0
        },
        iIi: {
            x: 0,
            y: 0
        },
        lastclick: {
            x: 0,
            y: 0
        },
        I1i: {
            x: 0,
            y: 0
        },
        i1I: {
            x: 0,
            y: 0
        }
    };
    var jl = {
        jji: -1,
        jil: {
            x: 0,
            y: 0
        },
        iIi: {
            x: 0,
            y: 0
        },
        lastclick: {
            x: 0,
            y: 0
        },
        I1i: {
            x: 0,
            y: 0
        },
        i1I: {
            x: 0,
            y: 0
        }
    };
    var ij = {
        jIl: true,
        iIi: {
            x: 0,
            y: 0
        },
        i1I: {
            x: 0,
            y: 0
        },
        li: {
            iII: false,
            dest: 0
        }
    };
    var ljI = 0;
    var divViewer = null;
    var divViewport = null;
    var divPanorama = null;
    var divPanoview = null;
    var divHotspots = null;
    this.l11j = null;
    this.lIli = new Array;
    this.cubeFacesOverlay = new Array;
    this.checkLoaded = new Array;
    this.l1Il = false;
    this.lIlj = false;
    this.divSkin = null;
    this.isLoaded = false;
    this.hasConfig = false;
    this.onMoveComplete = null;
    var percentLoaded = 0;
    var Ilj = new Array;
    var I1j = new Array;
    var IiI = new Array;
    var j1j = 1;
    var I11 = 1;
    var inPreview = false;
    var ji = {
        jIl: false,
        timeout: 5,
        iII: false,
        lII: 0.4,
        jjj: 0
    };
    var l11 = {
        iII: false,
        lII: 0.1,
        Il: 0,
        lj: 0
    };
    var Ij1;
    this.skinObj = null;
    this.userdata = {
        title: "",
        description: "",
        author: "",
        datetime: "",
        copyright: "",
        source: "",
        information: "",
        comment: ""
    };
    var l1j = new Array;
    this.emptyHotspot = {
        Il: 0,
        lj: 0,
        title: "",
        url: "",
        target: "",
        id: "",
        skinid: "",
        l1l: 100,
        lll: 20,
        wordwrap: false,
        lj1: null
    };
    var soundArray = new Array;
    var globalVolume = 1;
    var overlay = {
        target: 0,
        current: 0,
        blendSpeed: 0.01,
        Ii1: 2,
        delayStart: 0,
        delayActive: false,
        auto: false
    };
    var margin = {
        left: 0,
        top: 0,
        right: 0,
        bottom: 0
    };
    var jj = {
        jjI: false,
        jjl: false,
        jij: false,
        jj1: true,
        llll: false,
        speedWheel: 1
    };
    this.hotspot = this.emptyHotspot;
    this.mouse = {
        x: 0,
        y: 0
    };
    var useWebGL = false;
    var hasHtml5Css3D = false;
    var flagInitWebGL = true;
    var hasGestureEvents = false;
    var basePath = "";
    var cssPrefix = "";
    var domTransition = "transition";
    var domTransform = "transform";
    var lji = "perspective";
    var emptyImage = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAICAIAAABLbSncAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAA5JREFUeNpiYBgeACDAAADIAAE3iTbkAAAAAElFTkSuQmCC";
    var gl;
    var debugMsg = function (iIl) {
            debug = document.getElementById("debug");
            if (debug) {
                debug.innerHTML = iIl + "<br />";
            }
            if (window.console) {
                window.console.log(iIl);
            }
        };
    var requestAnimationFrame = (function () {
        return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame ||
        function (callback, element) {
            window.setTimeout(callback, 10);
        };
    })();
    this.detectBrowser = function () {
        var li1 = "Webkit,Moz,O,ms,Ms".split(",");
        var I;
        cssPrefix = "";
        domTransition = "transition";
        domTransform = "transform";
        lji = "perspective";
        for (I = 0; I < li1.length; I++) {
            if (typeof document.documentElement.style[li1[I] + "Transform"] !== "undefined") {
                cssPrefix = "-" + li1[I].toLowerCase() + "-";
                domTransition = li1[I] + "Transition";
                domTransform = li1[I] + "Transform";
                lji = li1[I] + "Perspective";
            }
        }
        hasHtml5Css3D = ggHasHtml5Css3D();
        useWebGL = ggHasWebGL();
        debugMsg((hasHtml5Css3D ? "CSS 3D available" : "CSS 3D not available") + ", " + (useWebGL ? "WebGL available" : "WebGL not available"));
    };
    this.getPercentLoaded = function () {
        return percentLoaded;
    };
    this.setBasePath = function (v) {
        basePath = v;
    };
    this.lI1l = function () {
        return il.height * 1 / (2 * Math.tan(Math.PI / 180 * (l1.getVFov() / 2)));
    };
    this.setViewerSize = function (l1l, lll) {
        if (l1.l1Il) {
            l1l = window.innerWidth;
            lll = window.innerHeight;
        }
        var cw = l1l - margin.left - margin.right;
        var ch = lll - margin.top - margin.bottom;
        divViewer.style.width = cw + "px";
        divViewer.style.height = ch + "px";
        divViewer.style.left = margin.left + "px";
        divViewer.style.top = margin.top + "px";
        if (useWebGL) {
            try {
                divViewer.width = cw;
                divViewer.height = ch;
                if (gl) {
                    gl.viewportWidth = cw;
                    gl.viewportHeight = ch;
                    gl.viewport(0, 0, cw, ch);
                }
            } catch (e) {
                alert(e);
            }
        }
        divHotspots.style.width = l1l + "px";
        divHotspots.style.height = lll + "px";
        l1.l1j1();
        if (l1.divSkin && l1.divSkin.ggUpdateSize) {
            l1.divSkin.ggUpdateSize(l1l, lll);
        }
    };
    var ljj = function () {
            l1.setViewerSize(l1.l1I1.offsetWidth, l1.l1I1.offsetHeight);
        };
    var getViewerOffset = function () {
            var I1i = {
                x: 0,
                y: 0
            };
            var lj1 = divViewer;
            if (lj1.offsetParent) {
                do {
                    I1i.x += lj1.offsetLeft;
                    I1i.y += lj1.offsetTop;
                } while (lj1 = lj1.offsetParent);
            }
            return I1i;
        };
    this.setMargins = function (l, Ij, r, b) {
        margin.left = l;
        margin.top = Ij;
        margin.right = r;
        margin.bottom = b;
        ljj();
    };
    this.changeViewMode = function (v) {
        if (v == 0) {
            jj.jj1 = false;
        }
        if (v == 1) {
            jj.jj1 = true;
        }
        if (v == 2) {
            jj.jj1 = jj.jj1 ? false : true;
        }
    };
    var jlj = function () {
            var v = new iji(0, 0, -100);
            var Il1 = l1.lI1l();
            for (var I = 0; I < l1j.length; I++) {
                var hotspot = l1j[I];
                v.llj1(0, 0, -100);
                v.lljl(-hotspot.lj * Math.PI / 180);
                v.llij(hotspot.Il * Math.PI / 180);
                v.llij(-Il.I1i * Math.PI / 180);
                v.lljl(lj.I1i * Math.PI / 180);
                var visible = false;
                if (v.lii < 0.1) {
                    var Ij = -Il1 / v.lii;
                    var px = v.x * Ij;
                    var Ill = v.y * Ij;
                    if (Math.abs(px) < il.width / 2 + 500 && Math.abs(Ill) < il.height / 2 + 500) {
                        visible = true;
                    }
                } else {
                    px = 0;
                    Ill = 0;
                }
                if (hotspot.lj1 && hotspot.lj1.__div) {
                    hotspot.lj1.__div.style[domTransition] = "none";
                    if (visible) {
                        hotspot.lj1.__div.style.left = margin.left + px + il.width / 2 + "px";
                        hotspot.lj1.__div.style.top = margin.top + Ill + il.height / 2 + "px";
                    } else {
                        hotspot.lj1.__div.style.left = "-100px";
                        hotspot.lj1.__div.style.top = "-100px";
                    }
                }
            }
        };
    this.lIl1 = function () {
        l1.lIlj = true;
        setTimeout(function () {
            l1.l1jl();
        }, 1);
    };
    this.getVFov = function () {
        var lli;
        var Iil = li.mode;
        switch (Iil) {
        case 0:
            lli = li.I1i / 2;
            break;
        case 1:
            lli = Math.atan(il.height / il.width * Math.tan(li.I1i / 2 * Math.PI / 180)) * 180 / Math.PI;
            break;
        case 2:
            var III = Math.sqrt(il.width * il.width + il.height * il.height);
            lli = Math.atan(il.height / III * Math.tan(li.I1i / 2 * Math.PI / 180)) * 180 / Math.PI;
            break;
        case 3:
            if (il.height * 4 / 3 > il.width) {
                lli = li.I1i / 2;
            } else {
                lli = Math.atan(il.height * 4 / (il.width * 3) * Math.tan(li.I1i / 2 * Math.PI / 180)) * 180 / Math.PI;
            }
        default:
            ;
        }
        return lli * 2;
    };
    this.setVFov = function (IIl) {
        var Iil = li.mode;
        var lli = IIl / 2;
        var lIi, Iii, III;
        switch (Iil) {
        case 0:
            li.I1i = lli * 2;
            break;
        case 1:
            lIi = Math.atan(il.width / il.height * Math.tan(lli * Math.PI / 180)) * 180 / Math.PI;
            li.I1i = lIi * 2;
            break;
        case 2:
            III = Math.sqrt(il.width * il.width + il.height * il.height);
            Iii = Math.atan(III / il.height * Math.tan(lli * Math.PI / 180)) * 180 / Math.PI;
            li.I1i = Iii * 2;
            break;
        case 3:
            if (il.height * 4 / 3 > il.width) {
                li.I1i = lli * 2;
            } else {
                lIi = Math.atan(il.width * 3 / (il.height * 4) * Math.tan(lli * Math.PI / 180)) * 180 / Math.PI;
                li.I1i = lIi * 2;
            }
        default:
            ;
        }
    };
    var Ijl = function () {
            var lIi;
            var lli;
            var Iii;
            if (li.I1i < li.min) {
                li.I1i = li.min;
            }
            if (li.I1i > li.max) {
                li.I1i = li.max;
            }
            lli = l1.getVFov() / 2;
            var lllj = false;
            lIi = Math.atan(il.width / il.height * Math.tan(lli * Math.PI / 180)) * 180 / Math.PI;
            if (lli * 2 > lj.max - lj.min) {
                lli = (lj.max - lj.min) / 2;
            }
            l1.setVFov(lli * 2);
            if (lj.max < 90) {
                if (lj.I1i + lli > lj.max) {
                    lj.I1i = lj.max - lli;
                }
            } else {
                if (lj.I1i > lj.max) {
                    lj.I1i = lj.max;
                }
            }
            if (lj.min > -90) {
                if (lj.I1i - lli < lj.min) {
                    lj.I1i = lj.min + lli;
                }
            } else {
                if (lj.I1i < lj.min) {
                    lj.I1i = lj.min;
                }
            }
            if (Il.max - Il.min < 359.99) {
                var da = 0;
                if (lj.I1i != 0) {
                    var ijj, IIi;
                    var jlI = il.width / 2;
                    var i1l = il.height / 2;
                    ijj = jlI * Math.tan(lIi * Math.PI / 180);
                    IIi = i1l * Math.tan(lli * Math.PI / 180);
                    var IjI = i1l / Math.tan(Math.abs(lj.I1i) * Math.PI / 180);
                    IjI -= IIi;
                    if (IjI > 0) {
                        da = Math.atan(1 / (IjI / IIi)) * 180 / Math.PI;
                        da = da * (Il.max - Il.min) / 360;
                    }
                }
                if (Il.I1i + (lIi + da) > Il.max) {
                    Il.I1i = Il.max - (lIi + da);
                    if (ji.iII) {
                        ji.lII = -ji.lII;
                        Il.II = 0;
                    }
                }
                if (Il.I1i - (lIi + da) < Il.min) {
                    Il.I1i = Il.min + (lIi + da);
                    if (ji.iII) {
                        ji.lII = -ji.lII;
                        Il.II = 0;
                    }
                }
                if (lj.I1i + lli > 90) {
                    lj.I1i = 90 - lli;
                }
                if (lj.I1i - lli < -90) {
                    lj.I1i = -90 + lli;
                }
            }
        };
    this.l1j1 = function () {
        jlj();
        if (useWebGL) {
            jl1();
        } else {
            updatePanoramaCSS();
        }
    };
    var jl1 = function () {
            Ijl();
            if (il.width != divViewer.offsetWidth || il.height != divViewer.offsetHeight) {
                il.width = parseInt(divViewer.offsetWidth);
                il.height = parseInt(divViewer.offsetHeight);
            }
            if (flagInitWebGL) {
                flagInitWebGL = false;
                initWebGL();
                ljj();
            }
            if (!gl) {
                return;
            }
            gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);
            mat4.identity(pMatrix);
            mat4.perspective(li.I1i, gl.viewportWidth / gl.viewportHeight, 0.1, 100, pMatrix);
            gl.uniformMatrix4fv(shaderProgram.pMatrixUniform, false, pMatrix);
            for (v = 0; v < 6; v++) {
                mat4.identity(mvMatrix);
                mat4.rotate(mvMatrix, -lj.I1i * Math.PI / 180, [1, 0, 0]);
                mat4.rotate(mvMatrix, (180 - Il.I1i) * Math.PI / 180, [0, 1, 0]);
                if (v < 4) {
                    mat4.rotate(mvMatrix, -Math.PI / 2 * v, [0, 1, 0]);
                } else {
                    mat4.rotate(mvMatrix, Math.PI / 2 * (v == 5 ? 1 : -1), [1, 0, 0]);
                }
                gl.bindBuffer(gl.ARRAY_BUFFER, il1);
                gl.vertexAttribPointer(shaderProgram.vertexPositionAttribute, 3, gl.FLOAT, false, 0, 0);
                gl.bindBuffer(gl.ARRAY_BUFFER, ill);
                gl.vertexAttribPointer(shaderProgram.textureCoordAttribute, 2, gl.FLOAT, false, 0, 0);
                gl.activeTexture(gl.TEXTURE0);
                gl.bindTexture(gl.TEXTURE_2D, II1[v]);
                gl.uniform1i(shaderProgram.samplerUniform, 0);
                gl.uniformMatrix4fv(shaderProgram.mvMatrixUniform, false, mvMatrix);
                gl.uniformMatrix4fv(shaderProgram.pMatrixUniform, false, pMatrix);
                gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER, Iji);
                gl.drawElements(gl.TRIANGLES, 6, gl.UNSIGNED_SHORT, 0);
            }
        };
    var updatePanoramaCSS = function () {
            Ijl();
            var iI1 = false;
            if (il.width != divViewer.offsetWidth || il.height != divViewer.offsetHeight) {
                il.width = parseInt(divViewer.offsetWidth);
                il.height = parseInt(divViewer.offsetHeight);
                divViewer.style[domTransform + "OriginX"] = il.width / 2 + "px";
                divViewer.style[domTransform + "OriginY"] = il.height / 2 + "px";
                iI1 = true;
            }
            var Il1 = Math.round(l1.lI1l());
            if (this.l1ii != Il1 || iI1) {
                this.l1ii = Il1;
                divViewer.style[lji] = Il1;
            }
            if (divPanoview) {
                divPanoview.style[domTransform] = "translate3d(" + il.width / 2 + "px," + il.height / 2 + "px," + Il1 + "px)";
            }
            if (divPanorama) {
                divPanorama.style[domTransform] = "rotateX(" + Number(lj.I1i).toFixed(10) + "deg)  rotateY(" + Number(-Il.I1i).toFixed(10) + "deg)";
            }
        };
    var shaderProgram;
    var initWebGL = function () {
            try {
                gl = divViewer.getContext("webgl", {preserveDrawingBuffer: true});
                if (!gl) {
                    gl = divViewer.getContext("experimental-webgl", {preserveDrawingBuffer: true});
                }
                if (gl) {
                    gl.viewportWidth = 500;
                    gl.viewportHeight = 500;
                    gl.clearColor(0, 0, 0, 0);
                    gl.enable(gl.DEPTH_TEST);
                    gl.viewport(0, 0, 500, 500);
                    gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);
                    gl.enable(gl.TEXTURE_2D);
                    initShaders();
                    initWebGLBuffers(I11);
                    initWebGLTexture();
                }
            } catch (e) {
                debugMsg(e);
            }
            if (!gl) {
                alert("Could not initialise WebGL!");
            }
        };
    var initShaders = function () {
            var fragmentShader = gl.createShader(gl.FRAGMENT_SHADER);
            ll = "#ifdef GL_ES\n";
            ll += "precision highp float;\n";
            ll += "#endif\n";
            ll += "varying vec2 vTextureCoord;\n";
            ll += "uniform sampler2D uSampler;\n";
            ll += "void main(void) {\n";
            ll += "    gl_FragColor = texture2D(uSampler, vec2(vTextureCoord.s, vTextureCoord.t));\n";
            ll += "}\n";
            gl.shaderSource(fragmentShader, ll);
            gl.compileShader(fragmentShader);
            if (!gl.getShaderParameter(fragmentShader, gl.COMPILE_STATUS)) {
                alert(gl.getShaderInfoLog(fragmentShader));
                fragmentShader = null;
            }
            var vertexShader = gl.createShader(gl.VERTEX_SHADER);
            ll = "attribute vec3 aVertexPosition;\n";
            ll += "attribute vec2 aTextureCoord;\n";
            ll += "uniform mat4 uMVMatrix;\n";
            ll += "uniform mat4 uPMatrix;\n";
            ll += "varying vec2 vTextureCoord;\n";
            ll += "void main(void) {\n";
            ll += "    gl_Position = uPMatrix * uMVMatrix * vec4(aVertexPosition, 1.0);\n";
            ll += "    vTextureCoord = aTextureCoord;\n";
            ll += "}\n";
            gl.shaderSource(vertexShader, ll);
            gl.compileShader(vertexShader);
            if (!gl.getShaderParameter(vertexShader, gl.COMPILE_STATUS)) {
                alert(gl.getShaderInfoLog(vertexShader));
                vertexShader = null;
            }
            shaderProgram = gl.createProgram();
            gl.attachShader(shaderProgram, vertexShader);
            gl.attachShader(shaderProgram, fragmentShader);
            gl.linkProgram(shaderProgram);
            if (!gl.getProgramParameter(shaderProgram, gl.LINK_STATUS)) {
                alert("Could not initialise shaders");
            }
            gl.useProgram(shaderProgram);
            shaderProgram.vertexPositionAttribute = gl.getAttribLocation(shaderProgram, "aVertexPosition");
            gl.enableVertexAttribArray(shaderProgram.vertexPositionAttribute);
            shaderProgram.textureCoordAttribute = gl.getAttribLocation(shaderProgram, "aTextureCoord");
            gl.enableVertexAttribArray(shaderProgram.textureCoordAttribute);
            shaderProgram.pMatrixUniform = gl.getUniformLocation(shaderProgram, "uPMatrix");
            shaderProgram.mvMatrixUniform = gl.getUniformLocation(shaderProgram, "uMVMatrix");
            shaderProgram.samplerUniform = gl.getUniformLocation(shaderProgram, "uSampler");
        };
    var handleLoadedTexture = function (texture) {
            return function (event) {
                try {
                    gl.pixelStorei(gl.UNPACK_FLIP_Y_WEBGL, true);
                    gl.bindTexture(gl.TEXTURE_2D, texture);
                    if (texture.mainImg != null && texture.mainImg.complete) {
                        if (!texture.hasMainImage) {
                            gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, texture.mainImg);
                            texture.hasMainImage = true;
                        }
                    } else {
                        if (texture.prevImg != null && texture.prevImg.complete) {
                            gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, texture.prevImg);
                        } else {
                            gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, texture.emptyImg);
                        }
                    }
                    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.LINEAR);
                    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);
                    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
                    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
                    gl.bindTexture(gl.TEXTURE_2D, null);
                    l1.lIlj = true;
                } catch (e) {}
            };
        };
    var II1 = Array();
    var initWebGLTexture = function () {
            var img;
            var texture;
            II1 = Array();
            for (var I = 0; I < 6; I++) {
                texture = gl.createTexture();
                texture.prevImg = null;
                texture.mainImg = null;
                texture.hasMainImage = false;
                img = new Image;
                img.src = emptyImage;
                texture.emptyImg = img;
                img.addEventListener("load", handleLoadedTexture(texture), false);
                if (IiI[I]) {
                    img = new Image;
                    img.src = basePath + IiI[I];
                    texture.prevImg = img;
                    img.addEventListener("load", handleLoadedTexture(texture), false);
                    l1.checkLoaded.push(img);
                }
                II1.push(texture);
            }
            for (var I = 0; I < 6; I++) {
                if (Ilj[I]) {
                    img = new Image;
                    img.src = basePath + Ilj[I];
                    img.addEventListener("load", handleLoadedTexture(II1[I]), false);
                    II1[I].mainImg = img;
                    l1.checkLoaded.push(img);
                }
            }
        };
    var mvMatrix = mat4.create();
    var pMatrix = mat4.create();
    var il1;
    var ill;
    var Iji;
    var initWebGLBuffers = function (scale) {
            il1 = gl.createBuffer();
            gl.bindBuffer(gl.ARRAY_BUFFER, il1);
            vertices = [-1, -1, 1, 1, -1, 1, 1, 1, 1, -1, 1, 1];
            for (I = 0; I < 12; I++) {
                if (I % 3 < 2) {
                    vertices[I] *= scale;
                }
            }
            gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertices), gl.STATIC_DRAW);
            ill = gl.createBuffer();
            gl.bindBuffer(gl.ARRAY_BUFFER, ill);
            var ijI = [1, 0, 0, 0, 0, 1, 1, 1];
            gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(ijI), gl.STATIC_DRAW);
            Iji = gl.createBuffer();
            gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER, Iji);
            var ij1 = [0, 1, 2, 0, 2, 3];
            gl.bufferData(gl.ELEMENT_ARRAY_BUFFER, new Uint16Array(ij1), gl.STATIC_DRAW);
        };
    this.getPan = function () {
        return Il.I1i;
    };
    this.getPanDest = function () {
        return l11.Il;
    };
    this.getPanN = function () {
        var llj = Il.I1i;
        while (llj < -180) {
            llj += 360;
        }
        while (llj > 180) {
            llj -= 360;
        }
        return llj;
    };
    this.setPan = function (v) {
        resetActivity();
        if (!isNaN(v)) {
            Il.I1i = Number(v);
        }
        l1.lIlj = true;
    };
    this.changePan = function (v, smooth) {
        this.setPan(this.getPan() + v);
        if (smooth) {
            Il.II = v;
        }
    };
    this.getTilt = function () {
        return lj.I1i;
    };
    this.getTiltDest = function () {
        return l11.lj;
    };
    this.setTilt = function (v) {
        resetActivity();
        if (!isNaN(v)) {
            lj.I1i = Number(v);
        }
        l1.lIlj = true;
    };
    this.changeTilt = function (v, smooth) {
        this.setTilt(this.getTilt() + v);
        if (smooth) {
            lj.II = v;
        }
    };
    this.getFov = function () {
        return li.I1i;
    };
    this.getFovDest = function () {
        return l11.li;
    };
    this.setFov = function (v) {
        resetActivity();
        if (!isNaN(v) && v > 0 && v < 180) {
            var old = li.I1i;
            li.I1i = Number(v);
            Ijl();
            l1.lIlj |= old != li.I1i;
        }
    };
    this.changeFov = function (v, smooth) {
        this.setFov(this.getFov() + v);
        if (smooth) {
            li.II = v;
        }
    };
    this.changeFovLog = function (v, smooth) {
        if (!isNaN(v)) {
            var Ij;
            Ij = v / 90 * Math.cos(li.I1i * Math.PI / 360);
            Ij = li.I1i * Math.exp(Ij);
            this.setFov(Ij);
            if (smooth) {
                li.II = v;
            }
        }
    };
    this.setPanTilt = function (llj, Ij) {
        resetActivity();
        if (!isNaN(llj)) {
            Il.I1i = llj;
        }
        if (!isNaN(Ij)) {
            lj.I1i = Ij;
        }
        l1.lIlj = true;
    };
    this.setPanTiltFov = function (llj, Ij, Ii) {
        resetActivity();
        if (!isNaN(llj)) {
            Il.I1i = llj;
        }
        if (!isNaN(Ij)) {
            lj.I1i = Ij;
        }
        if (!isNaN(Ii) && Ii > 0 && Ii < 180) {
            li.I1i = Ii;
        }
        l1.lIlj = true;
    };
    this.setDefaultView = function () {
        this.setPanTiltFov(Il.iil, lj.iil, li.iil);
    };
    this.setLocked = function (v) {
        l1.setLockedMouse(v);
        l1.setLockedWheel(v);
        l1.setLockedKeyboard(v);
    };
    this.setLockedMouse = function (v) {
        jj.jjl = v;
    };
    this.setLockedKeyboard = function (v) {
        jj.jjI = v;
    };
    this.setLockedWheel = function (v) {
        jj.jij = v;
    };
    this.moveTo = function (llj, Ij, Ii, lII) {
        resetActivity();
        l11.iII = true;
        var lI1 = llj.toString().split("/");
        if (lI1.length > 1) {
            llj = Number(lI1[0]);
            lII = Ij;
            Ij = Number(lI1[1]);
            if (lI1.length > 2) {
                Ii = Number(lI1[2]);
            }
        }
        if (!isNaN(llj)) {
            l11.Il = llj;
        } else {
            l11.Il = Il.I1i;
        }
        if (!isNaN(Ij)) {
            l11.lj = Ij;
        } else {
            l11.lj = lj.I1i;
        }
        if (!isNaN(Ii) && Ii > 0 && Ii < 180) {
            l11.li = Ii;
        } else {
            l11.li = li.I1i;
        }
        if (!isNaN(lII) && lII > 0) {
            l11.lII = lII;
        } else {
            l11.lII = 1;
        }
    };
    this.moveToDefaultView = function (lII) {
        this.moveTo(Il.iil, lj.iil, li.iil, lII);
    };
    var i1j = function (x, y) {
            ii.jil.x = x;
            ii.jil.y = y;
            ii.iIi.x = x;
            ii.iIi.y = y;
            ij.iIi.x = x;
            ij.iIi.y = y;
        };
    var ilI = function (x, y) {
            var IIl = l1.getVFov();
            Il.I1i += x * IIl / il.height;
            lj.I1i += y * IIl / il.height;
            Ijl();
        };
    var i1i = function (x, y) {
            ii.I1i.x = x;
            ii.I1i.y = y;
            ii.i1I.x = ii.I1i.x - ii.iIi.x;
            ii.i1I.y = ii.I1i.y - ii.iIi.y;
            if (jj.jj1) {
                ii.iIi.x = ii.I1i.x;
                ii.iIi.y = ii.I1i.y;
            }
        };
    var resetActivity = function () {
            if (ji.iII) {
                ji.iII = false;
                Il.II = 0;
                lj.II = 0;
                li.II = 0;
            }
            if (l11.iII) {
                l11.iII = false;
                Il.II = 0;
                lj.II = 0;
                li.II = 0;
            }
            var II = new Date;
            Ij1 = II.getTime();
        };
    var jli = function (e) {
            if (!jj.jjl) {
                e = e ? e : window.event;
                e.preventDefault();
                if (e.which || e.which == 0 || e.which == 1) {
                    if (e.target == l1.l11j) {
                        i1j(e.pageX, e.pageY);
                        jl.jji = 1;
                        var II = new Date;
                        var liI = II.getTime();
                        jl.startTime = liI;
                        resetActivity();
                    }
                }
                ii.i1I.x = 0;
                ii.i1I.y = 0;
            }
        };
    var mouseMove = function (e) {
            var I1i = getViewerOffset();
            l1.mouse.x = e.pageX - I1i.x;
            l1.mouse.y = e.pageY - I1i.y;
            if (!jj.jjl) {
                e = e ? e : window.event;
                e.preventDefault();
                if (jl.jji >= 0) {
                    if (e.which || e.which == 0 || e.which == 1) {
                        i1i(e.pageX, e.pageY);
                    }
                    resetActivity();
                }
            }
        };
    var j1l = function (e) {
            if (!jj.jjl) {
                e = e ? e : window.event;
                e.preventDefault();
                if (jl.jji >= 0) {
                    jl.jji = -3;
                    ii.i1I.x = 0;
                    ii.i1I.y = 0;
                    var II = new Date;
                    var liI = II.getTime();
                    var lIl = -1;
                    lIl = Math.abs(ii.jil.x - ii.iIi.x) + Math.abs(ii.jil.y - ii.iIi.y);
                    if (liI - jl.startTime < 400 && lIl >= 0 && lIl < 20) {
                        lIl = Math.abs(ii.lastclick.x - ii.iIi.x) + Math.abs(ii.lastclick.y - ii.iIi.y);
                        if (liI - l1.l11i < 700 && lIl >= 0 && lIl < 20) {
                            setTimeout(function () {
                                l1.toggleFullscreen();
                            }, 10);
                            l1.l11i = 0;
                        } else {
                            l1.l11i = liI;
                        }
                        ii.lastclick.x = ii.iIi.x;
                        ii.lastclick.y = ii.iIi.y;
                    }
                    resetActivity();
                }
            }
        };
    var j11 = function (e) {
            if (!jj.jij) {
                e = e ? e : window.event;
                var wheelData = e.detail ? e.detail * -1 : e.wheelDelta / 40;
                if (jj.llll) {
                    wheelData = -wheelData;
                }
                var j1 = wheelData > 0 ? 1 : -1;
                l1.changeFovLog(j1 * jj.speedWheel, true);
                l1.lIlj = true;
                e.preventDefault();
                resetActivity();
            }
        };
    var jll = function (e) {
            if (!e) {
                var e = window.event;
            }
            var Ij = e.touches;
            var I1i = getViewerOffset();
            l1.mouse.x = Ij[0].pageX - I1i.x;
            l1.mouse.y = Ij[0].pageY - I1i.y;
            if (!jj.jjl) {
                e.preventDefault();
                if (jl.jji < 0 && Ij[0]) {
                    var II = new Date;
                    var liI = II.getTime();
                    jl.startTime = liI;
                    jl.jil.x = Ij[0].pageX;
                    jl.jil.y = Ij[0].pageY;
                    jl.iIi.x = Ij[0].pageX;
                    jl.iIi.y = Ij[0].pageY;
                    l1.touchTarget = Ij[0].target;
                    if (Ij[0].target == l1.l11j) {
                        i1j(Ij[0].pageX, Ij[0].pageY);
                        jl.jji = Ij[0].identifier;
                        resetActivity();
                    }
                    if (l1.touchTarget) {
                        e = l1.touchTarget;
                        lIj = false;
                        while (e && e != l1.l11j) {
                            if (e.onmouseover) {
                                e.onmouseover();
                            }
                            if (e.onmousedown && !lIj) {
                                e.onmousedown();
                                lIj = true;
                            }
                            e = e.parentNode;
                        }
                    }
                }
                if (Ij.length > 1) {
                    jl.jji = -5;
                }
                if (!hasGestureEvents) {
                    if (Ij.length == 2 && Ij[0] && Ij[1]) {
                        li.startDist = Math.sqrt((Ij[0].pageX - Ij[1].pageX) * (Ij[0].pageX - Ij[1].pageX) + (Ij[0].pageY - Ij[1].pageY) * (Ij[0].pageY - Ij[1].pageY));
                        li.lllI = li.I1i;
                    }
                }
                ii.i1I.x = 0;
                ii.i1I.y = 0;
            }
        };
    var j1I = function (e) {
            if (!e) {
                var e = window.event;
            }
            var Ij = e.touches;
            var I1i = getViewerOffset();
            l1.mouse.x = Ij[0].pageX - I1i.x;
            l1.mouse.y = Ij[0].pageY - I1i.y;
            if (!jj.jjl) {
                e.preventDefault();
                if (Ij[0]) {
                    jl.iIi.x = Ij[0].pageX;
                    jl.iIi.y = Ij[0].pageY;
                }
                if (jl.jji >= 0) {
                    e.preventDefault();
                    for (var I = 0; I < Ij.length; I++) {
                        if (Ij[I].identifier == jl.jji) {
                            i1i(Ij[I].pageX, Ij[I].pageY);
                            break;
                        }
                    }
                    resetActivity();
                }
                if (Ij.length == 2 && Ij[0] && Ij[1]) {
                    jl.jji = -6;
                    if (!hasGestureEvents) {
                        li.curDist = Math.sqrt((Ij[0].pageX - Ij[1].pageX) * (Ij[0].pageX - Ij[1].pageX) + (Ij[0].pageY - Ij[1].pageY) * (Ij[0].pageY - Ij[1].pageY));
                        ij.li.iII = true;
                        ij.li.dest = li.lllI * Math.sqrt(li.startDist / li.curDist);
                        if (ij.li.dest > li.max) {
                            ij.li.dest = li.max;
                        }
                        if (ij.li.dest < li.min) {
                            ij.li.dest = li.min;
                        }
                        resetActivity();
                    }
                }
            }
        };
    var jIi = function (e) {
            if (!jj.jjl) {
                e.preventDefault();
                if (jl.jji >= 0) {
                    resetActivity();
                }
                if (1) {
                    var II = new Date;
                    var liI = II.getTime();
                    var lIl = -1;
                    lIl = Math.abs(jl.jil.x - jl.iIi.x) + Math.abs(jl.jil.y - jl.iIi.y);
                    if (lIl >= 0 && lIl < 20) {
                        if (l1.touchTarget) {
                            e = l1.touchTarget;
                            lIj = false;
                            while (e && e != l1.l11j) {
                                if (e.onclick && !lIj) {
                                    e.onclick();
                                    lIj = true;
                                }
                                e = e.parentNode;
                            }
                        }
                        lIl = Math.abs(jl.lastclick.x - jl.iIi.x) + Math.abs(jl.lastclick.y - jl.iIi.y);
                        if (liI - l1.l11i < 700 && lIl >= 0 && lIl < 20) {
                            if (l1.touchTarget == l1.l11j) {
                                setTimeout(function () {
                                    l1.toggleFullscreen();
                                }, 1);
                            }
                            if (l1.touchTarget) {
                                e = l1.touchTarget;
                                lIj = false;
                                while (e && e != l1.l11j) {
                                    if (e.ondblclick && !lIj) {
                                        e.ondblclick();
                                        lIj = true;
                                    }
                                    e = e.parentNode;
                                }
                            }
                            l1.l11i = 0;
                        } else {
                            l1.l11i = liI;
                        }
                        jl.lastclick.x = jl.iIi.x;
                        jl.lastclick.y = jl.iIi.y;
                    }
                    if (l1.touchTarget) {
                        e = l1.touchTarget;
                        lIj = false;
                        while (e && e != l1.l11j) {
                            if (e.onmouseout) {
                                e.onmouseout();
                            }
                            if (e.onmouseup && !lIj) {
                                e.onmouseup();
                                lIj = true;
                            }
                            e = e.parentNode;
                        }
                    }
                }
                l1.touchTarget = null;
                jl.jji = -11;
            }
        };
    var j1i = function (e) {
            if (!jj.jjl) {
                e.preventDefault();
                jl.jji = -2;
            }
        };
    var jiI = function (e) {
            hasGestureEvents = true;
            if (!jj.jjl) {
                e.preventDefault();
                li.lllI = li.I1i;
                resetActivity();
            }
        };
    var jii = function (e) {
            if (!jj.jjl) {
                e.preventDefault();
                ij.li.iII = true;
                ij.li.dest = li.lllI / Math.sqrt(event.scale);
                if (ij.li.dest > li.max) {
                    ij.li.dest = li.max;
                }
                if (ij.li.dest < li.min) {
                    ij.li.dest = li.min;
                }
                l1.lIlj = true;
                resetActivity();
            }
        };
    var ji1 = function (e) {
            if (!jj.jjl) {
                e.preventDefault();
                resetActivity();
            }
        };
    var keyDown = function (e) {
            if (!jj.jjI) {
                ljI = e.keyCode;
                resetActivity();
            }
        };
    var keyUp = function (e) {
            ljI = 0;
            resetActivity();
        };
    var onBlur = function (e) {
            ljI = 0;
        };
    resetActivity();
    var iIj = function () {
            requestAnimationFrame(iIj);
            if (jl.jji >= 0) {
                if (jj.jj1) {
                    ij.i1I.x = 0.4 * (ii.iIi.x - ij.iIi.x);
                    ij.i1I.y = 0.4 * (ii.iIi.y - ij.iIi.y);
                    ij.iIi.x += ij.i1I.x;
                    ij.iIi.y += ij.i1I.y;
                    ilI(ij.i1I.x, ij.i1I.y);
                    l1.lIlj = true;
                } else {
                    ij.i1I.x = -ii.i1I.x * 0.1;
                    ij.i1I.y = -ii.i1I.y * 0.1;
                    ilI(-ii.i1I.x * 0.1, -ii.i1I.y * 0.1);
                    l1.lIlj = true;
                }
            }
            if (ij.li.iII) {
                l1.changeFov(0.4 * (ij.li.dest - li.I1i));
                if (Math.abs(ij.li.dest - li.I1i) / li.I1i < 0.001) {
                    ij.li.iII = false;
                }
                l1.lIlj = true;
            }
            if (ij.jIl && (ij.i1I.x != 0 || ij.i1I.y != 0) && jl.jji < 0) {
                ij.i1I.x = 0.9 * ij.i1I.x;
                ij.i1I.y = 0.9 * ij.i1I.y;
                if (ij.i1I.x * ij.i1I.x + ij.i1I.y * ij.i1I.y < 0.1) {
                    ij.i1I.x = 0;
                    ij.i1I.y = 0;
                } else {
                    ilI(ij.i1I.x, ij.i1I.y);
                    l1.lIlj = true;
                }
            }
            if (ljI != 0) {
                switch (ljI) {
                case 37:
                    l1.changePan(1, true);
                    break;
                case 38:
                    l1.changeTilt(1, true);
                    break;
                case 39:
                    l1.changePan(-1, true);
                    break;
                case 40:
                    l1.changeTilt(-1, true);
                    break;
                case 43:
                case 107:
                case 16:
                    l1.changeFovLog(-1, true);
                    break;
                case 17:
                case 18:
                case 109:
                case 45:
                case 91:
                    l1.changeFovLog(1, true);
                    break;
                default:
                    ;
                }
                l1.lIlj = true;
            }
            if (!l1.isLoaded && l1.hasConfig) {
                var I, Ijj = 0;
                if (inPreview) {
                    l1.finalPanorama();
                    inPreview = false;
                }
                for (I = 0; I < l1.checkLoaded.length; I++) {
                    if (l1.checkLoaded[I].complete && l1.checkLoaded[I].src != emptyImage) {
                        Ijj++;
                    }
                }
                if (Ijj == l1.checkLoaded.length) {
                    percentLoaded = 1;
                    l1.isLoaded = true;
                    if (l1.divSkin && l1.divSkin.ggLoaded) {
                        l1.divSkin.ggLoaded();
                    }
                } else {
                    percentLoaded = Ijj / (l1.checkLoaded.length * 1);
                }
            }
            while (Il.I1i > 360) {
                Il.I1i -= 360;
            }
            while (Il.I1i < -360) {
                Il.I1i += 360;
            }
            if (l11.iII) {
                Il.II = l11.Il - Il.I1i;
                if (Il.max - Il.min == 360) {
                    while (Il.II < -180) {
                        Il.II += 360;
                    }
                    while (Il.II > 180) {
                        Il.II -= 360;
                    }
                }
                lj.II = l11.lj - lj.I1i;
                li.II = l11.li - li.I1i;
                var ljl = Math.sqrt(Il.II * Il.II + lj.II * lj.II + li.II * li.II);
                if (ljl * 10 < l11.lII) {
                    l11.iII = false;
                    Il.II = 0;
                    lj.II = 0;
                    li.II = 0;
                    if (l1.onMoveComplete) {
                        l1.onMoveComplete();
                    }
                } else {
                    if (ljl > l11.lII * 5) {
                        ljl = l11.lII / ljl;
                    } else {
                        ljl = 0.2;
                    }
                    Il.II *= ljl;
                    lj.II *= ljl;
                    li.II *= ljl;
                }
                Il.I1i += Il.II;
                lj.I1i += lj.II;
                li.I1i += li.II;
                var II = new Date;
                Ij1 = II.getTime();
                l1.lIlj = true;
            } else if (ji.iII) {
                lj.II = ji.jjj * (0 - lj.I1i) / 100;
                li.II = ji.jjj * (li.iil - li.I1i) / 100;
                Il.II = Il.II * 0.95 + -ji.lII * 0.05;
                Il.I1i += Il.II;
                lj.I1i += lj.II;
                li.I1i += li.II;
                l1.lIlj = true;
            } else {
                if (ji.jIl) {
                    var II = new Date;
                    if (jl.jji < 0 && II.getTime() - Ij1 > ji.timeout * 1000) {
                        ji.iII = true;
                        Il.II = 0;
                        lj.II = 0;
                        li.II = 0;
                    }
                }
                if (ij.jIl && ljI == 0 && jl.jji < 0 && (Il.II != 0 || lj.II != 0 || li.II != 0)) {
                    Il.II *= 0.9;
                    lj.II *= 0.9;
                    li.II *= 0.9;
                    Il.I1i += Il.II;
                    lj.I1i += lj.II;
                    l1.changeFovLog(li.II);
                    if (Il.II * Il.II + lj.II * lj.II + li.II * li.II < 0.0001) {
                        Il.II = 0;
                        lj.II = 0;
                        li.II = 0;
                    }
                    l1.lIlj = true;
                }
            }
            if (overlay.auto) {
                var II = new Date;
                if (overlay.delayActive) {
                    if (II.getTime() - overlay.delayStart >= overlay.Ii1 * 1000) {
                        overlay.delayActive = false;
                    }
                } else {
                    overlay.current += overlay.blendSpeed;
                    if (overlay.current < 0) {
                        overlay.current = 0;
                        overlay.blendSpeed = -overlay.blendSpeed;
                        overlay.delayActive = true;
                        overlay.delayStart = II.getTime();
                    }
                    if (overlay.current > 1) {
                        overlay.current = 1;
                        overlay.blendSpeed = -overlay.blendSpeed;
                        overlay.delayActive = true;
                        overlay.delayStart = II.getTime();
                    }
                    l1.setOverlayOpacity(overlay.current);
                }
            }
            if (l1.lIlj) {
                l1.lIlj = false;
                l1.l1j1();
            }
        };
    var iij = function () {
            setTimeout(function () {
                l1.setFullscreen(false);
            }, 10);
            setTimeout(function () {
                l1.setFullscreen(false);
            }, 100);
        };
    this.assignHandler = function () {
        var l1i;
        l1i = divHotspots;
        l1.l11j = l1i;
        iij();
        setTimeout(function () {
            iIj();
        }, 10);
        setTimeout(function () {
            ljj();
            l1.l1j1();
        }, 10);
        if (l1i.addEventListener) {
            l1i.addEventListener("touchstart", jll, false);
            l1i.addEventListener("touchmove", j1I, false);
            l1i.addEventListener("touchend", jIi, false);
            l1i.addEventListener("touchcancel", j1i, false);
            l1i.addEventListener("gesturestart", jiI, false);
            l1i.addEventListener("gesturechange", jii, false);
            l1i.addEventListener("gestureend", ji1, false);
            l1i.addEventListener("mousedown", jli, false);
            l1i.addEventListener("mousemove", mouseMove, false);
            document.addEventListener("mouseup", j1l, false);
            l1i.addEventListener("mousedblclick", this.toggleFullscreen, false);
            l1i.addEventListener("mousewheel", j11, false);
            l1i.addEventListener("DOMMouseScroll", j11, false);
            document.addEventListener("keydown", keyDown, false);
            document.addEventListener("keyup", keyUp, false);
            window.addEventListener("orientationchange", iij, false);
            window.addEventListener("resize", ljj, false);
            window.addEventListener("blur", onBlur, false);
        }
    };

    function jIj(player, hotspot) {
        var l1 = this;
        this.player = player;
        this.hotspot = hotspot;
        this.__div = document.createElement("div");
        this.img = document.createElement("img");
        var ll;
        ll = "data:image/png;base64,";
        ll += "iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAYAAAByDd+UAAAAGXRFWHRTb2Z0d2FyZQBBZG9";
        ll += "iZSBJbWFnZVJlYWR5ccllPAAAA5xJREFUeNqclmlIVFEUx997TjrplFQW2WKBBSYtRFlpWU";
        ll += "ILSSsRZRQIBdGHCFqIoKIvQRsUFRJC9LEgaSFbMMpcWi1pLzOLsjItKms0U5t5/c/wH7nc5";
        ll += "o2jF374xrv87z33nHOPaRsRtbFgDpgJxoD+wATfwDNQDK6CyrCr5OcbhgiGIRsUAZt4QTWo";
        ll += "IFXgp9JfAhY7rgdBl8NeBoLDYBloA+dBOagFTcDHcVEgDgwBGWA+OAcugvXgvb5wKMGJoAA";
        ll += "Mp9BpUA96EBf/Btsf8BI8AWfAErAcpHHDZeriliY2AVwDg8AucAQ0Ag+I4XhTm2Oxz8PT46";
        ll += "KMbTx5EZjuJDgAnAVusJUm9DhYwalFcc59sIXXIaceFkowDySBPTRPL20xm+b7zYXa+N3CP";
        ll += "rWJ6GuwGySA40HLBHc/GywFhbS5R1lEBrZy7FQwiSaX9pmnqeAYt+KUcew7BVZw/QKTq0oc";
        ll += "pYPVvDOXItZCk2xgDIZqL8BR8Ab0VDbr4yZOgLeIwzQx6WiQxcCt1+6sld66L4yYtFSwF4y";
        ll += "g2dU7/cEwGW9YVkAwmycp1dzdpvgm0DcCh4kHmxWzBls0uBX4qqmZJ4KzePm1IeJLgjmlC1";
        ll += "6aDKZpp5Q168B3o6wsSwTHgU+MIUs74RSj6y1d+212HKimJlUE+tFRfJpYtOKNXWmJTASqW";
        ll += "f2Bu/R6+4TKHOrOzG4IhptjWgHbGkZvepQ6SQK7oRuCXzjX1DJavBEX1ygfT8FgBqpfm1zR";
        ll += "DcEKbR2bsZlkJCdXieB1ZhZ5YtqVgXIPN+m9kbY6hpdb+d9fPncJRmZmqQheZkemJmgxyxy";
        ll += "kl3XWJEkcAl7N21s7PDcl5ZJ0PAa3wVwmWtVbZafPwQ7wLozYB7ATPNJO56d/LAikP9u+66";
        ll += "KNJS1d4IOZp7wU0hfLukUyzgwm70T2N/DOxIy/eFdqawa5DL2NEGwP5k15Ja4woz9glvcom";
        ll += "d9NzyvkFcQo5gomaLfm5c0svnKZ2k7q7+FauvR2MJKZR3+sY5WgtvkdG6JyELGhNHMTXyGf";
        ll += "LviRJ5Tcd4Dlhle7086Sgp8CqVxDkn4OqHaqacr5ekjy3Q/W0FRNNGmoMtamdzdxsytZC0l";
        ll += "qXKhEgWPVVgImg2NgFT1MHOoOk3yLEtgWN5TEOYvoIFI1rGM19//2wpAD7imF7lfwENwAxa";
        ll += "ASNCj90pcLLKdC2Iyw1M9gnEplMEp5kOU1f8WwKGJm8oUr9f8JMAAVMDM6HSDa9QAAAABJR";
        ll += "U5ErkJggg%3D%3D";
        this.img.setAttribute("src", ll);
        this.img.setAttribute("style", "position: absolute;top: -14px;left: -14px;");
        this.__div.appendChild(this.img);
        ll = "position:absolute;";
        ll += cssPrefix + "user-select: none;";
        this.__div.setAttribute("style", ll);
        this.__div.onclick = function () {
            l1.player.openUrl(hotspot.url, hotspot.target);
        };
        this.text = document.createElement("div");
        ll = "position:absolute;";
        ll += "left: -" + hotspot.l1l / 2 + "px;";
        ll += "top:  20px;";
        ll += "width: " + hotspot.l1l + "px;";
        if (hotspot.lll == 0) {
            ll += "height: auto;";
        } else {
            ll += "height: " + hotspot.lll + "px;";
        }
        if (hotspot.wordwrap) {
            ll += "white-space: pre-wrap;";
            ll += "width: " + hotspot.l1l + "px;";
        } else {
            if (hotspot.lll == 0) {
                ll += "width: auto;";
            } else {
                ll += "width: " + hotspot.l1l + "px;";
            }
            ll += "white-space: nowrap;";
        }
        ll += cssPrefix + "transform-origin: 50% 50%;";
        ll += "visibility: hidden;";
        ll += "border: 1px solid #000000;";
        ll += "background-color: #ffffff;";
        ll += "text-align: center;";
        ll += "overflow: hidden;";
        ll += "padding: 0px 1px 0px 1px;";
        this.text.setAttribute("style", ll);
        this.text.innerHTML = hotspot.title;
        this.__div.onmouseover = function () {
            if (hotspot.lll == 0) {
                l1l = l1.text.offsetWidth;
                l1.text.style.left = -l1l / 2 + "px";
            }
            l1.text.style.visibility = "inherit";
        };
        this.__div.onmouseout = function () {
            l1.text.style.visibility = "hidden";
        };
        this.__div.appendChild(this.text);
    }
    this.l1Ii = function () {
        for (var I = 0; I < l1j.length; I++) {
            if (l1.skinObj && l1.skinObj.addSkinHotspot) {
                l1j[I].lj1 = new l1.skinObj.addSkinHotspot(l1j[I]);
            } else {
                l1j[I].lj1 = new jIj(this, l1j[I]);
            }
            if (l1j[I].lj1 && l1j[I].lj1.__div) {
                var Ii = divHotspots.firstChild;
                if (Ii) {
                    divHotspots.insertBefore(l1j[I].lj1.__div, Ii);
                } else {
                    divHotspots.appendChild(l1j[I].lj1.__div);
                }
            }
        }
    };
    var addSoundElement = function (sound) {
            var jI = -1;
            try {
                for (var I = 0; I < soundArray.length; I++) {
                    if (soundArray[I].id == sound.id && soundArray[I].lj1 != null) {
                        try {
                            soundArray[I].lj1.pause();
                        } catch (e) {
                            debugMsg(e);
                        }
                        try {
                            soundArray[I].lj1.parentElement.removeChild(soundArray[I].lj1);
                            delete soundArray[I].lj1;
                            soundArray[I].lj1 = null;
                        } catch (e) {
                            debugMsg(e);
                        }
                        jI = I;
                    }
                }
                sound.lj1 = document.createElement("audio");
                sound.lj1.setAttribute("src", sound.url);
                sound.lj1.volume = sound.level * globalVolume;
                if (sound.loop == 0) {
                    sound.lj1.ggLoop = 10000000;
                }
                if (sound.loop >= 1) {
                    sound.lj1.ggLoop = sound.loop - 1;
                }
                if ((sound.mode == 1 || sound.mode == 2 || sound.mode == 3 || sound.mode == 5) && sound.loop >= 0) {
                    sound.lj1.autoplay = true;
                }
                if (sound.mode == 0) {}
                sound.lj1.addEventListener("ended", function () {
                    if (this.ggLoop > 0) {
                        this.ggLoop--;
                        this.play();
                    }
                }, false);
                if (jI >= 0) {
                    soundArray[jI] = sound;
                } else {
                    soundArray.push(sound);
                }
                divViewport.appendChild(sound.lj1);
            } catch (e) {
                debugMsg(e);
            }
        };
    this.playSound = function (id, loop) {
        var jI = -1;
        for (var I = 0; I < soundArray.length; I++) {
            if (soundArray[I].id == id) {
                jI = I;
            }
        }
        if (jI >= 0) {
            if (loop && !isNaN(Number(loop))) {
                soundArray[jI].lj1.ggLoop = Number(loop) - 1;
            } else {
                soundArray[jI].lj1.ggLoop = soundArray[jI].loop - 1;
            }
            soundArray[jI].lj1.play();
        }
    };
    this.pauseSound = function (id) {
        if (id == "_main") {
            for (var I = 0; I < soundArray.length; I++) {
                soundArray[I].lj1.pause();
            }
        } else {
            var jI = -1;
            for (var I = 0; I < soundArray.length; I++) {
                if (soundArray[I].id == id) {
                    jI = I;
                }
            }
            if (jI >= 0) {
                soundArray[jI].lj1.pause();
            }
        }
    };
    this.stopSound = function (id) {
        if (id == "_main") {
            for (var I = 0; I < soundArray.length; I++) {
                soundArray[I].lj1.pause();
                soundArray[I].lj1.currentTime = 0;
            }
        } else {
            var jI = -1;
            for (var I = 0; I < soundArray.length; I++) {
                if (soundArray[I].id == id) {
                    jI = I;
                }
            }
            if (jI >= 0) {
                soundArray[jI].lj1.pause();
                soundArray[jI].lj1.currentTime = 0;
            }
        }
    };
    this.setVolume = function (id, v) {
        var vol = Number(v);
        if (vol > 1) {
            vol = 1;
        }
        if (vol < 0) {
            vol = 0;
        }
        if (id == "_main") {
            globalVolume = vol;
            for (var I = 0; I < soundArray.length; I++) {
                soundArray[I].lj1.volume = soundArray[I].level * globalVolume;
            }
        } else {
            var jI = -1;
            for (var I = 0; I < soundArray.length; I++) {
                if (soundArray[I].id == id) {
                    jI = I;
                }
            }
            if (jI >= 0) {
                soundArray[jI].level = vol;
                soundArray[jI].lj1.volume = vol * globalVolume;
            }
        }
    };
    this.changeVolume = function (id, v) {
        if (id == "_main") {
            var vol = globalVolume;
            vol += Number(v);
            if (vol > 1) {
                vol = 1;
            }
            if (vol < 0) {
                vol = 0;
            }
            globalVolume = vol;
            for (var I = 0; I < soundArray.length; I++) {
                soundArray[I].lj1.volume = soundArray[I].level * globalVolume;
            }
        } else {
            var jI = -1;
            for (var I = 0; I < soundArray.length; I++) {
                if (soundArray[I].id == id) {
                    jI = I;
                }
            }
            if (jI >= 0) {
                var vol = soundArray[jI].level;
                vol += Number(v);
                if (vol > 1) {
                    vol = 1;
                }
                if (vol < 0) {
                    vol = 0;
                }
                soundArray[jI].level = vol;
                soundArray[jI].lj1.volume = vol * globalVolume;
            }
        }
    };
    this.removeHotspots = function () {
        var lll;
        while (l1j.length > 0) {
            lll = l1j.pop();
            divHotspots.removeChild(lll.lj1.__div);
            delete lll.lj1;
            lll.lj1 = null;
        }
    };
    this.setFullscreen = function (v) {
        if (this.l1Il != v) {
            this.l1Il = v;
            this.lIlj = true;
        }
        if ( this.l1Il) {
            if (1) {
                divViewport.style.position = "absolute";
                var I1i = getViewerOffset();
                divViewport.style.left = window.pageXOffset - I1i.x + margin.left + "px";
                divViewport.style.top = window.pageYOffset - I1i.y + margin.top + "px";
                document.body.style.overflow = "hidden";
            } else {
                divViewport.style.position = "fixed";
            }
            if (l1.divSkin && l1.divSkin.ggEnterFullscreen) {
                l1.divSkin.ggEnterFullscreen();
            }
        } else {
            divViewport.style.position = "relative";
            divViewport.style.left = "0px";
            divViewport.style.top = "0px";
            document.body.style.overflow = "";
            if (l1.divSkin && l1.divSkin.ggExitFullscreen) {
                l1.divSkin.ggExitFullscreen();
            }
        }
        ljj();
        
 
    };
    this.toggleFullscreen = function () {
        this.setFullscreen(!this.l1Il);
    };
    this.exitFullscreen = function () {
        l1.setFullscreen(false);
    };
    this.startAutorotate = function (lII, Ii1, ii1) {
        ji.jIl = true;
        ji.iII = true;
        if (lII && lII != 0) {
            ji.lII = lII;
        }
        if (Ii1) {
            ji.timeout = Ii1;
        }
        if (ii1) {
            ji.jjj = ii1;
        }
    };
    this.stopAutorotate = function () {
        ji.iII = false;
        ji.jIl = false;
    };
    this.toggleAutorotate = function () {
        ji.jIl = !ji.iII;
        ji.iII = ji.jIl;
    };
    this.l1Ij = function (ili) {
        var ll;
        this.l1I1 = document.getElementById(ili);
        if (this.l1I1) {
            this.l1I1.innerHTML = "";
        } else {
            alert("container not found!");
            return;
        }
        divViewport = document.createElement("div");
        divViewport.setAttribute("id", "viewport");
        ll = "top:  0px;";
        ll += "left: 0px;";
        ll += "position:relative;";
        divViewport.setAttribute("style", ll);
        this.l1I1.appendChild(divViewport);
        if (useWebGL) {
            divViewer = document.createElement("canvas");
            ll = "top:  0px;";
            ll += "left: 0px;";
            ll += "width:  100px;";
            ll += "height: 100px;";
            ll += "overflow: hidden;";
            ll += "position:absolute;";
            ll += cssPrefix + "user-select: none;";
            ll += "position:absolute;";
            divViewer.width = 100;
            divViewer.height = 100;
            divViewport.appendChild(divViewer);
        } else {
            divViewer = document.createElement("div");
            ll = "top:  0px;";
            ll += "left: 0px;";
            ll += "width:  100px;";
            ll += "height: 100px;";
            ll += "overflow: hidden;";
            ll += "position:absolute;";
            ll += "z-index: 0;";
            ll += cssPrefix + "user-select: none;";
            divViewer.setAttribute("id", "viewer");
            divViewer.setAttribute("style", ll);
            divViewport.appendChild(divViewer);
        }
        divHotspots = document.createElement("div");
        divHotspots.setAttribute("id", "hotspots");
        ll = "top:  0px;";
        ll += "left: 0px;";
        ll += "width:  100px;";
        ll += "height: 100px;";
        ll += "overflow: hidden;";
        ll += "position:absolute;";
        ll += "z-index: 1000;";
        ll += cssPrefix + "user-select: none;";
        divHotspots.setAttribute("style", ll);
        divViewport.appendChild(divHotspots);
        this.divSkin = divHotspots;
    };
    this.l1il = function () {
        var ll;
        divPanoview = document.createElement("div");
        ll = "position:absolute;";
        ll += cssPrefix + "user-select: none;";
        ll += cssPrefix + "transform-style: preserve-3d;";
        ll += "z-Index: 100;";
        divPanoview.setAttribute("style", ll);
        divPanoview.setAttribute("id", "divPanoview");
        divViewer.appendChild(divPanoview);
        divPanorama = document.createElement("div");
        ll = cssPrefix + "transform-style: preserve-3d;";
        ll += cssPrefix + "transform-origin: 0 0;";
        ll += "position:absolute;";
        ll += cssPrefix + "user-select: none;";
        ll += "z-Index: 100;";
        divPanorama.setAttribute("style", ll);
        divPanoview.appendChild(divPanorama);
        var l1I, I;
        inPreview = true;
        var tiles = 128;
        if (j1j > tiles) {
            tiles = j1j;
        }
        for (I = 0; I < 6; I++) {
            l1I = document.createElement("img");
            if (inPreview) {
                if (IiI[I] != "") {
                    l1I.setAttribute("src", basePath + IiI[I]);
                }
            } else {
                l1I.setAttribute("src", basePath + Ilj[I]);
            }
            ll = "position:absolute;";
            ll += "left: 0px;";
            ll += "top: 0px;";
            ll += "width: " + tiles + "px;";
            ll += "height: " + tiles + "px;";
            ll += "z-index: 100;";
            ll += cssPrefix + "transform-origin: 0 0;";
            ll += cssPrefix + "transform: ";
            if (I < 4) {
                ll += "rotateY(" + I * -90 + "deg)";
            } else {
                ll += "rotateX(" + (I == 4 ? -90 : 90) + "deg)";
            }
            ll += " scale(" + I11 + ") translate3d(" + -tiles / 2 + "px," + -tiles / 2 + "px," + -tiles / 2 + "px);";
            l1I.setAttribute("style", ll);
            divPanorama.appendChild(l1I);
            l1.lIli.push(l1I);
            l1.checkLoaded.push(l1I);
            if (I1j[I] != "") {
                l1I = document.createElement("img");
                l1I.setAttribute("src", I1j[I]);
                ll = "position:absolute;";
                ll += "left: 0px;";
                ll += "top: 0px;";
                ll += "width: " + tiles / 1.1 + "px;";
                ll += "height: " + tiles / 1.1 + "px;";
                ll += "z-index: 100;";
                ll += cssPrefix + "transform-origin: 0 0;";
                ll += cssPrefix + "transform: ";
                if (I < 4) {
                    ll += "rotateY(" + I * -90 + "deg)";
                } else {
                    ll += "rotateX(" + (I == 4 ? -90 : 90) + "deg)";
                }
                ll += " scale(" + I11 + ") translate3d(" + -tiles / 2.2 + "px," + -tiles / 2.2 + "px," + -tiles / 2.2 + "px);";
                l1I.setAttribute("style", ll);
                l1I.style.opacity = 0;
                divPanorama.appendChild(l1I);
                l1.cubeFacesOverlay.push(l1I);
                l1.checkLoaded.push(l1I);
            }
        }
    };
    this.finalPanorama = function () {
        var I;
        if (divPanoview) {
            for (I = 0; I < 6; I++) {
                l1.lIli[I].setAttribute("src", basePath + Ilj[I]);
            }
        }
    };
    this.setOverlayOpacity = function (value) {
        var I;
        if (divPanoview) {
            for (I = 0; I < 6; I++) {
                if (l1.cubeFacesOverlay[I]) {
                    if (l1.cubeFacesOverlay[I].style) {
                        l1.cubeFacesOverlay[I].style.opacity = value;
                    }
                }
            }
        }
    };
    this.l1i1 = function () {
        var I;
        if (divPanoview) {
            for (I = 0; I < l1.lIli.length; I++) {
                l1.lIli[I].setAttribute("src", emptyImage);
                if (l1.cubeFacesOverlay[I]) {
                    l1.cubeFacesOverlay[I].setAttribute("src", emptyImage);
                }
            }
            divViewer.removeChild(divPanoview);
            divPanorama = null;
            divPanoview = null;
            l1.lIli = new Array;
            l1.cubeFacesOverlay = new Array;
        }
    };
    this.lI1I = function () {
        var IIj = 1;
        if (window.devicePixelRatio) {
            IIj = window.devicePixelRatio;
        }
        return {
            l1l: screen.width * IIj,
            lll: screen.height * IIj
        };
    };
    this.getMaxScreenResolution = function () {
        var v = this.lI1I();
        return v.l1l > v.lll ? v.l1l : v.lll;
    };
    this.readConfigString = function (ijl) {
        if (window.DOMParser) {
            parser = new DOMParser;
            lij = parser.parseFromString(ijl, "text/xml");
        } else {
            lij = new ActiveXObject("Microsoft.XMLDOM");
            lij.async = "false";
            lij.loadXML(ijl);
        }
        this.readConfigXml(lij);
    };
    this.readConfigUrl = function (url) {
        try {
            var I1l;
            if (window.XMLHttpRequest) {
                I1l = new XMLHttpRequest;
            } else {
                I1l = new ActiveXObject("Microsoft.XMLHTTP");
            }
            I1l.open("GET", url, false);
            I1l.send(null);
            var lij = I1l.responseXML;
            if (lij) {
                var llj = url.lastIndexOf("/");
                if (llj >= 0) {
                    basePath = url.substr(0, llj + 1);
                }
                this.readConfigXml(lij);
            } else {
                alert("Error loading panorama XML");
            }
        } catch (e) {
            alert("Error:" + e);
        }
    };
    var Iij = true;
    this.readConfigXml = function (lij) {
        this.removeHotspots();
        this.l1i1();
        this.l1ii = 0;
        var jII = lij.firstChild;
        var i1 = jII.firstChild;
        var iI, v, I;
        var lil;
        var i11 = 1000000;
        while (i1) {
            if (i1.nodeName == "view") {
                v = i1.getAttributeNode("fovmode");
                if (v) {
                    li.mode = Number(v.nodeValue);
                }
                iI = i1.firstChild;
                while (iI) {
                    if (iI.nodeName == "start") {
                        v = iI.getAttributeNode("pan");
                        Il.I1i = Number(v ? v.nodeValue : 0);
                        Il.iil = Il.I1i;
                        v = iI.getAttributeNode("tilt");
                        lj.I1i = Number(v ? v.nodeValue : 0);
                        lj.iil = lj.I1i;
                        v = iI.getAttributeNode("fov");
                        li.I1i = Number(v ? v.nodeValue : 70);
                        li.iil = li.I1i;
                    }
                    if (iI.nodeName == "min") {
                        v = iI.getAttributeNode("pan");
                        Il.min = 1 * (v ? v.nodeValue : 0);
                        v = iI.getAttributeNode("tilt");
                        lj.min = 1 * (v ? v.nodeValue : -90);
                        v = iI.getAttributeNode("fov");
                        li.min = 1 * (v ? v.nodeValue : 5);
                        if (li.min < 1e-8) {
                            li.min = 1e-8;
                        }
                    }
                    if (iI.nodeName == "max") {
                        v = iI.getAttributeNode("pan");
                        Il.max = 1 * (v ? v.nodeValue : 0);
                        v = iI.getAttributeNode("tilt");
                        lj.max = 1 * (v ? v.nodeValue : 90);
                        v = iI.getAttributeNode("fov");
                        li.max = 1 * (v ? v.nodeValue : 120);
                        if (li.max >= 180) {
                            li.max = 179.9;
                        }
                    }
                    iI = iI.nextSibling;
                }
            }
            if (i1.nodeName == "autorotate") {
                if (Iij) {
                    ji.jIl = true;
                }
                v = i1.getAttributeNode("speed");
                if (v) {
                    ji.lII = 1 * v.nodeValue;
                }
                v = i1.getAttributeNode("delay");
                if (v) {
                    ji.timeout = 1 * v.nodeValue;
                }
                v = i1.getAttributeNode("returntohorizon");
                if (v) {
                    ji.jjj = 1 * v.nodeValue;
                }
            }
            if (i1.nodeName == "input") {
                if (!lil) {
                    lil = i1;
                }
            }
            if (lil) {
                for (I = 0; I < 6; I++) {
                    v = lil.getAttributeNode("prev" + I + "url");
                    IiI[I] = v ? new String(v.nodeValue) : "";
                }
            }
            if (i1.nodeName == "altinput") {
                var j1 = 0;
                v = i1.getAttributeNode("screensize");
                if (v) {
                    j1 = 1 * v.nodeValue;
                }
                if (j1 > 0 && j1 >= this.getMaxScreenResolution() && j1 < i11) {
                    i11 = j1;
                    lil = i1;
                }
            }
            if (i1.nodeName == "control") {
                if (Iij) {
                    v = i1.getAttributeNode("simulatemass");
                    if (v) {
                        ij.jIl = v.nodeValue == 1;
                    }
                    v = i1.getAttributeNode("locked");
                    if (v) {
                        jj.jjl = v.nodeValue == 1;
                    }
                    if (v) {
                        jj.jjI = v.nodeValue == 1;
                    }
                    v = i1.getAttributeNode("lockedmouse");
                    if (v) {
                        jj.jjl = v.nodeValue == 1;
                    }
                    v = i1.getAttributeNode("lockedkeyboard");
                    if (v) {
                        jj.jjI = v.nodeValue == 1;
                    }
                    v = i1.getAttributeNode("lockedwheel");
                    if (v) {
                        jj.jij = v.nodeValue == 1;
                    }
                    v = i1.getAttributeNode("invertwheel");
                    if (v) {
                        jj.llll = v.nodeValue == 1;
                    }
                    v = i1.getAttributeNode("speedwheel");
                    if (v) {
                        jj.speedWheel = 1 * v.nodeValue;
                    }
                    v = i1.getAttributeNode("invertcontrol");
                    if (v) {
                        jj.jj1 = v.nodeValue == 1;
                    }
                }
            }
            if (i1.nodeName == "overlay") {
                v = i1.getAttributeNode("blendspeed");
                if (v) {
                    overlay.blendSpeed = 1 * v.nodeValue;
                }
                v = i1.getAttributeNode("auto");
                if (v) {
                    overlay.auto = v.nodeValue == 1;
                }
                v = i1.getAttributeNode("delay");
                if (v) {
                    overlay.Ii1 = 1 * v.nodeValue;
                }
            }
            if (i1.nodeName == "userdata") {
                v = i1.getAttributeNode("title");
                l1.userdata.title = v ? v.nodeValue.toString() : "";
                v = i1.getAttributeNode("description");
                l1.userdata.description = v ? v.nodeValue.toString() : "";
                v = i1.getAttributeNode("author");
                l1.userdata.author = v ? v.nodeValue.toString() : "";
                v = i1.getAttributeNode("datetime");
                l1.userdata.datetime = v ? v.nodeValue.toString() : "";
                v = i1.getAttributeNode("copyright");
                l1.userdata.copyright = v ? v.nodeValue.toString() : "";
                v = i1.getAttributeNode("source");
                l1.userdata.source = v ? v.nodeValue.toString() : "";
                v = i1.getAttributeNode("info");
                l1.userdata.information = v ? v.nodeValue.toString() : "";
                v = i1.getAttributeNode("comment");
                l1.userdata.comment = v ? v.nodeValue.toString() : "";
            }
            if (i1.nodeName == "hotspots") {
                iI = i1.firstChild;
                while (iI) {
                    if (iI.nodeName == "hotspot") {
                        var hotspot = {
                            Il: 0,
                            lj: 0,
                            url: "",
                            target: "",
                            id: "",
                            skinid: "",
                            l1l: 100,
                            lll: 20,
                            wordwrap: false,
                            lj1: null
                        };
                        v = iI.getAttributeNode("pan");
                        hotspot.Il = 1 * (v ? v.nodeValue : 0);
                        v = iI.getAttributeNode("tilt");
                        hotspot.lj = 1 * (v ? v.nodeValue : 0);
                        v = iI.getAttributeNode("url");
                        if (v) {
                            hotspot.url = v.nodeValue.toString();
                        }
                        v = iI.getAttributeNode("target");
                        if (v) {
                            hotspot.target = v.nodeValue.toString();
                        }
                        v = iI.getAttributeNode("title");
                        if (v) {
                            hotspot.title = v.nodeValue.toString();
                        }
                        v = iI.getAttributeNode("id");
                        if (v) {
                            hotspot.id = v.nodeValue.toString();
                        }
                        v = iI.getAttributeNode("skinid");
                        if (v) {
                            hotspot.skinid = v.nodeValue.toString();
                        }
                        v = i1.getAttributeNode("width");
                        if (v) {
                            hotspot.l1l = v.nodeValue.toString();
                        }
                        v = i1.getAttributeNode("height");
                        if (v) {
                            hotspot.lll = v.nodeValue.toString();
                        }
                        v = i1.getAttributeNode("wordwrap");
                        if (v) {
                            hotspot.wordwrap = v.nodeValue == 1;
                        }
                        l1j.push(hotspot);
                    }
                    iI = iI.nextSibling;
                }
            }
            if (i1.nodeName == "sounds") {
                iI = i1.firstChild;
                while (iI) {
                    if (iI.nodeName == "sound") {
                        var sound = {
                            id: "",
                            url: "",
                            loop: 0,
                            level: 1,
                            mode: 1,
                            Il: 0,
                            lj: 0,
                            ll1l: 0,
                            llli: 0
                        };
                        v = iI.getAttributeNode("id");
                        if (v) {
                            sound.id = v.nodeValue.toString();
                        }
                        v = iI.getAttributeNode("url");
                        if (v) {
                            sound.url = v.nodeValue.toString();
                        }
                        v = iI.getAttributeNode("level");
                        if (v) {
                            sound.level = Number(v.nodeValue);
                        }
                        v = iI.getAttributeNode("loop");
                        if (v) {
                            sound.loop = Number(v.nodeValue);
                        }
                        v = iI.getAttributeNode("mode");
                        if (v) {
                            sound.mode = Number(v.nodeValue);
                        }
                        v = iI.getAttributeNode("pan");
                        if (v) {
                            sound.Il = Number(v.nodeValue);
                        }
                        v = iI.getAttributeNode("tilt");
                        if (v) {
                            sound.lj = Number(v.nodeValue);
                        }
                        v = iI.getAttributeNode("pansize");
                        if (v) {
                            sound.ll1l = Number(v.nodeValue);
                        }
                        v = iI.getAttributeNode("tiltsize");
                        if (v) {
                            sound.llli = Number(v.nodeValue);
                        }
                        addSoundElement(sound);
                    }
                    iI = iI.nextSibling;
                }
            }
            i1 = i1.nextSibling;
        }
        if (lil) {
            for (I = 0; I < 6; I++) {
                v = lil.getAttributeNode("tile" + I + "url");
                if (v) {
                    Ilj[I] = new String(v.nodeValue);
                }
                v = lil.getAttributeNode("tile" + I + "url1");
                if (v) {
                    I1j[I] = new String(v.nodeValue);
                } else {
                    I1j[I] = "";
                }
            }
            for (I = 0; I < 6; I++) {
                v = lil.getAttributeNode("prev" + I + "url");
                if (v) {
                    IiI[I] = new String(v.nodeValue);
                }
            }
            v = lil.getAttributeNode("tilesize");
            if (v) {
                j1j = 1 * v.nodeValue;
            }
            v = lil.getAttributeNode("tilescale");
            if (v) {
                I11 = 1 * v.nodeValue;
            }
        }
        if (useWebGL) {
            if (gl) {
                initWebGLBuffers(I11);
                initWebGLTexture();
            }
        } else {
            this.l1il();
            this.l1ii = 0;
        }
        this.l1Ii();
        this.lIlj = true;
        Iij = false;
        this.hasConfig = true;
        ljj();
    };
    this.openUrl = function (url, target) {
        if (url.length > 0) {
            if (url.substr(0, 7) != "http://" && url.substr(0, 1) != "/") {
                url = basePath + url;
            }
            if (url.substr(url.length - 4) == ".xml" || url.substr(url.length - 4) == ".swf") {
                this.openNext(url, target);
            } else {
                window.open(url, target);
            }
        }
    };
    var jI1 = function () {
            l1.isLoaded = false;
            l1.hasConfig = false;
            l1.checkLoaded = new Array;
            if (l1.divSkin && l1.divSkin.ggReLoaded) {
                l1.divSkin.ggReLoaded();
            }
            percentLoaded = 0;
        };
    this.openNext = function (url, target) {
        jI1();
        if (l1.skinObj) {
            if (l1.skinObj.hotspotProxyOut) {
                l1.skinObj.hotspotProxyOut(l1.hotspot.id);
            }
        }
        if (url.substr(url.length - 4) == ".swf") {
            url = url.substr(0, url.length - 4) + ".xml";
        }
        var ll = target.replace("$cur", Il.I1i + "/" + lj.I1i + "/" + li.I1i);
        ll = ll.replace("$ap", Il.I1i);
        ll = ll.replace("$at", lj.I1i);
        ll = ll.replace("$af", li.I1i);
        l1.readConfigUrl(url);
        if (ll != "") {
            var lI1 = ll.split("/");
            if (lI1.length > 0) {
                this.setPan(Number(lI1[0]));
            }
            if (lI1.length > 1) {
                this.setTilt(Number(lI1[1]));
            }
            if (lI1.length > 2) {
                this.setFov(Number(lI1[2]));
            }
        }
        resetActivity();
    };
    this.detectBrowser();
    this.l1Ij(ili);
    this.assignHandler();
}