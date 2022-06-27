<?php

function validation_image($label_field, $error_class, $upload_dir, $size = 20000000, $format = array('jpg', 'jpeg', 'png', 'gif'))
{
    $data = array();
    global $_FILES, $error;


    // Vì là mutiple nên phải !empty tới phần tử thứ 0 của 'name'
    if (empty($_FILES[$label_field]['name'][0])) {
        $error[$label_field] = "<p class='{$error_class}'>Tải lên hình ảnh</p>";
    } else {

        if (is_array($_FILES[$label_field]['name'])) { #Mutiple Images
            foreach ($_FILES[$label_field]['name'] as $k_file => $v_file) {

                # Lấy đường dẫn tạm của ảnh trước khi up lên server
                $tmp_name = $_FILES[$label_field]['tmp_name'][$k_file];

                # Lấy đường dẫn real của ảnh sau khi up lên server
                $upload_file = $upload_dir . $_FILES[$label_field]['name'][$k_file];

                # Lấy định dạng ảnh . VD : jpg, png để kiểm tra 
                $file_format = pathinfo($_FILES[$label_field]['name'][$k_file], PATHINFO_EXTENSION);

                # Lấy tên ảnh và up lên server . VD : hehe, huhu
                $file_name = pathinfo($_FILES[$label_field]['name'][$k_file], PATHINFO_FILENAME);
                // Kiểm tra
                # Đúng định dạng ảnh
                # Đúng kích thước ảnh
                # Tồn tại ảnh
                if (!in_array(strtolower($file_format), $format)) {
                    $string_format = implode(', ', $format);
                    $error[$label_field] = "<p class='{$error_class}'>Hệ thống chỉ hỗ trợ file ảnh có định dạng {$string_format}</p>";
                } else {
                    if ($_FILES[$label_field]['size'][$k_file] > $size) {
                        $error[$label_field] = "<p class='{$error_class}'>Hệ thống hỗ trợ file ảnh có kích thước <20MB</p>";
                    } else {
                        if (file_exists($upload_file)) {
                            $new_upload_file =  $upload_dir . $file_name . " - Copy." . $file_format;
                            $k = 2;
                            while (file_exists($new_upload_file)) {
                                $new_upload_file =  $upload_dir . $file_name . " - Copy({$k})." . $file_format;
                                $k++;
                            }
                            $data[] = array(
                                'url' => $new_upload_file,
                                'name' => $file_name,
                                'tmp_name' => $tmp_name
                            );
                        } else {
                            $data[] = array(
                                'url' => $upload_file,
                                'name' => $file_name,
                                'tmp_name' => $tmp_name
                            );
                        }
                    }
                }
            }
        } else { #Only one
            # Lấy đường dẫn tạm của ảnh trước khi up lên server
            $tmp_name = $_FILES[$label_field]['tmp_name'];

            # Lấy đường dẫn real của ảnh sau khi up lên server
            $upload_file = $upload_dir . $_FILES[$label_field]['name'];

            # Lấy định dạng ảnh . VD : jpg, png để kiểm tra 
            $file_format = pathinfo($_FILES[$label_field]['name'], PATHINFO_EXTENSION);

            # Lấy tên ảnh và up lên server . VD : hehe, huhu
            $file_name = pathinfo($_FILES[$label_field]['name'], PATHINFO_FILENAME);

            // Kiểm tra
            # Đúng định dạng ảnh
            # Đúng kích thước ảnh
            # Tồn tại ảnh
            if (!in_array(strtolower($file_format), $format)) {
                $string_format = implode(', ', $format);
                $error[$label_field] = "<p class='{$error_class}'>Hệ thống chỉ hỗ trợ file ảnh có định dạng {$string_format}</p>";
            } else {
                if ($_FILES[$label_field]['size'] > $size) {
                    $error[$label_field] = "<p class='{$error_class}'>Hệ thống hỗ trợ file ảnh có kích thước <20MB</p>";
                } else {
                    if (file_exists($upload_file)) {
                        $new_upload_file =  $upload_dir . $file_name . " - Copy." . $file_format;
                        $k = 2;
                        while (file_exists($new_upload_file)) {
                            $new_upload_file =  $upload_dir . $file_name . " - Copy({$k})." . $file_format;
                            $k++;
                        }
                        $data = array(
                            'url' => $new_upload_file,
                            'name' => $file_name,
                            'tmp_name' => $tmp_name
                        );
                    } else {
                        $data = array(
                            'url' => $upload_file,
                            'name' => $file_name,
                            'tmp_name' => $tmp_name
                        );
                    }
                }
            }
        }


        return $data;
    }
}
