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
                                'email'=>'Email','phone'=>'Telephone','address'=>'Address','website'=>'Website','notes'=>'Notes'
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

    {{-- === JIKA PERSONA ADA === --}}
    @if($lead->persona)

        <div class="d-flex justify-content-end mb-3">
            <button id="editBtnPersona" class="btn btn-warning btn-sm me-2">
                <i class="bi bi-pencil-square"></i> Edit
            </button>
            <button id="saveBtnPersona" class="btn btn-success btn-sm d-none">
                <i class="bi bi-check2-circle"></i> Save
            </button>
            <button id="cancelBtnPersona" class="btn btn-secondary btn-sm d-none">
                <i class="bi bi-x-circle"></i> Cancel
            </button>
        </div>

        @include('leads.persona.persona_list', ['persona' => $lead->persona])

    {{-- === JIKA PERSONA KOSONG === --}}
    @else

        <div class="d-flex justify-content-end mb-3">
            <button id="addBtnPersona" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Add Persona
            </button>

            <button id="saveBtnPersona" class="btn btn-success btn-sm d-none">
                <i class="bi bi-check2-circle"></i> Save
            </button>
            <button id="cancelBtnPersona" class="btn btn-secondary btn-sm d-none">
                <i class="bi bi-x-circle"></i> Cancel
            </button>
        </div>

        {{-- TEMPLATE PERSONA KOSONG (VIEW MODE) --}}
        <ul class="list-group list-group-flush" id="personaEmptyView">
            @foreach(['Date of Birth','Gender','Education','Income','Key Interest','Pain Point','Notes'] as $item)
                <li class="list-group-item persona-row">
                    <span class="label">{{ $item }}</span><span class="colon">:</span>
                    <span class="value"><span>-</span></span>
                </li>
            @endforeach
        </ul>

        {{-- TEMPLATE PERSONA EDIT MODE (DISABLED DULU) --}}
        <ul class="list-group list-group-flush d-none" id="personaEmptyEdit">

            <li class="list-group-item persona-row">
                <span class="label">Date of Birth</span><span class="colon">:</span>
                <input type="date" class="form-control form-control-sm" data-field="date_of_birth">
            </li>

            <li class="list-group-item persona-row">
                <span class="label">Gender</span><span class="colon">:</span>
                <select class="form-select form-select-sm" data-field="gender">
                    <option value="">-- pilih gender --</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </li>

            <li class="list-group-item persona-row">
                <span class="label">Education</span><span class="colon">:</span>
                <select class="form-select form-select-sm" data-field="education_level">
                    <option value="">-- pilih pendidikan --</option>
                    <option value="High School">High School</option>
                    <option value="Bachelor">Bachelor</option>
                    <option value="Master">Master</option>
                    <option value="Doctorate">Doctorate</option>
                </select>
            </li>

            <li class="list-group-item persona-row">
                <span class="label">Income</span><span class="colon">:</span>
                <select class="form-select form-select-sm" data-field="income_level">
                    <option value="">-- pilih income --</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                    <option value="Very High">Very High</option>
                </select>
            </li>

            <li class="list-group-item persona-row">
                <span class="label">Key Interest</span><span class="colon">:</span>
                <textarea class="form-control form-control-sm" data-field="key_interest"></textarea>
            </li>

            <li class="list-group-item persona-row">
                <span class="label">Pain Point</span><span class="colon">:</span>
                <textarea class="form-control form-control-sm" data-field="pain_point"></textarea>
            </li>

            <li class="list-group-item persona-row">
                <span class="label">Notes</span><span class="colon">:</span>
                <textarea class="form-control form-control-sm" data-field="notes"></textarea>
            </li>

        </ul>

    @endif
