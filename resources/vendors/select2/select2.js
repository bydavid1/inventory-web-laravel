!(function (t) {
    "use strict";
    function e(e) {
        e.element;
        return e.id ? "<i class='" + t(e.element).data("icon") + "'></i>" + e.text : e.text;
    }
    t(".select2").select2({ dropdownAutoWidth: !0, width: "100%" }),
        t(".select2-icons").select2({
            dropdownAutoWidth: !0,
            width: "100%",
            minimumResultsForSearch: 1 / 0,
            templateResult: e,
            templateSelection: e,
            escapeMarkup: function (e) {
                return e;
            },
        }),
        t(".max-length").select2({ dropdownAutoWidth: !0, width: "100%", maximumSelectionLength: 2, placeholder: "Select maximum 2 items" });
    var s = t(".js-example-programmatic").select2({ dropdownAutoWidth: !0, width: "100%" }),
        i = t(".js-example-programmatic-multi").select2();
    i.select2({ dropdownAutoWidth: !0, width: "100%", placeholder: "Programmatic Events" }),
        t(".js-programmatic-set-val").on("click", function () {
            s.val("CA").trigger("change");
        }),
        t(".js-programmatic-open").on("click", function () {
            s.select2("open");
        }),
        t(".js-programmatic-close").on("click", function () {
            s.select2("close");
        }),
        t(".js-programmatic-init").on("click", function () {
            s.select2();
        }),
        t(".js-programmatic-destroy").on("click", function () {
            s.select2("destroy");
        }),
        t(".js-programmatic-multi-set-val").on("click", function () {
            i.val(["CA", "AL"]).trigger("change");
        }),
        t(".js-programmatic-multi-clear").on("click", function () {
            i.val(null).trigger("change");
        });
    function c(e, t) {
        return 0 === t.toUpperCase().indexOf(e.toUpperCase());
    }
    t(".select2-data-array").select2({
        dropdownAutoWidth: !0,
        width: "100%",
        data: [
            { id: 0, text: "enhancement" },
            { id: 1, text: "bug" },
            { id: 2, text: "duplicate" },
            { id: 3, text: "invalid" },
            { id: 4, text: "wontfix" },
        ],
    }),
        t(".select2-data-ajax").select2({
            dropdownAutoWidth: !0,
            width: "100%",
            ajax: {
                url: "https://api.github.com/search/repositories",
                dataType: "json",
                delay: 250,
                data: function (e) {
                    return { q: e.term, page: e.page };
                },
                processResults: function (e, t) {
                    return (t.page = t.page || 1), { results: e.items, pagination: { more: 30 * t.page < e.total_count } };
                },
                cache: !0,
            },
            placeholder: "Search for a repository",
            escapeMarkup: function (e) {
                return e;
            },
            minimumInputLength: 1,
            templateResult: function (e) {
                if (e.loading) return e.text;
                var t =
                    "<div class='select2-result-repository clearfix'><div class='select2-result-repository__avatar'><img src='" +
                    e.owner.avatar_url +
                    "' /></div><div class='select2-result-repository__meta'><div class='select2-result-repository__title'>" +
                    e.full_name +
                    "</div>";
                e.description && (t += "<div class='select2-result-repository__description'>" + e.description + "</div>");
                return (t +=
                    "<div class='select2-result-repository__statistics'><div class='select2-result-repository__forks'><i class='icon-code-fork mr-0'></i> " +
                    e.forks_count +
                    " Forks</div><div class='select2-result-repository__stargazers'><i class='icon-star5 mr-0'></i> " +
                    e.stargazers_count +
                    " Stars</div><div class='select2-result-repository__watchers'><i class='icon-eye mr-0'></i> " +
                    e.watchers_count +
                    " Watchers</div></div></div></div>");
            },
            templateSelection: function (e) {
                return e.full_name || e.text;
            },
        }),
        t.fn.select2.amd.require(["select2/compat/matcher"], function (e) {
            t(".select2-customize-result").select2({ dropdownAutoWidth: !0, width: "100%", placeholder: "Search by 'r'", matcher: e(c) });
        }),
        t(".select2-theme").select2({ dropdownAutoWidth: !0, width: "100%", placeholder: "Classic Theme", theme: "classic" }),
        t(".select2-size-lg").select2({ dropdownAutoWidth: !0, width: "100%", containerCssClass: "select-lg" }),
        t(".select2-size-sm").select2({ dropdownAutoWidth: !0, width: "100%", containerCssClass: "select-sm" });
})((window, document, jQuery));
