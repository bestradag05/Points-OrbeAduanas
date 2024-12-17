import './bootstrap';


import Chart from 'chart.js/auto';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';


window.Chart = Chart;
window.Pusher = Pusher;


window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: false,
    wsHost: window.location.hostname,
    wsPort: 6001,
    disableStats: true,
    forceTLS: false,
});

