$(document).ready(() => {
    var cars = [];
    var models = [];
    //$("#models-input").prop("disabled", true);
    $(".color-picker").colorselector();
    var makes = [
        { name: "Acura" },
        { name: "Alfa-Romeo" },
        { name: "Aston Martin" },
        { name: "Audi" },
        { name: "BMW" },
        { name: "Bentley" },
        { name: "Buick" },
        { name: "Cadilac" },
        { name: "Chevrolet" },
        { name: "Chrysler" },
        { name: "Daewoo" },
        { name: "Daihatsu" },
        { name: "Dodge" },
        { name: "Eagle" },
        { name: "Ferrari" },
        { name: "Fiat" },
        { name: "Ford" },
        { name: "Freighliner" },
        { name: "Honda" },
        { name: "Hummer" },
        { name: "Hyundai" },
        { name: "Infinity" },
        { name: "Isuzu" },
        { name: "Jaguar" },
        { name: "Jeep" },
        { name: "Lamborghini" },
        { name: "Land Rover" },
        { name: "Lexus" },
        { name: "Lincoln" },
        { name: "Lotus" },
        { name: "Mazda" },
        { name: "Maserati" },
        { name: "Maybach" },
        { name: "McLaren" },
        { name: "Mercedez-Benz" },
        { name: "Mercury" },
        { name: "Mitsubishi" },
        { name: "Nissan" },
        { name: "Pontiac" },
        { name: "Porsche" },
        { name: "Ram" },
        { name: "Rolls_Royce" },
        { name: "Subaru" },
        //{ name: "Susuki" }, enable if the first api fails
        { name: "Suzuki" },
        { name: "Tesla" },
        { name: "Toyota" },
        { name: "Volkswagen" },
        { name: "Volvo" },
    ];
    function getMakesFromAPI(url) {
        $("#makes-input").html("");
        makes.forEach((car) => {
            var make = car.name;
            var option =
                '<option data-tokens="' + make + '">' + make + "</option>";
            if ($("#isUpdate").val() == "true") {
                const current_make = $("#default_make").val();

                if (
                    current_make
                        .replace("-", "_")
                        .replace(" ", "_")
                        .toLowerCase() ==
                    make.replace("-", "_").replace(" ", "_").toLowerCase()
                ) {
                    option =
                        '<option data-tokens="' +
                        make +
                        '" selected>' +
                        make +
                        "</option>";
                }
            }
            $("#makes-input").append(option);
        });
    }
    function getModelsFromAPI(url) {
        $("#models-container").html(
            '<select class="form-control selectpicker" id="models-input" name="model" data-live-search="true" required></select>'
        );
        /*$.getJSON(url, function (data) {
            data.Results.forEach((car) => {
                var model = car.Model_Name; //car.model_name;
                var option =
                    '<option data-tokens="' +
                    model +
                    '">' +
                    model +
                    "</option>";
                if ($("#isUpdate").val() == "true") {
                    const current_model = $("#default_model").val();

                    if (
                        current_model
                            .replace("-", "_")
                            .replace(" ", "_")
                            .toLowerCase() ==
                        model.replace("-", "_").replace(" ", "_").toLowerCase()
                    ) {
                        option =
                            '<option data-tokens="' +
                            model +
                            '" selected>' +
                            model +
                            "</option>";
                    }
                }
                $("#models-input").append(option);
            });
        });*/
        get_models($("#makes-input").val());
    }
    function get_models(str) {
        var string = str.replace("-", "_").replace(" ", "_");
        if (string == "Suzuki") {
            string = "susuki";
        }
        const make = string.charAt(0).toUpperCase() + string.slice(1);
        (async () => {
            const response = await fetch(
                "https://parseapi.back4app.com/classes/Car_Model_List_" +
                    make +
                    "?count=1&limit=100",
                {
                    headers: {
                        "X-Parse-Application-Id":
                            "hlhoNKjOvEhqzcVAJ1lxjicJLZNVv36GdbboZj3Z", // This is the fake app's application id
                        "X-Parse-Master-Key":
                            "SNMJJF0CZZhTPhLDIqGhTlUNV9r60M2Z5spyWfXW", // This is the fake app's readonly master key
                    },
                }
            );
            const data = await response.json(); // Here you have the data that you need
            const aux = JSON.stringify(data, null, 2);
            const array = JSON.parse(aux).results;
            //console.log(models.results);
            var models = [];
            for (let i = 0; i < array.length; i++) {
                const model = array[i].Model.replace("-", "_").replace(
                    " ",
                    "_"
                );
                models.push(model);
            }

            var unique = models.filter(onlyUnique);
            unique.forEach((model) => {
                $("#models-input").append(
                    '<option data-tokens="' + model + '">' + model + "</option>"
                );
            });
        })();
    }
    function onlyUnique(value, index, self) {
        return self.indexOf(value) === index;
    }

    function setAutoComplete(id, data) {
        $.typeahead({
            input: id,
            order: "desc",
            source: {
                data: data,
            },
            callback: {},
        });
    }

    function findMakes() {
        getMakesFromAPI(
            "https://www.carqueryapi.com/api/0.3/?callback=?&cmd=getMakes",
            cars
        );
    }

    function findModels() {
        var url =
            "https://vpic.nhtsa.dot.gov/api/vehicles/getmodelsformake/" +
            $("#makes-input").val().toLowerCase().replace("-", " ") +
            "?format=json";
        getModelsFromAPI(url, models);
    }

    /**
     *
     */
    function setAutoCompleteMakes() {
        setAutoComplete("#makes-input", cars);
    }
    function setAutoCompleteModels() {
        setAutoComplete("#models-input", models);
    }
    /**
     *
     */

    async function getMakes() {
        findMakes();
        await new Promise((resolve) => setTimeout(resolve, 800));
        $("#makes-input").selectpicker();
    }
    async function getModels() {
        await new Promise((resolve) => setTimeout(resolve, 400));
        findModels();
        await new Promise((resolve) => setTimeout(resolve, 800));
        $("#models-input").selectpicker();
    }

    getMakes();
    getModels();

    $(".input-images-1").imageUploader();

    $("#makes-input").on("change", () => {
        getModels();
    });
});
