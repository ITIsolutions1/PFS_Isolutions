<x-app-layout>
    <div class="container py-5">
        <!-- Card Utama -->
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <!-- Header Card -->
            <div class="card-header  text-white py-3"
                 style="background: linear-gradient(135deg, #860808ff 0%, #d65151ff 100%);">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-file-earmark-plus me-2"></i> Add Proposal
                    </h5>
                </div>
            </div>

            <!-- Body Card -->
            <div class="card-body p-4">
                <form action="{{ route('proposals.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Title -->
                        <div class="col-md-6">
                            <label for="title" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-pencil-square me-1 text-primary"></i> Proposal Title
                            </label>
                            <input type="text" name="title" id="title" 
                                   class="form-control shadow-sm @error('title') is-invalid @enderror"
                                   placeholder="Enter proposal title" value="{{ old('title') }}">
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
                            <label for="status" class="form-label fw-semibold text-secondary">
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

                        <!-- Assigned To -->
                        <div class="col-md-6">
                            <label for="assign_to" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-person-circle me-1 text-primary"></i> Assigned To
                            </label>
                            <select name="assign_to" id="assign_to" 
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

                        <!-- Description -->
                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-chat-left-text me-1 text-primary"></i> Description
                            </label>
                            <textarea name="description" id="description" rows="4"
                                      class="form-control shadow-sm"
                                      placeholder="Enter proposal details...">{{ old('description') }}</textarea>
                        </div>

                        <!-- File Upload -->
                        <div class="col-12">
                            <label for="files" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-paperclip me-1 text-primary"></i> Attach Files (optional)
                            </label>
                            <input type="file" name="files[]" id="files" 
                                   class="form-control shadow-sm" multiple>
                            <small class="text-muted">You can upload multiple files (PDF, DOCX, ZIP, etc.)</small>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
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

    <!-- Custom CSS -->
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
    </style>
</x-app-layout>
