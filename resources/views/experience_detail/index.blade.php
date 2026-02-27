<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
    @php
        $title = 'Experience Details';
        if(request('year')) {
            $title .= ' - ' . request('year');
        }
        if(request('category')) {
            $title .= ' - ' . request('category');
        }
         if(request('status')) {
            $title .= ' - ' . request('status');
        }
    @endphp
    {{ $title }}
</h2>
    </x-slot>

    <style>
        .sort-indicator {
            display: inline-block;
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            margin-left: 5px;
        }

        .sort-indicator.asc {
            border-bottom: 6px solid black;
        }

        .sort-indicator.desc {
            border-top: 6px solid black;
        }

        .sort-indicator.default {
            border-top: 6px solid gray;
            opacity: 0.5;
        }
    </style>

    <div class="px-6 py-2">
        <div class="flex justify-between items-center mt-10">

            <a href="{{ route('experiences.create') }}" class="inline-block bg-red-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition">Create New Experience</a>

            <div class="flex items-center">                
                <form method="GET" action="{{ route('experiences.index') }}" class="flex items-center">
                    <div class="w-40 mr-2"> <!-- Perpanjang dengan w-64 -->
                        <select name="searchBy" id="searchBy" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option class="searchBy" data-searchby = 'Project Name' value="project_name" {{ !request('searchBy') ? 'selected' : '' }}>Project Name</option>
                            <option class="searchBy" data-searchby = 'Client Name' value="client_name" {{ request('searchBy') == 'client_name' ? 'selected' : '' }}>Client Name</option>
                            <option class="searchBy" data-searchby = 'KBLI Number' value="kbli_number" {{ request('searchBy') == 'kbli_number' ? 'selected' : '' }}>KBLI Number</option>
                            <option class="searchBy" data-searchby = 'Location' value="locations" {{ request('searchBy') == 'locations' ? 'selected' : '' }}>Location</option>            
                        </select>
                    </div>


                     <div class="w-45 mr-2">
                     <select name="year" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- All Year --</option>
                        @for($i = date('Y'); $i >= 2000; $i--)
                            <option value="{{ $i }}" {{ request('year')==$i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    </div>
                    
                    <div class="w-64 relative mr-2"> <!-- Perpanjang dengan w-64 -->
                        <input type="text" name="search" id="search" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 pr-10" value="{{ request('search') }}" placeholder="Search Project Name">
                        <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-blue-500 hover:text-blue-600">
                            <i class="fa fa-search"></i> <!-- Gunakan ikon pencarian Font Awesome -->
                        </button>
                    </div>

                    <div class="w-40 mr-2"> <!-- Perpanjang dengan w-64 -->
                        <select name="pagination" id="pagination" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="" {{ !request('pagination') ? 'selected' : '' }}>Pagination</option>
                            <option value="10" {{ request('pagination') == '10' ? 'selected' : '' }}>10</option>
                            <option value="50" {{ request('pagination') == '50' ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('pagination') == '100' ? 'selected' : '' }}>100</option>
                            <option value="all" {{ request('pagination') == 'all' ? 'selected' : '' }}>All</option>
                        </select>
                    </div>

                    <div class="w-64 mr-2"> <!-- Perpanjang dengan w-64 -->
                        <select name="category" id="category" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="" {{ !request('category') ? 'selected' : '' }}>Category</option>
                            <option value="" {{ request('category') == 'all' ? 'selected' : '' }}>All</option>
                            <option value="801 Travel Arrangement" {{ request('category') == '801 Travel Arrangement' ? 'selected' : '' }}>801 Travel Arrangement</option>
                            <option value="802 Merchandise/ATK" {{ request('category') == '802 Marchandise/ATK' ? 'selected' : '' }}>802 Marchandise/ATK</option>
                            <option value="803 Business Development" {{ request('category') == '803 Business Development' ? 'selected' : '' }}>803 Business Development</option>                            
                            <option value="804 IT" {{ request('category') == '803 IT' ? 'selected' : '' }}>804 IT</option>
                            <option value="805 Manpower Supply" {{ request('category') == '805 Manpower Supply' ? 'selected' : '' }}>805 Manpower Supply</option>                            
                            <option value="806 Event Organizer" {{ request('category') == '806 Event Organizer' ? 'selected' : '' }}>806 Event Organizer</option>
                            <option value="807 Printing" {{ request('category') == '807 Printing' ? 'selected' : '' }}>807 Printing</option>
                            <option value="808 Car Rental" {{ request('category') == '808 Car Rental' ? 'selected' : '' }}>808 Car Rental</option>
                            <option value="809 Company Loan" {{ request('category') == '809 Company Loan' ? 'selected' : '' }}>809 Company Loan</option>
                            <option value="809 Moving Office" {{ request('category') == '809 Moving Office' ? 'selected' : '' }}>809 Moving Office</option>
                            <option value="809 Others" {{ request('category') == '809 Others' ? 'selected' : '' }}>809 Others</option>
                            <option value="810 Rent Building" {{ request('category') == '810 Rent Building' ? 'selected' : '' }}>810 Rent Building</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition">Apply</button>
                </form>
                <div class="reset_filter">
                    <a  href="{{ route('experiences.index') }}">
                        <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition ml-4 w-full md:w-auto">Reset Filter</button>
                    </a>
                </div>

                <div class="dropdown ml-2">
                    <!-- Dropdown Toggle Button -->
                    <button class="dropdown-toggle bg-red-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition ml-4 w-full md:w-auto" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>

                    <!-- Dropdown Menu -->
                    <ul class="dropdown-menu w-full min-w-[200px] mt-2 shadow-lg rounded-md bg-white ring-1 ring-gray-200 z-10" aria-labelledby="dropdownMenuButton">
                        <!-- Download All Button -->
                        <li>
                            <a href="{{ route('experiences.pdfAll', ['search' => request('search'), 'category' => request('category')]) }}" class="dropdown-item px-4 py-2 text-gray-700 hover:bg-gray-100">Download All</a>
                        </li>

                        <!-- Export Projects -->
                        <li>
                            <a href="{{ route('experiences.export') }}" class="dropdown-item px-4 py-2 text-gray-700 hover:bg-gray-100">Export Pfs</a>
                        </li>
                    </ul>
                </div>

                <div class="ml-2">
                    <button type="button" class="inline-block bg-red-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition" data-bs-toggle="modal" data-bs-target="#importModal">
                        Import
                    </button>

                    <!-- Modal untuk meng-upload file -->
                    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="importModalLabel">Upload File</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('experiences.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="file" class="form-label text-sm text-gray-700">Select File</label>
                                            <input type="file" id="file" name="file" class="form-control mt-1 block w-full text-sm text-gray-700" required>
                                        </div>
                                        <button type="submit" class="inline-block bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition w-full">Import</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Success Toast Notification -->
                    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="successToast">
                        <div id="liveToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    File berhasil diimport!
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>



        </div>
    </div>

    @if ($experiences instanceof \Illuminate\Pagination\LengthAwarePaginator || $experiences instanceof \Illuminate\Pagination\Paginator)

    <div class="w-80  py-2 px-6">
        <p class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition">
            Page : {{ $experiences->currentpage() }} to {{ $experiences->lastpage() }}  from {{ $experiences->total() }} data
        </p>
    </div>

    @endif

    <div class="w-full mx-auto py-2 px-6">
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto ">
                <thead class="bg-gray-200 ">
                    <tr>
                        <!-- <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">No.</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Project No</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Project Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Client Name</th> -->
                        <!-- <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                            <a href="?sortBy=no&order={{ request('order') == 'asc' ? 'desc' : 'asc' }}" class="flex items-center">
                                No.
                                <span class="ml-2">
                                    <span class="sort-indicator {{ request('sortBy') == 'no' && request('order') == 'asc' ? 'asc' : '' }} {{ request('sortBy') == 'no' && request('order') == 'desc' ? 'desc' : '' }} {{ request('sortBy') != 'no' ? 'default' : '' }}"></span>
                                </span>
                            </a>
                        </th> -->

                        

                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                            <a href="?sortBy=project_no&order={{ request('order') == 'asc' ? 'desc' : 'asc' }}&search={{ request('search') }}&category={{ request('category') }}&pagination={{ request('pagination') }}&page={{ request('page') }}" class="flex items-center">
                                Project No
                                <span class="ml-2">
                                    <span class="sort-indicator {{ request('sortBy') == 'project_no' && request('order') == 'asc' ? 'asc' : '' }} {{ request('sortBy') == 'project_no' && request('order') == 'desc' ? 'desc' : '' }} {{ request('sortBy') != 'project_no' ? 'default' : '' }}"></span>
                                </span>
                            </a>
                        </th>

                                   <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                            <a href="?sortBy=project_no&order={{ request('order') == 'asc' ? 'desc' : 'asc' }}&search={{ request('search') }}&category={{ request('category') }}&pagination={{ request('pagination') }}&page={{ request('page') }}" class="flex items-center">
                                No Contract
                                <span class="ml-2">
                                    <span class="sort-indicator {{ request('sortBy') == 'project_no' && request('order') == 'asc' ? 'asc' : '' }} {{ request('sortBy') == 'project_no' && request('order') == 'desc' ? 'desc' : '' }} {{ request('sortBy') != 'project_no' ? 'default' : '' }}"></span>
                                </span>
                            </a>
                        </th>


                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                            <a href="?sortBy=project_name&order={{ request('order') == 'asc' ? 'desc' : 'asc' }}&search={{ request('search') }}&category={{ request('category') }}&pagination={{ request('pagination') }}" class="flex items-center">
                                Project Name
                                <span class="ml-2">
                                    <span class="sort-indicator {{ request('sortBy') == 'project_name' && request('order') == 'asc' ? 'asc' : '' }} {{ request('sortBy') == 'project_name' && request('order') == 'desc' ? 'desc' : '' }} {{ request('sortBy') != 'project_name' ? 'default' : '' }}"></span>
                                </span>
                            </a>
                        </th>

                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                            <a href="?sortBy=client_name&order={{ request('order') == 'asc' ? 'desc' : 'asc' }}&search={{ request('search') }}&category={{ request('category') }}&pagination={{ request('pagination') }}" class="flex items-center">
                                Client Name
                                <span class="ml-2">
                                    <span class="sort-indicator {{ request('sortBy') == 'client_name' && request('order') == 'asc' ? 'asc' : '' }} {{ request('sortBy') == 'client_name' && request('order') == 'desc' ? 'desc' : '' }} {{ request('sortBy') != 'client_name' ? 'default' : '' }}"></span>
                                </span>
                            </a>
                        </th>



                       {{-- KBLI Number --}}
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                            <a href="?sortBy=kbli_number&order={{ request('order') == 'asc' ? 'desc' : 'asc' }}&search={{ request('search') }}&category={{ request('category') }}&pagination={{ request('pagination') }}" class="flex items-center">
                                KBLI Number
                                <span class="ml-2">
                                    <span class="sort-indicator 
                                        {{ request('sortBy') == 'kbli_number' && request('order') == 'asc' ? 'asc' : '' }} 
                                        {{ request('sortBy') == 'kbli_number' && request('order') == 'desc' ? 'desc' : '' }} 
                                        {{ request('sortBy') != 'kbli_number' ? 'default' : '' }}">
                                    </span>
                                </span>
                            </a>
                        </th>

                        {{-- Category --}}
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                            <a href="?sortBy=category&order={{ request('order') == 'asc' ? 'desc' : 'asc' }}&search={{ request('search') }}&category={{ request('category') }}&pagination={{ request('pagination') }}" class="flex items-center">
                                Category
                                <span class="ml-2">
                                    <span class="sort-indicator 
                                        {{ request('sortBy') == 'category' && request('order') == 'asc' ? 'asc' : '' }} 
                                        {{ request('sortBy') == 'category' && request('order') == 'desc' ? 'desc' : '' }} 
                                        {{ request('sortBy') != 'category' ? 'default' : '' }}">
                                    </span>
                                </span>
                            </a>
                        </th>

                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                            <a href="?sortBy=duration&order={{ request('order') == 'asc' ? 'desc' : 'asc' }}&search={{ request('search') }}&category={{ request('category') }}&pagination={{ request('pagination') }}" class="flex items-center">
                                Duration
                                <span class="ml-2">
                                    <span class="sort-indicator 
                                        {{ request('sortBy') == 'duration' && request('order') == 'asc' ? 'asc' : '' }} 
                                        {{ request('sortBy') == 'duration' && request('order') == 'desc' ? 'desc' : '' }} 
                                        {{ request('sortBy') != 'duration' ? 'default' : '' }}">
                                    </span>
                                </span>
                            </a>
                        </th>

                        <!-- <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Period</th> -->
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                            <a href="?sortBy=date_project_start&order={{ request('order') == 'asc' ? 'desc' : 'asc' }}&search={{ request('search') }}&category={{ request('category') }}&pagination={{ request('pagination') }}" class="flex items-center">
                                Period
                                <span class="ml-2">
                                    <span class="sort-indicator {{ request('sortBy') == 'date_project_start' && request('order') == 'asc' ? 'asc' : '' }} {{ request('sortBy') == 'date_project_start' && request('order') == 'desc' ? 'desc' : '' }} {{ request('sortBy') != 'date_project_start' ? 'default' : '' }}"></span>
                                </span>
                            </a>
                        </th>



                        {{-- Locations --}}
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                    <a href="?sortBy=location&order={{ request('order') == 'asc' ? 'desc' : 'asc' }}&search={{ request('search') }}&category={{ request('category') }}&pagination={{ request('pagination') }}" class="flex items-center">
                        Locations
                        <span class="ml-2">
                            <span class="sort-indicator 
                                {{ request('sortBy') == 'location' && request('order') == 'asc' ? 'asc' : '' }} 
                                {{ request('sortBy') == 'location' && request('order') == 'desc' ? 'desc' : '' }} 
                                {{ request('sortBy') != 'location' ? 'default' : '' }}">
                            </span>
                        </span>
                    </a>
                </th>

                {{-- Scope of Work --}}
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                    <a href="?sortBy=scope_of_work&order={{ request('order') == 'asc' ? 'desc' : 'asc' }}&search={{ request('search') }}&category={{ request('category') }}&pagination={{ request('pagination') }}" class="flex items-center">
                        Scope of Work
                        <span class="ml-2">
                            <span class="sort-indicator 
                                {{ request('sortBy') == 'scope_of_work' && request('order') == 'asc' ? 'asc' : '' }} 
                                {{ request('sortBy') == 'scope_of_work' && request('order') == 'desc' ? 'desc' : '' }} 
                                {{ request('sortBy') != 'scope_of_work' ? 'default' : '' }}">
                            </span>
                        </span>
                    </a>
                </th>

                {{-- Status --}}
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                    <a href="?sortBy=status&order={{ request('order') == 'asc' ? 'desc' : 'asc' }}&search={{ request('search') }}&category={{ request('category') }}&pagination={{ request('pagination') }}" class="flex items-center">
                        Status
                        <span class="ml-2">
                            <span class="sort-indicator 
                                {{ request('sortBy') == 'status' && request('order') == 'asc' ? 'asc' : '' }} 
                                {{ request('sortBy') == 'status' && request('order') == 'desc' ? 'desc' : '' }} 
                                {{ request('sortBy') != 'status' ? 'default' : '' }}">
                            </span>
                        </span>
                    </a>
                </th>

     

                {{-- Amount Contract --}}
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                    <a href="?sortBy=amount_contract&order={{ request('order') == 'asc' ? 'desc' : 'asc' }}&search={{ request('search') }}&category={{ request('category') }}&pagination={{ request('pagination') }}" class="flex items-center">
                        Amount Contract
                        <span class="ml-2">
                            <span class="sort-indicator 
                                {{ request('sortBy') == 'amount_contract' && request('order') == 'asc' ? 'asc' : '' }} 
                                {{ request('sortBy') == 'amount_contract' && request('order') == 'desc' ? 'desc' : '' }} 
                                {{ request('sortBy') != 'amount_contract' ? 'default' : '' }}">
                            </span>
                        </span>
                    </a>
                </th>

                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Images</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($experiences as $experienceDetail)
                    <tr>
                        {{-- <td class="px-6 py-3 text-sm">{{ $loop->iteration }}</td> --}}
                        <td class="px-6 py-3 text-sm">{{ $experienceDetail->project_no }}</td>
                        <td class="px-6 py-3 text-sm">{{ $experienceDetail->no_contract }}</td>
                        <td class="px-6 py-3 text-sm">{{ $experienceDetail->project_name }}</td>
                        <td class="px-6 py-3 text-sm">{{ $experienceDetail->client_name }}</td>
                        <td class="px-6 py-3 text-sm">{{ $experienceDetail->kbli_number }}</td>
                        <td class="px-6 py-3 text-sm">{{ $experienceDetail->category }}</td>
                        <td class="px-6 py-3 text-sm">{{ $experienceDetail->durations }}</td>
                        <td class="px-6 py-3 text-sm">{{ $experienceDetail->date_project_start }} - {{ $experienceDetail->date_project_end }}</td>
                        <td class="px-6 py-3 text-sm">{{ $experienceDetail->locations }}</td>
                        <td class="px-6 py-3 text-sm">{!! $experienceDetail->scope_of_work !!}</td>
                        <td class="px-6 py-3 text-sm">{{ $experienceDetail->status }}</td>
                        <td class="px-6 py-3 text-sm">Rp.{{ $experienceDetail->amount }}</td>




                        <td class="">
                            @foreach($experienceDetail->images as $image)
                            <img src="{{ Storage::url($image->foto) }}" alt="Image" class="w-20 h-20 object-cover rounded-md mb-2">
                            @endforeach
                        </td>
                        <td class="px-6 py-3 text-sm">
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                        <div>Action</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('experiences.edit', [$experienceDetail->id]) . '?' . http_build_query(request()->query())">
                                        Edit
                                    </x-dropdown-link>

                                    <x-dropdown-link :href="route('experiences.pdffs', $experienceDetail->id)" target="_blank">
                                        Download FactSheet
                                    </x-dropdown-link>

                                    <x-dropdown-link :href="route('experiences.bast', $experienceDetail->id)" target="_blank">
                                        Download BAST
                                    </x-dropdown-link>

                                    <form method="POST" action="{{ route('experiences.destroy', $experienceDetail->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <x-dropdown-link :href="route('experiences.destroy', $experienceDetail->id)" onclick="event.preventDefault(); this.closest('form').submit();">
                                            Delete
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- Pagination -->
    @if ($experiences instanceof \Illuminate\Pagination\LengthAwarePaginator || $experiences instanceof \Illuminate\Pagination\Paginator)
    {{ $experiences->links() }}
    @endif


    </div>
</x-app-layout>