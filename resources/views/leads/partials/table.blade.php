<style>
    .table thead {
        background: #dc3545; /* merah */
        color: white;
    }

    .table tbody tr:hover {
        background: #ffe5e5; /* merah soft */
        transition: 0.2s;
    }

    .table td, .table th {
        vertical-align: middle;
        padding: 10px;
    }

    .table-container {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
</style>

<div class="table-container">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Lead Name</th>
                <th>Category</th>
                <th>Created At</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($leads as $lead)
                <tr>
                     <td>{{ $lead->crm->name ?? '-' }}</td>
                    <td>{{ $lead->crm->category->name ?? '-' }}</td>
                  
                    <td>{{ $lead->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
