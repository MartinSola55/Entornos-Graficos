//Flot Pie Chart
$(function () {
    var data = [{
        label: "Botella de agua",
        data: 11,
        color: "#4f5467",
    },
    {
        label: "Bidón de agua",
        data: 7,
        color: "#26c6da",
    },
    {
        label: "Envase",
        data: 3,
        color: "#009efb",
    }];
    var plotObj = $.plot($("#flot-pie-chart"), data, {
        series: {
            pie: {
                innerRadius: 0.5
                , show: true
            }
        }
        , grid: {
            hoverable: true
        }
        , color: null
        , tooltip: true
        , tooltipOpts: {
            content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
            shifts: {
                x: 20
                , y: 0
            }
            , defaultTheme: false
        }
    });
});