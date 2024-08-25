import Highcharts from "highcharts"

document.addEventListener("DOMContentLoaded", function () {
  const { complaint, non_compliant } = compliance

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
          { name: "Compliant", y: complaint },
          { name: "Non compliant", y: non_compliant },
        ],
      },
    ],
  })
})
