'use strict';

$(function () {

  function productListener(){
    $('.product-type-select').on('change',function(){
      $value = $(this).val();
    });
  }
  productListener();

  let cardColor, headingColor, labelColor, shadeColor, grayColor;

  if (isDarkStyle) {
    cardColor = config.colors_dark.cardColor;
    labelColor = config.colors_dark.textMuted;
    headingColor = config.colors_dark.headingColor;
    shadeColor = 'dark';
    grayColor = '#5E6692'; // gray color is for stacked bar chart
  } else {
    cardColor = config.colors.cardColor;
    labelColor = config.colors.textMuted;
    headingColor = config.colors.headingColor;
    shadeColor = '';
    grayColor = '#817D8D';
  }

  const flatpickrRange = document.querySelector('#flatpickr-range');
  if (typeof flatpickrRange != undefined) {
    flatpickrRange.flatpickr({
      mode: 'range',
      locale: 'fa',
      dateFormat: 'Y/m/d',
    });
  }
  const payingPriceStatisticEl = document.querySelector('#payingPriceStatistic'),
    payingPriceStatisticConfig = {
      chart: {
        height: 130,
        type: 'area',
        parentHeightOffset: 0,
        toolbar: {
          show: false
        },
        sparkline: {
          enabled: true
        }
      },
      markers: {
        colors: 'transparent',
        strokeColors: 'transparent'
      },
      grid: {
        show: false
      },
      colors: [config.colors.success],
      fill: {
        type: 'gradient',
        gradient: {
          shade: shadeColor,
          shadeIntensity: 0.8,
          opacityFrom: 0.6,
          opacityTo: 0.1
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: 2,
        curve: 'smooth'
      },
      series: [
        {
          name: 'ءتء',
          data: Object.keys($monthlyPriceSums).map(month => ({
            x: month,
            y: $monthlyPriceSums[month].sumPricePaying
          })),
        }
      ],
      xaxis: {
        show: true,
        lines: {
          show: false
        },
        labels: {
          show: true,  // Show x-axis labels
          formatter: function (value) {  // Optional: Customize the format of the labels
            return value;  // Example: return new Date(value).toLocaleDateString(); for formatted date
          }
        },
        stroke: {
          width: 0
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        stroke: {
          width: 0
        },
        show: true,  // Show y-axis to display the values
        labels: {
          show: true,
          formatter: function (value) {  // Optional: Customize the format of the labels
            return value.toLocaleString();  // Example: Add commas to the numbers
          }
        }
      },
      tooltip: {
        enabled: true,
        x: {
          format: 'yyyy-MM'  // Customize the date format in the tooltip
        },
        y: {
          formatter: function (value) {
            return value.toLocaleString();  // Format the tooltip value
          }
        }
      }
    };

  const priceOffStatisticEl = document.querySelector('#priceOffStatistic'),
    priceOffStatisticConfig = {
      chart: {
        height: 130,
        type: 'area',
        parentHeightOffset: 0,
        toolbar: {
          show: false
        },
        sparkline: {
          enabled: true
        }
      },
      markers: {
        colors: 'transparent',
        strokeColors: 'transparent'
      },
      grid: {
        show: false
      },
      colors: [config.colors.danger],
      fill: {
        type: 'gradient',
        gradient: {
          shade: shadeColor,
          shadeIntensity: 0.8,
          opacityFrom: 0.6,
          opacityTo: 0.1
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: 2,
        curve: 'smooth'
      },
      series: [
        {
          name: 'ءتء',
          data: Object.keys($monthlyPriceSums).map(month => ({
            x: month,
            y: $monthlyPriceSums[month].sumPriceOff
          })),
        }
      ],
      xaxis: {
        show: true,
        lines: {
          show: false
        },
        labels: {
          show: true,  // Show x-axis labels
          formatter: function (value) {  // Optional: Customize the format of the labels
            return value;  // Example: return new Date(value).toLocaleDateString(); for formatted date
          }
        },
        stroke: {
          width: 0
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        stroke: {
          width: 0
        },
        show: true,  // Show y-axis to display the values
        labels: {
          show: true,
          formatter: function (value) {  // Optional: Customize the format of the labels
            return value.toLocaleString();  // Example: Add commas to the numbers
          }
        }
      },
      tooltip: {
        enabled: true,
        x: {
          format: 'yyyy-MM'  // Customize the date format in the tooltip
        },
        y: {
          formatter: function (value) {
            return value.toLocaleString();  // Format the tooltip value
          }
        }
      }
    };

  if (typeof priceOffStatisticEl !== undefined && priceOffStatisticEl !== null) {
    const priceOffStatistic = new ApexCharts(priceOffStatisticEl, priceOffStatisticConfig);
    priceOffStatistic.render();
  }
  if (typeof payingPriceStatisticEl !== undefined && payingPriceStatisticEl !== null) {
    const payingPriceStatistic = new ApexCharts(payingPriceStatisticEl, payingPriceStatisticConfig);
    payingPriceStatistic.render();
  }
  const totalPriceStatisticEl = document.querySelector('#totalPriceStatistic'),
    totalPriceStatisticConfig = {
      chart: {
        height: 130,
        type: 'area',
        parentHeightOffset: 0,
        toolbar: {
          show: false
        },
        sparkline: {
          enabled: true
        }
      },
      markers: {
        colors: 'transparent',
        strokeColors: 'transparent'
      },
      grid: {
        show: false
      },
      colors: [config.colors.info],
      fill: {
        type: 'gradient',
        gradient: {
          shade: shadeColor,
          shadeIntensity: 0.8,
          opacityFrom: 0.6,
          opacityTo: 0.1
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: 2,
        curve: 'smooth'
      },
      series: [
        {
          name: 'ءتء',
          data: Object.keys($monthlyPriceSums).map(month => ({
            x: month,
            y: $monthlyPriceSums[month].sumFullPrice
          })),
        }
      ],
      xaxis: {
        show: true,
        lines: {
          show: false
        },
        labels: {
          show: true,  // Show x-axis labels
          formatter: function (value) {  // Optional: Customize the format of the labels
            return value;  // Example: return new Date(value).toLocaleDateString(); for formatted date
          }
        },
        stroke: {
          width: 0
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        stroke: {
          width: 0
        },
        show: true,  // Show y-axis to display the values
        labels: {
          show: true,
          formatter: function (value) {  // Optional: Customize the format of the labels
            return value.toLocaleString();  // Example: Add commas to the numbers
          }
        }
      },
      tooltip: {
        enabled: true,
        x: {
          format: 'yyyy-MM'  // Customize the date format in the tooltip
        },
        y: {
          formatter: function (value) {
            return value.toLocaleString();  // Format the tooltip value
          }
        }
      }
    };

  if (typeof totalPriceStatisticEl !== undefined && totalPriceStatisticEl !== null) {
    const totalPriceStatistic = new ApexCharts(totalPriceStatisticEl, totalPriceStatisticConfig);
    totalPriceStatistic.render();
  }

  const weeklyEarningReportsEl = document.querySelector('#weeklyEarningReports'),
    weeklyEarningReportsConfig = {
      chart: {
        height: 202,
        parentHeightOffset: 0,
        type: 'bar',
        toolbar: {
          show: false
        }
      },
      plotOptions: {
        bar: {
          barHeight: '60%',
          columnWidth: '38%',
          startingShape: 'rounded',
          endingShape: 'rounded',
          borderRadius: 4,
          distributed: true
        }
      },
      grid: {
        show: false,
        padding: {
          top: -30,
          bottom: 0,
          left: -10,
          right: -10
        }
      },
      colors: [
        config.colors_label.primary,
        config.colors_label.primary,
        config.colors_label.primary,
        config.colors_label.primary,
        config.colors.primary,
        config.colors_label.primary,
        config.colors_label.primary
      ],
      dataLabels: {
        enabled: false
      },
      series: [
        {
          name: 'فروش',
          data: [40, 65, 50, 45, 90, 55, 70]
        }
      ],
      legend: {
        show: false
      },
      xaxis: {
        categories: ['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه'],
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: labelColor,
            fontSize: '13px',
            fontFamily: 'font-primary'
          }
        }
      },
      yaxis: {
        labels: {
          show: false
        }
      },
      tooltip: {
        enabled: true
      },
      responsive: [
        {
          breakpoint: 1025,
          options: {
            chart: {
              height: 199
            }
          }
        }
      ]
    };
  if (typeof weeklyEarningReportsEl !== undefined && weeklyEarningReportsEl !== null) {
    const weeklyEarningReports = new ApexCharts(weeklyEarningReportsEl, weeklyEarningReportsConfig);
    weeklyEarningReports.render();
  }

  const supportTrackerEl = document.querySelector('#supportTracker'),
    supportTrackerOptions = {
      series: [85],
      labels: ['تکمیل شده'],
      chart: {
        height: 360,
        type: 'radialBar'
      },
      plotOptions: {
        radialBar: {
          offsetY: 10,
          startAngle: -140,
          endAngle: 130,
          hollow: {
            size: '65%'
          },
          track: {
            background: cardColor,
            strokeWidth: '100%'
          },
          dataLabels: {
            name: {
              offsetY: -20,
              color: labelColor,
              fontSize: '13px',
              fontWeight: '400',
              fontFamily: 'font-primary'
            },
            value: {
              offsetY: 10,
              color: headingColor,
              fontSize: '38px',
              fontWeight: '500',
              fontFamily: 'font-primary'
            }
          }
        }
      },
      colors: [config.colors.primary],
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'dark',
          shadeIntensity: 0.5,
          gradientToColors: [config.colors.primary],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 0.6,
          stops: [30, 70, 100]
        }
      },
      stroke: {
        dashArray: 10
      },
      grid: {
        padding: {
          top: -20,
          bottom: 5
        }
      },
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      },
      responsive: [
        {
          breakpoint: 1025,
          options: {
            chart: {
              height: 330
            }
          }
        },
        {
          breakpoint: 769,
          options: {
            chart: {
              height: 280
            }
          }
        }
      ]
    };
  if (typeof supportTrackerEl !== undefined && supportTrackerEl !== null) {
    const supportTracker = new ApexCharts(supportTrackerEl, supportTrackerOptions);
    supportTracker.render();
  }


  const totalEarningChartEl = document.querySelector('#totalEarningChart'),
    totalEarningChartOptions = {
      series: [
        {
          name: 'درآمد',
          data: [15, 10, 20, 8, 12, 18, 12, 5]
        },
        {
          name: 'هزینه‌ها',
          data: [-7, -10, -7, -12, -6, -9, -5, -8]
        }
      ],
      chart: {
        height: 230,
        parentHeightOffset: 0,
        stacked: true,
        type: 'bar',
        toolbar: { show: false }
      },
      tooltip: {
        enabled: false
      },
      legend: {
        show: false
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '18%',
          borderRadius: 5,
          startingShape: 'rounded',
          endingShape: 'rounded'
        }
      },
      colors: [config.colors.primary, grayColor],
      dataLabels: {
        enabled: false
      },
      grid: {
        show: false,
        padding: {
          top: -40,
          bottom: -20,
          left: -10,
          right: -2
        }
      },
      xaxis: {
        labels: {
          show: false
        },
        axisTicks: {
          show: false
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        labels: {
          show: false
        }
      },
      responsive: [
        {
          breakpoint: 1468,
          options: {
            plotOptions: {
              bar: {
                columnWidth: '22%'
              }
            }
          }
        },
        {
          breakpoint: 1197,
          options: {
            chart: {
              height: 228
            },
            plotOptions: {
              bar: {
                borderRadius: 8,
                columnWidth: '26%'
              }
            }
          }
        },
        {
          breakpoint: 783,
          options: {
            chart: {
              height: 232
            },
            plotOptions: {
              bar: {
                borderRadius: 6,
                columnWidth: '28%'
              }
            }
          }
        },
        {
          breakpoint: 589,
          options: {
            plotOptions: {
              bar: {
                columnWidth: '16%'
              }
            }
          }
        },
        {
          breakpoint: 520,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 6,
                columnWidth: '18%'
              }
            }
          }
        },
        {
          breakpoint: 426,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 5,
                columnWidth: '20%'
              }
            }
          }
        },
        {
          breakpoint: 381,
          options: {
            plotOptions: {
              bar: {
                columnWidth: '24%'
              }
            }
          }
        }
      ],
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      }
    };
  if (typeof totalEarningChartEl !== undefined && totalEarningChartEl !== null) {
    const totalEarningChart = new ApexCharts(totalEarningChartEl, totalEarningChartOptions);
    totalEarningChart.render();
  }

})
