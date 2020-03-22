// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

var e = document.createElement("script");
e.src = 'https://code.jquery.com/jquery-3.4.1.js';
e.type="text/javascript";
document.getElementsByTagName("head")[0].appendChild(e);

var  WaitingForConfirm
var WaitingForDelivery
var WaitingForDispatch
var Shipping

$(document).ready(function() {
$.ajax({
  url: 'http://desmond.business:8080/myp/getRequestItems',
  type: 'get',
  contentType: 'application/json',
  success: function(response) {

    var len = 0;
    if (response != null) {
      len = response.length;
    }

    if (len > 0) {
      // Read data and create <option >
      for (var i = 0; i < len; i++) {

        console.log(response[i].status);
      }
    }

  }
});
});
// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["WaitingForConfirm", "WaitingForDispatch", "WaitingForDelivery"],
    datasets: [{
      data: [55, 30, 15],
      backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});
