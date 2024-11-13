// resources/js/chart.js
import { Chart } from "chart.js/auto";
import axios from "axios";
import moment from "moment";
import ChartDataLabels from "chartjs-plugin-datalabels";

Chart.register(ChartDataLabels);

let pointChart; // Variable para almacenar la instancia del gráfico

document.addEventListener("DOMContentLoaded", function () {
    getPointsFreight();
});

$("#searchPoint").on("click", () => {
    let date_range = $("#points_date_range").val();
    let date_split = date_range.split(" - ");

    let startDate = moment(date_split[0], "DD/MM/YYYY").format("YYYY-MM-DD");
    let endDate = moment(date_split[1], "DD/MM/YYYY").format("YYYY-MM-DD");

    getPointsFreight(startDate, endDate);
});

// Petición hacia el backend para traer los puntos
function getPointsFreight(startDate = null, endDate = null) {

    //Obtenemos el canva donde posicionaremos nuestra grafica
    const ctx = document
    .querySelector("canvas")
    .getContext("2d");

    const service = document
    .querySelector("canvas").id;

    const personals = [];
    const points = [];

    axios
        .get(`/points/${service}`, {
            params: {
                type: "chart",
                startDate,
                endDate,
            },
        })
        .then(function (response) {

            //Actualizamos la tabla: 

            actualizarDataTable(response.data);

            response.data.map(({ personal, puntos }) => {
                personals.push(personal.names);
                points.push(puntos);
            });

            // Condicionamos colores de acuerdo al valor
            /* const colors = response.data.map(({ puntos }) =>
                puntos > 15 ? "#0C3C70" : "#7F7F7F"
            ); */



            // Si el gráfico no existe, crearlo
            if (!pointChart) {
                pointChart = new Chart(ctx, {
                    type: "bar",
                    barPercentage: 1,
                    data: {
                        labels: personals,
                        datasets: [
                            {
                                label: "Puntos x Vendedor",
                                data: points,
                                backgroundColor: '#2e37a4' ,
                                borderWidth: 1,
                            },
                        ],
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    callback: function (value) {
                                        return Number.isInteger(value)
                                            ? value
                                            : null;
                                    },
                                },
                                max: Math.max(...points) + 1,
                            },
                        },
                        plugins: {
                            datalabels: {
                                anchor: "end", // Posición de las etiquetas (sobre las barras)
                                align: "top", // Alineación de las etiquetas (parte superior)
                                formatter: function (value, context) {
                                    return value; // Muestra el valor directamente
                                },
                                font: {
                                    weight: "bold",
                                },
                                color: "#fff", // Color del texto
                                backgroundColor: "#000",
                                padding: { left: 8, right: 8 },
                                borderRadius: 4,
                            },
                        },
                    },
                });
            } else {
                // Actualizar los datos del gráfico existente
                pointChart.data.labels = personals; // Actualiza las etiquetas
                pointChart.data.datasets[0].data = points; // Actualiza los datos
                pointChart.data.datasets[0].backgroundColor = '#2e37a4'; // Actualiza los colores
                pointChart.update(); // Redibuja el gráfico
            }
        });
}



function actualizarDataTable(data) {
    // Limpia el contenido actual del DataTable
    var table = $('#table-points').DataTable();
    table.clear();

    // Añadir las nuevas filas
    data.forEach(function(personalPoint, index) {

        let img  = null;

        if(personalPoint.personal.img_url === null){
            img = 'user_default.png';
        }else{
            img = personalPoint.personal.img_url;
        }

        table.row.add([
            index + 1,
            `<img src="/storage/personals/${img}" width="50px" />`,
            `${personalPoint.personal.names} ${personalPoint.personal.last_name}`,
            `<span class="${personalPoint.puntos < 15 ? 'text-secondary' : 'text-success'}">${personalPoint.puntos}</span>`
        ]);
    });

    // Renderiza nuevamente la tabla
    table.draw();
}
