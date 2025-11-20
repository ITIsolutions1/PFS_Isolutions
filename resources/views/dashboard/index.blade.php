<x-app-layout>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Experience Dashboard') }}
        </h2>
    </x-slot>



    <div class="py-6 px-6">
<div class="row mt-0">
    <div class="col-lg-6 connectedSortable">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 flex items-center justify-between mb-4 hover:shadow-xl transition">
            <div>
                <h2 class="text-gray-600 dark:text-gray-300 text-sm font-medium">
                    Total Project
                </h2>
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-1">
                    {{ $totalProjects }}
                </p>
            </div>
            <div class="p-4 bg-blue-100 dark:bg-blue-900 rounded-full">
                <i class="fas fa-folder-open text-blue-600 dark:text-blue-300 text-2xl"></i>
            </div>
        </div>
    </div>
</div>



          
    <div class="row">

    <!-- Yearly Chart -->
    <div class="col-lg-6 connectedSortable">
        <div class="card mb-4 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
            <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-200 flex items-center gap-2">
                <i class="fas fa-calendar-alt text-blue-500"></i>
                Projects by Year
            </h3>
            <canvas id="yearlyChart" class="h-56 w-full"></canvas>
        </div>
    </div>
   
 <div class="col-lg-6 connectedSortable">
        <div class="card mb-4 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
            <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-200 flex items-center gap-2">
                <i class="fas fa-layer-group text-indigo-500"></i>
                Projects by Category
            </h3>
            <canvas id="categoryChart" class="h-56 w-full"></canvas>
        </div>
    </div>
      <!-- Amount per Year -->
    
</div>

<div class="row mt-4">
    
 <!-- Category Chart -->
   

    <div class="col-lg-6 connectedSortable">
        <div class="card mb-4 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
            <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-200 flex items-center gap-2">
                <i class="fas fa-dollar-sign text-orange-500"></i>
                Total Amount per Year
            </h3>
            <canvas id="amountChart" class="h-56 w-full"></canvas>
        </div>
    </div>

     <!-- Status Chart -->
    <div class="col-lg-6 connectedSortable">
        <div class="card mb-4 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
            <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-200 flex items-center gap-2">
                <i class="fas fa-tasks text-green-500"></i>
                Projects by Status
            </h3>
          <canvas id="statusChart" style="width:450px; height:450px; margin:auto;"></canvas>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12 text-center">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">
           <strong>Projects per Category per Year</strong> 
        </h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm">
            Statistics on the number of projects by category and year
        </p>
    </div>
</div>

<div class="row mt-4">
    @foreach($categoryPerYear->groupBy('category') as $category => $data)
        <div class="col-lg-4 col-md-6 col-sm-12 connectedSortable">
            <div class="card mb-4 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 
                        hover:shadow-2xl hover:scale-[1.02] transform transition-all duration-300
                        border-t-4 border-purple-500">
                <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-200 flex items-center gap-3">
                    <div class="p-3 rounded-full bg-gradient-to-r from-purple-500 to-indigo-500 text-white shadow-md">
                        <i class="fas fa-chart-bar" style="color: black;"></i>
                    </div>
                    {{ $category }}
                </h3>
                <canvas id="chart-{{ Str::slug($category, '-') }}" class="h-56 w-full"></canvas>
            </div>
        </div>
    @endforeach
</div>

<div id="projectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
  <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-2/3 max-h-[80vh] overflow-y-auto shadow-xl">
    <h2 id="modalTitle" class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Projects</h2>
    <ul id="projectList" class="space-y-2 text-gray-700 dark:text-gray-200"></ul>
    <div class="mt-4 text-right">
      <button onclick="closeModal()" class="px-4 py-2 bg-red-500 text-white rounded-lg">Close</button>
    </div>
  </div>
</div>

<div class="row mt-10 ">
    <div class="col-12 text-center">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">
       <strong style="font-size: 2rem;">Proposal</strong>

        </h1>
        <!-- <p class="text-gray-500 dark:text-gray-400 text-sm">
            Statistics on the number of projects by category and year
        </p> -->
    </div>
</div>

