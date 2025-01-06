$(function () {
  // =====================================
  // Salary
  // =====================================

  fetch("/dashboard/getAgentYearChart")
  .then((response) => response.json())
  .then((data) => {

    const months = data.map((item) => item.label);
    const reservations_count = data.map((item) => item.reservations_count);

    const currentMonth = new Date().getMonth();
    const colors = data.map((_, index) => (index === currentMonth ? "#000000" : "var(--bs-primary)"));


    var salary = {
      series: [
      {
        name: "Employee Salary",
        data: reservations_count,
      },
      ],
      chart: {
        toolbar: {
          show: false,
        },
        height: 260,
        type: "bar",
        fontFamily: "Plus Jakarta Sans', sans-serif",
        foreColor: "#adb0bb",
      },
      colors: ['var(--bs-primary)'],
      plotOptions: {
        bar: {
          borderRadius: 4,
          columnWidth: "45%",
          distributed: true,
          endingShape: "rounded",
        },
      },
      dataLabels: {
        enabled: false,
      },
      legend: {
        show: false,
      },
      grid: {
        yaxis: {
          lines: {
            show: false,
          },
        },
        xaxis: {
          lines: {
            show: false,
          },
        },
      },
      xaxis: {
        categories: months,
        axisBorder: {
          show: false,
        },
        axisTicks: {
          show: false,
        },
      },
      yaxis: {
        labels: {
          show: false,
        },
      },
      tooltip: {
        theme: "dark",
      },
    };

    var chart = new ApexCharts(document.querySelector("#salary"), salary);
    chart.render();
  })
  .catch((error) => {
    console.error("Error fetching salary data:", error);
  });

  // =====================================
  // Stats
  // =====================================
  var stats = {
    chart: {
      id: "sparkline3",
      type: "area",
      height: 180,
      sparkline: {
        enabled: true,
      },
      group: "sparklines",
      fontFamily: "Plus Jakarta Sans', sans-serif",
      foreColor: "#adb0bb",
    },
    series: [
    {
      name: "Weekly Stats",
      color: "var(--bs-primary)",
      data: [], 
    },
    ],
    xaxis: {
      categories: [],
      labels: {
        rotate: -45,  
      },
    },
    stroke: {
      curve: "smooth",
      width: 2,
    },
    fill: {
      type: "gradient",
      gradient: {
        shadeIntensity: 0,
        inverseColors: false,
        opacityFrom: 0.2,
        opacityTo: 0,
        stops: [20, 180],
      },
    },
    markers: {
      size: 0,
    },
    tooltip: {
      theme: "dark",
      x: {
        formatter: function (value, opts) { 
          return opts.w.globals.labels[opts.dataPointIndex];
        },
      },
    },
  };

  new ApexCharts(document.querySelector("#stats"), stats).render();

  async function updateChart() {
    try {
      const response = await fetch('/dashboard/getAgentWeekChart'); 
      const chartData = await response.json();

      const dates = chartData.map(item => item.date); 
      const counts = chartData.map(item => item.reservations_count);

      stats.series[0].data = counts; 
      stats.xaxis = {
        categories: dates,
        labels: {
          rotate: -45, 
          format: 'yyyy-MM-dd',
        }, 
      };

      stats.tooltip = {
        theme: "dark",
        x: {
          formatter: function (value, opts) { 
            return dates[opts.dataPointIndex];
          },
        },
      };
      const chart = new ApexCharts(document.querySelector("#stats"), stats);
      chart.render();
    } catch (error) {
      console.error("Error fetching chart data:", error);
    }
  }

  updateChart();


});
