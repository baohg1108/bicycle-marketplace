@extends('vendor-dashboard.layouts.app')

@section('contents')
    <div class="container-xl">

        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="row row-cards">

                    <!-- Card 1 -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-primary text-white avatar">
                                            💲
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">132 Sales</div>
                                        <div class="text-secondary">12 waiting payments</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-green text-white avatar">🛒</span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">78 Orders</div>
                                        <div class="text-secondary">32 shipped</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-dark text-white avatar">✖</span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">623 Shares</div>
                                        <div class="text-secondary">16 today</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-primary text-white avatar">👍</span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">132 Likes</div>
                                        <div class="text-secondary">21 today</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
