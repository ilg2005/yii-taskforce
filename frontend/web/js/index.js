/*let locationFieldElement = document.querySelector('#autoComplete');
locationFieldElement.addEventListener('change', function (evt) {
    evt.preventDefault();
    let query = locationFieldElement.value;
    $.ajax({
        url: '/address/index',
        data: {query: query},
        type: 'GET',
        success: function (response) {
            let responseObj = JSON.parse(response);
            console.log(responseObj);
        },
        error: function () {
            alert('Ошибка: Данные геокодера не получены!');
        }
    });
});*/


if (document.querySelector("#autoComplete")) {
    const autoCompletejs = new autoComplete({
        data: {
            src: async function () {
                let query = document.querySelector("#autoComplete").value;
                if (query) {
                    const source = await fetch("/address/index?" + new URLSearchParams({
                        query: query
                    }));
                    console.log(source)
                    return source.json();
                }

                return [];
            },
            key: [""],
            cache: false
        },
        trigger: {
            event: ["input", "focusin"]
        },
        threshold: 2,
        debounce: 300,
        searchEngine: "loose",
        highlight: false,
        maxResults: 5,
        resultsList: {
            render: true,
        },
        resultItem: {
            element: "p"
        },
        onSelection: function (feedback) {
            document.querySelector("#autoComplete").blur();

            const point = feedback.selection.value.point.split(' ');
            document.querySelector("#longitude").value = point[0];
            document.querySelector("#latitude").value = point[1];
            document.querySelector("#locality").value = feedback.selection.value.locality;

            const selection = feedback.selection.value.city;
            document.querySelector("#autoComplete_list").innerHTML = selection;
            // Clear Input
            document.querySelector("#autoComplete").value = selection;
            // Change placeholder with the selected value
            document.querySelector("#autoComplete").setAttribute("placeholder", selection);
            // Concole log autoComplete data feedback
        },
    });
}

