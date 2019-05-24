$(function() {
  $.ajax({
    url: "http://localhost/TemperatureControl/webapp/chart_data.php",
    type: "GET",
    success: function(data) {
      chartData = data;
      var chartProperties = {
        caption: "Temperatures recordings from sensors",
        xAxisName: "Date & Time",
        yAxisName: "Temperatures Celsius degrees",
        rotatevalues: "1",
        theme: "zune"
      };
      apiChart = new FusionCharts({
        type: "line",
        renderAt: "chart-container",
        width: "95%",
        height: "650",
        dataFormat: "json",
        dataSource: {
          chart: chartProperties,
          data: chartData
        }
      });
      apiChart.render();
    }
  });
});