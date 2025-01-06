// Fetch daily income data from backend
fetch('/dashboard/getDailyIncome/30') // Ganti 30 dengan jumlah hari yang diinginkan
  .then(response => response.json())
  .then(data => {
    // Extract dates and income values
    const dates = data.map(item => item.date);
    const incomes = data.map(item => item.total_income);

    // Update chart options
    var options_gradient = {
      series: [{
        name: "Daily Income",
        data: incomes, // Data income
      }],
      chart: {
        fontFamily: '"Nunito Sans", sans-serif',
        height: 350,
        type: "line",
        toolbar: {
          show: false,
        },
      },
      stroke: {
        width: 7,
        curve: "smooth",
      },
      xaxis: {
        type: "datetime",
        categories: dates, // Tanggal-tanggal income
        labels: {
          style: {
            colors: ["#a1aab2"],
          },
        },
      },
      grid: {
        borderColor: "transparent",
      },
      colors: ["#39b69a"],
      fill: {
        type: "gradient",
        gradient: {
          shade: "dark",
          gradientToColors: ["var(--bs-primary)"],
          shadeIntensity: 1,
          type: "horizontal",
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100, 100, 100],
        },
      },
      markers: {
        size: 4,
        colors: ["var(--bs-primary)"],
        strokeColors: "#fff",
        strokeWidth: 2,
        hover: {
          size: 7,
        },
      },
      yaxis: {
        labels: {
          style: {
            colors: ["#a1aab2"],
          },
        },
      },
      tooltip: {
        theme: "dark",
      },
    };

    // Render chart
    var chart_line_gradient = new ApexCharts(
      document.querySelector("#chart-line-gradient"),
      options_gradient
    );
    chart_line_gradient.render();
  })
  .catch(error => console.error('Error fetching data:', error));
