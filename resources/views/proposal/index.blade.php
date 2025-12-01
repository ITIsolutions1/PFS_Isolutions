<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
/>
<style>
.status-card {
    width: 85px;
    aspect-ratio: 1 / 1;
    border-radius: 12px;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    color: white; /* 👈 tulisan jadi putih */
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    transition: 0.2s;
}

.status-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 14px rgba(0,0,0,0.25);
}

.status-card.inactive {
    opacity: .65;
    filter: grayscale(.3);
}

.status-wrapper {
    gap: 4px !important; 
}
</style>


<x-app-layout>
  @php
    $filterStatus = request('status');
@endphp

     <marquee behavior="scroll" direction="left" scrollamount="6" style="background-color: #ec1b2dff; color: #fce9ebff; padding: 10px; font-weight: bold;">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Sorry, this page is still under construction.
    </marquee>
    
<div class="container py-4">

  {{-- ALERTS --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- BACK BUTTON --}}
  <div class="mt-3">
    <a href="{{ route('leads.index') }}" class="btn btn-outline-danger">
      <i class="bi bi-arrow-left"></i> Back
    </a>
  </div>

@php
    $statusOptions = [
        'all' => 'All',
        'rfp' => 'RFP',
        'draft' => 'Draft',
        'submitted' => 'Submitted',
        'awaiting_po' => 'Awaiting PO',
        'awarded' => 'Awarded',
        'decline' => 'Decline',
        'lost' => 'Lost',
    ];

    // Gradasi merah ke merah tua
    $gradientColors = [
        '#ffcccc', '#ff9999', '#ff7a7a', '#ff5d5d',
        '#ff3f3f', '#ff2222', '#e60000', '#b30000'
    ];
@endphp

<div class="d-flex justify-content-end mb-4">
    <div class="d-flex gap-2 flex-wrap">

        @foreach ($statusOptions as $key => $label)
            @php
                $index = array_search($key, array_keys($statusOptions));
                $bg = $gradientColors[$index] ?? '#ffcccc';
                $isActive = request('status') == $key || (request('status') === null && $key == 'all');

                $total = $key === 'all'
                    ? ($totalAll ?? 0)
                    : ($statusCounts[$key] ?? 0);
            @endphp

            <a href="{{ route('proposals.index', ['status' => $key === 'all' ? null : $key]) }}"
               class="text-decoration-none">

                <div class="status-card {{ $isActive ? '' : 'inactive' }}"
                     style="background: linear-gradient(135deg, {{ $bg }}, {{ $isActive ? '#ff0000' : '#a00000' }});">

                    <div class="fw-bold">{{ $total }}</div>
                    <div class="small">{{ $label }}</div>

                </div>

            </a>
        @endforeach

    </div>
</div>



  {{-- HEADER --}}
  <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
    <div>
 <h2 class="fw-bold text-danger mb-0">
    <i class="bi bi-folder-fill me-2"></i>
    Proposal List
    @if(request('status'))
        - {{ strtoupper(request('status')) }}
    @endif
</h2>

      <p class="text-muted small mb-0">Stay organized and keep track of every proposal’s progress</p>
    </div>

    <div>
    <!-- <a href="{{ asset('scripts/open_folder.bat') }}" download class="btn btn-danger shadow-sm">
        <i class="bi bi-folder2-open me-1"></i> Open Folder in Explorer
    </a>

    <a href="file://192.168.2.10/sharing folder" class="btn btn-danger shadow-sm">
      <i class="bi bi-folder2-open me-1"></i> Open Folder in server
    </a> -->




    <a href="{{ route('proposals.create') }}" class="btn btn-danger shadow-sm">
      <i class="bi bi-plus-circle me-1"></i> Add
    </a>
    </div>

  </div>

