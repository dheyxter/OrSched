$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '/Charts',
        success: function (data) {
            barChartData = JSON.parse(data);
            console.log(barChartData);
            let myChart = document.getElementById('myChart').getContext('2d');
            let barChart = new Chart(myChart, {
                type: 'bar',
                // data: barChartData[],
                option: {}
            });
        }
    });


});
