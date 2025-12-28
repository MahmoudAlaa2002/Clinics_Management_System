<style>

    /* تأثير hover للنص فقط */
    .msg-item:hover{
        background:#007BFF !important;
    }

    /* غيّر لون النصوص فقط */
    .msg-item:hover .msg-text,
    .msg-item:hover .msg-name{
        color:#fff !important;
    }

</style>



<li class="nav-item dropdown d-none d-sm-block">

    <a class="nav-link dropdown-toggle position-relative" data-toggle="dropdown" href="#" role="button">

        <i class="fa fa-comment-o"></i>

        <span class="badge badge-pill badge-danger">
            {{ ($navbarUnreadCount ?? 0) > 99 ? '+99' : ($navbarUnreadCount ?? 0) }}
        </span>
    </a>

    <div class="dropdown-menu dropdown-menu-right p-0 shadow-lg border-0"
         style="width:340px; border-radius:14px; overflow:hidden;">

        <!-- HEADER -->
        <div style="padding:12px 14px; font-weight:700;
            background:#f7f9fc; border-bottom:1px solid #eef2f7;text-align:center;">
            Messages
        </div>

        <!-- LIST -->
        <div style="max-height:340px; overflow-y:auto;">

            @forelse($conversations ?? [] as $conv)

                @php
                    $target = $conv->participants->first();
                    $last   = $conv->messages->first();
                @endphp

                <a href="{{ route('chat_open', $target->id) }}"
                    class="dropdown-item d-flex align-items-center msg-item"
                    style="padding:12px 14px; transition:.25s;">

                    <!-- avatar -->
                    <div class="mr-3">
                        @if($target->image)
                            <img src="{{ asset($target->image) }}"
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

                    <!-- text -->
                    <div class="flex-fill">

                        <div class="msg-name" style="font-weight:700; color:#0d1f33;">
                            {{ $target->name }}
                        </div>

                        <div class="msg-text" style="font-size:12px; color:#6c7a92; margin-top:2px;">
                            {{ $last ? Str::limit($last->message, 50) : 'No messages yet' }}
                        </div>

                    </div>

                    <!-- unread badge -->
                    @if($conv->unread_count > 0)
                        <span class="badge badge-danger ml-2">
                            {{ $conv->unread_count > 99 ? '+99' : $conv->unread_count }}
                        </span>
                    @endif

                </a>

                <div style="height:1px;background:#f1f3f7;margin:0 12px;"></div>

            @empty

                <div class="dropdown-item text-center text-muted py-4">
                    No conversations yet
                </div>

            @endforelse

        </div>

        <!-- FOOTER -->
        <div class="text-center py-2" style="background:#fbfcff;border-top:1px solid #eef2f7;">
            <a href="{{ route('chat_contacts') }}" style="font-weight:600;">
                View all messages
            </a>
        </div>

    </div>

</li>