<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('proposals.index') }}">
              <input type="hidden" name="status" value="{{ request('status') }}">
            <div class="row g-2 align-items-end">

                {{-- Search --}}
                <div class="col-md-5">
                    <label for="search" class="form-label small fw-semibold text-muted mb-1">
                        Search 
                    </label>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="form-control form-control-sm"
                        placeholder="Type anything..."
                        value="{{ request('search') }}"
                    >
                </div>

                {{-- Pagination Size Selector --}}
                <div class="col-md-2">
                    <label for="per_page" class="form-label small fw-semibold text-muted mb-1">
                        Show pagination
                    </label>
                    <select name="per_page" id="per_page" class="form-select form-select-sm">
                        @foreach ([5, 10, 15, 25, 50, 100, 'all'] as $size)
                            <option value="{{ $size }}" {{ request('per_page', 'all') == $size ? 'selected' : '' }}>
                                {{ $size == 'all' ? 'All' : $size }}
                            </option>
                        @endforeach
                    </select>
                </div>

                

                {{-- Buttons --}}
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-muted mb-1 d-block">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-danger btn-sm px-3">
                            <i class="bi bi-search me-1"></i> Apply
                        </button>

                        <a href="{{ route('proposals.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                            <i class="bi bi-arrow-repeat me-1"></i> Reset
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<div id="proposalReminderModal" class="modal fade" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-danger shadow-lg">
      
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Submitted Follow-up Reminder</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body" id="proposalReminderContent">
        <p class="text-center text-muted">Loading...</p>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



  {{-- TABLE --}}
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-0">
      <table class="table align-middle mb-0">
        <thead class="bg-danger text-white">
          <tr>
            <th style="width:5%" class="text-center">No</th>
            <th style="width:15%">
              <span>Created at</span>
              <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at_asc']) }}" style="text-decoration: none; color: white; font-size: 11px;">&#9650;</a>
              <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at_desc']) }}" style="text-decoration: none; color: white; font-size: 11px;">&#9660;</a>
            </th>
            <th style="width:15%">
              <span>Title</span>
              <a href="{{ request()->fullUrlWithQuery(['sort' => 'title_asc']) }}" style="text-decoration: none; color: white; font-size: 11px;">&#9650;</a>
              <a href="{{ request()->fullUrlWithQuery(['sort' => 'title_desc']) }}" style="text-decoration: none; color: white; font-size: 11px;">&#9660;</a>
            </th>

             <th style="width:20%">
              <span>Name</span>
              <a href="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}" style="text-decoration: none; color: white; font-size: 11px;">&#9650;</a>
              <a href="{{ request()->fullUrlWithQuery(['sort' => 'name_desc']) }}" style="text-decoration: none; color: white; font-size: 11px;">&#9660;</a>
            </th>

            <th style="width:10%">
              Status
              <a href="{{ request()->fullUrlWithQuery(['sort' => 'status_asc']) }}" style="text-decoration: none; color: white; font-size: 11px;">&#9650;</a>
              <a href="{{ request()->fullUrlWithQuery(['sort' => 'status_desc']) }}" style="text-decoration: none; color: white; font-size: 11px;">&#9660;</a>
            </th>

            @if($filterStatus === 'submitted')
                <th>Submitted At</th>
            @endif

           


            <th style="width:8%">
              <span>PIC</span>
              <a href="{{ request()->fullUrlWithQuery(['sort' => 'pic_asc']) }}" style="text-decoration: none; color: white; font-size: 11px;">&#9650;</a>
              <a href="{{ request()->fullUrlWithQuery(['sort' => 'pic_desc']) }}" style="text-decoration: none; color: white; font-size: 11px;">&#9660;</a>
            </th>

             @if($filterStatus === 'decline')
                <th style="width:10%">Decline Reason</th>
            @endif
            <th>Description</th>
            <th class="text-center" style="width:10%">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($proposals as $index => $proposal)
          <tr class="hover-row">
            <td class="text-center">{{ $proposals->firstItem() + $index }}</td>
            <td>{{ $proposal->created_at->format('d M Y') }}</td>
            <td>{{ $proposal->title }}</td>
            <!-- <td>{{ $proposal->lead->crm->name }} -->

            <td class="fw-semibold" title="View Detail Lead">
              <a href="{{ route('proposals.show2', $proposal->id) }}" class="text-decoration-none text-dark">
                  {{ $proposal->lead->crm->name  }}
              </a>
              <br>
               <small class="text-danger">{{$proposal->lead->crm->company}}</small>
          </td>
                <!-- <br>
                <small class="text-danger">{{$proposal->lead->crm->company}}</small>
            </td> -->

            <td>
              @php
                $statusColors = [
                    'draft' => 'secondary',
                    'submitted' => 'primary',
                    'awaiting_po' => 'warning',
                    'awarded' => 'success',
                    'decline' => 'danger',
                    'lost' => 'dark'
                ];
              @endphp
              <span class="badge bg-{{ $statusColors[$proposal->status] ?? 'secondary' }}">
                {{ ucfirst(str_replace('_', ' ', $proposal->status)) }}
              </span>
            </td>
           @if($filterStatus === 'submitted')
              <td>
                  {{ $proposal->submitted_at ? \Carbon\Carbon::parse($proposal->submitted_at)->format('d M Y') : '-' }}
              </td>
          @endif

     


            <td>{{ $proposal->assignedUser->name ?? '-' }}</td>
                 @if($filterStatus === 'decline')
              <td>
                  {{ $proposal->decline_reason ?? '-' }}
              </td>
          @endif
            <td class="text-truncate" style="max-width: 250px;">{{ $proposal->description ?? '-' }}</td>

            <td class="text-center">
              <div class="btn-group">
                <a href="{{ route('proposals.show', $proposal->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle" title="View">
                  <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('proposals.edit', $proposal->id) }}" class="btn btn-sm btn-outline-primary rounded-circle" title="Edit">
                  <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('proposals.destroy', $proposal->id) }}" method="POST" onsubmit="return confirm('Are you sure want to delete this proposal?')" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center text-muted py-4">
                <i class="bi bi-folder-x fs-3 d-block mb-2"></i>
                No proposals found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-3">
    {{ $proposals->links() }}
  </div>

