import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Thiết lập axios
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Thiết lập Echo
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

// Lắng nghe sự kiện
window.Echo.channel('test')
    .listen('MessageNotification', (e) => {
        alert(123);
    });

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */
