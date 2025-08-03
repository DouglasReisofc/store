@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
           <!-- Seletor de Categoria -->
<div class="form-group">
    <label for="categorySelector">@lang('Selecione a categoria para mostrar as subcategorias')</label>
    <select id="categorySelector" class="form-control select2">
        <!--<option value="">@lang('Todas as Categorias')</option>-->
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ ($category->id == $categoryId) ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
    </select>
</div>

            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">

                            <thead>
                            <tr>
                             <th>@lang('Sub Category')</th>
                                <th>@lang('Category Name')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Sold')</th>
                                <th>@lang('Available')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($subCategories as $subCategory)
                            <tr>
                            

                            <td data-label="@lang('Category Name')">
                                    <span class="font-weight-bold">
                                        {{ __($subCategory->category->name) }}
                                    </span>
                                </td>


                            <td data-label="@lang('Sub Category')">
                            <span class="font-weight-bold" style="font-style: italic; color: #0051ff;">

                                    {{ __($subCategory->name) }}
                                    </span>
                                </td>

                                <td data-label="@lang('Price')">
                                    <span class="font-weight-bold" style="font-style: italic; color: #ff9100;">
                                        {{ showAmount($subCategory->price, 2) }}
                                        {{ __($general->cur_text) }}
                                    </span>
                                </td>


                                <td data-label="@lang('Sold')">
                                    {{ $subCategory->card->where('user_id', '!=', 0)->count() }}
                                    @lang('PS')
                                </td>

                                <td data-label="@lang('Available')">
                                <span class="font-weight-bold" style="color: {{ $subCategory->totalAvailableCards > 0 ? '#22a614' : '#FF0000' }};">
                                 {{ $subCategory->totalAvailableCards }} @lang('PS')
                                 </span>
                                </td>



                                <td data-label="@lang('Action')">
    <a href="#" class="icon-btn editBtn" data-toggle="tooltip" title="" data-original-title="@lang('Edit')"
       data-name="{{ $subCategory->name }}"
       data-sku="{{ $subCategory->sku }}"
       data-id="{{ $subCategory->id }}"
       data-price="{{ getAmount($subCategory->price, 2) }}"
       data-category="{{ $subCategory->category_id }}"
       data-image='{{ getImage(imagePath()["sub_category"]["path"]."/".$subCategory->image)}}'
       data-detalhes="{{ $subCategory->detalhes }}"> 
       <i class="las la-edit text--shadow"></i>
    </a>
    <a href="#" class="icon-btn deleteBtn bg--danger ml-2" data-toggle="tooltip" title="" data-original-title="@lang('Apagar')"
       data-name="{{ $subCategory->name }}"
       data-sku="{{ $subCategory->sku }}"
       data-id="{{ $subCategory->id }}"
       data-price="{{ getAmount($subCategory->price, 2) }}"
       data-category="{{ $subCategory->category_id }}"
       data-image='{{ getImage(imagePath()["sub_category"]["path"]."/".$subCategory->image)}}'>
       <i class="las la-trash text--shadow"></i>
    </a>
	
<a href="#" class="icon-btn cloneBtn bg--info ml-2" data-toggle="tooltip" title="" data-original-title="@lang('Clonar')"
   data-name="{{ $subCategory->name }}"
   data-sku="{{ $subCategory->sku }}"
   data-id="{{ $subCategory->id }}"
   data-price="{{ getAmount($subCategory->price, 2) }}"
   data-category="{{ $subCategory->category_id }}"
   data-image='{{ getImage(imagePath()["sub_category"]["path"]."/".$subCategory->image)}}'
   data-detalhes="{{ $subCategory->detalhes }}">
   <i class="las la-copy text--shadow"></i>
</a>

<a href="javascript:void(0)" class="icon-btn moveUpBtn ml-2" data-id="{{ $subCategory->id }}" title="@lang('Mover pra cima')">
    <i class="la la-arrow-up"></i>
