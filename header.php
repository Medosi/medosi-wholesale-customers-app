<!DOCTYPE html>
<html>
    <head>
        <title>Medosi Customers Data</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="styles.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script type="text/javascript" src="scripts.js"></script>
        <script src="https://kit.fontawesome.com/08f7b961aa.js" crossorigin="anonymous"></script>
    </head>
    <body>

    <div class="modal fade" id="customer-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Company Name</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="half">
                        <h6 class="font-weight-bold">Business Type</h6>
                        <p data-value="business-type">Empty</p>
                    </div>
                    <div class="half">
                        <h6 class="font-weight-bold">Business Accounts</h6>
                        <p data-value="business-accounts">Empty</p>
                    </div>
                    <div>
                        <h6 class="font-weight-bold">Business Reference</h6>
                        <p data-value="business-reference">Empty</p>
                    </div>
                    <div>
                        <h6 class="font-weight-bold">Address</h6>
                        <p data-value="business-address">Empty</p>
                    </div>
                    <div class="half">
                        <h6 class="font-weight-bold">City</h6>
                        <p data-value="business-city">Empty</p>
                    </div>
                    <div class="half">
                        <h6 class="font-weight-bold">State</h6>
                        <p data-value="business-state">Empty</p>
                    </div>
                    <div class="half">
                        <h6 class="font-weight-bold">Zip Code</h6>
                        <p data-value="business-zip">Empty</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="cta-container">
                        <button type="button" class="btn btn-danger" data-type="submit" data-customer-id="" data-account-request="declined">Decline</button>
                        <button type="button" class="btn btn-success" data-type="submit" data-customer-id="" data-account-request="approved">Approve</button>
                    </div>
                </div>
            </div>
        </div>
    </div>