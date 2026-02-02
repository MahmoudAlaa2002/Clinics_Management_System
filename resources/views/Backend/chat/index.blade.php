<style>

    /* تأثير hover للنص فقط */
    .msg-item:hover{
        background:#00A8FF !important;
    }

    /* غيّر لون النصوص فقط */
    .msg-item:hover .msg-text,
    .msg-item:hover .msg-name{
        color:#fff !important;
    }

    .no-msg-item:hover{
        background:#00A8FF !important;
        color:#fff !important;
        cursor:default; /* اختياري */
    }

    .no-msg-item{
        height: 280px;                 /* نفس تقريبًا ارتفاع قائمة الرسائل */
        display: flex;
        align-items: center;           /* عمودي */
        justify-content: center;       /* أفقي */
        font-size: 14px;
        color: #9ca3af;
        font-weight: 600;
        text-align: center;
        background: #fff;
    }

    /* لما يمر الماوس لا يتغير */
    .no-msg-item:hover{
        background: #fff !important;
        color: #9ca3af !important;
        cursor: default;
    }


</style>


<li class="nav-item dropdown d-none d-sm-block">

    <a class="nav-link dropdown-toggle position-relative" data-toggle="dropdown" href="#" role="button">

        <i class="fa fa-comment-o"></i>

        <span id="navbar-unread" class="badge badge-pill badge-danger">
            {{ ($navbarUnreadCount ?? 0) > 99 ? '+99' : ($navbarUnreadCount ?? 0) }}
        </span>
    </a>

    <div class="dropdown-menu dropdown-menu-right p-0 shadow-lg border-0"
         style="width:340px; border-radius:14px; overflow:hidden;">

        <div style="padding:12px 14px; font-weight:700;
            background:#f7f9fc; border-bottom:1px solid #eef2f7;text-align:center;">
            Messages
        </div>

        <div id="chat-header-list" style="max-height:340px; overflow-y:auto;">

            @forelse($conversations ?? [] as $conv)

                @php
                    $target = $conv->participants->first();
                    $last   = $conv->messages->first();
                @endphp

                <a href="{{ route('chat_open', $target->id) }}"
                   class="dropdown-item d-flex align-items-center msg-item"
                   style="padding:12px 14px; transition:.25s;"
                   data-conv-wrapper="{{ $conv->id }}">

                    <div class="mr-3">
                        @if($target->image)
                            <img src="{{ asset('storage/'.$target->image) }}"
                                 style="width:44px;height:44px;border-radius:50%;
                                 object-fit:cover; box-shadow:0 4px 14px rgba(0,0,0,.10);">
                        @else
                            <div style="width:44px;height:44px;border-radius:50%;
                                background:#e8f2ff;color:#0b4e7a;font-weight:700;
                                display:flex;align-items:center;justify-content:center;">
                                {{ strtoupper(substr($target->name,0,2)) }}
                            </div>
                        @endif
                    </div>

                    <div class="flex-fill">

                        <div class="msg-name" style="font-weight:700; color:#0d1f33;">
                            {{ $target->name }}
                        </div>

                        <div class="msg-text" style="font-size:12px; color:#6c7a92; margin-top:2px;">
                            {{ $last ? Str::limit($last->message, 40) : 'No messages yet' }}
                        </div>

                    </div>

                    @if($conv->unread_count > 0)
                        <span class="badge badge-danger ml-2"
                              data-conv="{{ $conv->id }}">
                            {{ $conv->unread_count > 99 ? '+99' : $conv->unread_count }}
                        </span>
                    @else
                        <span class="badge badge-danger ml-2"
                              style="display:none"
                              data-conv="{{ $conv->id }}">
                        </span>
                    @endif

                </a>

                <div style="height:1px;background:#f1f3f7;margin:0 12px;"></div>

            @empty

                <div class="no-msg-item">
                    No conversations yet
                </div>


            @endforelse

        </div>

        <div class="text-center py-2" style="background:#fbfcff;border-top:1px solid #eef2f7;">
            <a href="{{ route('chat_contacts') }}" style="font-weight:600;">
                View all messages
            </a>
        </div>

    </div>

</li>



@section('js')
<script>

    function recalcNavbarUnread() {
        let total = 0;

        document.querySelectorAll('.badge[data-conv]').forEach((el) => {
            let val = parseInt(el.innerText);
            if (!isNaN(val)) total += val;
        });

        let navbarBadge = document.getElementById('navbar-unread');
        if (!navbarBadge) return;

        navbarBadge.innerText = (total > 99) ? '+99' : total;
    }


    Echo.private(`user.{{ auth()->id() }}`)
        .listen('NewChatMessage', (e) => {

            if (e.receiver_id !== {{ auth()->id() }}) return;

            updateConversationPreview(e);
            updateUnreadBadges(e);
            recalcNavbarUnread();
        });


    function updateUnreadBadges(e) {

        let convBadge = document.querySelector(
            `.badge[data-conv="${e.conversation_id}"]`
        );

        if (convBadge) {

            if (e.unread_count > 0) {
                convBadge.style.display = 'inline-block';
                convBadge.innerText = (e.unread_count > 99)
                    ? '+99'
                    : e.unread_count;
            } else {
                convBadge.style.display = 'none';
                convBadge.innerText = '';
            }
        }
    }



    function updateConversationPreview(e) {

        let list = document.getElementById('chat-header-list');
        if (!list) return;

        let emptyMsg = document.querySelector('.no-msg-item');
        if (emptyMsg) emptyMsg.remove();

        // موجودة من قبل؟
        let wrapper = list.querySelector(
            `[data-conv-wrapper="${e.conversation_id}"]`
        );

        if (wrapper) {

            let text = wrapper.querySelector('.msg-text');
            if (text) text.innerText = e.message;

            list.prepend(wrapper);
            return;
        }

        // 👇👇 جديد — إنشاء محادثة في الهيدر فوراً 👇👇

        let avatar = `
            <div style="
                width:44px;height:44px;border-radius:50%;
                background:#e8f2ff;color:#0b4e7a;font-weight:700;
                display:flex;align-items:center;justify-content:center;">

                ${
                    e.sender_image
                        ? `<img src="${e.sender_image}"
                                onerror="this.parentNode.innerHTML='${e.sender_name.substring(0,2).toUpperCase()}'"
                                style="width:44px;height:44px;border-radius:50%;object-fit:cover;">`
                        : e.sender_name.substring(0,2).toUpperCase()
                }
            </div>`;





            let html = `
                <a href="/clinics-management/chat/open/${e.sender_id}"
                class="dropdown-item d-flex align-items-center msg-item"
                style="padding:12px 14px; transition:.25s;"
                data-conv-wrapper="${e.conversation_id}">

                    <div class="mr-3">
                        <div style="width:44px;height:44px;border-radius:50%;
                            background:#e8f2ff;color:#0b4e7a;font-weight:700;
                            display:flex;align-items:center;justify-content:center;">
                            ${avatar}
                        </div>
                    </div>

                    <div class="flex-fill">

                        <div class="msg-name" style="font-weight:700; color:#0d1f33;">
                            ${e.sender_name}
                        </div>

                        <div class="msg-text" style="font-size:12px; color:#6c7a92; margin-top:2px;">
                            ${e.message}
                        </div>

                    </div>

                    <span class="badge badge-danger ml-2"
                        data-conv="${e.conversation_id}">
                        1
                    </span>

                </a>

                <div style="height:1px;background:#f1f3f7;margin:0 12px;"></div>
                `;


        list.insertAdjacentHTML('afterbegin', html);
    }

</script>
@endsection
