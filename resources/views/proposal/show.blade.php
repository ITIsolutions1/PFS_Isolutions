<x-app-layout>
    <style>
        body {
            background-color: #fdf6f6;
        }

        .proposal-container {
            max-width: 1200px;
            margin: 40px auto;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(136, 0, 0, 0.15);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #880000, #b33333);
            color: #fff;
            font-size: 1.4rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .card-body {
            background-color: #fff;
            padding: 2rem;
        }

        .card-body p {
            font-size: 1rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .card-body strong {
            color: #880000;
        }

        .attached-files .file-box {
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            background-color: #fafafa;
            transition: all 0.2s ease;
        }

        .attached-files .file-box:hover {
            background-color: #fff;
            box-shadow: 0 3px 10px rgba(136, 0, 0, 0.1);
        }

        .file-icon {
            font-size: 2rem;
            color: #b33333;
            margin-right: 15px;
        }

        .file-info {
            flex-grow: 1;
        }

        .file-info .file-name {
            font-weight: 600;
            color: #880000;
            text-decoration: none;
        }

        .file-info .file-name:hover {
            text-decoration: underline;
        }

        .file-meta {
            font-size: 0.9rem;
            color: #777;
        }

        .missing {
            color: #b30000;
            font-weight: 600;
        }

        .btn-secondary {
            background-color: #880000;
            border: none;
            color: #fff;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #b30000;
        }

        .section-title {
            color: #880000;
            border-bottom: 3px solid #b33333;
            display: inline-block;
            padding-bottom: 4px;
            margin-bottom: 20px;
        }
    </style>

  

    <div class="proposal-container">

          <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('proposals.index') }}" class="btn btn-secondary mt-3">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back to List
                </a>
        </div>

        <h1 class="section-title mb-4">
            <i class="bi bi-file-earmark-text-fill me-2"></i> Proposal Details
        </h1>

        <div class="card mb-6">
            <div class="card-header">
                {{ $proposal->title }}
            </div>
            <div class="card-body">
                <p><strong>Status :</strong>  {{ $proposal->status ?? '-' }}</p>
             @if ($proposal->status === 'decline')
                <p><strong>Decline Reason:</strong> <br>
                 {{ $proposal->decline_reason }}</p>
            @endif

                <p><strong>PIC  :</strong>  <br>{{ optional($proposal->assignedUser)->name ?? '-' }}</p>
                <p>
                    <strong>Lead Info: <br></strong>
                    {{ optional($proposal->lead?->crm)->name ?? '-' }}
                    <small class="text-danger">{{ optional($proposal->lead?->crm)->company ?? '-' }}</small>
                </p>
                <p><strong>Description:</strong><br>{!! nl2br(e($proposal->description)) !!}</p>

                <div class="attached-files mt-4">
                    <h5 class="mb-3"><i class="bi bi-paperclip me-1"></i><strong>Attached Files</strong> </h5>

                    @if($proposal->files && $proposal->files->count() > 0)
                        @foreach($proposal->files as $file)
                            @php
                                $disk = 'public';
                                $exists = \Illuminate\Support\Facades\Storage::disk($disk)->exists($file->file_path);

                                try {
                                    $size = $exists 
                                        ? number_format(\Illuminate\Support\Facades\Storage::disk($disk)->size($file->file_path) / 1024, 1) . ' KB' 
                                        : 'Unknown';
                                    $lastModified = $exists 
                                        ? date('d M Y, H:i', \Illuminate\Support\Facades\Storage::disk($disk)->lastModified($file->file_path)) 
                                        : '-';
                                } catch (Exception $e) {
                                    $size = 'Unknown';
                                    $lastModified = '-';
                                }

                                $extension = pathinfo($file->file_name, PATHINFO_EXTENSION);
                                $icon = match($extension) {
                                    'pdf' => 'bi bi-filetype-pdf',
                                    'doc', 'docx' => 'bi bi-filetype-docx',
                                    'xls', 'xlsx' => 'bi bi-filetype-xlsx',
                                    'zip', 'rar' => 'bi bi-file-zip',
                                    'png', 'jpg', 'jpeg' => 'bi bi-file-earmark-image',
                                    default => 'bi bi-file-earmark'
                                };
                            @endphp

                            <div class="file-box">
                                <i class="{{ $icon }} file-icon"></i>
                                <div class="file-info">
                                    @if($exists)
                                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="file-name">
                                            {{ $file->file_name }}
                                        </a>
                                        <div class="file-meta">
                                            Size: {{ $size }} &nbsp; | &nbsp; Last Modified: {{ $lastModified }}
                                        </div>
                                    @else
                                        <div class="file-name missing">
                                            {{ $file->file_name }} (File Missing)
                                        </div>
                                        <div class="file-meta">
                                            Size: {{ $size }} &nbsp; | &nbsp; Last Modified: {{ $lastModified }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">No files attached.</p>
                    @endif
                </div>
            </div>
        </div>

        <div>
          {{-- 🚨 PERINGATAN JIKA SUBMITTED TAPI BELUM ADA FOLLOW-UP --}}
    @if($proposal->status == 'submitted' && $proposal->followups->count() == 0)
        <div class="alert alert-warning">
            This submitted proposal has no follow-up yet.
        </div>
    @endif

   
{{-- LIST FOLLOW-UP --}}
<style>
    .timeline-wrapper {
        position: relative;
        margin-left: 30px;
        padding-left: 20px;
    }

    .timeline-line {
        position: absolute;
        left: 5px;
        top: 0;
        width: 3px;
        height: 100%;
        background-color: #d10024;
        border-radius: 6px;
    }

    .timeline-item {
        position: relative;
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 0 8px rgba(0,0,0,0.08);
        border-left: 4px solid #d10024;
        transition: 0.2s ease;
    }

    .timeline-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 18px rgba(0,0,0,0.12);
    }

    .timeline-point {
        width: 16px;
        height: 16px;
        background-color: #fff;
        border: 3px solid #d10024;
        border-radius: 50%;
        position: absolute;
        left: -32px;
        top: 22px;
    }

    .followup-type {
        background-color: #ececec;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        color: #333;
        font-weight: 600;
    }

    .reminder-tag {
        background: #ffd5d8;
        border: 1px solid #d10024;
        padding: 6px 12px;
        border-radius: 20px;
        color: #d10024;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.85rem;
        margin-top: 5px;
    }
