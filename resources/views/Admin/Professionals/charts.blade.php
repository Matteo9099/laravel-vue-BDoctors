{{--@dd($leadsByMonth);--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- chartJs CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Charts</title>
</head>
<body>
<div class="container mx-auto py-10">
    <h1 class=" text-4xl text-center text-gray-700 mb-10">Le tue Statistiche</h1>
    <div class="grid md:grid-cols-2 grid-cols-1 gap-4 place-items-center md:place-items-stretch">
        <div class="py-5 px-6 md:border-gray-200 md:border-r-2 h-full grid place-items-center">
            <p class="text-xl text-gray-700 text-center mb-5">Numero recensioni per voto</p>
            <canvas id="myChart" class=""></canvas>
            <p class="text-lg text-gray-700 text-center mb-5">Voto Medio : {{$totalAverage}} </p>
        </div>
        <div class="py-5 px-6 h-full grid place-items-center">
            <p class="text-xl text-gray-700 text-center mb-5">Contatti ricevuti ogni mese</p>
            <canvas id="mySecondChart" class=" "></canvas>
            <p class="text-lg text-gray-700 text-center mb-5">Contatti ricevuti in totale : {{$countLeads}} </p>
        </div>
    </div>
</div>
<script>
    const votes = @json($chartReviews);
    // const labels = Utils.months({count: 7});
    const ctx = document.getElementById('myChart').getContext('2d');
    const cts = document.getElementById('mySecondChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Voto 0', 'Voto 1', 'Voto 2', 'Voto 3', 'Voto 4', 'Voto 5'],
            datasets: [{
                label: 'Voto medio Recensioni',
                data: [votes[0], votes[1], votes[2], votes[3], votes[4], votes[5]],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 06)',
                    'rgb(255, 119, 13)',
                    'rgb(255, 20, 132)',
                ],
                hoverOffset: 4
            }]
        },
        options: {

        }
    });
    const leads = @json($leadsByMonth);
    console.log(leads);
    const mySecondChart = new Chart(cts, {
        type: 'bar',
        data: {
            /*labels: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],*/
            datasets: [{
                label: 'Contatti Ricevuti',
                barPercentage: 0.5,
                barThickness: 20,
                maxBarThickness: 8,
                minBarLength: 2,
                data: leads,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
        }
    });
</script>
</body>
</html>
