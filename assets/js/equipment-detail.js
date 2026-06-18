document.addEventListener('DOMContentLoaded', function () {

    /*
    ====================================
    GRAFICO DE USO
    ====================================
    */

    const chartCanvas = document.getElementById('equipmentUsageChart');

    if (chartCanvas && typeof Chart !== 'undefined') {

        new Chart(chartCanvas, {

            type: 'line',

            data: {

                labels: equipmentData.months,

                datasets: [

                    {
                        label: 'Horas Usadas',
                        data: equipmentData.chartHours,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37,99,235,0.08)',
                        borderWidth: 3,
                        tension: 0.35,
                        fill: true,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },

                    {
                        label: 'Horas Contratadas',
                        data: [240, 240, 240, 240, 240, 240, 240, 240, 240, 240, 240, 240],
                        borderColor: '#94a3b8',
                        borderDash: [6, 6],
                        borderWidth: 2,
                        pointRadius: 0,
                        fill: false
                    }

                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                interaction: {
                    mode: 'index',
                    intersect: false
                },

                plugins: {

                    legend: {
                        position: 'top',
                        align: 'end'
                    }

                },

                scales: {

                    y: {

                        beginAtZero: true,

                        grid: {
                            color: '#eef2f7'
                        }

                    },

                    x: {

                        grid: {
                            display: false
                        }

                    }

                }

            }

        });

    }

    /*
    ====================================
    INDISPONIBILIDADES
    ====================================
    */

    const monthlyRate = equipmentData.monthlyRate;

    function daysInMonth(year, month) {

        return new Date(year, month + 1, 0).getDate();

    }

    function calculateDowntime() {

        const startInput = document.getElementById('start_date');
        const endInput = document.getElementById('end_date');

        if (!startInput || !endInput) {
            return;
        }

        const start = startInput.value;
        const end = endInput.value;

        if (!start || !end) {
            return;
        }

        const [y1, m1, d1] = start.split('-').map(Number);
        const [y2, m2, d2] = end.split('-').map(Number);

        const startDate = new Date(y1, m1 - 1, d1);
        const endDate = new Date(y2, m2 - 1, d2);

        if (endDate < startDate) {

            document.getElementById('downtimeDays').innerHTML = 0;
            document.getElementById('estimatedDiscount').innerHTML = '$ 0';

            return;
        }

        const diffDays =
            Math.floor(
                (endDate - startDate) /
                (1000 * 60 * 60 * 24)
            ) + 1;

        const daysMonth =
            daysInMonth(
                startDate.getFullYear(),
                startDate.getMonth()
            );

        const dailyRate =
            monthlyRate / daysMonth;

        const amount =
            diffDays * dailyRate;

        document.getElementById('downtimeDays').innerHTML =
            diffDays;

        document.getElementById('estimatedDiscount').innerHTML =
            '$ ' +
            amount.toLocaleString(
                'es-AR',
                {
                    maximumFractionDigits: 0
                }
            );
    }

    document.addEventListener('change', function (e) {

        if (
            e.target.id === 'start_date' ||
            e.target.id === 'end_date'
        ) {

            calculateDowntime();

        }

    });

    const downtimeForm =
        document.querySelector('#downtimeModal form');

    if (downtimeForm) {

        downtimeForm.addEventListener(
            'submit',
            function (e) {

                const start =
                    document.getElementById('start_date').value;

                const end =
                    document.getElementById('end_date').value;

                if (!start || !end) {
                    return;
                }

                const [sy, sm, sd] =
                    start.split('-').map(Number);

                const [ey, em, ed] =
                    end.split('-').map(Number);

                const startDate =
                    new Date(sy, sm - 1, sd);

                const endDate =
                    new Date(ey, em - 1, ed);

                if (endDate < startDate) {

                    e.preventDefault();

                    alert(
                        'La fecha fin no puede ser menor a la fecha inicio'
                    );

                }

            }
        );

    }

});