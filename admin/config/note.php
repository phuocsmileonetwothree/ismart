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
    'status' => "<span class='note'>Chỉ định trạng thái sản phẩm . Nếu muốn sản phẩm không hiển thị trên trang web của khách hàng hãy chọn OFF</span>",

);

$note['page'] = array(
    'title' => "<span class='note'>Tên riêng của trang để hiển thị trên trang web của bạn . Ví dụ : trang LIÊN HỆ , trang VỀ CHÚNG TÔI,...</span>",
    'slug' => "<span class='note'>Chuỗi đường dẫn tĩnh là tên hợp chuẩn với ĐƯỜNG DẪN (URL). Chuỗi này thường bao gồm chữ cái thường, số , ngăn cách nhau bởi dấu gạch ngang (-) và thường trùng với tên trang</span>",
    'content' => "<span class='note'>Nội dung chi tiết của trang sẽ được hiển thị trên trang web</span>"
);

$note['post_category'] = array(
    'delete' => "<span class='note width-55'>Xóa danh mục sẽ không xóa bài viết trong danh mục đó. Thay vì thế, bài viết sẽ được chuyển đến danh mục mặc định Uncategorized. Danh mục mặc định không thể xóa.</span>",
    'title' => "<span class='note'>Tên riêng của danh mục để hiển thị trên trang web của bạn</span>",
    'slug' => "<span class='note'>Chuỗi đường dẫn tĩnh là tên hợp chuẩn với ĐƯỜNG DẪN (URL). Chuỗi này thường bao gồm chữ cái thường, số , ngăn cách nhau bởi dấu gạch ngang (-) và thường trùng với tên danh mục</span>",
    'parent_cat' => "<span class='note'>Chỉ định một danh mục cha để tạo danh mục phân cấp. Ví dụ danh mục Thể thao sẽ là chuyên mục cha của Bóng đá và Bơi lội</span>",
    'desc' => "<span class='note'>Thông thường mô tả này không được sử dụng thường xuyên trong một số giao diện, tuy nhiên một vài giao diện có thể sử dụng thông tin này</span>"
);

$note['post'] = array(
    'title' => "<span class='note'>Tiêu đề của bài viết để hiển thị trên trang web của bạn</span>",
    'content' => "<span class='note'>Chi tiết về bài viết . Giúp người đọc có thể cảm nhận được sự uy tín của cửa hàng và hiểu được cửa hàng đang truyền tải thông tin gì</span>",
    'slug' => "<span class='note'>Chuỗi đường dẫn tĩnh là tên hợp chuẩn với ĐƯỜNG DẪN (URL). Chuỗi này thường bao gồm chữ cái thường, số , ngăn cách nhau bởi dấu gạch ngang (-) và thường trùng với tên danh mục</span>",
    'thumb' => "<span class='note'>Hình ảnh đại diện của bài viết</span>",
    'parent_cat' => "<span class='note'>Chỉ định một danh mục mà bài viết này thuộc vào</span>",
);

$note['widget'] = array(
    'title' => "<span class='note'>Tên riêng của khối</span>",
    'code' => "<span class='note'>Mã riêng của khối để dễ dàng quản lý danh sách khối</span>",
    'content' => "<span class='note'>Chi tiết về nội dung của khối sẽ hiển thị trên trang web của bạn</span>",
);

$note['menu'] = array(
    'main' => "<span class='note width-55'>Mỗi menu sẽ có một danh mục được liên kết . Chỉ được liên kết một danh mục hoặc một trang vào một menu nhất định</span>",
    'title' => "<span class='note width-100'>Tên menu sẽ hiển thị trên trang web . Ví dụ \"Trang chủ\" , \"Liên hệ\"</span>",
    'slug' => "<span class='note width-100'>Chuỗi đường dẫn tĩnh cho menu</span>",
    'page' => "<span class='note width-100'>Trang liên kết đến menu</span>",
    'category_product' => "<span class='note width-100'>Danh mục sản phẩm liên kết đến menu</span>",
    'category_post' => "<span class='note width-100'>Danh mục bài viết liên kết đến menu</span>",
    'order' => "<span class='note width-100'>Thứ tự xuất hiện của các menu , được tính từ trái sang</span>",
);

$note['slider'] = array(
    'title' => "<span class='note'>Tên của slider để dễ dàng phân biệt</span>",
    'link' => "<span class='note'>Đường dẫn mà slider muốn đưa khách hàng đến . Ví dụ \"slider 1\" sẽ đưa khách hàng đến \"danh sách sản phẩm\"</span>",
    'desc' => "<span class='note'>Mô tả ngắn về slider . Có thể thêm hoặc không</span>",
    'order' => "<span class='note'>Thứ tự xuất hiện của slider được tính từ trái sang phải</span>",
    'url_slider' => "<span class='note'>Hình ảnh tức slider</span>",
);

$note['banner'] = array(
    'title' => "<span class='note'>Tên của banner để dễ dàng phân biệt</span>",
    'link' => "<span class='note'>Đường dẫn mà banner muốn đưa khách hàng đến . Ví dụ \"banner 1\" sẽ đưa khách hàng đến \"danh sách sản phẩm\"</span>",
    'desc' => "<span class='note'>Mô tả ngắn về banner . Có thể thêm hoặc không</span>",
    'order' => "<span class='note'>Thứ tự xuất hiện của banner được tính từ trái sang phải</span>",
    'url_banner' => "<span class='note'>Hình ảnh tức banner</span>",
);