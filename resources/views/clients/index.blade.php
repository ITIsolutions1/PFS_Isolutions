<x-app-layout>
  <!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* Theme Blue + Interaktif */
:root {
  --danger-color: #880000; /* Blue-600 */
  --light-bg: #f0f4f8;
  --light-border: #d9e2ec;
  --hover-bg: #ebf8ff;
  --text-dark: #2d3748;
}

.search-bar-container {
  padding: 0 20px;
  margin-top: 20px;
  margin-bottom: 10px;
}

.search-bar {
  max-width: 400px;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.search-bar .input-group-text {
  background-color: var(--light-bg);
  border: none;
  color: var(--danger-color);
}

.search-bar .form-control {
  background-color: white;
  border: 1px solid var(--light-border);
  color: var(--text-dark);
  font-weight: 500;
  font-size: 0.95rem;
}

.search-bar .form-control:focus {
  box-shadow: 0 0 0 0.15rem rgba(43, 108, 176, 0.25);
  border-color: var(--danger-color);
}

.form-select {
  border-color: var(--light-border);
}

.form-select:focus {
  box-shadow: 0 0 0 0.15rem rgba(43, 108, 176, 0.25);
  border-color: var(--danger-color);
}

.table thead {
  background-color: var(--danger-color);
  color: white;
}

.table tbody tr:hover {
  background-color: var(--hover-bg);
  transition: background-color 0.2s ease-in-out;
}

.badge.bg-danger {
  background-color: var(--danger-color) !important;
}

.btn-danger-subtle {
  background-color: var(--hover-bg);
  color: var(--danger-color);
  border: 1px solid var(--danger-color);
}

.btn-danger-subtle:hover {
  background-color: var(--danger-color);
  color: white;
}

.btn-warning {
  background-color: #f6ad55;
  border: none;
}

.btn-danger {
  background-color: #e53e3e;
  border: none;
}

.alert-success, .alert-info {
  border-radius: 5px;
  padding: 10px 15px;
}

.card-title {
  font-weight: bold;
  color: var(--danger-color);
}

/* Pagination styling (Bootstrap override) */
.pagination .page-link {
  color: var(--danger-color);
}

.pagination .page-link:hover {
  background-color: var(--hover-bg);
}

.modal-content.bg-dark {
  background-color: #1a202c;
  color: white;
}

.modal-content.bg-dark .btn-light {
  background-color: white;
  color: var(--text-dark);
}

.table-danger th {
  color: #000 !important;
  width: auto !important;
}
</style>


<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">
          
        </h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <!-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">CRM List</li> -->
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">

    <!-- {{-- 🔍 Search & Filter --}}
    <div class="search-bar-container d-flex gap-2">
      <div class="input-group search-bar">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input type="text" id="crm-search" class="form-control" placeholder="Search CRM...">
      </div>

      <select id="category-filter" class="form-select" style="max-width: 200px;">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
          <option value="{{ strtolower($cat->name) }}">{{ $cat->name }}</option>
        @endforeach
      </select>
    </div> -->

    {{-- 🔍 Search & Filter --}}
<div class="search-bar-container d-flex gap-2 align-items-center">

  <div class="input-group search-bar">
    <span class="input-group-text"><i class="bi bi-search"></i></span>
    <input type="text" id="crm-search" class="form-control" placeholder="Search CRM...">
  </div>

  <select id="category-filter" class="form-select" style="max-width: 200px;">
    <option value="">All Categories</option>
    @foreach($categories as $cat)
      <option value="{{ strtolower($cat->name) }}">{{ $cat->name }}</option>
    @endforeach
  </select>

  {{-- ✅ BUTTON EXPORT --}}
  <button class="btn btn-success"
          data-bs-toggle="modal"
          data-bs-target="#exportCrmModal">
      <i class="bi bi-file-earmark-excel"></i> Export
  </button>

  {{-- ✅ BUTTON IMPORT --}}

<form action="{{ route('crm.import') }}"
      method="POST"
      enctype="multipart/form-data"
      class="d-flex align-items-center gap-2">

    @csrf

    <input type="file"
           name="file"
           id="importFile"
           class="d-none"
           accept=".csv,.xlsx"
           required>

    <div class="input-group" style="max-width: 300px;">
        <input type="text"
               id="fileName"
               class="form-control form-control-sm"
               placeholder="No file chosen"
               readonly>

        <button type="button"
                class="btn btn-outline-secondary btn-sm"
                onclick="document.getElementById('importFile').click()">
            <i class="bi bi-folder2-open"></i>
        </button>
    </div>

<button type="submit"
        class="btn btn-sm btn-primary d-flex align-items-center gap-1"
        disabled
        id="importBtn"
          style="height: 38px;">
        
    <i class="bi bi-upload"></i>
    <span>Import</span>
</button>

</form>






</div>


    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center w-100">
            <div class="card-title mb-0 text-2xl font-semibold flex items-center gap-2">
                CRM List  
                <span class="badge bg-danger text-lg px-3 py-1 rounded">
                    {{ $crmCount }}
                </span>
            </div>

              <div class="ms-auto">
                <a href="{{ route('crm.create') }}" class="btn btn-danger-subtle btn-sm">
                  <i class="bi bi-plus-lg"></i> Add New CRM
                </a>
              </div>
            </div>

            <div class="card-body">
              @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
              @endif

              @if($clients->count())
                <div class="table-responsive">
                  <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-danger">
                     <tr>
    <th style="width: 50px;">No</th>

    <th style="width: 150px;">
        <span>Date Created</span>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at_asc']) }}" 
           style="text-decoration: none; color: grey; font-size: 11px;">&#9650;</a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at_desc']) }}" 
           style="text-decoration: none; color: grey; font-size: 11px;">&#9660;</a>
    </th>

    <th style="width: 150px;">
        <span>Name</span>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}" 
           style="text-decoration: none; color: grey; font-size: 11px;">&#9650;</a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'name_desc']) }}" 
           style="text-decoration: none; color: grey; font-size: 11px;">&#9660;</a>
    </th>

    <th style="width: 200px;">
        <span>Email</span>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'email_asc']) }}" 
           style="text-decoration: none; color: grey; font-size: 11px;">&#9650;</a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'email_desc']) }}" 
           style="text-decoration: none; color: grey; font-size: 11px;">&#9660;</a>
    </th>

    <th style="width: 120px;">
        <span>Phone</span>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'phone_asc']) }}" 
           style="text-decoration: none; color: grey; font-size: 11px;">&#9650;</a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'phone_desc']) }}" 
           style="text-decoration: none; color: grey; font-size: 11px;">&#9660;</a>
    </th>

    <th style="width: 180px;">
        <span>Company</span>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'company_asc']) }}" 
           style="text-decoration: none; color: grey; font-size: 11px;">&#9650;</a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'company_desc']) }}" 
           style="text-decoration: none; color: grey; font-size: 11px;">&#9660;</a>
    </th>

    <th style="width: 450px;">
        <span>Address</span>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'address_asc']) }}" 
           style="text-decoration: none; color: grey; font-size: 11px;">&#9650;</a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'address_desc']) }}" 
           style="text-decoration: none; color: grey; font-size: 11px;">&#9660;</a>
    </th>

    <th style="width: 120px;">
        <span>Website</span>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'website_asc']) }}" 
           style="text-decoration: none; color: grey; font-size: 11px;">&#9650;</a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'website_desc']) }}" 
           style="text-decoration: none; color: grey; font-size: 11px;">&#9660;</a>
    </th>

    <th style="width: 120px;">
        <span>Category</span>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'category_asc']) }}" 
           style="text-decoration: none; color: grey; font-size: 11px;">&#9650;</a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'category_desc']) }}" 
           style="text-decoration: none; color: grey; font-size: 11px;">&#9660;</a>
    </th>

    <th style="width: 200px;">
        <span>Notes</span>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'note_asc']) }}" 
           style="text-decoration: none; color: grey; font-size: 11px;">&#9650;</a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'note_desc']) }}" 
           style="text-decoration: none; color: grey; font-size: 11px;">&#9660;</a>
    </th>

    <th> QR</th>

    <th style="width: 150px;">Actions</th>
