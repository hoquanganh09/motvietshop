function initChartOrder(url) {
    const chartDom = document.getElementById("chartOrder");
    const myChart = echarts.init(chartDom);

    ajax(url, "get", {}, function (res) {
        const option = {
            tooltip: {
                trigger: "axis",
                axisPointer: {
                    type: "cross",
                },
                formatter: function (params) {
                    let value = params[0].value; // Lấy giá trị từ tooltip
                    let formattedValue = value + "K"; // Thêm chữ K vào giá trị
                    return (
                        params[0].name +
                        "<br/>" +
                        params[0].marker +
                        "Tổng tiền: " +
                        formattedValue
                    );
                },
            },
            toolbox: {
                show: true,
                feature: {
                    saveAsImage: {},
                },
            },
            xAxis: {
                type: "category",
                data: res.data.x,
            },
            yAxis: {
                type: "value",
                axisLabel: {
                    formatter: "{value}K",
                },
            },
            series: [
                {
                    data: res.data.y,
                    type: "line",
                    name: "Tổng tiền",
                },
            ],
        };
        myChart.setOption(option);
    });

    $(window).on("resize", function () {
        if (myChart != null && myChart != undefined) {
            myChart.resize();
        }
    });
}

function initChartProductSale(url) {
    const chartDom = document.getElementById("productSale");
    const myChart = echarts.init(chartDom);

    ajax(url, "get", {}, function (res) {
        const option = {
            tooltip: {
              trigger: 'item'
            },
            legend: {
              orient: 'vertical',
              left: 'left'
            },
            series: [
              {
                name: 'Thể loại',
                type: 'pie',
                radius: '50%',
                data: res.data,
                emphasis: {
                  itemStyle: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                  }
                }
              }
            ],
            toolbox: {
                show: true,
                feature: {
                    saveAsImage: {},
                },
            },
          };
    
        myChart.setOption(option);
    });

    $(window).on("resize", function () {
        if (myChart != null && myChart != undefined) {
            myChart.resize();
        }
    });
}
