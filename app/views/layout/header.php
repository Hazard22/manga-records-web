
<header
x-data="{ 
    isScrolled: false 
}" 
x-init="
window.addEventListener('scroll', () => { 
    if (window.scrollY > 50) { 
        isScrolled = true 
    } else { 
        isScrolled = false 
    } 
})"
>
    <nav :class="isScrolled ? 'bg-blue-500 shadow-md' : 'bg-transparent'" class="fixed top-0 left-0 w-full p-4 transition-all duration-300">
        <div class="container mx-auto flex items-center justify-between">
            <a href="#" class="text-white text-2xl font-semibold" x-text="$store.headerTitle.title"></a>
            <?php if (isset($_SESSION['username'])): ?>
                <div class="flex gap-2">
                    <button
                    x-data="{
                        loading: false,
                        errorMessage: '',
                        logout() {
                            this.loading = true;
                            fetch('/manga-management/api/v1/logout', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                            })
                            .then(response => {
                                return response.json();
                            })
                            .then(data => {
                                if(data.status === 200){
                                    window.location.href = '/manga-management'
                                }
                            })
                            .catch(error => {
                                console.log('Error en la petición:', this.errorMessage);
                            })
                            .finally(() => {
                                this.loading = false;
                            });
                        },
                    }"
                    type="button"
                    x-on:click="logout()"
                    class="bg-red-500 p-2 rounded-md hover:bg-red-400 transition-color"
                    >
                    <span x-show="!loading" class="flex gap-4 content-center">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <p>Log out</p>
                    </span>
                    <span x-show="loading">
                        <i class="fa-solid fa-circle-notch fa-spin"></i>
                    </span>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </nav>
</header>
