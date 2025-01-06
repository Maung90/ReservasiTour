$(function () {
  // Donut Pie Chart -------> PIE CHART

  fetch('/dashboard/getTopProgram')
  .then(response => response.json())
  .then(data => {
    const programNames = data.map(item => item.program_name);
    const reservationCounts = data.map(item => item.reservations_count);

    var options_donut = {
      series: reservationCounts,
      chart: {
        fontFamily: '"Nunito Sans", sans-serif',
        type: "donut",
        width: 385,
      },
      labels: programNames, 
      colors: [
        "var(--bs-primary)", 
        "var(--bs-secondary)", 
        "#ffae1f", 
        "#fa896b", 
        "#39b69a"
        ],
      responsive: [
      {
        breakpoint: 480,
        options: {
          chart: {
            width: 200,
          },
          legend: {
            position: "bottom",
          },
        },
      },
      ],
      legend: {
        labels: {
          colors: ["#a1aab2"],
        },
      },
    };

    var chart = new ApexCharts(document.querySelector("#chart-pie-donut"), options_donut);
    chart.render();
  })
  .catch(error => console.error('Error fetching data:', error));

});