</style>

<div class="d-flex justify-content-between mb-3">
    <h4 class="fw-bold">Follow-Up Timeline</h4>

    <a href="{{ route('proposals.followups.create', $proposal->id) }}"
        class="btn btn-danger">
        + Add Follow-Up
    </a>
</div>

<div class="timeline-wrapper">
    <div class="timeline-line"></div>

    @forelse ($followups as $item)
        <div class="timeline-item">
            <div class="timeline-point"></div>

            <div class="d-flex justify-content-between">
                <div>
                    <div class="fw-bold text-danger fs-5">
                        📅 {{ \Carbon\Carbon::parse($item->followup_date)->format('d M Y') }}
                    </div>

                    <span class="followup-type">{{ ucfirst($item->type) }}</span>

                    {{-- Reminder --}}
                    @if($item->reminder_at)
                        <div class="reminder-tag mt-2">
                            🔔 Reminder: {{ \Carbon\Carbon::parse($item->reminder_at)->format('d M Y, H:i') }}
                        </div>
                    @endif

                    <div class="text-muted mt-2" style="font-size: 0.85rem;">
                        ⏳ {{ $item->created_at->diffForHumans() }}
                    </div>

                    <p class="mt-2 mb-0">{{ $item->notes }}</p>
                </div>

                <div class="d-flex flex-column gap-2">
                    <a class="edit-btn" 
                        href="{{ route('proposals.followups.edit', [$proposal->id, $item->id]) }}">
                            ✏️
                    </a>


                    <form method="POST" 
                    action="{{ route('proposals.followups.delete', ['proposal' => $proposal->id, 'followup' => $item->id]) }}">
                    @csrf
                    @method('DELETE')

                    <button class="delete-btn" onclick="return confirm('Delete follow-up?')">
                        🗑
                    </button>
                </form>

                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">No follow-ups yet.</p>
    @endforelse
</div>

{{-- PAGINATION --}}
<div class="mt-3">
    {{ $followups->links('pagination::bootstrap-5') }}
</div>



       
    </div>
</x-app-layout>