</div>

{{-- STYLE --}}
<style>
  .pagination .page-link {
      color: #dc3545;
      border: 1px solid #dc3545;
  }
  .pagination .page-item.active .page-link {
      background-color: #dc3545;
      border-color: #dc3545;
      color: #fff;
  }
  .pagination .page-link:hover {
      background-color: #dc3545;
      color: #fff;
      border-color: #dc3545;
  }
  .pagination .page-item.disabled .page-link {
      color: #ccc;
      border-color: #eee;
      background-color: #fff;
  }
  .hover-row:hover {
      background-color: #fff5f5;
      transition: 0.2s;
  }
  .card { overflow: hidden; }
  .btn.rounded-circle {
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
  }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const path = window.location.pathname;            // /proposals
    const search = window.location.search;            // ?status=rfp (jika ada)

    // Jika bukan /proposals ATAU ada query parameter (?status=...)
    if (path !== "/proposals" || search !== "") {
        return; // Jangan tampilkan popup
    }

    // Jika /proposals dan tanpa query → lanjut jalankan popup
    fetch("{{ route('proposals.followupReminder') }}")
        .then(res => res.text())
        .then(html => {
            document.getElementById("proposalReminderContent").innerHTML = html;

            if (html.trim() !== "" && !html.includes("No proposals")) {
                let modal = new bootstrap.Modal(document.getElementById('proposalReminderModal'));
                modal.show();
            }

            setTimeout(() => {
                const btn = document.getElementById("btnViewAllProposal");
                if (btn) {
                    btn.onclick = () => {
                        document.getElementById("allProposalReminder").style.display = "block";
                        btn.remove();
                    };
                }
            }, 100);
        });
});
</script>




</x-app-layout>