<div class="stats-container">

    <!-- RFP -->
    <div class="stat-card bg-primary"
         onclick="window.location='{{ route('proposal.byStatus', ['status' => 'rfp']) }}'">
        <div class="inner">
            <h3>{{ $proposalCounts['rfp'] }}</h3>
            <p>RFP</p>
        </div>
        <i class="bi bi-clipboard-check stat-icon"></i>
        <div class="stat-footer">
            <span>View RFP</span>
            <i class="bi bi-arrow-right-circle"></i>
        </div>
    </div>

    <!-- Draft -->
    <div class="stat-card bg-secondary"
         onclick="window.location='{{ route('proposal.byStatus', ['status' => 'draft']) }}'">
        <div class="inner">
            <h3>{{ $proposalCounts['draft'] }}</h3>
            <p>Draft</p>
        </div>
        <i class="bi bi-pencil stat-icon"></i>
        <div class="stat-footer">
            <span>View Draft</span>
            <i class="bi bi-arrow-right-circle"></i>
        </div>
    </div>

    <!-- Submitted -->
    <div class="stat-card bg-info"
         onclick="window.location='{{ route('proposal.byStatus', ['status' => 'submitted']) }}'">
        <div class="inner">
            <h3>{{ $proposalCounts['submitted'] }}</h3>
            <p>Submitted</p>
        </div>
        <i class="bi bi-send stat-icon"></i>
        <div class="stat-footer">
            <span>View Submitted</span>
            <i class="bi bi-arrow-right-circle"></i>
        </div>
    </div>

    <!-- Awaiting PO -->
    <div class="stat-card bg-warning"
         onclick="window.location='{{ route('proposal.byStatus', ['status' => 'awaiting_po']) }}'">
        <div class="inner">
            <h3>{{ $proposalCounts['awaiting_po'] }}</h3>
            <p>Awaiting PO</p>
        </div>
        <i class="bi bi-hourglass-split stat-icon"></i>
        <div class="stat-footer">
            <span>View Awaiting PO</span>
            <i class="bi bi-arrow-right-circle"></i>
        </div>
    </div>

    <!-- Awarded -->
    <div class="stat-card bg-success"
         onclick="window.location='{{ route('proposal.byStatus', ['status' => 'awarded']) }}'">
        <div class="inner">
            <h3>{{ $proposalCounts['awarded'] }}</h3>
            <p>Awarded</p>
        </div>
        <i class="bi bi-trophy stat-icon"></i>
        <div class="stat-footer">
            <span>View Awarded</span>
            <i class="bi bi-arrow-right-circle"></i>
        </div>
    </div>

    <!-- Decline -->
    <div class="stat-card bg-dark"
         onclick="window.location='{{ route('proposal.byStatus', ['status' => 'decline']) }}'">
        <div class="inner">
            <h3>{{ $proposalCounts['decline'] }}</h3>
            <p>Declined</p>
        </div>
        <i class="bi bi-x-circle stat-icon"></i>
        <div class="stat-footer">
            <span>View Declined</span>
            <i class="bi bi-arrow-right-circle"></i>
        </div>
    </div>

    <!-- Lost -->
    <div class="stat-card bg-danger"
         onclick="window.location='{{ route('proposal.byStatus', ['status' => 'lost']) }}'">
        <div class="inner">
            <h3>{{ $proposalCounts['lost'] }}</h3>
            <p>Lost</p>
        </div>
        <i class="bi bi-emoji-frown stat-icon"></i>
        <div class="stat-footer">
            <span>View Lost</span>
            <i class="bi bi-arrow-right-circle"></i>
        </div>
    </div>
</div>

<div class="row mt-10">
    <div class="col-12 text-center">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">
            <strong>Proposal Status Per Year</strong>
        </h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm">
         Statistics on the number of proposals by status each year
        </p>
    </div>
</div>

<div class="row mt-4">
    @foreach($statusPerYear->groupBy('status') as $status => $data)
        @php
            $chartId = 'chart-status-' . Str::slug($status, '-');
        @endphp

        <div class="col-lg-4 col-md-6 col-sm-12 connectedSortable">
            <div class="card mb-4 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 
                        hover:shadow-2xl hover:scale-[1.02] transform transition-all duration-300
                        border-t-4 border-blue-500">
                <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-200 flex items-center gap-3">
                    <div class="p-3 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 text-black shadow-md">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    {{ ucfirst($status) }}
                </h3>

                <canvas id="{{ $chartId }}" class="h-56 w-full"></canvas>
            </div>
        </div>
    @endforeach
