
<div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-10 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-white">Sign in to your account</h2>
</div>

<div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm"
x-data="{
 username: '',
 password: '',
 loading: false, 
 userNotExists: false,
 wrongPass: false,
 login() {
  this.loading = true;
  this.userNotExists = false;
  this.wrongPass = false;
  fetch('/manga-management/api/v1/login', {
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
      if(data.status === 200){
        window.location.href = data.redirect
      }
      else{
        if(data.status === 404){
          this.userNotExists = true;
        }
        else if (data.status === 401){
          this.wrongPass = true;
        }
        else{
          throw new Error('Internal server error')
        }
      }
  })
  .catch(error => {
      console.log('Error on request:', error.message);
  })
  .finally(() => {
      this.loading = false;
  });
 }
}" 
>
  <form class="space-y-6">
    <div>
      <label for="username" class="block text-sm/6 font-medium text-white">Username</label>
      <div class="mt-2">
        <input 
        type="text" 
        id="username"
        x-model="username" 
        required 
        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
      </div>
      <p
      x-show="userNotExists"
      class="text-red-500 mt-2"
      x-transition.duration.500ms
      >
        User with this nickname doesn't exist.
      </p>
    </div>

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
      <p
      x-show="wrongPass"
      class="text-red-500 mt-2"
      x-transition.duration.500ms
      >
        Password is incorrect.
      </p>
    </div>

    <div x-data="{ loading: false }">
      <button 
      x-bind:disabled="loading || username === '' || password === ''"
      x-on:click="login()"
      type="button" 
      class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:bg-gray-500 disabled:cursor-not-allowed transition-color"
      >
          <span x-show="!loading">
            Sign in
          </span>
          <span x-show="loading">
            <i class="fa-solid fa-circle-notch fa-spin"></i>
          </span>
      </button>
    </div>
  </form>

  <div
  class="mt-4 text-center"
  >
    <p class="text-white mx-auto">Don't have an account?, 
      <a href="register" class="text-indigo-600 hover:text-indigo-500 transition-color">Sign up</a>
    </p>
  </div>

</div>