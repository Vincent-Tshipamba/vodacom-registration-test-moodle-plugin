/*
Template Name: Tailwick - Admin & Dashboard Template
Author: Themesdesign
Version: 1.1.0
Website: https://themesdesign.in/
Contact: Themesdesign@gmail.com
File: dashboard hr init Js File
*/

// rgb to hex convert
function rgbToHex(rgb) {
    // Extract RGB values using regular expressions
    const rgbValues = rgb.match(/\d+/g);

    if (rgbValues.length === 3) {
        var [r, g, b] = rgbValues.map(Number);
    }
    // Ensure the values are within the valid range (0-255)
    r = Math.max(0, Math.min(255, r));
    g = Math.max(0, Math.min(255, g));
    b = Math.max(0, Math.min(255, b));

    // Convert each component to its hexadecimal representation
    const rHex = r.toString(16).padStart(2, '0');
    const gHex = g.toString(16).padStart(2, '0');
    const bHex = b.toString(16).padStart(2, '0');

    // Combine the hexadecimal values with the "#" prefix
    const hexColor = `#${rHex}${gHex}${bHex}`;

    return hexColor.toUpperCase(); // Convert to uppercase for consistency
}

// common function to get charts colors from class
function getChartColorsArray(chartId) {
    const chartElement = document.getElementById(chartId);
    if (chartElement) {
        const colors = chartElement.dataset.chartColors;
        if (colors) {
            const parsedColors = JSON.parse(colors);
            const mappedColors = parsedColors.map((value) => {
                const newValue = value.replace(/\s/g, "");
                if (!newValue.includes("#")) {
                    const element = document.querySelector(newValue);
                    if (element) {
                        const styles = window.getComputedStyle(element);
                        const backgroundColor = styles.backgroundColor;
                        return backgroundColor || newValue;
                    } else {
                        const divElement = document.createElement('div');
                        divElement.className = newValue;
                        document.body.appendChild(divElement);

                        const styles = window.getComputedStyle(divElement);
                        const backgroundColor = styles.backgroundColor.includes("#") ? styles.backgroundColor : rgbToHex(styles.backgroundColor);
                        return backgroundColor || newValue;
                    }
                } else {
                    return newValue;
                }
            });
            return mappedColors;
        } else {
            console.warn(`chart-colors attribute not found on: ${chartId}`);
        }
    }
}

var totalBoursierChart = "";
var totalApplicationChart = "";
var acceptedCandidatesChart = "";
var rejectedCandidatesChart = "";
var applicationReceivedChart = "";

