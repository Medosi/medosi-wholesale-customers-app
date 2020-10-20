function emptyMsg () {
    var rowCount = $('table.table tr').length;
    //console.log(rowCount);
    if(rowCount > 2) {
        $('tr.empty-msg').addClass('d-none');
    } else {
        $('tr.empty-msg').removeClass('d-none');
    }
}

function successMsg(message) {
    $(".success-msg").html(message);
    $("#success-alert").fadeTo(1000, 1, 'linear');
}

function warningMsg(message) {
    $(".warning-msg").html(message);
    $("#warning-alert").fadeTo(1000, 1, 'linear');
}

function sendEmail(customer_name,customer_email,status) {
    let n_c = {};
    n_c.email = {};
    n_c.email.customer_name = customer_name;
    n_c.email.customer_email = customer_email;
    n_c.email.status = status;

    n_c = JSON.stringify(n_c);
    $.ajax({
        url:'https://medosi-privateapp.com/apps/customer_data/notify_customer.php',
        data: {
            "email": n_c
        },
        type: 'POST',
        success: function(response){
            console.log(response);
        }
    });
}

function showCustomerData(id) {
    $("#customer-modal [data-type='submit']").attr("data-customer-id", id);
    $.ajax({
        url:'https://medosi-privateapp.com/apps/customer_data/get_customer.php',
        data: {
            "customer_id": id
        },
        type: 'POST',
        success: function(response){
            //console.log(response);
            let address = JSON.parse(response).customer.default_address;
            console.log(address);

            $('#customer-modal .modal-title').text(address.company);
            $('#customer-modal [data-value="business-address"]').text(address.address1);
            $('#customer-modal [data-value="business-city"]').text(address.city);
            $('#customer-modal [data-value="business-state"]').text(address.province);
            $('#customer-modal [data-value="business-zip"]').text(address.zip);

            $.ajax({
                url:'https://medosi-privateapp.com/apps/customer_data/get_metafields.php',
                data: {
                    "customer_id": id
                },
                type: 'POST',
                success: function(response){
                    //console.log(response);
                    let metafields = JSON.parse(response).metafields;
                    for (let metafield of metafields){
                        switch(metafield.key) {
                            case "Business Type":
                                $('#customer-modal [data-value="business-type"]').text(metafield.value);
                                break;
                            case "Business Reference":
                                $('#customer-modal [data-value="business-reference"]').text(metafield.value);
                                break;
                            case "Business Accounts":
                                $('#customer-modal [data-value="business-accounts"]').text(metafield.value);
                                break;
                            case "Wholesale Account":
                                //console.log(metafield);
                                switch(metafield.value){
                                    case "approved":
                                        $('#customer-modal [data-account-request="approved"]').hide();
                                        $('#customer-modal [data-account-request="declined"]').show();
                                        break;
                                    case "declined":
                                        $('#customer-modal [data-account-request="approved"]').show();
                                        $('#customer-modal [data-account-request="declined"]').hide();
                                        break;
                                    case "pending":
                                        $('#customer-modal [data-account-request]').show();
                                        break;
                                }
                                break;
                        }
                    }

                    $('#customer-modal').modal('show');
                }
            });
        }
    });
}

// $("#pending-table").ready( function(){
//     console.log("prending table loaded");
//     $.ajax({
//         crossDomain: true,
//         url:'https://medosi-privateapp.com/apps/customer_data/get_customers.php',
//         type: 'GET',
//         success: function(response){
//             var customers = JSON.parse(response);
//             customers = customers.customers;
//             //console.log(customers);
//             customers.forEach((customer) =>{
//                 //console.log(customer.id);
//                 var b_c = {};
//                 b_c.customer = customer;
//                 console.log(b_c);
//                 b_c = JSON.stringify(b_c);
//                 $.ajax({
//                     async: false,
//                     crossDomain: true,
//                     url:"https://medosi-privateapp.com/apps/customer_data/check_metafield.php",
//                     data: {
//                         "customer": b_c
//                     },
//                     type: 'POST',
//                     success: function(response){
//                         console.log(response);
//                     }
//                 });
//             });
//         }
//     })
//     return false;
// });

