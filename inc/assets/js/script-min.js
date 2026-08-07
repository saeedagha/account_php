function focustofield(a) {
    a.focus()
}

function totalEqual(output) {
    var r = output.val(),
        s = eval(r);
    output.val(s);
    var calcupd = localStorage.getItem("calcData"),
        newData = new Array;
    if (null !== calcupd) {
        var newData = JSON.parse(calcupd);
        newData.push(r + " = " + s)
    } else newData.push(r + " = " + s);
    localStorage.setItem("calcData", JSON.stringify(newData))
}
$(document).ready(function() {
    var a = $(".nk_calculator #result");
    focustofield(a), $(document).keypress(function(t) {
        var o = [];
        o.push(37, 40, 41, 42, 43, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57), 61 != t.which && 13 != t.which || (totalEqual(a), focustofield(a)), -1 == $.inArray(t.which, o)
    }), $(".nk_calculator .erase-cell").on("click", function() {
        a.val(a.val().substring(0, a.val().length - 1)), focustofield(a)
    }), $(".nk_calculator .calc-button").on("click", function() {
        var t = $(this),
            o = a.val();
        if (void 0 !== t.data("display") && (a.val(o + t.data("display")), focustofield(a)), void 0 !== t.data("action") && "clear" == t.data("action") && (a.val(""), focustofield(a)), void 0 !== t.data("action") && "total" == t.data("action") && (totalEqual(a), focustofield(a)), void 0 !== t.data("action") && "square" == t.data("action")) {
            var i = a.val();
            a.val(parseInt(i) * parseInt(i)), focustofield(a)
        }
        if (void 0 !== t.data("action") && "cos" == t.data("action")) {
            i = a.val();
            a.val(Math.cos(i)), focustofield(a)
        }
        if (void 0 !== t.data("action") && "sin" == t.data("action")) {
            i = a.val();
            a.val(Math.sin(i)), focustofield(a)
        }
        if (void 0 !== t.data("action") && "tan" == t.data("action")) {
            i = a.val();
            a.val(Math.tan(i)), focustofield(a)
        }
        if (void 0 !== t.data("action") && "squareroot" == t.data("action")) {
            i = a.val();
            a.val(Math.sqrt(i)), focustofield(a)
        }
        if (void 0 !== t.data("action") && "log" == t.data("action")) {
            i = a.val();
            a.val(Math.log(i)), focustofield(a)
        }
        if (void 0 !== t.data("action") && "history" == t.data("action")) {
            var l = $(".nk_calc_history");
            l.find("div").html("");
            var c = localStorage.getItem("calcData");
            if (null !== c)
                for (var n = JSON.parse(c), e = 0; e < n.length; e++) l.find("div").append("<p>" + n[e] + "</p>");
            else l.find("div").append("<p>No History Recorded</p>");
            l.animate({
                right: "0"
            }, "slow")
        }
    }), $(".nk_calc_history .closehistory").on("click", function() {
        $(this).closest(".nk_calc_history").animate({
            right: "-400px"
        }, "slow")
    }), $(".nk_moreitems a").on("click", function() {
        $(this).toggleClass("active"), $(".nk_calculator .morerows").slideToggle("fast"), $(".nk_moreitems a img").attr("src", "assets/images/more-light.png"), $(".nk_moreitems a.active img").attr("src", "assets/images/less-light.png")
    }), $(window).width() < 1090 && a.attr("readonly", "readonly")
});