<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1/dist/echo.iife.js"></script>

<script>
    window.Pusher = Pusher;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: "{{ config('broadcasting.connections.pusher.key') }}",
        wsHost: "{{ config('broadcasting.connections.pusher.options.host') }}",
        wsPort: "{{ config('broadcasting.connections.pusher.options.port') }}",
        forceTLS: false,
        disableStats: true,
        enabledTransports: ['ws']
    });
</script>
