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
        enabledTransports: ['ws'],
        withCredentials: true,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
            }
        }
    });



    // let offlineTimer = null;

    Echo.join('online-users')


    // الموجودون الآن
    // .here((users) => {
    //     users.forEach(u => {
    //         if (u.id === targetId) {
    //             if (offlineTimer) {
    //                 clearTimeout(offlineTimer);
    //                 offlineTimer = null;
    //             }
    //             setOnline();
    //         }

    //     });
    // })

    // // دخل المستخدم
    // .joining((user) => {
    //     if (user.id === targetId) {
    //         if (offlineTimer) {
    //             clearTimeout(offlineTimer);
    //             offlineTimer = null;
    //         }
    //         setOnline();
    //     }
    // })

    // // خرج (انتقال بين الصفحات / إغلاق المتصفح / النت فصل)
    // .leaving((user) => {
    //     if (user.id === targetId) {

    //         // ❗ لا نعتبره Offline فورًا
    //         offlineTimer = setTimeout(() => {
    //             setOffline();
    //         }, 6000);   // ← 6 ثواني (عدّلها كما تريد)
    //     }
    // });
</script>
