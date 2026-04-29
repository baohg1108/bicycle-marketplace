@extends('admin.layouts.app')

@section('contents')
    <div class="container-xl">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    {{-- <div class="card-header">
                        <h3 class="card-title">Create Role</h3>
                        <div class="card-actions">
                            <a href="{{ route('admin.role.index') }}" class="btn btn-primary">Back</a>
                        </div>
                    </div> --}}
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label required">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="" value="">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label required">Slug</label>
                                <input type="text" class="form-control" name="slug" placeholder="" value="">
                                <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label required">Short Description</label>
                                <textarea name="id" id="short-editor"></textarea>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label required">Content</label>
                                <textarea name="content" id="editor"></textarea>
                                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            </div>
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
                                    <input name="" value="" class="form-control" type="text"></input>
                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Price</label>
                                    <input name="" value="" class="form-control" type="text"></input>
                                    <x-input-error :messages="$errors->get('store')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Special Price</label>
                                    <input name="" value="" class="form-control" type="text"></input>
                                    <x-input-error :messages="$errors->get('store')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">From Date</label>
                                    <input name="" value="" class="form-control" type="text"></input>
                                    <x-input-error :messages="$errors->get('store')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">To Date</label>
                                    <input name="" value="" class="form-control" type="text"></input>
                                    <x-input-error :messages="$errors->get('store')" class="mt-2" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            <input class="form-check-input" type="checkbox"></input>
                                            <span class="form-check-label">Manage Stock</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Quantity</label>
                                        <input name="" value="" class="form-control" type="text"></input>
                                        <x-input-error :messages="$errors->get('store')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Stock Status</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-check">
                                                    <input class="form-check-input" type="radio" name="radios"
                                                        checked=""></input>
                                                    <span class="form-check-label">In Stock</span>
                                                </label>
                                                <label class="form-check">
                                                    <input class="form-check-input" type="radio" name="radios"
                                                        checked=""></input>
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
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Status</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <select class="form-control" name="status" id="">
                                    <option value="published">Published</option>
                                    <option value="draft">Draft</option>
                                    <option value="pending">Pending</option>
                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Store --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Store</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <select class="form-control select2" name="store" id="">
                                    <option value="published">Select a store</option>
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->id }}">{{ $store->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('store')" class="mt-2" />
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Is Featured --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Is Featured</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-check form-switch form-switch-3">
                                    <input class="from-check-input" type="checkbox"></input>
                                    <span class="from-check-label">Enable</span>
                                </label>
                                <x-input-error :messages="$errors->get('is_featured')" class="mt-2" />
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Categories --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Categories</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <select class="form-control" name="category" id="">
                                    <option value="published">Select a categories</option>
                                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Brands --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Brand</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <select class="form-control select2" name="brand" id="">
                                    <option value="published">Select a brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Labels --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Label</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label label="form-check">
                                    <input class="form-check-input" type="checkbox"></input>
                                    <span class="form-check-label" type="checkbox">Hot</span>
                                </label>
                                <label label="form-check">
                                    <input class="form-check-input" type="checkbox"></input>
                                    <span class="form-check-label" type="checkbox">New</span>
                                </label>

                                <x-input-error :messages="$errors->get('label')" class="mt-2" />

                            </div>
                        </div>

                    </div>
                </div>

                {{-- Tags --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Tags</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <select class="form-control select2" name="tag" id="" multiple="multiple">
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('tag')" class="mt-2" />

                            </div>
                        </div>

                    </div>
                </div>

                {{-- Buttons --}}
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="mb-3 row">
                                <button class="btn btn-primary mt-3" onclick="$('form').submit()">Create</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
