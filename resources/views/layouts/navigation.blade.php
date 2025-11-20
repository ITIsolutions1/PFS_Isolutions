<nav x-data="{ open: false }" 
     class="bg-red-500 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700" style="background-color: #800000;">
    <!-- Container -->
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <!-- Left Side -->
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center bg-white p-4 rounded">
                    <a href="{{ route('experiences.index') }}">
                        <x-application-logo 
                            class="block h-9 w-auto fill-current text-blue-600 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Back to Home (only on create/edit pages) -->
                @if(request()->routeIs('experiences.create') || request()->routeIs('experiences.edit'))
                    <div class="ml-8 flex items-center text-white">
                        <a href="{{ route('experiences.index') }}" 
                           class="flex items-center space-x-2 hover:text-gray-200 transition">
                            <i class="fas fa-home"></i>
                            <span>Home</span>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Right Side -->
         <!-- Right Side -->
<div class="hidden sm:flex sm:items-center ml-auto pr-6 space-x-8">
    <!-- Navigation Links -->
    <a href="{{ route('dashboard') }}"
       class="flex items-center text-sm font-medium text-white dark:text-gray-300 hover:text-gray-200 transition">
        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
    </a>
@php
    $user = Auth::user();
@endphp
    @if($user && ($user->role === 'admin' || $user->categories->isNotEmpty()))
   

      <a href="{{ route('crm.index') }}"
       class="flex items-center text-sm font-medium text-white dark:text-gray-300 hover:text-gray-200 transition">
        <i class="fas fa-users mr-2"></i> CRM
    </a>

     <a href="{{ route('leads.dashboard') }}"
       class="flex items-center text-sm font-medium text-white dark:text-gray-300 hover:text-gray-200 transition">
        <i class="fas fa-users mr-2"></i> Leads
    </a>
@endif

     @if(Auth::user()->role === 'admin')
  


  

    
    <a href="{{ route('proposals.index') }}"
       class="flex items-center text-sm font-medium text-white dark:text-gray-300 hover:text-gray-200 transition">
        <i class="fas fa-file mr-2"></i> Proposals
    </a>
     @endif

    <a href="{{ route('experience.index') }}"
       class="flex items-center text-sm font-medium text-white dark:text-gray-300 hover:text-gray-200 transition">
        <i class="fas fa-briefcase mr-2"></i> Experience Details
    </a>

      <a href="{{ route('broadcast.index') }}"
       class="flex items-center text-sm font-medium text-white dark:text-gray-300 hover:text-gray-200 transition">
        <i class="fas fa-envelope mr-2"></i>  Broadcast Email
    </a>
   

@if(Auth::user()->role === 'admin')
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="flex items-center text-sm font-medium text-white dark:text-gray-300 hover:text-gray-200 transition focus:outline-none">
            <i class="fas fa-user-shield mr-2"></i>
            Admin Menu
            <i class="fas fa-chevron-down ml-1 text-xs"></i>
        </button>

        <div x-show="open" @click.outside="open = false"
             class="absolute bg-gray-800 text-white dark:bg-gray-700 mt-2 rounded-lg shadow-lg w-40">
            <a href="{{ route('admin.users') }}" 
               class="flex items-center px-4 py-2 text-sm hover:bg-gray-700 rounded-t-lg transition">
                <i class="fas fa-user mr-2"></i> Users
            </a>

             <a href="{{ route('categories.index') }}" 
               class="flex items-center px-4 py-2 text-sm hover:bg-gray-700 rounded-b-lg transition">
                <i class="fas fa-envelope mr-2"></i>Category
            </a>
        </div>
    </div>
@endif


    <!-- User Info Dropdown -->
    <x-dropdown align="right" width="48">
    <x-slot name="trigger">
        <button 
            class="flex items-center px-4 py-2 bg-white rounded-md shadow 
                   text-gray-800 hover:bg-gray-100 transition">
            <!-- Avatar -->
            <div class="h-8 w-8 rounded-full bg-gray-300 
                        flex items-center justify-center text-gray-700 mr-2">
                <i class="fas fa-user"></i>
            </div>

            <!-- User Info -->
            <div class="flex flex-col text-left leading-tight">
                <span class="text-sm font-medium">
                    {{ Auth::user()->name }}
                </span>
                <span class="text-xs text-gray-500">
                    {{ Auth::user()->email }}
                </span>
            </div>

            <!-- Dropdown Icon -->
            <svg class="ml-2 h-4 w-4 fill-current text-gray-500" 
                 xmlns="http://www.w3.org/2000/svg" 
                 viewBox="0 0 20 20">
                <path fill-rule="evenodd" 
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 
                         111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 
                         1 0 010-1.414z" 
                      clip-rule="evenodd" />
            </svg>
        </button>
    </x-slot>

    <x-slot name="content">
        <x-dropdown-link :href="route('profile.edit')">
            <i class="fas fa-user-circle mr-2"></i> {{ __('Profile') }}
        </x-dropdown-link>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-dropdown-link :href="route('logout')"
                onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Log Out') }}
            </x-dropdown-link>
        </form>
    </x-slot>