</div>


                {{-- FOLLOW UP TAB --}}
             <div class="tab-pane fade" id="followup" role="tabpanel">

    <div class="d-flex justify-content-end mb-3">
        {{-- Add SELALU ADA --}}
        <button id="addFollowUpBtn" class="btn btn-primary btn-sm me-2">
            <i class="bi bi-plus-circle"></i> Add Follow Up
        </button>

        {{-- Edit/Save/Cancel MUNCUL KALAU ADA DATA --}}
        @if($lead->followUps->count())
            <button id="editBtnFollow" class="btn btn-warning btn-sm me-2"><i class="bi bi-pencil-square"></i> Edit</button>
            <button id="saveBtnFollow" class="btn btn-success btn-sm d-none"><i class="bi bi-check2-circle"></i> Save</button>
            <button id="cancelBtnFollow" class="btn btn-secondary btn-sm d-none"><i class="bi bi-x-circle"></i> Cancel</button>
        @endif
    </div>


    @if($lead->followUps->count())
        {{-- TABEL FOLLOW UP --}}
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

                        <td>
                            <span class="view-mode">
                                @if($fu->type === 'appointment')
                                    {{ \Carbon\Carbon::parse($fu->date)->format('d M Y H:i') }}
                                @else
                                    {{ \Carbon\Carbon::parse($fu->date)->format('d M Y') }}
                                @endif
                            </span>

                            @if($fu->type === 'appointment')
                                <input type="datetime-local" class="form-control form-control-sm edit-mode-follow d-none"
                                    data-field="date"
                                    value="{{ \Carbon\Carbon::parse($fu->date)->format('Y-m-d\TH:i') }}">
                            @else
                                <input type="date"
                                    class="form-control form-control-sm edit-mode-follow d-none"
                                    data-field="date"
                                    value="{{ \Carbon\Carbon::parse($fu->date)->format('Y-m-d') }}">
                            @endif
                        </td>

                        <td>
                            <span class="view-mode">{{ ucfirst($fu->type) }}</span>

                            <select class="form-control form-control-sm edit-mode-follow d-none" data-field="type">
                                @foreach(['call','email','meeting','chat','appointment'] as $type)
                                    <option value="{{ $type }}" {{ $fu->type == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            <span class="view-mode">{{ $fu->notes }}</span>
                            <input type="text"
                                class="form-control form-control-sm edit-mode-follow d-none"
                                data-field="notes"
                                value="{{ $fu->notes }}">
                        </td>

                    </tr>
                @endforeach
            </tbody>

        </table>

    @else
        {{-- KOSONG --}}
        <p class="text-muted">Belum ada follow up.</p>
    @endif

</div>


                <div class="modal fade" id="addFollowUpModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Follow Up</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="addFollowUpForm">

                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-control" name="type" required>
                            <option value="call">Call</option>
                            <option value="email">Email</option>
                            <option value="chat">Chat</option>
                            <option value="meeting">Meeting</option>
                            <option value="appointment">Appointment</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="datetime-local" class="form-control" name="date" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes"></textarea>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button id="saveFollowUpCreate" class="btn btn-primary">Save</button>
            </div>

        </div>
    </div>
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

    // CONTACT → CRM
    setupEditableSection(
        '#contact',
        '/admin/crm/{{ $lead->crm->id }}/update-multiple',
        '.edit-mode',
        false
    );

    // PERSONA
@if($lead->persona)
setupEditableSection(
    '#persona',
    `/personas/{{ $lead->persona->id }}/update-multiple`,
    '.edit-mode-persona',
    false
);
@endif

    // FOLLOWUP → multi row
   setupEditableSection(
    '#followup',
    '/followups/{{ $lead->id }}/bulk-update',
    '.edit-mode-follow',
    true
);

});

