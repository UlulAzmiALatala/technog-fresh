import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * (BAGIAN PENTING DIMULAI DARI SINI)
 * Kita akan mengkonfigurasi Echo di sini agar bisa terhubung ke Pusher
 * dan mendengarkan event broadcast dari server Laravel kita.
 */

import Echo from "laravel-echo";

import Pusher from "pusher-js";
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,

    authorizer: (channel, options) => {
        return {
            authorize: (socketId, callback) => {
                axios
                    .post("/broadcasting/auth", {
                        socket_id: socketId,
                        channel_name: channel.name,
                    })
                    .then((response) => {
                        callback(false, response.data);
                    })
                    .catch((error) => {
                        callback(true, error);
                    });
            },
        };
    },
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import "./echo";
