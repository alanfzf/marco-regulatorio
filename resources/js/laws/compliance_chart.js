import Highcharts from "highcharts"

document.addEventListener("DOMContentLoaded", function () {
  const { in_complaince, non_complaince } = compliance

  Highcharts.chart("container", {
    chart: {
      type: "pie",
      backgroundColor: "oklch(var(--b1))",
    },
    title: {
      text: "Compliance status",
    },
    credits: { enabled: false },
    tooltip: {
      valueSuffix: "%",
    },
    plotOptions: {
      series: {
        allowPointSelect: true,
        cursor: "pointer",
        colors: ["oklch(var(--in))", "oklch(var(--er))"], // Fixed color syntax
        dataLabels: {
          enabled: true,
          distance: -40,
          format: "{point.percentage:.1f}%",
          style: {
            fontSize: "1.2em",
            textOutline: "none",
            opacity: 0.7,
          },
        },
      },
    },
    series: [
      {
        name: "Percentage",
        colorByPoint: true,
        data: [
          { name: "In compliance", y: in_complaince },
          { name: "Not in compliance", y: non_complaince },
        ],
      },
    ],
  })
})