</a>
<a href="javascript:void(0)" class="icon-btn moveDownBtn ml-2" data-id="{{ $subCategory->id }}" title="@lang('Mover pra baixo')">
    <i class="la la-arrow-down"></i>
</a>

	
</td>
</tr>
@empty
    <tr>
        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}!</td>
    </tr>
@endforelse


                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                   <!-- Removi a paginação -->

                </div>
            </div>
        </div>
    </div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Confirmation')!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.delete.sub.category') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>
    @lang('Você deseja realmente apagar esta subcategoria ?')<br>
    @lang('⚠️Devo lembrar você que ao apagar esta subcategoria, todas as contas ou cards vinculados a ela serão apagados também, Por isso sempre recomendamos editar ao invés de apagar caso não deseje perder dados de contas antigas')<br>
    @lang('tenha ciência disso ao confirmar !')
</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Cancelar')</button>
                    <button type="submit" class="btn btn--primary">@lang('Apagar')</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ADD METHOD MODAL -->
<div id="addModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Add New Sub Category')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.add.sub.category') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                    <div class="col-lg-12 form-group">
                     <label for="sku">@lang('SKU (opcional)')</label>
                     <input type="text" name="sku" id="sku" class="form-control" placeholder="@lang('Enter SKU')">
                         </div>

                        <div class="col-lg-12 form-group">
                            <label for="name">@lang('Category Name')</label>
                            <select name="category_id" id="category_id" class="select2-basic" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-12 form-group">
                            <label for="name">@lang('Sub Category Name')</label>
                            <input type="text" name="name" id="name" class="form-control" oninput="charRemaining('nameSpan', this.value, 191)" required>
                            <span id="nameSpan" class="remaining">
                                191 @lang('characters remaining')
                            </span>
                        </div>

                        <div class="col-lg-12 form-group">
                            <label for="name">@lang('Price')</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="price" aria-label="price" aria-describedby="basic-addon1" required>
                                <div class="input-group-append">
                                  <span class="input-group-text" id="basic-addon1">
                                      {{ __($general->cur_text) }}
                                  </span>
                                </div>
                              </div>
                        </div>

                        <div class="col-lg-12 form-group">
                            <label for="detalhes">@lang('Detalhes')</label>
                            <textarea rows="3" class="form-control border-radius-5" name="detalhes" placeholder="@lang('Detalhes')">{{ old('detalhes') }}</textarea>
                        </div>

                        <div class="col-lg-12 form-group mt-3">
                            <div class="image-upload">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="profilePicPreview" id="display_image">
                                                    <span class="size_mention"></span>
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="avatar-edit mt-35px">
                                        <input type="file" class="profilePicUpload" id="profilePicUpload" accept=".png, .jpg, .jpeg" name="image">
                                        <label for="profilePicUpload" id='image_btn' class="bg-primary">@lang('Select Image') </label>
                                        @lang('Supported image formats: .jpeg, .png, .jpg. Maximum size: 1438x905')
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--primary">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- EDIT METHOD MODAL -->
<div id="editModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Edit Sub Category')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.edit.sub.category') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                    <div class="col-lg-12 form-group">
    <label for="sku">@lang('SKU (opcional)')</label>
    <input type="text" class="form-control" name="sku" id="sku" placeholder="@lang('Enter SKU')" value="{{ old('sku') }}">