</div>





<div class="row mt-10 ">
   

</div>

<div class="row mt-5">
    <div class="col-12 text-center">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">
           <strong>CRM</strong> 
        </h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm">
            Statistics on the number of projects by category and year
        </p>
    </div>
</div>

<style>
  .stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    gap: 1.2rem;
    margin-top: 2rem;
  }

  .stat-card {
    position: relative;
    border-radius: 1rem;
    color: #fff;
    padding: 1.8rem;
    overflow: hidden;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
  }

  .stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  }

  .stat-card::before {
    content: "";
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle at bottom right, rgba(255,255,255,0.15), transparent 70%);
    transform: rotate(25deg);
  }

  .stat-card .inner {
    position: relative;
    z-index: 2;
  }

  .stat-card h3 {
    font-size: 2.6rem;
    font-weight: 800;
    margin: 0;
    line-height: 1;
  }

  .stat-card p {
    font-size: 1rem;
    margin-top: 6px;
    letter-spacing: 0.5px;
    font-weight: 500;
    opacity: 0.9;
  }

  .stat-icon {
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 3rem;
    opacity: 0.2;
    z-index: 1;
  }

  .stat-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-weight: 500;
    font-size: 0.9rem;
    padding-top: 0.8rem;
    border-top: 1px solid rgba(255,255,255,0.2);
    margin-top: 1rem;
    opacity: 0.9;
  }

  .stat-footer i {
    font-size: 1rem;
    margin-left: 6px;
    transition: transform 0.2s;
  }

  .stat-card:hover .stat-footer i {
    transform: translateX(5px);
  }

  /* Warna Kustom */
  .bg-danger { background: linear-gradient(135deg, #dc3545, #a71d2a); }
  .bg-warning { background: linear-gradient(135deg, #ffc107, #d39e00); color: #000; }
  .bg-success { background: linear-gradient(135deg, #198754, #0f5132); }
  .bg-primary { background: linear-gradient(135deg, #0d6efd, #084298); }
</style>

<div class="stats-container">
  <!-- New Leads -->
  <div class="stat-card bg-danger" onclick="window.location='{{ route('leads.byStatus', ['status' => 'new']) }}'">
    <div class="inner">
      <h3>{{ $newLeads }}</h3>
      <p>New Leads</p>
    </div>
    <i class="bi bi-lightbulb stat-icon"></i>
    <div class="stat-footer">
      <span>View New Leads</span>
      <i class="bi bi-arrow-right-circle"></i>
    </div>
  </div>

  <!-- Contacted -->
  <div class="stat-card bg-warning" onclick="window.location='{{ route('leads.byStatus', ['status' => 'contacted']) }}'">
    <div class="inner">
      <h3>{{ $contactedLeads }}</h3>
      <p>Contacted</p>
    </div>
    <i class="bi bi-telephone stat-icon"></i>
    <div class="stat-footer">
      <span>View Contacted Leads</span>
      <i class="bi bi-arrow-right-circle"></i>
    </div>
  </div>

  <!-- Qualified (RFP) -->
  <div class="stat-card bg-success" onclick="window.location='{{ route('leads.byStatus', ['status' => 'qualified']) }}'">
    
  <div class="inner">
      <h3>{{ $qualifiedLeads }}</h3>
      <p>RFP / Qualified</p>
    </div>
    <i class="bi bi-clipboard-check stat-icon"></i>
    <div class="stat-footer">
      <span>View Qualified Leads</span>
      <i class="bi bi-arrow-right-circle"></i>
    </div>
  </div>

  <!-- Total Leads -->
  <div class="stat-card bg-primary" onclick="window.location='{{ route('leads.index') }}'">
    <div class="inner">
      <h3>{{ $totalLeads }}</h3>
      <p>Total Leads</p>
    </div>
    <i class="bi bi-people stat-icon"></i>
    <div class="stat-footer">
      <span>View All Leads</span>
      <i class="bi bi-arrow-right-circle"></i>
    </div>
  </div>
</div>


                    


    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Category chart
        const categoryLabels = @json($categoryCounts->pluck('category'));
        const categoryData = @json($categoryCounts->pluck('total'));

        new Chart(document.getElementById('categoryChart'), {
            type: 'bar',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Projects',
                    data: categoryData,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } },
                      onClick: (evt, elements) => {
                        if (elements.length > 0) {
                            const i = elements[0].index;
                            const category = categoryLabels[i]; 
                            window.location.href = `/experience?category=${category}`;
                        }
                        }
            }
        });

        // Status chart
        const statusLabels = @json($statusCounts->pluck('status'));
        const statusData = @json($statusCounts->pluck('total'));

        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusData,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(153, 102, 255, 0.7)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } },
                      onClick: (evt, elements) => {
                        if (elements.length > 0) {
                            const i = elements[0].index;
                            const status = statusLabels[i]; // atau category, tergantung chart
                            window.location.href = `/experience?status=${status}`;
                        }
                        }
            }
        });

       
        // Yearly chart 
        const yearlyLabels = @json($yearlyCounts->pluck('year'));
        const yearlyData   = @json($yearlyCounts->pluck('total'));

        const yearlyChart = new Chart(document.getElementById('yearlyChart'), {
            type: 'bar',
            data: {
                labels: yearlyLabels,
                datasets: [{
                    label: 'Projects',
                    data: yearlyData,
                    backgroundColor: 'rgba(145, 0, 0, 0.7)',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } },
            
            onClick: (evt, elements) => {
        if (elements.length > 0) {
            const i = elements[0].index;
            const year = yearlyLabels[i]; 
            window.location.href = `/experience?year=${year}`;
        }
        }

            }
        });


        // new Chart(document.getElementById('yearlyChart'), {
        //     type: 'line',
        //     data: {
        //         labels: yearlyLabels,
        //         datasets: [{
        //             label: 'Projects',
        //             data: yearlyData,
        //             borderColor: 'rgba(99, 102, 241, 1)',
        //             backgroundColor: 'rgba(99, 102, 241, 0.3)',
        //             fill: true,
        //             tension: 0.4,
        //             pointBackgroundColor: 'rgba(99, 102, 241, 1)',
        //             pointRadius: 5
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         plugins: { legend: { display: false } },
        //         scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        //     }
        // });

        // Amount per year
        @if(isset($amountPerYear))
        const amountLabels = @json($amountPerYear->pluck('year'));
        const amountData = @json($amountPerYear->pluck('total_amount'));

        new Chart(document.getElementById('amountChart'), {
            type: 'bar',
            data: {
                labels: amountLabels,
                datasets: [{
                    label: 'Total Amount',
                    data: amountData,
                    backgroundColor: 'rgba(255, 159, 64, 0.7)',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
        @endif
    </script>

    <script>
    const categoryCharts = @json($categoryPerYear->groupBy('category'));

    Object.keys(categoryCharts).forEach((category) => {
        let chartId = "chart-" + category.toLowerCase().replace(/[^a-z0-9]+/g, "-");

        let data = categoryCharts[category];

        let years = data.map(item => item.year);
        let totals = data.map(item => item.total);

        new Chart(document.getElementById(chartId), {
            type: 'bar',
            data: {
                labels: years,
                datasets: [{
                    label: 'Projects',
                    data: totals,
                    backgroundColor: 'rgba(99, 102, 241, 0.6)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: category
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision:0 }
                    }
                },

                 onClick: (evt, elements) => {
    if (elements.length > 0) {
        const i = elements[0].index;
        const year = years[i];   // ambil tahun sesuai bar yang diklik
        const selectedCategory = category; // ambil kategori dari loop

        // redirect ke route dengan query category + year
        window.location.href = `/experience?year=${year}&category=${encodeURIComponent(selectedCategory)}`;
    }
}


            }
        });
    });

</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        @foreach($statusPerYear->groupBy('status') as $status => $rows)
            const ctx{{ Str::slug($status, '_') }} = document.getElementById("chart-status-{{ Str::slug($status, '-') }}").getContext("2d");

            new Chart(ctx{{ Str::slug($status, '_') }}, {
                type: "bar",
                data: {
                    labels: {!! json_encode($rows->pluck('year')) !!},
                    datasets: [{
                        label: "{{ ucfirst($status) }}",
                        data: {!! json_encode($rows->pluck('total')) !!},
                        backgroundColor: "rgba(59, 130, 246, 0.6)",
                        borderColor: "rgba(59, 130, 246, 1)",
                        borderWidth: 2,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        @endforeach
    });
</script>






</x-app-layout>