$( document ).ready(function() {
    emptyMsg();

    let pathname = window.location.pathname;
    //console.log(pathname);
    if (pathname != "/apps/customer_data/index.php" && pathname != "/apps/customer_data/") {
        let warning_msg = "If data is not reflecting accuratelly, please wait 15-30 sec and try refreshing the page";
        warningMsg(warning_msg);
    }

    $("[data-action='get-customer-data']").click(function(){
        let id = $(this).text();
        showCustomerData(id);
    });

    $("[data-account-request]").click(function(){
        $(this).parent().html("<img class='loading' src='images/loading.gif'>");
        let customer_id = $(this).data("customer-id");
        let metafield_value = $(this).data("account-request");

        let n_c = {};
        n_c.customer = {};
        n_c.customer.customer_id = customer_id;
        n_c = JSON.stringify(n_c);

        $.ajax({
            url:'https://medosi-privateapp.com/apps/customer_data/get_metafield_id.php',
            data: {
                "get_metafield_id": n_c
            },
            type: 'POST',
            success: function(response){
                let metafield_id = response;
                //console.log(metafield_id);

                let n_c = {};
                n_c.metafield = {};
                n_c.metafield.id = metafield_id;
                n_c.metafield.value = metafield_value;
                n_c.metafield.value_type = "string";
                n_c = JSON.stringify(n_c);

                $.ajax({
                    url:'https://medosi-privateapp.com/apps/customer_data/update_metafield.php',
                    data: {
                        "update_metafield": n_c
                    },
                    type: 'POST',
                    success: function(response){
                        $.ajax({
                            url:'https://medosi-privateapp.com/apps/customer_data/get_customer_tags.php',
                            data: {
                                "customer_id": customer_id
                            },
                            type: 'POST',
                            success: function(response){
                                let tags = response.split(",");
                                var remove_tags = [];
                                // console.log(tags);

                                if (metafield_value == "approved"){
                                    tags.push("wholesale-approved");
                                    var remove_tags = ["wholesale-declined", "wholesale-pending"];
                                    //console.log(remove_tags);
                                } else {
                                    tags.push("wholesale-declined");
                                    var remove_tags = ["wholesale-approved", "wholesale-pending"];
                                    //console.log(remove_tags);
                                }

                                tags.forEach((tag, index) => {
                                    remove_tags.forEach((remove_tag) => {
                                        if(tag == remove_tag){
                                            tags.splice(index, 1);
                                        }
                                    });
                                });

                                tags.toString();
                                // console.log(tags);

                                let n_c = {};
                                n_c.customer = {};
                                n_c.customer.id = customer_id;
                                n_c.customer.tags = tags;
                                n_c = JSON.stringify(n_c);

                                $.ajax({
                                    url:'https://medosi-privateapp.com/apps/customer_data/update_customer_tags.php',
                                    data: {
                                        "customer": n_c
                                    },
                                    type: 'POST',
                                    success: function(response){
                                        //console.log(response);
                                        customer = JSON.parse(response).customer;
                                        //console.log(customer);
                                        let customer_name = customer.first_name;
                                        let customer_email = customer.email;
                                        //console.log("Name:",customer_name," Email:",customer_email);

                                        $('tr#customer-' + customer_id).fadeTo(1000, 0, 'linear', function(){
                                            $(this).remove();
                                            $('#customer-modal').modal('hide');
                                            emptyMsg();
                                            let success_msg = "customer was updated succesfully";
                                            successMsg(success_msg);
                                        });
                                        sendEmail(customer_name, customer_email, metafield_value);
                                    }
                                })
                            }
                        });
                    }
                });
                //console.log(m_c);
                return false;
            }
        })
        //console.log(n_c);
        return false;
    });
});