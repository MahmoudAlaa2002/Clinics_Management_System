<script>

    let offlineTimer = null;

    Echo.join('online-users')

        .here((users) => {
            users.forEach(u => {
                if (u.id === targetId) {
                    if (offlineTimer) clearTimeout(offlineTimer);
                    setOnline();
                }
            });
        })

        .joining((user) => {
            if (user.id === targetId) {
                if (offlineTimer) clearTimeout(offlineTimer);
                setOnline();
            }
        })

        .leaving((user) => {
            if (user.id === targetId) {
                offlineTimer = setTimeout(() => setOffline(), 6000);
            }
        });

</script>
