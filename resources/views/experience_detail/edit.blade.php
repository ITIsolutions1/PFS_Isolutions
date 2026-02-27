<x-app-layout>
    
    <div class="container mx-auto max-w-7xl py-6" id="app">
        <h1 class="text-2xl font-semibold mb-4">Edit</h1>
    
        <!-- Form to create a new experience detail -->
        <form method="POST" action="{{ route('experiences.update', $experienceDetail->id) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

             {{-- Masukkan semua query string sebagai hidden input --}}
@php
    $allQueryParams = request()->all(); // ambil semua query param, termasuk yang kosong
@endphp

@foreach ($allQueryParams as $key => $value)
    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
@endforeach

            <div>
                <label for="no_contract" class="block text-sm font-medium text-gray-700">No Contract</label>
                <input type="text" name="no_contract" id="no_contract" value="{{ old('no_contract', $experienceDetail->no_contract) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" >
            </div>            

            <div>
                <label for="project_name" class="block text-sm font-medium text-gray-700">Project Name</label>
                <input type="text" name="project_name" id="project_name" value="{{ old('project_name', $experienceDetail->project_name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            
    
            <div>
                <label for="client_name" class="block text-sm font-medium text-gray-700">Client Name</label>
                <input type="text" name="client_name" id="client_name" value="{{ old('client_name', $experienceDetail->client_name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
    
            
            <div class="grid gap-4 grid-cols-2">
    
                <div>
                    <label for="project_no" class="block text-sm font-medium text-gray-700">Project No</label>
                    <input type="text" name="project_no" id="project_no" value="{{ old('project_no', $experienceDetail->project_no) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
    
                <!--<div>-->
                <!--    <label for="kbli_number" class="block text-sm font-medium text-gray-700">KBLI Number</label>-->
                <!--    <input type="text" name="kbli_number" id="kbli_number" value="{{ old('kbli_number', $experienceDetail->kbli_number) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>-->
                <!--</div>-->
        
                <!--<div>-->
                <!--    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>-->
                <!--    <input type="text" name="status" id="status" value="{{ old('status', $experienceDetail->status) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>-->
                <!--</div>-->
                       
                       
                <div>
    <label for="kbli_number" class="block text-sm font-medium text-gray-700">KBLI Number</label>
    <select name="kbli_number" id="kbli_number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        <option value="" disabled <?php echo (empty($experienceDetail) ? 'selected' : ''); ?>>Choose KBLI Number</option>
        <option value="70209 - Management Consulting Activities" <?php echo ($experienceDetail == '70209 - Management Consulting Activities' ? 'selected' : ''); ?>>70209 - Management Consulting Activities</option>
        <option value="78101 - Domestic Labor Placement and Selection Activities" <?php echo ($experienceDetail == '78101 - Domestic Labor Placement and Selection Activities' ? 'selected' : ''); ?>>78101 - Domestic Labor Placement and Selection Activities</option>
        <option value="78200 - (Supporting) Temporary Labor Supply Activities" <?php echo ($experienceDetail == '78200 - (Supporting) Temporary Labor Supply Activities' ? 'selected' : ''); ?>>78200 - (Supporting) Temporary Labor Supply Activities</option>
        <option value="78300 - Human Resource Supply and Human Resource Management Activities" <?php echo ($experienceDetail == '78300 - Human Resource Supply and Human Resource Management Activities' ? 'selected' : ''); ?>>78300 - Human Resource Supply and Human Resource Management Activities</option>
        <option value="82302 - Special Event Organizer Services" <?php echo ($experienceDetail == '82302 - Special Event Organizer Services' ? 'selected' : ''); ?>>82302 - Special Event Organizer Services</option>
    </select>
</div>

        
                <div>
    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
    <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        <option value="" disabled <?php echo (empty($experienceDetail) ? 'selected' : ''); ?>>Choose status</option>
        <option value="Finish" <?php echo ($experienceDetail == 'Finish' ? 'selected' : ''); ?>>Finish</option>
        <option value="On Progress" <?php echo ($experienceDetail == 'On Progress' ? 'selected' : ''); ?>>On Progress</option>
    </select>
</div>
                       
              
                <div>
    <label for="locations" class="block text-sm font-medium text-gray-700">Location</label>
    <input type="text" name="locations" id="locations" value="{{ old('locations', $experienceDetail->locations) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