</tr>

                    </thead>
                  <tbody id="crm-table-body">
      @foreach($clients as $index => $c)
        <tr>

        <td>{{ $loop->iteration }}</td>

          <td>{{ \Carbon\Carbon::parse($c->created_at)->translatedFormat('l, d-m-Y') }}</td>
          <!-- <td style="word-wrap: break-word; white-space: normal; max-width:150px;">
            {{ $c->name }}
          </td> -->

          <td style="word-wrap: break-word; white-space: normal; max-width:150px;">
            <a href="{{ route('crm.show', $c->id) }}" class="text-blue-600 hover:underline">
              {{ $c->name }}
            </a>
          </td>

          <td style="word-wrap: break-word; white-space: normal; max-width:200px;">
            <a href="mailto:{{ $c->email }}">{{ $c->email }}</a>
          </td>
          <td style="word-wrap: break-word; white-space: normal; max-width:120px;">
            {{ $c->phone }}
          </td>
          <td style="word-wrap: break-word; white-space: normal; max-width:180px;">
            {{ $c->company }}
          </td>
          <td style="word-wrap: break-word; white-space: normal; max-width:400px;">
            {{ $c->address }}
          </td>
          <td style="word-wrap: break-word; white-space: normal; max-width:150px;">
            @if($c->website)
              <a href="{{ $c->website }}" target="_blank">{{ $c->website }}</a>
            @else
              -
            @endif
          </td>
          <td>
            <span class="badge bg-danger text-light">
              {{ $c->category ? $c->category->name : '-' }}
            </span>
          </td>
          <td style="word-wrap: break-word; white-space: normal; max-width:200px;">
            {{ $c->notes }}
          </td>
          <td>
          @if($c->qr_code)
            <img src="{{ asset('storage/'.$c->qr_code) }}" 
                alt="QR Contact" 
                width="150" 
                class="qr-thumbnail" 
                data-bs-toggle="modal" 
                data-bs-target="#qrModal" 
                data-img="{{ asset('storage/'.$c->qr_code) }}">
        @else
            -
        @endif

        </td>

          <td>
