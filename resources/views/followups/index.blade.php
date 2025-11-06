<x-app-layout>
<div class="container py-4">

  {{-- Alert sukses --}}
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
      <i class="bi bi-check-circle-fill me-2"></i>
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- HEADER --}}

   <div class="mt-3">
      <a href="{{ route('leads.index') }}" class="btn btn-outline-danger">
        <i class="bi bi-arrow-left"></i> Back
      </a>
    </div>

  <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
    <div>
      <h2 class="fw-bold text-danger mb-1">
        <i class="bi bi-chat-dots-fill me-2"></i>Follow Ups —
        <span class="text-dark">{{ $lead->crm->name ?? 'Without CRM' }}</span>
      </h2>
      <p class="text-muted small mb-0">Monitor communication activities and progress of each lead.</p>
    </div>
    <div><button class="btn btn-danger shadow-sm rounded-3" data-bs-toggle="modal" data-bs-target="#addFollowUpModal">
      <i class="bi bi-plus-circle me-1"></i> Add Follow Up
    </button>

     <button class="btn btn-danger shadow-sm rounded-3" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
      <i class="bi bi-plus-circle me-1"></i> Add Appointment
    </button>
  </div>

  </div>

  {{-- Timeline Follow-ups --}}
  @if($lead->followUps->isEmpty())
    <div class="text-center text-muted py-5">
      <i class="bi bi-clock-history display-5 d-block mb-3 text-danger"></i>
      <p class="mb-0 fw-semibold">There has been no follow-up for this lead.</p>
    </div>
  @else
    <div class="timeline">
      @foreach($lead->followUps->sortByDesc('date') as $f)
        <div class="timeline-item mb-4 p-4 bg-white border-0 rounded-4 shadow-sm position-relative">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <div class="d-flex align-items-center gap-2 mb-2">
                <h6 class="fw-semibold text-danger mb-0">
                  <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($f->date)->format('d M Y') }}
                </h6>
                <span class="badge bg-light text-dark border">{{ ucfirst($f->type) }}</span>
              </div>
             @if($f->type == 'appointment')
                <span class="badge bg-danger-subtle text-danger border border-danger px-4 py-2 fs-6 rounded-pill">
                    <i class="bi bi-bell-fill me-2"></i>
                    Reminder Appointment:
                    <strong class="text-dark">{{ \Carbon\Carbon::parse($f->date)->format('d M Y, H:i') }}</strong>
                </span>
            @endif
              <p class="text-muted small mb-2">
                <i class="bi bi-clock me-1"></i>{{ $f->created_at->diffForHumans() }}
              </p>
              <div class="text-dark lh-lg">{!! nl2br(e($f->notes)) !!}</div>
            </div>
            <div class="d-flex gap-2">
              {{-- Tombol edit --}}
              <a href="{{ route('followups.edit', [$lead->id, $f->id]) }}" class="btn btn-sm btn-outline-warning rounded-circle" title="Edit">
                <i class="bi bi-pencil-square"></i>
              </a>

              {{-- Tombol delete --}}
              <form action="{{ route('followups.destroy', [$lead->id, $f->id]) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus follow-up ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus">
                  <i class="bi bi-trash3"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>

<!-- modal appointment -->
 <!-- Modal -->

{{-- APPOINTMENT MODAL  --}}

<div class="modal fade" id="addAppointmentModal" tabindex="-1" aria-labelledby="addAppointmentLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="{{ route('appointments.store', ['lead_id' => $lead->id]) }}" class="modal-content rounded-4 shadow">
      @csrf
      <div class="modal-header bg-danger text-white rounded-top-4">
        <h5 class="modal-title"><i class="bi bi-plus-circle me-1"></i> Add Appointment</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body bg-light">
        <input type="hidden" name="lead_id" value="{{ $lead->id }}">
          {{-- <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
          </div> --}}
          <div class="mb-3">
            <label>Reminder Date & Time</label>
            <input type="datetime-local" name="reminder_at" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
          </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger px-4">Save</button>
      </div>
    </form>
  </div>
</div>


{{-- MODAL TAMBAH FOLLOW UP --}}
<div class="modal fade" id="addFollowUpModal" tabindex="-1" aria-labelledby="addFollowUpLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="{{ route('followups.store', ['lead_id' => $lead->id]) }}" class="modal-content rounded-4 shadow">
      @csrf
      <div class="modal-header bg-danger text-white rounded-top-4">
        <h5 class="modal-title"><i class="bi bi-plus-circle me-1"></i> Add Follow Up</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body bg-light">
        <div class="mb-3">
          <label for="date" class="form-label fw-semibold">Date</label>
          <input type="date" name="date" id="date" class="form-control shadow-sm" required>
        </div>

        <div class="mb-3">
        <label for="type" class="form-label fw-semibold">Follow Up Type</label>
        <select name="type" id="type" class="form-select shadow-sm" required>
            <option value="">-- Select Type --</option>
            @foreach($types as $t)
            <option value="{{ $t }}">{{ ucfirst($t) }}</option>
            @endforeach
        </select>
        </div>


        <div class="mb-3">
          <label for="notes" class="form-label fw-semibold">Notes</label>
          <textarea name="notes" id="notes" rows="4" class="form-control shadow-sm"
            placeholder="Write a concise and informative follow-up note..." required></textarea>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger px-4">Save</button>
      </div>
    </form>
  </div>
</div>

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
  /* Timeline Style */
  .timeline {
    position: relative;
    padding-left: 1.5rem;
  }
  .timeline::before {
    content: '';
    position: absolute;
    top: 0;
    left: 10px;
    width: 3px;
    height: 100%;
    background: #dc3545;
    border-radius: 3px;
  }
  .timeline-item::before {
    content: '';
    position: absolute;
    left: -6px;
    top: 22px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: #dc3545;
    border: 3px solid #fff;
    box-shadow: 0 0 0 2px #dc3545;
  }

  .timeline-item:hover {
    background: #fff6f6;
    transition: all 0.2s ease-in-out;
  }

  .modal-content {
    border: none;
  }

  .btn.rounded-circle {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
</style>
</x-app-layout>
