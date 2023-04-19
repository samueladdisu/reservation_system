// Set new default font family and font color to mimic Bootstrap's default styling
(Chart.defaults.global.defaultFontFamily = "Nunito"),
  '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + "").replace(",", "").replace(" ", "");
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
    dec = typeof dec_point === "undefined" ? "." : dec_point,
    s = "",
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return "" + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || "").length < prec) {
    s[1] = s[1] || "";
    s[1] += new Array(prec - s[1].length + 1).join("0");
  }
  return s.join(dec);
}

function getDataBar() {
  var dta;
  const d = new Date();
  const monthNames = [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
  ];
  axios
    .post("./js/demo/GetChart.php", {
      action: "ChartShop",
      CMonth: monthNames[d.getMonth()],
      CYear: d.getFullYear(),
    })
    .then((res) => {
      // var DataShops = JSON.parse(res.data[0]);
      // console.log(DataShops["Office Bar"]);
      // Bar Chart Example
      var ctx = document.getElementById("myBarChart");
      var myBarChart = new Chart(ctx, {
        type: "verticalBar",
        data: {
          labels: [
            "Historical",
            "Office Bar",
            "Galleria",
            "Meet up",
            "Roastery",
            "Camera",
            "Village",
            "Blue",
            "Sip and Create",
            "Black and white",
          ],
          datasets: [
            {
              label: "Number of Orders",
              backgroundColor: "#ea8016",
              hoverBackgroundColor: "#c08d00bf",
              borderColor: "#4e73df",
              data: [
                0,
                10,
               30,
                40,
              50,
               60,
              70,
              80,
               90,
             100,
              ],
            },
          ],
        },
        options: {
          maintainAspectRatio: false,
          // indexAxis: "y",

          layout: {
            padding: {
              left: 10,
              right: 25,
              top: 25,
              bottom: 0,
            },
          },
          scales: {
            yAxes: [
              {
                time: {
                  unit: "Shop",
                },
                gridLines: {
                  display: false,
                  drawBorder: false,
                },
                ticks: {
                  maxTicksLimit: 21,
                  padding: 10,
                },

                maxBarThickness: 90,
              },
            ],
            xAxes: [
              {
                ticks: {
                  maxTicksLimit: 10,
                  padding: 10,
                  // Include a dollar sign in the ticks
                  callback: function (value, index, values) {
                    return "#" + number_format(value);
                  },
                },
                gridLines: {
                  color: "rgb(0, 236, 244)",
                  zeroLineColor: "rgb(234, 236, 244)",
                  drawBorder: false,
                  borderDash: [2],
                  zeroLineBorderDash: [2],
                },
              },
            ],
          },
          legend: {
            display: false,
          },
          tooltips: {
            titleMarginBottom: 10,
            titleFontColor: "#6e707e",
            titleFontSize: 14,
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#000000",
            borderColor: "#000000",
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            callbacks: {
              label: function (tooltipItem, chart) {
                var datasetLabel =
                  chart.datasets[tooltipItem.datasetIndex].label || "";
                return datasetLabel + ": #" + number_format(tooltipItem.xLabel);
              },
            },
          },
        },
      });
    });
}

window.onload = getDataBar();


