import './bootstrap';


import Chart from 'chart.js/auto';
import toastr from 'toastr';
import * as htmlToImage from 'html-to-image';

/* import Echo from 'laravel-echo';
import Pusher from 'pusher-js'; */

window.Chart = Chart;


toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: 'toast-top-right',
    timeOut: '5000'
};

window.toastr = toastr;
window.htmlToImage = htmlToImage;
/* window.Pusher = Pusher; */
/* window.tinymce = tinymce;


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
 */
