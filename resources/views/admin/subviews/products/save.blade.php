 @extends('admin.layout.template')

 @section('content')
     <form id="save-form">
         @csrf
         @foreach ($_locales as $locale)
             <div class="mb-3 mt-3">
                 <label class="form-label">Name - {{ $locale }}: <span class="text-danger">*</span></label>
                 <input type="text" class="form-control" placeholder="Product name" name="name:{{ $locale }}">
                 <div class="invalid-feedback"></div>
             </div>
         @endforeach

         <div class="mb-3">
             <label class="form-label">Price:</label>
             <input type="text" name="price" class="form-control">
             <div class="invalid-feedback"></div>
         </div>

         <div class="mb-3">
             <label class="form-label">Stock count:</label>
             <input type="text" name="stock_count" class="form-control">
             <div class="invalid-feedback"></div>
         </div>

         <div class="mb-3">
             <label class="form-label">Categories:</label>
             {!! RenderingHelper::renderCategoriesList($categories) !!}
             <div class="invalid-feedback"></div>
         </div>
         <button type="submit" class="btn btn-primary">Submit</button>
     </form>
 @endsection

 @section('scripts')
     <script>
         $(document).ready(function() {
             $("#save-form").on("submit", function(e) {
                 e.preventDefault();
                 $.ajax({
                     url: route("products.save"),
                     method: 'POST',
                     data: new FormData(this),
                     processData: false,
                     contentType: false,
                     success: function(response) {
                         // Do something ...
                     },
                     error: function(xhr) {
                         viewSaveErrorAlert(xhr.status);
                         if (xhr.status === 422) {
                             renderValidationErrors(xhr.responseJSON);
                         }
                     }
                 });
             });

             $("[name='categories[]']").on("change", function() {
                 const state = $(this).is(":checked");
                 const children_ids = JSON.parse($(this).attr("data-children-ids"));
                 const parents_ids = JSON.parse($(this).attr("data-parents-ids"));

                 for (let i = 0; i < children_ids.length; i++) {
                     const id = children_ids[i];
                     if (state) {
                         $(`[value='${id}']`).prop("checked", true);
                     } else {
                         $(`[value='${id}']`).prop("checked", false);
                     }
                 }

                 for (let i = 0; i < parents_ids.length; i++) {
                     const id = parents_ids[i];
                     if (state) {
                         $(`[value='${id}']`).prop("checked", true);
                     }
                 }
             });
         });
     </script>
 @endsection
