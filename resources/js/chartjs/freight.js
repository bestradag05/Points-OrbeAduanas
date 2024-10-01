// resources/js/chart.js
import { Chart } from 'chart.js/auto';
import axios from 'axios';
import { color } from 'chart.js/helpers';

document.addEventListener('DOMContentLoaded', function () {

    const personals = [];
    const points = [];

        axios.get('/points/freight', {
            params: {
                type: 'chart'
            }
        })
        .then(function (response) {
            response.data.map(({ personal, puntos }) => {
                personals.push(personal.name);
                points.push(puntos);
            })

            //Condicionamos colores de acuerdo al valor
            const colors = response.data.map(({puntos}) => puntos > 15 ? '#0C3C70':'#FE000F');

            const ctx = document.getElementById('freightChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                barPercentage: 1,
                
                data: {
                    labels: personals,
                    datasets: [{
                        label: 'Puntos x Vendedor',
                        data: points,
                        backgroundColor: colors,
                       
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    
                }
            });




        })



});