<style>
    /* Styling za container */
    .tabs-container {
        margin-top: 20px;
    }

    /* Stil za tab dugmad */
    .tab-buttons {
        display: flex;
        border-bottom: 2px solid #ccc;
    }

    .tab-buttons button {
        flex: 1;
        padding: 10px 15px;
        cursor: pointer;
        background-color: #f1f1f1;
        border: none;
        border-bottom: 2px solid transparent;
        font-size: 16px;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .tab-buttons button.active {
        background-color: white;
        border-bottom: 2px solid #007bff;
        font-weight: bold;
    }

    /* Stil za sadržaj tabova */
    .tab-content {
        display: none;
        padding: 20px;
        border: 1px solid #ccc;
        border-top: none;
    }

    .tab-content.active {
        display: block;
    }
</style>

<div class="card">
    <div class="card-body">
        <div class="">

            <div class="row">
                <h2>Reports</h2>

                <div class="col-12">
                    <p>Select a period</p>
                </div>
                <div class="col-md-12 bg-gray-300 pb-3 border-radius-lg">
                    <div class="row col-md-6">
                        <div class="col-md-6">
                            <label for="from">From:</label>
                            <input type="date" class="form-control date-helper" placeholder="From" id="from">
                        </div>
                        <div class="col-md-6">
                            <label for="from">To:</label>
                            <input type="date" class="form-control date-helper" placeholder="To" id="to">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tabs Container -->
            <div class="tabs-container">
                <!-- Tab Buttons -->
                <div class="tab-buttons">
                    <button class="tab-button active" data-tab="clicks">Clicks Reports</button>
                    <button class="tab-button" data-tab="views">Views Reports</button>
                </div>

                <!-- Tab Content -->
                <div class="tab-content active" id="clicks">
                    <h3>Clicks Reports</h3>
                    <p>Click reports are displayed here</p>
                    <div class="row mt-4">
                        <div class="col-md-6 border border-radius-lg p-3">
                            <h4>Clicks by gender</h4>
                            <div id="clicks-by-gender-canvas"></div>
                        </div>
                        <div class="col-md-6 border border-radius-lg p-3">
                            <h4>Clicks by age groups</h4>
                            <div id="clicks-by-age-group-canvas"></div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12 border border-radius-lg p-3">
                            <h4>Clicks By Ad Over Time</h4>
                            <div id="clicks-by-ad-canvas"></div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 border border-radius-lg p-3">
                            <h4>Clicks By User</h4>
                            <div id="clicks-by-user-canvas"></div>
                        </div>
                    </div>
                </div>

                <!--        -->
                <div class="tab-content" id="views">
                    <h3>Views Report</h3>
                    <p>Views reports are displayed here</p>
                    <div class="row mt-4">
                        <div class="col-md-6 border border-radius-lg p-3">
                            <h4>Views by gender</h4>
                            <div id="views-by-gender-canvas"></div>
                        </div>
                        <div class="col-md-6 border border-radius-lg p-3">
                            <h4>Views by age groups</h4>
                            <div id="views-by-age-group-canvas"></div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12 border border-radius-lg p-3">
                            <h4>Views By Ad Over Time</h4>
                            <div id="views-by-ad-canvas"></div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12 border border-radius-lg p-3">
                            <h4>Views By User</h4>
                            <div id="views-by-user-canvas"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Selektovanje dugmadi i sadržaja
        const buttons = document.querySelectorAll('.tab-button');
        const contents = document.querySelectorAll('.tab-content');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                // Deaktiviraj sve dugmadi i sakrij sav sadržaj
                buttons.forEach(btn => btn.classList.remove('active'));
                contents.forEach(content => content.classList.remove('active'));

                // Aktiviraj trenutno dugme i prikaži odgovarajući sadržaj
                this.classList.add('active');
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');

                // Dohvati vrednosti `from` i `to` (ako su potrebni)
                const from = document.querySelector('#from')?.value || '';
                const to = document.querySelector('#to')?.value || '';
                console.log(`Tab "${tabId}" selected with parameters: from=${from}, to=${to}`);
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        generateClicksByGender();
        generateClicksByAgeGroup();
        generateClicksByAdOverTime();
        generateClicksByUser();

        //views
        generateViewsByGender();
        generateViewsByAgeGroup();
        generateViewsByAdOverTime();
        generateViewsByUser();

        $(".date-helper").change(function () {
            generateClicksByGender();
            generateClicksByAgeGroup();
            generateClicksByAdOverTime();
            generateClicksByUser();

            //views
            generateViewsByGender();
            generateViewsByAgeGroup();
            generateViewsByAdOverTime();
            generateViewsByUser();
        });

    });

    function generateClicksByGender() {
        // Resetovanje platna za grafikon
        $("#clicks-by-gender-canvas").empty();
        $("#clicks-by-gender-canvas").append(
            '<canvas id="clicks-by-gender"' +
            ' style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block;"' +
            ' class="chartjs-render-monitor"></canvas>'
        );

        let from = $("#from").val();
        let to = $("#to").val();

        let url = `/getClicksByGender?from=${from}&to=${to}`;

        $.getJSON(url, function (result) {
            // Mapiranje podataka iz JSON odgovora
            let labels = result.map(function (e) {
                return e.gender_id === "1" ? "Muški" : "Ženski";
            });

            let values = result.map(function (e) {
                return parseInt(e.clicks, 10);
            });

            // Priprema podataka za Chart.js
            let setData = {
                labels: labels,
                datasets: [
                    {
                        label: "Klikovi po polu",
                        data: values,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }
                ]
            };

            let options = {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            };

            let graph = $("#clicks-by-gender").get(0).getContext('2d');

            createGraph(setData, graph, 'pie', options);
        });
    }
    function generateViewsByGender() {
        // Resetovanje platna za grafikon
        $("#views-by-gender-canvas").empty();
        $("#views-by-gender-canvas").append(
            '<canvas id="views-by-gender"' +
            ' style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block;"' +
            ' class="chartjs-render-monitor"></canvas>'
        );

        let from = $("#from").val();
        let to = $("#to").val();

        let url = `/getViewsByGender?from=${from}&to=${to}`;

        $.getJSON(url, function (result) {
            // Mapiranje podataka iz JSON odgovora
            let labels = result.map(function (e) {
                return e.gender_id === "1" ? "Muški" : "Ženski";
            });

            let values = result.map(function (e) {
                return parseInt(e.views, 10);
            });

            // Priprema podataka za Chart.js
            let setData = {
                labels: labels,
                datasets: [
                    {
                        label: "Pregledi po polu",
                        data: values,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }
                ]
            };

            let options = {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            };

            let graph = $("#views-by-gender").get(0).getContext('2d');

            createGraphA(setData, graph, 'pie', options);
        });
    }
    function createGraphA(setData, graph, chartType, options) {
        new Chart(graph, {
            type: chartType,
            data: setData,
            options: options
        });
    }
    function createGraph(setData, graph, chartType, options) {
        new Chart(graph, {
            type: chartType,
            data: setData,
            options: options
        });
    }



    function generateClicksByAgeGroup() {
        // Resetovanje platna za grafikon
        $("#clicks-by-age-group-canvas").empty();
        $("#clicks-by-age-group-canvas").append(
            '<canvas id="clicks-by-age-group"' +
            ' style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block;"' +
            ' class="chartjs-render-monitor"></canvas>'
        );

        let from = $("#from").val();
        let to = $("#to").val();

        let url = `/getClicksByAgeGroup?from=${from}&to=${to}`;

        $.getJSON(url, function (result) {
            // Mapiranje podataka iz JSON odgovora
            let labels = result.map(function (e) {
                return e.age_group;
            });

            let values = result.map(function (e) {
                return parseInt(e.clicks, 10);
            });

            // Priprema podataka za Chart.js
            let setData = {
                labels: labels,
                datasets: [
                    {
                        label: "Klikovi po starosnim grupama",
                        data: values,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }
                ]
            };

            let options = {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            };

            let graph = $("#clicks-by-age-group").get(0).getContext('2d');

            createGraphForAges(setData, graph, 'pie', options);
        });
    }
    function generateViewsByAgeGroup() {
        // Resetovanje platna za grafikon
        $("#views-by-age-group-canvas").empty();
        $("#views-by-age-group-canvas").append(
            '<canvas id="views-by-age-group"' +
            ' style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block;"' +
            ' class="chartjs-render-monitor"></canvas>'
        );

        let from = $("#from").val();
        let to = $("#to").val();

        let url = `/getViewsByAgeGroup?from=${from}&to=${to}`;

        $.getJSON(url, function (result) {
            // Mapiranje podataka iz JSON odgovora
            let labels = result.map(function (e) {
                return e.age_group;
            });

            let values = result.map(function (e) {
                return parseInt(e.views, 10);
            });

            // Priprema podataka za Chart.js
            let setData = {
                labels: labels,
                datasets: [
                    {
                        label: "Klikovi po starosnim grupama",
                        data: values,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }
                ]
            };

            let options = {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            };

            let graph = $("#views-by-age-group").get(0).getContext('2d');

            createGraphForAges(setData, graph, 'pie', options);
        });
    }
    function createGraphForAges(setData, graph, chartType, options) {
        new Chart(graph, {
            type: chartType,
            data: setData,
            options: options
        });
    }

    function generateClicksByAdOverTime() {
        // Resetovanje platna za grafikon
        $("#clicks-by-ad-canvas").empty();
        $("#clicks-by-ad-canvas").append(
            '<canvas id="clicks-by-ad"' +
            ' style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block;"' +
            ' class="chartjs-render-monitor"></canvas>'
        );

        let from = $("#from").val();
        let to = $("#to").val();

        let url = `/getClicksByAdOverTime?from=${from}&to=${to}`;

        $.getJSON(url, function (result) {
            // Mapiranje podataka iz JSON odgovora
            let adData = {};
            result.forEach(function (row) {
                if (!adData[row.ad_text]) {
                    adData[row.ad_text] = { labels: [], data: [] };
                }
                adData[row.ad_text].labels.push(row.click_date);
                adData[row.ad_text].data.push(parseInt(row.click_count, 10));
            });

            // Priprema podataka za Chart.js
            let datasets = [];
            Object.keys(adData).forEach(function (adText) {
                datasets.push({
                    label: adText,
                    data: adData[adText].data,
                    fill: false,
                    borderColor: getRandomColor(),
                    tension: 0.1
                });
            });

            let setData = {
                labels: Object.values(adData)[0]?.labels || [], // Datumi iz prvog oglasa
                datasets: datasets
            };

            let options = {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: { title: { display: true, text: 'Datum' } },
                    y: { title: { display: true, text: 'Broj Klikova' }, beginAtZero: true }
                }
            };

            let graph = $("#clicks-by-ad").get(0).getContext('2d');

            createGraphClicksByAd(setData, graph, 'line', options);
        });
    }
    function generateViewsByAdOverTime() {
        // Resetovanje platna za grafikon
        $("#views-by-ad-canvas").empty();
        $("#views-by-ad-canvas").append(
            '<canvas id="viewa-by-ad"' +
            ' style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block;"' +
            ' class="chartjs-render-monitor"></canvas>'
        );

        let from = $("#from").val();
        let to = $("#to").val();

        let url = `/getViewsByAdOverTime?from=${from}&to=${to}`;

        $.getJSON(url, function (result) {
            // Mapiranje podataka iz JSON odgovora
            let adData = {};
            result.forEach(function (row) {
                if (!adData[row.ad_text]) {
                    adData[row.ad_text] = { labels: [], data: [] };
                }
                adData[row.ad_text].labels.push(row.view_date);
                adData[row.ad_text].data.push(parseInt(row.view_count, 10));
            });

            // Priprema podataka za Chart.js
            let datasets = [];
            Object.keys(adData).forEach(function (adText) {
                datasets.push({
                    label: adText,
                    data: adData[adText].data,
                    fill: false,
                    borderColor: getRandomColor(),
                    tension: 0.1
                });
            });

            let setData = {
                labels: Object.values(adData)[0]?.labels || [], // Datumi iz prvog oglasa
                datasets: datasets
            };

            let options = {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: { title: { display: true, text: 'Datum' } },
                    y: { title: { display: true, text: 'Broj Klikova' }, beginAtZero: true }
                }
            };

            let graph = $("#viewa-by-ad").get(0).getContext('2d');

            createGraphClicksByAd(setData, graph, 'line', options);
        });
    }
    function createGraphClicksByAd(setData, graph, chartType, options) {
        new Chart(graph, {
            type: chartType,
            data: setData,
            options: options
        });
    }

    // Generisanje random boje za svaki oglas
    function getRandomColor() {
        const r = Math.floor(Math.random() * 255);
        const g = Math.floor(Math.random() * 255);
        const b = Math.floor(Math.random() * 255);
        return `rgba(${r}, ${g}, ${b}, 1)`;
    }

    function generateClicksByUser() {
        // Resetovanje platna za grafikon
        $("#clicks-by-user-canvas").empty();
        $("#clicks-by-user-canvas").append(
            '<canvas id="clicks-by-user"' +
            ' style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block;"' +
            ' class="chartjs-render-monitor"></canvas>'
        );

        let from = $("#from").val();
        let to = $("#to").val();

        let url = `/getClicksByUser?from=${from}&to=${to}`;

        $.getJSON(url, function (result) {
            // Mapiranje podataka iz JSON odgovora
            let labels = result.map(function (e) {
                return e.user_name;
            });

            let values = result.map(function (e) {
                return parseInt(e.click_count, 10);
            });

            // Priprema podataka za Chart.js
            let setData = {
                labels: labels,
                datasets: [
                    {
                        label: "Broj Klikova po Korisnicima",
                        data: values,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            };

            let options = {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: { title: { display: true, text: 'Korisnici' } },
                    y: { title: { display: true, text: 'Broj Klikova' }, beginAtZero: true }
                }
            };

            let graph = $("#clicks-by-user").get(0).getContext('2d');

            createGraphClicksByUser(setData, graph, 'bar', options);
        });
    }
    function generateViewsByUser() {
        // Resetovanje platna za grafikon
        $("#views-by-user-canvas").empty();
        $("#views-by-user-canvas").append(
            '<canvas id="views-by-user"' +
            ' style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block;"' +
            ' class="chartjs-render-monitor"></canvas>'
        );

        let from = $("#from").val();
        let to = $("#to").val();

        let url = `/getViewsByUser?from=${from}&to=${to}`;

        $.getJSON(url, function (result) {
            // Mapiranje podataka iz JSON odgovora
            let labels = result.map(function (e) {
                return e.user_name;
            });

            let values = result.map(function (e) {
                return parseInt(e.views_count, 10);
            });

            // Priprema podataka za Chart.js
            let setData = {
                labels: labels,
                datasets: [
                    {
                        label: "Broj Pregleda po Korisnicima",
                        data: values,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            };

            let options = {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: { title: { display: true, text: 'Korisnici' } },
                    y: { title: { display: true, text: 'Broj Pregleda' }, beginAtZero: true }
                }
            };

            let graph = $("#views-by-user").get(0).getContext('2d');

            createGraphClicksByUser(setData, graph, 'bar', options);
        });
    }
    function createGraphClicksByUser(setData, graph, chartType, options) {
        new Chart(graph, {
            type: chartType,
            data: setData,
            options: options
        });
    }
</script>


<!--<script>-->
<!--    $(document).ready(function () {-->
<!--        generatePricePerUser();-->
<!---->
<!--        $(".date-helper").change(function () {-->
<!--            generatePricePerUser();-->
<!--        });-->
<!--    });-->
<!---->
<!--    function generatePricePerUser() {-->
<!--        $("#price-per-user-canvas").empty();-->
<!--        $("#price-per-user-canvas").append(-->
<!--            ' <canvas id="price-per-user"' +-->
<!--            'style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 634px;"' +-->
<!--            'class="chartjs-render-monitor"></canvas>'-->
<!--        );-->
<!---->
<!--        let from = $("#from").val();-->
<!--        let to = $("#to").val();-->
<!---->
<!--        let url = `/getClicksByGender?from=${from}&to=${to}`;-->
<!---->
<!--        $.getJSON(url, function (result) {-->
<!--            let labels = result.map(function (e) {-->
<!--                return e.email;-->
<!--            });-->
<!---->
<!--            let values = result.map(function (e) {-->
<!--                return e.price;-->
<!--            });-->
<!---->
<!--            let setData = {-->
<!--                labels: labels,-->
<!--                datasets: [-->
<!--                    {-->
<!--                        label: "Price per user",-->
<!--                        data: values-->
<!--                    }]-->
<!--            }-->
<!---->
<!--            let options = {}-->
<!---->
<!--            let graph = $("#price-per-user").get(0).getContext('2d');-->
<!---->
<!--            createGraph(setData, graph, 'bar', options);-->
<!--        });-->
<!--    }-->
<!---->
<!--    function createGraph(setData, graph, chartType, options) {-->
<!--        new Chart(graph, {-->
<!--            type: chartType,-->
<!--            data: setData,-->
<!--            options: options-->
<!--        });-->
<!--    }-->
<!--</script>-->