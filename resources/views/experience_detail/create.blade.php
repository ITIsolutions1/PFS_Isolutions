<x-app-layout>
    
<div class="container mx-auto max-w-7xl py-6" id="app">
    <h1 class="text-2xl font-semibold mb-4">Create New Experience Detail</h1>

    <!-- Form to create a new experience detail -->
    <form method="POST" action="{{ route('experiences.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="project_name" class="block text-sm font-medium text-gray-700">Project Name</label>
            <input type="text" name="project_name" id="project_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label for="client_name" class="block text-sm font-medium text-gray-700">Client Name</label>
            <input type="text" name="client_name" id="client_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        
        <div class="grid gap-4 grid-cols-2">

            <div>
                <label for="project_no" class="block text-sm font-medium text-gray-700">Project No</label>
                <input type="text" name="project_no" id="project_no" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <!--<div>-->
            <!--    <label for="kbli_number" class="block text-sm font-medium text-gray-700">KBLI Number</label>-->
            <!--    <input type="text" name="kbli_number" id="kbli_number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>-->
            <!--</div>-->
    
            <!--<div>-->
            <!--    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>-->
            <!--    <input type="text" name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>-->
            <!--</div>-->
            
            <div>
    <label for="kbli_number" class="block text-sm font-medium text-gray-700">KBLI Number</label>
    <select name="kbli_number" id="kbli_number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        <option value="" disabled selected>Choose KBLI Number</option>
        <option value="70209 - Management Consulting Activities">70209 - Management Consulting Activities</option>
        <option value="78101 - Domestic Labor Placement and Selection Activities">78101 - Domestic Labor Placement and Selection Activities</option>
        <option value="78200 - (Supporting) Temporary Labor Supply Activities">78200 - (Supporting) Temporary Labor Supply Activities</option>
        <option value="78300 - Human Resource Supply and Human Resource Management Activities">78300 - Human Resource Supply and Human Resource Management Activities</option>
        <option value="82302 - Special Event Organizer Services">82302 - Special Event Organizer Services</option>
    </select>
</div>



    
            <div>
    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
    <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        <option value="" disabled selected>Choose status</option>
        <option value="Finish">Finish</option>
        <option value="On Progress">On Progress</option>
    </select>
</div>
    
           
          
            <div>
                <label for="locations" class="block text-sm font-medium text-gray-700">Location</label>
                <input type="text" name="locations" id="locations" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div>
    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
    <select name="category" id="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        <option value="" disabled selected>Choose category</option>
        <option value="801 Travel Arrangement">801 Travel Arrangement (Flight and Accommodations)</option>
        <option value="802 Merchandise/ATK">802 Merchandise/ATK</option>
        <option value="803 Business Development">803 Business Development</option>        
        <option value="804 IT">804 IT</option>        
        <option value="805 Manpower Supply">805 Manpower Supply</option>
        <option value="806 Event Organizer">806 Event Organizer</option>
        <option value="807 Printing">807 Printing</option>
        <option value="808 Car Rental">808 Car Rental</option>
        <option value="809 Company Loan">809 Company Loan</option>
        <option value="809 Moving Office">809 Moving Office</option>
        <option value="809 Others">809 Others</option>
        <option value="810 Rent Building">810 Rent Building</option>
    </select>
</div>

<div>
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount Contract</label>
                <input type="text" name="amount" id="amount" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

</div>

          
          
    


        <div class="flex gap-4">
            <div>
                <label for="date_project_start" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" name="date_project_start" id="date_project_start" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div>
                <label for="date_project_end" class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" name="date_project_end" id="date_project_end" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div>
                <label for="durations" class="block text-sm font-medium text-gray-700">Durations (Month)</label>
                <input type="text" name="durations" id="durations" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
       </div>

        <!-- <div>
            <label for="scope_of_work" class="block text-sm font-medium text-gray-700">Scope of Work (max 3 lines)</label>
            <textarea name="scope_of_work" id="scope_of_work" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
        </div> -->

<div>
    <label for="scope_of_work" class="block text-sm font-medium text-gray-700">
        Scope of Work (max 3 lines)
    </label>

    <!-- Hidden input yang menyimpan value -->
    <input id="scope_of_work" 
           type="hidden" 
           name="scope_of_work"
           value="{{ old('scope_of_work', $experienceDetail->scope_of_work ?? '') }}">

    <!-- Editor TRIX -->
    <trix-editor 
        input="scope_of_work"
        class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm">
    </trix-editor>
</div>

<!-- TRIX CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

<!-- Fix untuk bullet list & numbering hilang -->
<style>
    trix-editor ul {
        list-style-type: disc !important;
        margin-left: 18px !important;
    }
    trix-editor ol {
        list-style-type: decimal !important;
        margin-left: 18px !important;
    }
    trix-editor li {
        display: list-item !important;
    }

    /* Optional: height biar mirip 3 baris */
    trix-editor {
        min-height: 70px;
        max-height: 120px;
        overflow-y: auto;
    }
</style>

        
        <div class="kontainer_upload_image grid grid-cols-3 gap-2">
            <div class="flex" v-for="(image, index) in images" :key='image.id' >
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700" v-text="'image (max 6 MB) ' "></label>
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
        </div>

        {{-- BAGIAN PREVIEW GAMBAR  --}}
        <div id="image-preview-container" class="grid grid-cols-10 gap-4 mt-4">
            <div v-for="(preview, id) in previews" :key='id'>
                <img :src='preview' alt="image preview"class="w-32 h-32 object-cover rounded-md shadow-md">
            </div>
        </div>

       

        <div class="max-w-60">
            <button type="submit" class="mt-4 w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Create Experience Detail</button>
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
                    categories: [{
                        id: Date.now()                        
                    }],
                    images: [{
                        id: Date.now()                        
                    }],
                    previews: {}                   
                }
            },
            methods: {
                addInput1(index) {
                    this.categories.push({
                        id: Date.now()                        
                    });
                },
                removeInput1(id) {
                    // versi arrow function
                    this.categories = this.categories.filter(category => category.id !== id)
                    console.log(id)
                },
                addInput2() {
                    if(this.images.length !== 5){
                        this.images.push({
                        id: Date.now()                        
                    })
                    } else {
                        alert("maksimum upload 5 images")
                    }
                    
                    console.log(this.images.length)
                },
                removeInput2(id) {
                    // versi fungsi anonim
                    // this.images = this.images.filter(function(category){
                    //     image.id !== id
                    // });

                    this.images = this.images.filter(image => image.id !== id)
                    delete this.previews[id];
                },
                previewImage(id, event) {
                    const file = event.target.files[0];
                    if (file && file.type.startsWith("image/")) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                           this.previews[id] = e.target.result
                        };
                        reader.readAsDataURL(file);
                    }
                    console.log(this.previews);
                }
                
            }
        }).mount('#app')



</script>
</x-app-layout>
