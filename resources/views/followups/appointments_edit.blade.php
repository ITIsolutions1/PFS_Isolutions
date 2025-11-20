<x-app-layout>
  <div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="fw-bold text-danger mb-1">
          <i class="bi bi-calendar-check me-2"></i>Edit Appointment
        </h3>
        <p class="text-muted small mb-0">
          Update appointment for lead:
          <span class="fw-semibold text-dark">{{ $lead->crm->name ?? 'Unknown Lead' }}</span>
        </p>
      </div>
      <a href="{{ route('followups.index', $lead->id) }}" class="btn btn-outline-secondary shadow-sm rounded-3">
        <i class="bi bi-arrow-left"></i> Back
      </a>
    </div>

    <!-- Card -->
    <div class="card border-0 shadow-sm rounded-4">
      <div class="card-body p-4">
        <h5 class="fw-bold text-secondary mb-4">Edit Appointment Details</h5>
<form action="{{ route('appointments.update', [$lead->id, $followup->id]) }}" method="POST">
    @csrf
    @method('PUT')


          <input type="hidden" name="lead_id" value="{{ $lead->id }}">

          <div class="row g-3">
            <!-- Appointment Date & Time -->
            <div class="col-md-6">
              <label for="reminder_at" class="form-label fw-semibold text-secondary">
                Appointment Date & Time
              </label>
              <input type="datetime-local" name="reminder_at" id="reminder_at"
                     value="{{ old('reminder_at', \Carbon\Carbon::parse($followup->date)->format('Y-m-d\TH:i')) }}"
                     class="form-control shadow-sm" required>
            </div>

            <!-- Notes -->
            <div class="col-12">
              <label for="notes" class="form-label fw-semibold text-secondary">
                Notes
              </label>
              <textarea name="description" id="notes" rows="5" 
                        class="form-control shadow-sm"
                        placeholder="Add a note for this appointment...">{{ old('description', $followup->notes) }}</textarea>
            </div>
          </div>

          <!-- Buttons -->
          <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('followups.index', $lead->id) }}" class="btn btn-outline-secondary px-4">
              <i class="bi bi-x-circle"></i> Cancel
            </a>
            <button type="submit" class="btn btn-danger px-4">
              <i class="bi bi-save"></i> Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <style>
    .form-control, .form-select {
      border-radius: 10px;
      padding: 0.7rem 0.9rem;
      transition: all 0.2s ease-in-out;
    }

    .form-control:focus {
      border-color: #dc3545;
      box-shadow: 0 0 0 0.15rem rgba(220,53,69,0.25);
    }

    .card {
      transition: all 0.25s ease-in-out;
    }

    .card:hover {
      transform: translateY(-2px);
    }

    textarea {
      resize: none;
    }
  </style>
</x-app-layout>
