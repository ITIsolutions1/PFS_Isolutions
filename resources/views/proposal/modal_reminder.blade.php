@if($proposals->isEmpty())
    <div class="text-center py-4">
        <p class="text-success fw-bold mb-1" style="font-size: 18px;">No proposals require follow-up 🎉</p>
        <small class="text-muted">Everything is up to date.</small>
    </div>
@else

    @php $limit = 5; @endphp

    <style>
        .proposal-card {
            border-radius: 14px;
            padding: 14px 18px;
            margin-bottom: 12px;
            background: #ffffff;
            border: 1px solid #eee;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: 0.2s ease-in-out;
        }
        .proposal-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.10);
        }
        .proposal-title {
            font-size: 16px;
            font-weight: 700;
            color: #b30000;
        }
        .proposal-sub {
            font-size: 14px;
        }
        .badge-follow {
            font-size: 11px;
            padding: 4px 8px;
            background: #f8d7da;
            color: #b30000;
            border-radius: 8px;
        }
        #allProposalReminder {
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <div class="mt-3">

        {{-- 5 pertama --}}
        @foreach($proposals->take($limit) as $p)

            @php
                $last = $p->followups->sortByDesc('followup_date')->first();
                $days = $last ? \Carbon\Carbon::parse($last->followup_date)->diffInDays(now()) : null;
            @endphp

            <a href="{{ route('proposals.show', $p->id) }}" class="text-decoration-none text-dark">
                <div class="proposal-card">

                    <div class="proposal-title">
                        {{ $p->title ?? 'Untitled Proposal' }}
                    </div>

                    <div class="proposal-sub text-muted">
                        {{ $p->lead?->crm->name ?? '-' }}
                    </div>

                    <div class="mt-1">
                        <span class="badge-follow">
                            Last followup: {{ $last->followup_date ?? 'None' }}
                            @if($days) — {{ $days }} days ago @endif
                        </span>
                    </div>

                </div>
            </a>

        @endforeach

        {{-- Hidden items --}}
        <div id="allProposalReminder" style="display:none;">
            @foreach($proposals->skip($limit) as $p)

                @php
                    $last = $p->followups->sortByDesc('followup_date')->first();
                    $days = $last ? \Carbon\Carbon::parse($last->followup_date)->diffInDays(now()) : null;
                @endphp

                <a href="{{ route('proposals.show', $p->id) }}" class="text-decoration-none text-dark">
                    <div class="proposal-card">

                        <div class="proposal-title">
                            {{ $p->title ?? 'Untitled Proposal' }}
                        </div>

                        <div class="proposal-sub text-muted">
                            {{ $p->crm->name ?? '-' }}
                        </div>

                        <div class="mt-1">
                            <span class="badge-follow">
                                Last followup: {{ $last->followup_date ?? 'None' }}
                                @if($days) — {{ $days }} days ago @endif
                            </span>
                        </div>

                    </div>
                </a>

            @endforeach
        </div>

    </div>

    {{-- Tombol View All --}}
    @if($proposals->count() > $limit)
        <div class="mt-2 text-center">
            <button id="btnViewAllProposal" class="btn btn-light border shadow-sm px-4 py-2"
                style="border-radius: 10px; font-weight: 600;">
                View All ({{ $proposals->count() }})
            </button>
        </div>
    @endif

@endif


<script>
document.getElementById('btnViewAllProposal')?.addEventListener('click', function () {
    document.getElementById('allProposalReminder').style.display = 'block';
    this.remove();
});
</script>