function loadCharts() {
    //  Total Boursiers
    var totalBoursiersColors = "";
    totalBoursiersColors = getChartColorsArray("totalBoursiersChart");
    if (totalBoursiersColors) {
        var totalBoursiersEl = document.getElementById("totalBoursiersChart");
        var totalBoursiersValue = 0;
        if (totalBoursiersEl && totalBoursiersEl.dataset && totalBoursiersEl.dataset.total) {
            var parsed = parseInt(totalBoursiersEl.dataset.total, 10);
            totalBoursiersValue = isNaN(parsed) ? 0 : parsed;
        }
        var options = {
            series: [totalBoursiersValue],
            chart: {
                height: 110,
                type: 'radialBar',
                sparkline: {
                    enabled: true
                }
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 0,
                        size: '50%',
                    },
                    track: {
                        margin: 2,
                    },
                    dataLabels: {
                        show: false
                    }
                }
            },
            grid: {
                padding: {
                    top: -15,
                    bottom: -15
                }
            },
            stroke: {
                lineCap: 'round'
            },
            labels: ['Total Boursiers'],
            colors: totalBoursiersColors
        };

        if (totalBoursierChart != "")
            totalBoursierChart.destroy();
        totalBoursierChart = new ApexCharts(document.querySelector("#totalBoursiersChart"), options);
        totalBoursierChart.render();
    }

    //  Total Application
    var totalApplicationColors = "";
    totalApplicationColors = getChartColorsArray("totalApplicationChart");
    if (totalApplicationColors) {
        var totalApplicationEl = document.getElementById("totalApplicationChart");
        var totalApplicationValue = 0;
        if (totalApplicationEl && totalApplicationEl.dataset && totalApplicationEl.dataset.total) {
            var parsed = parseInt(totalApplicationEl.dataset.total, 10);
            totalApplicationValue = isNaN(parsed) ? 0 : parsed;
        }
        var options = {
            series: [totalApplicationValue],
            chart: {
                height: 110,
                type: 'radialBar',
                sparkline: {
                    enabled: true
                }
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 0,
                        size: '50%',
                    },
                    track: {
                        margin: 2,
                    },
                    dataLabels: {
                        show: false
                    }
                }
            },
            grid: {
                padding: {
                    top: -15,
                    bottom: -15
                }
            },
            stroke: {
                lineCap: 'round'
            },
            labels: ['Total Employee'],
            colors: totalApplicationColors
        };

        if (totalApplicationChart != "")
            totalApplicationChart.destroy();
        totalApplicationChart = new ApexCharts(document.querySelector("#totalApplicationChart"), options);
        totalApplicationChart.render();
    }

    //  Accepted Candidates
    var acceptedCandidatesColors = "";
    acceptedCandidatesColors = getChartColorsArray("acceptedCandidatesChart");
    if (acceptedCandidatesColors) {
        var totalAcceptedCandidatesEl = document.getElementById("acceptedCandidatesChart");
        var totalAcceptedCandidatesValue = 0;
        if (totalAcceptedCandidatesEl && totalAcceptedCandidatesEl.dataset && totalAcceptedCandidatesEl.dataset.total) {
            var parsed = parseInt(totalAcceptedCandidatesEl.dataset.total, 10);
            totalAcceptedCandidatesValue = isNaN(parsed) ? 0 : parsed;
        }
        var options = {
            series: [totalAcceptedCandidatesValue],
            chart: {
                height: 110,
                type: 'radialBar',
                sparkline: {
                    enabled: true
                }
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 0,
                        size: '50%',
                    },
                    track: {
                        margin: 2,
                    },
                    dataLabels: {
                        show: false
                    }
                }
            },
            grid: {
                padding: {
                    top: -15,
                    bottom: -15
                }
            },
            stroke: {
                lineCap: 'round'
            },
            labels: ['Total Employee'],
            colors: acceptedCandidatesColors
        };

        if (acceptedCandidatesChart != "")
            acceptedCandidatesChart.destroy();
        acceptedCandidatesChart = new ApexCharts(document.querySelector("#acceptedCandidatesChart"), options);
        acceptedCandidatesChart.render();
    }

    //  Rejected Candidates
    var rejectedCandidatesColors = "";
    rejectedCandidatesColors = getChartColorsArray("rejectedCandidatesChart");
    if (rejectedCandidatesColors) {
        var totalRejectedCandidatesEl = document.getElementById("rejectedCandidatesChart");
        var totalRejectedCandidatesValue = 0;
        if (totalRejectedCandidatesEl && totalRejectedCandidatesEl.dataset && totalRejectedCandidatesEl.dataset.total) {
            var parsed = parseInt(totalRejectedCandidatesEl.dataset.total, 10);
            totalRejectedCandidatesValue = isNaN(parsed) ? 0 : parsed;
        }
        var options = {
            series: [totalRejectedCandidatesValue],
            chart: {
                height: 110,
                type: 'radialBar',
                sparkline: {
                    enabled: true
                }
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 0,
                        size: '50%',
                    },
                    track: {
                        margin: 2,
                    },
                    dataLabels: {
                        show: false
                    }
                }
            },
            grid: {
                padding: {
                    top: -15,
                    bottom: -15
                }
            },
            stroke: {
                lineCap: 'round'
            },
            labels: ['Total Employee'],
            colors: rejectedCandidatesColors
        };

        if (rejectedCandidatesChart != "")
            rejectedCandidatesChart.destroy();
        rejectedCandidatesChart = new ApexCharts(document.querySelector("#rejectedCandidatesChart"), options);
        rejectedCandidatesChart.render();
    }

    //Application Received
    var applicationReceivedColors = "";
    applicationReceivedColors = getChartColorsArray("applicantsByYearChart");
    if (applicationReceivedColors) {
        var applicantsByYearEl = document.getElementById("applicantsByYearChart");

        const years = JSON.parse(applicantsByYearEl.dataset.years || '[]');
        const counts = JSON.parse(applicantsByYearEl.dataset.counts || '[]');
        var options = {
            series: [{
                name: 'Nombre de candidats',
                data: counts
            }],
            chart: {
                height: 315,
                type: 'line',
                stacked: false,
                margin: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                },
                toolbar: {
                    show: false,
                },
            },
            stroke: {
                width: [2, 2],
                curve: 'smooth'
            },
            plotOptions: {
                bar: {
                    columnWidth: '50%'
                }
            },

            fill: {
                opacity: [0.3, 1],
                gradient: {
                    inverseColors: false,
                    shade: 'light',
                    type: "vertical",
                    opacityFrom: 0.85,
                    opacityTo: 0.55,
                    stops: [0, 100, 100, 100]
                }
            },
            labels: years,
            colors: applicationReceivedColors,
            markers: {
                size: 4
            },
            grid: {
                padding: {
                    top: -15,
                    right: 0,
                }
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function (y) {
                        if (typeof y !== "undefined") {
                            return y.toFixed(0) + " candidats";
                        }
                        return y;

                    }
                }
            },
            xaxis: {
                categories: years  // Assure que les années s'affichent sur l'axe X
            }
        };

        if (applicationReceivedChart != "")
            applicationReceivedChart.destroy();
        applicationReceivedChart = new ApexCharts(applicantsByYearEl, options);
        applicationReceivedChart.render();
    }
}

