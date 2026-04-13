@extends('frontend.dashboard.dashboard-app')

@section('dashboard_contents')
    <div id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
        <div class="card">
            <div class="card-header p-0">
                <h5>Account Details</h5>
            </div>
            <div class="card-body p-0">
                <p>You can edit account here.</p>
                <form method="post" name="enq">
                    <div class="row mt-30">
                        <div class="form-group col-md-12">
                            <label>Name <span class="required">*</span></label>
                            <input required="" class="form-control" name="name" type="text" />
                        </div>

                        <div class="form-group col-md-12">
                            <label>Email Address <span class="required">*</span></label>
                            <input required="" class="form-control" name="email" type="email" />
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit"
                                value="Submit">Save Change</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="card mt-4">
            <div class="card-header p-0">
                <h5>Change Password</h5>
            </div>
            <div class="card-body p-0">
                <p>You can change password here.</p>
                <form method="post" name="enq">
                    <div class="row mt-30">
                        <div class="form-group col-md-12">
                            <label>Current Password <span class="required">*</span></label>
                            <input required="" class="form-control" name="password" type="password" />
                        </div>
                        <div class="form-group col-md-12">
                            <label>New Password <span class="required">*</span></label>
                            <input required="" class="form-control" name="npassword" type="password" />
                        </div>
                        <div class="form-group col-md-12">
                            <label>Confirm Password <span class="required">*</span></label>
                            <input required="" class="form-control" name="cpassword" type="password" />
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit"
                                value="Submit">Save Change</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