</div>

                        <div class="col-lg-12 form-group">
                            <label for="name">@lang('Category Name')</label>
                            <select name="category_id" class="select2-basic" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-lg-12 form-group">
                            <label for="editName">@lang('Sub Category Name')</label>
                            <input type="text" name="name" class="form-control" oninput="charRemaining('editNameSpan', this.value, 191)" required>
                            <span id="editNameSpan" class="remaining">
                                <span class="char">191</span> @lang('characters remaining')
                            </span>
                        </div>

                        <input type="hidden" name="id">

                        <div class="col-lg-12 form-group">
                            <label for="name">@lang('Price')</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="price" aria-label="price" aria-describedby="basic-addon1" required>
                                <div class="input-group-append">
                                  <span class="input-group-text" id="basic-addon1">
                                      {{ __($general->cur_text) }}
                                  </span>
                                </div>
                              </div>
                        </div>

                        <div class="col-lg-12 form-group">
                            <label for="detalhes">@lang('Detalhes')</label>
                            <textarea rows="3" class="form-control border-radius-5" name="detalhes" placeholder="@lang('Detalhes')">{{ old('detalhes') }}</textarea>
                        </div>

                        <div class="col-lg-12 form-group mt-3">
                            <div class="image-upload">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="profilePicPreview" id="display_image">
                                                    <span class="size_mention"></span>
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="avatar-edit mt-35px">
                                        <input type="file" class="profilePicUpload" id="profilePicUpload2" accept=".png, .jpg, .jpeg" name="image">
                                        <label for="profilePicUpload2" id='image_btn' class="bg-primary">@lang('Select Image') </label>
                                        @lang('Formatos de imagens suportadas: .jpeg, .png, .jpg. Tamanho Exato: 1438x905')
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--primary">@lang('Update')</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- CLONE METHOD MODAL -->
<div id="cloneModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('clone Sub Category')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.clone.sub.category') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <label for="name">@lang('Category Name')</label>
                            <select name="category_id" class="select2-basic" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-12 form-group">
                            <label for="cloneName">@lang('Sub Category Name')</label>
                            <input type="text" name="name" class="form-control" oninput="charRemaining('cloneNameSpan', this.value, 191)" required>
                            <span id="cloneNameSpan" class="remaining">
                                <span class="char">191</span> @lang('characters remaining')
                            </span>
                        </div>

                        <input type="hidden" name="id">

                        <div class="col-lg-12 form-group">
                            <label for="name">@lang('Price')</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="price" aria-label="price" aria-describedby="basic-addon1" required>
                                <div class="input-group-append">
                                  <span class="input-group-text" id="basic-addon1">
                                      {{ __($general->cur_text) }}
                                  </span>
                                </div>
                              </div>
                        </div>

                        <div class="col-lg-12 form-group">
                            <label for="detalhes">@lang('Detalhes')</label>
                            <textarea rows="3" class="form-control border-radius-5" name="detalhes" placeholder="@lang('Detalhes')">{{ old('detalhes') }}</textarea>
                        </div>

                        <div class="col-lg-12 form-group mt-3">
                            <div class="image-upload">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="profilePicPreview" id="display_image">
                                                    <span class="size_mention"></span>
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="avatar-clone mt-35px">
                                        <input type="file" class="profilePicUpload" id="profilePicUpload2" accept=".png, .jpg, .jpeg" name="image">
                                        <label for="profilePicUpload2" id='image_btn' class="bg-primary">@lang('Select Image') </label>
                                        @lang('Formatos de imagens suportadas: .jpeg, .png, .jpg. Tamanho Exato: 1438x905')
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--primary">@lang('Update')</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection


@push('breadcrumb-plugins')
    <button class="btn btn-sm btn--primary box--shadow1 text--small addNew" type="submit">
        <i class="las la-plus"></i>
        @lang('Add New')
    </button>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/common/common.js') }}"></script>
@endpush