</x-dropdown>

</div>



            <!-- Mobile Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" 
                        class="p-2 rounded-md text-gray-400 dark:text-gray-500 
                               hover:text-gray-500 dark:hover:text-gray-400 
                               hover:bg-gray-100 dark:hover:bg-gray-900 
                               focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': ! open }" 
                              class="inline-flex" stroke-linecap="round" stroke-linejoin="round" 
                              stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': ! open, 'inline-flex': open }" 
                              class="hidden" stroke-linecap="round" stroke-linejoin="round" 
                              stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu -->
    <div :class="{ 'block': open, 'hidden': ! open }" class="hidden sm:hidden ">
    <!-- Links -->
    <div class="pt-2 pb-3 space-y-1 ">
        <x-responsive-nav-link :href="route('dashboard')" 
                               :active="request()->routeIs('dashboard')" class="text-white">
            <i class="fas fa-tachometer-alt mr-2"></i> {{ __('Dashboard') }}
        </x-responsive-nav-link>



       

        
        <!-- Admin Dropdown (Optional for mobile) -->
        <div x-data="{ openAdmin: false }" class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600-1">
            <button @click="openAdmin = !openAdmin"
                class="flex items-center w-full px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200  rounded-lg transition text-white">
                <i class="fas fa-user-shield mr-2"></i> Menu
                <i class="fas fa-chevron-down ml-auto text-xs"></i>
            </button> 
            @if(Auth::user()->role === 'admin')
            <div x-show="openAdmin" class="mt-1 space-y-1 pl-6">
                <x-responsive-nav-link :href="route('admin.users')" 
                                       :active="request()->routeIs('admin.users')" class="text-white">
                    <i class="fas fa-user mr-2"></i> Users
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('categories.index')" 
                                       :active="request()->routeIs('categories.index')" class="text-white">
                    <i class="fas fa-envelope mr-2"></i> Category
                </x-responsive-nav-link>

                       
        <x-responsive-nav-link :href="route('crm.index')" 
                               :active="request()->routeIs('crm.index')" class="text-white">
            <i class="fas fa-users mr-2 "></i> CRM
        </x-responsive-nav-link>

        <x-responsive-nav-link :href="route('leads.dashboard')" 
                               :active="request()->routeIs('leads.dashboard')" class="text-white">
            <i class="fas fa-users mr-2"></i> Leads
        </x-responsive-nav-link>

        <x-responsive-nav-link :href="route('proposals.index')" 
                               :active="request()->routeIs('proposals.index')" class="text-white">
            <i class="fas fa-file mr-2"></i> Proposals
        </x-responsive-nav-link>
        @endif


          <x-responsive-nav-link :href="route('experience.index')" 
                               :active="request()->routeIs('experience.index')" class="text-white">
            <i class="fas fa-briefcase mr-2"></i> Experience Details
        </x-responsive-nav-link>

        <x-responsive-nav-link :href="route('broadcast.index')" 
                               :active="request()->routeIs('broadcast.index')" class="text-white">
            <i class="fas fa-envelope mr-2"></i> Broadcast Email
        </x-responsive-nav-link>
           
        </div>

       
    </div>

    <!-- User Info + Settings -->
    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
        <div class="px-4">
            <div class="font-medium text-base text-gray-800 dark:text-gray-200 text-white">
                {{ Auth::user()->name }}
            </div>
            <div class="font-medium text-sm text-gray-500 text-white">
                {{ Auth::user()->email }}
            </div>
        </div>

        <div class="mt-3 space-y-1">
            <x-responsive-nav-link :href="route('profile.edit')" class="text-white">
                {{ __('Profile') }}
            </x-responsive-nav-link>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();" class="text-white">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</div>

</nav>
