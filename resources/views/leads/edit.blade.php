<x-app-layout>
<main class="app-main">
    <div class="app-content mt-10">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="card border-0 shadow-lg rounded-4">
                        <div class="card-header text-white rounded-top-4"
                             style="background: linear-gradient(90deg, #880000 0%, #5a0000 100%);">
                            <h5 class="mb-0 fw-semibold">
                                <i class="bi bi-file-earmark-text me-2"></i> Update Lead Record
                            </h5>
                        </div>

                        <div class="card-body bg-light-subtle p-4">
                            {{-- 🔸 Validation Errors --}}
                            @if ($errors->any())
                                <div class="alert alert-danger border-0 shadow-sm">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- 🧾 Update Form --}}
                            <form action="{{ route('leads.update', $lead->id) }}" method="POST" novalidate>
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="redirect_to" value="{{ $previousUrl }}">
                                <div class="row g-4">
                                    {{-- CRM --}}
                                    <div class="col-md-6">
                                        <label for="crm_id" class="form-label fw-semibold text-secondary">
                                            <i class="bi bi-building me-1"></i> CRM <span class="text-danger">*</span>
                                        </label>
                                        <select id="crm_id" class="form-select form-select-lg shadow-sm" disabled>
                                            @foreach ($crms as $crm)
                                                <option value="{{ $crm->id }}" {{ old('crm_id', $lead->crm_id) == $crm->id ? 'selected' : '' }}>
                                                    {{ $crm->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="crm_id" value="{{ $lead->crm_id }}">
                                    </div>

                                    {{-- Category --}}
                                    <div class="col-md-6">
                                        <label for="category_id" class="form-label fw-semibold text-secondary">
                                            <i class="bi bi-tags me-1"></i> Category
                                        </label>
                                        <select id="category_id" name="category_id" class="form-select form-select-lg shadow-sm">
                                            <option value="">-- Select Category CRM --</option>

                                            @foreach ($categories->where('name', '!=', 'Others') as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $lead->crm->category_id ?? null) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach

                                            {{-- Tambahkan kategori "Others" di bawah --}}
                                            @php $others = $categories->firstWhere('name', 'Others'); @endphp
                                            @if ($others)
                                                <option value="{{ $others->id }}"
                                                    {{ old('category_id', $lead->crm->category_id ?? null) == $others->id ? 'selected' : '' }}>
                                                    {{ $others->name }}
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                {{-- 🔘 Buttons --}}
                                <div class="d-flex justify-content-end gap-3 mt-4">
                                    {{-- Tombol Cancel --}}
                                    <a href="{{ $previousUrl ?? route('leads.index') }}" 
                                    class="btn btn-outline-secondary px-4">
                                        <i class="bi bi-x-circle"></i> Cancel
                                    </a>


                                    {{-- Tombol Submit --}}
                                    <button type="submit" class="btn btn-danger px-4">
                                        <i class="bi bi-save"></i> Update Lead
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- /Card --}}
                </div>
            </div>
        </div>
    </div>
</main>
</x-app-layout>
