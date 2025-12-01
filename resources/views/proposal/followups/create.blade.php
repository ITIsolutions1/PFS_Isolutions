<x-app-layout>

<div class="container py-4">

    {{-- Back Button --}}
    <a href="{{ route('proposals.show', $proposal->id) }}" class="btn btn-outline-danger mb-3">
        <i class="bi bi-arrow-left"></i> Back to Proposal
    </a>

    <h3 class="fw-bold mb-4 text-danger">
        Add Follow-Up for: {{ $proposal->title }}
    </h3>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Error Message --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>There were some errors:</strong>
            <ul class="mt-2 mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="card shadow-sm " style="border-width: 2px;">
        <div class="card-body">

            <form action="{{ route('proposals.followups.store', $proposal->id) }}" method="POST">
                @csrf

                {{-- Follow-up Date --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold text-danger">Follow-Up Date</label>
                    <input type="date" name="followup_date" class="form-control border-danger" required>
                </div>

                {{-- Follow-up Type --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold text-danger">Follow-Up Type</label>
                    <select name="type" class="form-select border-danger" required>
                        <option value="">-- Select Type --</option>
                        <option value="call">📞 Call</option>
                        <option value="chat">💬 Chat</option>
                        <option value="meeting">👥 Meeting</option>
                        <option value="email">📧 Email</option>
                        <option value="visit">🏢 Visit</option>
                        <option value="other">📝 Other</option>
                    </select>
                </div>

                {{-- Notes --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold text-danger">Notes</label>
                    <textarea name="notes" rows="4" class="form-control border-danger" placeholder="Add notes (optional)"></textarea>
                </div>

                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-plus-circle"></i> Add Follow-Up
                </button>
            </form>

        </div>
    </div>

</div>

</x-app-layout>
