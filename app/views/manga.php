<div 
x-data="{
    manga_id: '<?php echo $id; ?>',
    data: null,
    loading: false,
    isScrolled: false,
    async init(){
        this.loading = true
        const url = `/manga-management/api/v1/manga/${this.manga_id}`
        try {
            const response = await fetch(url)
            if(response){
                const responseData = await response.json()
                console.log(responseData);
                if(responseData.status === 200){
                    this.data=responseData.data
                    window.addEventListener('scroll', () => { 
                        if (window.scrollY > 50) { 
                            this.isScrolled = true
                            $store.headerTitle.title = this.data.title
                        } else { 
                            this.isScrolled = false
                            $store.headerTitle.title = 'Manga Management'
                        } 
                    })
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
    }
}"
x-init="init()"
>
    <template
    x-if="data"
    >
    <div x-data="{manga: data}">
        <div 
        class="fixed z-[-1] top-0 right-0 w-full h-52 bg-gradient-to-l from-indigo-500 via-50% to-black to-100% rounded-b-xl"
        :style="`opacity: ${isScrolled ? '0%' : '100%'}; background-image: linear-gradient(to left, ${manga && manga.color ? manga.color : '#5d3c9e'}, 50%, black 100%)`"
        >
        </div>

        <div 
        >
            <h1 class="text-white" x-text="`${manga.title}`"></h1>
            <h2 class="text-white" x-text="`Tomos adquiridos: ${manga.bought_volumes}`"></h2>
            <h3 class="text-white" x-text="`Datos de manga: ${manga.total_volumes}`"></h3>
        </div>

        <div class="h-[1200px]">s </div>
    </div>
    </template>

    <template x-if="loading">
         <div class="text-center h-screen content-center">
            <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
         </div>
    </template>
    
</div>