</div>


<div>
    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
    <select name="category" id="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        <option value="" disabled {{ old('category', $category) == '' ? 'selected' : '' }}>Choose category</option>
        <option value="801 Travel Arrangement" {{ old('category', $category) == '801 Travel Arrangement' ? 'selected' : '' }}>801 Travel Arrangement (Flight and Accommodations)</option>
        <option value="802 Marchandise/ATK" {{ old('category', $category) == '802 Marchandise/ATK' ? 'selected' : '' }}>802 Marchandise/ATK</option>
        <option value="803 Business Development" {{ old('category', $category) == '803 Business Development' ? 'selected' : '' }}>803 Business Development</option>        
        <option value="804 IT" {{ old('category', $category) == '804 IT' ? 'selected' : '' }}>804 IT</option>
        <option value="805 Manpower Supply" {{ old('category', $category) == '805 Manpower Supply' ? 'selected' : '' }}>805 Manpower Supply</option>
        <option value="806 Event Organizer" {{ old('category', $category) == '806 Event Organizer' ? 'selected' : '' }}>806 Event Organizer</option>
        <option value="807 Printing" {{ old('category', $category) == '807 Printing' ? 'selected' : '' }}>807 Printing</option>
        <option value="808 Car Rental" {{ old('category', $category) == '808 Car Rental' ? 'selected' : '' }}>808 Car Rental</option>
        <option value="809 Company Loan" {{ old('category', $category) == '809 Company Loan' ? 'selected' : '' }}>809 Company Loan</option>
        <option value="809 Moving Office" {{ old('category', $category) == '809 Moving Office' ? 'selected' : '' }}>809 Moving Office</option>
        <option value="809 Others" {{ old('category', $category) == '809 Others' ? 'selected' : '' }}>809 Others</option>
        <option value="810 Rent Building" {{ old('category', $category) == '810 Rent Building' ? 'selected' : '' }}>810 Rent Building</option>
    </select>
</div>



<div>
    <label for="amount" class="block text-sm font-medium text-gray-700">Amount Contract</label>
    <input type="text" name="amount" id="amount" value="{{ old('amount', $experienceDetail->amount) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" >
</div>

