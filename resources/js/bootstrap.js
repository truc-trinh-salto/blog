import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Thiết lập axios
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Thiết lập Echo
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb', // Đảm bảo bạn sử dụng 'pusher' nếu bạn đang sử dụng Pusher
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    wssPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

// Lắng nghe sự kiện
window.Echo.private('user.4')
    .listen('MessageNotification', (e) => {
        alert('abcdsadas');
    });
