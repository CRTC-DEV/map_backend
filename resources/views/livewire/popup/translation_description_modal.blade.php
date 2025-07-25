 <div wire:ignore.self class="modal fade" id="TranslationDescriptionModal" tabindex="-1"
     aria-labelledby="openTranslationDescriptionModalLabel" aria-hidden="true">
     <div class="modal-dialog" style="max-width: 80%; margin: auto;">
         <div class="modal-content">
             @if (Session::has('message'))
                 <div id="alert-message" class="alert alert-{{ Session::get('status') }}" role="alert">
                     {{ Session::get('message') }}
                 </div>
             @endif
             <div class="modal-header">
                 <h5 class="modal-title" id="openTranslationDescriptionModalLabel">Add Description Translation</h5>
                 <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <textarea type="text" wire:model.defer="translation_description.Translation" class="form-control"
                     placeholder="Enter translation" style="height: 350px;"></textarea>
                 @error('translation_description.Translation')
                     <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
                 <select name="translation_description.LanguageId" wire:model.defer="translation_description.LanguageId"
                     class="form-control form-select-sm" aria-label="Language select" style="min-width: 80px;">
                     <option value="{{ null }}" selected>Please Choose</option>
                     @foreach($language as $lang)
                        <option value="{{$lang->Id}}" selected>{{$lang->Name}}</option>
                        @endforeach
                 </select>
                 @error('translation_description.LanguageId')
                     <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
             </div>

             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary" wire:click="saveTranslationDescription">Save
                     Translation</button>
             </div>
         </div>
     </div>
 </div>