@push('script')
    <script>
        (function ($) {
            "use strict";

            // Função para remover caracteres especiais ou pontos apenas do campo de nome
            function removeSpecialChars(input) {
                return input.replace(/[^a-zA-Z0-9 ]/g, '');
            }

            // Adiciona um evento de input ao campo de nome
            $('input[name=name]').on('input', function () {
                var nameInput = $(this);
                var nameSpan = $('#nameSpan');
                var cleanedValue = removeSpecialChars(nameInput.val());
                nameInput.val(cleanedValue);
                updateCharCount(nameInput, nameSpan);
            });

            // Função para atualizar a contagem de caracteres restantes
            function updateCharCount(input, span) {
                var remaining = 191 - input.val().length;
                span.text(remaining + ' @lang('characters remaining')');
            }

            $('#display_image').hide();

            $('#image_btn').on('click', function() {
                var classNmae = $('#display_image').attr('class');
                if(classNmae != 'profilePicPreview has-image'){
                    $('#display_image').hide();
                }else{
                    $('#display_image').show();
                }
            });

            $('.remove-image').on('click', function(){
                $('.profilePicPreview').hide();
            });

            $('.addNew').on('click', function () {
                var modal = $('#addModal');
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
                modal.modal('show');
            });

            $('.editBtn').on('click', function () {
                var modal = $('#editModal');

                // Obtenha os dados da subcategoria
                var subCategorySku = $(this).data('sku');
                var categoryName = $(this).data('category');
                var subCategoryName = $(this).data('name');
                var subCategoryId = $(this).data('id');
                var subCategoryPrice = $(this).data('price');
                var subCategoryImage = $(this).data('image');
                var subCategoryDetalhes = $(this).data('detalhes');
                

                // Preencha automaticamente os campos do formulário de edição
                modal.find('input[name=sku]').val(subCategorySku);
                modal.find('select[name=category_id]').val(categoryName).select2();
                modal.find('input[name=name]').val(subCategoryName);
                modal.find('input[name=id]').val(subCategoryId);
                modal.find('input[name=price]').val(subCategoryPrice);
                modal.find('.profilePicPreview').attr('style','background-image:url('+subCategoryImage+')');
                
                // Adicione esta parte para preencher automaticamente o campo detalhes
                modal.find('textarea[name=detalhes]').val(subCategoryDetalhes);

                // Atualize a contagem de caracteres restantes
                let length = parseInt(subCategoryName.length);
                modal.find('.char').text(191 - length);

                modal.modal('show');
            });
            
            
            $('.cloneBtn').on('click', function () {
                var modal = $('#cloneModal');

                // Obtenha os dados da subcategoria
                var subCategorySku = $(this).data('sku');
                var categoryName = $(this).data('category');
                var subCategoryName = $(this).data('name');
                var subCategoryId = $(this).data('id');
                var subCategoryPrice = $(this).data('price');
                var subCategoryImage = $(this).data('image');
                var subCategoryDetalhes = $(this).data('detalhes');

                // Preencha automaticamente os campos do formulário de edição
                modal.find('input[name=sku]').val(subCategorySku);
                modal.find('select[name=category_id]').val(categoryName).select2();
                modal.find('input[name=name]').val(subCategoryName);
                modal.find('input[name=id]').val(subCategoryId);
                modal.find('input[name=price]').val(subCategoryPrice);
                modal.find('.profilePicPreview').attr('style','background-image:url('+subCategoryImage+')');
                
                // Adicione esta parte para preencher automaticamente o campo detalhes
                modal.find('textarea[name=detalhes]').val(subCategoryDetalhes);

                // Atualize a contagem de caracteres restantes
                let length = parseInt(subCategoryName.length);
                modal.find('.char').text(191 - length);

                modal.modal('show');
            });
            
            $('.deleteBtn').on('click', function () {
                var modal = $('#deleteModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.modal('show');
            });

            $(document).ready(function() {
    // Função para mover subcategoria para cima
    $('.moveUpBtn').click(function() {
        var subCategoryId = $(this).data('id');
        $.post('{{ route('admin.moveup.sub.category') }}', {id: subCategoryId, _token: '{{ csrf_token() }}'}, function(data) {
            window.location.reload();
        });
    });

    // Função para mover subcategoria para baixo
    $('.moveDownBtn').click(function() {
        var subCategoryId = $(this).data('id');
        $.post('{{ route('admin.movedown.sub.category') }}', {id: subCategoryId, _token: '{{ csrf_token() }}'}, function(data) {
            window.location.reload();
        });
    });
});


    $(document).ready(function() {
        $('#categorySelector').change(function() {
            var categoryId = $(this).val();
            var url = new URL(window.location.href);
            url.searchParams.set('categoryId', categoryId);
            window.location.href = url.href;
        });
    });


        })(jQuery);
    </script>
@endpush