<div class="d-flex align-items-center gap-2">

  <!-- Dropdown Actions -->
  <div class="dropdown">
    <button class="btn btn-sm btn-light border dropdown-toggle" 
            type="button" 
            id="dropdownMenuButton{{ $c->id }}" 
            data-bs-toggle="dropdown" 
            aria-expanded="false">
      <i class="bi bi-three-dots-vertical"></i>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $c->id }}">
      <li>
      <a class="dropdown-item" href="{{ route('crm.show', $c->id) }}">
  <i class="bi bi-eye-fill me-2 text-success"></i> Details
</a>

      </li>

      
      <li>
        @php
          $exists = \App\Models\Lead::where('crm_id', $c->id)->exists();
        @endphp

        @if(!$exists)
          <form action="{{ route('leads.createFromCrm', $c->id) }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="dropdown-item border-0 bg-transparent">
                  <i class="bi bi-lightbulb me-2 text-primary"></i> Add Lead
              </button>
          </form>
        @endif




      </li>
    </ul>
  </div>

  <!-- Edit button (icon only) -->
  <a href="{{ route('crm.edit', $c->id) }}" 
     class="btn btn-sm btn-outline-warning"
     title="Edit">
    <i class="bi bi-pencil-square"></i>
  </a>

  <!-- Delete button (icon only) -->
  <form action="{{ route('crm.destroy', $c->id) }}" 
        method="POST" 
        onsubmit="return confirm('Are you sure you want to delete this CRM data?')" 
        class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" 
            class="btn btn-sm btn-outline-danger"
            title="Delete">
      <i class="bi bi-trash"></i>
    </button>
  </form>

</div>

          </td>
        </tr>
      @endforeach
    </tbody>
                  </table>
                </div>
              @else
                <div class="alert alert-info mt-3">No CRM data found. Please add a new CRM data.</div>
              @endif
            </div>

            <div class="card-footer clearfix">
              <!-- <div class="float-end">
              </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal QR -->
<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-center">
      <div class="modal-body">
        <img id="qrModalImage" src="" alt="QR Code" class="img-fluid rounded">
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- modal export -->
 <!-- Modal Export CRM -->
<div class="modal fade" id="exportCrmModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('crm.export') }}" method="POST" class="modal-content">
      @csrf

      <div class="modal-header">
        <h5 class="modal-title">Export CRM ke Excel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <p class="text-muted mb-2">Pilih kolom yang akan di-export:</p>

        @php
          $fields = [
              'name' => 'Name',
              'position' => 'Position',
              'company' => 'Company',
              'category' => 'Category',

              'email' => 'Email',
              'phone' => 'Phone',
              'address' => 'Address',
              'website' => 'Website',
              'notes' => 'Notes',
          ];
        @endphp

        @foreach($fields as $key => $label)
          <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="columns[]"
                   value="{{ $key }}"
                   id="col_{{ $key }}">
            <label class="form-check-label" for="col_{{ $key }}">
              {{ $label }}
            </label>
          </div>
        @endforeach

      </div>

      <div class="modal-footer">
        <button type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal">
            Cancel
        </button>

        <button type="submit" class="btn btn-success">
            Export Excel
        </button>
      </div>

    </form>
  </div>
</div>


</main>

<script>
  const fileInput = document.getElementById('importFile');
  const fileNameInput = document.getElementById('fileName');
  const importBtn = document.getElementById('importBtn');

  fileInput.addEventListener('change', () => {
    if (fileInput.files.length > 0) {
      fileNameInput.value = fileInput.files[0].name;
      importBtn.disabled = false;
    } else {
      fileNameInput.value = 'No file chosen';
      importBtn.disabled = true;
    }
  });
</script>



<script>
document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('crm-search');
  const categoryFilter = document.getElementById('category-filter');
  const rows = document.querySelectorAll('#crm-table-body tr');

  function applyFilters() {
    const searchTerm = searchInput.value.toLowerCase();
    const selectedCategory = categoryFilter.value;

    rows.forEach(row => {
      const rowText = row.innerText.toLowerCase();
      const categoryText = row.querySelector('td:nth-child(9)').innerText.toLowerCase(); // kolom Category

      const matchesSearch = rowText.includes(searchTerm);
      const matchesCategory = !selectedCategory || categoryText.includes(selectedCategory);

      row.style.display = (matchesSearch && matchesCategory) ? '' : 'none';
    });
  }

  searchInput.addEventListener('input', applyFilters);
  categoryFilter.addEventListener('change', applyFilters);
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const qrModal = document.getElementById('qrModal');
    qrModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const imgSrc = button.getAttribute('data-img');
        const modalImg = qrModal.querySelector('#qrModalImage');
        modalImg.src = imgSrc;
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.add-lead-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const crmId = this.dataset.crm;

            fetch(`/crms/add-lead/${crmId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Error adding lead');
                });
        });
    });
});
</script>


</x-app-layout>
