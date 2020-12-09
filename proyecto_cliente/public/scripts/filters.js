// External js: jquery, isotope.pkgd.js, bootstrap.min.js, bootstrap-slider.js
$(document).ready(function () {
    // Create object to store filter for each group
    var buttonFilters = {};
    var buttonFilter = "*";
    // Create new object for the range filters and set default values,
    // The default values should correspond to the default values from the slider
    var rangeFilters = {
        price: { min: 800, max: 200000 },
        year: { min: 1960, max: 2020 },
    };

    // Initialise Isotope
    // Set the item selector
    const itemSelector = ".car";

    var responsiveIsotope = [
        [480, 4],
        [720, 6],
    ];
    var itemsPerPageDefault = 10;
    var itemsPerPage = 10;
    var currentNumberPages = 1;
    var currentPage = 1;
    var currentFilter = "*";
    var filterValue = "";
    var pageAttribute = "data-page";
    var pagerClass = "isotope-pager";
    var $checkboxes = $(".btn-filter");

    const $grid = $(".autos-container").isotope({ itemSelector: itemSelector });

    // Initialise Sliders
    // Set min/max range on sliders as well as default values
    var $priceSlider = $("#filter-price").slider({
        tooltip_split: true,
        min: 800,
        max: 200000,
        range: true,
        value: [2000, 35000],
    });
    var $yearSlider = $("#filter-year").slider({
        tooltip_split: true,
        min: 1960,
        max: 2020,
        range: true,
        value: [2000, 2018],
    });

    function updateRangeSlider(slider, slideEvt) {
        //console.log("Current slider:" + slider);
        var sldmin = +slideEvt.value[0],
            sldmax = +slideEvt.value[1],
            // Find which filter group this slider is in (in this case it will be either height or weight)
            // This can be changed by modifying the data-filter-group="age" attribute on the slider HTML
            filterGroup = slider.attr("data-filter-group"),
            // Set current selection in variable that can be pass to the label
            currentSelection = sldmin + " - " + sldmax;

        // Update filter label with new range selection
        slider
            .siblings(".filter-label")
            .find(".filter-selection")
            .text(currentSelection);
        //
        rangeFilters[filterGroup] = {
            min: sldmin || 0,
            max: sldmax || 200000,
        };

        // Trigger isotope again to refresh layout
        setPagination();
        goToPage(1);
    }

    // Trigger Isotope Filter when slider drag has stopped
    $priceSlider.on("slideStop", function (slideEvt) {
        var $this = $(this);
        updateRangeSlider($this, slideEvt);
    });
    $yearSlider.on("slideStop", function (slideEvt) {
        var $this = $(this);
        updateRangeSlider($this, slideEvt);
    });

    $(".filters").on("click", ".btn-filter", function (evt) {
        evt.preventDefault();
        var $this = $(this);
        var $buttonGroup = $this.parents(".btn-groupp");
        var filterGroup = $buttonGroup.attr("data-filter-group");
        buttonFilters[filterGroup] = $this.attr("data-filter");
        buttonFilter = concatValues(buttonFilters) || "*";
        currentFilter = buttonFilter;
        $("[btn-filter='" + $(this).attr("btn-filter") + "']").removeClass(
            "is-checked"
        );
        $(this).toggleClass("is-checked");
        setPagination();
        goToPage(1);
    });

    // change is-checked class on btn-filter to toggle which one is active
    /*$(".filters").each(function (i, buttonGroup) {
        var $buttonGroup = $(buttonGroup);
        $buttonGroup.on("click", ".btn-filter", function (evt) {
            evt.preventDefault();
            $buttonGroup
                .find("[btn-filter='" + $(this).attr("btn-filter") + "']")
                .removeClass("is-checked");
            $(this).toggleClass("is-checked");
        });
        itemsPerPage = defineItemsPerPage();
    });*/
    // update items based on current filters
    function changeFilter(selector) {
        $grid.isotope({
            filter: function () {
                var $this = $(this);
                var price = $this.attr("data-price");
                var year = $this.attr("data-year");
                var isInPriceRange =
                    rangeFilters["price"].min <= price &&
                    rangeFilters["price"].max >= price;
                var isInYearRange =
                    rangeFilters["year"].min <= year &&
                    rangeFilters["year"].max >= year;
                // Debug to check whether an item is within the height weight range
                return $this.is(selector) && isInPriceRange && isInYearRange;
            },
        });
    }

    //grab all checked filters and goto page on fresh isotope output
    function goToPage(n) {
        currentPage = n;
        $('.pager').removeClass('current_page');
        $('#page-'+n).addClass('current_page');
        var selector = itemSelector;
        var exclusives = [];
        // for each box checked, add its value and push to array
        var num = 0;
        for (let i = 1; i < $checkboxes.length; i++) {
            var elem = $checkboxes[i];

            if ($checkboxes[num].classList[4] == "is-checked") {
                selector +=
                    currentFilter != "*"
                        ? $checkboxes[num].getAttribute("data-filter")
                        : "";
                exclusives.push(selector);
            }
            num++;
        }
        // smash all values back together for 'and' filtering
        //filterValue = exclusives.length ? exclusives.join("") : "*";

        // add page number to the string of filters
        var wordPage = currentPage.toString();
        filterValue = buttonFilter;
        filterValue += "." + wordPage;
        changeFilter(filterValue);
    }

    // determine page breaks based on window width and preset values
    function defineItemsPerPage() {
        var pages = itemsPerPageDefault;

        for (var i = 0; i < responsiveIsotope.length; i++) {
            if ($(window).width() <= responsiveIsotope[i][0]) {
                pages = responsiveIsotope[i][1];
                break;
            }
        }

        return pages;
    }

    function setPagination() {
        //const elemt = document.getElementById("prueba-mitsubishi");
        //console.log(elemt.getAttribute("value"));
        itemsPerPage = defineItemsPerPage();
        var SettingsPagesOnItems = (function () {
            var itemsLength = $grid.children(itemSelector).length;
            var pages = Math.ceil(itemsLength / itemsPerPage);
            var item = 1;
            var page = 1;
            var selector = itemSelector;
            var exclusives = [];
            // for each box checked, add its value and push to array
            var num = 0;
            for (let i = 1; i < $checkboxes.length; i++) {
                var elem = $checkboxes[i];

                if ($checkboxes[num].classList[4] == "is-checked") {
                    selector +=
                        currentFilter != "*"
                            ? $checkboxes[num].getAttribute("data-filter")
                            : "";
                    exclusives.push(selector);
                }
                num++;
            }

            // smash all values back together for 'and' filtering
            filterValue = exclusives.length ? exclusives.join("") : "*";
            // find each child element with current filter values
            $grid.children(filterValue).each(function () {
                // increment page if a new one is needed
                if (item > itemsPerPage) {
                    page++;
                    item = 1;
                }
                // add page number to element as a class
                wordPage = page.toString();
                var classes = $(this).attr("class").split(" ");
                var lastClass = classes[classes.length - 1];
                // last class shorter than 4 will be a page number, if so, grab and replace
                if (lastClass.length < 4) {
                    $(this).removeClass();
                    classes.pop();
                    classes.push(wordPage);
                    classes = classes.join(" ");
                    $(this).addClass(classes);
                } else {
                    // if there was no page number, add it
                    $(this).addClass(wordPage);
                }
                item++;
            });
            currentNumberPages = page;
        })();

        // create page number navigation
        var CreatePagers = (function () {
            var $isotopePager =
                $("." + pagerClass).length == 0
                    ? $('<div class="' + pagerClass + '"></div>')
                    : $("." + pagerClass);

            $isotopePager.html("");
            if (currentNumberPages > 1) {
                for (var i = 0; i < currentNumberPages; i++) {
                    var $pager = $(
                        '<a href="javascript:void(0);" class="pager" id="page-' +
                            (i+1) +
                            '"' +
                            pageAttribute +
                            '="' +
                            (i + 1) +
                            '"></a>'
                    );
                    $pager.html(i + 1);

                    $pager.click(function () {
                        var page = $(this).eq(0).attr(pageAttribute);
                        goToPage(page);
                        $('.pager').removeClass('current_page');
                        $(this).addClass('current_page');
                        $("html, body").scrollTop(0);
                    });
                    $pager.appendTo($isotopePager);
                }
            }
            $grid.after($isotopePager);
        })();
    }
    // remove checks from all boxes and refilter
    function clearAll() {
        $checkboxes.each(function (i, elem) {
            if (elem.classList[4] == "is-checked") {
                elem.classList[4] = "";
            }
        });
        currentFilter = "*";
        setPagination();
        goToPage(1);
    }

    setPagination();
    goToPage(1);
    //event handlers
    /*$checkboxes.change(function () {
        var filter = $(this).attr(filterAttribute);
        currentFilter = filter;
        setPagination();
        goToPage(1);
    });*/

    $("#clear-filters").click(function () {
        clearAll();
    });

    $(window).resize(function () {
        itemsPerPage = defineItemsPerPage();
        setPagination();
        goToPage(1);
    });

    /**
     * PAGINATION
     */
});
// Flatten object by concatting values
function concatValues(obj) {
    var value = "";
    for (var prop in obj) {
        value += obj[prop];
    }
    return value;
}
