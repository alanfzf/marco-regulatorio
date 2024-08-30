import Highcharts from "highcharts"

document.addEventListener("DOMContentLoaded", function () {
  const { in_complaince, non_complaince } = items
  const maturityNames = maturity.map((item) => item.maturity_name)
  const articleItemCounts = maturity.map((item) => item.article_item_count)

  const colors = [
    "#FF6347",
    "#FFA500",
    "#FFD700",
    "#32CD32",
    "#1E90FF",
    "#00FFFF",
  ]

  Highcharts.chart("pie_chart", {
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

  Highcharts.chart("bar_chart", {
    chart: {
      type: "column",
      backgroundColor: "oklch(var(--b1))",
    },
    title: {
      text: "Maturity levels",
    },
    subtitle: {
      text: "Items by maturity levels",
    },
    xAxis: {
      categories: maturityNames,
      title: {
        text: null,
      },
    },
    yAxis: {
      min: 0,
      title: {
        text: "Items (count)",
        align: "high",
      },
      labels: {
        overflow: "justify",
      },
    },
    tooltip: {
      valueSuffix: " items",
    },
    plotOptions: {
      bar: {
        dataLabels: {
          enabled: true,
        },
      },
    },
    legend: {
      enabled: false,
    },
    credits: {
      enabled: false,
    },
    series: [
      {
        name: "Items",
        data: articleItemCounts.map((count, index) => ({
          y: count,
          color: colors[index % colors.length], // Asigna un color a cada barra usando la lista de colores
        })),
      },
    ],
  })
})
