export function renderSponsorPaymentChart(canvasId) {
  const ctx = document.getElementById(canvasId);
  if (!ctx) return;

  new Chart(ctx, {
    type: "line",
    data: {
      labels: ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو"],
      datasets: [
        {
          label: "المدفوعات الشهرية لشراكة الكفالة ($)",
          data: [650, 650, 650, 950, 950, 950],
          borderColor: "#1B6B43",
          backgroundColor: "rgba(27, 107, 67, 0.05)",
          borderWidth: 3,
          tension: 0.3,
          fill: true,
          pointBackgroundColor: "#F5A623",
          pointBorderColor: "#fff",
          pointRadius: 5,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          labels: { font: { family: "Cairo", size: 12 } },
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: { font: { family: "Cairo" } },
        },
        x: {
          ticks: { font: { family: "Cairo" } },
        },
      },
    },
  });
}
