
<div class="sm:mx-auto sm:w-full sm:max-w-sm">
  <img class="mx-auto h-10 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
  <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-white">Create new account</h2>
</div>

<div 
  x-data="{ 
    username: '', 
    password: '', 
    confpassword: '', 
    loading: false,
    touched: false, 
    error: null, 
    errorMessage: '',
    successSignUp () {
      Toastify({
        text: 'Sign up successfully, returning to login screen...',
        duration: 5000,
        position: 'center'
      }).showToast();
      setTimeout(() => {
        window.location.href = '/manga-management'
      }, 5000);
    },
    registerUser() {
      this.loading = true;
      fetch('/manga-management/api/v1/register', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json'
          },
          body: JSON.stringify({ username: this.username, password: this.password })
      })
      .then(response => {
          return response.json();
      })
      .then(data => {
          if(data.status === 201){
            this.successSignUp()
          }
          else{
            this.error = true 
            this.errorMessage = data.data
            setTimeout(() => {
              error = false
            }, 3000);
          }
      })
      .catch(error => {
          console.log('Error en la petición:', error.message);
      })
      .finally(() => {
          setTimeout(() => {
            this.errorMessage = ''
          }, 3500);
          this.loading = false;
      });
    } 
  }" 
  class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm"
  >
    <form
    class="space-y-6" 
    >
      <div>
        <label for="username" class="block text-sm/6 font-medium text-white">Username</label>
        <div class="mt-2">
          <input 
          type="text"
          id="username" 
          x-model="username" 
          @blur="touched = true"
          required 
          class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
        </div>
      </div>

      <p 
        x-show="touched && username === ''" 
        class="text-red-500"
        x-transition
        >
          This field is required.
      </p>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm/6 font-medium text-white">Password</label>
        </div>
        <div class="mt-2">
          <input 
          type="password" 
          id="password"
          x-model="password" 
          required 
          class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 transition-colors">
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="confpassword" class="block text-sm/6 font-medium text-white">Confirm password</label>
        </div>
        <div class="mt-2">
          <input 
          type="password" 
          id="confpassword"
          x-model="confpassword" 
          required 
          class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 transition-colors">
        </div>
      </div>

      <p 
      x-show="password !== '' && confpassword !== '' && password !== confpassword" 
      class="text-red-500"
      x-transition
      >
        Passwords not match.
      </p>
      

      <div>
        <button 
        x-bind:disabled="loading || password !== confpassword || username === '' || password === '' || confpassword === ''"
        x-on:click="registerUser()"
        type="button" 
        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:bg-gray-500 disabled:cursor-not-allowed transition-color"
        >
            <span x-show="!loading">
              Sign up
            </span>
            <span x-show="loading">
              <i class="fa-solid fa-circle-notch fa-spin"></i>
            </span>
        </button>
      </div>
      <p class="text-red-500 text-center"
      x-show="error"
      x-text="errorMessage"
      x-transition.duration.500ms
      ></p>
  </form>

</div>