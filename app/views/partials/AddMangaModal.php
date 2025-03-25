
<div x-data="{
        openModal: false
    }">
    <div class="fixed bottom-4 right-4">
        <button 
        x-data="{ isHover: false }"
        @mouseenter="isHover = true" 
        @mouseleave="isHover = false"
        x-on:click="openModal = true"
        class="w-12 hover:w-24 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full shadow-lg transition-all">
            <span class="text-sm">
                <i x-show="!isHover" class="fa-solid fa-plus"></i>
                <p x-show="isHover">Add Manga</p>
            </span>
        </button>
    </div>
    <div x-show="openModal" 
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    x-transition>
        <div class="bg-[#17153B] p-6 rounded-lg shadow-lg w-96">

            <div class="w-full flex justify-between text-white">
                <h2>Add new manga</h2>
                <button 
                type="button"
                @click="openModal = false" 
                class="rounded-md px-2 hover:bg-[#2E236C] transition-color">
                    <span><i class="fa-solid fa-xmark"></i></span>
                </button>
            </div>

            <div
            x-data="{
                title: '',
                banner_img: '',
                color: '#000000',
                touched: false,
                loading: false,
                addManga() {
                    this.loading = true
                    const body = this.banner_img.trim() === '' 
                    ? { title: this.title, color: this.color }
                    : { title: this.title, banner_img: this.banner_img, color: this.color }
                    this.loading = true;
                    fetch('/manga-management/api/v1/manga', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(body)
                    })
                    .then(response => {
                        return response.json();
                    })
                    .then(data => {
                        if(data.status === 201){
                            console.log(data)
                            window.location.reload()
                        }
                    })
                    .catch(error => {
                        console.log('Error en la petición:', error.message);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
                },
            }"
            class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm"
            >
            <form
            class="space-y-6" 
            >
                <div>
                    <label for="title" class="block text-sm/6 font-medium text-white">Title</label>
                    <div class="mt-2">
                    <input 
                    type="text"
                    id="title" 
                    x-model="title" 
                    @blur="touched = true"
                    required 
                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <p 
                    x-show="touched && title === ''" 
                    class="text-red-500"
                    x-transition
                    >
                    This field is required.
                </p>

                <div>
                    <label for="banner_img" class="block text-sm/6 font-medium text-white">Banner image</label>
                    <div class="mt-2">
                    <input 
                    type="text"
                    id="banner_img" 
                    x-model="banner_img"
                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div>
                    <label for="color" class="block text-sm/6 font-medium text-white">Banner color</label>
                    <div class="mt-2">
                    <input 
                    type="color"
                    id="color" 
                    x-model="color" 
                    @blur="touched = true"
                    required 
                    class="cursor-pointer bg-transparent border-none rounded-xl w-8 h-8 appearance-none">
                    </div>
                </div>

                <p 
                    x-show="touched && color === ''" 
                    class="text-red-500"
                    x-transition
                    >
                    This field is required.
                </p>

                <button
                x-bind:disabled="loading || title === '' || !touched"
                type="button"
                @click="addManga()"
                class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:bg-gray-500 disabled:cursor-not-allowed transition-color"
                >
                <span x-show="!loading">
                    Add 
                </span>
                <span x-show="loading">
                    <i class="fa-solid fa-circle-notch fa-spin"></i>
                </span>
                </button>
            </form>
            </div>
        </div>
    </div>
</div>