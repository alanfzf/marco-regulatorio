import Highcharts from "highcharts"

document.addEventListener("DOMContentLoaded", function () {
  Highcharts.chart("container", {
    chart: {
      type: "pie",
    },
    title: {
      text: "Status",
    },
    credits: { enabled: false },
    tooltip: {
      valueSuffix: "%",
    },
    plotOptions: {
      series: {
        allowPointSelect: true,
        cursor: "pointer",

        colors: ["oklch(var(--in)", "oklch(var(--er))"], // Azul y Rojo
        dataLabels: [
          {
            enabled: true,
            distance: 20,
          },
          {
            enabled: true,
            distance: -40,
            format: "{point.percentage:.1f}%",
            style: {
              fontSize: "1.2em",
              textOutline: "none",
              opacity: 0.7,
            },
            filter: {
              operator: ">",
              property: "percentage",
              value: 10,
            },
          },
        ],
      },
    },
    series: [
      {
        name: "Percentage",
        colorByPoint: true,
        data: [
          { name: "Compliant", y: 75 },
          { name: "Non compliant", y: 25 },
        ],
      },
    ],
  })
})
