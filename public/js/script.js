// Pass csrf token in ajax header
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


//----- [ button click function ] ----------
    $("#createBtn").click(function(event) {
        event.preventDefault();
        $(".error").remove();
        $(".alert").remove();

        var name       =       $("#name").val();
        var count =       $("#count").val();
        var category_id =       $("#category_id").val();
        var price =       $("#price").val();

        if(name == "") {
            $("#name").after('<span class="text-danger error"> Name is required </span>');

        }

        if(count == "") {
            $("#count").after('<span class="text-danger error"> Count is required </span>');
            return false;
        }

		if(category_id == "") {
            $("#category_id").after('<span class="text-danger error"> Category is required </span>');
            return false;
        }
		
		if(price == "") {
            $("#price").after('<span class="text-danger error"> Price is required </span>');
            return false;
        }
		
        var form_data   =       $("#postForm").serialize();

        // if product id exist
        if($("#id_hidden").val() !="") {
            updateProduct(form_data);
        }

        // else create product
        else {
            createProduct(form_data);
        }
    });


    // create new product
    function createProduct(form_data) {
        $.ajax({
            url: 'product',
            method: 'post',
            data: form_data,
            dataType: 'json',

            beforeSend:function() {
                $("#createBtn").addClass("disabled");
                $("#createBtn").text("Processing..");
            },

            success:function(res) {
                $("#createBtn").removeClass("disabled");
                $("#createBtn").text("Save");

                if(res.status == "success") {
                    $(".result").html("<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>" + res.message+ "</div>");
					window.location.reload();
				}

                else if(res.status == "failed") {
                    $(".result").html("<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>" + res.message+ "</div>");
                }
				
            }
        });
    }

    // update product
    function updateProduct(form_data) {
        $.ajax({
            url: 'product',
            method: 'put',
            data: form_data,
            dataType: 'json',

            beforeSend:function() {
                $("#createBtn").addClass("disabled");
                $("#createBtn").text("Processing..");
            },

            success:function(res) {
                $("#createBtn").removeClass("disabled");
                $("#createBtn").text("Update");

                if(res.status == "success") {
                    $(".result").html("<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>" + res.message+ "</div>");
					window.location.reload();
			   }

                else if(res.status == "failed") {
                    $(".result").html("<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>" + res.message+ "</div>");
                }
            }
        });
    }

    // ---------- [ Delete product ] ----------------
    function deleteProduct(product_id) {
        var status = confirm("Do you want to delete this product?");
        if(status == true) {
            $.ajax({
                url: "product/"+product_id,
                method: 'delete',
                dataType: 'json',

                success:function(res) {
                    if(res.status == "success") {
						
                        $("#result").html("<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>" + res.message + "</div>");
						window.location.reload();
					}
                    else if(res.status == "failed") {
                        $("#result").html("<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>" + res.message + "</div>");
						console.log(res);
					}
					
                }
            });
			window.location.reload();
        }
    }

$('#addProductModal').on('shown.bs.modal', function (e) {
   var id           =   $(e.relatedTarget).data('id');
   var name        =   $(e.relatedTarget).data('name');
   var count  =   $(e.relatedTarget).data('count');
   var category_id = $(e.relatedTarget).data('category_id');
   var price = $(e.relatedTarget).data('price');
   
   var action       =   $(e.relatedTarget).data('action');

   if(action !== undefined) {
        if(action === "view") {

            // set modal title
            $(".modal-title").html("Product Detail");

            // pass data to input fields
            $("#name").attr("readonly", "true");
            $("#name").val(name);

            $("#count").attr("readonly", "true");
            $("#count").val(count);
			
			$("#category_id").attr("readonly", "true");
            $("#category_id").val(category_id);
			
			$("#price").attr("readonly", "true");
            $("#price").val(price);

            // hide button
            $("#createBtn").addClass("d-none");
        }


        if(action === "edit") {
            $("#name").removeAttr("readonly");
            $("#count").removeAttr("readonly");
            $("#category_id").removeAttr("readonly");
            $("#price").removeAttr("readonly");

            // set modal title
            $(".modal-title").html("Update Product");

            $("#createBtn").text("Update");

             // pass data to input fields
             $("#id_hidden").val(id);
             $("#name").val(name);
             $("#count").val(count);
             $("#category_id").val(category_id);
             $("#price").val(price);

             // hide button
            $("#createBtn").removeClass("d-none");
        }
   }

   else {
        $(".modal-title").html("Create Product");

        // pass data to input fields
        $("#name").removeAttr("readonly");
        $("#name").val("");

        $("#count").removeAttr("readonly");
        $("#count").val("");
		
		$("#category_id").removeAttr("readonly");
        $("#category_id").val("");
		
		$("#price").removeAttr("readonly");
        $("#price").val("");

        // hide button
        $("#createBtn").removeClass("d-none");
   }
});