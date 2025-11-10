<x-app-layout>
<div class="container py-4">

    {{-- Tombol kembali --}}
    <div class="mt-3">
        <a href="{{ $previousUrl ?? route('leads.index') }}" class="btn btn-outline-danger">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    {{-- Judul --}}
    <h3 class="fw-bold text-danger mb-4 mt-5">
        <i class="bi bi-people-fill me-2"></i> Detail Lead: {{ $lead->crm->name ?? '-' }}
    </h3>

    <div class="card shadow-sm rounded-4">
        <div class="card-body">

            {{-- Tabs --}}
            <ul class="nav nav-tabs mb-3" id="leadTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button">Informasi Contact</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="persona-tab" data-bs-toggle="tab" data-bs-target="#persona" type="button">Informasi Persona</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="followup-tab" data-bs-toggle="tab" data-bs-target="#followup" type="button">Follow Up Tracking</button>
                </li>
            </ul>

            {{-- Tab Content --}}
            <div class="tab-content" id="leadTabContent">

                {{-- CONTACT TAB --}}
                <div class="tab-pane fade show active" id="contact" role="tabpanel">
                    <div class="d-flex justify-content-end mb-3">
                        <button id="editBtn" class="btn btn-warning btn-sm me-2"><i class="bi bi-pencil-square"></i> Edit</button>
                        <button id="saveBtn" class="btn btn-success btn-sm d-none"><i class="bi bi-check2-circle"></i> Save</button>
                        <button id="cancelBtn" class="btn btn-secondary btn-sm d-none"><i class="bi bi-x-circle"></i> Cancel</button>
                    </div>

                    <ul class="list-group list-group-flush">
                        @php
                            $fields = [
                                'name'=>'Name','position'=>'Position','company'=>'Company',
                                'email'=>'Email','phone'=>'Telephone','address'=>'Address','notes'=>'Notes'
                            ];
                        @endphp

                        @foreach ($fields as $field => $label)
                            <li class="list-group-item contact-row">
                                <span class="label">{{ $label }}</span><span class="colon">:</span>
                                <span class="value">
                                    <span class="view-mode">{{ $lead->crm->$field ?? '-' }}</span>
                                    <input type="text" class="form-control form-control-sm edit-mode d-none" data-field="{{ $field }}" value="{{ $lead->crm->$field ?? '' }}">
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- PERSONA TAB --}}
                <div class="tab-pane fade" id="persona" role="tabpanel">
                    @if($lead->persona)
                    <div class="d-flex justify-content-end mb-3">
                        <button id="editBtnPersona" class="btn btn-warning btn-sm me-2"><i class="bi bi-pencil-square"></i> Edit</button>
                        <button id="saveBtnPersona" class="btn btn-success btn-sm d-none"><i class="bi bi-check2-circle"></i> Save</button>
                        <button id="cancelBtnPersona" class="btn btn-secondary btn-sm d-none"><i class="bi bi-x-circle"></i> Cancel</button>
                    </div>

                    <ul class="list-group list-group-flush">
                        @foreach([
                            'date_of_birth'=>'Date of Birth','gender'=>'Gender','education_level'=>'Education',
                            'income_level'=>'Income','key_interest'=>'Key Interest','pain_point'=>'Pain Point','notes'=>'Notes'
                        ] as $field => $label)
                            <li class="list-group-item persona-row">
                                <span class="label">{{ $label }}</span><span class="colon">:</span>
                                <span class="value">
                                    <span class="view-mode">{{ $lead->persona->$field ?? '-' }}</span>
                                    <input type="text" class="form-control form-control-sm edit-mode-persona d-none" data-field="{{ $field }}" value="{{ $lead->persona->$field ?? '' }}">
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    @else
                        <p class="text-muted">Belum ada data persona.</p>
                    @endif
                </div>

                {{-- FOLLOW UP TAB --}}
                <div class="tab-pane fade" id="followup" role="tabpanel">
                    @if($lead->followUps->count())
                    <div class="d-flex justify-content-end mb-3">
                        <button id="editBtnFollow" class="btn btn-warning btn-sm me-2"><i class="bi bi-pencil-square"></i> Edit</button>
                        <button id="saveBtnFollow" class="btn btn-success btn-sm d-none"><i class="bi bi-check2-circle"></i> Save</button>
                        <button id="cancelBtnFollow" class="btn btn-secondary btn-sm d-none"><i class="bi bi-x-circle"></i> Cancel</button>
                    </div>

                    <table class="table table-hover mt-3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Type</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lead->followUps as $index => $fu)
                            <tr data-id="{{ $fu->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td><span class="view-mode">{{ \Carbon\Carbon::parse($fu->date)->format('d M Y') }}</span>
                                    <input type="date" class="form-control form-control-sm edit-mode-follow d-none" data-field="date" value="{{ $fu->date }}">
                                </td>
                                <td><span class="view-mode">{{ ucfirst($fu->type) }}</span>
                                    <input type="text" class="form-control form-control-sm edit-mode-follow d-none" data-field="type" value="{{ $fu->type }}">
                                </td>
                                <td><span class="view-mode">{{ $fu->notes }}</span>
                                    <input type="text" class="form-control form-control-sm edit-mode-follow d-none" data-field="notes" value="{{ $fu->notes }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <p class="text-muted">Belum ada follow up.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- STYLES --}}
