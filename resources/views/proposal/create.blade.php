<x-app-layout>
    <div class="container py-5">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

            <!-- Header -->
            <div class="card-header text-white py-3"
                 style="background: linear-gradient(135deg, #860808ff 0%, #d65151ff 100%);">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-file-earmark-plus me-2"></i> Add Proposal
                </h5>
            </div>

            <!-- Body -->
            <div class="card-body p-4">
                <form action="{{ route('proposals.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">

                        <!-- Title -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">
                                <i class="bi bi-pencil-square me-1 text-primary"></i> Proposal Title
                            </label>
                            <input type="text" name="title"
                                   class="form-control shadow-sm @error('title') is-invalid @enderror"
                                   placeholder="Enter proposal title"
                                   value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Lead -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">
                                <i class="bi bi-briefcase me-1 text-primary"></i> Related Lead
                            </label>
                            <select name="lead_id"
                                    class="form-select shadow-sm @error('lead_id') is-invalid @enderror">
                                <option value="">-- Select Lead --</option>
                                @foreach($leads as $lead)
                                    <option value="{{ $lead->id }}" {{ old('lead_id') == $lead->id ? 'selected' : '' }}>
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
                            <label class="form-label fw-semibold text-secondary">
                                <i class="bi bi-flag me-1 text-primary"></i> Status
                            </label>
                            <select name="status" id="status" class="form-select shadow-sm">
                                <option value="rfp">Rfp</option>
                                <option value="draft">Draft</option>
                                <option value="submitted">Submitted</option>
                                <option value="awaiting_po">Awaiting PO</option>
                                <option value="awarded">Awarded</option>
                                <option value="decline">Decline</option>
                                <option value="lost">Lost</option>
                            </select>
                        </div>

                        <!-- Assign To -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">
                                <i class="bi bi-person-circle me-1 text-primary"></i> Assigned To
                            </label>
                            <select name="assign_to"
                                    class="form-select shadow-sm @error('assign_to') is-invalid @enderror">
                                <option value="">-- Select User --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('assign_to') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('assign_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submitted Date -->
                        <div class="col-md-6" id="submitted_date_wrapper" style="display: none;">
                            <label class="form-label fw-semibold text-secondary">
                                <i class="bi bi-calendar-check me-1 text-primary"></i> Submitted Date
                            </label>
                            <input type="date" name="submitted_at" id="submitted_at"
                                   class="form-control shadow-sm"
                                   value="{{ old('submitted_at') }}">
                        </div>

                        <!-- Decline Reason -->
                        <div class="col-md-6" id="decline_reason_wrapper" style="display: none;">
                            <label class="form-label fw-semibold text-secondary">
                                <i class="bi bi-exclamation-triangle me-1 text-danger"></i> Decline Reason
                            </label>
                            <textarea name="decline_reason" id="decline_reason"
                                      class="form-control shadow-sm"
                                      placeholder="Explain why this proposal was declined...">{{ old('decline_reason') }}</textarea>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary">
                                <i class="bi bi-chat-left-text me-1 text-primary"></i> Description
                            </label>
                            <textarea name="description" rows="4"
                                      class="form-control shadow-sm"
                                      placeholder="Enter proposal details...">{{ old('description') }}</textarea>
                        </div>

                        <!-- File Upload -->
                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary">
                                <i class="bi bi-paperclip me-1 text-primary"></i> Attach Files (optional)
                            </label>
                            <input type="file" name="files[]" class="form-control shadow-sm" multiple>
                            <small class="text-muted">You can upload multiple files (PDF, DOCX, JPG, etc.)</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save"></i> Save Proposal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CLEAN SCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const statusSelect = document.getElementById('status');

            const submittedWrapper = document.getElementById('submitted_date_wrapper');
            const submittedInput = document.getElementById('submitted_at');

            const declineWrapper = document.getElementById('decline_reason_wrapper');
            const declineInput = document.getElementById('decline_reason');

            function toggleFields() {

                // SUBMITTED
                if (statusSelect.value === 'submitted') {
                    submittedWrapper.style.display = 'block';
                    if (!submittedInput.value) {
                        submittedInput.value = new Date().toISOString().split('T')[0];
                    }
                } else {
                    submittedWrapper.style.display = 'none';
                    submittedInput.value = '';
                }

                // DECLINE
                if (statusSelect.value === 'decline') {
                    declineWrapper.style.display = 'block';
                } else {
                    declineWrapper.style.display = 'none';
                    declineInput.value = '';
                }
            }

            toggleFields(); // saat load
            statusSelect.addEventListener('change', toggleFields);
        });
    </script>

</x-app-layout>
