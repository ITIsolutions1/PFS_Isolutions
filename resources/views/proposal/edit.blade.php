<x-app-layout>
    <div class="container py-5">
        <!-- Card Utama -->
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <!-- Header Card -->
            <div class="card-header text-white py-3"
                 style="background: linear-gradient(135deg, #860808ff 0%, #d65151ff 100%);">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-pencil-square me-2"></i> Edit Proposal
                    </h5>
                </div>
            </div>

            <!-- Body Card -->
            <div class="card-body p-4">
                <form action="{{ route('proposals.update', $proposal->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Title -->
                        <div class="col-md-6">
                            <label for="title" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-pencil-square me-1 text-primary"></i> Proposal Title
                            </label>
                            <input type="text" name="title" id="title"
                                   class="form-control shadow-sm @error('title') is-invalid @enderror"
                                   value="{{ old('title', $proposal->title) }}" placeholder="Enter proposal title">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Lead -->
                        <div class="col-md-6">
                            <label for="lead_id" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-briefcase me-1 text-primary"></i> Related Lead
                            </label>
                            <select name="lead_id" id="lead_id"
                                    class="form-select shadow-sm @error('lead_id') is-invalid @enderror">
                                <option value="">-- Select Lead --</option>
                                @foreach($leads as $lead)
                                    <option value="{{ $lead->id }}"
                                            {{ old('lead_id', $proposal->lead_id) == $lead->id ? 'selected' : '' }}>
                                        {{ $lead->crm->company_name ?? $lead->crm->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lead_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <label for="status" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-flag me-1 text-primary"></i> Status
                            </label>
                            <select name="status" id="status" class="form-select shadow-sm">
                                <option value="rfp" {{ old('status', $proposal->status) == 'rfp' ? 'selected' : '' }}>Rfp</option>
                                <option value="draft" {{ old('status', $proposal->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="submitted" {{ old('status', $proposal->status) == 'submitted' ? 'selected' : '' }}>Submitted</option>
                                <option value="awaiting_po" {{ old('status', $proposal->status) == 'awaiting_po' ? 'selected' : '' }}>Awaiting PO</option>
                                <option value="awarded" {{ old('status', $proposal->status) == 'awarded' ? 'selected' : '' }}>Awarded</option>
                                <option value="decline" {{ old('status', $proposal->status) == 'decline' ? 'selected' : '' }}>Decline</option>
                                <option value="lost" {{ old('status', $proposal->status) == 'lost' ? 'selected' : '' }}>Lost</option>
                            </select>
                        </div>

                        <!-- Submitted Date -->
                        <div class="col-md-6"
                            id="submitted_date_wrapper"
                            style="display: none;">
                            <label for="submitted_at" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-calendar-check me-1 text-primary"></i> Submitted Date
                            </label>

                            <input type="date"
                                name="submitted_at"
                                id="submitted_at"
                                class="form-control shadow-sm"
                               value="{{ old('submitted_at', $proposal->submitted_at ? \Carbon\Carbon::parse($proposal->submitted_at)->format('Y-m-d') : '') }}"
                            >
                        </div>


                        <!-- Decline Reason -->
                        <div class="col-md-6" id="decline_reason_wrapper" style="display: none;">
                            <label for="decline_reason" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-exclamation-triangle me-1 text-danger"></i> Decline Reason
                            </label>
                            <textarea name="decline_reason" id="decline_reason"
                                    class="form-control shadow-sm"
                                    placeholder="Explain why this proposal was declined...">{{ old('decline_reason', $proposal->decline_reason) }}</textarea>
                        </div>



                        <!-- Assigned To -->
                        <div class="col-md-6">
                            <label for="assign_to" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-person-circle me-1 text-primary"></i> Assigned To
                            </label>
                            <select name="assign_to" id="assign_to"
                                    class="form-select shadow-sm @error('assign_to') is-invalid @enderror">
                                <option value="">-- Select User --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                            {{ old('assign_to', $proposal->assign_to) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('assign_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-chat-left-text me-1 text-primary"></i> Description
                            </label>
                            <textarea name="description" id="description" rows="4"
                                      class="form-control shadow-sm"
                                      placeholder="Enter proposal details...">{{ old('description', $proposal->description) }}</textarea>
                        </div>

                        <!-- Existing Files -->
                        @if($proposal->files && $proposal->files->count() > 0)
                            <div class="col-12">
                                <label class="form-label fw-semibold text-secondary">
                                    <i class="bi bi-paperclip me-1 text-danger"></i> Existing Files
                                </label>
                                <ul class="list-unstyled ms-1">
                                    @foreach($proposal->files as $file)
                                        <li class="mb-1">
                                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="text-decoration-none text-danger">
                                                <i class="bi bi-file-earmark-arrow-down me-1"></i> {{ $file->file_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Upload New Files -->
                        <div class="col-12">
                            <label for="files" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-cloud-upload me-1 text-primary"></i> Upload New Files (optional)
                            </label>
                            <input type="file" name="files[]" id="files" class="form-control shadow-sm" multiple>
                            <small class="text-muted">Uploading new files will add them alongside existing ones.</small>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('proposals.show', $proposal->id) }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save2"></i> Update Proposal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .card { border-radius: 1.25rem; transition: all 0.25s ease; }
        .card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
        .form-control, .form-select {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            border: 1px solid #dee2e6;
            transition: 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.15rem rgba(78,115,223,0.25);
        }
        .btn { border-radius: 0.75rem; font-weight: 500; transition: all 0.2s ease-in-out; }
        .btn:hover { transform: translateY(-2px); }
        ul.list-unstyled li a:hover { text-decoration: underline; }
    </style>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    const statusSelect = document.getElementById('status');
    const submittedWrapper = document.getElementById('submitted_date_wrapper');
    const submittedInput = document.getElementById('submitted_at');

    function toggleSubmittedDate() {
        if (statusSelect.value === 'submitted') {
            submittedWrapper.style.display = 'block';

            // Jika tidak ada value, isi otomatis tanggal hari ini
            if (!submittedInput.value) {
                submittedInput.value = new Date().toISOString().split('T')[0];
            }
        } else {
            submittedWrapper.style.display = 'none';
            submittedInput.value = '';
        }
    }

    // Run on load
    toggleSubmittedDate();

    // Run on change
    statusSelect.addEventListener('change', toggleSubmittedDate);
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusSelect = document.getElementById('status');

    // SUBMITTED
    const submittedWrapper = document.getElementById('submitted_date_wrapper');
    const submittedInput = document.getElementById('submitted_at');

    // DECLINE
    const declineWrapper = document.getElementById('decline_reason_wrapper');
    const declineInput = document.getElementById('decline_reason');

    function toggleFields() {

        // === SUBMITTED ===
        if (statusSelect.value === 'submitted') {
            submittedWrapper.style.display = 'block';
            if (!submittedInput.value) {
                submittedInput.value = new Date().toISOString().split('T')[0];
            }
        } else {
            submittedWrapper.style.display = 'none';
            submittedInput.value = '';
        }

        // === DECLINE ===
        if (statusSelect.value === 'decline') {
            declineWrapper.style.display = 'block';
        } else {
            declineWrapper.style.display = 'none';
            declineInput.value = '';
        }
    }

    toggleFields(); // load pertama
    statusSelect.addEventListener('change', toggleFields);
});
</script>


</x-app-layout>