</div>




            <!-- <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
            
            <div class="grid grid-cols-4 gap-4">
                
                <div class="flex gap-2"  v-for="(category, index) in categories" :key='category.id'>               
                    <input type="text" name="categories[]" id="category"  :placeholder="'category ' + (index + 1)" :value="category.value" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <div class="flex items-center">
                            <button @click="removeInput1(category.id)" type="button" class="w-full sm:w-auto rounded-full bg-blue-500 px-3.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                -
                            </button>
                        </div>
                </div>  
            </div>
            <div class="button ms-1 col-md-1">
                <button @click="addInput1" type="button" class="w-full sm:w-auto rounded-full bg-blue-500 px-3.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">+</button>
            </div> -->
    
    
            <div class="flex gap-4">
                <div>
                    <label for="date_project_start" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" name="date_project_start" id="date_project_start" value="{{ old('date_project_start', $experienceDetail->date_project_start) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
    
                <div>
                    <label for="date_project_end" class="block text-sm font-medium text-gray-700">End Date</label>
                    <input type="date" name="date_project_end" id="date_project_end" value="{{ old('date_project_end', $experienceDetail->date_project_end) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div>
                    <label for="durations" class="block text-sm font-medium text-gray-700">Durations</label>
                    <input type="text" name="durations" id="durations" value="{{ old('durationss', $experienceDetail->durations) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
           </div>
    
            <!-- <div>
                <label for="scope_of_work" class="block text-sm font-medium text-gray-700">Scope of Work (max 3 lines)</label>
                <textarea name="scope_of_work" id="scope_of_work" value="{{ old('scope_of_work', $experienceDetail->scope_of_work) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
            </div> -->
    
<div>
    <label for="scope_of_work" class="block text-sm font-medium text-gray-700">
        Scope of Work (max 3 lines)
    </label>

    <input id="scope_of_work" type="hidden" 
        name="scope_of_work"
        value="">

    <trix-editor 
        id="trix_scope"
        input="scope_of_work"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-white">
    </trix-editor>
</div>

<link rel="stylesheet" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

<script>
document.addEventListener("trix-initialize", function () {
    let content = `{!! old('scope_of_work', $experienceDetail->scope_of_work) !!}`;

    document.getElementById("scope_of_work").value = content;
    document.querySelector("#trix_scope").editor.loadHTML(content);
});
</script>

<style>
    trix-editor ul {
        list-style-type: disc !important;
        margin-left: 20px !important;
    }

    trix-editor ol {
        list-style-type: decimal !important;
        margin-left: 20px !important;
    }

    trix-editor li {
        display: list-item !important;
    }
</style>







            {{-- <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Upload Images</label>
                <input type="file" name="image[]" id="image" accept="image/*" onchange="previewImages(event)" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" multiple>
            </div> --}}
            
            {{-- =============== TUTUP SEMENTARA ======================= --}}
            {{-- <div class="kontainer_upload_image grid grid-cols-3 gap-2">
                <div class="flex" v-for="(image, index) in images" :key='image.id' >
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700" v-text="'image (max 6 MB)'"></label>
                        <input @change="previewImage(image.id, $event)" type="file" name="images[]" :id='"image" + (index + 1)' accept="image/*" class="mt-1 block w-80 border-gray-300 rounded-md shadow-sm">
                    </div>       
                    <div class="flex items-center">
                        <button @click="removeInput2(image.id)" type="button" class="w-full sm:w-auto rounded-full bg-blue-500 px-3.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            -
                        </button>
                    </div>
                </div>
            </div>
    
            <div class="button ms-1 col-md-1">
                <button @click="addInput2" type="button" class="w-full sm:w-auto rounded-full bg-blue-500 px-3.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">+</button>
            </div> --}}
    
            {{-- BAGIAN PREVIEW GAMBAR  --}}
            {{-- =============== TUTUP SEMENTARA ======================= --}}
            {{-- <div id="image-preview-container" class="grid grid-cols-10 gap-4 mt-4">
                <div v-for="(preview, id) in previews" :key='id'>
                    <img :src='preview' alt="image preview"class="w-32 h-32 object-cover rounded-md shadow-md">
                </div>
            </div> --}}
    
           <div class="kontainer_upload_image grid grid-cols-3 gap-2">
    <!-- Iterasi untuk menampilkan input gambar dan preview -->
    <div class="flex" v-for="(image, index) in images" :key='image.id'>
        <div :id='image.id'>
            <label for="image" class="block text-sm font-medium text-gray-700" v-text="'Image (max 6 MB) ' "></label>
            <!-- Input untuk upload gambar -->
            {{-- <input type="hidden" name="image_id" :value='image.id' :id='image.id'> --}}
            <input 
                {{-- @change="previewImage(image.id, $event)"  --}}
                @change="previewImage(inndex, $event)" 
                type="file" 
                name="images[]" 
                :id="'image' + (index + 1)" 
                accept="image/*" 
                class="mt-1 block w-80 border-gray-300 rounded-md shadow-sm"
            >
        </div>
        
        <!-- Tampilkan gambar sebelumnya jika ada -->
        {{-- <div v-if="image.preview" class="mt-2">
            <img :src="image.preview" alt="image preview" class="w-32 h-32 object-cover rounded-md shadow-md">
        </div> --}}
        
        <!-- Tombol untuk menghapus gambar -->
        <div class="flex items-center">
            <button @click="removeInput2(image.id)" type="button" class="w-full sm:w-auto rounded-full bg-red-500 px-3.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-red-600">
                -
            </button>
        </div>
    </div>
    <div id="for_delete">

    </div>
</div>

<!-- Tombol untuk menambah input gambar baru -->
<div class="button ms-1 col-md-1">
    <button @click="addInput2" type="button" class="w-full sm:w-auto rounded-full bg-blue-500 px-3.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
        +
    </button>
</div>

{{-- BAGIAN PREVIEW GAMBAR --}}
<div id="image-preview-container" class="grid grid-cols-10 gap-4 mt-4">
    <!-- Preview gambar yang baru di-upload -->
    <div v-for="(preview, id) in previews" :key='id'>
        <div class="flex-row">
            <div class="flex justify-center">
              
            </div>
            <img :src='preview.path' alt="image preview" class="w-32 h-32 object-cover rounded-md shadow-md mt-3">
        </div>
        
    </div>
</div>

    
            <div class="max-w-60">
                <button type="submit" class="mt-4 w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Save</button>
            </div>
        </form>
    </div>
    
    <script>
    
    
          const {
                createApp
            } = Vue
    
            createApp({
                data() {
                    return {
                        categories: [],
                        images: [],
                        previews: [],
                        index_for_prviews: 6                   
                    }
                },
                mounted() {
                    this.fetchData();
                },
                methods: {
                    fetchData() {
                        fetch("{{ route('edit_api', ['id' => $experienceDetail->id]) }}")
                        .then(response => response.json())
                        .then(data => {
                            array_categories = data.category.split("|");
                            // for(let index in array_categories){
                            //     console.log("ini" + array_categories[index])
                            // }
                            let number = 0
                            array_categories.forEach(category => {
                                this.categories.push({
                                    id: number += 1,
                                    value: category,
                                })
                            }); 
                            let number2 = 0;
                           data.images.forEach(image => {
                            this.images.push({
                                id: image.id,
                                vue_id: number += 1,
                                image: image.foto
                            })
                            // this.previews[image.id] = {{ Storage::url('') }} + image.foto
                            this.previews.push({
                                id: image.id,
                                path: {{ Storage::url('') }} + image.foto,
                            })
                           })
                           console.log(this.previews)
                        })
                    },
                    addInput1(index) {
                        this.categories.push({
                            id: Date.now()                        
                        });
                    },
                    removeInput1(id) {
                        // versi arrow function
                        this.categories = this.categories.filter(category => category.id !== id)
                        console.log(this.categories)
                    },
                    addInput2() {
                        if(this.images.length !== 5){
                            this.images.push({
                            id: Date.now()                        
                        })
                        } else {
                            alert("maksimum upload 3 images")
                        }
                        
                        console.log(this.previews);
                    },
                    removeInput2(id) {
                        // versi fungsi anonim
                        // this.images = this.images.filter(function(category){
                        //     image.id !== id
                        // });
                        const existingPreviewIndex = this.previews.findIndex(preview => preview.id === id);
                            if (existingPreviewIndex !== -1) { 
                                $('#for_delete').append(` <input type="hidden" name="images_id_delete[]" value="${id}">`);
                                this.previews.splice(existingPreviewIndex, 1)
                                console.log(this.previews)                                
                            }

                        this.images = this.images.filter(image => image.id !== id)
                        delete this.previews[id];
                        // console.log()
                    },
                    previewImage(id, event) {
                        // $('#' + id).append(` <input type="hidden" name="images_id[]" value="${id}">`);
                        const file = event.target.files[0];
                        if (file && file.type.startsWith("image/")) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                const existingPreviewIndex = this.previews.findIndex(preview => preview.id === id);
                                if (existingPreviewIndex !== -1) { 
                                    $('#' + id).append(` <input type="hidden" name="images_id[]" value="${id}">`);                   
                                    this.previews[existingPreviewIndex].path = e.target.result;
                                } else {
                                    this.previews.push({
                                        id: this.index_for_prviews += 1,
                                        path: e.target.result
                                    })
                                }
                            //    this.previews[id] = e.target.result
                            console.log(e.target.result)
                            };
                            reader.readAsDataURL(file);
                        }
                        console.log(this.previews);
                        
                    }
                    
                }
            }).mount('#app')
    
        //     function previewImages(event) {
        //         const files = event.target.files;
        //         const previewContainer = document.getElementById('image-preview-container');
                
        //         // Kosongkan kontainer sebelum menambahkan preview baru
        //         previewContainer.innerHTML = '';
    
        //         // Loop melalui file yang diunggah
        //         Array.from(files).forEach(file => {
        //             if (file.type.startsWith('image/')) {
        //                 const reader = new FileReader();
    
        //                 reader.onload = function (e) {
        //                     const img = document.createElement('img');
        //                     img.src = e.target.result; // URL hasil membaca file
        //                     img.alt = file.name;
        //                     img.classList.add('w-32', 'h-32', 'object-cover', 'rounded-md', 'shadow-md'); // TailwindCSS
        //                     previewContainer.appendChild(img);
        //                 };
    
        //                 reader.readAsDataURL(file); // Membaca file sebagai Data URL
        //             }
        //         });
        // }
    
    
    </script>



    </x-app-layout>
    