function setupEditableSection(tabSelector, url, inputSelector, isTable = false) {

    const tab = document.querySelector(tabSelector);
    if (!tab) return;

    const editBtn   = tab.querySelector('[id^=editBtn]');
    const saveBtn   = tab.querySelector('[id^=saveBtn]');
    const cancelBtn = tab.querySelector('[id^=cancelBtn]');

    const viewModes = tab.querySelectorAll('.view-mode');
    const editModes = tab.querySelectorAll(inputSelector);

    let original = {};

    if (!editBtn) return;

    // EDIT MODE
    editBtn.addEventListener('click', () => {

        editModes.forEach(i => {
            const key = i.dataset.field + (isTable ? i.closest('tr').dataset.id : '');
            original[key] = i.value;
            i.classList.remove('d-none');
        });

        viewModes.forEach(v => v.classList.add('d-none'));

        editBtn.classList.add('d-none');
        saveBtn.classList.remove('d-none');
        cancelBtn.classList.remove('d-none');
    });

    // CANCEL MODE
    cancelBtn.addEventListener('click', () => {

        editModes.forEach(i => {
            const key = i.dataset.field + (isTable ? i.closest('tr').dataset.id : '');
            i.value = original[key];
            i.classList.add('d-none');
        });

        viewModes.forEach(v => v.classList.remove('d-none'));

        saveBtn.classList.add('d-none');
        cancelBtn.classList.add('d-none');
        editBtn.classList.remove('d-none');
    });

    // SAVE CHANGES
    saveBtn.addEventListener('click', async () => {

        let payload;

        if (isTable) {
            // FOLLOWUP → array
            const updates = [];

            tab.querySelectorAll('tbody tr').forEach(tr => {
                const id = tr.dataset.id;
                const row = { id };

                tr.querySelectorAll(inputSelector).forEach(i => {
                    row[i.dataset.field] = i.value;
                });

                updates.push(row);
            });

            payload = { updates };

        } else {
            // CRM & PERSONA → single object
            payload = {};

            editModes.forEach(i => {
                payload[i.dataset.field] = i.value;
            });
        }

        try {
            const res = await fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            });

            const json = await res.json();

            if (!res.ok || !json.success) throw new Error();

            alert("Data berhasil disimpan!");
            location.reload();

        } catch (error) {
            alert("Gagal menyimpan data!");
        }
    });

}



</script>


<SCript>
    document.addEventListener("DOMContentLoaded", () => {

    // === ADD PERSONA MODE ===
    document.getElementById("addBtnPersona")?.addEventListener("click", () => {
        document.getElementById("personaEmptyView").classList.add("d-none");
        document.getElementById("personaEmptyEdit").classList.remove("d-none");

        document.getElementById("addBtnPersona").classList.add("d-none");
        document.getElementById("saveBtnPersona").classList.remove("d-none");
        document.getElementById("cancelBtnPersona").classList.remove("d-none");
    });

    // === CANCEL (balik seperti semula) ===
    document.getElementById("cancelBtnPersona")?.addEventListener("click", () => {
        document.getElementById("personaEmptyView").classList.remove("d-none");
        document.getElementById("personaEmptyEdit").classList.add("d-none");

        document.getElementById("addBtnPersona").classList.remove("d-none");
        document.getElementById("saveBtnPersona").classList.add("d-none");
        document.getElementById("cancelBtnPersona").classList.add("d-none");
    });

    // === SAVE PERSONA ===
    document.getElementById("saveBtnPersona")?.addEventListener("click", async () => {

        const fields = document.querySelectorAll("#personaEmptyEdit [data-field]");

        let payload = {};
        fields.forEach(el => {
            payload[el.dataset.field] = el.value;
        });

        let leadId = "{{ $lead->id }}";

        const response = await fetch(`/leads/${leadId}/persona`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(payload)
        });

        const result = await response.json();

        if (!response.ok) {
            alert("Gagal menyimpan persona!");
            console.error(result);
            return;
        }

        // sukses → reload
        location.reload();

    });

});



</SCript>

<script>
    // buka modal
document.getElementById("addFollowUpBtn").addEventListener("click", function () {
    let modal = new bootstrap.Modal(document.getElementById("addFollowUpModal"));
    modal.show();
});

// ubah date input kalau type = appointment
document.querySelector("[name='type']").addEventListener("change", function() {
    let dateInput = document.querySelector("[name='date']");

    if (this.value === "appointment") {
        dateInput.type = "datetime-local";
    } else {
        dateInput.type = "date";
    }
});

</script>

<script>
    document.getElementById("saveFollowUpCreate").addEventListener("click", function () {

    const form = document.getElementById("addFollowUpForm");
    const data = new FormData(form);

    fetch(`/leads/{{ $lead->id }}/followups`, {
        method: "POST",
        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        body: data
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            location.reload(); // refresh agar row baru tampil
        } else {
            alert("Gagal menambah follow up");
        }
    })
    .catch(err => console.error(err));
});

</script>

</x-app-layout>
