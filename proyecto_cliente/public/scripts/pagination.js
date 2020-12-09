$(document).ready(function () {
    main($("#default-view").val());

    $("#post").click(function () {
        main("container");
    });

    $("#saved").click(function () {
        main("container1");
    });

    function main(container) {
        var itemSelector = ".grid-item";

        var $container = $("#" + container).isotope({
            itemSelector: itemSelector,
        });

        var itemsPerPageDefault = 10;
        var itemsPerPage = 2;
        var currentNumberPages = 1;
        var currentPage = 1;
        var currentFilter = "*";
        var filterAtribute = "data-filter";
        var pageAtribute = "data-page";
        var pagerClass = "isotope-pager";

        function changeFilter(selector) {
            $container.isotope({
                filter: selector,
            });
        }
        function goToPage(n) {
            currentPage = n;
            $(".pager").removeClass("current_page");
            $("#page-" + n).addClass("current_page");
            var selector = itemSelector;
            selector +=
                currentFilter != "*"
                    ? "[" + filterAtribute + '="' + currentFilter + '"]'
                    : "";
            selector += "[" + pageAtribute + '="' + currentPage + '"]';

            changeFilter(selector);
        }

        function setPagination() {
            var SettingsPagesOnItems = (function () {
                var itemsLength = $container.children(itemSelector).length;

                var pages = Math.ceil(itemsLength / itemsPerPage);
                var item = 1;
                var page = 1;
                var selector = itemSelector;
                selector +=
                    currentFilter != "*"
                        ? "[" + filterAtribute + '="' + currentFilter + '"]'
                        : "";

                $container.children(selector).each(function () {
                    if (item > itemsPerPage) {
                        page++;
                        item = 1;
                    }
                    $(this).attr(pageAtribute, page);
                    item++;
                });

                currentNumberPages = page;
            })();

            var CreatePagers = (function () {
                var $isotopePager =
                    $("." + pagerClass).length == 0
                        ? $('<div class="' + pagerClass + '"></div>')
                        : $("." + pagerClass);

                $isotopePager.html("");

                for (var i = 0; i < currentNumberPages; i++) {
                    var $pager = $(
                        '<a href="javascript:void(0);" id="page-' +
                            (i+1) +
                            '" class="pager" ' +
                            pageAtribute +
                            '="' +
                            (i + 1) +
                            '"></a>'
                    );
                    $pager.html(i + 1);

                    $pager.click(function () {
                        var page = $(this).eq(0).attr(pageAtribute);
                        goToPage(page);
                        $(".pager").removeClass("current_page");
                        $(this).addClass("current_page");
                        $("html, body").scrollTop(0);
                    });

                    $pager.appendTo($isotopePager);
                }

                $container.after($isotopePager);
            })();
        }

        setPagination();
        goToPage(1);

        //Adicionando Event de Click para as categorias
        $(".filters a").click(function () {
            var filter = $(this).attr(filterAtribute);
            currentFilter = filter;

            setPagination();
            goToPage(1);
        });
        //Evento Responsivo
    }
});
