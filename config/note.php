<?php
/*
 * File Note.php sẽ lưu giữ cấu hình mặc định của các ghi chú của dự án
 */
$note['product_category'] = array(
    'delete' => "<span class='note width-55'>Xóa danh mục sẽ không xóa sản phẩm trong danh mục đó. Thay vì thế, sản phẩm sẽ được chuyển đến danh mục mặc định Uncategorized. Danh mục mặc định không thể xóa.</span>",
    'title' => "<span class='note'>Tên riêng của danh mục để hiển thị trên trang web của bạn</span>",
    'slug' => "<span class='note'>Chuỗi đường dẫn tĩnh là tên hợp chuẩn với ĐƯỜNG DẪN (URL). Chuỗi này thường bao gồm chữ cái thường, số , ngăn cách nhau bởi dấu gạch ngang (-) và thường trùng với tên danh mục</span>",
    'parent_cat' => "<span class='note'>Chỉ định một danh mục cha để tạo danh mục phân cấp. Ví dụ danh mục Áo sẽ là chuyên mục cha của Áo sơ mi và Áo thể thao</span>",
    'desc' => "<span class='note'>Thông thường mô tả này không được sử dụng thường xuyên trong một số giao diện, tuy nhiên một vài giao diện có thể sử dụng thông tin này</span>"
);

$note['product'] = array(
    'name' => "<span class='note'>Tên riêng của sản phẩm để hiển thị trên trang web của bạn</span>",
    'code' => "<span class='note'>Mã riêng của sản phẩm để phân biệt và quản lý danh sách sản phẩm của bạn</span>",
    'price' => "<span class='note'>Hãy cho biết sản phẩm này có đáng giá bao nhiêu</span>",
    'desc' => "<span class='note'>Mô tả ngắn của sản phẩm . Thông thường được sử dụng mô tả cấu hình của sản phẩm</span>",
    'content' => "<span class='note'>Mô tả chi tiết về sản phẩm . Giúp khách hàng hiểu thêm về sản phẩm này</span>",
    'thumb' => "<span class='note'>Hình ảnh sản phẩm</span>",
    'product_cat' => "<span class='note'>Chỉ định sản phẩm này thuộc danh mục nào để dễ dàng phân tách . Ví dụ sản phẩm Laptop Asus 13 inch thuộc danh mục Asus</span>",
    'status' => "<span class='note'>Chỉ định trạng thái sản phẩm . Nếu muốn sản phẩm không hiển thị hãy chọn OFF</span>",

);