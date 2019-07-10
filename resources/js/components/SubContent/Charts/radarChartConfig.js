import theme from '../../../theme';

export default {
    chart: {
        polar: true,
        type: 'area',
        backgroundColor: 'transparent',
    },

    title: {
        text: '',
    },

    pane: {
        size: '100%',
    },

    xAxis: {
        categories: ['Happy', 'Dance', 'Speech', 'Acoustic',
            'Instruments', 'Energy'],
        tickmarkPlacement: 'on',
        lineWidth: 0,
        labels: {
            align: 'center',
            x: 0,
            y: 0,
        },
    },

    yAxis: {
        gridLineInterpolation: 'polygon',
        gridLineDashStyle: 'Solid',
        lineWidth: 0,
        gridLineColor: 'rgba(0,0,0,.5)',
        gridLineWidth: .5,
        min: 0,
        max: 1,
        tickAmount: 5,
        labels: {
            enabled: false,
        },
    },

    tooltip: {
        shared: true,
        backgroundColor: 'rgba(0,0,0,.5)',
        style: {
            color: 'white',
        },
        pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.2f}</b><br/>',
        outside: true,
        hideDelay: 100,
    },

    legend: {
        enabled: false,
    },

    series: [
        {
            name: 'Playing track',
            data: [null, null, null, null, null, null],
            color: theme.secondary,
            pointPlacement: 'on',
            marker: {
                enabled: true,
                symbol: 'circle',
                radius: 3,
                states: {
                    hover: {
                        radiusPlus: 1,
                    },
                },
            },
        },
        {
            name: 'Selected tracks (avg)',
            color: theme.primary,
            data: [null, null, null, null, null, null],
            pointPlacement: 'on',
            marker: {
                enabled: true,
                symbol: 'circle',
                radius: 3,
                states: {
                    hover: {
                        radiusPlus: 1,
                    },
                },
            },
        }
    ],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    align: 'center',
                    verticalAlign: 'bottom',
                },
                pane: {
                    size: '70%',
                },
            },
        }],
    },

}
