

<div 
x-data="{
    loading: false,
    data: null,
    notFound: false,
    async fetchMangas(){
        this.loading = true
        const url = '/manga-management/api/v1/manga'
        try {
            const response = await fetch(url)
            if(response){
                const responseData = await response.json()
                //console.log(responseData);
                if(responseData.status === 200){
                    this.data=responseData.data
                }
                else if(responseData.status === 404){
                    this.notFound = true
                }
                else{
                    throw new Error('INTERNAL SERVER ERROR')
                }
            }
        } catch (error) {
            console.log(error);
        }
        this.loading = false
    },
}"
x-init="fetchMangas()"
>
    <template x-if="data">
        <div 
        x-data="{mangas: data}"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
        >
            <template x-for="manga in mangas">
                <div 
                class="max-w-sm rounded overflow-hidden shadow-lg text-white bg-violet-950 hidden md:block hover:cursor-pointer hover:scale-110 transition-transform">
                    <img 
                    :src="manga.latest_cover_imgs" 
                    alt="Cover image"
                    class="w-full h-80 object-cover"
                    >
                    <div class="px-6 py-4">
                        <div 
                        class="font-bold text-xl mb-2"
                        x-text="manga.manga_title"
                        >
                        </div>
                        <div>
                            <p x-text="`Comprados: ${manga.bought_volumes}`"></p>
                            <p x-text="`Disponibles: ${manga.total_volumes}`"></p>
                        </div>
                    </div>
                </div>
            </template>
            <!-- Moviles -->
            <template x-for="manga in mangas">
                <div 
                class="max-w-sm rounded overflow-hidden shadow-lg text-white bg-violet-950 block sm:hidden hover:cursor-pointer hover:scale-110 transition-transform">
                    
                    <div class="w-full flex items-center">
                        <div class="w-2/5">
                            <img 
                            :src="manga.latest_cover_imgs" 
                            alt="Cover image"
                            class="w-full h-42 object-cover"
                            >
                        </div>
                        <div class="w-3/5">
                            <div 
                            class="font-bold text-xl mb-2 pl-2"
                            x-text="manga.manga_title"
                            >
                            </div>
                            <div class="pl-4">
                                <p x-text="`Comprados: ${manga.bought_volumes}`"></p>
                                <p x-text="`Disponibles: ${manga.total_volumes}`"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </template>

    <template x-if="notFound">
        <h3 class="text-white">No mangas found</h3>
    </template>

    <template x-if="loading">
        <h3 class="text-white">Loading...</h3>
    </template>
</div>