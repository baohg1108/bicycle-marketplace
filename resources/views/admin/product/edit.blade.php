@extends('admin.layouts.app')
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css" />

    <style>
        .dropzone {
            border: 2px dashed #ccc;
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            background: #f8f9fa;
            margin-bottom: 20px;
        }

        .dropzone.dz-drag-hover {
            border-color: #2196F3;
            background: fixed #e3f2fd;
        }

        .image-preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .image-preview-item {
            position: relative;
            padding: 5px;
            boder: 1px solid #ddd;
            border-radius: 4px;
            corsor: move;
        }

        .image-preview-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
        }

        .image-preview-item .remove-image {
            position: absolute;
            top: -10px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50;
            width: 24px;
            height: 24px;
            text-align: center;
            line-height: 24px;
            cursor: pointer;
        }

        .image-preview-loader {
            position: relative;
            width: 100%;
            height: 150px;
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 1.5s infinite;
        }

        .image-preview-loader::after {
            content: "Uploading...";
            color: #666;
        }

        @keyframes pulse {
            0% {
                opacity: 0.6;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0.6;
            }
        }
    </style>
@endpush

@section('contents')
    <div class="container-xl">
        <form action="" class="product-form">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        {{-- <div class="card-header">
                        <h3 class="card-title">Create Roles</h3>
                        <div class="card-actions">
                            <a href="{{ route('admin.role.index') }}" class="btn btn-primary">Back</a>
                        </div>
                    </div> --}}
                        <div class="card-body">

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label required">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder=""
                                        value="{{ $product->name }}">
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label required">Slug</label>
                                    <input type="text" class="form-control" name="slug" id="slug" placeholder=""
                                        value="{{ $product->slug }}">
                                    <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label required">Short Description</label>
                                    <textarea name="short_description" id="short-editor">{!! $product->short_description !!}</textarea>
                                    <x-input-error :messages="$errors->get('short_description')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label required">Content</label>
                                    <textarea name="content" id="editor">{!! $product->description !!}</textarea>
                                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                                </div>
                            </div>

                        </div>

                        <div class="card">
                            <div class="card-header">
                                Overview
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">SKU</label>
                                            <input type="text" class="form-control" name="sku"
                                                value="{{ $product->sku }}">
                                            <x-input-error :messages="$errors->get('sku')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Price</label>
                                            <input type="text" class="form-control" name="price"
                                                value="{{ $product->price }}">
                                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Special Price</label>
                                            <input type="text" class="form-control" name="special_price"
                                                value="{{ $product->special_price }}">
                                            <x-input-error :messages="$errors->get('special_price')" class="mt-2" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">From Date</label>
                                            <input type="text" class="form-control datepicker" name="from_date"
                                                value="{{ $product->special_price_start }}">
                                            <x-input-error :messages="$errors->get('from_date')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">To Date</label>
                                            <input type="text" class="form-control datepicker" name="to_date"
                                                value="{{ $product->special_price_end }}" id="datepicker-tow">
                                            <x-input-error :messages="$errors->get('to_date')" class="mt-2" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-check">
                                                    <input class="form-check-input manage-stock-check" name="manage_stock"
                                                        type="checkbox" @checked('$product->manage_stock' == 'yes')>
                                                    <span class="form-check-label">Manage Stock</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div
                                            class="col-md-12 manage-stock {{ $product->manage_stock == 'yes' ? '' : 'd-none' }}">
                                            <div class="mb-3">
                                                <label class="form-label">Quantity</label>
                                                <input type="text" class="form-control" name="quantity"
                                                    value="{{ $product->qty }}">
                                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <h3 class="card-title">Stock Status</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="stock_status" @checked($product->in_stock == 1)
                                                                value="in_stock">
                                                            <span class="form-check-label">In Stock</span>
                                                        </label>
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="stock_status" @checked($product->in_stock == 0)
                                                                value="out_of_stock">
                                                            <span class="form-check-label">Out Of Stock</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Product Images --}}
                    <div class="card" id="product-images">
                        <div class="card-header">
                            <h3 class="card-title">Product Image</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div id="imageUploader" class="dropzone">
                                        <div id="imagePreviewContainer" class="image-preview-container">
                                            @foreach ($product?->images ?? [] as $image)
                                                <div class="image-preview-item" data-image-id="{{ $image->id }}">
                                                    <img src="{{ asset($image->path) }}">
                                                    <span class="remove-image"
                                                        data-image-id="{{ $image->id }}">&times;</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Product Attributes --}}
                    <div class="card mt-3" id="product-attributes">
                        <div class="card-header">
                            <h3 class="card-title">Product Attributes</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="accordion" id="accordion-default">

                                </div>
                                <button class="btn btn-primary mt-3" type="button" id="add-attribute-btn">Add
                                    Attribute</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Status</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <select name="status" class="form-control" id="">
                                        <option @selected($product->status == 'active') value="active">Active</option>
                                        <option @selected($product->status == 'inactive') value="inactive">Inactive</option>
                                        <option @selected($product->status == 'draft') value="draft">Draft</option>
                                        <option @selected($product->status == 'pending') value="pending">Pending</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Store</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <select name="store" class="form-control select2" id="">
                                        <option value="">Select a store</option>
                                        @foreach ($stores as $store)
                                            <option @selected($product->store_id == $store->id) value="{{ $store->id }}">
                                                {{ $store->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('store')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Is Featured</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-check form-switch form-switch-3">
                                        <input class="form-check-input" @checked($product->is_featured == 1) type="checkbox"
                                            name="is_featured">
                                        <span class="form-check-label">Enable</span>
                                    </label>
                                    <x-input-error :messages="$errors->get('is_featured')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Categories</h3>
                        </div>
                        <div class="card-body" style="height: 400px; overflow-y: scroll;">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="category-search"
                                            placeholder="Search Category">
                                    </div>
                                    <ul class="list-unstyled " id="category-tree">
                                        @foreach ($categories as $category)
                                            <li>
                                                <label for="" class="form-check category-wrapper">
                                                    <input type="checkbox" class="form-check-input category-check"
                                                        name="categories[]" value="{{ $category->id }}"
                                                        @checked(in_array($category->id, $productCategoryIds))>
                                                    <span
                                                        class="form-check-label category-label">{{ $category->name }}</span>
                                                </label>
                                                @if ($category->children_nested && $category->children_nested->count() > 0)
                                                    <ul class="list-unstyled ms-4 mt-2">
                                                        @foreach ($category->children_nested as $child)
                                                            <li>
                                                                <label for="" class="form-check category-wrapper">
                                                                    <input type="checkbox"
                                                                        class="form-check-input category-check"
                                                                        name="categories[]" value="{{ $child->id }}"
                                                                        @checked(in_array($child->id, $productCategoryIds))>
                                                                    <span
                                                                        class="form-check-label category-label">{{ $child->name }}</span>
                                                                </label>
                                                                @if ($child->children_nested && $child->children_nested->count() > 0)
                                                                    <ul class="list-unstyled ms-4 mt-2">
                                                                        @foreach ($child->children_nested as $subChild)
                                                                            <li>
                                                                                <label for=""
                                                                                    class="form-check category-wrapper">
                                                                                    <input type="checkbox"
                                                                                        class="form-check-input category-check"
                                                                                        name="categories[]"
                                                                                        value="{{ $subChild->id }}"
                                                                                        @checked(in_array($subChild->id, $productCategoryIds))>
                                                                                    <span
                                                                                        class="form-check-label category-label">{{ $subChild->name }}</span>
                                                                                </label>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Brand</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <select name="brand" class="form-control select2" id="">
                                        <option value="">Select a brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}" @selected($product->brand_id == $brand->id)>
                                                {{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Label</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_hot"
                                            @checked($product->is_hot)>
                                        <span class="form-check-label">Hot</span>
                                    </label>
                                    <label class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_new"
                                            @checked($product->is_new)>
                                        <span class="form-check-label">New</span>
                                    </label>
                                    <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Tags</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <select name="tags[]" class="form-control select2" id=""
                                        multiple="multiple">
                                        @foreach ($tags as $tag)
                                            <option @selected(in_array($tag->id, $productTagIds)) value="{{ $tag->id }}">
                                                {{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('tags')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="mb-3 row">
                                    <button class="btn btn-primary mt-3" type="submit">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
    </div>
@endsection


@push('scripts')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr"></script>

    <script>
        $(function() {

            const pickerInstances = {};

            let uniqueCounter = 0;

            function generateUniqueId(prefix = "picker-") {
                uniqueCounter++;
                return prefix + uniqueCounter + "-" + Date.now();
            }

            function createPicker(pickerId, defaultColor, inputSelector) {
                if (pickerInstances[pickerId]) {
                    pickerInstances[pickerId].destroyAndRemove();
                }

                const picker = Pickr.create({
                    el: `#${pickerId}`,
                    theme: 'classic',
                    default: defaultColor || '#42445A',
                    components: {
                        preview: true,
                        opacity: true,
                        hue: true,
                        interaction: {
                            hex: true,
                            rgba: true,
                            input: true,
                            clear: true,
                            save: true
                        }
                    }
                });

                picker.on("change", (color) => {
                    const selectedColor = color.toHEXA().toString();
                    $(`#${pickerId}`).css('background-color', selectedColor);
                    $(`${inputSelector}`).val(selectedColor);
                })
                pickerInstances[pickerId] = picker;
            }

            function destroyPicker(pickerId) {
                if (pickerInstances[pickerId]) {
                    pickerInstances[pickerId].destroyAndRemove();
                    delete pickerInstances[pickerId];
                }
            }

            function initColorPickersInContainer(container) {
                $(container).find('.color-preview').each(function() {
                    const $this = $(this);
                    const currentColor = $this.css("background-color") || "#000000";
                    createPicker(pickerId, currentColor, `input[data-picker-id]=${pickerId}`);
                })
            }

            let count = 0;
            $("#add-attribute-btn").on("click", function() {
                count++;
                const collapseId = "collapse" + count;
                const headerId = "header" + count;

                const accordionItem = `
                <div class="accordion-item" data-index="${count}">
                                        <div class="accordion-header" id="${headerId}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#${collapseId}" aria-control="${collapseId}" aria-expanded="false">
                                                New Attribute #${count}
                                                <div class="accordion-button-toggle">
                                                    <!-- Download SVG icon from http://tabler.io/icons/icon/chevron-down -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-1">
                                                        <path d="M6 9l6 6l6 -6"></path>
                                                    </svg>
                                                </div>
                                            </button>
                                            <span class="delete-btn"
                                                style="padding: 5px; background: red; color: white; border-radius: 10px; margin-right: 10px;"><i
                                                    class="ti ti-trash"></i> </span>
                                        </div>
                                        <div id="${collapseId}" class="accordion-collapse collapse"
                                            data-bs-parent="#accordion-default" style="">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="" class="form-label">Name</label>
                                                        <input type="text" class="form-control" value=""
                                                            name="">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="" class="form-label">Type</label>
                                                        <select name="" class="form-control main-type" id="">
                                                            <option value="text">Text</option>
                                                            <option value="color">Color</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <table class="table table-bordered section-table mt-3" style="display: none">
                                                    <thead>
                                                        <tr>
                                                            <th>Label</th>
                                                            <th class="value-header">Value</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            {{-- <td colspan="2">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center">
                                                                    <input type="text" class="form-control"
                                                                        name="" placeholder="Label"></input>
                                                                    <span class="review-row-btn ms-2"><i
                                                                            class="ti ti-trash"></i></span>
                                                                </div>
                                                            </td> --}}
                                                            {{-- <td> --}}
                                                            {{-- <input type="text" class="form-control" name=""
                                                                    id="" placeholder="Label"></input>
                                                            </td>
                                                            <td>
                                                                <div class="picker">
                                                                    <input type="hidden" class="color-value"
                                                                        placeholder="Label"></input>
                                                                    <span class="review-row-btn ms-2"><i
                                                                            class="ti ti-trash"></i></span>
                                                                </div>
                                                            </td> --}}
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <div class="mt-2">
                                                    <button class="btn btn-sm btn-primary add-row-btn" type="button">Add Row</button>
                                                    <button class="btn btn-sm btn-success" type="button">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                `;

                $("#accordion-default").append(accordionItem);
            })

            $(document).on("click", ".add-row-btn", function() {
                const accordionBody = $(this).closest('.accordion-body');
                const type = accordionBody.find('.main-type').val();
                const table = accordionBody.find('.section-table');
                const tbody = table.find('tbody');
                table.show()

                const pickerId = generateUniqueId();
                let rowHtml = "";

                if (type === "color") {
                    rowHtml = `
                 <tr>
                       <td>
                            <input type="text" class="form-control label-input" name="" id=""
                                placeholder="Label"></input>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div id="${pickerId}-preview" class="color-preview"></div>
                                <input type="hidden" class="color-value" data-picker-id="${pickerId}"></input>
                                <span class="review-row-btn ms-2"><i class="ti ti-trash"></i></span>
                            </div>
                        </td></tr>
                        `
                } else {
                    rowHtml = `
                     <tr>
                        <td colspan="2">
                            <div class="d-flex justify-content-between align-items-center">
                                <input type="text" class="form-control label-input" name="" placeholder="Label"></input>
                                <span class="review-row-btn ms-2"><i class="ti ti-trash"></i></span>
                            </div>
                        </td>
                    </tr>
                    `
                }
                tbody.append(rowHtml);

                if (type === "color") {
                    createPicker(
                        pickerId + "-preview",
                        "#000000",
                        `input[data-picker-id="${pickerId}"]`
                    );
                }
            })

            // remove row
            $(document).on("click", ".review-row-btn", function() {
                const $row = $(this).closest("tr");
                const $colorPreview = $row.find(".color-preview");
                if ($colorPreview.length) {
                    destroyPicker($colorPreview.attr("id"));
                }
                const $table = $(this).closest("section-table");
                $row.remove();
                const tbody = $table.find("tbody");
                if (tbody.children().length === 0) {
                    $table.hide();
                }
            })

            // chnage type => rebuild rowa and mange pickers
            $(document).on("change", ".main-type", function() {
                const accordionBody = $(this).closest('.accordion-body');
                const type = $(this).val();
                const table = accordionBody.find('.section-table');
                const tbody = table.find('tbody');

                // collect row values and destroy any existing pickers
                const labels = [];

                tbody.find("tr").each(function() {
                    const $colorPreview = $(this).find(".color-preview");
                    if ($colorPreview.length) {
                        destroyPicker($colorPreview.attr("id"));
                    }
                    const labelVal = $(this).find(".label-input").val();
                    labels.push(labelVal || "");
                });
                tbody.empty();

                labels.forEach(label => {
                    const pickerId = generateUniqueId();
                    let rowHtml = ""
                    if (type === "color") {
                        rowHtml = `
                 <tr>
                       <td>
                            <input type="text" class="form-control label-input" name="" id=""
                                placeholder="Label" value="${label}"></input>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div id="${pickerId}-preview" class="color-preview"></div>
                                <input type="hidden" class="color-value" data-picker-id="${pickerId}" name=""></input>
                                <span class="review-row-btn ms-2"><i class="ti ti-trash"></i></span>
                            </div>
                        </td></tr>
                        `
                    } else {
                        rowHtml = `
                     <tr>
                        <td colspan="2">
                            <div class="d-flex justify-content-between align-items-center">
                                <input type="text" class="form-control label-input" name="" placeholder="Label" value="${label}"></input>
                                <span class="review-row-btn ms-2"><i class="ti ti-trash"></i></span>
                            </div>
                        </td>
                    </tr>
                    `
                    }
                    tbody.append(rowHtml);

                    if (type === "color") {
                        createPicker(
                            pickerId + "-preview",
                            "#000000",
                            `input[data-picker-id="${pickerId}"]`
                        );
                    }
                })
                if (labels.length > 0) {
                    table.show();
                } else {
                    table.hide();
                }
            })
        })
    </script>

    <script>
        $(document).on('change', '.category-check', function() {
            const isChecked = $(this).is(':checked');

            $(this).closest('li').find('input.category-check').each(function() {
                this.checked = isChecked;
                this.indeterminate = false;
            })

            function updateParents($input) {
                const $li = $input.closest('li').parent().closest('li');

                console.log($li);

                if ($li.length) {
                    const $siblings = $li.find('> ul > li input.category-check');
                    const checkedCount = $siblings.filter(':checked').length;
                    const $parent = $li.find('> label > input.category-check');

                    if (checkedCount === 0) {
                        $parent.prop('checked', false).prop('indeterminate', false);
                    } else if (checkedCount === $siblings.length) {
                        $parent.prop('checked', true).prop('indeterminate', false);
                    } else {
                        $parent.prop('checked', false).prop('indeterminate', true);
                    }

                    updateParents($parent);
                }
            }

            updateParents($(this));
        })

        // search logic
        $('#category-search').on('input', function() {
            const query = $(this).val().toLowerCase();

            $('#category-tree li').each(function() {
                const label = $(this).find('> label > .category-label').text().toLowerCase();
                if (label.includes(query)) {
                    $(this).removeClass('d-none');
                    // show all ancestors
                    $(this).parents('li').removeClass('d-none');
                } else {
                    $(this).addClass('d-none');
                }
            });
            // if query is empty, show all
            if (query === '') {
                $('#category-tree li').removeClass('d-none');
            }
        });

        $('.manage-stock-check').on('change', function() {
            if ($(this).is(':checked')) {
                $('.manage-stock').removeClass('d-none');
            } else {
                $('.manage-stock').addClass('d-none');
            }
        })

        // submit form
        $(function() {
            $('.product-form').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let data = new FormData(form[0]);

                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.products.update', ':id') }}".replace(':id',
                        '{{ $product->id }}'),
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function(response) {


                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            notyf.error(errors[key][0]);
                        });
                    }

                })
            });
        });

        // dropzone images upload
        Dropzone.autoDiscover = false;
        let imageUploader = null;

        function initImageUploader() {
            imageUploader = new Dropzone('#imageUploader', {
                url: "{{ route('admin.products.images.upload', ':id') }}".replace(':id', imageUploadProductId),
                paramName: 'file',
                maxFileSize: 10, // MB
                acceptedFiles: 'image/*',
                addRemoveLinks: false,
                uploadMultiple: false,
                autoProcessQueue: true,
                previewsContainer: false,
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                init: function() {
                    this.on("addedfile", function(file) {
                        const placeholderId = "upload-" + Date.now();
                        addUploadPlaceholder(placeholderId);
                        file.placeholderId = placeholderId;
                    })

                    this.on("success", function(file, response) {
                        $(`#${file.placeholderId}`).remove();
                        addImagePreview(response.path, response.id);
                        this.removeFile(file);
                    })

                    this.on("error", function(file, errorMessage, xhr) {
                        console.log('Dropzone error:', errorMessage);
                        console.log('XHR response:', xhr);
                        $(`#${file.placeholderId}`).remove();
                    })

                }
            });
        }

        let imageUploadProductId = null;


        function addUploadPlaceholder(placeholderId) {
            const placeholderHtml = `
            <div class="image-preview-item" id="${placeholderId}">
                <div class="image-preview-loader"></div>
            </div>
        `;

            $('#imagePreviewContainer').append(placeholderHtml);
        }

        function addImagePreview(path, id) {
            const placeholderHtml = `
            <div class="image-preview-item" data-image-id="${id}">
                <img src="${path}">
                <span class="remove-image"  data-image-id="${id}">&times;</span>
            </div>
        `;

            $('#imagePreviewContainer').append(placeholderHtml);
        }

        $(document).on("click", ".remove-image", function() {
            const imageId = $(this).attr("data-image-id");
            const element = this;
            $.ajax({
                method: "DELETE",
                url: `{{ route('admin.products.images.destroy', ':id') }}`.replace(':id', imageId),
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                success: function(response) {
                    notyf.success("Image deleted successfully");
                    $(element).closest(".image-preview-item").remove();
                },
                error: function(xhr, status, error) {
                    notyf.error("Failed to delete image");
                }
            })
        })

        // init sortable
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        new Sortable(imagePreviewContainer, {
            animation: 150,
            onEnd: function() {
                console.log("dragged")
            }
        })

        function updateImageOrder() {
            const imageOrder = [];
            $(`.image-preview-item`).each(function(index) {
                imageOrder.push({
                    id: $(this).attr("image-id"),
                    order: index
                });
            });

            $.ajax({
                url: "{{ route('admin.products.images.reorder') }}",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                data: {
                    images: imageOrder
                },
                success: function(response) {
                    notyf.success("Image order updated");
                },
                error: function(xhr, status, error) {
                    notyf.error("Failed to update image order");
                }
            })
        }
    </script>
@endpush
