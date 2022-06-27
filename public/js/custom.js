$(function () {
    // FILTER PRODUCT AJAX
    $(".filter-price").click(function () {
        $('input').not(this).removeAttr('checked');
        var range_price = $(this).attr("data-id");
        var cat_id = $(this).parent().parent().parent().attr("cat_id");
        var data = { range_price: range_price, cat_id: cat_id };
        $.ajax({
            url: "?mod=product&action=filter_ajax",
            method: "POST",
            data: data,
            dataType: "html",

            success: function (data) {
                $('ul#list-data-ajax').html(data);
            },

            error: function (xhr, ajaxOption, thorwnError) {
                console.log(xhr.status);
                console.log(thorwnError);

            }
        })


    })

    // UPDATE QTY AJAX
    $("input.num-order").change(function () {
        var qty = $(this).val();
        var product_id = $(this).attr('product-id');
        var data = { product_id: product_id, qty: qty };

        $.ajax({
            url: "?mod=cart&action=update_ajax",
            method: "POST",
            data: data,
            // Lỗi "SyntaxError: Không mong đợi mã thông báo <trong JSON ở vị trí 0"
            // thường xảy ra khi dữ liệu trả về có ký tự ">" html
            // Khi có hàm show_array thì sẽ có thẻ <pre> </pre>
            // Xem trong f12->internet->response
            dataType: "json",

            success: function (data) {
                $(".sub-total-" + product_id).text(data.sub_total);
                $(".sub-qty-" + product_id + " span").text(data.sub_qty);
                $("#total-price span").text(data.total_price);
                $("span#num").text(data.total_qty);
                $("p.desc span").text(data.total_qty + " sản phẩm");
                $(".total-price p.price").text(data.total_price);
            },

            error: function (xhr, ajaxOption, thorwnError) {
                console.log(xhr.status);
                console.log(thorwnError);
            }
        })

    })


    // SELECT SORT
    $("select[name=sort-by]").change(function () {
        var sort_by = $(this).val();
        $("#sort-now").submit();
    })


    var middle_outer_width_product_content = $(".product-content").outerWidth() / 2;
    var middle_outer_width_extend_content = $(".extend-content").outerWidth() / 2
    var position_left = middle_outer_width_product_content - middle_outer_width_extend_content;
    $("a.extend-content").css('left', position_left);
    $("a.collapse-content").css('left', position_left);
    $('a.extend-content').click(function () {
        $(".product-content").addClass('max-height-none');
        $(".opacity").hide();
        $('a.extend-content').hide();
        $('a.collapse-content').show();
        return false;
    })

    $('a.collapse-content').click(function () {
        $(".product-content").removeClass('max-height-none');
        $(".opacity").show();
        $('a.extend-content').show();
        $('a.collapse-content').hide();
        return false;

    })

    // ------------------------------------------
    function add_product_ajax(module, data) {
        var string_product = "";
        $.ajax({
            url: "?mod=" + module + "&action=add_product_ajax",
            method: "POST",
            data: data,
            // Lỗi "SyntaxError: Không mong đợi mã thông báo <trong JSON ở vị trí 0"
            // thường xảy ra khi dữ liệu trả về có ký tự ">" html
            // Khi có hàm show_array thì sẽ có thẻ <pre> </pre>
            // Xem trong f12->internet->response
            dataType: "json",
            success: function (data) {
                
                string_product += "<li class='clearfix'>";
                string_product += "<a href='product/" + data.name + "' class='thumb fl-left'>";
                string_product += "<img src='admin/" + data.url + "'>";
                string_product += "</a>";
                string_product += "<div class='info fl-right'>";
                string_product += "<a href='product/" + data.slug + "' class='product-name'>" + data.name + "</a>";
                string_product += "<p class='price'>" + data.price + "</p>";
                string_product += "<p class='qty'>Số lượng: <span>" + data.qty + "</span></p>";
                string_product += "</div>";
                string_product += "</li>";
                // Start
                $("p.desc span").text(data.total_qty + " sản phẩm");
                $(".total-price p.price").text(data.total_price);
                $("span#num").text(data.total_qty);
                var count = $("ul.list-cart > li[data-id=" + data.product_id + "]").length
                if (count == 1) {
                    $("ul.list-cart > li[data-id=" + data.product_id + "] div.info p.qty span").text(data.qty);
                }else{
                    $("ul.list-cart").append(string_product);
                }
                $(".wrapper").fadeIn(250);
                $(".zoomContainer").addClass('disabled');
            },

            error: function (xhr, ajaxOption, thorwnError) {
                console.log(xhr.status);
                console.log(thorwnError);
            }
        })
    }
    $(".modal-show-inner label").click(function () {
        $(".wrapper").hide(250);
        $("#site").removeClass('disabled');
    })

    // ADD PRODUCT CART MODULE PRODUCT ACTION DETAIL
    $(".info a.add-cart").click(function () {
        var module = $("#site").attr('module');
        var product_id = $("#num-order").attr('data-id');
        var qty = $("#num-order").val();
        var data = { product_id: product_id, qty: qty };
        add_product_ajax(module, data);
        return false;
    });
    $(".action a.add-cart").click(function () {
        var product_id = $(this).attr('data-id');
        var module = $("#site").attr('module');
        var qty = 1;
        var data = { product_id: product_id, qty: qty };
        add_product_ajax(module, data);
        return false;
    });
    // ADD PRODUCT CART (MODULE PRODUCT ACTION INDEX) AND 


});