window.addEventListener("resize", function () {
    setTimeout(() => {
        loadCharts();
    }, 0);
});
loadCharts();

// Editions by status
const totalProjectChartEl = document.getElementById("totalProjectChart");
if (totalProjectChartEl) {
    const editionStatusSeries = JSON.parse(totalProjectChartEl.dataset.series || '[]');
    const editionStatusLabels = JSON.parse(totalProjectChartEl.dataset.labels || '[]');
    const editionStatusColors = getChartColorsArray("totalProjectChart");

    var options = {
        series: editionStatusSeries,
        chart: {
            type: 'bar',
            height: 350,
            stacked: true,
            zoom: {
                enabled: true
            },
            toolbar: {
                show: false,
            },
        },
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 2,
                columnWidth: '45%',
            },
        },
        grid: {
            padding: {
                top: -15,
                bottom: 5,
                right: 0,
            }
        },
        xaxis: {
            categories: editionStatusLabels,
            labels: {
                rotate: -35,
            }
        },
        yaxis: {
            title: {
                text: 'Candidats',
            }
        },
        dataLabels: {
            enabled: false
        },
        tooltip: {
            y: {
                formatter: function (value) {
                    return value + " candidats";
                }
            }
        },
        noData: {
            text: 'Aucune donnée disponible'
        },
        colors: editionStatusColors,
        legend: {
            position: 'bottom',
        },
        fill: {
            opacity: 1
        }
    };

    var chart = new ApexCharts(document.querySelector("#totalProjectChart"), options);
    chart.render();
}

const options44 = {
    settings: {
        visibility: {
            theme: 'light',
        },
        selected: {
            day: new Date().getDay(),
            month: new Date().getMonth(),
            year: new Date().getFullYear(),
        },
    },
    popups: {
        '2025-12-28': {
            modifier: '!bg-red-500 !text-white',
            html: 'Meeting with Designer',
        },
        '2025-12-13': {
            modifier: '!bg-red-500 !text-white text-bold',
            html: 'Meeting at 6:00 PM',
        },
        '2025-12-08': {
            modifier: '!bg-purple-500 !text-white text-bold',
            html: `<div>
        <div class="font-semibold underline mb-1">09:57 AM</div>
        <p class="text-slate-500 dark:text-zink-200">Developing Line Managers Conference</p>
      </div>`,
        },
        '2025-12-17': {
            modifier: '!bg-green-500 !text-white',
            html: `<div>
        <div class="font-semibold underline mb-1">12:00 PM</div>
        <p class="text-slate-500 dark:text-zink-200">Airplane in Las Vegas</p>
      </div>`,
        },
        '2025-12-11': {
            modifier: '!bg-purple-500 !text-white text-bold',
            html: `<div>
        <div class="font-semibold underline mb-1">09:57 AM</div>
        <p class="text-slate-500 dark:text-zink-200">Leadership Executive Summit</p>
      </div>`,
        },
        '2025-12-11': {
            modifier: '!bg-orange-500 !text-white text-bold',
            html: `<div>
        <p class="text-slate-500 dark:text-zink-200">Hospitality Project Discuses</p>
      </div>`,
        },
    },
};

const calendar = new VanillaCalendar('#calendar', options44);
calendar.init();
