$(document).ready(function () {


    var hehe = $('#wp-blur').hasClass('d-block')
    if (hehe == true) {
        $("#site").addClass('disable');
    }

    $(".close").click(function () {
        $(this).parent(".alert").fadeOut();
        $('#site').removeClass('disable');
    });







    var height = $(window).height() - $('#footer-wp').outerHeight(true) - $('#header-wp').outerHeight(true);
    $('#content').css('min-height', height);


    // EVENT DASHBOARD 
    $(".auto-hide-num").html("&#8727;&#8727;&#8727;&#8727;&#8727;&#8727;&#8727;&#8727;&#8727;&#8727;");
    $(".auto-hide").append("<i class='fa fa-eye-slash absolute-auto-hide' aria-hidden='true'></i>");
    $(".absolute-auto-hide").css({ 'position': 'absolute', 'top': '21px', 'left': '160px', 'cursor': 'pointer' });
    $('.absolute-auto-hide').mouseenter(function () {
        $(this).removeClass('fa-eye-slash').addClass('fa-eye');
        var data_num = $(this).parent().attr('data-num');
        $(this).parent().children(':first-child').text(data_num);

        $(this).mouseleave(function () {
            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            $(this).parent().children(':first-child').html("&#8727;&#8727;&#8727;&#8727;&#8727;&#8727;&#8727;&#8727;&#8727;&#8727;");
        });
    });
    var middle_outer_width = ($(".order-list").outerWidth() / 2) - ($(".notify").outerWidth() / 2);
    $(".notify").css({ 'top': '37%', 'left': middle_outer_width, "z-index": "9999999999" });
    if ($("h1").hasClass('notify')) {
        $(".absolute-auto-hide, .fa-eye-slash").attr('title', "Bạn cần có quyền truy cập , liên hệ quản lý hoặc quản trị viên để biết chi tiết");
        $(".order-list a").click(function () { return false; })
    }

    // EVENT SIDEBAR MENU

    $('#sidebar-menu .nav-item .nav-link .title').after('<span class="fa fa-angle-right arrow"></span>');
    var sidebar_menu = $('#sidebar-menu > .nav-item > .nav-link');
    var searchParams = new URLSearchParams(window.location.search);

    var mod = "?mod=" + searchParams.get('mod');
    var type = '';
    if (searchParams.get('type') != null) {
        type = "&type=" + searchParams.get('type');
    }
    var action = "&action=" + searchParams.get('action');
    var param_url = mod + type + action;
    if(searchParams.get('mod') == null){
        $("ul#sidebar-menu li.nav-item > a[href='?']").parent().addClass('active');
        $("ul#sidebar-menu li.nav-item > a[href='?']").css({ 'background': '#f5f5f5' });
    }


    $("#sidebar-menu .sub-menu > li > a[href='" + param_url + "']").parent().parent().parent().addClass('active');
    $("#sidebar-menu .sub-menu > li > a[href='" + param_url + "']").parent().parent().slideDown();
    $("#sidebar-menu .sub-menu > li > a[href='" + param_url + "']").parent().parent().addClass('active_by_url');
    $("#sidebar-menu .sub-menu > li > a[href='" + param_url + "']").css({ 'background': '#f5f5f5' });
    sidebar_menu.not('.dashboard').click(function () {
        if ($(this).parent().hasClass('active')) {
            $('#sidebar-menu > .nav-item').removeClass('active');
            $('.sub-menu').not('.active_by_url').slideUp();
        } else {
            $('#sidebar-menu > .nav-item').removeClass('active');
            $('.sub-menu').not('.active_by_url').slideUp();
            $(this).parent('li').addClass('active');
            $(this).parent('li').find('.sub-menu').slideDown();
        }
        return false;
    });






    // -------------------------------- CUSTOM -----------------------------------
    // SELECTED MENU chỉ chọn 1 liên kết đối với 1 menu
    $('select.choose-only-one').change(function () {
        var name = $(this).attr('name');
        $('select.choose-only-one').each(function () {
            $(this).not("[name='" + name + "']").val('-1');
        })

    })


    //  CHECK ALL
    var checked_array = [];
    $('input[name="checkAll"]').click(function () {
        var status = $(this).prop('checked');
        if (status === false) {
            checked_array = [];
        }
        $('.list-table-wp tbody tr td input[type="checkbox"]').prop("checked", status);
        checked_array = [];
        $('input.checkItem').each(function () {
            data_id = $(this).attr('data-id');
            if ($(this).is(':checked')) {

                checked_array.push(data_id);
            }
        });
    });

    // CHECK ALL ON ROW
    $('input.checkAllRow').each(function () {
        if ($(this).is(':checked')) {
            var status = $(this).prop('checked');
            var module_id = $(this).attr('data-id');
            $("input.checkItemRow[data-id=" + module_id + "]").each(function () {
                if (status == true) {
                    $(this).attr('disabled', 'disabled');
                } else {
                    $(this).removeAttr('disabled');
                }
                $(this).prop('checked', status);
            });
        }

    });
    $("input.checkAllRow").click(function () {
        var status = $(this).prop('checked');
        var module_id = $(this).attr('data-id');
        if (status == true) {

            $("input.checkItemRow[data-id=" + module_id + "]").attr('disabled', 'disabled');
        } else {
            $("input.checkItemRow[data-id=" + module_id + "]").removeAttr('disabled');
        }
        $("input.checkItemRow[data-id=" + module_id + "]").prop('checked', status);

    });





    $('input.checkItem').change(function () {
        data_id = $(this).attr('data-id');
        if (!$(this).is(':checked')) {
            for (var i = 0; i <= checked_array.length - 1; i++) {
                if (checked_array[i] == data_id) {
                    checked_array.splice(i, 1);
                    break;
                }
            }
        } else {
            checked_array.push(data_id);
        }
    });

    function get_param_string(string) {
        const stringArr = {
            'product': 'sản phẩm',
            'order': 'đơn hàng',
            'page': 'trang',
            'post': 'bài viết',
            'category': 'danh mục',
            'widget': 'khối giao diện',
            'menu': 'menu',
            'slider': 'slider',
            'banner': 'banner',
        }
        for (key in stringArr) {
            if (string == key) {
                return stringArr[key];
            }
        }
    }


    function ajax_action(data, module, action) {
        $.ajax({
            url: "?mod=" + module + "&action=actions_ajax",
            method: "POST",
            data: data,
            // Lỗi "SyntaxError: Không mong đợi mã thông báo <trong JSON ở vị trí 0"
            // thường xảy ra khi dữ liệu trả về có ký tự ">" html
            // Khi có hàm show_array thì sẽ có thẻ <pre> </pre>
            // Xem trong f12->internet->response
            dataType: "json",
            success: function (data) {
                for (key in data) {
                    if (key != 'update') {
                        $("li." + key + " a span.count").text("(" + data[key] + ")");
                    }
                }
                if (action != 'delete') {
                    if (action == 'on' || action == 'off' || action == "processing" || action == "cancelled" || action == "transported" || action == "successful") {
                        checked_array.forEach(function (index) {
                            $("span.status-" + index).text(data.update);
                            $("span.status-" + index).removeClass("processing cancelled transported successful on off").addClass(action);
                        });
                    } else {
                        checked_array.forEach(function (index) {
                            $("span.stocking-" + index).text(data.update);
                            $("span.stocking-" + index).removeClass("still out").addClass(action);
                        });
                    }

                } else {
                    if (data.delete == true) {
                        $('input.checkItem').each(function () {
                            if ($(this).is(':checked')) {
                                $(this).parent().parent().css({ "background": "red", "color": "#fff", "transition": "2s", "opacity": "0.5" });
                                $(this).parent().parent().slideUp(1500);
                            }
                        });
                    } else {
                        alert(data.delete);
                    }
                }
            },
            error: function (xhr, ajaxOption, thorwnError) {
                console.log(xhr.status);
                console.log(thorwnError);
            }

        })
    }

    $("input[name=sm_action]").click(function () {
        var module = $(this).attr('mod');
        var module_name = get_param_string(module);
        if ($("select[name=actions]").val() == 0) {
            alert("Vui lòng chọn tác vụ");
        } else {
            if (checked_array.length == 0) {
                alert("Vui lòng chọn " + module_name);
            } else {
                var action = $("select[name=actions]").val();
                if (action == 'delete' && confirm("Bạn chắc chắn xóa " + module_name + " . Không thể hoàn tác lại khi đã xóa") == false) {
                    return false;
                }
                var data = { checked_array: checked_array, action: action };
                ajax_action(data, module, action);
            }

        }
        return false;
    })

    $("input#thumb_avatar").change(function () {
        var file_data = $(this).prop('files')[0];
        //khởi tạo đối tượng form data
        var form_data = new FormData();
        //thêm files vào trong form data
        form_data.append('thumb', file_data)

        $.ajax({
            url: "?mod=user&action=add_image_ajax",
            method: 'POST',
            data: form_data,
            // Lỗi "SyntaxError: Không mong đợi mã thông báo <trong JSON ở vị trí 0"
            // thường xảy ra khi dữ liệu trả về có ký tự ">" html
            // Khi có hàm show_array thì sẽ có thẻ <pre> </pre>
            // Xem trong f12->internet->response
            cache: false,
            contentType: false,
            processData: false,
            dataType: "html",
            success: function (data) {
                $("span.thumb img").attr("src", data);
            },
            error: function (xhr, ajaxOption, thorwnError) {
                console.log(xhr.status);
                console.log(thorwnError);
            }

        })
    })

    $("ul.list-update-thumb li a").click(function () {
        if ($("#list-thumb > li").length == 1) {
            alert("Không thể xóa tất cả hình ảnh . Bạn có thể thêm 1 ảnh mới và sau đó xóa ảnh bạn muốn xóa");
        } else {
            var id = $(this).attr('data-image')
            var action = $(this).attr('class');
            if (action == 'delete' && confirm("Bạn chắc chắn xóa hình ảnh . Không thể hoàn tác lại khi đã xóa") == false) {
                return false;
            }
            var data = { id: id, action: action };
            $.ajax({
                url: "?mod=product&action=delete_image_ajax",
                method: "POST",
                data: data,
                // Lỗi "SyntaxError: Không mong đợi mã thông báo <trong JSON ở vị trí 0"
                // thường xảy ra khi dữ liệu trả về có ký tự ">" html
                // Khi có hàm show_array thì sẽ có thẻ <pre> </pre>
                // Xem trong f12->internet->response
                dataType: "json",
                success: function (data) {
                    if (data.delete == true) {
                        $("ul#list-thumb img[data-image=" + id + "]").attr('src', '');
                        $("ul.list-update-thumb li a[data-image=" + id + "]").parent().parent().parent().css({ "background": "red", "color": "#fff", "transition": "2s", "opacity": "0.5" });
                        $("ul.list-update-thumb li a[data-image=" + id + "]").parent().parent().parent().fadeOut(1000);
                    }
                },
                error: function (xhr, ajaxOption, thorwnError) {
                    console.log(xhr.status);
                    console.log(thorwnError);
                }

            })
        }
        return false;
    })

    $("input.add-list-image").change(function () {
        var form_data = new FormData();
        var product_id = $(this).attr('data-id');
        var totalfiles = document.getElementById('files').files.length;

        for (var index = 0; index < totalfiles; index++) {
            form_data.append("files[]", document.getElementById('files').files[index]);
        }
        form_data.append("product_id", product_id);
        $.ajax({
            url: '?mod=product&action=upload_image_ajax',
            type: 'post',
            data: form_data,
            dataType: 'html',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $("ul#list-thumb").append(data);
            }
        });
    })

    var image_swap = [];
    $("ul#list-thumb li img").click(function () {
        var image_id = $(this).attr('data-image');
        image_swap.push(image_id);
        $(this).addClass('border-2px');
        var count = $('ul#list-thumb li img.border-2px').length;
        if (count == 2) {
            if (confirm("Bạn chắc chắn đổi vị trí của hình ảnh . Vị trí của hình ảnh theo thứ tự đầu tiên đến cuối cùng được tính từ trái sang phải , từ trên xuống dưới") == true) {
                var data = { image_one: image_swap[0], image_two: image_swap[1] };

                $.ajax({
                    url: "?mod=product&action=swap_order_image_ajax",
                    method: "POST",
                    data: data,
                    // Lỗi "SyntaxError: Không mong đợi mã thông báo <trong JSON ở vị trí 0"
                    // thường xảy ra khi dữ liệu trả về có ký tự ">" html
                    // Khi có hàm show_array thì sẽ có thẻ <pre> </pre>
                    // Xem trong f12->internet->response
                    dataType: "json",
                    success: function (data) {
                        if (data.swap_image == false) {
                            alert("Hệ thống đã xảy ra lỗi . Mong bạn thử lại sau");
                        } else {
                            $("ul#list-thumb li img[data-image=" + image_swap[0] + "]").removeAttr('src').attr('src', data.new_src_img_one);
                            $("ul#list-thumb li img[data-image=" + image_swap[1] + "]").removeAttr('src').attr('src', data.new_src_img_two);
                            image_swap = [];
                            $('ul#list-thumb li img').removeClass('border-2px');
                        }
                    },
                    error: function (xhr, ajaxOption, thorwnError) {
                        console.log(xhr.status);
                        console.log(thorwnError);
                    }

                })
            } else {
                $('ul#list-thumb li img').removeClass('border-2px');
                image_swap = [];
                console.log(image_swap);
            }
        }
    })

    $('a#hover-list-order').mouseenter(function () {
        $(this).mouseleave(function () {
            $("#table-hover-list-order").remove();
        });
        var order_id = $(this).attr('data-id');
        var data = { order_id: order_id };
        $.ajax({
            url: "?mod=dashboard&action=hover_list_order",
            method: "POST",
            data: data,
            // Lỗi "SyntaxError: Không mong đợi mã thông báo <trong JSON ở vị trí 0"
            // thường xảy ra khi dữ liệu trả về có ký tự ">" html
            // Khi có hàm show_array thì sẽ có thẻ <pre> </pre>
            // Xem trong f12->internet->response
            dataType: "html",
            success: function (data) {
                $("a#hover-list-order[data-id='" + order_id + "']").append($(data).hide().fadeIn());
            },
            error: function (xhr, ajaxOption, thorwnError) {
                console.log(xhr.status);
                console.log(thorwnError);
            }

        })
    });
    $('a#hover-list-order').click(function () {
        return false;
    })
});