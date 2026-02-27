<x-app-layout>


  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
  />

  <div class="container py-4">

    {{-- ALERT SECTION --}}
    @foreach (['success', 'warning'] as $type)
      @if(session($type))
        <div class="alert alert-{{ $type }} alert-dismissible fade show shadow-sm" role="alert">
          {{ session($type) }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif
    @endforeach

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3 mt-5">
      <div>
        <h2 class="fw-bold text-danger mb-1">
          <i class="bi bi-people-fill me-2"></i> Leads List
        </h2>
        <p class="text-muted small mb-0">
          @if(!empty($selectedCategory))
            Showing leads in <strong>{{ $selectedCategory->name }}</strong> category.
          @else
            Monitor and manage all your potential client projects.
          @endif
        </p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('leads.dashboard') }}" class="btn btn-outline-danger btn-sm">
          <i class="bi bi-arrow-left"></i> Back
        </a>
        <a href="{{ route('leads.create') }}" class="btn btn-danger btn-sm shadow-sm">
          <i class="bi bi-plus-circle me-1"></i> Add Lead
        </a>
      </div>
    </div>

    {{-- FILTER SECTION --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
      <div class="card-body p-3">
       <form method="GET"
      action="{{ isset($selectedCategory)
          ? route('leads.byCategory', ['id' => $selectedCategory->id])
          : route('leads.index') }}">

  <div class="row g-2 align-items-end">

    {{-- Search --}}
    <div class="{{ empty($selectedCategory) ? 'col-md-5' : 'col-md-8' }}">
      <label class="form-label small fw-semibold text-muted mb-1">
        Search by CRM Name
      </label>
      <input
        type="text"
        name="search_name"
        class="form-control form-control-sm"
        value="{{ request('search_name') }}"
      >
    </div>

    {{-- Category --}}
    @if(empty($selectedCategory))
      <div class="col-md-3">
        <label class="form-label small fw-semibold text-muted mb-1">
          Filter by Category
        </label>
        <select name="category_id" class="form-select form-select-sm">
          <option value="">All Categories</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
              {{ $cat->name }}
            </option>
          @endforeach
        </select>
      </div>
    @endif

    {{-- Buttons --}}
    <div class="col-md-4">
      <div class="d-flex gap-2">

        {{-- APPLY --}}
        <button type="submit" class="btn btn-danger btn-sm px-3">
          <i class="bi bi-search me-1"></i> Apply
        </button>

        {{-- RESET --}}
        <a href="{{ isset($selectedCategory)
            ? route('leads.byCategory', ['id' => $selectedCategory->id])
            : route('leads.index') }}"
           class="btn btn-outline-secondary btn-sm px-3">
          <i class="bi bi-arrow-repeat me-1"></i> Reset
        </a>

        {{-- EXPORT (AMAN) --}}
        <button
            type="button"
            class="btn btn-success btn-sm px-3"
            data-bs-toggle="modal"
            data-bs-target="#exportLeadsModal">
          <i class="bi bi-file-earmark-excel"></i> Export
        </button>

      </div>
    </div>

  </div>
