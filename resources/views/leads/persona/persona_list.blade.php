<ul class="list-group list-group-flush">

    <li class="list-group-item persona-row">
        <span class="label">Date of Birth</span><span class="colon">:</span>
        <span class="view-mode">{{ $persona->date_of_birth ?? '-' }}</span>
        <input type="date" class="form-control form-control-sm edit-mode-persona d-none"
               data-field="date_of_birth" value="{{ $persona->date_of_birth }}">
    </li>

    <li class="list-group-item persona-row">
        <span class="label">Gender</span><span class="colon">:</span>
        <span class="view-mode">{{ $persona->gender ?? '-' }}</span>
        <select class="form-select form-select-sm edit-mode-persona d-none"
                data-field="gender">
            <option value="">-- pilih gender --</option>
            <option value="Male"   {{ $persona->gender=='Male' ? 'selected':'' }}>Male</option>
            <option value="Female" {{ $persona->gender=='Female' ? 'selected':'' }}>Female</option>
        </select>
    </li>

    <li class="list-group-item persona-row">
        <span class="label">Education</span><span class="colon">:</span>
        <span class="view-mode">{{ $persona->education_level ?? '-' }}</span>
        <select class="form-select form-select-sm edit-mode-persona d-none"
                data-field="education_level">
            <option value="">-- pilih pendidikan --</option>
            <option value="High School" {{ $persona->education_level=='High School' ? 'selected':'' }}>High School</option>
            <option value="Bachelor"    {{ $persona->education_level=='Bachelor' ? 'selected':'' }}>Bachelor</option>
            <option value="Master"      {{ $persona->education_level=='Master' ? 'selected':'' }}>Master</option>
            <option value="Doctorate"   {{ $persona->education_level=='Doctorate' ? 'selected':'' }}>Doctorate</option>
        </select>
    </li>

    <li class="list-group-item persona-row">
        <span class="label">Income</span><span class="colon">:</span>
        <span class="view-mode">{{ $persona->income_level ?? '-' }}</span>
        <select class="form-select form-select-sm edit-mode-persona d-none"
                data-field="income_level">
            <option value="">-- pilih income --</option>
            <option value="Low"       {{ $persona->income_level=='Low' ? 'selected':'' }}>Low</option>
            <option value="Medium"    {{ $persona->income_level=='Medium' ? 'selected':'' }}>Medium</option>
            <option value="High"      {{ $persona->income_level=='High' ? 'selected':'' }}>High</option>
            <option value="Very High" {{ $persona->income_level=='Very High' ? 'selected':'' }}>Very High</option>
        </select>
    </li>

    <li class="list-group-item persona-row">
        <span class="label">Key Interest</span><span class="colon">:</span>
        <span class="view-mode">{{ $persona->key_interest ?? '-' }}</span>
        <textarea class="form-control form-control-sm edit-mode-persona d-none"
                  data-field="key_interest">{{ $persona->key_interest }}</textarea>
    </li>

    <li class="list-group-item persona-row">
        <span class="label">Pain Point</span><span class="colon">:</span>
        <span class="view-mode">{{ $persona->pain_point ?? '-' }}</span>
        <textarea class="form-control form-control-sm edit-mode-persona d-none"
                  data-field="pain_point">{{ $persona->pain_point }}</textarea>
    </li>

    <li class="list-group-item persona-row">
        <span class="label">Notes</span><span class="colon">:</span>
        <span class="view-mode">{{ $persona->notes ?? '-' }}</span>
        <textarea class="form-control form-control-sm edit-mode-persona d-none"
                  data-field="notes">{{ $persona->notes }}</textarea>
    </li>

</ul>
