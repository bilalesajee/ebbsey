<?php include resource_path('views/includes/header.php'); ?>
    <div class="full_viewport login_wrapper">
    <div class="container">
        <div class="custom_package_wrap">
            <div class="package_header d-flex align-items-sm-center flex-column flex-sm-row">
                <div>
                    <h2>Custom Package</h2>
                    <div class="number_passes">50 Passes</div>
                </div>
            </div>
            <div class="package_body">
                <form class="payment_form">
                    <div class="form-section">
                        <div class="form-group">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <label>E-Mail</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="email" class="form-control eb-form-control" placeholder="Example@gmail.com" />
                                </div>
                            </div><!-- row -->
                        </div><!-- form-group -->   
                        <div class="form-group">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <label>Card Number</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control eb-form-control" placeholder="xxxx-xxxx-xxxx-xxxx" />
                                </div>
                            </div><!-- row -->
                        </div><!-- form-group -->   
                        <div class="form-group">    
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <label>CVC</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control eb-form-control" placeholder="***" />
                                </div>
                            </div><!-- row -->
                        </div><!-- form-group -->   
                        <div class="form-group">    
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <label>Valid Until</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="email" class="form-control eb-form-control" placeholder="Example@gmail.com" />
                                </div>
                            </div><!-- row -->
                        </div><!-- form-group -->
                    </div><!-- form-section -->
                    <div class="form-section">
                        <div class="form-group mb-4">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <h5 class="coupen-title mb-3">Enter a Coupon Code and Get <span class="text-orange"> 20% </span> Discount on purchase!</h5>
                                </div>
                                <div class="col-md-3">
                                    <label>Coupon Code</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="field_wrap">
                                        <input type="text" class="form-control eb-form-control"/>
                                        <div class="btn_in_input d-flex justify-content-end align-items-center">
                                            <button class="btn btn-success btn_coupen">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- row -->
                        </div><!-- form-group -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <h5 class="coupen-title mb-3">Enter a Coupon Code and Get <span class="text-orange"> 20% </span> Discount on purchase!</h5>
                                </div>
                                <div class="col-md-3">
                                    <label>Referral Code</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="field_wrap">
                                        <input type="text" class="form-control eb-form-control"/>
                                        <div class="btn_in_input d-flex justify-content-end align-items-center">
                                            <button class="btn btn-success btn_coupen">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- row -->
                        </div><!-- form-group -->
                    </div><!-- form-section -->

                    <div class="total_payment d-flex align-items-sm-center flex-column flex-sm-row">
                        <div>
                            <span class="total_payment_label">Total Payment</span>
                        </div>
                        <div class="ml-sm-auto">
                            <div class="price d-flex align-items-center">
                                <span class="current">$160.00</span>
                                <span class="prev">$200.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="checkbox" class="custom-control-input" id="terms" name="gender" value="male" required>
                        <label class="custom-control-label" for="terms"> Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci 
                            quia dolor sit amet, consectetur, adipisci velit </label>
                    </div>
                    <input type="submit" value="Pay Now" class="btn orange btn-lg text-uppercase font-weight-bold mt-4"/>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
</body>
</html>