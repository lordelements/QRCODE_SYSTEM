   <!-- Button trigger modal -->
   <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirm-user-deletion">
       {{ __('Delete Account') }}
   </button>

   <!-- Modal -->
   <div class="modal fade" id="confirm-user-deletion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel">{{ __('Delete Account') }}</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="card-body p-3">
                   <form method="post" action="{{ route('admin.profile.delete') }}" class="p-6">
                       @csrf
                       @method('delete')

                       <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                           {{ __('Are you sure you want to delete your account?') }}
                       </h2>

                       <p  class="text-sm">
                           {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.
                             Please enter your password to confirm you would like to permanently delete your account.') }}
                       </p>

                       <div class="mt-6">
                           <label for="password" class="form-label">Password</label>
                           <div class="form-group">
                               <input id="password"
                                   name="password"
                                   type="password"
                                   class="mt-1 form-control"
                                   placeholder="{{ __('Password') }}"
                                   autocomplete="new-password" />
                               <span :messages="$errors->userDeletion->get('password')" class="mt-2"></span>
                           </div>
                       </div>

                       <div class="mt-2 flex justify-end">
                           <x-danger-button class="btn btn-primary">
                               {{ __('Delete Account') }}
                           </x-danger-button>
                           <x-danger-button  class="btn btn-secondary" data-bs-dismiss="modal">
                               {{ __('Close') }}
                           </x-danger-button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>