<style>
    .nav-tabs .nav-link.active {
        color: #fff; background-color: #dc3545; border-color: #dc3545 #dc3545 #fff;
    }
    .contact-row, .persona-row {
        display: grid; grid-template-columns: 150px 10px 1fr; align-items: center;
    }
    .label { font-weight: 600; } .colon { text-align: center; }
</style>

{{-- SCRIPTS --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    // === CONTACT ===
    setupEditableSection('#contact', '/admin/crm/{{ $lead->crm->id }}/update-multiple', '.edit-mode');

    // === PERSONA ===
    @if($lead->persona)
    setupEditableSection('#persona', '/personas/{{ $lead->persona->id }}/update-multiple', '.edit-mode-persona');
    @endif

    // === FOLLOW UP ===
    setupEditableSection('#followup', '/followups/update-multiple', '.edit-mode-follow', true);
});

function setupEditableSection(tabSelector, url, inputSelector, isTable = false) {
    const tab = document.querySelector(tabSelector);
    if (!tab) return;

    const editBtn = tab.querySelector('[id^=editBtn]');
    const saveBtn = tab.querySelector('[id^=saveBtn]');
    const cancelBtn = tab.querySelector('[id^=cancelBtn]');
    const viewModes = tab.querySelectorAll('.view-mode');
    const editModes = tab.querySelectorAll(inputSelector);
    let original = {};

    if (!editBtn) return;

    editBtn.addEventListener('click', () => {
        editModes.forEach(i => { original[i.dataset.field + (isTable ? i.closest('tr').dataset.id : '')] = i.value; i.classList.remove('d-none'); });
        viewModes.forEach(v => v.classList.add('d-none'));
        toggleButtons(editBtn, saveBtn, cancelBtn);
    });

    cancelBtn.addEventListener('click', () => {
        editModes.forEach(i => { i.value = original[i.dataset.field + (isTable ? i.closest('tr').dataset.id : '')]; i.classList.add('d-none'); });
        viewModes.forEach(v => v.classList.remove('d-none'));
        toggleButtons(saveBtn, cancelBtn, editBtn);
    });

    saveBtn.addEventListener('click', async () => {
        const updates = [];
        if (isTable) {
            tab.querySelectorAll('tbody tr').forEach(tr => {
                const id = tr.dataset.id;
                const data = {};
                tr.querySelectorAll(inputSelector).forEach(i => data[i.dataset.field] = i.value);
                updates.push({ id, ...data });
            });
        } else {
            const single = {};
            editModes.forEach(i => single[i.dataset.field] = i.value);
            updates.push(single);
        }

        try {
            const res = await fetch(url, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ updates })
            });
            const data = await res.json();
            if (!res.ok || !data.success) throw new Error();
            alert('Data berhasil disimpan!');
            location.reload();
        } catch (e) {
            alert('Gagal menyimpan data!');
        }
    });
}

function toggleButtons(...buttons) {
    document.querySelectorAll('button').forEach(b => b.classList.add('d-none'));
    buttons.forEach(b => b.classList.remove('d-none'));
}
</script>

</x-app-layout>
