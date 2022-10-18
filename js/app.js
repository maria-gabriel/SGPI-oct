"use strict";
(function (a) {
  var h = a(window),
    b = a("body");
  feather.replace({ "stroke-width": 2 });
  a(document).on("click", '[data-toggle="fullscreen"]', function () {
    a(this).toggleClass("active-fullscreen");
    if (document.fullscreenEnabled) {
      if (a(this).hasClass("active-fullscreen")) {
        document.documentElement.requestFullscreen();
      } else {
        document.exitFullscreen();
      }
    } else {
      alert("Your browser does not support fullscreen.");
    }
    return false;
  });
  a(document).on("click", ".overlay", function () {
    a.removeOverlay();
    if (b.hasClass("hidden-navigation")) {
      a(".navigation .navigation-menu-body").niceScroll().remove();
    }
    b.removeClass("navigation-show");
  });
  a.createOverlay = function () {
    if (a(".overlay").length < 1) {
      b.addClass("no-scroll").append('<div class="overlay"></div>');
      a(".overlay").addClass("show");
    }
  };
  a.removeOverlay = function () {
    b.removeClass("no-scroll");
    a(".overlay").remove();
  };
  a("[data-backround-image]").each(function (i) {
    a(this).css("background", "url(" + a(this).data("backround-image") + ")");
  });
  h.on("load", function () {
    setTimeout(function () {
      a(".navigation .navigation-menu-body ul li a").each(function () {
        var i = a(this);
        if (i.next("ul").length) {
          i.append('<i class="sub-menu-arrow ti-angle-up"></i>');
        }
      });
      a(".navigation .navigation-menu-body ul li.open>a>.sub-menu-arrow")
        .removeClass("ti-plus")
        .addClass("ti-minus")
        .addClass("rotate-in");
    }, 200);
  });
  a(document).on("click", "[data-nav-target]", function () {
    var i = a(this),
      j = i.data("nav-target");
    if (b.hasClass("navigation-toggle-one")) {
      b.addClass("navigation-show");
    }
    a(
      ".navigation .navigation-menu-body .navigation-menu-group > div"
    ).removeClass("open");
    a(".navigation .navigation-menu-body .navigation-menu-group " + j).addClass(
      "open"
    );
    a("[data-nav-target]").removeClass("active");
    i.addClass("active");
    i.tooltip("hide");
  });
  a(document).on("click", ".navigation-toggler a", function () {
    if (h.width() < 1200) {
      a.createOverlay();
      b.addClass("navigation-show");
    } else {
      if (
        !b.hasClass("navigation-toggle-one") &&
        !b.hasClass("navigation-toggle-two")
      ) {
        b.addClass("navigation-toggle-one");
      } else {
        if (
          b.hasClass("navigation-toggle-one") &&
          !b.hasClass("navigation-toggle-two")
        ) {
          b.addClass("navigation-toggle-two");
          b.removeClass("navigation-toggle-one");
        } else {
          if (
            !b.hasClass("navigation-toggle-one") &&
            b.hasClass("navigation-toggle-two")
          ) {
            b.removeClass("navigation-toggle-two");
            b.removeClass("navigation-toggle-one");
          }
        }
      }
    }
    return false;
  });
  a(document).on("click", ".header-toggler a", function () {
    a(".header ul.navbar-nav").toggleClass("open");
    return false;
  });
  a(document).on("click", "*", function (i) {
    if (
      !a(i.target).is(a(".navigation, .navigation *, .navigation-toggler *")) &&
      b.hasClass("navigation-toggle-one")
    ) {
      b.removeClass("navigation-show");
    }
  });
  a(document).on("click", "*", function (i) {
    if (
      !a(i.target).is(
        ".header ul.navbar-nav, .header ul.navbar-nav *, .header-toggler, .header-toggler *"
      )
    ) {
      a(".header ul.navbar-nav").removeClass("open");
    }
  });
  window.addEventListener(
    "load",
    function () {
      var i = document.getElementsByClassName("needs-validation");
      Array.prototype.filter.call(i, function (j) {
        j.addEventListener(
          "submit",
          function (k) {
            if (j.checkValidity() === false) {
              k.preventDefault();
              k.stopPropagation();
            }
            j.classList.add("was-validated");
          },
          false
        );
      });
    },
    false
  );
  var g = a(".table-responsive-stack");
  g.find("th").each(function (j) {
    a(".table-responsive-stack td:nth-child(" + (j + 1) + ")").prepend(
      '<span class="table-responsive-stack-thead">' +
        a(this).text() +
        ":</span> "
    );
    a(".table-responsive-stack-thead").hide();
  });
  g.each(function () {
    var j = a(this).find("th").length,
      i = 100 / j + "%";
    a(this).find("th, td").css("flex-basis", i);
  });
  function e() {
    if (h.width() < 768) {
      a(".table-responsive-stack").each(function (j) {
        a(this).find(".table-responsive-stack-thead").show();
        a(this).find("thead").hide();
      });
    } else {
      a(".table-responsive-stack").each(function (j) {
        a(this).find(".table-responsive-stack-thead").hide();
        a(this).find("thead").show();
      });
    }
  }
  e();
  window.onresize = function (i) {
    e();
  };
  a(document).on(
    "click",
    '[data-toggle="search"], [data-toggle="search"] *',
    function () {
      a(".header .header-body .header-search")
        .show()
        .find(".form-control")
        .focus();
      return false;
    }
  );
  a(document).on(
    "click",
    ".close-header-search, .close-header-search svg",
    function () {
      a(".header .header-body .header-search").hide();
      return false;
    }
  );
  a(document).on("click", "*", function (i) {
    if (
      !a(i.target).is(
        a(
          '.header, .header *, [data-toggle="search"], [data-toggle="search"] *'
        )
      )
    ) {
      a(".header .header-body .header-search").hide();
    }
  });
  a(document).on(
    "click",
    ".accordion.custom-accordion .accordion-row a.accordion-header",
    function () {
      var i = a(this);
      i.closest(".accordion.custom-accordion")
        .find(".accordion-row")
        .not(i.parent())
        .removeClass("open");
      i.parent(".accordion-row").toggleClass("open");
      return false;
    }
  );
  var d,
    f = a(".table-responsive");
  f.on("show.bs.dropdown", function (i) {
    d = a(i.target).find(".dropdown-menu");
    b.append(d.detach());
    var j = a(i.target).offset();
    d.css({
      display: "block",
      top: j.top + a(i.target).outerHeight(),
      left: j.left,
      width: "184px",
      "font-size": "14px",
    });
    d.addClass("mobPosDropdown");
  });
  f.on("hide.bs.dropdown", function (i) {
    a(i.target).append(d.detach());
    d.hide();
  });
  a(document).on(
    "click",
    ".chat-app-wrapper .btn-chat-sidebar-open",
    function () {
      a(".chat-app-wrapper .chat-sidebar").addClass("chat-sidebar-opened");
      return false;
    }
  );
  a(document).on("click", "*", function (i) {
    if (
      !a(i.target).is(
        ".chat-app-wrapper .chat-sidebar, .chat-app-wrapper .chat-sidebar *, .chat-app-wrapper .btn-chat-sidebar-open, .chat-app-wrapper .btn-chat-sidebar-open *"
      )
    ) {
      a(".chat-app-wrapper .chat-sidebar").removeClass("chat-sidebar-opened");
    }
  });
  a(document).on("click", ".navigation ul li a", function () {
    var i = a(this);
    if (i.next("ul").length) {
      var j = i.find(".sub-menu-arrow");
      j.toggleClass("rotate-in");
      i.next("ul").toggle(200);
      i.parent("li")
        .siblings()
        .find("ul")
        .not(i.parent("li").find("ul"))
        .slideUp(200);
      i.next("ul").find("li ul").slideUp(200);
      i.next("ul")
        .find("li>a")
        .find(".sub-menu-arrow")
        .removeClass("ti-minus")
        .addClass("ti-plus");
      i.next("ul")
        .find("li>a")
        .find(".sub-menu-arrow")
        .removeClass("rotate-in");
      i.parent("li")
        .siblings()
        .not(i.parent("li").find("ul"))
        .find(">a")
        .find(".sub-menu-arrow")
        .removeClass("ti-minus")
        .addClass("ti-plus");
      i.parent("li")
        .siblings()
        .not(i.parent("li").find("ul"))
        .find(">a")
        .find(".sub-menu-arrow")
        .removeClass("rotate-in");
      if (j.hasClass("rotate-in")) {
        setTimeout(function () {
          j.removeClass("ti-plus").addClass("ti-minus");
        }, 200);
      } else {
        j.removeClass("ti-minus").addClass("ti-plus");
      }
      if (!b.hasClass("horizontal-side-menu") && h.width() >= 1200) {
        setTimeout(function (k) {
          a(".navigation .navigation-menu-body").getNiceScroll().resize();
        }, 300);
      }
      return false;
    }
  });
  a("body.small-navigation .navigation").hover(
    function (i) {
      if (
        b.hasClass("small-navigation") &&
        !b.hasClass("horizontal-navigation") &&
        !b.hasClass("hidden-navigation") &&
        h.width() >= 992
      ) {
        a(".navigation .navigation-menu-body").niceScroll();
      }
    },
    function () {
      a(".navigation .navigation-menu-body").getNiceScroll().remove();
      a(".navigation ul").attr("style", null);
    }
  );
  a(document).on("click", ".dropdown-menu", function (i) {
    i.stopPropagation();
  });
  a("#exampleModal").on("show.bs.modal", function (j) {
    var i = a(j.relatedTarget),
      l = i.data("whatever"),
      k = a(this);
    k.find(".modal-title").text("New message to " + l);
    k.find(".modal-body input").val(l);
  });
  a('[data-toggle="tooltip"]').tooltip({ container: "body" });
  a('[data-toggle="popover"]').popover();
  a(".carousel").carousel();
  if (h.width() >= 992) {
    a(".card-scroll").niceScroll();
    a(".table-responsive").niceScroll();
    a(".app-block .app-content .app-lists").niceScroll();
    a(".app-block .app-sidebar .app-sidebar-menu").niceScroll();
    a(".chat-block .chat-sidebar .chat-sidebar-content").niceScroll();
    var c = a(".chat-block .chat-content .messages");
    if (c.length) {
      c.niceScroll({ horizrailenabled: false });
      c.getNiceScroll(0).doScrollTop(c.get(0).scrollHeight, -1);
    }
  }
  if (
    !b.hasClass("small-navigation") &&
    !b.hasClass("horizontal-navigation") &&
    !b.hasClass("hidden-navigation") &&
    h.width() >= 992
  ) {
    a(".navigation .navigation-menu-body").niceScroll();
  }
  a(".dropdown-menu ul.list-group").niceScroll();
  a(document).on(
    "click",
    ".chat-block .chat-content .mobile-chat-close-btn a",
    function () {
      a(".chat-block .chat-content").removeClass("mobile-open");
      return false;
    }
  );
  
})(jQuery);

function toask_error(e) {
    $(".preloader").fadeOut(400, function() {
        setTimeout(function() {
            toastr.options = {
                timeOut: 5000,
                progressBar: true,
                showMethod: "slideDown",
                hideMethod: "slideUp",
                showDuration: 200,
                hideDuration: 300,
                positionClass: "toast-bottom-center",
            };
            toastr.error("Operación no exitosa");
            a(".theme-switcher").removeClass("open")
        }, 500)
    });
    console.log(e);
}