</form>


        
      </div>
    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-nowrap">
          <thead class="bg-danger text-white">
            <tr>
              <th class="text-center">No</th>
              <th>
                Created At
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at_asc']) }}" class="text-white small">&#9650;</a>
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at_desc']) }}" class="text-white small">&#9660;</a>
              </th>
              <th>
                CRM Name
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}" class="text-white small">&#9650;</a>
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'name_desc']) }}" class="text-white small">&#9660;</a>
              </th>
              <th>Category</th>
              <th>Status</th>
              <th>Follow Ups</th>
              <th>Last Contact</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($leads as $lead)
              <tr class="hover-row">
                <td class="text-center fw-semibold">
                  {{ ($leads->currentPage() - 1) * $leads->perPage() + $loop->iteration }}
                </td>
                <td>{{ $lead->created_at ? \Carbon\Carbon::parse($lead->created_at)->translatedFormat('d M Y, H:i') : '-' }}</td>
                <td class="fw-semibold">
                  <a href="{{ route('leads.show', $lead->id) }}" class="text-decoration-none text-dark">
                    {{ $lead->crm->name }} <br><span class="text-muted">
                      {{ $lead->crm->company ? '('.$lead->crm->company.')' : '' }}
                    </span>
                  </a>
                </td>
                <td>{{ $lead->crm->category->name ?? '-' }}</td>
                <td>
                  @php
                    $badgeColors = [
                      'new' => 'secondary',
                      'contacted' => 'info',
                      'qualified' => 'success',
                      'unqualified' => 'danger',
                    ];
                    $icons = [
                      'new' => 'bi-lightning-charge',
                      'contacted' => 'bi-telephone',
                      'qualified' => 'bi-check-circle',
                      'unqualified' => 'bi-x-circle',
                    ];
                  @endphp
                  <span class="badge bg-{{ $badgeColors[$lead->status] ?? 'secondary' }} px-3 py-2 rounded-pill shadow-sm">
                    <i class="bi {{ $icons[$lead->status] ?? 'bi-circle' }} me-1"></i>
                    {{ ucfirst($lead->status) }}
                  </span>
                </td>
                <td>
                  <a href="{{ route('followups.index', $lead->id) }}" class="text-decoration-none text-dark">
                    <i class="bi bi-chat-dots-fill text-danger me-1"></i>
                    {{ $lead->followUps->count() }} x
                  </a>
                </td>
                <td>
                  @if($lead->followUps->count())
                    @php $latestFollowUp = $lead->followUps->sortByDesc('date')->first(); @endphp
                    {{ \Carbon\Carbon::parse($latestFollowUp->date)->format('d M Y') }}
                  @else
                    <span class="text-muted">Not Yet</span>
                  @endif
                </td>
                <td class="text-center">
                  <div class="d-flex justify-content-center gap-2 flex-wrap">
                    <a href="{{ route('followups.index', $lead->id) }}" class="btn btn-sm btn-outline-danger rounded-circle" title="Follow Ups">
                      <i class="bi bi-chat-dots-fill"></i>
                    </a>
                    <a href="{{ route('leads.edit', ['lead' => $lead->id] + (isset($selectedCategoryId) ? ['category_id' => $selectedCategoryId] : [])) }}"
                      class="btn btn-sm btn-outline-warning rounded-circle"
                      title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    <form action="{{ route('leads.destroy', $lead) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this lead?')">
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
                <td colspan="8" class="text-center text-muted py-5">
                  <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                  No leads found.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="mt-3 d-flex justify-content-center">
      {{ $leads->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

    <!-- Modal Export Leads -->
<div class="modal fade" id="exportLeadsModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('leads.export') }}" method="POST" class="modal-content">
      @csrf

      <input
      type="hidden"
      name="category_id"
      value="{{ $selectedCategory->id ?? request('category_id') }}">

      <div class="modal-header">
        <h5 class="modal-title">Export Leads ke Excel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        @php
          $fields = [
              'crm_id' => 'CRM ID',
              'status' => 'Status',
              'category' => 'Category',
              'notes' => 'Notes',
          ];
        @endphp

        @foreach($fields as $key => $label)
          <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="columns[]"
                   value="{{ $key }}"
                   id="lead_{{ $key }}">
            <label class="form-check-label" for="lead_{{ $key }}">
              {{ $label }}
            </label>
          </div>
        @endforeach

      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-success">
            Export Excel
        </button>
      </div>

    </form>
  </div>
</div>


  </div>

  

  <style>
    body { background-color: #fafafa; }
    .hover-row:hover { background-color: #fff5f5 !important; transition: 0.2s ease-in-out; }
    .btn.rounded-circle { width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; }
    .form-label { font-size: 0.85rem; }
    .form-control, .form-select { border-radius: 0.5rem; }
    @media (max-width: 768px) {
      .table th, .table td { font-size: 13px; white-space: nowrap; }
      .btn.rounded-circle { width: 32px; height: 32px; }
      h2.fw-bold { font-size: 1.25rem; }
    }
  </style>
</x-app-layout>
