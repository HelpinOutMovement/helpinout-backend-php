var ctx = document.getElementById("mybarChartReportUpdate").getContext("2d");
ctx.height = 350;
var mybarChartReportUpdate = new Chart(ctx, {
type: 'bar',
data: {
  labels: ['Rounds Progress in %'],
  datasets: [{
    label: '# of Round 1',
    backgroundColor: "#00c0ef",
    data: [55]
  }, {
    label: '# of Round 2',
    backgroundColor: "#00a65a",
    data: [70]
  }, {
    label: '# of Round 3',
    backgroundColor: "#0073b7",
    data: [80]
  }]
},

options: {
  legend: {
    display: true,
    position: 'bottom',
    labels: {
      fontColor: "#000080",
    }
  },
  scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      responsive: true,
      maintainAspectRatio: true,
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }],
      xAxes: [{
          barPercentage: 0.4
      }]
    }
  }
});