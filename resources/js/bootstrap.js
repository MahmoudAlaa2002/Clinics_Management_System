import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',  // ← Changed from "reverb"
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,  // ← Added cluster
    forceTLS: true,
    encrypted: true,
    enableLogging: true,

    // Custom authorizer for /broadcasting/auth
    authorizer: (channel, options) => {
        return {
            authorize: (socketId, callback) => {
                fetch('/broadcasting/auth', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        socket_id: socketId,
                        channel_name: channel.name,
                    })
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        callback(null, data);
                    })
                    .catch(error => {
                        console.error('Broadcasting auth failed:', error);
                        callback(error);
                    });
            }
        };
    },
});