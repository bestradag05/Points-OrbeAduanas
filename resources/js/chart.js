// resources/js/chart.js
import { Chart } from 'chart.js/auto';
import axios from 'axios';

document.addEventListener('DOMContentLoaded', function () {

    const personals = [];
    const points = [];

        axios.get('/points/customs', {
            params: {
                type: 'chart'
            }
        })
        .then(function (response) {
            response.data.map(({ personal, puntos }) => {
                personals.push(personal.name);
                points.push(puntos);
            })

            const ctx = document.getElementById('customChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                barPercentage: 1,
                
                data: {
                    labels: personals,
                    datasets: [{
                        label: 'Puntos x Vendedor',
                        data: points,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
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